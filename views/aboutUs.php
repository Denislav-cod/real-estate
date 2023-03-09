<!-- Header -->
<?php include "header.php" ?>
<!-- Navigtion -->
<?php include "navigation.php" ?>

<?php
if(!isset($_COOKIE['logAndReg'])){
    header('Location: http://localhost/php/Php-project/Project/view/login.php');
} 
?>

<div class="container  mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 mt-3 p-4 me-3">
            <h3>Кои сме ние</h3>
            <p>Намираме се във Варна, България</p>
        </div>
        <div class="col-lg-4  mt-3 p-4 me-3 ">
            <h3>Инструменти, които сме използвали</h3>
            <p><code style="font-size: 18px;">PHP, MYSQL, HTML, BOOTSTRAP, CSS</code></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-2 mt-3 p-4 me-3">
            <h3>Контакти</h3>
            <br>
            <p>Телефон: 089089089</p>
            <p>Имейл: test.gmail.com</p>
        </div>
    </div>
</div>
</div>

<!-- Footer -->
<?php include "./footer.php" ?>