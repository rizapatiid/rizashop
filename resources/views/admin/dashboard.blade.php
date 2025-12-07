@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong> — Anda login sebagai <strong>ADMIN</strong>.</p>

    {{-- Contoh link kembali yang aman --}}
    <div class="mt-6">
        <a href="{{ url('/') }}" class="underline">Kembali ke Beranda</a>
    </div>

    {{-- Tambahan: contoh card sederhana --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">Jumlah Pengguna</h3>
            <p class="text-3xl mt-2">{{ \App\Models\User::count() }}</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">Role saat ini</h3>
            <p class="mt-2">{{ auth()->user()->role }}</p>
        </div>
    </div>
</div>
@endsection
