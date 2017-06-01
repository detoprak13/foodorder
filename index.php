<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title>
    <link REL="StyleSheet" TYPE="text/css" HREF="index.css">
    <?php if(isset($_SESSION['username'])){
        header("Location: home.php");
        die();
    }
    if(isset($_POST['signIn'])){
        header("Location: signin.php");
    }
    if(isset($_POST['signUp'])){
        header("Location: signup.php");
    }
    ?>
</head>

<body>
    <center>

        <div class="index">
            <div class="heading">
        <h2>Food Order</h2>
        <form method ="post">
        <button class = "float"
                name = "signIn">Sign In</button>
            <button class = "float"
                    name = "signUp">Sign Up</button>
        </form>

        </div>

            </div>
    </center>
</body>
</html>
