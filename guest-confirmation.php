<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/guestbook.png">

    <title>Guestbook | Confirmation</title>
</head>
<body>
<div class="container">
    <header class="jumbotron">
        <h1 class="display-4">Guest Book</h1>

        <?php

        // if all data was saved successfully
        if ($isSaved) {
            echo "<h2>Success!! Your information has been submitted.</h2>
                  <p class='lead'>Thanks for signing!</p>";
        }
        else {
            echo "<h2>There was an error. Your information was not submitted.</h2>";
        }

        ?>
    </header>

    <?php

    if ($isSaved) {
        echo "<h1 class='h3'>".$_POST["fName"]." ".$_POST["lName"]." wrote...</h1>";
        echo "<p>".$_POST["comment"]."</p>";
    }
    ?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script></script>
</body>
</html>