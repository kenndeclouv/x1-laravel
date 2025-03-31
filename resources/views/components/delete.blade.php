@props([
    'route',
    'message' => 'Are you sure you want to delete this item?',
    'title' => 'Delete Item',
    'icon' => 'fa-solid fa-trash-xmark',
])

<button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
    data-bs-title="{{ $title }}"
    onclick="confirmDelete('{{ $route }}', '{{ $title }}', '{{ $message }}')">
    <i class="{{ $icon }}"></i>
</button>

<script>
    function confirmDelete(route, title, message) {
        // Cek atribut data-style di elemen <html> dan fallback ke preferensi sistem
        const htmlStyle = document.documentElement.getAttribute('data-style');
        const isDarkMode = htmlStyle === 'dark' || (htmlStyle !== 'light' && window.matchMedia(
            '(prefers-color-scheme: dark)').matches);

        Swal.fire({
            title: title,
            text: message,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-danger)',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            background: isDarkMode ? '#2f3349' : '#fff',
            color: isDarkMode ? '#CFCDE4' : '#000'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = route;
                form.method = 'POST';

                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Canceled",
                    text: "You didn't delete the data :)",
                    icon: "warning",
                    background: isDarkMode ? '#2f3349' : '#fff',
                    color: isDarkMode ? '#CFCDE4' : '#000',
                    confirmButtonColor: 'var(--bs-primary)',
                    // cancelButtonColor: '#8592a3',
                });
            }
        });
    }
</script>