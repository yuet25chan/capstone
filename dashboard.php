<?php
session_start();
require 'db_credentials.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


$username = $_SESSION['username'];
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
/* Match index.php font */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

body{
  background:#ffffff;
  font-family:'Playfair Display', serif;
}

/* ================= NAVBAR (lavender, like index.php) ================= */
.navbar{
  background-color:#d6bedb !important;
  box-shadow:0 4px 6px rgba(0,0,0,.1);
  border:none;
  border-radius:0;
  margin:0 0 16px 0;  /* no outer gap, small bottom space */
}

/* keep a small gutter on both sides of the bar */
.navbar .container,
.navbar .container-fluid{
  padding-left:12px !important;
  padding-right:12px !important;
}

/* brand + links */
.navbar .navbar-brand{
  color:#fff !important;
  font-weight:bold;
  font-size:1.5rem;
  margin-left:0 !important;      /* cancel BS3 negative offset */
  padding-left:16px !important;  /* <-- inner space before “Task Master” */
  padding-right:8px;             /* optional symmetry */
}
.navbar .nav-link,
.navbar .navbar-nav>li>a{
  color:#fff !important;
  font-weight:bold;
}
.navbar .nav-link:hover,
.navbar .navbar-nav>li>a:hover{
  opacity:.9;
  text-decoration:underline;
}

/* BS3 compatibility for your BS5-ish markup */
.ms-auto{ margin-left:auto !important; }
.navbar .navbar-nav{ list-style:none; padding-left:0; margin:7.5px 0; }
.navbar .navbar-nav.ms-auto{ float:right; }     /* right-align when only one link */
.navbar-right{ margin-right:0 !important; }

/* optional hamburger visuals if you keep the toggler */
.navbar .navbar-toggler{ border:0; outline:0; background:transparent; }
.navbar .navbar-toggler-icon{
  display:inline-block; width:24px; height:2px; background:#fff; position:relative;
}
.navbar .navbar-toggler-icon::before,
.navbar .navbar-toggler-icon::after{
  content:""; position:absolute; left:0; right:0; height:2px; background:#fff;
}
.navbar .navbar-toggler-icon::before{ top:-6px; }
.navbar .navbar-toggler-icon::after{ top:6px; }

