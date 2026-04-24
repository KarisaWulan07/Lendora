<form action="<?= base_url('/register') ?>" method="post">

<input name="nama" placeholder="Nama" required>
<input name="email" placeholder="Email" required>
<input name="username" placeholder="Username" required>
<input name="password" type="password" required>

<select name="role" id="role" required>
    <option value="">-- Pilih Role --</option>
    <option value="anggota">Anggota</option>
    <option value="petugas">Petugas</option>
</select>

<!-- ANGGOTA -->
<input name="nis" placeholder="NIS">
<input name="alamat" placeholder="Alamat">
<input name="no_hp" placeholder="No HP">

<!-- PETUGAS -->
<input name="jabatan" placeholder="Jabatan">

<button type="submit">Register</button>

</form>