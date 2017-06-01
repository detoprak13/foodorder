<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="restaurant_list.css">
    <?php include('functions.php');
    $uname = '';
    if(isset($_SESSION['username'])){
        $uname = $_SESSION['username'];
    }else{
        header("Location: signin.php");
        die();
    }
    if(isset($_POST['home'])){
        header("Location: home.php");
    }
    if(isset($_POST['add_restaurant'])){
        header("Location: add_restaurant.php");
    }?>
</head>

<body>

<center>
    <div class="restaurant_list">
        <div class="heading">
            <form method="post">
                <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
                <button type="submit" class="float" name = "add_restaurant">Add Restaurant</button>

            </form>


            <?php

            echo "<h2>Your Restaurants</h2>";


            $is_ordered = false;
            if (isset($_POST['show_restaurant'])) {
                $rest_info = $_POST['show_restaurant'];
                header("Location: restaurant_info.php" . $rest_info);

            }

            $result = getOwnedRestaurants($uname);
            while($row=mysqli_fetch_array($result)){

                $name = $row['name'];

                echo "<form method=\"post\" action=\"\">";
                echo "<button class = 'float but ' type = 'submit'
                name = 'show_restaurant' value= '?name=$name'>";

                echo "<h4>$name</h4> ";



                "</button>";

                echo "</form>";
            }
            ?>
        </div>
    </div>
</center>
</body>
</html>
