<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title><link REL="StyleSheet" TYPE="text/css" HREF="restaurant.css">
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
    $owner = $_GET['owner'];
    ?>

</head>

<body>
<?php
    if(isset($_POST['add_cart'])){
        $item_id = $_POST['add_cart'];
        addCart($uname,$item_id);
    }
    if(isset($_POST['make_favorite'])){
        addToFavorites($uname,$restname,$owner);
    }
    if(isset($_POST['removefavorite'])){
        removeFromFavorites($uname,$restname,$owner);
    }
    if(isset($_POST['home'])){
        header("Location: home.php");
    }
if(isset($_POST['cart'])){
    header("Location: cart.php");
}

?>
<div class="restaurant">
    <div class="heading">
        <form method="post">
            <button type="submit" class="float" name = "home"><i class="fa fa-home"></i>Home</button>
            <button type="submit" class="float" name = "cart">Cart</button>
        </form>


<center>

    <?php
        $most_ordered = getMostOrdered($restname,$owner);
        echo "<form method=\"post\" action=\"\">";
        $rest_info_result = getRestaurantMenu($owner,$restname);
        echo "<h2>".$restname."</h2>";
    if(isAlreadyFavored($uname,$restname,$owner)){
        echo "<button class = float type = \"submit\" name = \"removefavorite\">Remove From Favorites</button>";
    }else{
        echo "<button class = float type = \"submit\" name = \"make_favorite\">Add to Favorites</button>";
    }

    echo "<br>";
    if(isset($most_ordered['i_id'])){
        $most_ordered_id = $most_ordered['i_id'];
        $most_ordered_name = $most_ordered['name'];
        $most_ordered_type = $most_ordered['type'];
        $most_ordered_price = $most_ordered['price'];
        echo "<b><h5>Most Ordered Item:</b></br>";
        echo $most_ordered_name." ".$most_ordered_price."₺ ".$most_ordered_type."</h5>";
        echo "<button class = 'float but' type = \"submit\"
                name = \"add_cart\" value=$most_ordered_id>Add to Cart</button>";
    }


        while($row = mysqli_fetch_array($rest_info_result)){
            $name = $row['name'];
            $price = $row['price'];
            $is_available = $row['is_available'];
            $type = $row['type'];
            $item_id = $row['i_id'];
            if($is_available){
                echo "<h5>".$name." ".$price."₺ ".$type."</h5>";
                echo "<button class = 'float but' type = \"submit\"
                name = \"add_cart\" value=$item_id>Add to Cart</button>";
            }
            echo "<br>";
        }
    echo "</form>";
    ?>
    </div>
    </div>
</center>
</body>
</html>
