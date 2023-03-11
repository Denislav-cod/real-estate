<!-- Header -->
<?php include_once("header.php") ?>
<!-- Navigtion -->
<?php include_once("navigation.php") ?>

<?php include_once("../functions/functions.php") ?>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $message = login($email, $password);
    if($message){
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

<body>
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

<?php include_once("./footer.php") ?>