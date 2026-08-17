<?php
include('include/db_connect.php');
session_start();

$targetDir = "uploads/";
$errormsg = $success = '';

if (isset($_POST['submit'])) {
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];

    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $allowedExts = ['png', 'jpg', 'jpeg'];

    if (in_array($imageExt, $allowedExts)) {
        if ($imageError === 0) {
            if ($imageSize <= 5000000) {
                $newImageName = uniqid('', true) . '.' . $imageExt;
                $targetFilePath = $targetDir . $newImageName;

                if (move_uploaded_file($imageTmpName, $targetFilePath)) {
                    $success = "Image uploaded successfully!";
                } else {
                    $errormsg = "There was an error uploading the file.";
                }
            } else {
                $errormsg = "Sorry, your file is too large. The maximum allowed size is 5MB.";
            }
        } else {
            $errormsg = "There was an error uploading your file.";
        }
    } else {
        $errormsg = "Sorry, only PNG, JPG, and JPEG files are allowed.";
    }
}

if (isset($_POST['delete'])) {
    $imagePath = $_POST['imagePath'];
    if (file_exists($imagePath)) {
        if (unlink($imagePath)) {
            $success = "Image '$imagePath' deleted successfully!";
        } else {
            $errormsg = "There was an error deleting the image.";
        }
    } else {
        $errormsg = "Image not found!";
    }
}
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
<h2 style="text-align: center;">Cyberbullying Images on Chat</h2>
<hr>
<form action="imgupload.php" method="POST" enctype="multipart/form-data">
<?php if(!empty($success)) { ?><p style="color:green;"><b><?php echo $success; ?></b></p> <?php } ?>
<?php if(!empty($errormsg)) { ?><p style="color:red;"><b><?php echo $errormsg; ?></b></p> <?php } ?>
<table>
  <tr>
    <th style="width: 25%;">Upload Image</th>
    <th><input type="file" name="image" id="image" accept=".png, .jpg, .jpeg" required> &nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Upload"></th>
  </tr>
</table>
</form>
<hr>
<table>
  <tr>
    <th>Si. No</th>
    <th>Image</th>
    <th>Delete</th>
  </tr>
  <?php 
  $inc = 1;
  $images = glob($targetDir . "*.{jpg,jpeg,png}", GLOB_BRACE);
  if (count($images) > 0) {
    foreach ($images as $vimage) { ?>
    <tr>
      <td><?php echo $inc; ?></td>
      <td><img src='<?php echo $vimage; ?>' alt='Uploaded Image' style='width: 50px; height: auto;'></td>
      <td>
        <form action='' method='POST'>
          <input type='hidden' name='imagePath' value='<?php echo htmlspecialchars($vimage); ?>'>
          <input type='submit' name='delete' value='Delete Image'>
        </form>
      </td>
    </tr>
    <?php $inc++; }
  } else {
    echo "<tr><td colspan='3'>No images found in the directory.</td>";
  }
  ?>
</table>
</body>
</html>
