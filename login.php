<?php
$pageTitle="Login";
require_once "header.php";
require_once "navbar.php";


?>

  <!-- Login Form -->
  <main class="container">
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
<?php
require_once "footer.php";
?>
