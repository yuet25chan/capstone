<?php
$pageTitle='Contact Us';
require_once "header.php";
require_once "navbar.php";

?>
<div class="container">
<div class="row">
  <div class="col-md-12">
    <h1>Contact Us</h1>
    <h2>Reach the Task Master team directly.</h2>

    <div class="row mt-3">
      <!-- Email card -->
      <div class="col-md-6 mb-3">
        <div class="form-container">
          <p class="mb-2"><i class="fa-regular fa-envelope"></i> <strong>Email</strong></p>
          <p class="mb-2">We typically reply within 1–2 business days.</p>
          <a class="btn btn-lavender" href="mailto:support@taskmaster.local">
            Email support@taskmaster.local
          </a>
        </div>
      </div>

      <!-- Phone card -->
      <div class="col-md-6 mb-3">
        <div class="form-container">
          <p class="mb-2"><i class="fa-solid fa-phone"></i> <strong>Phone</strong></p>
          <p class="mb-2">Mon–Fri, 9:00 AM – 5:00 PM</p>
          <a class="btn btn-info" href="tel:+15555551234">
            Call +1 (555) 555-1234
          </a>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <p><strong>Hours:</strong> Mon–Fri, 9:00 AM – 5:00 PM (ET)</p>
      <p><strong>Address:</strong> (Optional) Add your office address here.</p>
    </div>
  </div>
</div>
</div>
<?php
require_once "footer.php";

?>