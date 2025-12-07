@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-red-600 mb-4">Akses Ditolak</h1>
    <p>Anda tidak diperbolehkan mengakses laman ini.</p>
    <p class="mt-4">
        @if(auth()->check())
            Anda login sebagai: <strong>{{ auth()->user()->email }}</strong> (role: <strong>{{ auth()->user()->role }}</strong>)
        @else
            Silakan <a href="{{ route('login') }}">masuk</a> atau <a href="{{ route('register') }}">daftar</a>.
        @endif
    </p>
    <div class="mt-6">
        <a href="{{ url()->previous() ?? route('dashboard') }}" class="underline">Kembali</a>
    </div>
</div>
@endsection
