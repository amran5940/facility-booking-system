<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .users-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .users-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .users-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .users-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .action-buttons-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .btn-action-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-modern {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-modern:hover {
        background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
        color: white;
        transform: translateY(-1px);
    }

    .users-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .users-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .users-table thead th {
        background: var(--primary-gradient);
        color: white;
        padding: 1.25rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .users-table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        vertical-align: middle;
    }

    .users-table tbody tr {
        transition: all 0.3s ease;
    }

    .users-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.02);
        transform: scale(1.01);
    }

    .user-avatar-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .user-email {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .user-role-badge {
        background: var(--primary-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .user-status {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .user-type {
        font-weight: 500;
        color: #495057;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-edit {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-password {
        background: var(--info-gradient);
        color: white;
    }

    .btn-password:hover {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: var(--danger-gradient);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #ff6b81 0%, #ff92a3 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-toggle-status {
        background: var(--warning-gradient);
        color: white;
    }

    .btn-toggle-status:hover {
        background: linear-gradient(135deg, #ffb347 0%, #ffd36a 100%);
        color: #333;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h4 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .search-filter-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .search-input {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 400px;
    }

    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary-gradient);
        border-color: var(--primary-color);
        color: white;
    }

    .table-stats {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .stats-info {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sort-icon {
        margin-left: 0.5rem;
        opacity: 0.7;
    }

    .sortable:hover .sort-icon {
        opacity: 1;
    }

    .users-table thead th {
        cursor: pointer;
        user-select: none;
        position: relative;
    }

    .users-table thead th:hover {
        background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
    }
        .users-table {
            font-size: 0.85rem;
        }

        .users-table thead th,
        .users-table tbody td {
            padding: 0.75rem 0.5rem;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .user-name {
            font-size: 0.9rem;
        }

        .user-email {
            font-size: 0.75rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-action {
            padding: 0.375rem 0.625rem;
            font-size: 0.7rem;
        }

        .btn-action small {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .users-table-container {
            border-radius: 0;
            margin: -1rem;
        }

        .users-table {
            font-size: 0.8rem;
        }

        .users-table thead th:nth-child(4),
        .users-table tbody td:nth-child(4) {
            display: none;
        }
    }
</style>

<!-- Header Section -->
<div class="users-header fade-in-up">
    <h1><i class="fas fa-users me-3"></i>Pengurusan Pengguna</h1>
    <p>Kelola semua pengguna dalam sistem tempahan fasiliti</p>
</div>

<!-- Action Buttons Section -->
<div class="action-buttons-section fade-in-up">
    <div class="btn-action-group">
        <a href="/admin/users/create" class="btn btn-modern">
            <i class="fas fa-user-plus"></i>
            <span>Tambah Pengguna Baharu</span>
        </a>
    </div>
</div>

<!-- Alerts -->
<?php if (session('success')): ?>
    <div class="alert alert-success alert-modern fade-in-up">
        <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
    </div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="alert alert-danger alert-modern fade-in-up">
        <i class="fas fa-exclamation-triangle me-2"></i><?= session('error') ?>
    </div>
<?php endif; ?>

<!-- Search and Filter Section -->
<div class="search-filter-section fade-in-up">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text" style="background: #f8f9fa; border: 2px solid #e9ecef; border-right: none; color: #6c757d;">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="search-input" id="userSearch" placeholder="Cari pengguna...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="admin">Admin</button>
                <button class="filter-btn" data-filter="manager">Pengurus</button>
                <button class="filter-btn" data-filter="user">Pengguna</button>
                <button class="filter-btn" data-filter="approved">Diluluskan</button>
                <button class="filter-btn" data-filter="pending">Menunggu</button>
            </div>
        </div>
    </div>
</div>

<!-- Table Statistics -->
<div class="table-stats fade-in-up">
    <div class="stats-info">
        <div class="stat-item">
            <div class="stat-number" id="totalUsers"><?= count($users) ?></div>
            <div class="stat-label">Jumlah Pengguna</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" id="approvedUsers"><?= count(array_filter($users, fn($u) => $u['approved'])) ?></div>
            <div class="stat-label">Diluluskan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" id="pendingUsers"><?= count(array_filter($users, fn($u) => !$u['approved'])) ?></div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" id="adminUsers"><?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?></div>
            <div class="stat-label">Admin</div>
        </div>
    </div>
    <div class="text-end">
        <small style="opacity: 0.8;">Kemaskini terakhir: <?= date('d/m/Y H:i') ?></small>
    </div>
</div>

<!-- Users Table -->
<div class="users-table-container fade-in-up">
    <?php if (!empty($users)): ?>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Emel</th>
                    <th>Telefon</th>
                    <th>Jenis</th>
                    <th>Peranan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div class="user-avatar-cell">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                </div>
                                <div class="user-info">
                                    <div class="user-name"><?= esc($user['full_name']) ?></div>
                                    <div class="user-email"><?= esc($user['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-email"><?= esc($user['email']) ?></div>
                        </td>
                        <td>
                            <?= esc($user['phone'] ?: 'Tidak dinyatakan') ?>
                        </td>
                        <td>
                            <span class="user-type">
                                <?= $user['user_type'] === 'public' ? 'Orang Awam' : 'Agensi' ?>
                            </span>
                        </td>
                        <td>
                            <span class="user-role-badge">
                                <?= esc($user['role']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="user-status status-<?= $user['approved'] ? 'approved' : 'pending' ?>">
                                <?= $user['approved'] ? 'Diluluskan' : 'Menunggu' ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/users/<?= $user['id'] ?>/edit" class="btn-action btn-edit" title="Edit Pengguna">
                                    <i class="fas fa-edit"></i>
                                    <small>Edit</small>
                                </a>

                                <a href="/admin/users/<?= $user['id'] ?>/change-password" class="btn-action btn-password" title="Tukar Kata Laluan">
                                    <i class="fas fa-key"></i>
                                    <small>Password</small>
                                </a>

                                <?php if ($user['role'] !== 'admin'): ?>
                                    <form method="post" action="/admin/users/<?= $user['id'] ?>/toggle-status" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-action btn-toggle-status" title="<?= $user['approved'] ? 'Nonaktifkan' : 'Aktifkan' ?> Pengguna">
                                            <i class="fas fa-<?= $user['approved'] ? 'ban' : 'check' ?>"></i>
                                            <small><?= $user['approved'] ? 'Nonaktif' : 'Aktif' ?></small>
                                        </button>
                                    </form>

                                    <form method="post" action="/admin/users/<?= $user['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam pengguna ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-action btn-delete" title="Padam Pengguna">
                                            <i class="fas fa-trash"></i>
                                            <small>Padam</small>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h4>Tiada Pengguna</h4>
            <p>Belum ada pengguna yang didaftarkan dalam sistem.</p>
            <a href="/admin/users/create" class="btn btn-modern">
                <i class="fas fa-user-plus me-2"></i>
                Tambah Pengguna Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('.users-table tbody tr');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        filterUsers(searchTerm, getActiveFilter());
    });

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.dataset.filter;
            filterUsers(searchInput.value.toLowerCase().trim(), filter);
        });
    });

    function getActiveFilter() {
        const activeButton = document.querySelector('.filter-btn.active');
        return activeButton ? activeButton.dataset.filter : 'all';
    }

    function filterUsers(searchTerm, filter) {
        let visibleCount = 0;
        let approvedCount = 0;
        let pendingCount = 0;
        let adminCount = 0;

        tableRows.forEach(row => {
            const userName = row.cells[0].textContent.toLowerCase();
            const userEmail = row.cells[1].textContent.toLowerCase();
            const userType = row.cells[3].textContent.toLowerCase();
            const userRole = row.cells[4].textContent.toLowerCase();
            const userStatus = row.cells[5].textContent.toLowerCase();

            // Check search term
            const matchesSearch = searchTerm === '' ||
                userName.includes(searchTerm) ||
                userEmail.includes(searchTerm);

            // Check filter
            let matchesFilter = true;
            switch(filter) {
                case 'admin':
                    matchesFilter = userRole.includes('admin');
                    break;
                case 'manager':
                    matchesFilter = userRole.includes('pengurus') || userRole.includes('manager');
                    break;
                case 'user':
                    matchesFilter = userRole.includes('pengguna') || userRole.includes('user');
                    break;
                case 'approved':
                    matchesFilter = userStatus.includes('diluluskan');
                    break;
                case 'pending':
                    matchesFilter = userStatus.includes('menunggu');
                    break;
                default:
                    matchesFilter = true;
            }

            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                visibleCount++;

                // Count for statistics
                if (userStatus.includes('diluluskan')) approvedCount++;
                if (userStatus.includes('menunggu')) pendingCount++;
                if (userRole.includes('admin')) adminCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update statistics
        document.getElementById('totalUsers').textContent = visibleCount;
        document.getElementById('approvedUsers').textContent = approvedCount;
        document.getElementById('pendingUsers').textContent = pendingCount;
        document.getElementById('adminUsers').textContent = adminCount;
    }

    // Table sorting functionality
    const tableHeaders = document.querySelectorAll('.users-table thead th');
    let sortDirection = {};

    tableHeaders.forEach((header, index) => {
        if (index < tableHeaders.length - 1) { // Don't make last column (Actions) sortable
            header.classList.add('sortable');
            header.innerHTML += ' <i class="fas fa-sort sort-icon"></i>';
            sortDirection[index] = 'asc';

            header.addEventListener('click', function() {
                const columnIndex = index;
                const direction = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
                sortDirection[columnIndex] = direction;

                // Update sort icons
                tableHeaders.forEach((h, i) => {
                    const icon = h.querySelector('.sort-icon');
                    if (icon) {
                        if (i === columnIndex) {
                            icon.className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'} sort-icon`;
                        } else {
                            icon.className = 'fas fa-sort sort-icon';
                        }
                    }
                });

                sortTable(columnIndex, direction);
            });
        }
    });

    function sortTable(columnIndex, direction) {
        const tbody = document.querySelector('.users-table tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            let aValue = a.cells[columnIndex].textContent.trim().toLowerCase();
            let bValue = b.cells[columnIndex].textContent.trim().toLowerCase();

            // Special handling for status column
            if (columnIndex === 5) {
                aValue = a.cells[columnIndex].querySelector('.user-status').textContent.trim().toLowerCase();
                bValue = b.cells[columnIndex].querySelector('.user-status').textContent.trim().toLowerCase();
            }

            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });

        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    }
});
</script>

<?= $this->endSection() ?>