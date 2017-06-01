<?php
session_start();
?>
<html>
<head>
    <?php
    include('functions.php');
    $uname = '';
    if(isset($_SESSION['username'])){
        $uname = $_SESSION['username'];
    }else{
        header("Location: signin.php");
        die();
    }

    ?>
    <title>Food Order</title></head><link REL="StyleSheet" TYPE="text/css" HREF="edit_profile.css">
<body>

<?php
$msg = '';
if (isset($_POST['edit_profile'])){
    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['district']) && !empty($_POST['city']) && !empty($_POST['street']) && $_POST['door_number'] != 0 && !empty($_POST['phone_number'])){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $district = $_POST['district'];
        $city_id = $_POST['city'];
        $street = $_POST['street'];
        $door_number = (int)$_POST['door_number'];
        $phone_number = $_POST['phone_number'];
        $result = updateUserInfo($uname, $name, $surname, $district, $city_id, $street, $door_number, $phone_number);
        if ($result) {
            $msg = "Update Successful";
        }
    } else{
        $msg = "Error: Please fill all fields.";
    }
}
if(isset($_POST['home'])){
    header("Location: home.php");
}
?>






<center>
    <div class="edit_profile">
        <div class="heading">
            <form method="post">
                <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
            </form>

    <h2>Edit Account Information</h2>
    <?php
        $userArray = getUserInfo($uname);
        $name = $userArray['u_name'];
        $surname = $userArray['surname'];
        $street = $userArray['street'];
        $door_number = $userArray['door_number'];
        $phone_number = $userArray['phonenumber'];
        $city_name = $userArray['c_name'];
        $city_id_old = $userArray['c_id'];
        $district_name = $userArray['district'];
    ?>
    <form method="post">
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
             <input type="text" class="form-control" name="name" value="<?php echo $name?>" placeholder="Name"><br>
            </div>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"></span>
            <input type="text" class="form-control" name="surname" value="<?php echo $surname?>" placeholder="Surname"><br>
                </div>
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
        <select class= "egehan" name="city">
            <option class = "spec" value="<?php echo $city_id_old?>"><?php echo $city_name?></option>
            <?php
            $cities = getCities();
            while($row = mysqli_fetch_array($cities)){
                echo "<option class = 'spec' value=".$row['city_id'].">".$row['name']."</option>";
            }
            ?>
        </select><br></div>
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
        <select class= "egehan" name="district">
            <option class = "spec" value="<?php echo $district_name?>" placeholder="anan"><?php echo $district_name?></option>
            <?php
            $districts = getDistricts();
            while($row = mysqli_fetch_array($districts)){
                echo "<option class = 'spec' value=".$row['district'].">".$row['district']."</option>";
            }
            ?>
        </select><br></div>
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
        <input type="text" class="form-control" name="street" value="<?php echo $street?>" placeholder="Street"><br>
            </div>
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
        <input type="number" class="form-control" name="door_number" value="<?php echo $door_number?>" placeholder="Door Number"><br>
            </div>
        <div class="input-group input-group-lg">
            <span class="input-group-addon"></span>
        <input type="text" class="form-control" name="phone_number" value="<?php echo $phone_number?>" placeholder="Phone Number"><br>
            </div>
        <b><?php echo $msg ?><br></b>
        <button type="submit" class="float" name = "edit_profile">Update</button>


    </form>
    </div>
        </div>
</center>
</body>
</html>

