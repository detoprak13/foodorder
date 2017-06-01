<?php
ob_start();
session_start();
?>
<html>
<head><title>Food Order</title> <link REL="StyleSheet" TYPE="text/css" HREF="signup.css"> <?php include "functions.php"?>

</head>
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
if (isset($_POST['add_restaurant']) && !empty($_POST['rest_name']) && !empty($_POST['work_start']) && !empty($_POST['work_end']) && !empty($_POST['district']) && !empty($_POST['city'])
    && !empty($_POST['street']) && $_POST['door_number'] != 0) {
    $rest_name = $_POST['rest_name'];
    $work_start = $_POST['work_start'];
    $work_end = $_POST['work_end'];
    $district = $_POST['district'];
    $city_id = $_POST['city'];
    $street = $_POST['street'];
    $door_number = (int)$_POST['door_number'];
    $result = addRestaurant($rest_name, $uname, $work_start, $work_end, $district, $city_id, $street, $door_number);
    header("Location: restaurant_list.php");
    die();
}
?>
<center>
    <div class="signup">
        <div class="heading">
            <form method="post"><button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button></form>
        <h2>Add Restaurant</h2>
<form method="post" >

    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "rest_name" placeholder="Name">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "work_start" placeholder="Working Hour Start">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "work_end" placeholder="Working Hour End">
    </div>

    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
    <select  class="egehan" name="city">

        <option class = "spec" value="" disabled selected>Choose Your City</option>

        <?php
            $cities = getCities();
            while($row = mysqli_fetch_array($cities)){
                echo "<option class = 'spec' value=".$row['city_id'].">".$row['name']."</option>";
            }

        ?>

    </select><br></div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
    <select  class="egehan" name="district">

        <option class = "spec" value="">Choose Your District</option>
        <?php
            $districts = getDistricts();
            while ($row = mysqli_fetch_array($districts)) {
                echo "<option class = 'spec' value=" . $row['district'] . ">" . $row['district'] . "</option>";
            }
        ?>
    </select><br></div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "street" placeholder="Street">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="number" class="form-control" name = "door_number" placeholder="Door Number">
    </div>
    <b><font color="white"><?php echo $msg ?></font><br></b>
    <button type="submit" class="float" name = "add_restaurant">Submit</button>
</form>
    </div>
        </div>
</center>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>
</html>
