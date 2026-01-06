<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Get all active categories
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        // Cek apakah ada kategori
        if ($categories->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'Belum ada kategori. Silakan jalankan: php artisan db:seed --class=CategorySeeder');
        }
        
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_type' => 'required|in:physical,digital,service',
            'is_active' => 'nullable',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'variants' => 'nullable|array',
            'variants.*.name' => 'nullable|string',
            'variants.*.values' => 'nullable|string',
            'variants.*.price_modifier' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
        ], [
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.exists' => 'Kategori yang dipilih tidak valid',
            'product_type.required' => 'Jenis produk harus dipilih',
            'product_type.in' => 'Jenis produk tidak valid',
            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'images.required' => 'Minimal 1 gambar harus diupload',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Product
            $product = Product::create([
                'name' => $validated['name'],
                'sku' => $validated['sku'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'stock' => $validated['stock'] ?? 0,
                'category_id' => $validated['category_id'],
                'product_type' => $validated['product_type'],
                'is_active' => 1, // 🔥 PAKSA AKTIF
            ]);

            // 2. Handle Multiple Images Upload
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $uploadedIndex = 0;
                
                foreach ($images as $index => $image) {
                    // Skip jika slot kosong (null)
                    if (!$image) continue;
                    
                    // Generate unique filename
                    $filename = time() . '_' . $uploadedIndex . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store image
                    $path = $image->storeAs('products', $filename, 'public');
                    
                    // Save to database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $uploadedIndex,
                        'is_primary' => $uploadedIndex === 0, // First uploaded image is primary
                    ]);

                    // Set first image as product main image (backward compatibility)
                    if ($uploadedIndex === 0) {
                        $product->update(['image_path' => $path]);
                    }
                    
                    $uploadedIndex++;
                }
            }

            // 3. Handle Product Variants
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variantData) {
                    // Skip if empty
                    if (empty($variantData['name']) || empty($variantData['values'])) {
                        continue;
                    }

                    // Split values by comma
                    $values = array_map('trim', explode(',', $variantData['values']));
                    
                    // Create variant for each value
                    foreach ($values as $value) {
                        if (empty($value)) continue;
                        
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_name' => $variantData['name'],
                            'variant_value' => $value,
                            'price_modifier' => $variantData['price_modifier'] ?? 0,
                            'stock' => $variantData['stock'] ?? 0,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded images if error occurs
            if (isset($product) && $product->images) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'variants']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $product->load(['images', 'variants']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_type' => 'required|in:physical,digital,service',
            'new_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'delete_images.*' => 'nullable|exists:product_images,id',
            'variants' => 'nullable|array',
            'variants.*.name' => 'nullable|string',
            'variants.*.values' => 'nullable|string',
            'variants.*.price_modifier' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1️⃣ Update produk
            $product->update([
                'name' => $validated['name'],
                'sku' => $validated['sku'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'stock' => $validated['stock'] ?? 0,
                'category_id' => $validated['category_id'],
                'product_type' => $validated['product_type'],
                'is_active' => 1, // 🔥 PAKSA AKTIF
            ]);

            // 2️⃣ HAPUS gambar yang ditandai untuk dihapus
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id == $product->id) {
                        // Hapus file dari storage
                        Storage::disk('public')->delete($image->image_path);
                        // Hapus dari database
                        $image->delete();
                    }
                }
            }

            // 3️⃣ UPLOAD gambar baru per slot
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $slotNumber => $image) {
                    if (!$image) continue;
                    
                    // Generate filename
                    $filename = time() . '_slot' . $slotNumber . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store image
                    $path = $image->storeAs('products', $filename, 'public');
                    
                    // Hitung sort_order berdasarkan jumlah gambar yang ada
                    $currentCount = $product->images()->count();
                    
                    // Save to database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $currentCount,
                        'is_primary' => $currentCount === 0, // Jika ini gambar pertama
                    ]);
                }
            }

            // 4️⃣ Update primary image di tabel products (backward compatibility)
            $firstImage = $product->images()->orderBy('sort_order')->first();
            if ($firstImage) {
                $product->update(['image_path' => $firstImage->image_path]);
            }

            // 5️⃣ Reindex sort_order agar berurutan 0,1,2,3,4
            $images = $product->images()->orderBy('sort_order')->get();
            foreach ($images as $index => $img) {
                $img->update([
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }

            // 6️⃣ Validasi minimal 1 gambar
            if ($product->images()->count() === 0) {
                throw new \Exception('Produk harus memiliki minimal 1 gambar!');
            }

            // 7️⃣ HAPUS SEMUA VARIAN LAMA
            $product->variants()->delete();

            // 8️⃣ INSERT ULANG VARIAN DARI FORM
            if ($request->filled('variants')) {
                foreach ($request->variants as $variant) {
                    if (empty($variant['name']) || empty($variant['values'])) {
                        continue;
                    }

                    $values = array_map('trim', explode(',', $variant['values']));

                    foreach ($values as $value) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_name' => $variant['name'],
                            'variant_value' => $value,
                            'price_modifier' => $variant['price_modifier'] ?? 0,
                            'stock' => $variant['stock'] ?? 0,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Delete main image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Delete product (cascades to images and variants)
            $product->delete();

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}