<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* COUNTS */
$students = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students"));
$exams = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM examinations"));
$regs = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM registrations"));
$results = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM results"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<style>
.success-message{
position:fixed;
top:20px;
right:20px;
background:linear-gradient(135deg,#1597E5,#0B1F4D);
color:white;
padding:15px 25px;
border-radius:10px;
font-weight:bold;
font-size:15px;
box-shadow:0 5px 15px rgba(0,0,0,.2);
display:none;
z-index:9999;
animation:slideIn .5s ease;
}

@keyframes slideIn{
from{
opacity:0;
transform:translateX(100px);
}
to{
opacity:1;
transform:translateX(0);
}
}
</style>

<body>

<div id="successMessage" class="success-message">
    ✓ Login Successful
</div>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        <i class="fas fa-graduation-cap" style="font-size:60px"></i>
        <h2>SEM SYSTEM</h2>
        <p>Sidai Secondary School</p>
    </div>

    <ul>

        <li class="active">
            <a href="dashboard.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        <?php if($_SESSION['role']=="Admin"){ ?>

<li>
<a href="students.php">
<i class="fas fa-user-graduate"></i> Students
</a>
</li>

<?php } ?>

        <?php if($_SESSION['role']=="Admin" || $_SESSION['role']=="ExamAdmin"){ ?>

<li>
<a href="examinations.php">
<i class="fas fa-file-alt"></i> Examinations
</a>
</li>

<?php } ?>

        <?php if($_SESSION['role']=="Admin" || $_SESSION['role']=="ExamAdmin"){ ?>

<li>
<a href="registrations.php">
<i class="fas fa-clipboard-list"></i> Registrations
</a>
</li>

<?php } ?>

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


<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <h2>Dashboard Overview</h2>

        <div>
            Welcome,
<b><?php echo $_SESSION['username']; ?></b>

<br>

<small>
Role:
<?php echo $_SESSION['role']; ?>
</small>
        </div>

    </div>


    <!-- STATISTICS -->
    <div class="cards">

        <div class="card blue">
            <i class="fas fa-user-graduate"></i>
            <h2><?php echo $students; ?></h2>
            <p>Total Students</p>
        </div>

        <div class="card green">
            <i class="fas fa-file-alt"></i>
            <h2><?php echo $exams; ?></h2>
            <p>Examinations</p>
        </div>

        <div class="card orange">
            <i class="fas fa-clipboard-list"></i>
            <h2><?php echo $regs; ?></h2>
            <p>Registrations</p>
        </div>

        <div class="card red">
            <i class="fas fa-chart-line"></i>
            <h2><?php echo $results; ?></h2>
            <p>Results Entered</p>
        </div>

    </div>


    <!-- RECENT ACTIVITY -->
    <div class="table-section">

        <h2>Recent Examinations</h2>

        <table>

            <tr>
                <th>Examination</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>Mid-Term Examination</td>
                <td>10 June 2026</td>
                <td>Completed</td>
            </tr>

            <tr>
                <td>End-Term Examination</td>
                <td>25 July 2026</td>
                <td>Upcoming</td>
            </tr>

            <tr>
                <td>Mock Examination</td>
                <td>15 August 2026</td>
                <td>Scheduled</td>
            </tr>

        </table>

    </div>

</div>

<script>

window.onload = function()
{
    if(localStorage.getItem("loginSuccess")=="1")
    {
        document.getElementById("successMessage").style.display="block";

        setTimeout(function()
        {
            document.getElementById("successMessage").style.display="none";
        },3000);

        localStorage.removeItem("loginSuccess");
    }
}

</script>
</body>
</html>