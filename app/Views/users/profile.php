<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4 p-4">

        <div class="text-center">

            <img src="<?= $user['foto'] 
                ? base_url('uploads/users/' . $user['foto']) 
                : base_url('assets/img/default.png') ?>"
                width="110"
                height="110"
                class="rounded-circle border shadow-sm mb-3"
                style="object-fit:cover;">

            <h4 class="fw-bold mb-1">
                <?= $user['nama'] ?>
            </h4>

            <div class="text-muted mb-4">
                <?= ucfirst($user['role']) ?>
            </div>

        </div>

        <table class="table">

            <tr>
                <th width="180">Nama</th>
                <td><?= $user['nama'] ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $user['email'] ?></td>
            </tr>

            <tr>
                <th>Role</th>
                <td><?= ucfirst($user['role']) ?></td>
            </tr>

        </table>

        <div class="mt-3">

            <a href="<?= base_url('users/edit/' . $user['id']) ?>"
               class="btn btn-primary">

                <i class="bi bi-pencil-square"></i>
                Edit Profil

            </a>

        </div>

    </div>

</div>

<?= $this->endSection() ?>