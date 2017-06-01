<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="search.css">
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
    }?>
</head>

<body>

<center>
    <div class="search">
        <div class="heading">
            <form method="post">
                <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>

            </form>


    <?php
    $msg= "";
    echo "<form method=\"get\" action=\"\">";
    echo "<button class = 'float' type = \"submit\"
        name = \"order_service\">Order by Service Time</button><br>";
    echo "<h2>Restaurants In Your Region</h2>";
    echo "</form>";

    $is_ordered = false;
        if (isset($_POST['show_restaurant'])) {
            $rest_info = $_POST['show_restaurant'];
            header("Location: restaurant.php".$rest_info);

        }
        if (isset($_GET['order_service'])) {
            $is_ordered = true;
        }
        date_default_timezone_set('Europe/Istanbul');
        $current_time = date('h:i:s');
        $result = searchRestaurant($uname, $is_ordered);
        while($row=mysqli_fetch_array($result)){

            $name = $row['name'];
            $owner = $row['o_name'];
            echo "<form method=\"post\" action=\"\">";
            echo "<button class = 'but float' type = \"submit\"
                name = \"show_restaurant\" value=\"?name=".$name."&owner=".$owner."\">";
            $msg+=$name;
            echo "<h4>  $name  |</h4> ";
            $work_time_start = $row['work_start'];
            $work_time_end = $row['work_end'];
            $service_time = $row['service_time'];
            $minimum_cost = $row['minimum_cost'];
            if($current_time < $work_time_end && $current_time > $work_time_start){
                $msg=$msg."Open|";
                echo "<h4> Open |</h4> ";
            }else{
                $msg=$msg."Closed|";
                echo "<h4> Closed |</h4> ";
            }
            $msg+=$service_time;
            echo "<h4> $service_time | </h4>";
            echo "<h4> $minimum_cost ₺ </h4>";

            "</button>";

            echo "</form>";
        }
    ?>
            </div>
        </div>
</center>
</body>
</html>
