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
if (isset($_POST['add_region']) && !empty($_POST['district']) && !empty($_POST['service_time']) && !empty($_POST['min_cost'])) {
    $min_cost = $_POST['min_cost'];
    $service_time= $_POST['service_time'];
    $re_id = $_POST['district'];
    $is_valid_service = true;
    $hour = (int)$service_time[0];
    if($hour != 0){
      $is_valid_service = false;
    }
    $hour = (int)$service_time[1];
    if($hour >= 2){
      $min = (int)$service_time[3];
      if($min != 0){
        $is_valid_service = false;
      }else{
        $min_1 = (int)$service_time[4];
        if($min_1 != 0){
          $is_valid_service = false;
        }
      }
    }
    if($is_valid_service){
      $result = addRegionToRestaurant($restname, $uname, $re_id, $service_time, $min_cost);
      if ($result) {
          header("Location: restaurant_info.php?name=".$restname);
      } else {
          $msg = "Error: Please fill all fields.";
      }
    }else{
      $msg = 'Service time cannot be more than 2 hours';
    }


}
?>
<center>
    <div class="add_menu_item">
        <div class="heading">
            <h2>Add Region To <?php echo $restname?></h2>
            <form method="post" >
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <select  class="egehan" name="district">

                        <option class = "spec" value="">District</option>
                        <?php
                        $districts = getPossibleDistricts($restname, $uname);
                        while ($row = mysqli_fetch_array($districts)) {
                            echo "<option class = 'spec' value=" . $row['re_id'] . ">" . $row['district'] . "</option>";
                        }
                        ?>
                    </select><br></div>

                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name = "service_time" placeholder="Service Time (HH:MM)">
                </div>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name = "min_cost" placeholder="Minimum Cost">
                </div>


                <b><font color="white"><?php echo $msg ?></font><br></b>
                <button type="submit" class="float" name = "add_region">Add</button>
            </form>
        </div>
    </div>
</center>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>
</html>
