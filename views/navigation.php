<?php
include_once('../functions/functions.php');
?>
<nav class="navbar navbar-dark navbar-expand-lg" style="background-color:#3952ad; font-size: 1.5rem;">
  <div class="container-fluid">
    <a class="navbar-brand mr-auto" href="home.php">Имоти</a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
      <div class="d-flex justify-content-center">
        <ul class="navbar-nav  ">
          <?php
          if (!isset($_COOKIE['logAndReg'])) {
            echo ' <li class="nav-item">
            <a class="nav-link" href="login.php">Влизане</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="registration.php">Регистрация</a>
          </li>';
          } else {
            if (isset($_COOKIE['admin'])) {
              echo '<li class="nav-item">
            <a class="nav-link" href="admin.php">Админ панел</a>
          </li>';
            }
            echo '<li class="nav-item">
            <a class="nav-link" href="home.php">Публикувай имот</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="searchProp.php">Търсене</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aboutUs.php">За нас</a>
          </li>
          <form method="POST">
            <button class="btn nav-link" type="submit" name="logout" >Излизане</button>
          </form>';
          }
          if (isset($_POST['logout'])) {
            logOut();
            echo "<meta http-equiv='refresh' content='0'>";
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</nav>