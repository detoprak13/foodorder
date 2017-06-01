<html lang = "en">
<?php
session_start();
?>
<head>
    <title>Food Order</title> <link REL="StyleSheet" TYPE="text/css" HREF="home.css">
    <?php
    include('functions.php');
    $uname = '';
    if(isset($_SESSION['username'])){
        $uname = $_SESSION['username'];
    }else{
        header("Location: signin.php");
        die();
    }
    if(isset($_POST['Search'])){
        header("Location: search.php");
    }
    if(isset($_POST['edit_profile'])){
        header("Location: edit_profile.php");
    }
    if(isset($_POST['view_cart'])){
        header("Location: cart.php");
    }
    if(isset($_POST['recent_orders'])){
        header("Location: recent_orders.php");
    }
    if(isset($_POST['logout'])){
        header("Location: logout.php");
    }
    if(isset($_POST['my_restaurants'])){
        header("Location: restaurant_list.php");
    }
    ?>
</head>

<body>

    <center>
<div class= "home">
    <div class="heading">
    <h2>Hello, <?php $info = getNameSurname($uname); echo $info["name"]; echo " "; echo $info["surname"]?></h2>
        <form method="post">
            <?php
            if(isCustomer($uname)) {
                echo "<button type='submit' class='float' name = 'Search'><i class='fa fa-search'></i>Search Restaurants In My Region</button><br>";
                echo "<button type='submit' class='float' name = 'edit_profile'><i class='fa fa-edit'></i>Edit Profile</button><br>";
                echo "<button type='submit' class='float' name = 'view_cart'>View Cart</button><br>";
                echo "<button type='submit' class='float' name = 'recent_orders'>View Recent Orders</button><br>";
            }else{
                echo "<button type='submit' class='float' name = 'my_restaurants'>Show My Restaurants</button><br>";
                echo "<button type='submit' class='float' name = 'edit_profile'><i class='fa fa-edit'></i>Edit Profile</button><br>";
            }

            echo "<button type='submit' class='float' name = 'logout'>Logout</button><br>";
            ?>
        </form>
    </div>
</div>

    </center>
</body>
</html>