<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Task Master</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #ffffff;
         font-family: 'Playfair Display', serif;
   
    }

    .navbar {
      background-color: #d6bedb !important;
    }

    .navbar-brand,
    .nav-link {
      color: white !important;
      font-weight: bold;
       font-size: 1.5rem;
    }

    .form-container {
      background-color: #fff3e6;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
      font-family: 'Playfair Display', serif;
      background-color: #d6bedb;
      color: white;
      padding: 1rem;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      text-align: center;
      margin: -2rem -2rem 1.5rem -2rem;
    }

    .btn-lavender {
      background-color: #d6bedb;
      color: white;
      border: none;
    }

    .btn-lavender:hover {
      background-color: #c4aacd;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Task Master</a>
    </div>
  </nav>

  <!-- Login Form -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-container">
          <h2>Login</h2>
          <form action="loginProcess.php" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-lavender w-100">Login</button>
          </form>
          <p class="mt-3 text-center">
            Don’t have an account? <a href="./index.php">Register here</a>.
          </p>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
