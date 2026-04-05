@extends('layouts.app')

@section('content')
<div class="container">

<h3 class="mb-4">Form Transaksi</h3>

<form action="{{ route('petugas.transaksi.store') }}" method="POST">
@csrf


<!-- PILIH TRANSAKSI -->
<div class="mb-3">
<label>Pilih Transaksi</label>

<select name="peminjaman_id" id="peminjaman" class="form-control" required>
<option value="">-- pilih transaksi --</option>

@foreach($peminjaman as $p)
<option value="{{ $p->id }}">
{{ $p->kode_peminjaman }} - {{ $p->user->name }}
</option>
@endforeach

</select>
</div>


<!-- TABEL ALAT -->
<table class="table table-bordered">

<thead>
<tr>
<th>Nama Barang</th>
<th>Jumlah</th>
<th>Harga / Hari</th>
<th>Jumlah Hari</th>
<th>Total</th>
</tr>
</thead>

<tbody id="alatTable">
</tbody>

</table>


<!-- BIAYA KERUSAKAN -->
<div class="mb-3">
<label>Biaya Kerusakan</label>

<input type="number"
name="biaya_kerusakan"
id="kerusakan"
class="form-control"
value="0"
readonly>

</div>


<!-- DENDA -->
<div class="mb-3">
<label>Denda Keterlambatan</label>

<input type="number" name="denda" id="denda" class="form-control" readonly>

</div>


<!-- TOTAL BAYAR -->
<div class="mb-3">
<label>Total Bayar</label>

<input type="number"
name="total_bayar"
id="totalBayar"
class="form-control"
readonly>

</div>


<!-- METODE PEMBAYARAN -->
<div class="mb-3">
<label>Metode Pembayaran</label>

<select name="metode_pembayaran"
id="metode"
class="form-control"
required>

<option value="">-- pilih metode --</option>
<option value="cash">Cash</option>
<option value="transfer">Transfer</option>
<option value="qris">QRIS</option>

</select>

</div>


<!-- NO HP (SELALU MUNCUL) -->
<div class="mb-3">
<label>No HP Pelanggan</label>

<input type="text"
name="no_telp"
class="form-control"
required>

</div>


<!-- CASH -->
<div id="cashForm" style="display:none">

<div class="mb-3">
<label>Uang Bayar</label>

<input type="number"
id="uangBayar"
class="form-control">

</div>


<div class="mb-3">
<label>Kembalian</label>

<input type="text"
id="kembalian"
class="form-control"
readonly>

</div>

</div>


<button class="btn btn-primary">
Kirim Transaksi
</button>

</form>

</div>


<script>

let peminjamanData = @json($peminjaman);

let hargaSewa = 0;
let dendaOtomatis = 0;


/* =========================
PILIH TRANSAKSI
========================= */

document.getElementById('peminjaman').addEventListener('change', function(){

let id = this.value;

let data = peminjamanData.find(p => p.id == id);

let table = document.getElementById('alatTable');

table.innerHTML = '';

hargaSewa = 0;
dendaOtomatis = 0;

if(!data) return;


/* =========================
HITUNG HARI SEWA
========================= */

let hari = hitungHari(data.tanggal_pinjam,data.tanggal_kembali_rencana);

/* =========================
HITUNG TERLAMBAT
========================= */

let hariTerlambat = hitungTerlambat(data.tanggal_kembali_rencana);


/* =========================
LOOP DETAIL ALAT
========================= */

data.details.forEach(function(detail){

let harga = detail.alat.harga_sewa;

let jumlah = detail.jumlah;

let dendaPerHari = detail.alat.denda_per_hari || 0;

let total = harga * jumlah * hari;

hargaSewa += total;


/* HITUNG DENDA OTOMATIS */

dendaOtomatis += hariTerlambat * dendaPerHari * jumlah;


table.innerHTML += `
<tr>
<td>${detail.alat.nama}</td>
<td>${jumlah}</td>
<td>${formatRupiah(harga)}</td>
<td>${hari}</td>
<td>${formatRupiah(total)}</td>
</tr>
`;

});


/* =========================
MASUKKAN DENDA OTOMATIS
========================= */

document.getElementById('denda').value = dendaOtomatis;


/* =========================
HITUNG BIAYA KERUSAKAN
========================= */

let totalKerusakan = 0;

if(data.pengembalian && data.pengembalian.detail_kerusakan){

data.pengembalian.detail_kerusakan.forEach(function(k){

totalKerusakan += parseFloat(k.biaya_perbaikan);

});

}

document.getElementById('kerusakan').value = totalKerusakan;


/* =========================
HITUNG TOTAL BAYAR
========================= */

hitungTotal();

});



/* =========================
HITUNG JUMLAH HARI SEWA
========================= */

function hitungHari(pinjam,kembali){

let p = new Date(pinjam);

let k = new Date(kembali);

let diff = (k - p) / (1000*60*60*24);

return diff + 1;

}



/* =========================
HITUNG HARI TERLAMBAT
========================= */

function hitungTerlambat(tanggal){

let today = new Date();

let kembali = new Date(tanggal);
// =======TESTING TERLAMBAT======
// ubah ('2026-03-20')

let diff = (today - kembali) / (1000*60*60*24);

if(diff > 0){
return Math.floor(diff);
}

return 0;

}




/* =========================
HITUNG TOTAL BAYAR
========================= */

document.getElementById('kerusakan').addEventListener('input', hitungTotal);
document.getElementById('denda').addEventListener('input', hitungTotal);

function hitungTotal(){

let kerusakan = parseInt(document.getElementById('kerusakan').value) || 0;

let denda = parseInt(document.getElementById('denda').value) || 0;

let total = hargaSewa + kerusakan + denda;

document.getElementById('totalBayar').value = total;

}



/* =========================
METODE PEMBAYARAN
========================= */

document.getElementById('metode').addEventListener('change', function(){

let metode = this.value;

document.getElementById('cashForm').style.display = 'none';

if(metode == 'cash'){
document.getElementById('cashForm').style.display = 'block';
}

});



/* =========================
HITUNG KEMBALIAN
========================= */

document.getElementById('uangBayar').addEventListener('input', function(){

let bayar = parseInt(this.value) || 0;

let total = parseInt(document.getElementById('totalBayar').value) || 0;

let kembali = bayar - total;

if(kembali < 0){

document.getElementById('kembalian').value = 'Uang Kurang';

}else{

document.getElementById('kembalian').value = formatRupiah(kembali);

}

});



/* =========================
FORMAT RUPIAH
========================= */

function formatRupiah(angka){

return 'Rp ' + angka.toLocaleString('id-ID');

}

</script>

@endsection