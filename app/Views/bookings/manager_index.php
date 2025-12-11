<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Pengurusan Tempahan</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Fasiliti</th>
                <th>Tarikh Mula</th>
                <th>Tarikh Tamat</th>
                <th>Status</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= esc($booking['user_name']) ?></td>
                    <td><?= esc($booking['facility_name']) ?></td>
                    <td><?= esc($booking['start_date']) ?></td>
                    <td><?= esc($booking['end_date']) ?></td>
                    <td>
                        <span class="badge bg-<?= $booking['status'] === 'approved' ? 'success' : ($booking['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                            <?= esc(ucfirst($booking['status'])) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($booking['status'] === 'pending'): ?>
                            <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/approve" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-success">Luluskan</button>
                            </form>
                            <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/reject" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                        <?php endif; ?>
                        <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu padam tempahan ini?')">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Padam</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>