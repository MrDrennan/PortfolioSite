<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

if(isset($_SESSION['username'])){
    header('location: guests.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require('/home/cdrennan/guestbookConnect.php');
    require('includes/loginFunctions.inc.php');

    $hasValidLogin = isValidLogin($cnxn, $_POST['username'], $_POST['password']);

    if ($hasValidLogin) {
        $_SESSION['username'] = $_POST['username'];
        header('Location: guests.php');
    }

    // close the db connection
    mysqli_close($cnxn);
}



?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- guestbook CSS -->
    <link rel="stylesheet" type="text/css" href="styles/guestbook.css">
    <link rel="stylesheet" type="text/css" href="styles/guestbookLogin.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/guestbook.png">

    <title>Guestbook | Login</title>
</head>
<body>
<div class="container">
    <header class="jumbotron">
        <h1 class="display-4">Guest Book</h1>
    </header>
    <main>
        <?php

        if (isset($hasValidLogin) && !$hasValidLogin) {
            echo "<span id='loginErr'>Invalid login</span>";
        }
        ?>
        <form method="post" action="#">
            <fieldset id="login" class="form-group">
            <legend><h1>Login</h1></legend>

            <div class="form-group">
                <label for="username" >Username:</label>
                <input id="username" class="form-control" type="text" name="username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" class="form-control" type="password" name="password">
            </div>
            </fieldset>

            <input id="btnLogin" class="btn btn-primary" type="submit" name="submit" value="Login">
        </form>
    </main>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
