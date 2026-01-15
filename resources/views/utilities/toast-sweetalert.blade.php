<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    //  Universal SweetAlert wrapper
    function sweetalert(title, text, icon = 'info', confirmButtonText = 'OK') {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            theme: 'bootstrap-5'
        })
    }

    window.sweetalert = sweetalert;

    //sweet Toastify wrapper
    function showSweetToast(message, type = "info") {
        const icons = {
            success: "success",
            error: "error",
            warning: "warning",
            info: "info",
        };

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            theme: 'bootstrap-5',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        return Toast.fire({
            icon: icons[type] || "info",
            title: message
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        @if (session('success'))
            showSweetToast("{{ session('success') }}", "success");
        @endif

        @if (session('error'))
            showSweetToast("{{ session('error') }}", "error");
        @endif

        @if (session('info'))
            showSweetToast("{{ session('info') }}", "info");
        @endif

        @if (session('warning'))
            showSweetToast("{{ session('warning') }}", "warning");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showSweetToast("{{ $error }}", "error");
            @endforeach
        @endif
    });

    // Global Delete Handler - Listens for clicks on any element with class .delete-item
    $(document).on('click', '.delete-item', function() {
        let url = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showSweetToast(response.message, 'success');
                            // Reload DataTable if it exists
                            if ($.fn.DataTable) {
                                // Reload all initialized datatables
                                $('.dataTable').DataTable().ajax.reload(null, false);
                            } else {
                                window.location.reload();
                            }
                        } else {
                            showSweetToast(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        showSweetToast('Something went wrong!', 'error');
                    }
                });
            }
        });
    });
</script>
