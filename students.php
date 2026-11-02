<?php
session_start();

if($_SESSION['role']!="Admin")
{
    header("Location: dashboard.php");
    exit();
}

include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* ADD */
if(isset($_POST['save'])){
    mysqli_query($conn,"INSERT INTO students(admission_no,full_name,gender,class)
    VALUES(
    '$_POST[admission_no]',
    '$_POST[full_name]',
    '$_POST[gender]',
    '$_POST[class]'
    )");
}

/* DELETE */
if(isset($_GET['delete'])){
    mysqli_query($conn,"DELETE FROM students WHERE id='$_GET[delete]'");
    header("Location: students.php");
}

/* EDIT FETCH */
$edit = false;

if(isset($_GET['edit'])){
    $edit = true;
    $id = $_GET['edit'];

    $row = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM students WHERE id='$id'"));

    $admission_no = $row['admission_no'];
    $full_name = $row['full_name'];
    $gender = $row['gender'];
    $class = $row['class'];
}

/* UPDATE */
if(isset($_POST['update'])){
    mysqli_query($conn,"UPDATE students SET
    admission_no='$_POST[admission_no]',
    full_name='$_POST[full_name]',
    gender='$_POST[gender]',
    class='$_POST[class]'
    WHERE id='$_POST[id]'");
}

$students = mysqli_query($conn,"SELECT * FROM students");
?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<div class="logo">
<i class="fas fa-graduation-cap"></i>
<h2>SEM SYSTEM</h2>
<p>Sidai Secondary School</p>
</div>

<ul>

<li>
   <a href="dashboard.php">
     <i class="fas fa-home"></i>Dashboard</a></li>

<li class="active">
    <a href="students.php">
     <i class="fas fa-user-graduate"></i>Students</a></li>

<li>
    <a href="examinations.php">
     <i class="fas fa-file-alt"></i>Examinations</a></li>

<li>
   <a href="registrations.php">
     <i class="fas fa-clipboard-list"></i>Registrations</a></li>

<li>
   <a href="results.php">
     <i class="fas fa-chart-bar"></i>Results</a></li>

<li>
   <a href="reports.php">
     <i class="fas fa-print"></i>Reports</a></li>

<li>
     <a href="logout.php">  
       <i class="fas fa-sign-out-alt"></i>Logout</a></li>
</ul>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">

<h2>Students Module</h2>

<div>
    Welcome,
   <b><?php echo $_SESSION['username']; ?></b></div>

</div>

<!-- FORM CARD -->
<div class="form-card">
<h2><?php echo $edit ? "Update Student" : "Add Student"; ?></h2>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $edit ? $id : ''; ?>">

<input type="text" name="admission_no" placeholder="Admission No"
value="<?php echo $edit ? $admission_no : ''; ?>">

<input type="text" name="full_name" placeholder="Full Name"
value="<?php echo $edit ? $full_name : ''; ?>">

<select name="gender">
<option>Male</option>
<option>Female</option>
</select>

<select name="class" required>

<option value="">Select Grade</option>

<option value="Grade 7"
<?php if($edit && $class=="Grade 7") echo "selected"; ?>>
Grade 7
</option>

<option value="Grade 8"
<?php if($edit && $class=="Grade 8") echo "selected"; ?>>
Grade 8
</option>

<option value="Grade 9"
<?php if($edit && $class=="Grade 9") echo "selected"; ?>>
Grade 9
</option>

<option value="Grade 10"
<?php if($edit && $class=="Grade 10") echo "selected"; ?>>
Grade 10
</option>

</select>

<button name="<?php echo $edit ? 'update' : 'save'; ?>">
<?php echo $edit ? "Update" : "Save"; ?>
</button>

</form>
</div>

<!-- TABLE -->
<div class="table-section">

<h2>
   <i class="fas fa-users"></i>Students List</h2>

<table>
<tr>
<th>ID</th>
<th>Admission No</th>
<th>Name</th>
<th>Gender</th>
<th>Class</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($students)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['admission_no']; ?></td>
<td><?php echo $row['full_name']; ?></td>
<td><?php echo $row['gender']; ?></td>
<td><?php echo $row['class']; ?></td>

<td>

<a class="edit-btn"
href="students.php?edit=<?php echo $row['id']; ?>">
<i class="fas fa-edit"></i>
Edit
</a>

<a class="delete-btn"
href="students.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this student?')">

<i class="fas fa-trash"></i>
Delete

</a>

</td>

</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>