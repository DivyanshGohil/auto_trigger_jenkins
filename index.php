<?php
include 'classes/sessions.php';
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'classes/messages.php';
include_once 'initial.php'; // connect to database

$records_per_page = 25; 
$from_record_num = 1;

$user = new User($db);
$session = new session_data();
$err = new Messages();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <title>Demo CRUD - OOP</title>
</head>

<body>

    <div class="container">
        <?php include('./includes/menu.php'); ?>

        <?php
        $err->print_msg($session->get("err_code"));
        $session->reset('err_code');
        ?>

        <div class="row">
            <div class="col-12">
                <div class='float-end m-3'>
                    <a href="create.php" class="btn btn-lg btn-success">Create Users</a>
                </div>

                <?php
                // select all users
                $prep_state = $user->getAllUsers($from_record_num, $records_per_page); 
                $num = $prep_state->rowCount();

               
                if ($num >= 0) {

                    echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>E-Mail</th>";
                    echo "<th>Mobile</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";

                    while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)) {

                        $id = $row['id'];

                        echo "<tr>";

                        echo "<td>$row[firstname]</td>";
                        echo "<td>$row[lastname]</td>";
                        echo "<td>$row[email]</td>";
                        echo "<td>$row[mobile]</td>";

                        echo "<td>";
                        // edit user button
                        echo "<a href='edit.php?id=" . $id . "' class=' btn btn-warning m-1'>";
                        echo "Edit";
                        echo "</a>";

                        // delete user button
                        echo "<a href='actions/act_delete.php?id=" . $id . "' class='btn btn-danger delete-object'>";
                        echo "Delete";
                        echo "</a>";

                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
               }

                // if there are no user
                else {
                    echo "<div> No User found. </div>";
                }
                ?>
            </div>
        </div>
        <?php include('./includes/footer.php'); ?>
    </div>
</body>

</html>