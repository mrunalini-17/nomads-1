<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads</title>
    <link rel="icon" href="{{ asset('assets/img/logoicon.png') }}" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E3F2FD; /* Light blue background */
        }
        .card {
            background-color: #FFFFFF;
            border-color: #90CAF9; /* Light blue border */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #42A5F5; /* Medium blue header */
            color: #fff;
            border-radius: 10px 10px 0 0;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #42A5F5;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2196F3;
        }
        .btn-link {
            color: #42A5F5;
        }
        .btn-link:hover {
            color: #1E88E5;
        }
        .form-group label {
            font-weight: bold;
        }
        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <!-- Form Column -->
                            <div class="card-body p-5">
                                <img src="{{asset('assets/img/nomadlogo.png')}}" alt="Logo" style="padding-bottom: 10px;">
                                <h2 class="text-center mb-4">Sign In</h2>
                                <form method="POST" action="{{ route('login-store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autofocus>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Sign In
                                        </button>
                                    </div>

                                    <div class="form-group text-center">
                                        <a href="{{ route('register') }}" class="btn btn-link">Don't have an account? Register</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-md-block">
                            <!-- Image Column -->
                            <img src="{{asset('assets/img/Group 309.png')}}" alt="Login Image" class="card-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
