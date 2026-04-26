<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LendoraApp</title>

    <!-- BOOTSTRAP -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- DASHBOARD CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            min-height: 100vh;
            background: #f4f8fb;
            margin: 0;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: #0B2E59;
            color: #fff;
            padding: 20px 10px;
            border-radius: 0 20px 20px 0;
            box-shadow: 5px 0 25px rgba(0,0,0,0.08);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: 0.25s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            width: 100%;
        }

        /* 🔥 FIX: benar-benar hilangkan sidebar */
        .no-sidebar .sidebar {
            display: none !important;
        }

        .no-sidebar .content {
            padding: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar a span {
                display: none;
            }
        }
    </style>
</head>

<body>

<?php
    // 🔥 bikin variable aman (anti undefined)
    $hideSidebar = $hideSidebar ?? false;
?>

<div class="wrapper <?= $hideSidebar ? 'no-sidebar' : '' ?>">

    <?php if (!$hideSidebar): ?>
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
        </aside>
    <?php endif; ?>

    <!-- CONTENT -->
    <main class="content">
        <?= $this->renderSection('content') ?>
    </main>

</div>

</body>
</html>