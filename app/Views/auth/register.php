<div class="d-flex" style="min-height:100vh; background: linear-gradient(135deg,#eaf2ff,#f7f9fc);">

    <!-- =========================
         SIDEBAR
    ========================== -->
    <div style="
        width:240px;
        background: linear-gradient(180deg,#0b2a4a,#061a30);
        color:#fff;
        padding:20px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    ">

        <!-- BRAND -->
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-0">Lendora</h4>
            <small style="opacity:0.7;">Smart Library</small>
        </div>

        <hr style="border-color:rgba(255,255,255,0.1);">

        <!-- MENU -->
        <a href="#" class="d-block text-white text-decoration-none py-2">
            <i class="bi bi-person me-2"></i> User
        </a>

        <a href="#" class="d-block text-white text-decoration-none py-2">
            <i class="bi bi-gear me-2"></i> Setting
        </a>

        <a href="#" class="d-block text-white text-decoration-none py-2 text-danger">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>

    </div>

    <!-- =========================
         CONTENT
    ========================== -->
    <div class="flex-grow-1 d-flex align-items-center justify-content-center p-4">

        <form action="<?= base_url('/register') ?>" method="post"
              class="card border-0 shadow-lg p-4"
              style="width:100%; max-width:520px; border-radius:16px;">

            <!-- TITLE -->
            <h4 class="mb-4 text-center fw-bold">
                Register User
            </h4>

            <!-- NAMA -->
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <!-- USERNAME -->
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- ROLE -->
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="anggota">Anggota</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>

            <hr>

            <!-- ANGGOTA FIELD -->
            <div class="role-field anggota-field mb-3" style="display:none;">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="NIS">
            </div>

            <div class="role-field anggota-field mb-3" style="display:none;">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Alamat">
            </div>

            <div class="role-field anggota-field mb-3" style="display:none;">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="No HP">
            </div>

            <!-- PETUGAS FIELD -->
            <div class="role-field petugas-field mb-3" style="display:none;">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan">
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary w-100 mt-3">
                Simpan
            </button>

        </form>

    </div>

</div>