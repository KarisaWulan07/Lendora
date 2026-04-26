<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", sans-serif;
            background: #eef3ff;
            min-height: 100vh;
        }

        .main-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .register-card {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }

        /* LEFT PANEL */
        .left-panel {
            background: linear-gradient(135deg, #0F4C75, #3282B8);
            color: white;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-top-right-radius: 120px;
            border-bottom-right-radius: 120px;
            padding: 50px;
            text-align: center;
        }

        .left-panel h1 {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .left-panel h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .left-panel p {
            font-size: 15px;
            opacity: 0.95;
            line-height: 1.8;
            max-width: 420px;
        }

        .btn-login {
            margin-top: 30px;
            border: 1px solid #fff;
            color: white;
            border-radius: 30px;
            padding: 10px 35px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: white;
            color: #0F4C75;
        }

        /* RIGHT PANEL */
        .right-panel {
            min-height: 650px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
        }

        .form-box h3 {
            font-weight: 700;
            color: #1b1b1b;
            margin-bottom: 8px;
        }

        .form-box p {
            color: #777;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group-text {
            background: #f8f9fc;
            border: 1px solid #dfe6ee;
            border-right: none;
            border-radius: 14px 0 0 14px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dfe6ee;
            border-radius: 14px;
            padding: 12px 15px;
            font-size: 14px;
            box-shadow: none !important;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 14px 14px 0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0F4C75;
        }

        .btn-save {
            width: 100%;
            background: #0F4C75;
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-save:hover {
            background: #0c3b5c;
        }

        .bottom-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .bottom-link a {
            text-decoration: none;
            color: #0F4C75;
            font-weight: 600;
        }

        .bottom-link a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none !important;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .register-card {
                border-radius: 18px;
            }
        }
    </style>
</head>

<body>

<div class="main-wrapper">
    <div class="register-card">
        <div class="row g-0">

            <!-- LEFT SIDE -->
            <div class="col-md-6 d-none d-md-block">
                <div class="left-panel">
                    <h1>LENDORA</h1>
                    <h2>Create New User</h2>

                    <p>
                        Sistem manajemen perpustakaan modern untuk mengelola data user 
                        dengan cepat, rapi, efisien, dan lebih terstruktur.
                    </p>

                    <a href="<?= base_url('login') ?>" class="btn-login">
                        Kembali Login
                    </a>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-6">
                <div class="right-panel">
                    <div class="form-box">

                        <h3>
                            <i class="bi bi-person-plus"></i>
                            Tambah User Baru
                        </h3>

                        <p>Silakan lengkapi data user baru di bawah ini</p>

                        <!-- ERROR -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- FORM -->
                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>

                            <div class="mb-3">
                                <select name="role" class="form-select" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn-save">
                                <i class="bi bi-save"></i>
                                Simpan Data
                            </button>

                        </form>

                        <div class="bottom-link">
                            Sudah selesai?
                            <a href="<?= base_url('login') ?>">Kembali ke Login</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>