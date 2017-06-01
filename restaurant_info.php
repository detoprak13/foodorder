<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="restaurant_info.css">
    <?php
    include('functions.php');
    $uname = '';
    if(isset($_SESSION['username'])){
        $uname = $_SESSION['username'];
    }else{
        header("Location: signin.php");
        die();
    }
    $restname = $_GET['name'];
    ?>

</head>

<body>
<?php

if(isset($_POST['home'])){
    header("Location: home.php");
}
if(isset($_POST['view_orders'])){
    header("Location: restaurant_orders.php?restname=".$restname);
}
if(isset($_POST['add_menu_item'])){
    header("Location: add_menu_item.php?restname=".$restname);
}
if(isset($_POST['add_region'])){
    header("Location: add_region.php?restname=".$restname);
}
if(isset($_POST['remove_menu_item'])){
  $item_id = $_POST['remove_menu_item'];
  removeMenuItem($restname, $uname, $item_id);
}
$msg = '';
if(isset($_POST['remove'])){
  $order_count = getUnprocessedOrderCount($restname, $uname);
  if($order_count != 0){
    $msg = "Can't remove. Unprocessed orders exist.";
  }else{
    removeRestaurant($restname, $uname);
    header("Location: restaurant_list.php");
  }
}
if(isset($_POST['add_payment'])){
  $pay_id = $_POST['add_payment_method'];
  addPaymentToRestaurant($uname, $restname, $pay_id);
}
?>
<div class="restaurant_info">
    <div class="heading">
        <form method="post">
            <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
        </form>



        <center>

            <?php
            echo "<h2>$restname</h2><br>";
            echo "<font color='white'>".$msg.'</font>';
            $rest_info_result = getRestaurantMenu($uname,$restname);
            echo "<form method='post'>";
            while($row = mysqli_fetch_array($rest_info_result)){
                $name = $row['name'];
                $price = $row['price'];
                $is_available = $row['is_available'];
                $type = $row['type'];
                $item_id = $row['i_id'];
                if($is_available){
                    echo "<h5>".$name." ".$price."₺ ".$type."</h5>";
                    echo "<button class = 'float but' type = \"submit\"
                    name = \"remove_menu_item\" value=$item_id>Remove</button>";
                }
                echo "<br>";
            }
            echo "</form>";
            echo "<form method='post'>";
            echo "<button type='submit' class='float' name = 'add_menu_item'>Add Menu Item</button>";
            echo "</form>";
            ///
            $rest_serves_info = getRestaurantServing($restname, $uname);
            while($row = mysqli_fetch_array($rest_serves_info)){
              $service_time = $row['service_time'];
              $minimum_cost = $row['minimum_cost'];
              $district = $row['district'];
              echo "<h5>".$district." ".$minimum_cost."₺ ".$service_time."</h5>";
            }

            echo "<form method='post'>";
            echo "<button type='submit' class='float' name = 'add_region'>Add Region</button>";
            echo "</form>";
            $accepted_payments = getPaymentTypes($restname, $uname);
            while($row = mysqli_fetch_array($accepted_payments)){
              echo "<h4>".$row['payment_type']."</h4><br>";

            }
            $payments = getPossiblePayments();
            echo "<form method='post'>";
            echo "<div class='input-group input-group-lg'>";
            echo "<select  class='egehan' name='add_payment_method'>";
            echo "<option class = 'spec' value=''>Choose a Payment Method</option>";
            while($row = mysqli_fetch_array($payments)){
              $pay_id = $row['pay_id'];
              echo $pay_id;
              $pay_type = $row['payment_type'];
              echo "<option class='spec' value='".$pay_id."'>".$pay_type."</option>";
            }
            echo "</select><br></div>";

            echo "<button type='submit' class='float' name = 'add_payment'>Add Payment Method</button>";
            echo "</form>";
            echo "<form method='post'>";
            echo "<button type='submit' class='float' name = 'view_orders'>View Orders</button>";

            echo "</form>";
            echo "<form method='post'>";
            echo "<button type='submit' class='float' name = 'remove'>Remove Restaurant</button>";

            echo "</form>";

            ?>

    </div>
</div>
</center>
</body>
</html>
