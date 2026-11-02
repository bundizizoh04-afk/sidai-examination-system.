<?php

$conn = mysqli_connect("localhost","root","","exam_system");

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM students WHERE id='$id'");

header("Location: students.php");

?>