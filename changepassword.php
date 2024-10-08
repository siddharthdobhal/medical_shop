<?php 
session_start();
include "dbconfigure.php";
if(verifyuser())
{
$emailid = $_SESSION['semail'];
$query = "select * from siteuser where emailid='$emailid'";
$rs = my_select($query);
if($row = mysqli_fetch_array($rs))
{

$name = $row[0];

}
}
else
{
header("location:index.php");
}
?>
<html>
<head>
<?php include "header.php"; ?>
<style>
td{color : brown ; font-weight : bold}
</style>
</head>
<body>
<?php include "nav2.php";
echo "<br>Welcome <b style = 'text-transform : capitalize ; color : blue'>$name</b>";

 ?>


<div class="container" style = "margin-top:70px">
<h2 class="text-center" style = "font-family : Monotype Corsiva ; color : red">Change Password</h2>
<br>
<form method = post>
<label><b>Old Password</b></label>
<input class = "form-control" style = "color : purple" type = password name = oldpassword>

<label><b>New Password</b></label>
<input class = "form-control" style = "color : purple" type = password name = newpassword>
<label><b>Confirm Password</b></label>
<input class = "form-control" type = password style = "color : purple" name = cpassword>
<br>
<input type = submit value = "Submit" name = submit class="btn btn-primary">
</form>
</div>
</body>
</html>
<?php 
if(isset($_POST['submit']))
{
$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];
$cpassword = $_POST['cpassword'];

if($newpassword==$cpassword)
{

$query = "update siteuser set pwd='$newpassword' where emailid='$emailid' and pwd='$oldpassword'";
$n = my_iud($query);
if($n ==1)
{
echo '<script>alert("Password Updated Successfully");
window.location = "login.php";
</script>';
}
else
{
echo '<script>alert("Something went wrong,Try Again!")</script>';
}	

}
else
{
echo '<script>alert("Password and Confirm Password Not Match");
</script>';
}


}
?>
