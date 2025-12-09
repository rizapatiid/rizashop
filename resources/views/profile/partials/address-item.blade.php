{{-- resources/views/profile/partials/address-item.blade.php --}}
<div class="border border-slate-200 rounded-lg p-4 bg-white relative">

    {{-- BADGE ALAMAT UTAMA (warna sesuai UI — sky blue) --}}
    @if($address->is_primary)
        <span class="px-2.5 py-1 text-xs rounded-md bg-orange-500 text-white absolute top-3 right-3 flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
    </svg>
    Utama
</span>
    @endif

    {{-- LABEL ALAMAT --}}
    <p class="font-semibold text-slate-800">
        {{ $address->label ?? 'Alamat' }}
    </p>

    {{-- DATA PENERIMA --}}
    <p class="mt-1 text-sm text-slate-700 font-medium">
        {{ $address->recipient_name ?? Auth::user()->name }}
        <span class="text-slate-500">
            — {{ $address->phone_country }} {{ $address->phone }}
        </span>
    </p>

    {{-- ALAMAT LENGKAP STYLE MARKETPLACE --}}
    <p class="text-sm text-slate-600 leading-relaxed mt-1">
        {{ $address->address_full }} <br>

        @if($address->village)
            Kel. {{ $address->village }} • 
        @endif

        @if($address->subdistrict)
            Kec. {{ $address->subdistrict }} • 
        @endif

        @if($address->city)
            {{ $address->city }} • 
        @endif

        @if($address->province)
            {{ $address->province }} • 
        @endif

        @if($address->postal_code)
            {{ $address->postal_code }} • 
        @endif

        {{ $address->country }}
    </p>

    {{-- TOMBOL AKSI --}}
    <div class="flex items-center gap-4 text-sm mt-4">

        {{-- Edit --}}
        <button
            type="button"
            onclick="openAddressEdit({{ $address->id }})"
            class="flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 hover:border-sky-400 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M15.232 5.232l3.536 3.536M4 20h4.768L19.768 9.232a2.5 2.5 0 00-3.536-3.536L5.232 16.464 4 20z"/>
            </svg>
            Ubah
        </button>


        {{-- Hapus --}}
        @if(!$address->is_primary)
            <button
                type="button"
                onclick="openAddressDelete({{ $address->id }})"
                class="flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md border border-red-300 text-red-600 bg-red-50 hover:bg-red-100 hover:border-red-400 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                </svg>
                Hapus
            </button>
        @endif

        {{-- Jadikan Utama --}}
        @if(!$address->is_primary)
            <form method="POST" action="{{ route('addresses.setPrimary', $address->id) }}">
                @csrf
                @method('PATCH')   {{-- <- tambah ini --}}
                <button class="flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md border border-orange-300 text-orange-700 bg-orange-50 hover:bg-orange-100 hover:border-orange-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    Jadikan Utama
                </button>
            </form>
        @endif

        

    </div>

</div>
