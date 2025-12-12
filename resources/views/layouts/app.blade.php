<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? 'WarkopNet - Forum Diskusi' }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Funnel+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery (Wajib untuk Summernote) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Summernote CSS + JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!-- Summernote Theme (opsional) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <style>
        .font-utama { font-family: "Bricolage Grotesque", sans-serif; }
        .font-accent { font-family: "Funnel Sans", sans-serif; }

        
    </style>

    @livewireStyles
</head>

<body class="bg-[#FFF8F0] font-accent text-[#373737]">

    @yield('content')

    
    <script>
        $(document).ready(function() {
            if ($('#summernote').length) {
                $('#summernote').summernote({
                    placeholder: 'Tulis balasan kamu...',
                    tabsize: 2,
                    height: 180,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });
            }
        });
    </script>

<script>
function confirmDelete(formId) {
    Swal.fire({
        title: "Yakin mau hapus?",
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>

    @livewireScripts
</body>
</html>

