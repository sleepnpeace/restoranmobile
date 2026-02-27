tabel user:
id
username
password
email
role(manager, admin, kasir)
status
id_karyawan

tabel kategori:
id
nama

tabel menu:
id
nama
harga
id_kategori
status
stok
gambar
deskripsi

tabel meja:
id
nomor_meja
status
kapasitas

tabel transaksi:
id
nama_konsumen
total_bayar
tanggal
status
id_user
id_meja

tabel pembayaran:
id
id_transaksi
metode_pembayaran (cash, qris)
jumlah_bayar
status
waktu_bayar

tabel karyawan:
id
nama
notelp
alamat
jenkel
jabatan

tabel detail_transaksi:
id
id_transaksi
id_menu
jumlah
metode(takeaway, dine in)
catatan
status
subtotal

tabel update_stokharian:
id
id_menu
jumlah_porsi
tanggal_update