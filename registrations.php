<?php
session_start();
if($_SESSION['role']!="Admin" &&
   $_SESSION['role']!="ExamAdmin")
{
    header("Location: dashboard.php");
    exit();
}
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* ADD REGISTRATION */
if(isset($_POST['save'])){
    mysqli_query($conn,"
        INSERT INTO registrations(student_id, exam_id)
        VALUES('$_POST[student_id]','$_POST[exam_id]')
    ");
}

/* DELETE */
if(isset($_GET['delete'])){
    mysqli_query($conn,"
        DELETE FROM registrations WHERE id='$_GET[delete]'
    ");
    header("Location: registrations.php");
    exit();
}

/* DATA */
$students = mysqli_query($conn,"SELECT * FROM students");
$exams = mysqli_query($conn,"SELECT * FROM examinations");

$regs = mysqli_query($conn,"
SELECT r.id, s.full_name, e.exam_name, r.registration_date
FROM registrations r
JOIN students s ON r.student_id = s.id
JOIN examinations e ON r.exam_id = e.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Registrations</title>


<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div class="sidebar">

<div class="logo">
<i class="fas fa-graduation-cap"></i>
<h2>SEM SYSTEM</h2>
<p>Sidai Secondary School</p>
</div>

<ul>

<li>
<a href="dashboard.php">
<i class="fas fa-home"></i> Dashboard
</a>
</li>

<li>
<a href="students.php">
<i class="fas fa-user-graduate"></i> Students
</a>
</li>

<li>
<a href="examinations.php">
<i class="fas fa-file-alt"></i> Examinations
</a>
</li>

<li class="active">
<a href="registrations.php">
<i class="fas fa-clipboard-list"></i> Registrations
</a>
</li>

<li>
<a href="results.php">
<i class="fas fa-chart-bar"></i> Results
</a>
</li>

<li>
<a href="reports.php">
<i class="fas fa-print"></i> Reports
</a>
</li>

<li>
<a href="logout.php">
<i class="fas fa-sign-out-alt"></i> Logout
</a>
</li>

</ul>

</div>

<div class="main">

<div class="topbar">

<h2>Examination Registration</h2>

<div>
Welcome,
<b><?php echo $_SESSION['username']; ?></b>
</div>

</div>

<div class="form-card">

<h2>
<i class="fas fa-clipboard-check"></i>
Register Student For Examination
</h2>

<form method="POST">

<select name="student_id" required>
<option value="">Select Student</option>
<?php while($s=mysqli_fetch_assoc($students)){ ?>
<option value="<?php echo $s['id']; ?>">
<?php echo $s['full_name']; ?>
</option>

<?php } ?>
</select>

<select name="exam_id" required>
<option value="">Select Exam</option>
<?php while($e=mysqli_fetch_assoc($exams)){ ?>
<option value="<?php echo $e['id']; ?>">
<?php echo $e['exam_name']; ?>
</option>
<?php } ?>
</select>

<button name="save">Register</button>

</form>

</div>

<div class="table-section">

<h2>
<i class="fas fa-list"></i>
Registered Students
</h2>

<table>
<tr>
<th>ID</th>
<th>Student</th>
<th>Exam</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($regs)){ ?>
<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['full_name']; ?></td>
<td><?php echo $r['exam_name']; ?></td>
<td><?php echo $r['registration_date']; ?></td>
<td>

<a class="delete-btn"
href="registrations.php?delete=<?php echo $r['id']; ?>"
onclick="return confirm('Delete this registration?')">

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