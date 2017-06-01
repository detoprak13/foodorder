<?php
ob_start();
session_start();
?>
<html>
<head><title>Food Order</title> <link REL="StyleSheet" TYPE="text/css" HREF="add_menu_item.css"> <?php include "functions.php"?></head>
<body>

<?php
$uname='';
if(isset($_SESSION['username'])){
    $uname = $_SESSION['username'];
}else{
    header("Location: signin.php");
    die();
}
if(isset($_POST['home'])){
    header("Location: home.php");
}
$msg = '';
$restname = $_GET['restname'];
if (isset($_POST['add_menu_item']) && !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['type'])) {
    $price = $_POST['price'];
    $type= $_POST['type'];
    $name = $_POST['name'];
    $result = addMenuItem($restname, $uname, $name, $price, $type);
    if ($result) {
      header("Location: restaurant_info.php?name=".$restname);
    } else {
      $msg = "Error: Please fill all fields.";
    }
}
?>
<center>
    <div class="add_menu_item">
        <div class="heading">
            <h2>Add Menu Item To <?php echo $restname?></h2>
            <form method="post" >
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name = "name" placeholder="Name">
                </div>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <input type="number" class="form-control" name = "price" placeholder="Price">
                </div>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name = "type" placeholder="Type">
                </div>


                <b><font color="white"><?php echo $msg ?></font><br></b>
                <button type="submit" class="float" name = "add_menu_item">Add</button>
            </form>
        </div>
    </div>
</center>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>
</html>
