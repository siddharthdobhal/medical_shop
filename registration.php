<html>
<head>
<?php include "header.php"; ?>

</head>
<body>
<?php include "nav1.php"; ?>


<div class="container" style = "margin-top:70px">
<h2 class="text-center" style = "font-family : Monotype Corsiva ; color : red">Customer Registration</h2>
<div class="form-group">
<form method = post>
<label><b>UserName</b></label>
<input type = text name = username class="form-control">

<label><b>Password</b></label>
<input type = password name = pwd class="form-control">

<label><b>City</b></label>
<input type = text name = city class="form-control">

<label><b>Address</b></label>
<textarea name = address class="form-control"></textarea>

<label><b>EmailID</b></label>
<input type = email name = emailid class="form-control">

<label><b>Contact Number</b></label>
<input type = text name = contact class="form-control">




<br>
<input type = submit name = submit value = "Submit" class="btn btn-primary form-control" >
</form>
</div>
</div>
</body>
</html>
<?php 
session_start();
include "dbconfigure.php";
if(isset($_POST['submit']))
{
$username = $_POST['username'];
$pwd = $_POST['pwd'];
$city = $_POST['city'];
$address = $_POST['address'];
$emailid = $_POST['emailid'];
$contact = $_POST['contact'];

$query = "insert into siteuser values('$username','$pwd','$city','$address','$emailid','$contact')";
$n = my_iud($query);
if($n ==1)
{
echo '<script>alert("SignUp Successfull");
window.location = "login.php";
</script>';
}
else
{
echo '<script>alert("Something went wrong,Try Again!")</script>';
}
}
?>