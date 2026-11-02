<?php
session_start();

$conn = mysqli_connect("localhost","root","","exam_system");

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM examinations WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $exam_name = $_POST['exam_name'];
    $term = $_POST['term'];
    $year = $_POST['year'];
    $exam_date = $_POST['exam_date'];

    mysqli_query($conn,
    "UPDATE examinations SET 
    exam_name='$exam_name',
    term='$term',
    year='$year',
    exam_date='$exam_date'
    WHERE id=$id");

    header("Location: examinations.php");
    exit();
}
?>

<form method="POST">
    <input type="text" name="exam_name" value="<?php echo $row['exam_name']; ?>" required>

    <select name="term">
        <option><?php echo $row['term']; ?></option>
        <option>Term 1</option>
        <option>Term 2</option>
        <option>Term 3</option>
    </select>

    <input type="text" name="year" value="<?php echo $row['year']; ?>" required>

    <input type="date" name="exam_date" value="<?php echo $row['exam_date']; ?>" required>

    <button type="submit" name="update">Update Exam</button>
</form>