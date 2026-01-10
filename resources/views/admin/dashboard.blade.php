@extends('layouts.nav_masterdashboard')

@section('content')
@php
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

/* ================== DATA ================== */
$user = auth()->user();

$grossRevenue = Order::whereIn('status',['completed','received','diterima'])->sum('total');
$netRevenue = Order::whereIn('status',['completed','received','diterima'])
    ->selectRaw('SUM(total - shipping_cost) as revenue')->value('revenue') ?? 0;

$totalOrders   = Order::count();
$successOrders = Order::whereIn('status',['completed','received','diterima'])->count();
$cancelOrders  = Order::whereIn('status',['cancelled','canceled'])->count();
$totalProducts = Product::count();

$products = Product::orderBy('stock','asc')->take(8)->get();
$customers = User::where('role','user')->latest()->take(8)->get();

/* ================= GRAFIK 7 HARI ================= */
$labels = [];
$totalData = [];
$successData = [];
$cancelData = [];

for ($i = 6; $i >= 0; $i--) {
    $date = Carbon::now()->subDays($i);

    $labels[] = $date->format('d M');

    $totalData[] = Order::whereDate('created_at', $date)->count();
    $successData[] = Order::whereDate('created_at', $date)->whereIn('status', ['completed','received','diterima'])->count();
    $cancelData[] = Order::whereDate('created_at', $date)->whereIn('status', ['cancelled','canceled'])->count();
}
@endphp

<div class="max-w-7xl mx-auto px-6 py-6 space-y-8">

    {{-- ================= WELCOME ================= --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali 👋</h1>
        <p class="text-gray-500 mt-1">{{ $user->name }}</p>
    </div>

    {{-- ================= PENDAPATAN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border rounded-xl p-6 shadow">
            <p class="text-sm text-gray-500">Pendapatan Kotor</p>
            <p class="text-3xl font-bold text-indigo-600 mt-2">Rp {{ number_format($grossRevenue,0,',','.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Total nilai produk terjual</p>
        </div>
        <div class="bg-white border rounded-xl p-6 shadow relative">
            <div class="flex items-center gap-2">
                <p class="text-sm text-gray-500">Pendapatan Bersih</p>
                <button onclick="toggleInfo()" aria-label="Toggle info" class="text-gray-400 hover:text-gray-600">ℹ️</button>
            </div>
            <p class="text-3xl font-bold text-emerald-600 mt-2">Rp {{ number_format($netRevenue,0,',','.') }}</p>
            <div id="infoBox" class="hidden absolute top-14 right-6 bg-white border rounded-lg p-4 text-xs text-gray-600 w-64 shadow">
                Pendapatan bersih adalah total pendapatan setelah dikurangi ongkir pengiriman.
            </div>
        </div>
    </div>

    {{-- ================= STAT OPERASIONAL ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat title="Pesanan Masuk" :value="$totalOrders" color="indigo"/>
        <x-stat title="Pesanan Sukses" :value="$successOrders" color="green"/>
        <x-stat title="Pesanan Dibatalkan" :value="$cancelOrders" color="red"/>
        <x-stat title="Total Produk" :value="$totalProducts" color="gray"/>
    </div>

    {{-- ================= GRAFIK ================= --}}
    <div class="bg-white border rounded-xl p-6 shadow">
        <h3 class="font-semibold mb-4">Grafik Pesanan 7 Hari Terakhir</h3>
        <div class="relative w-full" style="min-height:280px">
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    {{-- ================= LIST DATA ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- PRODUK --}}
        <div class="bg-white border rounded-xl overflow-hidden shadow">
            <div class="px-5 py-4 border-b font-semibold">Produk & Stok</div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-center">Stok</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $status = $product->stock <= 0 ? 'Habis' : ($product->stock <= 5 ? 'Menipis' : 'Aman');
                            $color = $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-yellow-600' : 'text-green-600');
                        @endphp
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-center font-semibold {{ $color }}">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PELANGGAN --}}
        <div class="bg-white border rounded-xl overflow-hidden shadow">
            <div class="px-5 py-4 border-b font-semibold">Pelanggan Terbaru</div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $customer->name }}</td>
                            <td class="px-4 py-3">{{ $customer->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleInfo() {
        const box = document.getElementById('infoBox');
        box.classList.toggle('hidden');
    }

    (function () {
        const el = document.getElementById('orderChart');
        if (!el) return;

        new Chart(el, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Total Pesanan',
                        data: @json($totalData),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.12)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Pesanan Sukses',
                        data: @json($successData),
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34,197,94,0.12)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    },
                    {
                        label: 'Pesanan Dibatalkan',
                        data: @json($cancelData),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.12)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    })();
</script>

@endsection