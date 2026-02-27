<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #f1f5f9; display: flex; justify-content: center; padding: 20px; color: #000; }
        .struk-container { background: white; width: 320px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 15px; }
        .store-name { font-size: 20px; font-weight: 800; margin: 0; text-transform: uppercase; }
        .meta-info { font-size: 11px; margin-top: 5px; line-height: 1.4; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .info-row { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 3px; }
        .item-container { margin-bottom: 12px; padding-bottom: 5px; border-bottom: 1px dotted #ccc; }
        .item-name { font-weight: bold; font-size: 13px; display: block; }
        .item-details { display: flex; justify-content: space-between; font-size: 12px; margin-top: 2px; }
        .item-meta { font-size: 10px; color: #444; margin-top: 2px; display: flex; gap: 10px; }
        .item-note { font-size: 10px; font-style: italic; margin-top: 2px; background: #f0f0f0; padding: 2px 5px; border-radius: 4px; display: inline-block; }
        .total-section { border-top: 2px dashed #000; margin-top: 10px; padding-top: 10px; }
        .flex-between { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px; }
        .grand-total { font-size: 16px; font-weight: 800; margin-top: 5px; padding-top: 5px; border-top: 1px solid #000; }
        .footer { text-align: center; font-size: 10px; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; }
        .btn-group { margin-top: 20px; }
        .btn-print { display: block; width: 100%; background: #16a34a; color: white; border: none; padding: 12px; cursor: pointer; font-family: sans-serif; font-weight: bold; font-size: 14px; border-radius: 6px; margin-bottom: 10px;}
        .btn-tambah { display: block; width: 100%; background: #3b82f6; color: white; border: none; padding: 12px; cursor: pointer; font-family: sans-serif; font-weight: bold; font-size: 14px; border-radius: 6px; text-decoration: none; text-align: center; margin-bottom: 10px;}
        .btn-back { display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #475569; font-size: 12px; font-family: sans-serif; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; }
        @media print { body { background: white; padding: 0; } .struk-container { box-shadow: none; width: 100%; padding: 0; margin: 0; } .btn-group { display: none; } }
    </style>
</head>
<body>

    <div class="struk-container">
        <div class="header">
            <div class="store-name">NAMA RESTO ANDA</div>
            <div class="meta-info">Jl. Alamat Lengkap Restoran<br>Telp: 08xx-xxxx-xxxx</div>
        </div>

        <div>
            <div class="info-row"><span>No. Transaksi</span><span style="font-weight:bold">#{{ $transaksi->id }}</span></div>
            <div class="info-row"><span>Tanggal</span><span>{{ date('d/m/Y H:i', strtotime($transaksi->tanggal)) }}</span></div>
            <div class="info-row"><span>Kasir</span><span>{{ $transaksi->nama_kasir ?? 'System' }}</span></div>
            <div class="info-row"><span>Pelanggan</span><span>{{ $transaksi->nama_bersih }}</span></div>
            <div class="info-row"><span>Tipe Pesanan</span><span>{{ $transaksi->id_meja ? 'Dine In (Meja '.$transaksi->nomor_meja.')' : 'Takeaway' }}</span></div>
        </div>

        <div class="divider"></div>

        <div style="min-height: 100px;">
            @foreach($details as $item)
            <div class="item-container">
                <span class="item-name">{{ $item->nama_menu }}</span>
                <div class="item-details">
                    <span>{{ $item->jumlah }} x {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                    <span style="font-weight:bold">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="item-meta">
                    <span>[{{ strtoupper($item->metode ?? 'Dine In') }}]</span>
                </div>
                @if(!empty($item->catatan))
                <div class="item-note">Catatan: {{ $item->catatan }}</div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="total-section">
            <div class="flex-between grand-total">
                <span>TOTAL TAGIHAN</span>
                <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div style="margin-top: 10px;">
                <div class="flex-between">
                    <span>Status Bayar</span>
                    <span style="font-weight:bold; border: 1px solid #000; padding: 2px 5px;">{{ strtoupper($transaksi->status) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>** TERIMA KASIH **<br><i>Selamat menikmati hidangan kami</i></p>
        </div>

        <div class="btn-group">
            @if($transaksi->status == 'pending')
            <form action="{{ route('transaksi.tambah', $transaksi->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-tambah">+ TAMBAH PESANAN</button>
            </form>
            @endif

            <button onclick="window.print()" class="btn-print">🖨️ CETAK STRUK</button>
            <a href="{{ route('kasir.transaksi') }}" class="btn-back">Kembali ke Daftar</a>
        </div>
    </div>
</body>
</html>