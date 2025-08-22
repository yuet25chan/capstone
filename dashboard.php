<?php
session_start();
require 'db_credentials.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
require_once "header.php";
require_once "navbar.php";


?>


<main class="container">
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
<div>
<label for="title"><input type="text"  class="form-control" id="title" name="title"
       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required></label>
</div>

<div>
<label for="description"><input type="text"  class="form-control" id="description" name="description"
       value="<?= htmlspecialchars($_POST['description'] ?? '') ?>"></label>
</div>

<div>

<label for="date"><input type="date"  class="form-control" id="due_date" name="due_date"

       value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>" required>
</label>
</label>

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
<form action="/testing/projects/capstone_sql_and_php/task.php" method="post">
<input type="hidden" name="action" value="add">

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

<button type="submit" class="btn btn-primary">Save Task</button>

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

    <td colspan="2">
 
  <form action="dashboard.php" method="post" class="d-inline">
    <input type="hidden" name="task_id" value="<?= (int)$row['task_id'] ?>">
    <input type="hidden" name="title" value="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>">
    <input type="hidden" name="description" value="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>">
    <input type="hidden" name="category" value="<?= htmlspecialchars($row['category'], ENT_QUOTES) ?>">
    <input type="hidden" name="due_date" value="<?= htmlspecialchars($row['due_date'], ENT_QUOTES) ?>">
    <input type="hidden" name="created_at" value="<?= htmlspecialchars($row['created_at'], ENT_QUOTES) ?>">
    <input type="hidden" name="priority" value="<?= htmlspecialchars($row['priority'], ENT_QUOTES) ?>">
    <input type="hidden" name="status" value="<?= htmlspecialchars($row['status'], ENT_QUOTES) ?>">
    <button type="submit" class="btn btn-info" name="submit" value="edittask">
      <i class="fa-solid fa-pencil pencil"></i>
    </button>
  </form>


  <form action="task.php" method="post" class="d-inline" onsubmit="return confirm('Delete this task?')">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="task_id" value="<?= (int)$row['task_id'] ?>">
    <button type="submit" class="btn btn-danger">
      <i class="fa-solid fa-trash-can"></i>
    </button>
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
<?php

require_once "footer.php";
?>







