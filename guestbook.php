<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require('/home/cdrennan/guestbookConnect.php');
require('includes/guestbookFunctions.inc.php');


$hasReqFName = true;
$hasReqLName = true;
$hasValidHowMet = true;
$hasReqOther = true;
$hasReqEmail = true;
$hasValidEmail = true;
$hasValidUrl = true;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    list($fName, $hasReqFName) = validateReqField("fName");
    list($lName, $hasReqLName) = validateReqField("lName");

    list($howMet, $other, $hasValidHowMet, $hasReqOther) = validateHowMet("howMet", "other");

    list($email, $hasValidEmail) = validateFormat("email", FILTER_VALIDATE_EMAIL);
    $hasReqEmail = hasRequiredEmail($email);
    list($url, $hasValidUrl) = validateFormat("liURL", FILTER_VALIDATE_URL);

    // ["fName"]=> string(4) "Chad" ["lName"]=> string(7) "Drennan" ["title"]=> string(7) "manager"
    // ["company"]=> string(7) "safeway" ["email"]=> string(28) "cdrennan@mail.greenriver.edu"
    // ["mailingList"]=> string(4) "true" ["emailFormat"]=> string(4) "html" ["liURL"]=> string(18) "https://amazon.com"
    // ["howMet"]=> string(0) "" ["other"]=> string(0) "" ["comment"]=> string(10) "my comment"
    if ($hasReqFName && $hasReqLName && $hasReqEmail && $hasValidEmail
                     && $hasValidUrl && $hasValidHowMet && $hasReqOther) {

        // region PROCESS DATA FOR DB INSERT

        // take "other" text input val instead of the word "other"
        if ($howMet === 'other') {
            $howMet = mysqli_real_escape_string($cnxn ,trim($other));
        }

        $fName = mysqli_real_escape_string($cnxn, $fName);
        $lName = mysqli_real_escape_string($cnxn, $lName);

        $title = setEmptyToNull($cnxn ,$_POST['title']);

        $company = trim($_POST['company']);
        $company = empty($company) ? null : "'" . mysqli_real_escape_string($cnxn, $company) . "'";

        $comment = setEmptyToNull($cnxn, $_POST['comment']);
        $email = setEmptyToNull($cnxn, $email);
        $url = setEmptyToNull($cnxn, $url);

        $onMailList = (isset($_POST['mailingList'])) ? 1 : 0;

        $emailFormat = getEmailOption('emailFormat');

        // endregion

        $isSaved = saveGuest($cnxn, $fName, $lName, $title, $company, $email, $onMailList,
                                $emailFormat, $url, $howMet, $comment);

        include "guest-confirmation.php";
    }
    else {
        include "guestbook-form.php";
    }
}
else {
    include "guestbook-form.php";
}


