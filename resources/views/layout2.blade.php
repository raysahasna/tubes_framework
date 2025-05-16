<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Masukkan header dari layouts -->
    @include('layout/header')
</head>
<body>
    Selamat Datang {{ $nama }}
    <hr>

    <!-- Masukkan untuk template konten -->
    @yield('konten')
    
    <hr>
    <!-- Masukkan footer dari layouts -->
    @include('layout/footer')
</body>
</html>
