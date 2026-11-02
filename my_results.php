<?php

session_start();
include 'connection.php';

if($_SESSION['role']!="Student")
{
    header("Location:login.php");
    exit();
}

$username=$_SESSION['username'];

$sql=mysqli_query($conn,"
SELECT
students.id
FROM students
WHERE admission_no='$username'
");

$student=mysqli_fetch_assoc($sql);

$id=$student['id'];

header("Location:view_report.php?id=".$id);

?>