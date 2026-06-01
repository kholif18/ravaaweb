<!-- resources/views/admin/products/partials/_media_picker_modal.blade.php -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-images me-2"></i> Pilih Media
                    <span id="pickerTargetBadge" class="badge bg-primary ms-2">Gambar Utama</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <ul class="nav nav-tabs nav-tabs-line px-5" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#media-library-tab">Media Library</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#upload-tab">Upload</button></li>
                </ul>
                <div class="tab-content p-5">
                    <div class="tab-pane fade show active" id="media-library-tab">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control" id="mediaSearch" placeholder="Cari media...">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchMediaLibrary()"><i class="bi bi-search"></i></button>
                        </div>
                        <div class="row g-3" id="mediaLibraryGrid">
                            <div class="col-12 text-center py-10"><div class="spinner-border text-primary"></div></div>
                        </div>
                        <nav id="mediaPagination" class="d-flex justify-content-center mt-5"></nav>
                    </div>
                    <div class="tab-pane fade" id="upload-tab">
                        <div class="text-center p-10 border border-dashed rounded">
                            <i class="bi bi-cloud-arrow-up text-muted fs-3x d-block mb-3"></i>
                            <h5 class="mb-3">Upload File Baru</h5>
                            <input type="file" id="fileUpload" class="d-none" multiple accept="image/*" onchange="handleFileSelection(this.files)">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileUpload').click()">Pilih File</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="selectionInfo" class="me-auto" style="display: none;"><span id="selectedCount">0</span> gambar dipilih</div>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="insertMediaBtn" onclick="insertSelectedMedia()" disabled>Pilih</button>
            </div>
        </div>
    </div>
</div>
