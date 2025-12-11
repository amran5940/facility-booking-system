<?= $this->extend('manager_layout') ?>

<?= $this->section('content') ?>
<h2>Tambah Fasiliti</h2>

<form method="post" action="/manager/facilities">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label"><?= lang('App.name') ?></label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label"><?= lang('App.description') ?></label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label"><?= lang('App.type') ?></label>
        <select class="form-control" id="type" name="type" required>
            <option value="public">Awam</option>
            <option value="agency">Agensi</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Kapasiti</label>
        <input type="number" class="form-control" id="capacity" name="capacity">
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Lokasi</label>
        <input type="text" class="form-control" id="location" name="location">
    </div>
    <button type="submit" class="btn btn-primary">Cipta Fasiliti</button>
    <a href="/manager/facilities" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
</form>
<?= $this->endSection() ?>