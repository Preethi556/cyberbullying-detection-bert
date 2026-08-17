<?php
session_start();
include('include/db_connect.php');

if(isset($_POST['cyword'])) {
 $cyword= $_POST['cyword'];
 $cyword=trim($cyword);
 if(!empty($cyword)) {
  $reg="insert into cyberwords(cyword) values ('".strtolower($cyword)."')";
  $query=mysqli_query($con,$reg);
  if($query){
   echo '<script>alert("Cyberbullying Keyword Added  ")</script>';
   echo '<script>window.open("addcyberwords.php","_self")</script>';
  }      
 } 
}
$sql = "select * from cyberwords order by created desc" ;
$all_result = mysqli_query($con, $sql);
$num = mysqli_num_rows($all_result);
?>
<!DOCTYPE html>
<html>
<head>
<style>
table { border-collapse: collapse; width: 100%; }
th, td { padding: 8px; text-align: left; border-bottom: 1px solid #DDD; }
tr:hover {background-color: #D6EEEE;}
</style>
</head>
<body>
<h2 style="text-align: center;">Cyberbullying Keywords</h2>
<hr>
<form method="post">
<table>
  <tr>
    <th style="width: 25%;">Enter Cyberbullying Keyword</th>
    <th><input type="text" name="cyword" placeholder="Enter Keyword"/> &nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Add"/></th>
  </tr>
</table>
</form>
<hr>
<table>
  <tr>
    <th>Si. No</th>
    <th>Keyword</th>
    <th>Created</th>
  </tr>
  <?php if($num >= 1) { $inc = 1;
 while($rows=mysqli_fetch_assoc($all_result))
 { ?>
  <tr>
  <td><?php echo $inc; ?></td>
  <td><?php echo $rows['cyword']; ?></td>
  <td><?php echo $rows['created']; ?></td>
  </tr>
 <?php $inc++; }
 } ?>
</table>
</body>
</html>
