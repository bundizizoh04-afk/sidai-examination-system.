<?php
include 'connection.php';

$message = "";

if(isset($_POST['reset']))
{
    $username = $_POST['username'];
    $newpassword = $_POST['newpassword'];

    $check = mysqli_query($conn,
    "SELECT * FROM users WHERE username='$username'");

    if(mysqli_num_rows($check) > 0)
    {
        mysqli_query($conn,
        "UPDATE users
        SET password='$newpassword'
        WHERE username='$username'");

        $message = "Password Reset Successful";
    }
    else
    {
        $message = "Username Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:white;
padding:40px;
width:400px;
box-shadow:0 0 10px gray;
}

input{
width:100%;
padding:12px;
margin-bottom:15px;
}

button{
width:100%;
padding:12px;
background:#1597E5;
color:white;
border:none;
cursor:pointer;
}

.message{
color:green;
margin-bottom:15px;
}

</style>
</head>

<body>

<div class="box">

<h2>Reset Password</h2>

<?php
if($message!="")
{
    echo "<p class='message'>$message</p>";
}
?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="newpassword"
placeholder="New Password"
required>

<button name="reset">
Reset Password
</button>

</form>

<br>

<a href="login.php">
Back To Login
</a>

</div>

</body>
</html>