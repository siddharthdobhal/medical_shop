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
$city = $row[2];
$address = $row[3];

$contact = $row[5];
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
<h2 class="text-center" style = "font-family : Monotype Corsiva ; color : red">User Profile</h2>
<br>
<form method = post>
<table class = "table">
<tr>
<th>UserName</th>
<td><input name = username1 class = "form-control" type = text value = "<?php echo $name; ?>"></td>
</tr>
<tr>
<th>City</th>
<td><input name = city1 class = "form-control" type = text value = "<?php echo $city; ?>"></td>
</tr>
<tr>
<th>Address</th>
<td><input name = address1 class = "form-control" type = text value = "<?php echo $address; ?>"></td>
</tr>
<tr>
<th>EmailID</th>
<td><input name = emailid1 class = "form-control" type = text value = "<?php echo $emailid; ?>" readonly></td>
</tr>
<tr>
<th>Contact</th>
<td><input name = contact1 class = "form-control" type = text value = "<?php echo $contact; ?>"></td>
</tr>
</table>
<br>
<input type = submit  name = "edit" class="btn btn-primary" value = "Submit">
</form>
</div>
</body>
</html>
<?php 
if(isset($_POST['edit']))
{
$username1 = $_POST['username1'];
$city1 = $_POST['city1'];
$address1 = $_POST['address1'];

$contact1 = $_POST['contact1'];
$query = "update siteuser set username='$username1' , city='$city1',address='$address1',contact='$contact1' where emailid='$emailid'";
$n = my_iud($query);
if($n ==1)
{
echo '<script>alert("Profile Updated Successfully");
window.location = "customerhome.php";
</script>';
}
else
{
echo '<script>alert("Something went wrong,Try Again!")</script>';
}
}
?>
