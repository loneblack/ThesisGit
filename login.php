<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Login</title>
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" action="login_DB.php"> <!-- added action link and method-->
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">

            <!-- ginalaw ko-->
            <?php

    if(isset($_SESSION["Lmessage"]))
        {

            echo "wrong username or password";
            unset($_SESSION["Lmessage"]);
        }
    ?>
    <!-- ginalaw ko-->

            <div class="user-login-info">
                <input name="username" type="text" class="form-control" placeholder="Username" autofocus required><!-- added name-->
                <input name="password" type="password" class="form-control" placeholder="Password" required><!-- added name-->
            </div>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
            <center>Need Assets? Click this <a href="donation_form.php">link</a> for donations.</center>
        </div>
      </form>
    </div>



    <!-- Wag nga galawin kulit -->


    

    <!--Core js-->
    <script type="text/javascript">$('#failModal').modal("show")</script>
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>

  </body>
</html>
