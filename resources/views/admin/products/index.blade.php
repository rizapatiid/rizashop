@extends('layouts.nav_masterdashboard')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

* {
  font-family: 'Inter', sans-serif;
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}

.stat-box {
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  padding: 24px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.stat-box:hover {
  border-color: #3b82f6;
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(59, 130, 246, 0.15);
}

.stat-value {
  font-size: 36px;
  font-weight: 900;
  color: #0f172a;
  margin-bottom: 8px;
  line-height: 1;
}

.stat-label {
  font-size: 13px;
  color: #64748b;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  display: flex;
  align-items: center;
  gap: 6px;
}

.stat-icon {
  font-size: 28px;
  opacity: 0.9;
}

/* Toolbar */
.toolbar {
  background: white;
  border-radius: 20px;
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.search-wrapper {
  flex: 1;
  min-width: 300px;
  max-width: 500px;
  position: relative;
}

.search-input {
  width: 100%;
  padding: 14px 20px 14px 48px;
  border: 2px solid #e2e8f0;
  border-radius: 14px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  background: #f8fafc;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  background: white;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.search-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 18px;
}

.toolbar-actions {
  display: flex;
  gap: 12px;
  align-items: center;
}

.filter-btn, .export-btn {
  padding: 12px 20px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  border: 2px solid #e2e8f0;
  background: white;
  color: #475569;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-btn:hover, .export-btn:hover {
  border-color: #3b82f6;
  color: #3b82f6;
  background: #eff6ff;
}

/* Products Grid */
.products-container {
  background: white;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
  overflow: hidden;
}

.products-header {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  padding: 20px 28px;
  border-bottom: 2px solid #e2e8f0;
  display: grid;
  grid-template-columns: 60px 2fr 1fr 100px 100px 120px 120px;
  gap: 16px;
  align-items: center;
}

.header-cell {
  font-size: 12px;
  font-weight: 800;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.product-row {
  display: grid;
  grid-template-columns: 60px 2fr 1fr 100px 100px 120px 120px;
  gap: 16px;
  align-items: center;
  padding: 24px 28px;
  border-bottom: 1px solid #f1f5f9;
  transition: all 0.3s ease;
}

.product-row:hover {
  background: linear-gradient(90deg, #f8fafc 0%, white 100%);
  border-left: 4px solid #3b82f6;
  padding-left: 24px;
}

.product-row:last-child {
  border-bottom: none;
}

.product-number {
  font-size: 14px;
  font-weight: 700;
  color: #94a3b8;
}

.product-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.product-image {
  width: 64px;
  height: 64px;
  border-radius: 14px;
  object-fit: cover;
  border: 2px solid #e2e8f0;
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.product-row:hover .product-image {
  border-color: #3b82f6;
  transform: scale(1.05);
  box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
}

.product-image-placeholder {
  width: 64px;
  height: 64px;
  border-radius: 14px;
  background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #94a3b8;
  font-size: 28px;
  border: 2px solid #e2e8f0;
  flex-shrink: 0;
}

.product-details {
  flex: 1;
  min-width: 0;
}

.product-name {
  font-weight: 700;
  color: #0f172a;
  font-size: 15px;
  margin-bottom: 4px;
  line-height: 1.4;
}

.product-sku {
  font-size: 12px;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 4px;
  font-weight: 500;
}

.product-price {
  font-weight: 800;
  color: #0f172a;
  font-size: 17px;
}

.product-sold {
  font-weight: 700;
  color: #3b82f6;
  font-size: 18px;
}

.product-stock {
  font-weight: 700;
  color: #0f172a;
  font-size: 18px;
}

.stock-warning {
  font-weight: 700;
  color: #f59e0b;
  font-size: 16px;
}

.stock-empty {
  font-weight: 700;
  color: #ef4444;
  font-size: 16px;
}

/* Status Badge */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.badge-active {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  color: #065f46;
  border: 2px solid #059669;
}

.badge-inactive {
  background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
  color: #475569;
  border: 2px solid #94a3b8;
}

.status-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
}

.action-btn {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 16px;
}

.edit-btn {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  color: #3b82f6;
}

.edit-btn:hover {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
}

.delete-btn {
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  color: #ef4444;
}

.delete-btn:hover {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
  padding: 80px 40px;
  text-align: center;
}

.empty-icon {
  font-size: 80px;
  margin-bottom: 24px;
  opacity: 0.6;
}

.empty-title {
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 8px;
}

.empty-text {
  color: #64748b;
  font-size: 16px;
  font-weight: 500;
  margin-bottom: 24px;
}

.empty-btn {
  padding: 14px 28px;
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.empty-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px rgba(59, 130, 246, 0.3);
}

/* Pagination */
.pagination-wrapper {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  padding: 24px 28px;
  border-top: 2px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.pagination-info {
  font-size: 14px;
  color: #64748b;
  font-weight: 600;
}

/* Success Alert */
.success-alert {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  border: 2px solid #059669;
  border-radius: 16px;
  padding: 18px 24px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

.success-icon {
  width: 44px;
  height: 44px;
  background: #059669;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 20px;
  flex-shrink: 0;
}

.success-message {
  color: #065f46;
  font-weight: 700;
  font-size: 15px;
}

/* Delete Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(8px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-content {
  background: white;
  border-radius: 24px;
  width: 100%;
  max-width: 480px;
  padding: 40px;
  box-shadow: 0 24px 48px rgba(0, 0, 0, 0.2);
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 24px;
}

.modal-icon {
  width: 64px;
  height: 64px;
  border-radius: 16px;
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #dc2626;
  font-size: 32px;
  flex-shrink: 0;
}

.modal-title {
  font-size: 24px;
  font-weight: 900;
  color: #0f172a;
}

.modal-message {
  font-size: 15px;
  color: #64748b;
  line-height: 1.6;
  margin-bottom: 32px;
}

.modal-product-name {
  font-weight: 800;
  color: #0f172a;
}

.modal-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
}

.modal-btn {
  padding: 14px 28px;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

.cancel-btn {
  background: #f1f5f9;
  color: #475569;
}

.cancel-btn:hover {
  background: #e2e8f0;
}

.confirm-delete-btn {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: white;
}

.confirm-delete-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
  .products-header,
  .product-row {
    grid-template-columns: 50px 2fr 1fr 80px 80px 100px 100px;
    gap: 12px;
  }
}

@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .toolbar {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-wrapper {
    max-width: 100%;
  }
  
  .toolbar-actions {
    width: 100%;
    justify-content: stretch;
  }
  
  .filter-btn, .export-btn {
    flex: 1;
    justify-content: center;
  }
  
  .products-header {
    display: none;
  }
  
  .product-row {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 16px;
    padding: 20px;
  }
  
  .product-info {
    width: 100%;
  }
  
  .action-buttons {
    justify-content: flex-start;
  }
}
</style>

<!-- Stats Grid -->
@php
  $totalProducts = $products->total() ?? 0;
  $activeProducts = $products->where('is_active', true)->count();
  $inactiveProducts = $products->where('is_active', false)->count();
  $outOfStock = $products->where('stock', 0)->count();
  $totalSold = $products->sum(fn($p) => $p->sold ?? 0);
@endphp

<div class="stats-grid">
  <div class="stat-box">
    <div class="stat-value">{{ $totalProducts }}</div>
    <div class="stat-label">
      <span class="stat-icon">📦</span>
      Total Produk
    </div>
  </div>
  
  <div class="stat-box">
    <div class="stat-value">{{ $activeProducts }}</div>
    <div class="stat-label">
      <span class="stat-icon">✅</span>
      Aktif
    </div>
  </div>
  
  <div class="stat-box">
    <div class="stat-value">{{ $inactiveProducts }}</div>
    <div class="stat-label">
      <span class="stat-icon">⏸️</span>
      Nonaktif
    </div>
  </div>
  
  <div class="stat-box">
    <div class="stat-value">{{ $outOfStock }}</div>
    <div class="stat-label">
      <span class="stat-icon">⚠️</span>
      Stok Habis
    </div>
  </div>
</div>

<!-- Success Alert -->
@if(session('success'))
<div class="success-alert">
  <div class="success-icon">
    <i class="fas fa-check"></i>
  </div>
  <div class="success-message">{{ session('success') }}</div>
</div>
@endif

<!-- Toolbar -->
<div class="toolbar">
  <div class="search-wrapper">
    <i class="fas fa-search search-icon"></i>
    <input type="text" class="search-input" placeholder="Cari produk berdasarkan nama atau SKU...">
  </div>
  
  <div class="toolbar-actions">
    <button class="filter-btn">
      <i class="fas fa-filter"></i>
      Filter
    </button>
    <button class="export-btn">
      <i class="fas fa-download"></i>
      Export
    </button>
  </div>
</div>

@if($products->count() === 0)
<!-- Empty State -->
<div class="products-container">
  <div class="empty-state">
    <div class="empty-icon">📦</div>
    <div class="empty-title">Belum Ada Produk</div>
    <div class="empty-text">Mulai tambahkan produk pertama Anda untuk memulai penjualan</div>
    <a href="{{ route('admin.products.create') }}" class="empty-btn">
      <i class="fas fa-plus"></i>
      Tambah Produk Pertama
    </a>
  </div>
</div>
@else
<!-- Products Grid -->
<div class="products-container">
  <!-- Header -->
  <div class="products-header">
    <div class="header-cell">#</div>
    <div class="header-cell">Produk</div>
    <div class="header-cell">Harga</div>
    <div class="header-cell">Terjual</div>
    <div class="header-cell">Stok</div>
    <div class="header-cell">Status</div>
    <div class="header-cell" style="text-align: right;">Aksi</div>
  </div>
  
  <!-- Products List -->
  @foreach($products as $product)
  <div class="product-row">
    <div class="product-number">
      {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
    </div>
    
    <div class="product-info">
      @if($product->image_path)
        <img src="{{ asset('storage/'.$product->image_path) }}" 
             class="product-image" 
             alt="{{ $product->name }}">
      @else
        <div class="product-image-placeholder">
          📷
        </div>
      @endif
      
      <div class="product-details">
        <div class="product-name">{{ $product->name }}</div>
        @if($product->sku)
          <div class="product-sku">
            <i class="fas fa-tag"></i>
            {{ $product->sku }}
          </div>
        @endif
      </div>
    </div>
    
    <div class="product-price">
      Rp {{ number_format($product->price, 0, ',', '.') }}
    </div>
    
    <div class="product-sold">
      {{ $product->sold ?? 0 }}
    </div>
    
    <div>
      @if($product->stock > 10)
        <div class="product-stock">{{ $product->stock }}</div>
      @elseif($product->stock > 0)
        <div class="stock-warning">{{ $product->stock }}</div>
      @else
        <div class="stock-empty">Habis</div>
      @endif
    </div>
    
    <div>
      <span class="status-badge {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
        <span class="status-dot"></span>
        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
      </span>
    </div>
    
    <div class="action-buttons">
      <a href="{{ route('admin.products.edit', $product->id) }}" 
         class="action-btn edit-btn"
         title="Edit Produk">
        <i class="fas fa-edit"></i>
      </a>
      <button onclick="openDeleteModal('{{ route('admin.products.destroy', $product->id) }}', '{{ $product->name }}')" 
              class="action-btn delete-btn"
              title="Hapus Produk">
        <i class="fas fa-trash"></i>
      </button>
    </div>
  </div>
  @endforeach
  
  <!-- Pagination -->
  <div class="pagination-wrapper">
    <div class="pagination-info">
      Menampilkan <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
    </div>
    <div>
      {{ $products->links() }}
    </div>
  </div>
</div>
@endif

<!-- Delete Modal -->
<div id="deleteModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <div class="modal-icon">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="modal-title">Hapus Produk?</div>
    </div>
    
    <div class="modal-message">
      Anda yakin ingin menghapus produk 
      <span id="productName" class="modal-product-name"></span>? 
      Tindakan ini tidak dapat dibatalkan dan semua data terkait akan hilang permanen.
    </div>
    
    <div class="modal-actions">
      <button onclick="closeDeleteModal()" class="modal-btn cancel-btn">
        Batal
      </button>
      <form id="deleteForm" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="modal-btn confirm-delete-btn">
          <i class="fas fa-trash"></i> Hapus Produk
        </button>
      </form>
    </div>
  </div>
</div>

<script>
function openDeleteModal(action, name) {
  document.getElementById('deleteForm').action = action;
  document.getElementById('productName').textContent = name;
  document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeDeleteModal();
  }
});

// Keyboard support
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeDeleteModal();
  }
});

// Search functionality (placeholder)
document.querySelector('.search-input').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  // Add your search logic here
  console.log('Searching for:', searchTerm);
});
</script>

@endsection