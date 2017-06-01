
<html>
<head><title>Food Order</title> <link REL="StyleSheet" TYPE="text/css" HREF="signup.css"> <?php include "functions.php"?></head>
<body>

<?php
$msg = '';
if (isset($_POST['signup']) && !empty($_POST['uname']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['district']) && !empty($_POST['city'])
    && !empty($_POST['street']) && $_POST['door_number'] != 0 && !empty($_POST['phone_number'])) {
    $username = $_POST['uname'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $district = $_POST['district'];
    $city_id = $_POST['city'];
    $street = $_POST['street'];
    $door_number = (int)$_POST['door_number'];
    $phone_number = $_POST['phone_number'];
    $isOwner = $_POST['isOwner'];
    if(isPasswordValid($password)){
      $result = signup_func($username, $password, $name, $surname, $district, $city_id, $street, $door_number, $phone_number, $isOwner);
      if ($result) {
            header("Location: signin.php");
            die();
        } else {
            $msg = "Error: Please fill all fields.";
        }
    }else{
      $msg = "Password must contain at least 6 characters and the first character must alphabetic.";
      echo "aksdmads";
    }


}
?>
<center>
    <div class="signup">
        <div class="heading">
        <h2>Sign Up</h2>
<form method="post" >
    <div class="input-group input-group-lg">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" class="form-control" name = "uname" placeholder="Username">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        <input type="password" class="form-control" name = "password" placeholder="Password">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "name" placeholder="Name">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "surname" placeholder="Surname">
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
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <input type="text" class="form-control" name = "phone_number" placeholder="Phone Number">
    </div>
    <div class="input-group input-group-lg">
        <span class="input-group-addon"></span>
        <h4>Owner?</h4><input type="checkbox" name="isOwner" value="owner">
    </div>
    <b><font color="white"><?php echo $msg ?></font><br></b>
    <button type="submit" class="float" name = "signup">Submit</button>
</form>
    </div>
        </div>
</center>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>
</html>
