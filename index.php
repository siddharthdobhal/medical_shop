<html>
<head>
<?php include "header.php"; ?>
<style>
.mydivstyleone:hover{
box-shadow:0 0 20px 0 rgba(0,0,0,0.3);
transform:translateY(-1px);

.headingfour:hover{
color : lightblue;
</style>

</head>
<body>
<?php include "nav1.php"; ?>

<!-- carousel start-->
<div id="demo" class="carousel slide" data-ride="carousel" style = "margin-top : 1px">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
    <li data-target="#demo" data-slide-to="3"></li>
    <li data-target="#demo" data-slide-to="4"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="myimages/2.jpg"  width="100%" height="300">
    </div>
    <div class="carousel-item">
      <img src="myimages/1.jpg"  width="100%" height="300">
    </div>
    <div class="carousel-item">
      <img src="myimages/3.jpg"  width="100%" height="300">
    </div>
      <div class="carousel-item">
      <img src="myimages/4.jpg"  width="100%" height="300">
    </div>
      <div class="carousel-item">
      <img src="myimages/5.jpg"  width="100%" height="300">
    </div>
        
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

<!--carousel end-->
<div class="container" style = "margin-top:20px">
<h2 class="text-center" style = "font-family : Monotype Corsiva ; color : red">OUR MEDICINE Collection</h2>

<center><img src="myimages/line1.jpg" style ="height:20px ; width : 500px" ></center>
<br>
<?php 
include "dbconfigure.php";
$query = "select * from category";
$rs = my_select($query);
?>
<div class = "row">
<?php 
while($row=mysqli_fetch_array($rs))
{
?>
<div class="col-sm-4 mydivstyleone text-center">
<h4 class = "text-center headingfour" style = "font-family : Monotype Corsiva ; color : red"><?= $row[1]?></h4> 
<a href = "medicinebycategory.php?category=<?=$row[1]?>"><img src="admin/<?=$row[2]?>" class="img-thumbnail" style = "width:304px; height : 236px"> </a> 
</div>
<?php 
}
?>

</div>
</div>
<br><br><br><br>

<!--scrolltop start-->
<div class="scrolltop float-right">
  <i class="fa fa-arrow-up" onclick="topFunction()" id="scrollbtn"></i>
  </div>
  <script>
  scrollbutton = document.getElementById("scrollbtn"); 
  window.onscroll = function(){scrollFunction()};
  
  function scrollFunction()
  {
  if(document.body.scrollTop>20 || document.documentElement.scrollTop>20)
  {
  scrollbutton.style.display="block";
  }
  else
  {
  scrollbutton.style.display="none";
  }
  }
  
  function topFunction()
  {
  document.body.scrollTop = 0;//safari
  document.documentElement.scrollTop = 0;//for chrome
  }
  </script>
  
  
 <!--scrolltop end--> 
</body>
</html>