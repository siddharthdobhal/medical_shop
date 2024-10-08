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
<table class = "table">
<tr>
<th>UserName</th>
<td><?php echo $name; ?></td>
</tr>
<tr>
<th>City</th>
<td><?php echo $city; ?></td>
</tr>
<tr>
<th>Address</th>
<td><?php echo $address; ?></td>
</tr>
<tr>
<th>EmailID</th>
<td><?php echo $emailid; ?></td>
</tr>
<tr>
<th>Contact</th>
<td><?php echo $contact; ?></td>
</tr>
</table>
<br>
<a href = "editprofile.php" class="btn btn-primary">Edit Profile</a>
</div>
</body>
</html>
