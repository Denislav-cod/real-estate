<?php include_once("../functions/functions.php") ?>

<?php
if (!isset($_COOKIE['logAndReg'])) {
    header('Location: http://localhost/php/Php-project/Project/view/login.php');
}
?>

<div class="container p-5">
    <?php
    //Variable to track the correctness of the data 
    $correctData = FALSE;

    //If the button Sell is submitted
    if (isset($_POST["submit"])) {
        $price = $_POST["price"];
        $type = $_POST["type"];
        $area = $_POST["area"];
        $town = $_POST["town"];
        $neighborhood = $_POST["neighborhood"];
        $email = $_COOKIE['logAndReg'];

        //Get the name of the image
        $image = $_FILES['file']['name'];
        //Get the type of the image
        $imgType =  $_FILES['file']['type'];
        $types = ['image/jpg', 'image/jpeg', 'image/png', 'image/svg'];
        if (!in_array($imgType, $types)) {
            echo  "Грешен тип на снимката";
        } else {

            $dir = '../images/';
            move_uploaded_file($_FILES['file']['tmp_name'], $dir . basename($image));

            if (!empty($price) && !empty($type) && !empty($area) && !empty($image) && !empty($town) && !empty($neighborhood)) {

                $correctData = sellProp($type, $price, $area, $image, $town, $neighborhood, $email);
            } else {
                echo
                "<div class='row justify-content-center text-center m-3'>
                <div class='col-md-6'>
                    <div class='alert alert-danger text'>
                        Попълни всички полета
                    </div>
                </div>
            </div>";
            }

            //And finally if all the data is correct, this message shows up to the user
            if ($correctData === TRUE) {
                echo
                "<div class='row justify-content-center text-center m-3'>
                <div class='col-md-6'>
                    <div class='alert alert-success text'>
                    Успешно публикувахте имот!
                    </div>
                </div>
            </div>";
            } else {
                echo
                "<div class='row justify-content-center text-center m-3'>
                <div class='col-md-6'>
                    <div class='alert alert-danger text'>
                    $correctData
                    </div>
                </div>
            </div>";
            }
        }
    }
    ?>
    <form method="post" action="#" enctype="multipart/form-data">

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label for="price" class="col-sm-2 col-form-label">Цена</label>
                <input type="text" required class="form-control" name="price">
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label for="type" class="col-sm-2 col-form-label">Тип</label>
                <select class="form-select" required aria-label="Default select example" name="type">
                    <option selected>Избери тип</option>
                    <?php

                    //Get all Types from the database
                    $types = getTypes();

                    //Print them
                    foreach ($types as $type => $value) {
                        echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label for="area" class="col-sm-2 col-form-label">Площ</label>
                <input type="text" required class="form-control" name="area">
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label for="area" class="col-sm-2 col-form-label">Град</label>
                <select class="form-select" id="town" required aria-label="Default select example" name="town">
                    <option selected>Избери Град</option>
                    <?php

                    //Get all towns from the database
                    $towns = getTowns();

                    //Print them
                    foreach ($towns as $town => $value) {
                        echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label for="area" class="col-sm-2 col-form-label">Квартал</label>
                <select class="form-select" id="neigh" required aria-label="Default select example" name="neighborhood">
                    <option selected>Избери Квартал</option>
                    <script>
                        // Script for making the appear of neighborhoods dynamic
                        // ex. If we choose Sofia as Town, only neighborhoods that are
                        // in Sofia will appear

                        $('#town').change(function() {
                            let string = $('#town').val();
                            if (string === "town") {
                                $("#neigh").empty().append("<option>Select Neghborhood</option>");
                                return;
                            }
                            $.get('../functions/search.php', {
                                input: string
                            }, function(data) {
                                $("#neigh").empty().append(data);
                            });
                        });
                    </script>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-sm-10">
                <label class="col-sm-2 col-form-label">Снимка</label>
                <input type="file" class="form-control" required name="file">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary" name="submit">Публикувай имота си!</button>
            </div>
        </div>

    </form>


</div>