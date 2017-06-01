<?php
ob_start();
session_start();
?>

<html lang = "en">

<head>
    <title>Food Order</title>
    <link REL="StyleSheet" TYPE="text/css" HREF="signin.css">
    <?php
        include('functions.php');
    ?>
</head>

<body>
<center>


<div class = "container form-signin">

    <?php
    $msg = '';

    if (isset($_POST['login']) && !empty($_POST['username'])
        && !empty($_POST['password'])) {
        $uname = $_POST['username'];
        $pw = $_POST['password'];
        if(!check_credentials($uname, $pw)){
            $msg = 'Wrong username or password';
        }else{
            $_SESSION['username'] = $uname;
            header("Location: home.php");
            die();
        }
    }
    ?>

</div> <!-- /container -->
    <div class="login">
        <div class="heading">
            <h2>Sign in</h2>
            <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
            ?>" method = "post">

                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name = "username" placeholder="Username" required autofocus>
                </div>

                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name = "password" placeholder="Password" required>

                </div>
                <h4><br><?php echo $msg; ?></h4>

                <button type="submit" class="float" name = "login">Login</button>
            </form>
            <h4>Click <a href = "signup.php" title = "Signup">here</a> to sign up.</h4>
        </div>
    </div>


</center>
</body>
</html>