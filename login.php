<?php
session_start();
include 'connection.php';

$message = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
    "SELECT * FROM users WHERE username=? AND password=?");

    mysqli_stmt_bind_param($stmt,"ss",$username,$password);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

  if(mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);

    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['login_time'] = date("d-m-Y H:i:s");

    if($row['role']=="Student")
    {
        header("Location: student_dashboard.php");
    }
    else
    {
        header("Location: dashboard.php");
    }
    exit();
}
    else
    {
        $message = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>SEM Login</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f7fb;
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
}

.container{
width:100%;
max-width:700px;
text-align:center;
}

.logo{
width:100px;
margin-bottom:10px;
}

.header h1{
color:#1597E5;
font-size:32px;
margin-bottom:5px;
}

.header h2{
color:#0B1F4D;
font-size:18px;
margin-bottom:10px;
}

.greeting{
color:#16a34a;
font-weight:bold;
margin-bottom:15px;
}

.login-box{
background:white;
width:100%;
max-width:550px;
margin:auto;
padding:40px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

.login-box h3{
margin-bottom:25px;
font-size:30px;
color:#222;
}

.form-group{
margin-bottom:20px;
}

.form-group input{
width:100%;
padding:15px;
border:1px solid #ddd;
border-radius:5px;
font-size:16px;
}

.form-group input:focus{
outline:none;
border-color:#1597E5;
}

.btn{
width:100%;
padding:15px;
border:none;
border-radius:5px;
background:#1597E5;
color:white;
font-size:18px;
cursor:pointer;
}

.btn:hover{
background:#0d7ec1;
}

.error{
color:red;
margin-bottom:15px;
}

.options{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
font-size:14px;
}

.options a{
text-decoration:none;
color:#1597E5;
}

.footer{
margin-top:20px;
color:#666;
}

</style>

<script>
function showPassword()
{
    var x = document.getElementById("password");

    if(x.type === "password")
    {
        x.type = "text";
    }
    else
    {
        x.type = "password";
    }
}
</script>

</head>

<body>

<div class="container">

<div class="header">

<img src="sidai_logo.png" alt="Logo" class="logo">

<h1>SIDAI SECONDARY SCHOOL</h1>

<h2>EXAMINATION MANAGEMENT SYSTEM</h2>

</div>

<div class="login-box">

<h3>LOGIN</h3>

<?php
if($message != "")
{
    echo "<p class='error'>$message</p>";
}
?>

<form method="POST">

<div class="form-group">
<input
type="text"
name="username"
placeholder="Username"
required>
</div>

<div class="form-group">
<input
type="password"
name="password"
id="password"
placeholder="Password"
required>
</div>

<div class="options">

<div>
<input type="checkbox" onclick="showPassword()">
Show Password
</div>

<div>
<input type="checkbox" name="remember">
Remember Me
</div>

</div>

<button
type="submit"
name="login"
class="btn">
LOGIN
</button>

<a href="forgot_password.php">Forgot Password?</a>

</form>

</div>

<div class="footer">
© <?php echo date("Y"); ?> Student Examination Management System
</div>

</div>

</body>
</html>