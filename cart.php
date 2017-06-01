<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="cart.css">
    <?php
    include('functions.php');
    $uname = '';
    $msg = '';
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
<div class="cart">
    <div class="heading">
        <form method="post">
        <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
        </form>
<center>
    <h2><?php $info = getNameSurname($uname); echo $info["name"]; echo " "; echo $info["surname"]?>'s Cart</h2>
    <?php
    if(isset($_POST['empty_cart'])){
        empty_cart($uname);
    }
    if(isset($_POST['place_order'])){
      $payment_type = $_POST['payment_type'];
      $is_valid = true;
      $total_cost = $_POST['total_cost'];
      if(is_numeric($payment_type)){
        date_default_timezone_set('Europe/Istanbul');
        $date_time = date('Y-m-d H:i:s');
        if($_POST['date_time'] != ''){
          if($date_time > $_POST['date_time']){
            $is_valid = false;
            $msg = "Please provide a future date.";
          }else{
            $diff = $_POST['date_time'] - strtotime($date_time);
            $years = floor($diff / (365*60*60*24));
            echo $years;
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            echo $months;
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            echo $days;
            if($days > 2 || $years > 0 || $months > 0){
              $msg = "You can order 2 days advanced at most.";
              $is_valid = false;
            }
          }
        }
        if($is_valid){
          placeOrder($uname, $payment_type, $date_time, $total_cost);
        }
      }else{
        $msg = "Please select payment type.";
      }

    }
    if(isset($_POST['remove_item'])){
        $item_id = $_POST['remove_item'];
        removeItemFromCart($uname, $item_id);
    }
    ?>
    <form method="post" action="">
    <?php
    $count = 0;
    $is_same_restaurant = true;
    $get_cart_result = getCart($uname);
    $total_cost = 0;
    if($row = mysqli_fetch_array($get_cart_result)){
        $prev_rest_name = $row['r_name'];
        $prev_own_name = $row['o_name'];
        echo "<h5>";
        echo $row['r_name']." | ";
        echo $row{'name'}." | ";
        echo $row['price']."₺ | ";
        echo $row['amount'];
        $total_cost += ($row['price']*$row['amount']);
        echo "</h5>";
        $item_id = $row['i_id'];
        echo "<button class = 'float but' type = \"submit\" name = \"remove_item\" value = $item_id>Remove</button>";
        echo "<br>";
        $count++;
    }

        while($row = mysqli_fetch_array($get_cart_result)){
            echo "<h5>";
            echo $row['r_name']." | ";
            echo $row{'name'}." | ";
            echo $row['price']."₺ | ";
            echo $row['amount'];
            $total_cost += ($row['price']*$row['amount']);
            echo "</h5>";
            $item_id = $row['i_id'];
            echo "<button class = 'float but' type = \"submit\" name = \"remove_item\" value = $item_id>Remove</button>";
            echo "<br>";
            $count++;

            if($prev_rest_name!=$row['r_name'] || $prev_own_name!=$row['o_name']){
                $is_same_restaurant = false;
            }
            $prev_rest_name = $row['r_name'];
            $prev_own_name = $row['o_name'];

        }
    ?>
        <?php
            if($count != 0) {


                echo "<h4>Total Cost: ".$total_cost."₺</h4><br>";
                echo '<input type="hidden" name="total_cost" value="'.$total_cost.'">';
                if($is_same_restaurant){
                  date_default_timezone_set('Europe/Istanbul');
                  $current_time = date('h:i:s');
                  $row = mysqli_fetch_array(getRestaurantInformation($prev_own_name,$prev_rest_name));
                  $work_time_start = $row['work_start'];
                  $work_time_end = $row['work_end'];
                  if($current_time < $work_time_end && $current_time > $work_time_start){
                    echo '
                    <select  class="egehan" name="payment_type">

                        <option class = "spec" value="payment_type">Choose Payment Type</option>';
                          $payment_types = getPaymentTypes($prev_rest_name,$prev_own_name);
                          while ($payment_row = mysqli_fetch_array($payment_types)) {
                              echo "<option class = 'spec' value=" . $payment_row['pay_id'] . ">" . $payment_row['payment_type'] . "</option>";
                          }

                    echo '</select><br>';
                    echo '<input type="text" class="form-control" name = "date_time" placeholder="Date and time (Format: Y-m-d H:i:s.)"><br>';
                    echo '<h4>'.$msg.'</h4>';
                      echo "<button class = 'float but1' type = \"submit\" name = \"empty_cart\">Empty Cart</button>";
                    echo "<button class = 'float but2' type = \"submit\" name = \"place_order\">Place Order</button>";
                  }else{
                      echo "<br><h4>Restaurant is closed. You can't order.</h4>";
                  }
                }
                else
                    echo "<br><h4>Please order from the same restaurant.</h4>";

            }

        ?>

     </form>
    </div>
</div>
</center>
</body>
</html>
