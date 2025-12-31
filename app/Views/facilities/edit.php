<?= $this->extend(session('user')['role'] === 'admin' ? 'admin_layout' : 'manager_layout') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .edit-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .edit-header h1 {
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
    }
    
    .edit-form {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    #map { 
        height: 400px; 
        width: 100%; 
        border-radius: 12px; 
        margin-bottom: 1rem;
        border: 2px solid #e9ecef;
    }
    
    .geocoder-control input { 
        padding: 0.75rem; 
        border: 2px solid #e9ecef; 
        border-radius: 8px; 
        width: 100%; 
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .image-preview-container { 
        display: flex; 
        gap: 1rem; 
        flex-wrap: wrap; 
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        min-height: 80px;
    }
    
    .image-preview { 
        position: relative; 
        width: 120px; 
        height: 120px; 
        border: 2px solid #ddd; 
        border-radius: 8px; 
        overflow: hidden; 
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .image-preview:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .image-preview img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    
    .image-preview .remove-btn { 
        position: absolute; 
        top: 4px; 
        right: 4px; 
        background: #dc3545; 
        color: white; 
        border: none; 
        border-radius: 50%; 
        width: 28px; 
        height: 28px; 
        cursor: pointer;
        font-weight: bold;
    }
    
    .image-preview .primary-badge { 
        position: absolute; 
        bottom: 5px; 
        left: 5px; 
        background: #28a745; 
        color: white; 
        padding: 4px 8px; 
        border-radius: 4px; 
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .image-preview.primary { 
        border-color: #28a745; 
        border-width: 3px;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .btn-submit {
        background: var(--success-gradient);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
    }
    
    .btn-cancel {
        background: #e9ecef;
        color: #2c3e50;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #dee2e6;
    }
</style>

<div class="container mt-4">
    <div class="edit-header">
        <h1><i class="fas fa-edit me-2"></i>Edit Fasiliti</h1>
    </div>
    
    <div class="edit-form">
        <form method="post" action="/<?= session('user')['role'] === 'admin' ? 'admin' : 'manager' ?>/facilities/<?= $facility['id'] ?>/update" enctype="multipart/form-data">
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
        <div class="mb-3">
            <label for="pricing_type" class="form-label">Jenis Harga</label>
            <select class="form-control" id="pricing_type" name="pricing_type" required>
                <option value="hourly" <?= ($facility['pricing_type'] ?? 'hourly') === 'hourly' ? 'selected' : '' ?>>Mengikut Jam (Slot)</option>
                <option value="daily" <?= ($facility['pricing_type'] ?? 'hourly') === 'daily' ? 'selected' : '' ?>>Harian</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3" id="hourly_price_field" style="display: <?= ($facility['pricing_type'] ?? 'hourly') === 'hourly' ? 'block' : 'none' ?>">
                <label for="price_per_hour" class="form-label">Harga Sejam (RM)</label>
                <input type="number" step="0.01" class="form-control" id="price_per_hour" name="price_per_hour" min="0" value="<?= esc($facility['price_per_hour'] ?? '0.00') ?>">
            </div>
            <div class="col-md-6 mb-3" id="daily_price_field" style="display: <?= ($facility['pricing_type'] ?? 'hourly') === 'daily' ? 'block' : 'none' ?>">
                <label for="price_per_day" class="form-label">Harga Sehari (RM)</label>
                <input type="number" step="0.01" class="form-control" id="price_per_day" name="price_per_day" min="0" value="<?= esc($facility['price_per_day'] ?? '0.00') ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilih Lokasi di Peta</label>
            <div class="position-relative">
                <div class="geocoder-control">
                    <input type="text" id="geocoder" class="form-control" placeholder="Cari lokasi..." />
                </div>
                <div id="map"></div>
            </div>
            <small class="text-muted">Klik pada peta untuk pilih lokasi atau gunakan carian di atas</small>
            <input type="hidden" id="latitude" name="latitude" value="<?= esc($facility['latitude'] ?? '') ?>">
            <input type="hidden" id="longitude" name="longitude" value="<?= esc($facility['longitude'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Fasiliti (Maksimum 5)</label>
            <div id="existingImages" class="image-preview-container"></div>
            <input type="file" class="form-control mt-2" id="facility_images" name="facility_images[]" multiple accept="image/*">
            <small class="text-muted">Klik pada gambar untuk jadikan gambar utama. Total maksimum 5 gambar.</small>
            <div id="imagePreviewContainer" class="image-preview-container"></div>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e9ecef;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save me-2"></i>Kemaskini Fasiliti
            </button>
            <a href="/<?= session('user')['role'] === 'admin' ? 'admin' : 'manager' ?>/facilities" class="btn-cancel">
                <i class="fas fa-times me-2"></i><?= lang('App.cancel') ?>
            </a>
        </div>
        </form>
    </div>
</div>

<script>
// Define functions globally so onclick handlers can access them
const userRole = '<?= session('user')['role'] ?? 'manager' ?>';
const baseUrl = userRole === 'admin' ? '/admin' : '/manager';

function setPrimaryExisting(imageId) {
    fetch(`${baseUrl}/facilities/images/${imageId}/set-primary`, {
        method: 'POST',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(() => location.reload());
}

function removeExistingImage(imageId) {
    if (!confirm('Padam gambar ini?')) return;
    fetch(`${baseUrl}/facilities/images/${imageId}/delete`, {
        method: 'POST',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(() => location.reload());
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Loading map...');
    
    // Kedah coordinates and bounds
    const kedahBounds = L.latLngBounds(
        L.latLng(5.5, 99.6),  // Southwest
        L.latLng(6.7, 100.8)  // Northeast
    );

    const existingLat = parseFloat('<?= $facility['latitude'] ?? '' ?>');
    const existingLng = parseFloat('<?= $facility['longitude'] ?? '' ?>');
    const hasExisting = !isNaN(existingLat) && !isNaN(existingLng);
    
    console.log('Existing coordinates:', existingLat, existingLng, 'Has existing:', hasExisting);

    let map = L.map('map', {
        center: hasExisting ? [existingLat, existingLng] : [6.1184, 100.3681],
        zoom: hasExisting ? 15 : 10,
        maxBounds: kedahBounds,
        maxBoundsViscosity: 1.0,
        minZoom: 9
    });

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    let marker = null;

    if (hasExisting) {
        marker = L.marker([existingLat, existingLng], {
            draggable: false,
            title: 'Lokasi Semasa'
        }).addTo(map);
        
        marker.bindPopup('<b>Lokasi Semasa Fasiliti</b><br>' + 
                        'Lat: ' + existingLat.toFixed(6) + '<br>' +
                        'Lng: ' + existingLng.toFixed(6)).openPopup();
        
        document.getElementById('latitude').value = existingLat.toFixed(6);
        document.getElementById('longitude').value = existingLng.toFixed(6);
        
        console.log('Marker created at:', existingLat, existingLng);
    } else {
        // Set default Kedah center coordinates
        document.getElementById('latitude').value = '6.118400';
        document.getElementById('longitude').value = '100.368100';
        console.log('No existing location, using default');
    }
    
    setTimeout(function() {
        map.invalidateSize();
        console.log('Map size invalidated');
    }, 100);

    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
        
        marker.bindPopup('<b>Lokasi Baru</b><br>' + 
                        'Lat: ' + lat.toFixed(6) + '<br>' +
                        'Lng: ' + lng.toFixed(6)).openPopup();
        
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('location').value = data.display_name;
            }
        });
});

const geocoderInput = document.getElementById('geocoder');
let searchTimeout;

geocoderInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;
    
    if (query.length < 3) return;
    
    searchTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=my&bounded=1&viewbox=99.6,6.7,100.8,5.5`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const result = data[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    
                    map.setView([lat, lng], 15);
                    
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng]).addTo(map);
                    }
                    
                    document.getElementById('latitude').value = lat.toFixed(8);
                    document.getElementById('longitude').value = lng.toFixed(8);
                    document.getElementById('location').value = result.display_name;
                }
            });
    }, 500);
});

// Auto-search when name field loses focus
document.getElementById('name').addEventListener('blur', function() {
    const facilityName = this.value.trim();
    
    if (facilityName.length < 3) return;
    
    // Search for facility name in Kedah
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(facilityName + ' Kedah')}&countrycodes=my&bounded=1&viewbox=99.6,6.7,100.8,5.5`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                const result = data[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);
                
                map.setView([lat, lng], 15);
                
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
                
                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);
                document.getElementById('location').value = result.display_name;
            }
        })
        .catch(err => console.log('Geocoding error:', err));
    });

    // Load existing images
    const existingImagesContainer = document.getElementById('existingImages');
    const imagesData = <?= json_encode($images ?? []) ?>;
    console.log('Loading images:', imagesData);
    
    const existingImages = imagesData.map(function(img) {
        return {id: img.id, is_primary: img.is_primary};
    });

    existingImages.forEach((img, index) => {
        const preview = document.createElement('div');
        preview.className = 'image-preview' + (img.is_primary ? ' primary' : '');
        preview.innerHTML = `
            <img src="/images/facility/${img.id}" alt="Facility Image">
            <button type="button" class="remove-btn" onclick="removeExistingImage(${img.id})">&times;</button>
            ${img.is_primary ? '<span class="primary-badge">Utama</span>' : ''}
        `;
        preview.onclick = (ev) => {
            if (!ev.target.classList.contains('remove-btn')) {
                setPrimaryExisting(img.id);
            }
        };
        existingImagesContainer.appendChild(preview);
    });

    // Image upload preview
    const imageInput = document.getElementById('facility_images');
    const previewContainer = document.getElementById('imagePreviewContainer');
    let selectedFiles = [];
    let primaryIndex = 0;

    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const existingCount = document.querySelectorAll('#existingImages .image-preview').length;
        
        if (files.length + existingCount > 5) {
            alert('Maksimum 5 gambar sahaja (termasuk gambar sedia ada)');
            return;
        }
        
        selectedFiles = files;
        previewContainer.innerHTML = '';
        
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'image-preview' + (index === primaryIndex ? ' primary' : '');
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="removeImage(${index})">&times;</button>
                    ${index === primaryIndex ? '<span class="primary-badge">Utama</span>' : ''}
                `;
                preview.onclick = (ev) => {
                    if (!ev.target.classList.contains('remove-btn')) {
                        setPrimaryImage(index);
                    }
                };
                previewContainer.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    });

    function setPrimaryImage(index) {
        primaryIndex = index;
        imageInput.dispatchEvent(new Event('change'));
    }

    function removeImage(index) {
        selectedFiles.splice(index, 1);
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
        imageInput.dispatchEvent(new Event('change'));
    }
    
    // Pricing type toggle
    document.getElementById('pricing_type').addEventListener('change', function() {
        const hourlyField = document.getElementById('hourly_price_field');
        const dailyField = document.getElementById('daily_price_field');
        
        if (this.value === 'hourly') {
            hourlyField.style.display = 'block';
            dailyField.style.display = 'none';
            document.getElementById('price_per_hour').required = true;
            document.getElementById('price_per_day').required = false;
        } else {
            hourlyField.style.display = 'none';
            dailyField.style.display = 'block';
            document.getElementById('price_per_hour').required = false;
            document.getElementById('price_per_day').required = true;
        }
    });
});
</script>
<?= $this->endSection() ?>