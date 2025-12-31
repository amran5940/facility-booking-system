<?= $this->extend('admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Payment Gateway
                    </h4>
                </div>
                <div class="card-body">
                    <form action="/admin/payment-gateways/<?= $gateway['id'] ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?= esc($gateway['name']) ?>" placeholder="e.g., FPX Online Banking">
                                <small class="text-muted">Display name for the payment gateway</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">
                                    <i class="fas fa-code me-1"></i>Code <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="code" name="code" required
                                       value="<?= esc($gateway['code']) ?>" placeholder="e.g., fpx" 
                                       pattern="[a-z0-9_]+" title="Only lowercase letters, numbers, and underscores allowed">
                                <small class="text-muted">Unique identifier (lowercase, no spaces)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-info-circle me-1"></i>Description
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                      placeholder="Describe the payment gateway..."><?= esc($gateway['description']) ?></textarea>
                            <small class="text-muted">Optional description for administrators</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" <?= $gateway['is_active'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    <i class="fas fa-toggle-on me-1"></i>Active
                                </label>
                            </div>
                            <small class="text-muted">Check to make this payment gateway available for bookings</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Payment Gateway
                            </button>
                            <a href="/admin/payment-gateways" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate code from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const code = name.toLowerCase()
                     .replace(/[^a-z0-9\s]/g, '') // Remove special chars
                     .replace(/\s+/g, '_') // Replace spaces with underscores
                     .replace(/_+/g, '_') // Replace multiple underscores with single
                     .replace(/^_|_$/g, ''); // Remove leading/trailing underscores
    
    document.getElementById('code').value = code;
});
</script>
<?= $this->endSection() ?>