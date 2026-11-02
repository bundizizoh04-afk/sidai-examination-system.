<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

if($_SESSION['role']!="Student")
{
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Student Dashboard</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="sidebar">

<h2>Student Panel</h2>

<ul>

<li>

<a href="my_results.php">

My Results

</a>

</li>

<li>

<a href="logout.php">

Logout

</a>

</li>

</ul>

</div>

<div class="main">

<h2>

Welcome

<?php echo $_SESSION['username']; ?>

</h2>

<p>

You can only view and print your academic report.

</p>

</div>

</body>

</html>