<!-- Edit Modal -->
<div class="modal fade" id="editKebunModal" tabindex="-1" aria-labelledby="editKebunModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <h5 class="modal-title" id="editKebunModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kebun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form  method="POST" id="formEditKebun">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-tag me-1 text-success"></i>Nama Kebun
                        </label>
                        <input type="text"
                            name="nama"
                            class="form-control border-success"
                            id="editNama"
                            required
                            style="border-width: 2px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-map-marker-alt me-1 text-success"></i>Lokasi
                        </label>
                        <input type="text"
                            name="lokasi"
                            class="form-control border-success"
                            id="editLokasi"
                            required
                            style="border-width: 2px;">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>