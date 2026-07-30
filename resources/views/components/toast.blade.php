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
                        Swal.fire({
                            title: 'Masukkan Saldo Awal',
                            html: `
                                <div style="text-align: left; margin-top: 1rem;">
                                    <div style="margin-bottom: 1rem;">
                                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 0.5rem;">Nominal Saldo (Rp)</label>
                                        <input type="text" id="swal_amount_display" placeholder="Misal: 100.000" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.15); background: rgba(0,0,0,0.2); color: #fff; font-size: 1.1rem; font-weight: 600; outline: none; box-sizing: border-box;" inputmode="numeric">
                                        <input type="hidden" id="swal_amount">
                                    </div>
                                    <div style="margin-bottom: 0.5rem;">
                                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 500; display: block; margin-bottom: 0.5rem;">Sumber Dana</label>
                                        <select id="swal_account" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.15); background: #0f172a; color: #fff; font-size: 1rem; outline: none; box-sizing: border-box;">
                                            <option value="cash">Tunai (Dompet)</option>
                                            <option value="bank">Bank / E-Wallet</option>
                                            @if(auth()->check() && auth()->user()->accounts->count() > 0)
                                                @foreach(auth()->user()->accounts as $acc)
                                                    <option value="{{ $acc->name }}">{{ $acc->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonColor: '#10b981',
                            cancelButtonColor: 'rgba(255, 255, 255, 0.1)',
                            confirmButtonText: 'Simpan Saldo',
                            cancelButtonText: 'Batal',
                            background: 'rgba(15, 23, 42, 0.95)',
                            color: '#f8fafc',
                            backdrop: 'rgba(15, 23, 42, 0.4)',
                            customClass: {
                                popup: 'hematcuy-swal-popup',
                                title: 'hematcuy-swal-title',
                                htmlContainer: 'hematcuy-swal-text'
                            },
                            didOpen: () => {
                                const amountDisplay = Swal.getPopup().querySelector('#swal_amount_display');
                                const amountHidden = Swal.getPopup().querySelector('#swal_amount');
                                amountDisplay.focus();
                                amountDisplay.addEventListener('input', function(e) {
                                    let value = this.value.replace(/[^0-9]/g, '');
                                    amountHidden.value = value;
                                    if(value) {
                                        this.value = parseInt(value, 10).toLocaleString('id-ID');
                                    } else {
                                        this.value = '';
                                    }
                                });
                            },
                            preConfirm: () => {
                                const amount = Swal.getPopup().querySelector('#swal_amount').value;
                                const account = Swal.getPopup().querySelector('#swal_account').value;
                                if (!amount || parseInt(amount, 10) <= 0) {
                                    Swal.showValidationMessage(`Silakan masukkan nominal saldo awal yang valid!`);
                                    return false;
                                }
                                return { amount: amount, account: account };
                            }
                        }).then((inputResult) => {
                            if (inputResult.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = "{{ route('transactions.store') }}";
                                
                                const csrfInput = document.createElement('input');
                                csrfInput.type = 'hidden';
                                csrfInput.name = '_token';
                                csrfInput.value = "{{ csrf_token() }}";
                                form.appendChild(csrfInput);

                                const titleInput = document.createElement('input');
                                titleInput.type = 'hidden';
                                titleInput.name = 'title';
                                titleInput.value = 'Saldo Awal';
                                form.appendChild(titleInput);

                                const amountInput = document.createElement('input');
                                amountInput.type = 'hidden';
                                amountInput.name = 'amount';
                                amountInput.value = inputResult.value.amount;
                                form.appendChild(amountInput);

                                const typeInput = document.createElement('input');
                                typeInput.type = 'hidden';
                                typeInput.name = 'type';
                                typeInput.value = 'income';
                                form.appendChild(typeInput);

                                const accountInput = document.createElement('input');
                                accountInput.type = 'hidden';
                                accountInput.name = 'account';
                                accountInput.value = inputResult.value.account;
                                form.appendChild(accountInput);

                                const categoryInput = document.createElement('input');
                                categoryInput.type = 'hidden';
                                categoryInput.name = 'category';
                                categoryInput.value = 'Gaji';
                                form.appendChild(categoryInput);

                                const descInput = document.createElement('input');
                                descInput.type = 'hidden';
                                descInput.name = 'description';
                                descInput.value = 'Mengisi saldo awal saat pendaftaran akun baru.';
                                form.appendChild(descInput);

                                const dateInput = document.createElement('input');
                                dateInput.type = 'hidden';
                                dateInput.name = 'date';
                                dateInput.value = new Date().toISOString().slice(0, 10);
                                form.appendChild(dateInput);

                                const timeInput = document.createElement('input');
                                timeInput.type = 'hidden';
                                timeInput.name = 'time';
                                timeInput.value = new Date().toTimeString().slice(0, 5);
                                form.appendChild(timeInput);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
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
