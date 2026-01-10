@extends('layouts.nav_masterdashboard')

@section('title','Pendapatan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

<style>
:root{
    --primary:#3b82f6;
    --success:#16a34a;
    --danger:#dc2626;
    --muted:#6b7280;
    --border:#e5e7eb;
    --bg:#f9fafb;
}

.card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:14px;
    padding:20px;
}

.stat{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.stat h4{
    font-size:13px;
    color:var(--muted);
    margin-bottom:4px;
}

.stat .value{
    font-size:20px;
    font-weight:800;
}

.net{
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    border:1px solid #bfdbfe;
}

.table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

.table th{
    background:var(--bg);
    padding:12px;
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
    text-align:left;
}

.table td{
    padding:12px;
    border-bottom:1px solid #f1f5f9;
}

@media(max-width:768px){
    .table-wrap::after{
        content:"Geser →";
        display:block;
        text-align:right;
        font-size:12px;
        color:#9ca3af;
        padding:6px;
    }
}
</style>

{{-- HEADER --}}
<div class="mb-6">
    <h1 class="text-2xl font-extrabold">Pendapatan</h1>
    <p class="text-sm text-gray-500">Ringkasan pendapatan toko Anda</p>
</div>

{{-- FILTER --}}
<form class="flex gap-3 mb-6 flex-wrap">
<input type="date"
       name="start"
       value="{{ $start->format('Y-m-d') }}"
       class="border rounded-lg px-3 py-2 text-sm">

<input type="date"
       name="end"
       value="{{ $end->format('Y-m-d') }}"
       class="border rounded-lg px-3 py-2 text-sm">

    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">
        Terapkan
    </button>
</form>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

    <div class="card stat">
        <div>
            <h4>Total Penjualan</h4>
            <div class="value">Rp {{ number_format($totalGrossSales,0,',','.') }}</div>
        </div>
    </div>

    <div class="card stat">
        <div>
            <h4>Diskon</h4>
            <div class="value text-red-600">- Rp {{ number_format($totalDiscount,0,',','.') }}</div>
        </div>
    </div>

    <div class="card stat">
        <div>
            <h4>Biaya Admin</h4>
            <div class="value text-red-600">- Rp {{ number_format($totalAdmin,0,',','.') }}</div>
        </div>
    </div>

    <div class="card stat">
        <div>
            <h4>Pengiriman</h4>
            <div class="value text-red-600">- Rp {{ number_format($totalShipping,0,',','.') }}</div>
        </div>
    </div>

    <div class="card stat net">
        <div>
            <h4>Pendapatan Bersih</h4>
            <div class="value text-green-700">
                Rp {{ number_format($netRevenue,0,',','.') }}
            </div>
        </div>
    </div>

</div>

{{-- TABLE --}}
<div class="card table-wrap">
<table class="table">
<thead>
<tr>
    <th>Order</th>
    <th>Tanggal</th>
    <th>Subtotal</th>
    <th>Diskon</th>
    <th>Admin</th>
    <th>Ongkir</th>
    <th>Bersih</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
    <td>{{ $order->order_number }}</td>
    <td>{{ $order->created_at->format('d M Y') }}</td>

    <td>Rp {{ number_format(
        $order->subtotal + ($order->shipping_cost ?? 0),
    0,',','.') }}</td>

    <td>- Rp {{ number_format($order->discount ?? 0,0,',','.') }}</td>

    <td>- Rp {{ number_format($order->admin_fee ?? 0,0,',','.') }}</td>

    <td>- Rp {{ number_format($order->shipping_cost ?? 0,0,',','.') }}</td>

    <td class="text-green font-bold">
        Rp {{ number_format(
            $order->subtotal
            - ($order->discount ?? 0)
            - ($order->admin_fee ?? 0),
        0,',','.') }}
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>
@endsection
