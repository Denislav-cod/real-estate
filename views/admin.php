<!-- Logic -->
<?php include_once("../functions/functions.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панел</title>
</head>

<body>

    <!-- Navigtion -->
    <?php include_once("navigation.php") ?>

    <?php
    if (!isset($_COOKIE['logAndReg'])) {
        header('Location: http://localhost/php/Php-project/Project/view/login.php');
    }
    ?>

    <?php
    $admin = adminProps();
    echo "<div class='row justify-content-center m-4 p-4 gap-4'>";
    foreach ($admin as $p => $value) {
        echo "<div class='card' value='' style='width:18rem;'>";
        echo "<img src='../images/" . $value['img'] . "' class='card-img-top' style='height: 100px' alt='Image alt'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'> Тип: " . $value['type'] . "</h5>";
        echo "<p class='card-text'> Площ: " . $value['area'] . " m<sup>2</sup></p>";
        echo "<p class='card-text'> Цена: $" . $value['price'] . "</p>";
        echo "<p class='card-text'> Град: " . $value['town'] . "</p>";
        echo "<p class='card-text'> Квартал: " . $value['neighborhood'] . "</p>";
        echo "<p class='card-text'> Публикувано от: " . $value['name'] . "</p>";
        echo "<p class='card-text'> Контакт: " . $value['email'] . "</p>";
        echo "</div>";
        echo "<form action='#' method='POST' class='text-center mb-3'>";
        echo "<input type='hidden' name='id' value=" . $value['id'] . ">";
        if (!strcmp($value['status'], 'pending')) {
            echo "<button class='btn btn-success' type='submit' name='accept'>Приемане</button>";
        }
        echo "<button class='btn btn-danger m-1' type='submit' name='delete'>Изтриване</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";

    if (isset($_POST['accept'])) {
        $id = $_POST['id'];
        updateStatus($id);
        echo "<meta http-equiv='refresh' content='0'>";
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        delete($id);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    ?>
</body>

</html>