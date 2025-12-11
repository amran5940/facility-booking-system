<?= $this->extend(session('user')['role'] === 'admin' ? 'admin_layout' : 'manager_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Edit Fasiliti</h1>
    <form method="post" action="/<?= session('user')['role'] === 'admin' ? 'admin' : 'manager' ?>/facilities/<?= $facility['id'] ?>/update">
        <div class="mb-3">
            <label for="name" class="form-label"><?= lang('App.name') ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?= esc($facility['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"><?= lang('App.description') ?></label>
            <textarea class="form-control" id="description" name="description"><?= esc($facility['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $facility['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label"><?= lang('App.type') ?></label>
            <select class="form-control" id="type" name="type" required>
                <option value="public" <?= $facility['type'] == 'public' ? 'selected' : '' ?>>Awam</option>
                <option value="agency" <?= $facility['type'] == 'agency' ? 'selected' : '' ?>>Agensi</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label"><?= lang('App.status') ?></label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" <?= $facility['status'] == 'active' ? 'selected' : '' ?>><?= lang('App.active') ?></option>
                <option value="inactive" <?= $facility['status'] == 'inactive' ? 'selected' : '' ?>><?= lang('App.inactive') ?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Kapasiti</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="<?= esc($facility['capacity']) ?>">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= esc($facility['location']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Kemaskini Fasiliti</button>
        <a href="/<?= session('user')['role'] === 'admin' ? 'admin' : 'manager' ?>/facilities" class="btn btn-secondary"><?= lang('App.cancel') ?></a>
    </form>
</div>
<?= $this->endSection() ?>