<?php

function showError($isValid) {
    if (!$isValid) {
        echo "style='display:initial;'";
    }
}

function validateReqField($name) {
    $value = trim($_POST[$name]);

    if (empty($value)) {
        return array(null, false);
    }
    return array($value, true);
}

function hasRequiredEmail($email) {
    return !empty($email) || !isset($_POST['mailingList']) || !$_POST['mailingList'] === "true";
}

function validateFormat($postKey, $filter) {
    $value = trim($_POST[$postKey]);
    $hasValidFormat = true; // only show format error on entered value

    // if not empty and format is invalid
    if (!empty($value) && !filter_var($value, $filter)) {
        $hasValidFormat = false;
    }
    return array($value, $hasValidFormat);
}

function validateHowMet($howMetKey, $otherKey) {
    $howMet = trim($_POST[$howMetKey]);
    $other = trim($_POST[$otherKey]);
    $hasValidHowMet = true;
    $hasReqOther = true;

    if(!empty($howMet)) {
        if ($howMet === 'other' && empty($other)) {
            $hasReqOther = false;
            $other = null;
        }
        else if ($howMet !== 'meetup' && $howMet !== 'jobFair' && $howMet !== 'notMet' && $howMet !== 'other') {
            $hasValidHowMet = false;
            $howMet = null;
            $other = null;
        }
    }
    else {
        $hasValidHowMet = false;
        $howMet = null;
        $other = null;
    }
    return array($howMet, $other, $hasValidHowMet, $hasReqOther);
}


function stickVal($postKey) {
    if (isset($_POST[$postKey])) {
        echo "value=\"$_POST[$postKey]\"";
    }
}

function stickCheck($postKey, $val) {
    if (isset($_POST[$postKey]) && $_POST[$postKey] === $val) {
        echo "checked";
    }
}

function stickSelect($postKey, $val) {
    if (isset($_POST[$postKey]) && $_POST[$postKey] === $val) {
        echo "selected";
    }
}

function saveGuest($cnxn, $fName, $lName, $title, $company, $email, $onMailList,
                    $emailFormat, $url, $howMet, $comment) {

    $companyId = saveUniqueCompany($cnxn, $company);

    // if could not find or insert the company
    if ($companyId === 0) {
        return false;
    }

    $insertGuestResult =  insertGuest($cnxn, $companyId, $fName, $lName, $title, $email, $onMailList,
                                        $emailFormat, $url, $howMet, $comment);

    return $insertGuestResult;
}

function saveUniqueCompany($cnxn, $company) {
    if (isset($company)) {
        $companyId = getCompanyId($cnxn, $company);

        // Insert company if not found
        if ($companyId == 0 && insertCompany($cnxn, $company)) {
            $companyId = $cnxn->insert_id;
        }
        return $companyId;
    }
    return 'NULL';
}

function insertGuest($cnxn, $companyId, $fName, $lName, $title, $email,
                     $onMailList, $emailFormat, $url, $howMet, $comment) {

    $insert = "INSERT INTO guest (companyId, firstName, lastName, email, onMailList, emailFormat, 
                                  linkedIn, jobTitle, howMet, comment, dateAdded)
               VALUES ($companyId, '$fName', '$lName', $email, $onMailList, $emailFormat, 
                                  $url, $title, '$howMet', $comment, NOW())";

    return mysqli_query($cnxn, $insert);
}

function insertCompany($cnxn, $companyName) {
    $insert = "INSERT INTO company (name)
               VALUES ($companyName)";

    return mysqli_query($cnxn, $insert);
}

function getCompanyId($cnxn, $company) {
    $sql = "SELECT companyId 
            FROM company 
            WHERE $company = name";

    $result = mysqli_query($cnxn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['companyId'];
    }
    return 0;
}

function getAllGuests($cnxn) {
    $sql = 'SELECT *
            FROM guest 
            LEFT JOIN company 
                ON guest.companyId = company.companyId
            ORDER BY guestId DESC;';

    return mysqli_query($cnxn, $sql);
}

function setEmptyToNull($cnxn, $value) {
    $value = trim($value);
    return empty($value) ? 'NULL' : "'".mysqli_real_escape_string($cnxn, $value)."'";
}

function getEmailOption($emailOption) {
    if (isset($_POST[$emailOption]) && ($_POST[$emailOption] === 'html' || $_POST[$emailOption] === 'text')) {
        return "'$_POST[$emailOption]'";
    }
    return 'NULL';
}

function formatHowMet($howMet) {
    switch ($howMet) {
        case 'meetup':
            return 'Meetup';
        case 'jobFair':
            return 'Job fair';
        case 'notMet':
            return "Haven't met";
        case 'other':
            return "Other";
        default:
            return $howMet;
    }
}
