<?php
include 'connection.php';
session_start();

if(!isset($_SESSION['username']))
{
    header("Location:login.php");
    exit();
}

$id=$_GET['id'];

if($_SESSION['role']=="Student")
{

$username=$_SESSION['username'];

$check=mysqli_query($conn,"
SELECT id
FROM students
WHERE admission_no='$username'
");

$mine=mysqli_fetch_assoc($check);

if($mine['id']!=$id)
{
    die("Access Denied");
}

}

$query = mysqli_query($conn,"
SELECT s.admission_no,
       s.full_name,
       s.class,
       e.exam_name,
       e.term,
       e.year,
       r.subject,
       r.marks,
       r.grade
FROM results r
JOIN students s ON r.student_id=s.id
JOIN examinations e ON r.exam_id=e.id
WHERE s.id='$id'
");

$student = mysqli_fetch_assoc($query);

$total = 0;
$count = 0;

mysqli_data_seek($query,0);

while($row=mysqli_fetch_assoc($query))
{
    $total += $row['marks'];
    $count++;
}

$average = ($count > 0) ? ($total / $count) : 0;

mysqli_data_seek($query,0);

function meanGrade($avg)
{
    if($avg >= 80) return "A";
    elseif($avg >= 70) return "B";
    elseif($avg >= 60) return "C";
    elseif($avg >= 50) return "D";
    else return "F";
}

$mean_grade = meanGrade($average);

$report_no = "SSR-".date("Y")."-".str_pad($id,5,"0",STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Report Card</title>

<style>

body{
    background:#f1f5f9;
    font-family:Arial,sans-serif;
    margin:0;
    padding:10px;
}

.container{
    width:820px;          /* was 900px */
    margin:10px auto;
    background:white;
    padding:20px;         /* was 40px */
    border:2px solid #003366;
    box-shadow:0 0 8px rgba(0,0,0,.15);
    position:relative;
    overflow:hidden;
}

.header{
    text-align:center;
    border-bottom:2px solid #003366;
    padding-bottom:8px;
    margin-bottom:10px;
}

.school-logo{
    width:65px;
    height:65px;
    margin-bottom:5px;
}

.header h1{
    margin:0;
    font-size:24px;
}

.header h3{
    margin:3px 0;
    font-size:18px;
}

.header p{
    margin:2px;
    font-size:12px;
}

.info-table{
    width:100%;
    border-collapse:collapse;
    margin:12px 0;
}

.info-table th{
    background:#0B3A70;
    color:#fff;
    width:18%;
    padding:10px;
    text-align:left;
    font-size:15px;
    font-weight:bold;
}

.info-table td{
    border:1px solid #bbb;
    padding:10px;
    font-size:15px;
    font-weight:bold;      /* Make student details bold */
    color:#111;
}

.subjects{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.subjects th{
    background:#0B3A70;
    color:#fff;
    padding:10px;
    font-size:14px;
    text-align:left;      /* was center */
}

.subjects td{
    border:1px solid #cfcfcf;
    padding:10px;
    font-size:14px;
    text-align:left;      /* keeps contents aligned */
}

.subjects th:nth-child(2),
.subjects td:nth-child(2),
.subjects th:nth-child(3),
.subjects td:nth-child(3){
    text-align:center;
}

.subjects th:nth-child(4),
.subjects td:nth-child(4){
    text-align:left;
}

.summary{
    width:38%;
    float:right;
    margin-top:12px;
    border-collapse:collapse;
}

.summary th{
    background:#003366;
    color:white;
    padding:8px;
    text-align:center;
}

.summary td{
    border:1px solid #555;
    padding:8px;
    font-size:13px;
}

.summary td:first-child{
    font-weight:bold;
    width:60%;

}

.remark{
    clear:both;
    margin-top:20px;      /* was 160px */
    font-size:13px;
}

.remark p{
    margin:4px 0;
}

.signature{
    width:100%;
    margin-top:20px;      /* was 80px */
}

.signature td{
    padding-top:25px;
    border:none;
    text-align:center;
    font-size:13px;
}

.footer{
    clear:both;
    margin-top:15px;
    text-align:center;
    font-size:11px;
    color:#666;
}

/* WATERMARK */
.watermark{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    z-index:0;
    opacity:0.05;      /* Lower = more transparent (0.03–0.08 looks good) */
    pointer-events:none;
}

.watermark img{
    width:650px;       /* Increase to 700px if you want it even bigger */
    height:auto;
}

.header,
.student-info,
.subjects,
.summary,
.remark,
.signature,
.footer{
    position:relative;
    z-index:2;
}

.print-btn{
    margin-top:15px;
}

@media print{

@page{
    size:A4 portrait;
    margin:8mm;
}

body{
    background:white;
    padding:0;
}

.container{
    width:100%;
    margin:0;
    padding:12px;
    box-shadow:none;
    border:2px solid #003366;
}

.print-btn{
    display:none;
}

/* WATERMARK */
.watermark{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    z-index:0;
    opacity:0.05;      /* Lower = more transparent (0.03–0.08 looks good) */
    pointer-events:none;
}

.watermark img{
    width:650px;       /* Increase to 700px if you want it even bigger */
    height:auto;
}


}

</style>
</head>

<body>

<div class="container">

<div class="watermark">
    <img src="sidai_logo.png">
</div>

<div class="content">

<div class="header">

<img src="sidai_logo.png" class="school-logo">

<h1>SIDAI SECONDARY SCHOOL</h1>

<h3>OFFICIAL STUDENT REPORT CARD</h3>

<p><b>Motto:</b> Strive For Excellence</p>

<p><b>Report No:</b> <?php echo $report_no; ?></p>

</div>

<div class="student-info">

<table class="info-table">

<tr>
<th>Student Name</th>
<td><?php echo $student['full_name']; ?></td>

<th>Admission No</th>
<td><?php echo $student['admission_no']; ?></td>
</tr>

<tr>
<th>Class</th>
<td><?php echo $student['class']; ?></td>

<th>Academic Year</th>
<td><?php echo $student['year']; ?></td>
</tr>

<tr>
<th>Term</th>
<td><?php echo $student['term']; ?></td>

<th>Mean Grade</th>
<td><b><?php echo $mean_grade; ?></b></td>
</tr>

<tr>
<th>Examination</th>
<td colspan="3">
<?php echo $student['exam_name']; ?>
</td>
</tr>

</table>

</div>

<table class="subjects">

<tr>
<th>Subject</th>
<th>Marks</th>
<th>Grade</th>
<th>Remarks</th>
</tr>

<?php
mysqli_data_seek($query,0);

while($row=mysqli_fetch_assoc($query))
{
    if($row['grade']=="A")
        $remarks="Excellent";
    elseif($row['grade']=="B")
        $remarks="Very Good";
    elseif($row['grade']=="C")
        $remarks="Good";
    elseif($row['grade']=="D")
        $remarks="Fair";
    else
        $remarks="Needs Improvement";
?>

<tr>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['marks']; ?></td>
<td><?php echo $row['grade']; ?></td>
<td><?php echo $remarks; ?></td>
</tr>

<?php } ?>

</table>

<table class="summary">

<tr>
<th colspan="2">
RESULT SUMMARY
</th>
</tr>

<tr>
<td>Total Marks</td>
<td><?php echo $total; ?></td>
</tr>

<tr>
<td>Average Marks</td>
<td><?php echo number_format($average,1); ?></td>
</tr>

<tr>
<td>Mean Grade</td>
<td><?php echo $mean_grade; ?></td>
</tr>

<tr>
<td>Status</td>

<td>

<?php
if($average>=50)
echo "PASS";
else
echo "FAIL";
?>

</td>

</tr>

</table>

<div class="remarks">

<p><b>Class Teacher's Remarks:</b></p>
<p>Good academic progress. Maintain discipline and continue working hard.</p>

<br>

<p><b>Principal's Remarks:</b></p>
<p>Promoted to the next academic level subject to school regulations.</p>

</div>

<table class="signature">

<tr>

<td>
_________________________
<br><br>
CLASS TEACHER
</td>

<td>
_________________________
<br><br>
PRINCIPAL
</td>

</tr>

</table>

<div class="footer">

CONFIDENTIAL SCHOOL DOCUMENT

<br>

Generated On: <?php echo date("d-m-Y H:i:s"); ?>

<br>

Sidai Secondary School Examination Management System

</div>

<center>

<button onclick="window.print()" class="print-btn">
🖨 Print Report Card
</button>

</center>

</div>

</div>

</body>
</html>