/* ================= PAGE CARD & TYPO ================= */
.container .col-md-12{
  background:#fff;
  border:1px solid #f0e8f3;
  border-radius:16px;
  padding:24px 24px 32px;
  box-shadow:0 6px 18px rgba(0,0,0,.06);
  margin-top:24px;
}
h1{ font-weight:700; margin:0 0 6px; letter-spacing:.3px; }
h2{ color:#6c6c6c; font-size:20px; margin:0 0 18px; }

/* Section header & form card (peach) */
h3{
  background:#d6bedb;
  color:#fff;
  padding:12px 14px;
  border-radius:10px 10px 0 0;
  margin:20px 0 0;
  font-weight:700;
}
h3 + form{
  background:#fff3e6;               /* peach */
  border:1px solid #f7d9bb;
  border-top:none;
  border-radius:0 0 12px 12px;
  padding:16px;
  box-shadow:0 5px 15px rgba(0,0,0,.06);
  margin-bottom:24px;
}

/* Inputs */
label{ display:block; font-weight:700; margin:10px 0 6px; }
.form-control{
  border-radius:10px;
  border:1px solid #e5dff0;
  box-shadow:none;
  transition:all .2s ease;
}
.form-control:focus{
  border-color:#c4aacd;
  box-shadow:0 0 0 3px rgba(214,190,219,.25);
}
input[type="date"].form-control{ padding:6px 10px; }

/* Buttons */
.btn{ border-radius:10px; font-weight:700; }
.btn-primary{ background:#d6bedb; border-color:#c4aacd; }
.btn-primary:hover, .btn-primary:focus{ background:#c4aacd; border-color:#b799c1; }
.btn-info{ background:#bfa7c6; border-color:#b79ec0; color:#fff; }
.btn-info:hover{ background:#ad92b4; border-color:#a689ab; }
.btn-danger{ background:#f36b6b; border-color:#ef5a5a; }
.btn-danger:hover{ background:#e25555; border-color:#db4a4a; }

/* Alerts */
.alert{ border:none; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,.05); }
.alert-success{ background:#e9f7ef; color:#196c3c; }
.alert-info{ background:#eef3ff; color:#1a3d8f; }
.alert-danger{ background:#fdeeee; color:#952d2d; }

/* ================= TASKS TABLE AS CARD ================= */
table.table{
  position:relative;
  border-collapse:separate; border-spacing:0;
  border-radius:12px; overflow:hidden;
  border:1px solid #eee; background:#fff;
  box-shadow:0 5px 15px rgba(0,0,0,.06);
  margin-top:12px;
}
/* faux card header */
table.table::before{
  content:'My Tasks';
  display:block;
  background:#d6bedb; color:#fff;
  font-weight:700;
  padding:12px 14px;
  border-radius:12px 12px 0 0;
}
thead th{ background:#f6f1f8; color:#444; border-bottom:none !important; }
.table-striped>tbody>tr:nth-of-type(odd){ background:#fcfbfd; }
.table-hover>tbody>tr:hover{ background:#f4eef6; }
.table>tbody>tr>td{ vertical-align:middle; }

/* Status badge (8th column) */
.table>tbody>tr>td:nth-child(8){ font-weight:700; }
.table>tbody>tr>td:nth-child(8):not(:empty){
  background:#fff; border:1px solid #e9d9ef; color:#6f3e82;
  padding:.35em .6em; border-radius:999px; display:inline-block;
}

/* Action buttons spacing */
.table .btn + .btn{ margin-left:6px; }
.fa-pencil, .fa-trash-can{ vertical-align:middle; }


.navbar .navbar-collapse{
  display:flex !important;
  justify-content:flex-end;
  align-items:center;
}







</style>




</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="./">Task Master</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarNav" aria-controls="navbarNav"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item">
            <a class="nav-link active" href="./logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container"><div class="row"><div class="col-md-12">


<h1>Dashboard</h1>
<h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php

if (isset($_SESSION['alert'])) {
  if ($_SESSION['alert'] == 'taskadded') {
    echo '<div class="alert alert-success"><strong>Success!</strong>Task Added.</div>';
  } elseif ($_SESSION['alert'] == 'taskupdated') {
    echo '<div class="alert alert-info"><strong>Success!</strong>Task Updated.</div>';
  } elseif ($_SESSION['alert'] == 'taskdeleted') {
    echo '<div class="alert alert-danger"><strong>Success!</strong>Task Deleted.</div>';
  }
}
unset($_SESSION['alert']);


?>





<?php
if (isset($_POST['submit']) && $_POST['submit'] === 'edittask') {
?>

<h3>Edit Tasks</h3>
<form action="task.php" method="post">

<div>

<input type="hidden" name="action" value="edit">
<input type="hidden" name="task_id" value="<?= isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0 ?>">

<label for="title">Task Title:<input type="text" class="form-control" value="<?=$_POST['title']?>" class="form-control" id="title" name="title" required></label>
</div>

<div>
    <label for="description">Description:<input type="text" class="form-control" type="text" class="form-control" value="<?=$_POST['description']?>" class="form-control" id="description" name="description"></label>
</div>

<div>
   <label for="due_date">Due Date:<input type="date" value="<?=$_POST['due_date']?>" class="form-control" id="due_date" name="due_date" required></label>
</div>

<div>
<label for="category">Category<select name="category" id="category" class="form-control" required> <?php $categories = array('Work', 'School', 'Personal', 'Health', 'Fitness', 'Finance', 'Family', 'Shopping', 'Travel', 'Social'); foreach ($categories as $category) { $selected = (isset($_POST['category']) && $_POST['category'] == $category) ? 'selected' : ''; echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>'; } ?>
</select></label>
</div>

<div>
<label for="priority">Priority<select name="priority" class="form-control" required> <?php $priorities=array('Low','Medium','High'); foreach ($priorities as $priority) {echo '<option value="'.$priority.'">'.$priority.'</option>';} ?>

</select></label>
 
</div>

<div>
<label for="status">Status<select name="status" class="form-control" id="status"required> <?php $statuses=array('Pending', 'Completed'); foreach ($statuses as $status) {echo '<option value="'.$status.'">'.$status.'</option>';} ?>


</select></label>

</div>

<button type="submit" class="btn btn-primary" name="action" value="edit">Update Task</button>

</form>
<?php 
}
else {
?> 



<h3>Add Task</h3>
<form action="task.php" method="post">

<div>
<label for="title">Task Title<input type="text" class="form-control" value="<?=$_POST['title']?>" class="form-control" id="title" name="title" required>
</label>
</div>

<div>
    <label for="description">Description:<input type="text" class="form-control" type="text" class="form-control" value="<?=$_POST['description']?>" class="form-control" id="description" name="description"></label>
</div>

<div>
   <label for="due_date">Due Date:<input type="date" value="<?=$_POST['due_date']?>" class="form-control" id="due_date" name="due_date" required></label>
</div>

<div>
<label for="category">Category<select name="category" id="category" class="form-control" required>
<?php
$categories = array('Work', 'School', 'Personal', 'Health', 'Fitness', 'Finance', 'Family', 'Shopping', 'Travel', 'Social');
foreach ($categories as $category) {
  $selected = (isset($_POST['category']) && $_POST['category'] == $category) ? 'selected' : '';
  echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>';
}
?>
</select></label>
</div>

<div>
<label for="priority">Priority<select name="priority" class="form-control" required>
<?php
$priorities = array('Low', 'Medium', 'High');
foreach ($priorities as $priority) {
  $selected = (isset($_POST['priority']) && $_POST['priority'] == $priority) ? 'selected' : '';
  echo '<option value="' . $priority . '" ' . $selected . '>' . $priority . '</option>';
}
?>
</select></label>
</div>

<div>
<label for="status">Status<select name="status" class="form-control" id="status"required>
<?php
$statuses=array('Pending', 'Completed');
foreach ($statuses as $status) 
{echo '<option value="'.$status.'">'.$status.'</option>';} 
?>


</select></label>

</div>

<button type="submit" class="btn btn-primary" name="action" value="add">Save Task</button>

</form>
<?php
}
?>


<table class="table table-hover table-striped table-bordered" style="margin-top:80px;"> 
<tr>
<th>Task ID</th>
<th>Task Title</th>
<th>Description</th>
<th>Category</th>
<th>Due Date</th>
<th>Priority</th>
<th>Created At</th>
<th>Status</th>
<th colspan="2"></th>
</tr>
<?php


// Run the query to get all guests
$sql = "SELECT * FROM tasks WHERE user_id = $userId";
$result = mysqli_query($conn, $sql);

//print_r(mysqli_num_rows($result));
//die;
//print out the number of rows

//print_r(mysqli_fetch_assoc($result)); 
//die;

//var_dump(mysqli_fetch_assoc($result));
//die;

if (mysqli_num_rows($result) > 0) {
  
while($row = mysqli_fetch_assoc($result)) { 

?>
    <tr>
    <td><?=$row['task_id']?></td>
    <td><?=$row['title']?></td>
    <td><?=$row['description']?></td>
    <td><?=$row['category']?></td>
    <td><?=$row['due_date']?></td>
    <td><?=$row['priority']?></td>
    <td><?=$row['created_at']?></td>
    <td><?=$row['status']?></td>
    <td>
  <!--<form action="deleteguest.php" method="post"> -->
      <form action="task.php" method="post">
      <input type="hidden" name="task_id" value="<?=$row['task_id']?>">
  <!--<button class='btn btn-danger' name="deleteguest">x</button> -->
    <button class="btn btn-danger" name="submit" value="delete"><i class="fa-solid fa-trash-can"></i></button>

    </form>

    <form action="dashboard.php" method="post">
      
      <input type="hidden" name="task_id" value="<?=$row['task_id']?>">
      <input type="hidden" name="title" value="<?=$row['title']?>">
      <input type="hidden" name="description" value="<?=$row['description']?>">
      <input type="hidden" name="category" value="<?=$row['category']?>">
      <input type="hidden" name="due_date" value="<?=$row['due_date']?>">
      <input type="hidden" name="created_at" value="<?=$row['created_at']?>">
    <input type="hidden" name="priority" value="<?=$row['priority']?>">
        <input type="hidden" name="status" value="<?=$row['status']?>">
        
      <button type="submit" class="btn btn-info" name="submit" value="edittask"><i class="fa-solid fa-pencil pencil"></i></button>
    </form>
  </td>
 

    </tr>
<?php
  }
} 

mysqli_close($conn);
?>
</table>

</div></div></div>

</body>
</html>







