@extends('admin.layouts.app')

@section('page-title', 'FAQ Management')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}"
           class="text-muted text-hover-primary">
            Dashboard
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted text-hover-primary">
            Layanan Page
        </a>
    </li>

    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>

    <li class="breadcrumb-item text-dark">
        FAQ Management
    </li>
@endsection

@section('content')
<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>FAQ (Frequently Asked Questions)</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                    <i class="bi bi-plus-circle fs-2"></i> Tambah FAQ Baru
                </button>
            </div>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--begin::Card body-->
    <div class="card-body pt-0">
        
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5 mb-10">
            <i class="bi bi-info-circle fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-info">Informasi FAQ</h4>
                <span>Kelola pertanyaan yang sering diajukan di halaman Layanan. FAQ akan ditampilkan di bagian bawah halaman.</span>
            </div>
        </div>
        <!--end::Alert-->
        
        <!--begin::FAQ List-->
        <div class="accordion" id="faqAccordion">
            
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <div class="accordion-header" id="faqHeading1">
                    <div class="accordion-button d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                        <div class="d-flex align-items-center">
                            <span class="me-3">1</span>
                            <span>Berapa lama waktu pengerjaan untuk desain logo?</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="editFaq(1)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFaq(1)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Waktu pengerjaan desain logo biasanya membutuhkan 3-7 hari kerja, tergantung kompleksitas dan jumlah revisi yang dibutuhkan. Untuk paket prioritas, waktu pengerjaan bisa dipercepat menjadi 1-3 hari kerja.</p>
                        <div class="text-muted fs-7 mt-3">
                            <i class="bi bi-clock me-1"></i> Terakhir diperbarui: 15 Nov 2023
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <div class="accordion-header" id="faqHeading2">
                    <div class="accordion-button d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        <div class="d-flex align-items-center">
                            <span class="me-3">2</span>
                            <span>Apa perbedaan cetak offset dan digital printing?</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="editFaq(2)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFaq(2)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Cetak offset cocok untuk jumlah besar (minimal 500 lembar) dengan biaya per unit lebih murah dan kualitas warna yang konsisten. Digital printing cocok untuk jumlah kecil (10-500 lembar) dengan biaya setup lebih murah dan waktu pengerjaan lebih cepat.</p>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <div class="accordion-header" id="faqHeading3">
                    <div class="accordion-button d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        <div class="d-flex align-items-center">
                            <span class="me-3">3</span>
                            <span>Apakah bisa membuat ATK dengan logo perusahaan custom?</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="editFaq(3)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFaq(3)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Ya, kami menyediakan layanan pembuatan ATK custom dengan logo perusahaan. Minimal order bervariasi tergantung jenis produk, mulai dari 50 pcs untuk pulpen custom hingga 100 pcs untuk notebook custom.</p>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <div class="accordion-header" id="faqHeading4">
                    <div class="accordion-button d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        <div class="d-flex align-items-center">
                            <span class="me-3">4</span>
                            <span>Apakah menyediakan layanan pengiriman?</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="editFaq(4)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFaq(4)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Ya, kami menyediakan layanan pengiriman ke seluruh Indonesia. Untuk area tertentu dalam kota, kami memberikan gratis ongkos kirim dengan minimal order tertentu. Biaya pengiriman luar kota disesuaikan dengan kurir yang dipilih.</p>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <div class="accordion-header" id="faqHeading5">
                    <div class="accordion-button d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                        <div class="d-flex align-items-center">
                            <span class="me-3">5</span>
                            <span>Bagaimana cara melakukan pembayaran?</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="editFaq(5)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteFaq(5)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Kami menerima pembayaran melalui transfer bank, virtual account, e-wallet, dan tunai di tempat. Untuk proyek bernilai tinggi, biasanya kami menerapkan pembayaran bertahap: 50% di awal dan 50% sebelum pengiriman.</p>
                    </div>
                </div>
            </div>
            
        </div>
        <!--end::FAQ List-->
        
        <!--begin::Empty State-->
        <div id="emptyFaqState" class="text-center py-10" style="display: none;">
            <i class="bi bi-question-circle fs-2hx text-gray-400 mb-5"></i>
            <h3 class="text-gray-600 mb-3">Belum ada FAQ</h3>
            <p class="text-muted mb-6">Tambahkan FAQ pertama Anda untuk membantu pengunjung.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="bi bi-plus-circle me-2"></i> Tambah FAQ Pertama
            </button>
        </div>
        <!--end::Empty State-->
        
    </div>
    <!--end::Card body-->
    
    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-between py-6 px-9">
        <div class="text-muted">
            <span id="faqCount">5</span> FAQ tersedia
        </div>
        <div>
            <button type="button" class="btn btn-light me-3" onclick="reorderFaqs()">
                <i class="bi bi-arrow-down-up me-2"></i> Atur Ulang Urutan
            </button>
            <button type="button" class="btn btn-primary" onclick="saveAllFaqs()">
                <i class="bi bi-save me-2"></i> Simpan Perubahan
            </button>
        </div>
    </div>
    <!--end::Card footer-->
    
</div>
<!--end::Card-->

