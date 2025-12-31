<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<style>
    .settings-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .gateway-option {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .gateway-option:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }
    
    .gateway-option.active {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }
    
    .own-gateway-fields {
        display: none;
    }
    
    .own-gateway-fields.active {
        display: block;
    }
</style>

<div class="settings-header">
    <h1><i class="fas fa-credit-card me-3"></i>Tetapan Pembayaran</h1>
    <p class="mb-0">Urus kaedah pembayaran untuk agensi anda</p>
</div>

<div class="container-fluid">
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="settings-card">
        <form method="post" action="/manager/payment-settings">
            <?= csrf_field() ?>
            
            <h3 class="mb-4"><i class="fas fa-cog me-2"></i>Pilihan Payment Gateway</h3>
            
            <!-- Option 1: Use Admin Gateway -->
            <div class="gateway-option <?= (!$agencyGateway || !$agencyGateway['use_own_gateway']) ? 'active' : '' ?>" 
                 onclick="selectGatewayType(0)">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="use_own_gateway" id="useAdminGateway" 
                           value="0" <?= (!$agencyGateway || !$agencyGateway['use_own_gateway']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="useAdminGateway">
                        <h5><i class="fas fa-shield-alt me-2" style="color: #667eea;"></i>Guna Payment Gateway Admin</h5>
                        <p class="text-muted mb-0">Pilih dari payment gateway yang telah disediakan oleh admin</p>
                    </label>
                </div>
                
                <div id="adminGatewayFields" class="mt-3 <?= (!$agencyGateway || !$agencyGateway['use_own_gateway']) ? '' : 'd-none' ?>">
                    <label class="form-label">Pilih Payment Gateway</label>
                    <select class="form-control" name="payment_gateway_id">
                        <option value="">-- Pilih Gateway --</option>
                        <?php foreach ($adminGateways as $gateway): ?>
                            <option value="<?= $gateway['id'] ?>" 
                                    <?= ($agencyGateway && $agencyGateway['payment_gateway_id'] == $gateway['id']) ? 'selected' : '' ?>>
                                <?= esc($gateway['name']) ?> - <?= esc($gateway['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Option 2: Use Own Gateway -->
            <div class="gateway-option <?= ($agencyGateway && $agencyGateway['use_own_gateway']) ? 'active' : '' ?>" 
                 onclick="selectGatewayType(1)">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="use_own_gateway" id="useOwnGateway" 
                           value="1" <?= ($agencyGateway && $agencyGateway['use_own_gateway']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="useOwnGateway">
                        <h5><i class="fas fa-building me-2" style="color: #22c55e;"></i>Guna Payment Gateway Sendiri</h5>
                        <p class="text-muted mb-0">Sediakan payment gateway anda sendiri</p>
                    </label>
                </div>
                
                <div id="ownGatewayFields" class="own-gateway-fields <?= ($agencyGateway && $agencyGateway['use_own_gateway']) ? 'active' : '' ?> mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Gateway</label>
                            <input type="text" class="form-control" name="gateway_name" 
                                   value="<?= esc($agencyGateway['gateway_name'] ?? '') ?>" 
                                   placeholder="Contoh: FPX, Stripe, PayPal">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kod Gateway</label>
                            <input type="text" class="form-control" name="gateway_code" 
                                   value="<?= esc($agencyGateway['gateway_code'] ?? '') ?>" 
                                   placeholder="Contoh: fpx, stripe">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Key</label>
                            <input type="text" class="form-control" name="api_key" 
                                   value="<?= esc($agencyGateway['api_key'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Secret</label>
                            <input type="password" class="form-control" name="api_secret" 
                                   value="<?= esc($agencyGateway['api_secret'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Merchant ID</label>
                        <input type="text" class="form-control" name="merchant_id" 
                               value="<?= esc($agencyGateway['merchant_id'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Tetapan
                </button>
                <a href="/manager/dashboard" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function selectGatewayType(type) {
    const adminOption = document.querySelector('.gateway-option:first-of-type');
    const ownOption = document.querySelector('.gateway-option:last-of-type');
    const adminFields = document.getElementById('adminGatewayFields');
    const ownFields = document.getElementById('ownGatewayFields');
    
    if (type === 0) {
        document.getElementById('useAdminGateway').checked = true;
        adminOption.classList.add('active');
        ownOption.classList.remove('active');
        adminFields.classList.remove('d-none');
        ownFields.classList.remove('active');
    } else {
        document.getElementById('useOwnGateway').checked = true;
        ownOption.classList.add('active');
        adminOption.classList.remove('active');
        adminFields.classList.add('d-none');
        ownFields.classList.add('active');
    }
}
</script>

<?= $this->endSection() ?>
