<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --brand-yellow: #ffcc00;
        --brand-yellow-dark: #f5b800;
        --brand-black: #0b0c0f;
        --brand-gray: #f5f6f8;
        --brand-line: #e5e7eb;
        --primary-gradient: linear-gradient(135deg, #ffcc00 0%, #ffd84d 100%);
        --success-gradient: linear-gradient(135deg, #2ec8a6 0%, #54dcbf 100%);
        --info-gradient: linear-gradient(135deg, #111217 0%, #161821 100%);
        --card-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.9rem;
        background: var(--primary-gradient);
        color: #111217;
        border-radius: 999px;
        font-weight: 700;
        box-shadow: 0 10px 24px rgba(255,204,0,0.28);
        font-size: 0.95rem;
    }

    .badge-soft {
        padding: 0.35rem 0.8rem;
        border-radius: 14px;
        background: #fff7d6;
        color: #8a6b00;
        border: 1px solid #ffe89c;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .dashboard-shell {
        background: #f1fbf6;
        min-height: 100vh;
        padding: 2rem 0 3rem;
    }

    .welcome-section {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        border: 1px solid #eceff3;
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--brand-black);
    }

    .welcome-section p {
        font-size: 1.05rem;
        color: #1f2937;
        margin-bottom: 0;
    }

    .profile-card {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #eceff3;
        transition: all 0.25s ease;
        box-shadow: 0 10px 24px rgba(0,0,0,0.06);
    }

    .profile-card:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.08);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 22px rgba(0,0,0,0.1);
    }

    .profile-info h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .profile-info p {
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .profile-info small {
        font-size: 0.8rem;
        opacity: 0.7;
    }

    .btn-edit-profile {
        background: var(--primary-gradient);
        border: none;
        color: #0b0c0f;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 1rem;
        box-shadow: 0 10px 24px rgba(255,204,0,0.35);
    }

    .btn-edit-profile:hover {
        background: var(--primary-gradient);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(255,204,0,0.35);
        color: #0b0c0f;
        text-decoration: none;
    }

    .facilities-section h2 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2rem;
        text-align: center;
    }

    .agency-section {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 24px rgba(0,0,0,0.06);
        border: 1px solid #eceff3;
    }

    .agency-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .agency-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0b0c0f;
        margin-bottom: 0.5rem;
    }

    .agency-description {
        font-size: 1rem;
        color: #4b5563;
        margin-bottom: 0;
    }

    .facility-description {
        line-height: 1.5;
        min-height: 3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .facility-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .facility-card {
        background: #fff;
        border-radius: 15px;
        border: 1px solid #eceff3;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        border-color: #ffd84d;
    }

    .facility-card .card-body {
        padding: 2rem;
        text-align: center;
    }

    .facility-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 22px rgba(255,204,0,0.35);
    }

    .facility-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0b0c0f;
        margin-bottom: 0.5rem;
    }

    .facility-type {
        display: inline-block;
        background: #fff7d6;
        color: #8a6b00;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border: 1px solid #ffe89c;
    }

    .agency-badge {
        display: inline-block;
        background: #f5f6f8;
        color: #0b0c0f;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid #eceff3;
    }

    .book-btn {
        background: var(--primary-gradient);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 2rem;
        color: #0b0c0f;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 24px rgba(255,204,0,0.35);
        width: 100%;
    }

    .book-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(255,204,0,0.4);
        color: #0b0c0f;
    }

    .no-facilities {
        text-align: center;
        padding: 4rem 2rem;
        background: #f9fafb;
        border-radius: 20px;
        margin: 2rem 0;
    }

    .no-facilities i {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .no-facilities h3 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .no-facilities p {
        color: #868e96;
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

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .stagger-animation > * {
        animation: fadeInUp 0.6s ease-out;
    }

    .stagger-animation > *:nth-child(1) { animation-delay: 0.1s; }
    .stagger-animation > *:nth-child(2) { animation-delay: 0.2s; }
    .stagger-animation > *:nth-child(3) { animation-delay: 0.3s; }
    .stagger-animation > *:nth-child(4) { animation-delay: 0.4s; }
    .stagger-animation > *:nth-child(5) { animation-delay: 0.5s; }
    .stagger-animation > *:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="dashboard-shell">
<div class="container mt-5">
<!-- Welcome Section -->
<div class="welcome-section fade-in-up">
    <div class="row align-items-center">
        <div class="col-lg-6 text-start">
            <div class="pill mb-3"><i class="fas fa-user-shield"></i> Dashboard Pengguna</div>
            <h1><i class="fas fa-user me-3"></i>Selamat Datang</h1>
            <p class="mb-0">Temui dan tempah fasiliti yang tersedia untuk kegunaan anda.</p>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <?php if (($userType ?? 'public') === 'agency'): ?>
                    <span class="badge-soft"><i class="fas fa-landmark me-1"></i><?= isset($agencyFacilities) ? count($agencyFacilities) : 0 ?> agensi</span>
                <?php endif; ?>
                <span class="badge-soft"><i class="fas fa-warehouse me-1"></i><?= isset($publicFacilities) ? count($publicFacilities) : 0 ?> fasiliti awam</span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="profile-card">
                <div class="profile-avatar">
                    <?= strtoupper(substr(session('user')['full_name'] ?? 'P', 0, 1)) ?>
                </div>
                <div class="profile-info">
                    <h4><?= session('user')['full_name'] ?? 'Pengguna' ?></h4>
                    <p><i class="fas fa-envelope me-2"></i><?= session('user')['email'] ?? '' ?></p>
                    <p><i class="fas fa-phone me-2"></i><?= session('user')['phone'] ?? 'Tidak dinyatakan' ?></p>
                    <p><i class="fas fa-user me-2"></i>Pengguna Sistem</p>
                    <div class="text-center">
                        <a href="#" class="btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: var(--primary-gradient); color: white; border-radius: 20px 20px 0 0; border-bottom: none; padding: 2rem;">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div id="editProfileAlert"></div>
                <form id="editProfileForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label" style="font-weight: 600; color: #2c3e50;">
                                <i class="fas fa-user me-2" style="color: var(--brand-black);"></i>Nama Penuh
                            </label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   value="<?= session('user')['full_name'] ?? '' ?>"
                                   style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label" style="font-weight: 600; color: #2c3e50;">
                                <i class="fas fa-envelope me-2" style="color: var(--brand-black);"></i>Emel
                            </label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= session('user')['email'] ?? '' ?>"
                                   style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label" style="font-weight: 600; color: #2c3e50;">
                                <i class="fas fa-phone me-2" style="color: var(--brand-black);"></i>Telefon
                            </label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   value="<?= session('user')['phone'] ?? '' ?>"
                                   style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label" style="font-weight: 600; color: #2c3e50;">
                                <i class="fas fa-calendar me-2" style="color: var(--brand-black);"></i>Tarikh Lahir
                            </label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                   value="<?= session('user')['date_of_birth'] ?? '' ?>"
                                   style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label" style="font-weight: 600; color: #2c3e50;">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--brand-black);"></i>Alamat
                        </label>
                        <textarea class="form-control" id="address" name="address" rows="3"
                                  style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;"><?= session('user')['address'] ?? '' ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label" style="font-weight: 600; color: #2c3e50;">
                                <i class="fas fa-venus-mars me-2 text-secondary"></i>Jantina
                            </label>
                            <select class="form-control" id="gender" name="gender"
                                    style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.875rem 1rem; transition: all 0.3s ease;">
                                <option value="">Pilih Jantina</option>
                                <option value="Lelaki" <?= (session('user')['gender'] ?? '') == 'Lelaki' ? 'selected' : '' ?>>Lelaki</option>
                                <option value="Perempuan" <?= (session('user')['gender'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg me-2" id="editProfileBtn"
                            style="background: var(--primary-gradient); color: #0b0c0f; border: none; border-radius: 25px; padding: 0.75rem 2rem; box-shadow: 0 10px 24px rgba(255,204,0,0.35); transition: all 0.3s ease;">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal"
                                style="border-radius: 25px; padding: 0.75rem 2rem;">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php if (!empty($agencyFacilities) || !empty($publicFacilitiesByAgency)): ?>
        
        <!-- Agency Facilities -->
        <?php if (($userType ?? 'public') === 'agency' && !empty($agencyFacilities)): ?>
            <?php foreach ($agencyFacilities as $agencyData): ?>
                <div class="agency-section mb-5">
                    <div class="agency-header mb-4">
                        <h3 class="agency-title">
                            <i class="fas fa-university me-2" style="color: var(--brand-black);"></i>
                            <?= esc($agencyData['agency']['name']) ?>
                        </h3>
                        <p class="agency-description text-muted">
                            <?= esc($agencyData['agency']['description'] ?: 'Agensi kerajaan yang menyediakan pelbagai fasiliti untuk kegunaan awam.') ?>
                        </p>
                    </div>
                    
                    <div class="facility-grid stagger-animation">
                        <?php foreach ($agencyData['facilities'] as $facility): ?>
                            <div class="facility-card">
                                <div class="card-body">
                                    <div class="facility-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h5 class="facility-name"><?= esc($facility['name']) ?></h5>
                                    <span class="facility-type">
                                        <i class="fas fa-tag me-1"></i>
                                        <?= esc($facility['category_name'] ?? 'Fasiliti') ?>
                                    </span>
                                    <br>
                                    <span class="agency-badge">
                                        <i class="fas fa-university me-1"></i>
                                        <?= esc($agencyData['agency']['name']) ?>
                                    </span>
                                    <br>
                                    <p class="facility-description small text-muted mb-3">
                                        <?= esc($facility['description'] ?: 'Tiada penerangan tambahan.') ?>
                                    </p>
                                    <a href="/user/bookings/create/<?= $facility['id'] ?>" class="book-btn">
                                        <i class="fas fa-calendar-plus me-2"></i>Tempah Sekarang
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Public Facilities (only for public users) -->
        <?php if (($userType ?? 'public') === 'public' && !empty($publicFacilitiesByAgency)): ?>
            <?php foreach ($publicFacilitiesByAgency as $agencyData): ?>
                <div class="agency-section mb-5">
                    <div class="agency-header mb-4">
                        <h3 class="agency-title">
                            <i class="fas fa-globe me-2" style="color: var(--brand-black);"></i>
                            <?= esc($agencyData['agency']['name'] ?? 'Fasiliti Awam Umum') ?>
                        </h3>
                        <p class="agency-description text-muted">
                            Fasiliti awam yang ditawarkan oleh <?= esc($agencyData['agency']['name'] ?? 'agensi berkaitan') ?>.
                        </p>
                    </div>
                    
                    <div class="facility-grid stagger-animation">
                        <?php foreach ($agencyData['facilities'] as $facility): ?>
                            <div class="facility-card">
                                <div class="card-body">
                                    <div class="facility-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h5 class="facility-name"><?= esc($facility['name']) ?></h5>
                                    <span class="facility-type">
                                        <i class="fas fa-tag me-1"></i>
                                        <?= esc($facility['category_name'] ?? 'Fasiliti Awam') ?>
                                    </span>
                                    <br>
                                    <span class="agency-badge">
                                        <i class="fas fa-university me-1"></i>
                                        <?= esc($agencyData['agency']['name'] ?? 'Umum') ?>
                                    </span>
                                    <br>
                                    <p class="facility-description small text-muted mb-3">
                                        <?= esc($facility['description'] ?: 'Tiada penerangan tambahan.') ?>
                                    </p>
                                    <a href="/user/bookings/create/<?= $facility['id'] ?>" class="book-btn">
                                        <i class="fas fa-calendar-plus me-2"></i>Tempah Sekarang
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php else: ?>
        <div class="no-facilities">
            <i class="fas fa-building"></i>
            <h3>Tiada Fasiliti Tersedia</h3>
            <p>Maaf, tiada fasiliti yang tersedia untuk tempahan pada masa ini.</p>
        </div>
    <?php endif; ?>
</div>
</div>

<script>
// Add smooth scrolling and enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add click animation to book buttons
    const bookButtons = document.querySelectorAll('.book-btn');
    bookButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Add hover effect to facility cards
    const facilityCards = document.querySelectorAll('.facility-card');
    facilityCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });

    // Edit Profile Modal Functionality
    const editProfileForm = document.getElementById('editProfileForm');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileAlert = document.getElementById('editProfileAlert');
    const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));

    if (editProfileForm) {
        editProfileForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Show loading state
            editProfileBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            editProfileBtn.disabled = true;

            try {
                const response = await fetch('/user/update-profile', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    editProfileAlert.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>${result.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    // Update the displayed profile information
                    document.querySelector('.profile-info h4').textContent = result.user.full_name;
                    document.querySelector('.profile-info p:nth-child(2)').innerHTML = '<i class="fas fa-envelope me-2"></i>' + result.user.email;
                    document.querySelector('.profile-info p:nth-child(3)').innerHTML = '<i class="fas fa-phone me-2"></i>' + (result.user.phone || 'Tidak dinyatakan');
                    document.querySelector('.profile-avatar').textContent = result.user.full_name.charAt(0).toUpperCase();

                    setTimeout(() => {
                        editProfileModal.hide();
                    }, 2000);
                } else {
                    editProfileAlert.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>${result.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Edit profile error:', error);
                editProfileAlert.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>Ralat sistem. Sila cuba lagi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            } finally {
                editProfileBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
                editProfileBtn.disabled = false;
            }
        });
    }

    // Reset form when modal is hidden
    document.getElementById('editProfileModal').addEventListener('hidden.bs.modal', function() {
        if (editProfileForm) {
            editProfileForm.reset();
            if (editProfileAlert) editProfileAlert.innerHTML = '';
        }
    });

    // Add focus effects to inputs
    const modalInputs = document.querySelectorAll('#editProfileModal .form-control');
    modalInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#1e90ff';
            this.style.boxShadow = '0 0 0 0.2rem rgba(30, 144, 255, 0.25)';
        });

        input.addEventListener('blur', function() {
            this.style.borderColor = '#e9ecef';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

<?= $this->endSection() ?>