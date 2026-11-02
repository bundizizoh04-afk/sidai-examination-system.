<?php

session_start();
if($_SESSION['role']!="Admin" &&
   $_SESSION['role']!="ExamAdmin")
{
    header("Location: dashboard.php");
    exit();
}

if(!isset($_SESSION['username']))
{
    header("Location: login2.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","exam_system");

if(!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']); // IMPORTANT SECURITY FIX

    $delete = mysqli_query($conn, "DELETE FROM examinations WHERE id=$id");

    if($delete)
    {
        header("Location: examinations.php?msg=deleted");
        exit();
    }
    else
    {
        echo "Delete failed: " . mysqli_error($conn);
    }
}

if(isset($_POST['save']))
{
    $exam_name = $_POST['exam_name'];
    $term = $_POST['term'];
    $year = $_POST['year'];
    $exam_date = $_POST['exam_date'];

    // CHECK IF EXAM ALREADY EXISTS
    $check = mysqli_query($conn,
    "SELECT * FROM examinations 
     WHERE exam_name='$exam_name' 
     AND term='$term' 
     AND year='$year'");

    if(mysqli_num_rows($check) > 0)
    {
        echo "<script>alert('This exam already exists!');</script>";
    }
    else
    {
        mysqli_query($conn,
        "INSERT INTO examinations (exam_name,term,year,exam_date)
         VALUES ('$exam_name','$term','$year','$exam_date')");

        echo "<script>alert('Exam added successfully!');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Examinations</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">

<i class="fas fa-graduation-cap"
style="font-size:60px;color:white;"></i>

<h2>SEM SYSTEM</h2>

<p>Examination Management</p>

</div>

<ul>

<li>
<a href="dashboard.php">
<i class="fas fa-home"></i> Dashboard
</a>
</li>

<li>
    <a href="students.php">
      <i class="fas fa-user-graduate"></i> Students</a>
</li>

<li class="active"><a href="examinations.php">
     <i class="fas fa-file-alt"></i> Examination</a>
</li>

<li>
  <a href="registrations.php">
      <i class="fas fa-clipboard-list"></i> Registrations</a>
</li>

<li>
    <a href="results.php">
     <i class="fas fa-chart-bar"></i> Results</a>
</li>

<li>
  <a href="logout.php">
     <i class="fas fa-sign-out-alt"></i> Logout</a>
</li>
     <li>
<a href="reports.php">
<i class="fas fa-print"></i> Reports
</a>
</li>

</ul>

</div>

<!-- MAIN -->

<div class="main">

<div class="topbar">

<h1>Examinations</h1>

<div>
Welcome,
<b><?php echo $_SESSION['username']; ?></b>
</div>

</div>

<!-- ADD EXAM -->

<div class="form-card">

<h2>
<i class="fas fa-plus-circle"></i>
Add Examination
</h2>

<form method="POST">


<select name="exam_name" required>
    <option value="">Select Exam Type</option>
    <option>CAT 1</option>
    <option>CAT 2</option>
    <option>Midterm Exam</option>
    <option>End of Term Exam</option>
</select>

<select name="term" required>
    <option value="">Select Term</option>
    <option>Term 1</option>
    <option>Term 2</option>
    <option>Term 3</option>
</select>

<select name="year" required>
    <option value="">Select Year</option>
    <option><?php echo date("Y"); ?></option>
    <option><?php echo date("Y") + 1; ?></option>
</select>

<input
type="date"
name="exam_date"
required>

<button
type="submit"
name="save">
Save Examination
</button>

</form>

</div>

<!-- EXAM TABLE -->

<div class="table-section">

<h2>
<i class="fas fa-file-alt"></i>
Available Examinations
</h2>

<table>

<tr>
<th>ID</th>
<th>Exam Name</th>
<th>Term</th>
<th>Year</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php

$result = mysqli_query(
$conn,
"SELECT * FROM examinations");

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['exam_name']; ?></td>

<td><?php echo $row['term']; ?></td>

<td><?php echo $row['year']; ?></td>

<td><?php echo $row['exam_date']; ?></td>

<td>

<a class="edit-btn" href="edit_exam.php?id=<?php echo $row['id']; ?>">
    <i class="fas fa-edit"></i>
    Edit
</a>


<a class="delete-btn" 
   href="examinations.php?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Are you sure you want to delete this exam?')">
    <i class="fas fa-trash"></i>
    Delete
</a>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

</body>
</html>