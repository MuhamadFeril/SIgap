<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="d-flex">
                <a href="{{ route('admin.logout') }}" class="btn btn-outline-success" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Welcome to the Admin Dashboard, {{ Auth::user()->name }}!</h1>
    </div>
</body>
</html>
