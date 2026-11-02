<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

function getGrade($marks)
{
    if($marks>=80) return "A";
    elseif($marks>=70) return "B";
    elseif($marks>=60) return "C";
    elseif($marks>=50) return "D";
    else return "F";
}

/* SAVE RESULTS */
if(isset($_POST['save']))
{
    $student_id=$_POST['student_id'];
    $exam_id=$_POST['exam_id'];

    foreach($_POST['marks'] as $subject=>$mark)
    {
        if($mark!="")
        {
            $check=mysqli_query($conn,"
            SELECT *
            FROM results
            WHERE student_id='$student_id'
            AND exam_id='$exam_id'
            AND subject='$subject'
            ");

            if(mysqli_num_rows($check)==0)
            {
                $grade=getGrade($mark);

                mysqli_query($conn,"
                INSERT INTO results(student_id,exam_id,subject,marks,grade)
                VALUES('$student_id','$exam_id','$subject','$mark','$grade')
                ");
            }
        }
    }
}

/* DELETE */
if(isset($_GET['delete']))
{
    mysqli_query($conn,"DELETE FROM results WHERE id='$_GET[delete]'");
    header("Location: results.php");
    exit();
}

$students=mysqli_query($conn,"SELECT * FROM students");
$exams=mysqli_query($conn,"SELECT * FROM examinations");
?>

<!DOCTYPE html>
<html>
<head>

<title>Results Module</title>

<link rel="stylesheet" href="style.css">

<style>

.marks-table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

.marks-table th{
background:#2563eb;
color:white;
padding:12px;
}

.marks-table td{
padding:10px;
border:1px solid #ddd;
}

.marks-table input{
width:100px;
padding:8px;
}

</style>

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
<h2>Results Module</h2>
</div>

<div class="form-card">

<h2>Enter Student Results</h2>

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

<option value="">Select Examination</option>

<?php while($e=mysqli_fetch_assoc($exams)){ ?>

<option value="<?php echo $e['id']; ?>">

<?php echo $e['exam_name']; ?>

</option>

<?php } ?>

</select>

<table class="marks-table">

<tr>
<th>Subject</th>
<th>Marks</th>
</tr>

<?php

$subjects=mysqli_query($conn,"SELECT * FROM subjects");

while($sub=mysqli_fetch_assoc($subjects))
{
?>

<tr>

<td>

<?php echo $sub['subject_name']; ?>

</td>

<td>

<input
type="number"
name="marks[<?php echo $sub['subject_name']; ?>]"
min="0"
max="100">

</td>

</tr>

<?php } ?>

</table>

<br>

<button name="save">

Save Results

</button>

</form>

</div>

<div class="table-section">

<h2>Results Summary</h2>

<table>

<tr>

<th>Student</th>

<th>Exam</th>

<th>Subjects Done</th>

<th>Average</th>

<th>Mean Grade</th>

<th>Action</th>

</tr>

<?php

$query=mysqli_query($conn,"
SELECT
s.id,
s.full_name,
e.exam_name,
COUNT(r.subject) total_subjects,
AVG(r.marks) average_marks
FROM results r
JOIN students s ON r.student_id=s.id
JOIN examinations e ON r.exam_id=e.id
GROUP BY s.id,e.id
");

while($row=mysqli_fetch_assoc($query))
{

$avg=$row['average_marks'];

if($avg>=80)
$grade="A";
elseif($avg>=70)
$grade="B";
elseif($avg>=60)
$grade="C";
elseif($avg>=50)
$grade="D";
else
$grade="F";

?>

<tr>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['exam_name']; ?></td>

<td><?php echo $row['total_subjects']; ?></td>

<td><?php echo number_format($avg,1); ?></td>

<td><?php echo $grade; ?></td>

<td>

<a class="edit-btn"
href="view_report.php?id=<?php echo $row['id']; ?>">

View Report

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>