<!--begin::Modal: Add FAQ-->
<div class="modal fade" tabindex="-1" id="addFaqModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFaqForm">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Tambah FAQ Baru</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x fs-2"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-10">
                        <label class="form-label required">Pertanyaan</label>
                        <input type="text" class="form-control" name="question" placeholder="Masukkan pertanyaan" required />
                    </div>
                    <div class="mb-10">
                        <label class="form-label required">Jawaban</label>
                        <textarea class="form-control" name="answer" rows="4" placeholder="Masukkan jawaban" required></textarea>
                        <div class="text-muted fs-7 mt-1">Gunakan bahasa yang jelas dan informatif.</div>
                    </div>
                    <div class="mb-10">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category">
                            <option value="">Semua Kategori</option>
                            <option value="design">Desain Grafis</option>
                            <option value="printing">Percetakan</option>
                            <option value="atk">ATK</option>
                            <option value="merchandise">Merchandise</option>
                            <option value="digital">Digital Printing</option>
                            <option value="general">Umum</option>
                        </select>
                    </div>
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="active" value="1" id="faq_active" checked />
                        <label class="form-check-label" for="faq_active">
                            Tampilkan di halaman
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal: Add FAQ-->

<!--begin::Modal: Edit FAQ-->
<div class="modal fade" tabindex="-1" id="editFaqModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editFaqForm">
                @csrf
                <input type="hidden" name="faq_id" id="edit_faq_id">
                <div class="modal-header">
                    <h3 class="modal-title">Edit FAQ</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x fs-2"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal: Edit FAQ-->
@endsection

@push('scripts')
<script>
    // Add FAQ
    document.getElementById('addFaqForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const question = this.querySelector('input[name="question"]').value;
        const answer = this.querySelector('textarea[name="answer"]').value;
        
        if (!question || !answer) {
            Swal.fire({
                text: "Pertanyaan dan jawaban harus diisi!",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return;
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addFaqModal'));
        modal.hide();
        
        // Show success
        Swal.fire({
            text: "FAQ berhasil ditambahkan!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        }).then(() => {
            // Reset form
            this.reset();
            // Reload page or update list
            location.reload();
        });
    });
    
    // Edit FAQ
    function editFaq(id) {
        // In real app, fetch data from API
        const faqData = {
            1: {
                question: "Berapa lama waktu pengerjaan untuk desain logo?",
                answer: "Waktu pengerjaan desain logo biasanya membutuhkan 3-7 hari kerja, tergantung kompleksitas dan jumlah revisi yang dibutuhkan. Untuk paket prioritas, waktu pengerjaan bisa dipercepat menjadi 1-3 hari kerja.",
                category: "design",
                active: true
            },
            2: {
                question: "Apa perbedaan cetak offset dan digital printing?",
                answer: "Cetak offset cocok untuk jumlah besar (minimal 500 lembar) dengan biaya per unit lebih murah dan kualitas warna yang konsisten. Digital printing cocok untuk jumlah kecil (10-500 lembar) dengan biaya setup lebih murah dan waktu pengerjaan lebih cepat.",
                category: "printing",
                active: true
            }
        };
        
        const data = faqData[id] || {
            question: "Pertanyaan FAQ",
            answer: "Jawaban FAQ",
            category: "",
            active: true
        };
        
        // Set form values
        document.getElementById('edit_faq_id').value = id;
        const form = document.getElementById('editFaqForm');
        form.querySelector('input[name="question"]').value = data.question;
        form.querySelector('textarea[name="answer"]').value = data.answer;
        form.querySelector('select[name="category"]').value = data.category;
        form.querySelector('input[name="active"]').checked = data.active;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('editFaqModal'));
        modal.show();
    }
    
    // Delete FAQ
    function deleteFaq(id) {
        Swal.fire({
            title: "Hapus FAQ?",
            text: "FAQ akan dihapus permanen dari halaman Layanan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // In real app, call API to delete
                Swal.fire({
                    text: "FAQ berhasil dihapus!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    // Reload or remove from DOM
                    location.reload();
                });
            }
        });
    }
    
    // Save all FAQs
    function saveAllFaqs() {
        Swal.fire({
            title: "Simpan Perubahan?",
            text: "Semua perubahan pada FAQ akan disimpan.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                const saveButton = event.target;
                const originalText = saveButton.innerHTML;
                saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                saveButton.disabled = true;
                
                setTimeout(() => {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    
                    Swal.fire({
                        text: "Semua FAQ berhasil disimpan!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, 1000);
            }
        });
    }
    
    // Reorder FAQs (sortable)
    function reorderFaqs() {
        Swal.fire({
            title: "Atur Ulang Urutan FAQ",
            text: "Drag and drop FAQ untuk mengatur urutan tampilan.",
            icon: "info",
            buttonsStyling: false,
            confirmButtonText: "Mulai Atur Ulang",
            showCancelButton: true,
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // In real app, implement drag & drop sorting
                // For now, show instruction
                Swal.fire({
                    text: "Fitur drag & drop akan diimplementasikan di versi selanjutnya.",
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
</script>
@endpush