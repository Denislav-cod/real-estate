<!-- Header -->
<?php include_once("header.php") ?>
<!-- Navigtion -->
<?php include_once("navigation.php") ?>
<!-- Logic -->
<?php include_once("../functions/functions.php") ?>

<?php
if (!isset($_COOKIE['logAndReg'])) {
  header('Location: http://localhost/php/Php-project/Project/view/login.php');
}
?>

<div class="container">
  <form method="post">
    <div class="row m-5 p-5 gap-4 border">
      <div class="col-lg">
        Тип
        <select class="form-select" aria-label="Default select example" name="type">
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
      <div class="col-lg">
        Площ
        <select class="form-select" aria-label="Default select example" name="area">
          <option value="0-50">0-50</option>
          <option value="50-100">50-100</option>
          <option value="100-150">100-150</option>
          <option value="150-1000">150-1000</option>
        </select>
      </div>
      <div class="col-lg">
        Град
        <select class="form-select" id="town" aria-label="Default select example" name="town">
          <option value="" selected>Град</option>
          <?php
          //Get all towns from the database
          $towns = getTowns();

          //Echo them
          foreach ($towns as $town => $value) {
            echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
          }
          ?>
        </select>
      </div>
  </form>
  <div class="col-lg">
    Квартали
    <select class="form-select" id="neigh" aria-label="Default select example" name="neighborhood">
      <option selected>Квартали</option>
      <script>
        // Script for making the appear of neighborhoods dynamic
        // ex. If we choose Sofia as Town, only neighborhoods that are
        // in Sofia will appear - Mladost, Boyana

        $('#town').change(function() {
          let string = $('#town').val();
          if (string === "town") {
            $("#neigh").empty().append("<option>Квартали</option>");
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
  <div class="row">
    <div class="d-flex justify-content-center">
      <button class="btn btn-primary" name="search" type="submit">Търсене</button>
    </div>
  </div>
</div>

<?php

if (isset($_POST["search"])) {
  $prop = [];

  $type = $_POST["type"];
  $area = $_POST["area"];
  $town = $_POST["town"];
  $neighborhood = $_POST["neighborhood"];

  if (!empty($type) && !empty($area) && !empty($town) && !empty($neighborhood)) {
    //Get all properties by the given criteria and print them
    $sortedProps = sortProps($type, $area, $town, $neighborhood);
    echo "<div class='row justify-content-center m-4 p-4 gap-4'>";
    foreach ($sortedProps as $p => $value) {
      echo "<div class='card' style='width:18rem;'>";
      echo "<img src='../images/" . $value['img'] . "' class='card-img-top' alt='Снимка'>";
      echo "<div class='card-body'>";
      echo "<h5 class='card-title'> Тип: " . $value['type'] . "</h5>";
      echo "<p class='card-text'> Площ: " . $value['area'] . " m<sup>2</sup></p>";
      echo "<p class='card-text'> Цена: $" . $value['price'] . "</p>";
      echo "<p class='card-text'> Град: " . $value['town'] . "</p>";
      echo "<p class='card-text'> Квартал: " . $value['neighborhood'] . "</p>";
      echo "<p class='card-text'> Публикувано от: " . $value['name'] . "</p>";
      echo "<p class='card-text'> Контакт: " . $value['email'] . "</p>";
      echo "</div>";
      echo "</div>";
    }

    echo "</div>";
  }
} else {
  //Get all properties and print them
  $allProps = allProps();
  echo "<div class='row justify-content-center m-4 p-4 gap-4'>";
  foreach ($allProps as $p => $value) {
    echo "<div class='card' style='width:18rem;'>";
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
    echo "</div>";
  }
  echo "</div>";
}

?>


<?php include_once("./footer.php") ?>