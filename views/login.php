<?php include_once("../functions/functions.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Navigtion -->
    <?php include_once("navigation.php") ?>

    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $message = login($email, $password);
        if ($message) {
            echo
            "<div class='row justify-content-center text-center m-5'>
                <div class='col-md-3'>
                    <div class='alert alert-danger text'>
                        $message
                    </div>
                </div>
            </div>";
        }
    }
    ?>

    <form action="#" method="POST" class="m-5">
        <div class="row justify-content-center mb-3">
            <div class="col-sm-3">
                <label for="area" class="col-sm-2 col-form-label">Имейл</label>
                <input type="text" required class="form-control" name="email">
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-sm-3">
                <label for="area" class="col-sm-2 col-form-label">Парола</label>
                <input type="password" required class="form-control" name="password">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-1">
                <button class="btn btn-primary" type="submit" name="login">Влизане</button>
            </div>
        </div>
    </form>

</body>

</html>