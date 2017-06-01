<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="restaurant_orders.css">
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
    $restname = $_GET['restname'];?>
</head>

<body>
<?php
  if(isset($_POST['complete_order'])){
    $order_id = $_POST['complete_order'];
    completeOrder($order_id);
  }
  ?>
<div class="restaurant_orders">
    <div class="heading">
        <form method="post">
            <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
        </form>
        <center>
            <h2><?php echo $restname?>'s Orders</h2>

            <form method="post" action="">
                <?php
                $get_rest_orders_result = getRestaurantOrders($uname,$restname);

                while($row = mysqli_fetch_array($get_rest_orders_result)){
                        echo "<h5>";
                        $order_id = $row['o_id'];
                        echo $row['username']." | ";
                        echo $row{'total_cost'}."₺ | ";
                        echo $row['date']." | ";
                        $status = $row['status'];
                        if($status == 0) echo 'Unprocessed ';
                        else echo 'Completed ';
                        echo "</h5>";
                        if($status == 0)
                          echo "<button class = 'float but' type = \"submit\" name = \"complete_order\" value = $order_id>Complete</button>";
                        echo "<br>";
                }
                ?>

            </form>
    </div>
</div>
</center>
</body>
</html>
