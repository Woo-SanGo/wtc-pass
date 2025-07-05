<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            overflow-x: hidden;
            background-color: #f4f6f9;
            font-size: 1.1rem; /* Bigger base font */
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2e3a59;
            color: #ffffff;
            padding-top: 1rem;
        }
        #sidebar .nav-link {
            color: #cfd2dc;
            font-size: 1.1rem;
            transition: background 0.2s, color 0.2s;
            padding: 10px 12px;
        }
        #sidebar .nav-link.active,
        #sidebar .nav-link:hover {
            background-color: #3d4d70;
            color: #ffffff;
            border-radius: 8px;
        }
        #content {
            margin-left: 250px;
            padding: 2rem;
            font-size: 1.2rem;
        }
        .btn-link {
            color: #cfd2dc;
            text-decoration: none;
        }
        .btn-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        h4 {
            color: #f0f0f0;
            font-size: 1.5rem;
        }
        .nav-icon {
            margin-right: 10px;
            font-size: 1.3rem;
        }
    </style>
</head>
<body>
    <aside id="sidebar">
        <div class="text-center mb-4">
            <h4>Admin Dashboard</h4>
        </div>
            <nav class="nav flex-column px-3">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door nav-icon"></i>Home
                </a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people nav-icon"></i>Manage Users
                </a>
                <a class="nav-link" href="{{ route('admin.adoptions.index') }}">
                    <i class="bi bi-book nav-icon"></i>Manage Adoptions
                </a>
                <a class="nav-link" href="{{ route('admin.managepet.index') }}">
                    <i class="bi bi-heart nav-icon"></i>Manage Pets
                </a>
                <a class="nav-link" href="{{ route('admin.shelters.index') }}">
                    <i class="bi bi-building nav-icon"></i>Manage Shelter
                </a>

                <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                    <i class="bi bi-bell nav-icon"></i>Notifications
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto px-3">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link p-0 text-start" style="cursor:pointer;">
                        <i class="bi bi-box-arrow-right nav-icon"></i>Logout
                    </button>
                </form>
            </nav>

    </aside>

    <main id="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
