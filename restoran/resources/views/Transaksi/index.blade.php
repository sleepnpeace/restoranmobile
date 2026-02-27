@extends('manager.layouts.app')

@section('content')
<div class="main-content">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Riwayat Transaksi</h1>

    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <tr>
                    <th style="padding: 15px;">Pelanggan</th>
                    <th style="padding: 15px;">Meja</th>
                    <th style="padding: 15px;">Total Tagihan</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $t)
                @php 
                    $displayName = str_contains($t->nama_konsumen, '||') ? explode('||', $t->nama_konsumen)[0] : $t->nama_konsumen;
                @endphp
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px;"><b>{{ $displayName }}</b><br><small>{{ date('d M Y H:i', strtotime($t->tanggal)) }}</small></td>
                    <td style="padding: 15px;">
                        {{ $t->nomor_meja ? 'Meja ' . $t->nomor_meja : 'Takeaway' }}
                    </td>
                    <td style="padding: 15px; font-weight: 800; color: #16a34a;">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; 
                            background: {{ $t->status == 'paid' ? '#f0fdf4' : ($t->status == 'cancel' ? '#fef2f2' : '#fff7ed') }}; 
                            color: {{ $t->status == 'paid' ? '#16a34a' : ($t->status == 'cancel' ? '#dc2626' : '#ea580c') }}">
                            {{ strtoupper($t->status) }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 5px;">
                            <!-- Tombol Bayar (Hanya muncul jika pending) -->
                            @if($t->status == 'pending')
                            <button onclick="openPaymentModal('{{ $t->id }}', '{{ $t->total_bayar }}')" 
                                    style="background: #16a34a; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 12px;">
                                KONFIRMASI
                            </button>
                            @endif

                            <!-- Tombol Lihat Struk (Selalu muncul) -->
                            <a href="{{ route('kasir.detailtransaksi', $t->id) }}" target="_blank"
                               style="background: #3b82f6; color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-block;">
                                📄 STRUK
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Pembayaran (Code lama Anda tetap disini) -->
<div id="paymentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:20px; width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:20px; font-weight:800;">Selesaikan Pembayaran</h2>
        <form id="paymentForm" method="POST">
            @csrf
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">Total Tagihan</label>
                <input type="text" id="modal_total_display" readonly style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9; font-weight:800; color:#16a34a;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">Metode Pembayaran</label>
                <select name="metode_pembayaran" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    <option value="cash">Cash (Tunai)</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">Jumlah Uang Diterima</label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" placeholder="Masukkan nominal...">
            </div>

            <button type="submit" style="width:100%; background:#16a34a; color:white; border:none; padding:12px; border-radius:10px; font-weight:800; cursor:pointer;">SIMPAN & SELESAI</button>
            <button type="button" onclick="closePaymentModal()" style="width:100%; background:none; border:none; color:#94a3b8; margin-top:10px; cursor:pointer;">Batal</button>
        </form>
    </div>
</div>

<script>
   function openPaymentModal(id, total) {
    const actionUrl = "{{ url('/kasir/transaksi/bayar') }}/" + id;
    document.getElementById('paymentForm').action = actionUrl;
    
    document.getElementById('modal_total_display').value = "Rp " + parseInt(total).toLocaleString('id-ID');
    document.getElementById('jumlah_bayar').value = total;
    document.getElementById('paymentModal').style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}
</script>
@endsection