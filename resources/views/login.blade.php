<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>MRMFX OFFICIAL</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />

  <!-- Google Font Orbitron -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('images/logos/motocross.png') }}" width="180" alt="Motocross Logo">
                  <p class="fw-bold fs-5 mb-0 mt-2" style="color: black; font-family: 'Orbitron', sans-serif;">MRMFX OFFICIAL</p>
                </a>

                <!-- Alert for errors -->
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Username</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>

                  <!-- Login Button -->
                  <button type="submit" class="btn btn-secondary w-100 py-8 fs-4 mb-4 rounded-2"
                    style="background-color: #b0b0b0; border: none;">Login</button>

                  <!-- Optional: Additional Actions -->
                  <div class="d-flex align-items-center justify-content-center">
                    {{-- Tambahkan opsi register jika diperlukan --}}
                    {{-- <p class="fs-6 mb-0 fw-normal">Belum punya akun?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ url('/register') }}">Daftar</a> --}}
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
