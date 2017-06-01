<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title>
    <link REL="StyleSheet" TYPE="text/css" HREF="rank_comment.css">
    <?php
    include('functions.php');
    $uname = '';
     if(isset($_SESSION['username'])){
        $uname = $_SESSION['username'];
    }else{
        header("Location: signin.php");
        die();
    }
    $order_id = $_GET['order_id'];
    ?>
</head>

<body>
  <?php
    if(isset($_POST['rate']) && isset($_POST['comment'])){
      $rate = $_POST['rate'];
      $comment = $_POST['comment'];
      rankOrder($order_id, $rate, $comment, $uname);
      header("Location: recent_orders.php");
    }

   ?>
<center>

    <div class="rank_comment">
        <div class="heading">
            <h2>Food Order</h2>
            <form method ="post">

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"></span>
                        <input type="number" class="form-control" name = "rate" placeholder="Rate (out of 10)">
                        </div>
                <div class="input-group input-group-lg cem">
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name = "comment" placeholder="Comments Here!">
                </div>
                        <button class = "float"
                        name = "submit">Submit</button>

            </form>

        </div>

    </div>
</center>
</body>
</html>
