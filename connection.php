<?php

$conn = mysqli_connect(
    "localhost","root", "", "exam_system"
);

if(!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

?>