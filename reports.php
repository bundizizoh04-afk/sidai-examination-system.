<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

$total_students = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students"));

$total_exams = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM examinations"));

$total_registrations = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM registrations"));

$total_results = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM results"));


$query = mysqli_query($conn,"
SELECT
    s.id,
    s.full_name,
    e.exam_name,
    COUNT(r.subject) AS total_subjects
FROM students s
INNER JOIN results r ON s.id = r.student_id
INNER JOIN examinations e ON r.exam_id = e.id
GROUP BY s.id, s.full_name, e.id, e.exam_name
ORDER BY s.full_name ASC
");


?>

<!DOCTYPE html>
<html>
<head>

<title>Reports</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
    <div class="sidebar">

<div class="logo">
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

<li>
<a href="registrations.php">
<i class="fas fa-clipboard-list"></i> Registrations
</a>
</li>

<li>
<a href="results.php">
<i class="fas fa-chart-bar"></i> Results
</a>
</li>

<li class="active">
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
<h2>Reports Module</h2>

<div>
Welcome,
<b><?php echo $_SESSION['username']; ?></b>
</div>

</div>
<div class="cards">

<div class="card blue">
<h3>Total Students</h3>
<h1><?php echo $total_students; ?></h1>
</div>

<div class="card green">
<h3>Examinations</h3>
<h1><?php echo $total_exams; ?></h1>
</div>

<div class="card orange">
<h3>Registrations</h3>
<h1><?php echo $total_registrations; ?></h1>
</div>

<div class="card red">
<h3>Results Entered</h3>
<h1><?php echo $total_results; ?></h1>
</div>

</div>

<div class="card">

<h2>Students Performance Report</h2>

<table>

<thead>
<tr>
    <th>No.</th>
    <th>Student Name</th>
    <th>Examination</th>
    <th>Subjects Done</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['exam_name']; ?></td>

<td style="text-align:center;">
    <span style="background:#28a745;color:white;padding:5px 12px;border-radius:20px;font-weight:bold;">
        <?php echo $row['total_subjects']; ?>
    </span>
</td>

<td>

<a href="view_report.php?id=<?php echo $row['id']; ?>" class="print-btn">
    <i class="fas fa-eye"></i> View Report
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>
