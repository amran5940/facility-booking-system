<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<style>
    .categories-header {
        background: var(--quest-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .categories-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .categories-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .categories-header p {
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

    .btn-modern {
        background: var(--quest-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 233, 123, 0.4);
        color: white;
    }

    .category-card {
        background: white;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .category-header {
        background: var(--quest-gradient);
        color: white;
        padding: 1.5rem;
        position: relative;
    }

    .category-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .category-header h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .category-body {
        padding: 1.5rem;
    }

    .category-description {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .category-actions {
        display: flex;
        gap: 0.5rem;
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
        background: var(--quest-gradient);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #5e35b1 0%, #4527a0 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-fields {
        background: var(--info-gradient);
        color: white;
    }

    .btn-fields:hover {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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

    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .create-category-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 1rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-modern .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-modern .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-modern .form-control:focus {
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.25);
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
        .categories-header {
            padding: 2rem 1.5rem;
        }

        .categories-header h1 {
            font-size: 2rem;
        }

        .category-actions {
            justify-content: center;
        }
    }
</style>

<!-- Header Section -->
<div class="categories-header fade-in-up">
    <h1><i class="fas fa-tags me-3"></i>Kategori Fasiliti</h1>
    <p>Kelola kategori fasiliti untuk sistem tempahan</p>
</div>

<!-- Action Buttons Section -->
<div class="action-buttons-section fade-in-up">
    <button class="btn btn-modern" type="button" data-bs-toggle="collapse" data-bs-target="#createCategory" aria-expanded="false" aria-controls="createCategory">
        <i class="fas fa-plus-circle"></i>
        <span>Cipta Kategori Baharu</span>
    </button>
</div>

<!-- Create Category Collapse Section -->
<div class="collapse fade-in-up" id="createCategory">
    <div class="create-category-section">
        <h5 class="mb-4"><i class="fas fa-tag me-2"></i>Cipta Kategori Fasiliti</h5>
        <form method="post" action="/admin/facility-categories" class="form-modern">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Penerangan</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-modern">
                <i class="fas fa-save me-2"></i>Cipta Kategori
            </button>
            <button type="button" class="btn btn-secondary ms-2" data-bs-toggle="collapse" data-bs-target="#createCategory" aria-expanded="false" aria-controls="createCategory">
                <i class="fas fa-times me-2"></i>Batal
            </button>
        </form>
    </div>
</div>

<!-- Categories Grid -->
<div class="row">
    <?php foreach ($facility_categories as $category): ?>
        <div class="col-lg-6 col-xl-4 fade-in-up">
            <div class="category-card">
                <div class="category-header">
                    <h5><i class="fas fa-tag me-2"></i><?= esc($category['name']) ?></h5>
                </div>
                <div class="category-body">
                    <div class="category-description">
                        <?= esc($category['description']) ?: '<em class="text-muted">Tiada penerangan</em>' ?>
                    </div>

                    <div class="category-actions">
                        <a href="/admin/facility-categories/<?= $category['id'] ?>/edit" class="btn-icon-label btn-edit">
                            <i class="fas fa-edit"></i>
                            <small>Edit</small>
                        </a>

                        <a href="/admin/facility-categories/<?= $category['id'] ?>/fields" class="btn-icon-label btn-fields">
                            <i class="fas fa-list"></i>
                            <small>Medan</small>
                        </a>

                        <form method="post" action="/admin/facility-categories/<?= $category['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam kategori ini?')">
                            <button type="submit" class="btn-icon-label btn-delete">
                                <i class="fas fa-trash"></i>
                                <small>Padam</small>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>