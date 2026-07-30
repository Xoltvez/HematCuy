<style>
    .hematcuy-toast {
        background: rgba(15, 23, 42, 0.85) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
        padding: 0.75rem 1rem !important;
        margin-top: 1rem !important;
        margin-right: 1rem !important;
    }
    .hematcuy-toast-title {
        color: #f8fafc !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        margin-left: 0.5rem !important;
    }
    .swal2-timer-progress-bar {
        background: rgba(255, 255, 255, 0.15) !important;
        height: 3px !important;
    }
    .swal2-icon.swal2-success {
        border-color: #34d399 !important;
        color: #34d399 !important;
    }
    .swal2-icon.swal2-success [class^=swal2-success-line] {
        background-color: #34d399 !important;
    }
    .swal2-icon.swal2-success .swal2-success-ring {
        border-color: rgba(52, 211, 153, 0.3) !important;
    }
    .swal2-icon.swal2-error {
        border-color: #fb7185 !important;
        color: #fb7185 !important;
    }
    .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        background-color: #fb7185 !important;
    }
    .hematcuy-swal-popup {
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
    }
    .hematcuy-swal-title {
        color: #f8fafc !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 1.4rem !important;
        font-weight: 700 !important;
        padding-top: 1rem !important;
    }
    .hematcuy-swal-text {
        color: #94a3b8 !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 0.95rem !important;
        line-height: 1.5 !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: {
                popup: 'hematcuy-toast',
                title: 'hematcuy-toast-title'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{!! addslashes(session('success')) !!}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{!! addslashes(session('error')) !!}"
            });
        @endif
        
        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: "{!! addslashes($errors->first()) !!}"
            });
        @endif

        @if(session('show_fill_balance'))
            setTimeout(() => {
                Swal.fire({
                    title: 'Isi Saldo Awal?',
                    text: 'Selamat datang di HematCuy! Apakah Anda ingin mengisi saldo awal Anda sekarang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: 'rgba(255, 255, 255, 0.1)',
                    confirmButtonText: 'Ya, Isi Saldo',
                    cancelButtonText: 'Nanti Saja',
                    background: 'rgba(15, 23, 42, 0.95)',
                    color: '#f8fafc',
                    backdrop: 'rgba(15, 23, 42, 0.4)',
                    customClass: {
                        popup: 'hematcuy-swal-popup',
                        title: 'hematcuy-swal-title',
                        htmlContainer: 'hematcuy-swal-text'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('transactions.create') }}";
                    }
                });
            }, 800);
        @endif

        // Expose Toast globally
        window.HematCuyToast = Toast;

        // Listen to PDF/Print downloads
        document.addEventListener('click', function(event) {
            const downloadLink = event.target.closest('a[href*="/pdf"], a[href*="/export/pdf"], .btn-pdf-download');
            if (downloadLink) {
                setTimeout(() => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil di download'
                    });
                }, 1000);
            }
        });
    });
</script>
