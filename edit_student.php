<?php
$conn = mysqli_connect("localhost","root","","exam_system");

$id = $_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM students WHERE id='$id'");

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $admission_no = $_POST['admission_no'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $stream = $_POST['stream'];

    mysqli_query($conn,

    "UPDATE students SET

    admission_no='$admission_no',
    full_name='$full_name',
    gender='$gender',
    class='$class',
    stream='$stream'

    WHERE id='$id'");

    header("Location: students.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>

<style>

body{
    font-family:Arial;
    background:#eaf2ff;
}

.container{
    width:600px;
    margin:40px auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

input,select{
    width:100%;
    padding:12px;
    margin-bottom:15px;
}

button{
    background:#1597E5;
    color:white;
    border:none;
    padding:12px 20px;
}

</style>
</head>

<body>

<div class="container">

<h2>Edit Student</h2>

<form method="POST">

<input type="text"
name="admission_no"
value="<?php echo $row['admission_no']; ?>">

<input type="text"
name="full_name"
value="<?php echo $row['full_name']; ?>">

<select name="gender">

<option><?php echo $row['gender']; ?></option>
<option>Male</option>
<option>Female</option>

</select>

<select name="class">

<option><?php echo $row['class']; ?></option>
<option>Form 1</option>
<option>Form 2</option>
<option>Form 3</option>
<option>Form 4</option>

</select>

<select name="stream">

<option><?php echo $row['stream']; ?></option>
<option>Blue</option>
<option>Red</option>
<option>Green</option>
<option>Yellow</option>

</select>

<button type="submit"
name="update">
Update Student
</button>

</form>

</div>

</body>
</html>