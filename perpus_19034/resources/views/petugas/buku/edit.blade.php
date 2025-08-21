@extends('layout')

@section('perpus')

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-edit me-2"></i> Edit Data Buku</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <h5 class="alert-heading fw-medium mb-2"><i class="fas fa-exclamation-circle me-2"></i>Error Validasi</h5>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Judul Buku Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Judul Buku <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-heading text-primary"></i></span>
                                <input type="text" 
                                       name="judul" 
                                       class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                       value="{{ old('judul', $buku->judul) }}" 
                                       required 
                                       placeholder="Masukkan Judul Buku">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Penulis Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Penulis <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user-edit text-primary"></i></span>
                                <input type="text" 
                                       name="penulis" 
                                       class="form-control form-control-lg @error('penulis') is-invalid @enderror" 
                                       value="{{ old('penulis', $buku->penulis) }}" 
                                       required 
                                       placeholder="Masukkan Nama Penulis">
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Penerbit Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Penerbit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-building text-primary"></i></span>
                                <input type="text" 
                                       name="penerbit" 
                                       class="form-control form-control-lg @error('penerbit') is-invalid @enderror" 
                                       value="{{ old('penerbit', $buku->penerbit) }}" 
                                       required 
                                       placeholder="Masukkan Nama Penerbit">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tahun Terbit Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Tahun Terbit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-primary"></i></span>
                                <input type="number" 
                                       name="tahun_terbit" 
                                       class="form-control form-control-lg @error('tahun_terbit') is-invalid @enderror" 
                                       value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                                       required 
                                       placeholder="Masukkan Tahun Terbit">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kategori Buku Field - Enhanced Design -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Kategori Buku <span class="text-danger">*</span></label>
                            @if($kategori->count() > 0)
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($kategori as $item)
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input @error('kategori') is-invalid @enderror" 
                                                   type="checkbox" 
                                                   name="kategori[]" 
                                                   value="{{ $item->id }}" 
                                                   id="kategori{{ $item->id }}"
                                                   {{ in_array($item->id, old('kategori', $buku->kategoribukus->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label shadow-sm" for="kategori{{ $item->id }}">
                                                <span class="badge-category">{{ $item->nama_kategori }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('kategori')
                                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="alert alert-warning mb-0 rounded-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                                        <div>
                                            <h6 class="fw-medium mb-1">Peringatan</h6>
                                            <p class="mb-0">Belum ada kategori buku. Silakan tambahkan kategori terlebih dahulu.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Cover Buku Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Cover Buku</label>
                            
                            @if ($buku->cover)
                                <div class="mb-3">
                                    <p class="text-muted mb-2">Cover saat ini:</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('covers/' . $buku->cover) }}" 
                                             alt="Current Cover" 
                                             class="img-thumbnail shadow-sm" 
                                             style="max-height: 150px; width: auto;">
                                        <div class="file-upload-wrapper flex-grow-1">
                                            <input type="file" 
                                                   name="cover" 
                                                   class="form-control @error('cover') is-invalid @enderror" 
                                                   accept="image/*" 
                                                   id="coverUpload">
                                            <label for="coverUpload" class="file-upload-label">
                                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                                <span>Ganti cover buku</span>
                                            </label>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Kosongkan jika tidak ingin mengubah cover. Format: JPG/PNG, maks. 2MB
                                            </small>
                                            <div class="preview-container mt-3 d-none">
                                                <img id="coverPreview" src="#" alt="Preview Cover" class="img-thumbnail" style="max-width: 200px; display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="file-upload-wrapper">
                                    <input type="file" 
                                           name="cover" 
                                           class="form-control @error('cover') is-invalid @enderror" 
                                           accept="image/*" 
                                           id="coverUpload">
                                    <label for="coverUpload" class="file-upload-label">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                        <span>Pilih file cover buku</span>
                                    </label>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Upload cover buku (opsional). Format: JPG/PNG, maks. 2MB
                                    </small>
                                    <div class="preview-container mt-3 d-none">
                                        <img id="coverPreview" src="#" alt="Preview Cover" class="img-thumbnail" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            @endif
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('buku.index') }}" class="btn btn-action btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-action btn-save">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --danger-color: #dc3545;
        --border-radius: 0.5rem;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }
    
    /* Card Styling */
    .card {
        border: none;
        transition: var(--transition);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }
    
    /* Form Elements */
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
    }
    
    .form-control-lg {
        padding: 0.85rem 1.2rem;
    }
    
    .input-group-text {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: var(--primary-color);
    }
    
    /* Checkbox Styling */
    .form-check-custom .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
    }
    
    .form-check-custom .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .badge-category {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: #f1f5f9;
        border-radius: 50px;
        color: #334155;
        font-size: 0.85rem;
        transition: var(--transition);
        cursor: pointer;
    }
    
    .form-check-input:checked + .form-check-label .badge-category {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
    }
    
    /* File Upload Styling */
    .file-upload-wrapper {
        position: relative;
    }
    
    .file-upload-label {
        display: block;
        padding: 1.2rem;
        border: 2px dashed #e2e8f0;
        border-radius: var(--border-radius);
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        color: #64748b;
    }
    
    .file-upload-label:hover {
        border-color: var(--primary-color);
        background-color: #f8fafc;
    }
    
    #coverUpload {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--box-shadow);
    }
    
    .btn-cancel {
        background-color: white;
        color: var(--secondary-color);
        border: 1px solid #e2e8f0;
    }
    
    .btn-cancel:hover {
        background-color: #f1f5f9;
        color: #4b5563;
    }
    
    .btn-save {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }
    
    .btn-save:hover {
        background-color: var(--primary-hover);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Alert Styling */
    .alert {
        border-radius: var(--border-radius);
        padding: 1rem 1.25rem;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border-color: #fecaca;
        color: #b91c1c;
    }
    
    .alert-warning {
        background-color: #fef3c7;
        border-color: #fde68a;
        color: #92400e;
    }
    
    /* Image Thumbnail */
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        max-width: 100%;
        height: auto;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .btn-action {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .file-upload-label {
            padding: 1rem;
        }
    }
</style>

<script>
    // Cover image preview functionality
    document.getElementById('coverUpload')?.addEventListener('change', function(e) {
        const previewContainer = document.querySelector('.preview-container');
        const previewImage = document.getElementById('coverPreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
                previewImage.src = event.target.result;
                previewImage.style.display = 'block';
                previewContainer?.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '#';
            previewImage.style.display = 'none';
            previewContainer?.classList.add('d-none');
        }
    });
    
    // Form validation
    (function() {
        'use strict';
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>
@endsection