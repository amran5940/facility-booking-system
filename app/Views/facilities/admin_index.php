<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<style>
    .facilities-header {
        background: var(--quest-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .facilities-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .facilities-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .facilities-header p {
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

    .facility-category {
        background: var(--info-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    .facility-status {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-active {
        background: var(--success-gradient);
        color: white;
    }

    .status-inactive {
        background: var(--danger-gradient);
        color: white;
    }

    .facility-actions {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .btn-icon-label {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-icon-label i {
        font-size: 0.75rem;
    }

    .btn-icon-label small {
        font-size: 0.7rem;
        opacity: 0.9;
    }

    .btn-edit {
        background: var(--warning-gradient);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: var(--danger-gradient);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
        .facilities-header {
            padding: 2rem 1.5rem;
        }

        .facilities-header h1 {
            font-size: 2rem;
        }

        .table-container {
            padding: 1rem;
        }

        .facility-actions {
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
<div class="facilities-header fade-in-up">
    <h1><i class="fas fa-building me-3"></i>Semua Fasiliti</h1>
    <p>Papar dan urus semua fasiliti dalam sistem</p>
</div>

<?php
// Group facilities by agency
$groupedFacilities = [];
foreach ($facilities as $facility) {
    $agencyName = $facility['agency_name'] ?? 'Tiada Agensi';
    if (!isset($groupedFacilities[$agencyName])) {
        $groupedFacilities[$agencyName] = [];
    }
    $groupedFacilities[$agencyName][] = $facility;
}
?>

<?php foreach ($groupedFacilities as $agencyName => $agencyFacilities): ?>
    <div class="agency-section fade-in-up">
        <div class="agency-header">
            <h4><i class="fas fa-building me-2"></i><?= esc($agencyName) ?></h4>
            <span class="badge"><?= count($agencyFacilities) ?> fasiliti</span>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table id="facilitiesTable-<?= md5($agencyName) ?>" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Fasiliti</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Kapasiti</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agencyFacilities as $facility): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= esc($facility['name']) ?></div>
                                    <?php if ($facility['description']): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-quote-left me-1"></i>
                                            <?= esc($facility['description']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="facility-category"><?= esc($facility['category_name']) ?></span>
                                </td>
                                <td>
                                    <i class="fas fa-info-circle text-muted me-1"></i>
                                    <?= esc($facility['type']) ?>
                                </td>
                                <td>
                                    <i class="fas fa-users text-muted me-1"></i>
                                    <?= esc($facility['capacity']) ?>
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                    <?= esc($facility['location']) ?: 'Tiada lokasi' ?>
                                </td>
                                <td>
                                    <span class="facility-status status-<?= strtolower($facility['status']) ?>">
                                        <?= esc($facility['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="facility-actions">
                                        <a href="/admin/facilities/<?= $facility['id'] ?>/edit" class="btn-icon-label btn-edit">
                                            <i class="fas fa-edit"></i>
                                            <small>Edit</small>
                                        </a>

                                        <form method="post" action="/admin/facilities/<?= $facility['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam fasiliti ini?')">
                                            <button type="submit" class="btn-icon-label btn-delete">
                                                <i class="fas fa-trash"></i>
                                                <small>Padam</small>
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
    <?php foreach ($groupedFacilities as $agencyName => $agencyFacilities): ?>
        $('#facilitiesTable-<?= md5($agencyName) ?>').DataTable({
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
            "order": [[ 0, "asc" ]], // Sort by facility name ascending
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 6 } // Disable sorting on actions column
            ]
        });
    <?php endforeach; ?>
});
</script>

<?= $this->endSection() ?>