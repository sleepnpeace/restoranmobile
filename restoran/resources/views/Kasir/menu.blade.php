@extends('kasir.layouts.app')

@section('content')
<div class="main-content">
    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #bbf7d0; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    @foreach($menu->groupBy('kategori.nama') as $namaKategori => $items)
        <div class="category-section">
            <h2 class="category-name">{{ $namaKategori }}</h2>
            <div class="menu-grid">
                @foreach($items as $m)
                    <div class="menu-card">
                        <div class="card-image" onclick="openModal('{{ $m->id }}', '{{ $m->nama }}', '{{ $m->harga }}')">
                            <img src="{{ $m->gambar ?? 'https://via.placeholder.com/300' }}" alt="{{ $m->nama }}">
                            <div class="stock-badge">Stok: {{ $m->stok ?? '∞' }}</div>
                        </div>
                        <div class="card-content">
                            <p class="menu-name">{{ $m->nama }}</p>
                            <p class="price-tag">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>

                            <div class="action-group">
                                <button class="btn-info-detail" onclick="showDetail('{{ $m->id }}')">DETAIL</button>
                                <button class="btn-order" onclick="openModal('{{ $m->id }}', '{{ $m->nama }}', '{{ $m->harga }}')">PESAN</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

{{-- Floating Cart Button --}}
<button class="cart-toggle-btn" onclick="toggleCart()">
    🛒 <div id="cart-count">0</div>
</button>

{{-- Sidebar Keranjang --}}
<div class="sidebar-cart hide-scrollbar" id="sidebar-cart">
    <button onclick="toggleCart()" class="btn-close-cart">✕ TUTUP</button>
    <h2 style="color:#16a34a; margin-bottom:20px; font-weight: 800; font-size: 1.5rem;">Pesanan Baru 🛒</h2>

    <div id="cart-items-container" class="hide-scrollbar" style="flex:1; overflow-y:auto;"></div>

    <form action="{{ route('transaksi.store') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="cart_data" id="cart_data_input">
        
        <label class="label-form">Nama Pelanggan</label>
        <input type="text" name="nama_konsumen" placeholder="Ketik nama tamu..." required class="input-minimal">

        <label class="label-form">Pilih Nomor Meja</label>
        <select name="id_meja" required class="input-minimal">
            <option value="" disabled selected>Pilih Meja...</option>
            @foreach($mejas as $meja)
                <option value="{{ $meja->id }}" {{ $meja->status ? '' : 'disabled' }}>
                    Meja {{ $meja->nomor_meja }} {{ $meja->status ? '' : '(Penuh)' }}
                </option>
            @endforeach
        </select>

        <div style="display:flex; justify-content:space-between; margin:15px 0; font-weight:800; font-size:1.2rem;">
            <span style="color: #64748b;">Total</span>
            <span id="total-price-display" style="color:#16a34a;">Rp 0</span>
        </div>
        <button type="submit" class="btn-submit">SIMPAN & CETAK</button>
    </form>
</div>

{{-- Modal Order --}}
<div id="orderModal" class="modal">
    <div class="modal-content-small">
        <div style="text-align: center; margin-bottom: 20px;">
            <h3 id="modal-title" style="font-weight:800; font-size:1.6rem; color:#1e293b; margin-bottom: 5px;"></h3>
            <p id="modal-price" style="color:#16a34a; font-weight:800; font-size: 1.2rem;"></p>
        </div>

        <div class="qty-container">
            <button onclick="changeQty(-1)" class="btn-qty">-</button>
            <span id="modal-qty">1</span>
            <button onclick="changeQty(1)" class="btn-qty">+</button>
        </div>

        <div style="text-align: left; margin-bottom: 20px;">
            <label class="label-form">Metode Penyajian</label>
            <select id="modal-metode" class="input-minimal">
                <option value="Dine In">Makan Sini (Dine In)</option>
                <option value="Takeaway">Bungkus (Takeaway)</option>
            </select>

            <label class="label-form">Catatan Tambahan</label>
            <input type="text" id="modal-catatan" placeholder="Contoh: Tanpa pedas..." class="input-minimal">
        </div>

        <button class="btn-submit" onclick="addToCart()">TAMBAH KE KERANJANG</button>
        <button onclick="closeModal()" style="width:100%; margin-top:15px; background:none; border:none; color:#94a3b8; font-weight:600; cursor:pointer;">Batal</button>
    </div>
