@extends('layouts.nav_masterdashboard')
@section('title', 'Lihat Pesanan')
@section('page-title', 'Lihat Pesanan')


@section('content')
<div class="container mx-auto p-6 max-w-5xl" id="admin-order-show">
  <style>
    :root{
      --muted:#6b7280; --border:#e6eef6; --accent:#0ea5e9; --danger:#ef4444; --success:#10b981;
      --card:#ffffff;
    }
    .card { background:var(--card); border:1px solid var(--border); border-radius:12px; padding:16px; box-shadow:0 8px 24px rgba(2,6,23,0.04); }
    .grid-2 { display:grid; grid-template-columns:1fr 360px; gap:16px; }
    @media(max-width:1024px){ .grid-2 { grid-template-columns:1fr; } }
    .muted{ color:var(--muted); font-size:14px; }
    .btn { padding:10px 14px; border-radius:10px; border:0; background:var(--accent); color:#fff; font-weight:800; cursor:pointer; display:inline-flex; gap:8px; align-items:center; }
    .btn-ghost{ padding:8px 12px; border-radius:10px; background:#fff; border:1px solid var(--border); color:#0f172a; font-weight:700; text-decoration:none; display:inline-flex; gap:8px; }
    .btn-danger{ background:var(--danger); color:#fff; }
    .btn-success{ background:var(--success); color:#fff; }
    .small{ font-size:13px; color:var(--muted); }
    label{ font-weight:700; display:block; margin-bottom:6px; }
    input[type="text"], textarea, select { width:100%; padding:9px 10px; border-radius:8px; border:1px solid var(--border); }
    .actions { display:flex; justify-content:space-between; gap:12px; align-items:center; margin-top:12px; flex-wrap:wrap; }
    .badge { display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px; font-weight:800; color:#fff; gap:8px; font-size:13px; }
    .b-pending{ background:#f59e0b; } .b-wait{ background:#f97316; } .b-processing{ background:#6366f1; } .b-shipped{ background:#06b6d4; } .b-completed{ background:#10b981; } .b-cancel{ background:#ef4444; }
    /* adopt your icon sizes/classes */
    .icon{ width:20px; height:20px; display:block; }
    .icon-sm{ width:14px; height:14px; display:block; }
    /* modal */
    .modal-backdrop{ position:fixed; inset:0; background:rgba(2,6,23,0.5); z-index:1200; display:flex; align-items:center; justify-content:center; }
    .modal { background:#fff; border-radius:10px; width:720px; max-width:94%; padding:16px; box-shadow:0 20px 60px rgba(2,6,23,0.35); z-index:1201; }
    .modal .modal-header{ display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
    .modal .modal-body{ max-height:60vh; overflow:auto; }
    .modal .modal-actions{ display:flex; gap:8px; justify-content:flex-end; margin-top:12px; }
    .hidden{ display:none; }
    .img-proof { width:100%; max-height:60vh; object-fit:contain; border:1px solid var(--border); border-radius:8px; background:#fafafa; }
  </style>

  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
    <div>
      <h2 style="font-weight:900;">Detail Pesanan</h2>
      <div class="muted">Order: <strong>{{ $order->order_number ?: '#'.$order->id }}</strong></div>
      <div class="small" style="margin-top:6px;">Dibuat: {{ $order->created_at->format('d M Y, H:i') }}</div>
    </div>
    <div style="display:flex;gap:12px;align-items:center;">
      <a href="{{ route('admin.orders.index') }}" class="btn-ghost">Kembali</a>
      {{-- Satu tombol dinamis sesuai status --}}
      @php
        // determine label + state
        $st = $order->status;
        $btn = ['label'=>'','class'=>'btn','disabled'=>false,'action'=>null];
        if (in_array($st, ['pending','waiting_payment'])) {
          $btn['label'] = 'Konfirmasi Pembayaran';
          $btn['class'] = 'btn btn-ghost';
          $btn['disabled'] = true;
        } elseif ($st === 'waiting_confirm') {
          $btn['label'] = 'Konfirmasi Pembayaran';
          $btn['class'] = 'btn';
          $btn['disabled'] = false;
          $btn['action'] = 'openProofModal';
        } elseif (in_array($st, ['processing'])) {
          $btn['label'] = 'Kirimkan Pesanan';
          $btn['class'] = 'btn';
          $btn['disabled'] = false;
          $btn['action'] = 'openTrackingModal';
        } elseif (in_array($st, ['shipped'])) {
          $btn['label'] = 'Kirimkan Catatan';
          $btn['class'] = 'btn btn-ghost';
          $btn['disabled'] = false;
          $btn['action'] = 'openNoteModal';
        } elseif ($st === 'completed') {
          $btn['label'] = 'Pesanan Selesai';
          $btn['class'] = 'btn btn-success';
          $btn['disabled'] = true;
        } elseif ($st === 'cancelled') {
          $btn['label'] = 'Pesanan Dibatalkan';
          $btn['class'] = 'btn btn-danger';
          $btn['disabled'] = true;
        } else {
          $btn['label'] = 'Aksi';
          $btn['class'] = 'btn';
          $btn['disabled'] = true;
        }
      @endphp

      <button id="dynamicActionBtn"
        class="{{ $btn['class'] }}"
        @if($btn['disabled']) disabled aria-disabled="true" title="Tombol tidak aktif pada status ini" @endif
        data-action="{{ $btn['action'] ?? '' }}">
        {{ $btn['label'] }}
      </button>
    </div>
  </div>

  <div class="grid-2">
    <div>
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
          <div>
            <div style="font-weight:900;font-size:16px;">Informasi Pembeli</div>
            <div class="small" style="margin-top:6px;">{{ $order->user?->name ?? '—' }} · {{ $order->user?->email ?? '—' }}</div>
            <div class="small" style="margin-top:6px;">No. Pesanan: <strong>{{ $order->order_number ?: '#'.$order->id }}</strong></div>
          </div>
          <div style="text-align:right;">
            @php
              $labelMap = [
                'pending'=>'Pesanan Masuk',
                'waiting_payment'=>'Menunggu Pembayaran',
                'waiting_confirm'=>'Konfirmasi Pembayaran',
                'processing'=>'Pesanan Diproses',
                'shipped'=>'Pesanan Dikirimkan',
                'completed'=>'Pesanan Diterima',
                'cancelled'=>'Pesanan Dibatalkan'
              ];
              $badgeMap = [
                'pending'=>'b-pending','waiting_payment'=>'b-wait','waiting_confirm'=>'b-wait','processing'=>'b-processing',
                'shipped'=>'b-shipped','completed'=>'b-completed','cancelled'=>'b-cancel'
              ];

              // Use the same SVGs and classes as in your provided code
              $iconMap = [
                'pending' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
                'waiting_payment' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
                'waiting_confirm' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h11"/><path d="M17 2v4"/></svg>',
                'processing' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>',
                'shipped' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6a1 1 0 0 1-1 1h-1"/><path d="M16 3v4"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>',
                'completed' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
                'cancelled' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
              ];
            @endphp

            <div class="badge {{ $badgeMap[$order->status] ?? 'b-pending' }}" role="status" aria-label="Status pesanan: {{ $labelMap[$order->status] ?? ucfirst($order->status) }}" title="{{ $labelMap[$order->status] ?? ucfirst($order->status) }}">
              {!! $iconMap[$order->status] ?? $iconMap['pending'] !!}
              <span>{{ $labelMap[$order->status] ?? ucfirst($order->status) }}</span>
            </div>
            <div class="small" style="margin-top:6px;">Terakhir: {{ $order->updated_at ? $order->updated_at->format('d M Y, H:i') : '-' }}</div>
          </div>
        </div>

        <hr style="margin:12px 0;border:none;border-top:1px solid var(--border)">

        <div>
          <div style="font-weight:800;">Alamat Pengiriman</div>
          <div class="muted" style="margin-top:8px; white-space:pre-line;">
            @if($order->address)
              {!! e($order->address->address_full) !!}{{ $order->address->village ? ', '.$order->address->village : '' }}{{ $order->address->city ? ', '.$order->address->city : '' }}
              <div style="margin-top:8px;"><strong>Penerima:</strong> {{ $order->address->recipient_name }} · {{ trim(($order->address->phone_country??'').' '.($order->address->phone??'')) }}</div>
            @else
              <div class="small">Tidak ada alamat pada pesanan ini.</div>
            @endif
          </div>
        </div>
      </div>

      <div class="card" style="margin-top:12px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <div style="font-weight:900;">Items ({{ count($order->items) }})</div>
          <div class="small">Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}</div>
        </div>

        <div style="margin-top:12px; display:flex;flex-direction:column;gap:10px;">
          @foreach($order->items as $it)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;border:1px solid #f3f6fb;border-radius:10px;background:#fff;">
              <div>
                <div style="font-weight:800;">{{ $it->product_name }}</div>
                <div class="small">Qty: {{ $it->qty }} · Rp {{ number_format($it->price,0,',','.') }} /pcs</div>
              </div>
              <div style="text-align:right;">
                <div style="font-weight:900;">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
                <div class="small">Subtotal</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="card" style="margin-top:12px;">
        <div style="font-weight:900;">Pembayaran</div>

        @if($order->payment)
          <div style="margin-top:8px;">
            <div><strong>Status pembayaran:</strong> {{ $order->payment->status }}</div>
            <div class="small" style="margin-top:6px;"><strong>Metode:</strong> {{ $order->payment->method ?? '-' }}</div>
            @if($order->payment->proof_path)
              <div style="margin-top:8px;">
                <a href="{{ asset(ltrim($order->payment->proof_path,'/')) }}" target="_blank" class="btn-ghost">Buka Bukti (tab baru)</a>
              </div>
            @endif
          </div>
        @else
          <div class="small" style="margin-top:8px;">Belum ada bukti pembayaran.</div>
        @endif
      </div>

    </div>

    <aside>
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <div style="font-weight:900;">Ringkasan Pembayaran</div>
          <div class="small">Order ID: {{ $order->id }}</div>
        </div>

        <div style="margin-top:10px;">
          <div class="small">Subtotal</div><div style="font-weight:800;">Rp {{ number_format($order->subtotal,0,',','.') }}</div>
          <div class="small" style="margin-top:8px;">Ongkir</div><div style="font-weight:800;">Rp {{ number_format($order->shipping_cost,0,',','.') }}</div>
          <hr style="margin:12px 0;border:none;border-top:1px solid var(--border)">
          <div class="small">Total</div><div style="font-weight:900;font-size:18px;">Rp {{ number_format($order->total,0,',','.') }}</div>
        </div>

        <div style="margin-top:12px;">
          <div class="muted" style="margin-bottom:6px;">Tindakan cepat</div>

          {{-- If waiting_confirm: quick approve/reject shown below modal too --}}
          @if($order->status === 'waiting_confirm')
            <div style="display:flex;gap:8px;">
              <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                @csrf
                <input type="hidden" name="action" value="approve_payment">
                <button class="btn btn-success" type="submit">Setujui Pembayaran</button>
              </form>

              <button class="btn btn-danger" id="quickRejectBtn">Tolak Pembayaran</button>
            </div>
          @endif

          {{-- If processing: quick open tracking modal --}}
          @if($order->status === 'processing')
            <div style="margin-top:8px;">
              <button class="btn" id="quickTrackingBtn">Isi No. Resi & Kirim</button>
            </div>
          @endif

          {{-- If shipped: show courier & tracking --}}
          @if($order->status === 'shipped' || $order->tracking_number)
            <div style="margin-top:10px;">
              <div class="small">Kurir: <strong>{{ $order->shipping_courier ?? $order->courier ?? '-' }}</strong></div>
              <div class="small" style="margin-top:6px;">Resi: <strong>{{ $order->tracking_number ?? '-' }}</strong></div>
            </div>
          @endif
        </div>
      </div>
    </aside>

  </div>

  {{-- flash messages --}}
  @if(session('success'))
    <div style="margin-top:12px;" class="card"><div style="color:#064e3b;font-weight:800;">{{ session('success') }}</div></div>
  @endif
  @if(session('error'))
    <div style="margin-top:12px;" class="card"><div style="color:#7f1d1d;font-weight:800;">{{ session('error') }}</div></div>
  @endif

  {{-- MODALS --}}
  {{-- 1) Proof Modal (Konfirmasi Pembayaran) --}}
  <div id="proofModal" class="hidden" aria-hidden="true">
    <div class="modal-backdrop" role="dialog" aria-modal="true">
      <div class="modal" role="document">
        <div class="modal-header">
          <div style="font-weight:900;">Konfirmasi Pembayaran — Bukti</div>
          <button class="btn-ghost" onclick="closeModal('proofModal')" aria-label="Tutup">X</button>
        </div>
        <div class="modal-body">
          @if($order->payment && $order->payment->proof_path)
            <img src="{{ asset(ltrim($order->payment->proof_path,'/')) }}" alt="Bukti Pembayaran" class="img-proof" />
            <div style="margin-top:10px;" class="small">Jumlah: Rp {{ number_format($order->payment->amount ?? 0,0,',','.') }} · Metode: {{ $order->payment->method ?? '-' }}</div>
          @else
            <div class="small">Tidak ada bukti pembayaran.</div>
          @endif

          <hr style="margin:12px 0;border:none;border-top:1px solid var(--border)">

          {{-- Approve / Reject forms --}}
          <div style="display:flex;gap:8px;flex-direction:column;">
            <form id="approveForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
              @csrf
              <input type="hidden" name="action" value="approve_payment">
              <button class="btn btn-success" type="submit">Setujui Pembayaran</button>
            </form>

            <form id="rejectForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
              @csrf
              <input type="hidden" name="action" value="reject_payment">
              <label for="reject_note">Catatan (opsional, beri alasan penolakan)</label>
              <textarea name="note" id="reject_note" rows="3" placeholder="Contoh: Bukti tidak jelas atau nominal tidak sesuai"></textarea>
              <div style="display:flex;gap:8px;margin-top:8px;">
                <button class="btn btn-danger" type="submit" onclick="return confirm('Tolak bukti pembayaran?')">Tolak Pembayaran</button>
                <button class="btn-ghost" type="button" onclick="closeModal('proofModal')">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 2) Tracking Modal (Kirimkan Pesanan) --}}
  <div id="trackingModal" class="hidden" aria-hidden="true">
    <div class="modal-backdrop" role="dialog" aria-modal="true">
      <div class="modal" role="document">
        <div class="modal-header">
          <div style="font-weight:900;">Kirimkan Pesanan — Input Resi</div>
          <button class="btn-ghost" onclick="closeModal('trackingModal')" aria-label="Tutup">X</button>
        </div>
        <div class="modal-body">
          <form id="trackingForm" method="POST" action="{{ route('admin.orders.setTracking', $order->id) }}">
            @csrf
            <label for="modal_courier">Kurir</label>
            <input type="text" name="courier" id="modal_courier" value="{{ $order->shipping_courier ?? $order->courier ?? '' }}" placeholder="Contoh: JNE / J&T">

            <label for="modal_tracking" style="margin-top:8px;">Nomor Resi</label>
            <input type="text" name="tracking_number" id="modal_tracking" value="{{ $order->tracking_number ?? '' }}" placeholder="Masukkan nomor resi">

            <div class="modal-actions">
              <button class="btn" type="submit">Simpan & Kirim</button>
              <button class="btn-ghost" type="button" onclick="closeModal('trackingModal')">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- 3) Note Modal (Kirimkan Catatan saat shipped) --}}
  <div id="noteModal" class="hidden" aria-hidden="true">
    <div class="modal-backdrop" role="dialog" aria-modal="true">
      <div class="modal" role="document">
        <div class="modal-header">
          <div style="font-weight:900;">Kirimkan Catatan ke Pembeli</div>
          <button class="btn-ghost" onclick="closeModal('noteModal')" aria-label="Tutup">X</button>
        </div>
        <div class="modal-body">
          <form id="noteForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
            @csrf
            {{-- We'll use updateStatus with same status to only add note; controller appends note if provided --}}
            <input type="hidden" name="status" value="{{ $order->status }}">
            <label for="admin_note">Catatan</label>
            <textarea name="note" id="admin_note" rows="4" placeholder="Tulis catatan untuk pembeli..."></textarea>

            <div class="modal-actions">
              <button class="btn" type="submit">Kirim Catatan</button>
              <button class="btn-ghost" type="button" onclick="closeModal('noteModal')">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  (function(){
    // helpers
    function $(s){return document.querySelector(s);}
    function $all(s){return Array.from(document.querySelectorAll(s));}
    function openModal(id){
      const el = document.getElementById(id);
      if(!el) return;
      el.classList.remove('hidden');
      el.setAttribute('aria-hidden','false');
    }
    function closeModal(id){
      const el = document.getElementById(id);
      if(!el) return;
      el.classList.add('hidden');
      el.setAttribute('aria-hidden','true');
    }
    window.closeModal = closeModal;

    const dynBtn = $('#dynamicActionBtn');

    if(dynBtn){
      dynBtn.addEventListener('click', function(e){
        const action = dynBtn.dataset.action || '';
        if(!action) return;
        if(action === 'openProofModal') openModal('proofModal');
        if(action === 'openTrackingModal') openModal('trackingModal');
        if(action === 'openNoteModal') openModal('noteModal');
      });
    }

    const quickReject = $('#quickRejectBtn');
    if(quickReject){
      quickReject.addEventListener('click', function(){
        openModal('proofModal');
        // focus reject textarea
        setTimeout(()=> { const t = $('#reject_note'); if(t) t.focus(); }, 200);
      });
    }

    const quickTracking = $('#quickTrackingBtn');
    if(quickTracking){
      quickTracking.addEventListener('click', function(){
        openModal('trackingModal');
        setTimeout(()=> { const t = $('#modal_tracking'); if(t) t.focus(); }, 200);
      });
    }

    // Accessibility: close modal on Esc
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape'){
        ['proofModal','trackingModal','noteModal'].forEach(id => {
          const el = document.getElementById(id);
          if(el && !el.classList.contains('hidden')) closeModal(id);
        });
      }
    });
  })();
</script>

@endsection
