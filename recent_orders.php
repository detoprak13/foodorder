<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="recent_orders.css">
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
    }
    if(isset($_POST['rank_comment'])){
        $order_id = $_POST['rank_comment'];
        header("Location: rank_comment.php?order_id=".$order_id);
    }
    ?>
</head>

<body>
<div class="recent_orders">
    <div class="heading">
        <form method="post">
        <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
        </form>
<center>
    <h2>Recent Orders</h2>

    <form method="post" action="">
    <?php
    $get_recent_orders_result = getRecentOrders($uname);

    date_default_timezone_set('Europe/Istanbul');
    $current_date = date('Y-m-d H:i:s');
        while($row = mysqli_fetch_array($get_recent_orders_result)){
          $is_two_week = false;
          $diff =  strtotime($current_date) - strtotime($row['date']);
          $years = floor($diff / (365*60*60*24));
          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
          if($days > 14 || $months > 0 || $years > 0) $is_two_week = true;
          if(!$is_two_week){
            $order_id= $row['o_id'];
              echo "<h5>";
              echo $row['r_name']." | ";
              echo $row{'total_cost'}."₺ | ";
              echo $row['date']."  ";
              echo "</h5>";
              if(canComment($order_id, $uname)){
              echo "<button class = 'float but' type = \"submit\" name = \"rank_comment\" value = $order_id>Rank/Comment</button>";
              echo "<br>";
            }
          }
        }
    ?>

     </form>
    </div>
</div>
</center>
</body>
</html>
