<h2>Tambah Detail Buku</h2>

<form action="/peminjaman/saveDetail/<?= $id ?>" method="post">

Format:
<br>
ID_BUKU | JUMLAH

<pre>
1|2
3|1
5|4
</pre>

<textarea name="data_buku" rows="6"></textarea>

<br><br>
<button>Simpan</button>

</form>