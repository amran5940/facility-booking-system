<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Tempahan Saya
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Current Bookings Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-day me-2"></i>Tempahan Semasa & Akan Datang
                                <?php if (!empty($currentBookings)): ?>
                                    <span class="badge bg-light text-dark ms-2"><?= count($currentBookings) ?></span>
                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($currentBookings)): ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tiada tempahan semasa</h5>
                                    <p class="text-muted">Anda tidak mempunyai tempahan yang sedang berlangsung atau akan datang.</p>
                                    <a href="/dashboard" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Buat Tempahan Baharu
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table id="currentBookingsTable" class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="fas fa-building me-1"></i>Fasiliti</th>
                                                <th><i class="fas fa-tags me-1"></i>Kategori</th>
                                                <th><i class="fas fa-map-marker-alt me-1"></i>Lokasi</th>
                                                <th><i class="fas fa-calendar-alt me-1"></i>Tarikh Mula</th>
                                                <th><i class="fas fa-calendar-check me-1"></i>Tarikh Tamat</th>
                                                <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                                <th><i class="fas fa-sticky-note me-1"></i>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($currentBookings as $booking): ?>
                                                <tr>
                                                    <td>
                                                        <strong class="text-primary"><?= esc($booking['facility_name']) ?></strong>
                                                        <?php if ($booking['agency_name']): ?>
                                                            <br><small class="text-muted">Agensi: <?= esc($booking['agency_name']) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary"><?= esc($booking['category_name']) ?></span>
                                                    </td>
                                                    <td>
                                                        <?= esc($booking['location']) ?: '<em class="text-muted">Tiada lokasi</em>' ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                        <?= date('d/m/Y H:i', strtotime($booking['start_date'])) ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                        <?= date('d/m/Y H:i', strtotime($booking['end_date'])) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = match($booking['status']) {
                                                            'approved' => 'success',
                                                            'pending' => 'warning',
                                                            'cancelled' => 'danger',
                                                            'rejected' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                        $statusText = match($booking['status']) {
                                                            'approved' => 'Diluluskan',
                                                            'pending' => 'Menunggu',
                                                            'cancelled' => 'Dibatalkan',
                                                            'rejected' => 'Ditolak',
                                                            default => ucfirst($booking['status'])
                                                        };
                                                        ?>
                                                        <span class="badge bg-<?= $statusClass ?>">
                                                            <i class="fas fa-circle me-1"></i><?= $statusText ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= esc($booking['notes']) ?: '<em class="text-muted">Tiada nota</em>' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Past Bookings Section -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history me-2"></i>Tempahan Lepas
                                <?php if (!empty($pastBookings)): ?>
                                    <span class="badge bg-light text-dark ms-2"><?= count($pastBookings) ?></span>
                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pastBookings)): ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tiada tempahan lepas</h5>
                                    <p class="text-muted">Anda belum mempunyai sebarang tempahan yang telah tamat.</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table id="pastBookingsTable" class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="fas fa-building me-1"></i>Fasiliti</th>
                                                <th><i class="fas fa-tags me-1"></i>Kategori</th>
                                                <th><i class="fas fa-map-marker-alt me-1"></i>Lokasi</th>
                                                <th><i class="fas fa-calendar-alt me-1"></i>Tarikh Mula</th>
                                                <th><i class="fas fa-calendar-check me-1"></i>Tarikh Tamat</th>
                                                <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                                <th><i class="fas fa-sticky-note me-1"></i>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pastBookings as $booking): ?>
                                                <tr class="table-secondary">
                                                    <td>
                                                        <strong class="text-primary"><?= esc($booking['facility_name']) ?></strong>
                                                        <?php if ($booking['agency_name']): ?>
                                                            <br><small class="text-muted">Agensi: <?= esc($booking['agency_name']) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary"><?= esc($booking['category_name']) ?></span>
                                                    </td>
                                                    <td>
                                                        <?= esc($booking['location']) ?: '<em class="text-muted">Tiada lokasi</em>' ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                        <?= date('d/m/Y H:i', strtotime($booking['start_date'])) ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                        <?= date('d/m/Y H:i', strtotime($booking['end_date'])) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = match($booking['status']) {
                                                            'approved' => 'success',
                                                            'pending' => 'secondary',
                                                            'cancelled' => 'danger',
                                                            'rejected' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                        $statusText = match($booking['status']) {
                                                            'approved' => 'Diluluskan',
                                                            'pending' => 'Tidak Aktif',
                                                            'cancelled' => 'Dibatalkan',
                                                            'rejected' => 'Ditolak',
                                                            default => ucfirst($booking['status'])
                                                        };
                                                        ?>
                                                        <span class="badge bg-<?= $statusClass ?>">
                                                            <i class="fas fa-circle me-1"></i><?= $statusText ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= esc($booking['notes']) ?: '<em class="text-muted">Tiada nota</em>' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Jumlah tempahan: <?= count($currentBookings) + count($pastBookings) ?> |
                            Semasa: <?= count($currentBookings) ?> |
                            Lepas: <?= count($pastBookings) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable for current bookings
    if ($('#currentBookingsTable').length) {
        $('#currentBookingsTable').DataTable({
            "language": {
                "lengthMenu": "Papar _MENU_ tempahan setiap halaman",
                "zeroRecords": "Tiada tempahan semasa ditemui",
                "info": "Menunjukkan _START_ hingga _END_ dari _TOTAL_ tempahan",
                "infoEmpty": "Tiada tempahan untuk dipaparkan",
                "infoFiltered": "(ditapis dari _MAX_ jumlah tempahan)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Seterusnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "order": [[ 3, "asc" ]], // Sort by start date ascending
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 6 } // Disable sorting on notes column
            ]
        });
    }

    // Initialize DataTable for past bookings
    if ($('#pastBookingsTable').length) {
        $('#pastBookingsTable').DataTable({
            "language": {
                "lengthMenu": "Papar _MENU_ tempahan setiap halaman",
                "zeroRecords": "Tiada tempahan lepas ditemui",
                "info": "Menunjukkan _START_ hingga _END_ dari _TOTAL_ tempahan",
                "infoEmpty": "Tiada tempahan untuk dipaparkan",
                "infoFiltered": "(ditapis dari _MAX_ jumlah tempahan)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Seterusnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "order": [[ 3, "desc" ]], // Sort by start date descending (most recent first)
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 6 } // Disable sorting on notes column
            ]
        });
    }
});
</script>

<?= $this->endSection() ?>