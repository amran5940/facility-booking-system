<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<style>
    .bookings-header {
        background: var(--quest-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .bookings-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .bookings-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .bookings-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .agency-section {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .agency-header {
        background: var(--quest-gradient);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .agency-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .agency-header h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .agency-header .badge {
        background: rgba(255,255,255,0.2);
        color: white;
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        position: relative;
        z-index: 1;
    }

    .table-container {
        padding: 2rem;
    }

    .table thead th {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-approved {
        background: var(--success-gradient);
        color: white;
    }

    .status-rejected {
        background: var(--danger-gradient);
        color: white;
    }

    .status-pending {
        background: var(--warning-gradient);
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-approve {
        background: var(--success-gradient);
        color: white;
    }

    .btn-approve:hover {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-reject {
        background: var(--danger-gradient);
        color: white;
    }

    .btn-reject:hover {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: var(--dark-gradient);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
        transform: translateY(-1px);
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .bookings-header {
            padding: 2rem 1.5rem;
        }

        .bookings-header h1 {
            font-size: 2rem;
        }

        .table-container {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<!-- Header Section -->
<div class="bookings-header fade-in-up">
    <h1><i class="fas fa-calendar-check me-3"></i>Semua Tempahan</h1>
    <p>Papar dan urus semua tempahan dalam sistem</p>
</div>

<!-- Bookings Tables Grouped by Agency -->
<?php
// Group bookings by agency
$groupedBookings = [];
foreach ($bookings as $booking) {
    $agencyName = $booking['agency_name'] ?? 'Tiada Agensi';
    if (!isset($groupedBookings[$agencyName])) {
        $groupedBookings[$agencyName] = [];
    }
    $groupedBookings[$agencyName][] = $booking;
}
?>

<?php foreach ($groupedBookings as $agencyName => $agencyBookings): ?>
    <div class="agency-section fade-in-up">
        <div class="agency-header">
            <h4><i class="fas fa-building me-2"></i><?= esc($agencyName) ?></h4>
            <span class="badge"><?= count($agencyBookings) ?> tempahan</span>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table id="bookingsTable-<?= md5($agencyName) ?>" class="table table-striped">
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
                        <?php foreach ($agencyBookings as $booking): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= esc($booking['user_name']) ?></div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        <?= esc($booking['facility_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-plus text-muted me-1"></i>
                                    <?= esc($booking['start_date']) ?>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-minus text-muted me-1"></i>
                                    <?= esc($booking['end_date']) ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($booking['status']) ?>">
                                        <?= esc(ucfirst($booking['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <form method="post" action="/admin/bookings/<?= $booking['id'] ?>/approve" class="d-inline">
                                                <button type="submit" class="btn-action btn-approve" title="Lulus Tempahan">
                                                    <i class="fas fa-check me-1"></i>Lulus
                                                </button>
                                            </form>

                                            <form method="post" action="/admin/bookings/<?= $booking['id'] ?>/reject" class="d-inline">
                                                <button type="submit" class="btn-action btn-reject" title="Tolak Tempahan">
                                                    <i class="fas fa-times me-1"></i>Tolak
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="post" action="/admin/bookings/<?= $booking['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam tempahan ini?')">
                                            <button type="submit" class="btn-action btn-delete" title="Padam Tempahan">
                                                <i class="fas fa-trash me-1"></i>Padam
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
$(document).ready(function() {
    <?php foreach ($groupedBookings as $agencyName => $agencyBookings): ?>
        $('#bookingsTable-<?= md5($agencyName) ?>').DataTable({
            "language": {
                "lengthMenu": "Papar _MENU_ entri setiap halaman",
                "zeroRecords": "Tiada rekod yang sepadan ditemui",
                "info": "Memanipulasi _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Tiada entri untuk dipaparkan",
                "infoFiltered": "(ditapis dari _MAX_ jumlah entri)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Seterusnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "order": [[ 2, "desc" ]], // Sort by start date descending
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 5 } // Disable sorting on actions column
            ]
        });
    <?php endforeach; ?>
});
</script>

<?= $this->endSection() ?>