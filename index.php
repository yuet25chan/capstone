<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <title>Welcome to Task Master</title>
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body {
                background-image: url('https://www.toptal.com/designers/subtlepatterns/patterns/frenchstucco.png');
                background-size: cover;
                background-attachment: fixed;
                font-family: 'Playfair Display', serif;
                color: #5a5a5a;
            }
            .navbar {
                background-color: #d8bfd8;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .navbar-brand {
                font-weight: bold;
                font-size: 1.5rem;
            }
            .card {
                border: none;
                border-radius: 15px;
                background-color: #fdf5e6;
            }
            .card-header {
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                background-color: #d8bfd8;
                color: white;
            }
            .btn-primary {
                background-color: #d8bfd8;
                border-color: #d8bfd8;
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #c0a6c0;
                border-color: #c0a6c0;
            }
            .form-control:focus {
                box-shadow: 0 0 5px rgba(216, 191, 216, 0.5);
                border-color: #d8bfd8;
            }
            h2 {
                font-family: 'Playfair Display', serif;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">Task Master</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Registration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h2>Welcome to Task Master</h2>
                        </div>
                        <div class="card-body">
                            <form action='registrationProcess.php' method="post">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
