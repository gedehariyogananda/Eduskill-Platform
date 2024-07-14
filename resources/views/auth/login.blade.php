<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Authenticate System | Eduskill</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}" />
    <link rel="icon" type="image/png" sizes="2x3" href="assets/images/eduskill.png">
    <style>
        .btn-primary {
            background-color: #FFA62F;
            border-color: #FFA62F;
        }

        .btn-primary:hover {
            background-color: #fea939;
            border-color: #FFA62F;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row text-center mt-3">
            <div id="auth-left">
                <br>
                <img class="w-25" src="{{ asset('assets/images/eduskill.png') }}" alt="">
                <br><br>

                <div class="container text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            @if (Session::has('error'))
                            <div class="alert alert-danger">
                                <strong>{{ Session::get('error') }}</strong>
                            </div>
                            @endif
                            <form action="{{ route('loginPost') }}" method="POST">
                                @csrf
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="email" class="form-control form-control-lg" placeholder="Email"
                                        name="email" />
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control-lg" placeholder="Password"
                                        name="password" />
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    @error('password')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-block btn-l shadow-lg mt-3" type="submit">
                                    Log in
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session()->has('success'))
<script>
    Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            showConfirmButton: true,
            timer: 2000
        });
</script>
@endif

</html>