</div>

{{-- Modal Detail --}}
<div id="detailModal" class="modal">
    <div class="modal-content-small">
        <div id="detail-image-container" style="width:100%; height:200px; border-radius:15px; overflow:hidden; margin-bottom:20px;">
            <img id="detail-img" src="" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3 id="detail-title" style="font-weight:800; font-size:1.5rem; color:#1e293b; margin-bottom:10px;"></h3>
        <p id="detail-desc" style="color:#64748b; font-size:0.9rem; line-height:1.5; margin-bottom:20px;"></p>
        <div style="background:#f1f5f9; padding:15px; border-radius:12px; margin-bottom:20px;">
            <span class="label-form" style="margin-bottom:5px;">Status Stok</span>
            <b id="detail-stok" style="color:#1e293b;"></b>
        </div>
        <button onclick="closeDetailModal()" class="btn-submit" style="background:#64748b;">TUTUP DETAIL</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = [];
    let currentItem = null;

    function toggleCart() { document.getElementById('sidebar-cart').classList.toggle('active'); }
    function closeModal() { document.getElementById('orderModal').style.display = 'none'; }
    function closeDetailModal() { document.getElementById('detailModal').style.display = 'none'; }

    function openModal(id, nama, harga) {
        currentItem = { id, nama, harga, qty: 1 };
        document.getElementById('modal-title').innerText = nama;
        document.getElementById('modal-price').innerText = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
        document.getElementById('modal-qty').innerText = 1;
        document.getElementById('modal-catatan').value = '';
        document.getElementById('orderModal').style.display = 'flex';
    }

    function changeQty(v) {
        currentItem.qty = Math.max(1, currentItem.qty + v);
        document.getElementById('modal-qty').innerText = currentItem.qty;
    }

    function addToCart() {
        cart.push({
            id_menu: currentItem.id,
            nama: currentItem.nama,
            harga: currentItem.harga,
            jumlah: currentItem.qty,
            metode: document.getElementById('modal-metode').value,
            catatan: document.getElementById('modal-catatan').value,
            subtotal: currentItem.harga * currentItem.qty
        });
        renderCart();
        closeModal();
        document.getElementById('sidebar-cart').classList.add('active');
    }

    function renderCart() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';
        let total = 0;
        cart.forEach((item, index) => {
            total += item.subtotal;
            container.innerHTML += `
                <div style="background:#ffffff; padding:15px; border-radius:15px; margin-bottom:12px; border: 1px solid #e2e8f0; position:relative;">
                    <span style="position:absolute; top:12px; right:12px; font-size:10px; font-weight:800; padding:3px 8px; border-radius:5px; background:#f0fdf4; color:#16a34a; border: 1px solid #16a34a;">${item.metode.toUpperCase()}</span>
                    <b style="color:#1e293b; font-size:14px;">${item.nama}</b><br>
                    <small style="color:#64748b;">${item.jumlah}x @ Rp ${parseInt(item.harga).toLocaleString('id-ID')}</small>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; border-top: 1px dashed #e2e8f0; padding-top:10px;">
                        <b style="color:#1e293b;">Rp ${item.subtotal.toLocaleString('id-ID')}</b>
                        <button onclick="removeItem(${index})" style="color:#ef4444; border:none; background:none; cursor:pointer; font-weight:700; font-size:11px;">HAPUS</button>
                    </div>
                </div>`;
        });
        document.getElementById('total-price-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('cart-count').innerText = cart.length;
        document.getElementById('cart_data_input').value = JSON.stringify(cart);
    }

    function removeItem(index) { cart.splice(index, 1); renderCart(); }

    function showDetail(id) {
        fetch(`/kasir/menu/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detail-img').src = data.gambar ?? 'https://via.placeholder.com/300';
                document.getElementById('detail-title').innerText = data.nama;
                document.getElementById('detail-desc').innerText = data.deskripsi ?? 'Tidak ada deskripsi untuk menu ini.';
                document.getElementById('detail-stok').innerText = data.stok ?? '∞ (Tersedia)';
                document.getElementById('detailModal').style.display = 'flex';
            });
    }
</script>
@endpush