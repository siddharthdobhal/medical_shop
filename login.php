<html>
<head>
<?php include "header.php"; ?>

</head>
<body>
<?php include "nav1.php"; ?>


<div class="container" style = "margin-top:70px">
<h2 class="text-center" style = "font-family : Monotype Corsiva ; color : red">Customer Login</h2>
<br><br>
<div class="form-group">
<form method = post>
<label><b>Enter EmailID</b></label>
<input type = text name = emailid class="form-control" required>

<label><b>Enter Password</b></label>
<input type = password name = pwd class="form-control" required>
<br>
<input type = checkbox name = rem> <b>Remember Me</b>
<br>
<br>
<input type = submit name = login value = "Login" class="btn btn-primary " >
<a href = "registration.php" class="btn btn-primary">SignUp</a>
</form>
</div>
</div>
</body>
</html>
<?php 
session_start();
include "dbconfigure.php";
if(isset($_POST['login']))
{
$emailid = $_POST['emailid'];
$pwd = $_POST['pwd'];
if(isset($_POST['rem']))
{
$remember = "yes";
}
else
{
$remember = "no";
}
$query = "select count(*) from siteuser where emailid='$emailid' and pwd='$pwd'";
$n = my_one($query);
if($n==1)
{
$_SESSION['semail']=$emailid;
$_SESSION['spwd']=$pwd;
  
	if($remember=='yes')
	{
		setcookie('cemail',$emailid,time()+60*60*24*7);
		setcookie('cpwd',$pwd,time()+60*60*24*7);

	}
if(isset($_GET['id']))
{
header("location:booking.php?id=".$_GET['id']);
}
else
{
header("location:customerhome.php");
}
}
else
{
echo '<script>alert("Invalid Login Credentials,Try Again!")</script>';
}
}
?>