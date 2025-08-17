<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenaeum - @yield('title', 'Library System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f6f3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #4B3832; /* Warm brown for library vibes */
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }
        footer {
            background: #4B3832;
            color: #f8f6f3;
            padding: 15px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-book-half me-2"></i> Athenaeum
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-sm btn-outline-light ms-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i> Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <small>&copy; {{ date('Y') }} Athenaeum Library System. All Rights Reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
