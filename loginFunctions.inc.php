<?php
function isValidLogin($cnxn, $username, $password) {
    if (empty($username) || empty($password)) {
        return false;
    }
    else {
        $username = mysqli_real_escape_string($cnxn, $username);
        $password = mysqli_real_escape_string($cnxn, $password);
    }

    $sql = "SELECT COUNT(*)
            FROM administrator
            WHERE username = '$username' AND password = SHA2('$password', 512)";

    $qResult = mysqli_query($cnxn, $sql);

    return $qResult && mysqli_num_rows($qResult) === 1;
}
