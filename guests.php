<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();

$loggedIn = true;

if (!isset($_SESSION['username'])) {
    header('location: adminLogin.php');
    $loggedIn = false;
}

require('/home/cdrennan/guestbookConnect.php');
require('includes/guestbookFunctions.inc.php');

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

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

    <title>Guests | Guestbook</title>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="jumbotron banner">
        <h1 class="display-4">Guests</h1>
    </div>

    <a class='h2' href='guestbook.php'>Guestbook Form</a>
    <?php
    if ($loggedIn) {
        echo "<a id='logout' class='h2' href='adminLogout.php'>Logout</a>";
    }
    ?>
    <hr>
    <br>

    <!-- Guests Table -->
    <table id="guestTable" class="display w-100 nowrap">
        <thead>
        <tr>
            <th>Name</th>
            <th>Job Title</th>
            <th>Company</th>
            <th>Email</th>
            <th>On Mail List</th>
            <th>Email Format</th>
            <th>LinkedIn</th>
            <th>How we met</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
        </thead>

        <!-- Guest information -->
        <tbody>
        <?php
        $result = getAllGuests($cnxn);

        while ($row = mysqli_fetch_assoc($result)) {
            $guestId = $row['guestId'];
            $fName = ucwords(strtolower($row['firstName']));
            $lName = ucwords(strtolower($row['lastName']));
            $jobTitle = ucwords(strtolower($row['jobTitle']));
            $company = ucwords(strtolower($row['name']));
            $email = strtolower($row['email']);
            $onMailList = $row['onMailList'] == 1 ? 'Yes' : 'No';
            $emailFormat = $row['emailFormat'];
            $linkedIn = strtolower($row['linkedIn']);
            $howMet = formatHowMet($row['howMet']);
            $comment = $row['comment'];
            $date = date('m/d/Y', strtotime($row['dateAdded']));

            echo "<tr>
                    <td>$fName $lName</td>
                    <td>$jobTitle</td>
                    <td>$company</td>
                    <td>$email</td>
                    <td>$onMailList</td>
                    <td>$emailFormat</td>
                    <td>$linkedIn</td>
                    <td>$howMet</td>
                    <td>$comment</td>
                    <td data-sort='$guestId'>$date</td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('#guestTable').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+ data[0];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        // Order table by join date descending
        "order": [[ 9, "desc" ]]
    });
</script>
</body>
</html>
