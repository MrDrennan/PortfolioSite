<?php
session_start();

$loggedIn = true;

if (!isset($_SESSION['username'])) {
    $loggedIn = false;
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
    <?php

    if ($loggedIn) {
        echo "
        <style>
            #logout {
                display: block;
                float: right;
            }
        </style>";
    }

    ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/guestbook.png">

    <title>Guestbook | Form</title>
</head>
<body>
<div class="container">
    <header class="jumbotron">
        <h1 class="display-4">Guest Book</h1>
        <p class="lead">Thanks for attending!</p>
    </header>
    <main>
        <a class="h2" href="guests.php">All Guests</a>
        <?php
        if ($loggedIn) {
            echo "<a id='logout' class='h2' href='adminLogout.php'>Logout</a>";
        }
        ?>
        <hr>
        <br>

        <form id="guest-form" action="#" method="post">
            <fieldset class="form-group">
                <legend>Personal Info</legend>

                <div class="form-group">
                    <label for="fName">First Name*</label>
                    <input type="text" id="fName" name="fName" class="form-control required" <?php stickVal('fName'); ?>>
                    <span class="err" id="err-fName" <?php showError($hasReqFName); ?>>Please enter your first name</span>
                </div>

                <div class="form-group">
                    <label for="lName">Last Name*</label>
                    <input type="text" id="lName" name="lName" class="form-control required" <?php stickVal('lName'); ?>>
                    <span class="err" id="err-lName" <?php showError($hasReqLName); ?>>Please enter your last name</span>
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" <?php stickVal('title'); ?>>
                </div>

                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" class="form-control" <?php stickVal('company'); ?>>
                </div>
            </fieldset>

            <fieldset class="form-group">
                <legend>Contact Info</legend>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" <?php stickVal('email'); ?>>
                    <span class="err" id="err-format-email" <?php showError($hasValidEmail); ?>>
                        Please enter a valid email
                    </span>
                    <span class="err" id="err-email" <?php showError($hasReqEmail); ?>>
                        Please enter your email for the mailing list
                    </span>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="mailingList" name="mailingList" value="true" class="form-check-input"
                        <?php stickCheck('mailingList', 'true'); ?>>
                    <label for="mailingList">Please add me to your mailing list</label>
                </div>

                <div class="form-group" id="emailFormatSection">
                    <p>Which email format do you prefer?</p>
                    <div class="form-check">
                        <input type="radio" id="html" name="emailFormat" value="html" class="form-check-input"
                        <?php stickCheck('emailFormat', 'html'); ?>>
                        <label for="html">HTML</label>
                    </div>

                    <div class="form-check">
                        <input type="radio" id="text" name="emailFormat" value="text" class="form-check-input"
                        <?php stickCheck('emailFormat', 'text') ?>>
                        <label for="text">Text</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="liUrl">LinkedIn URL</label>
                    <input type="text" id="liURL" name="liURL" class="form-control" <?php stickVal('liURL'); ?>>
                    <span class="err" id="err-format-liURL" <?php showError($hasValidUrl); ?>>
                        Please enter a valid URL
                    </span>
                </div>
            </fieldset>

            <fieldset class="form-group">
                <legend>How did we meet?*</legend>

                <div class="form-group">
                    <select class="form-control required" id="howMet" name="howMet">
                        <option value="" <?php stickSelect('howMet' , ''); ?>>Select</option>
                        <option value="meetup" <?php stickSelect('howMet' , 'meetup'); ?>>Meetup</option>
                        <option value="jobFair" <?php stickSelect('howMet' , 'jobFair'); ?>>Job fair</option>
                        <option value="notMet" <?php stickSelect('howMet' , 'notMet'); ?>>Haven't met</option>
                        <option value="other" <?php stickSelect('howMet' , 'other'); ?>>Other</option>
                    </select>
                    <span class="err" id="err-howMet" <?php showError($hasValidHowMet); ?>>Please select how we met</span>
                </div>

                <div class="form-group" id="otherSection">
                    <label for="other">Other* (please specify)</label>
                    <input type="text" id="other" name="other" class="form-control" <?php stickVal('other'); ?>>
                    <span class="err" id="err-other" <?php showError($hasReqOther); ?>>Please describe how we met</span>
                </div>
            </fieldset>

            <fieldset class="form-group">
                <legend>Comment</legend>
                <textarea id="comment" name="comment" class="form-control"><?php
                    if (isset($_POST['comment'])) echo $_POST['comment'] ?></textarea>
            </fieldset>

            <button id="" type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </main>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="scripts/guestbook.js"></script>
</body>
</html>