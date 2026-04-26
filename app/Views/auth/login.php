<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #0F4C75 !important;
        }

        body {
            background: #f4f6f9;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .left-panel {
            background: linear-gradient(135deg, #0F4C75, #3282B8);
            color: white;
            padding: 40px;
        }

        .left-panel h2 {
            font-weight: bold;
        }

        .right-panel {
            padding: 40px;
            background: white;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-primary {
            background: #0F4C75;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: #0d3d60;
        }

        .btn-outline-success,
        .btn-outline-danger {
            border-radius: 10px;
        }
        .btn-custom-primary {
        color: #0F4C75;
        border: 1px solid #0F4C75;
        }

        .btn-custom-primary:hover {
         background: #0F4C75;
         color: white;
        }
    </style>
</head>

<body>

<div class="container login-wrapper d-flex align-items-center justify-content-center">

    <div class="card login-card shadow-lg" style="max-width: 900px; width: 100%;">

        <div class="row g-0">

            <!-- LEFT PANEL -->
<div class="col-md-5 left-panel d-flex flex-column justify-content-center">

    <h4>
        <i class="bi bi-book-half me-2"></i> Lendora
    </h4>

    <p class="mt-3 fw-semibold">
        Smart Library Management System
    </p>

    <p class="mt-2">
        Selamat datang di Lendora, sistem manajemen perpustakaan digital yang dirancang untuk
        memudahkan pengelolaan peminjaman, pengembalian, dan pendataan buku secara cepat,
        efisien, dan modern.
    </p>

    <small class="mt-auto opacity-75">
        Silakan login untuk melanjutkan 👋
    </small>

</div>
            <!-- RIGHT PANEL -->
            <div class="col-md-7 right-panel">

                <h4 class="mb-4 fw-bold text-center">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </h4>

                <!-- ALERT -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger py-2">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('salahpw')): ?>
                    <div class="alert alert-danger py-2">
                        <?= session()->getFlashdata('salahpw') ?>
                    </div>
                <?php endif; ?>

                <!-- FORM -->
                <form action="<?= base_url('/login') ?>" method="post">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Masukkan password" required>
                    </div>

                    <button class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>

                </form>

                <!-- BUTTONS -->
                <div class="text-center mt-4 d-flex flex-column gap-2">

                    <a href="<?= base_url('users/create') ?>" class="btn btn-outline-primary btn-sm btn-custom-primary">
                        <i class="bi bi-person-plus me-1"></i> Daftar Baru
                    </a>

                    <a href="<?= base_url('restore') ?>" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-database me-1"></i> Restore DB
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>