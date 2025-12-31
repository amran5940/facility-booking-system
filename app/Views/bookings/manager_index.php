<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<?php
$pendingCount = 0;
$approvedCount = 0;
$rejectedCount = 0;
$activeBookings = [];
$pastBookings = [];
$today = new DateTime('today');

foreach ($bookings as $b) {
    if ($b['status'] === 'pending') {
        $pendingCount++;
    } elseif ($b['status'] === 'approved') {
        $approvedCount++;
    } elseif ($b['status'] === 'rejected') {
        $rejectedCount++;
    }

    $endDate = new DateTime($b['end_date']);
    if ($endDate >= $today) {
        $activeBookings[] = $b;
    } else {
        $pastBookings[] = $b;
    }
}

$totalCount = count($bookings);
$activeCount = count($activeBookings);
$pastCount = count($pastBookings);
?>

<style>
    .page-shell { background: #f5f7fb; padding: 24px; }
    .card-glow { border: none; border-radius: 18px; box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-glow:hover { transform: translateY(-3px); box-shadow: 0 16px 36px rgba(0,0,0,0.12); transition: all 0.25s ease; }
    .stat-pill { display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 14px; color: #0b0c0f; font-weight: 600; }
    .stat-pill .icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; }
    .pill-orange { background: #fff7ed; }
    .pill-green { background: #ecfdf3; }
    .pill-red { background: #fef2f2; }
    .pill-blue { background: #eef2ff; }
    .icon-orange { background: linear-gradient(135deg, #fb923c, #f97316); }
    .icon-green { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .icon-red { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .icon-blue { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .filter-bar { gap: 12px; }
    .table-modern thead th { background: #f8fafc; color: #475569; font-weight: 700; border: none; }
    .table-modern tbody tr { background: #fff; border-radius: 12px; box-shadow: 0 8px 18px rgba(15,23,42,0.05); }
    .table-modern tbody tr td { vertical-align: middle; border-top: none; padding: 14px; }
    .badge-soft { padding: 8px 12px; border-radius: 999px; font-weight: 700; }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-approved { background: #dcfce7; color: #166534; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }
    .action-btn { border-radius: 12px; padding: 6px 12px; font-weight: 600; }
    .search-input { border-radius: 12px; }
    @media (max-width: 768px) { .table-responsive { border: none; } }
</style>

<div class="page-shell">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-1">Pengurusan Tempahan</h3>
            <p class="text-muted mb-0">Semak dan ambil tindakan ke atas tempahan fasiliti agensi anda.</p>
        </div>
        <div class="text-end">
            <div class="badge bg-light text-dark fw-semibold">Jumlah: <?= $totalCount ?> (Semasa: <?= $activeCount ?> · Lepas: <?= $pastCount ?>)</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="stat-pill pill-blue">
                <div class="icon icon-blue"><i class="fas fa-list"></i></div>
                <div>
                    <div class="text-muted small">Semua</div>
                    <div class="fs-5 fw-bold" id="stat-total"><?= $totalCount ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stat-pill pill-orange">
                <div class="icon icon-orange"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="text-muted small">Menunggu</div>
                    <div class="fs-5 fw-bold" id="stat-pending"><?= $pendingCount ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stat-pill pill-green">
                <div class="icon icon-green"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="text-muted small">Diluluskan</div>
                    <div class="fs-5 fw-bold" id="stat-approved"><?= $approvedCount ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stat-pill pill-red">
                <div class="icon icon-red"><i class="fas fa-times-circle"></i></div>
                <div>
                    <div class="text-muted small">Ditolak</div>
                    <div class="fs-5 fw-bold" id="stat-rejected"><?= $rejectedCount ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-glow mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-md-center filter-bar">
                <div class="flex-grow-1 w-100 mb-2 mb-md-0">
                    <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari pengguna atau fasiliti">
                </div>
                <div style="width: 220px;">
                    <select id="statusFilter" class="form-select" aria-label="Tapisan status">
                        <option value="all">Semua status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Diluluskan</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-glow mb-4">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="mb-1">Tempahan Semasa / Akan Datang</h5>
            <p class="text-muted small mb-0">Tempahan yang masih aktif atau akan datang.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0 bookings-table" id="bookingsTableActive">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Fasiliti</th>
                        <th>Tarikh Mula</th>
                        <th>Tarikh Tamat</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeBookings as $booking): ?>
                        <tr data-status="<?= esc($booking['status']) ?>">
                            <td><div class="fw-semibold mb-0"><?= esc($booking['user_name']) ?></div></td>
                            <td><div class="fw-semibold"><?= esc($booking['facility_name']) ?></div></td>
                            <td><?= esc(date('d M Y', strtotime($booking['start_date']))) ?></td>
                            <td><?= esc(date('d M Y', strtotime($booking['end_date']))) ?></td>
                            <td>
                                <?php
                                    $badgeClass = 'badge-pending';
                                    if ($booking['status'] === 'approved') { $badgeClass = 'badge-approved'; }
                                    if ($booking['status'] === 'rejected') { $badgeClass = 'badge-rejected'; }
                                ?>
                                <span class="badge-soft <?= $badgeClass ?> text-uppercase" data-label="<?= esc($booking['status']) ?>">
                                    <?= esc($booking['status'] === 'pending' ? 'Menunggu' : ($booking['status'] === 'approved' ? 'Diluluskan' : 'Ditolak')) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <?php if ($booking['status'] === 'pending'): ?>
                                    <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/approve" class="d-inline">
                                        <button type="submit" class="btn btn-success btn-sm action-btn"><i class="fas fa-check me-1"></i>Lulus</button>
                                    </form>
                                    <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/reject" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm action-btn"><i class="fas fa-times me-1"></i>Tolak</button>
                                    </form>
                                <?php endif; ?>
                                <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu padam tempahan ini?')">
                                    <button type="submit" class="btn btn-outline-danger btn-sm action-btn"><i class="fas fa-trash me-1"></i>Padam</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-glow">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="mb-1">Tempahan Lepas</h5>
            <p class="text-muted small mb-0">Tempahan yang telah berakhir.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0 bookings-table" id="bookingsTablePast">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Fasiliti</th>
                        <th>Tarikh Mula</th>
                        <th>Tarikh Tamat</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pastBookings as $booking): ?>
                        <tr data-status="<?= esc($booking['status']) ?>">
                            <td><div class="fw-semibold mb-0"><?= esc($booking['user_name']) ?></div></td>
                            <td><div class="fw-semibold"><?= esc($booking['facility_name']) ?></div></td>
                            <td><?= esc(date('d M Y', strtotime($booking['start_date']))) ?></td>
                            <td><?= esc(date('d M Y', strtotime($booking['end_date']))) ?></td>
                            <td>
                                <?php
                                    $badgeClass = 'badge-pending';
                                    if ($booking['status'] === 'approved') { $badgeClass = 'badge-approved'; }
                                    if ($booking['status'] === 'rejected') { $badgeClass = 'badge-rejected'; }
                                ?>
                                <span class="badge-soft <?= $badgeClass ?> text-uppercase" data-label="<?= esc($booking['status']) ?>">
                                    <?= esc($booking['status'] === 'pending' ? 'Menunggu' : ($booking['status'] === 'approved' ? 'Diluluskan' : 'Ditolak')) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <?php if ($booking['status'] === 'pending'): ?>
                                    <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/approve" class="d-inline">
                                        <button type="submit" class="btn btn-success btn-sm action-btn"><i class="fas fa-check me-1"></i>Lulus</button>
                                    </form>
                                    <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/reject" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm action-btn"><i class="fas fa-times me-1"></i>Tolak</button>
                                    </form>
                                <?php endif; ?>
                                <form method="post" action="/manager/bookings/<?= $booking['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu padam tempahan ini?')">
                                    <button type="submit" class="btn btn-outline-danger btn-sm action-btn"><i class="fas fa-trash me-1"></i>Padam</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const rows = Array.from(document.querySelectorAll('.bookings-table tbody tr'));
    const statTotal = document.getElementById('stat-total');
    const statPending = document.getElementById('stat-pending');
    const statApproved = document.getElementById('stat-approved');
    const statRejected = document.getElementById('stat-rejected');

    const applyFilter = () => {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        let total = 0, pending = 0, approved = 0, rejected = 0;

        rows.forEach(row => {
            const statusVal = row.getAttribute('data-status');
            const text = row.innerText.toLowerCase();
            const matchText = term === '' || text.includes(term);
            const matchStatus = status === 'all' || statusVal === status;
            const visible = matchText && matchStatus;
            row.style.display = visible ? '' : 'none';

            if (visible) {
                total++;
                if (statusVal === 'pending') pending++;
                if (statusVal === 'approved') approved++;
                if (statusVal === 'rejected') rejected++;
            }
        });

        statTotal.textContent = total;
        statPending.textContent = pending;
        statApproved.textContent = approved;
        statRejected.textContent = rejected;
    };

    searchInput.addEventListener('input', applyFilter);
    statusFilter.addEventListener('change', applyFilter);
});
</script>
<?= $this->endSection() ?>