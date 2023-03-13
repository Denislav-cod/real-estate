<?php
include_once("connectToDatabase.php");

function getTowns()
{
    $conn = connect();
    $array = [];
    $sql = "SELECT name FROM towns";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
    }
    return $array;
    $conn->close();
}

function getTypes()
{
    $conn = connect();
    $array = [];
    $sql = "SELECT name FROM types";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
    }
    return $array;
    $conn->close();
}

function sellProp($type, $price, $area, $image, $town, $neighborhood, $email)
{
    $conn = connect();
    try {
        numValidation($price);
        numValidation($area);
    } catch (Exception $e) {
        return $e->getMessage();
    }

    // Get the neighborhood_id
    $sqlNeighborhoodId = "SELECT `id` FROM `neighborhoods` WHERE `name` LIKE '$neighborhood'";
    $result = $conn->query($sqlNeighborhoodId);
    $row = $result->fetch_assoc();
    $neighborhoodId = $row["id"];

    //Get the town_id
    $sqlTownId = "SELECT `id` FROM `towns` WHERE `name` LIKE '$town'";
    $resultTownId = $conn->query($sqlTownId);
    $row2 = $resultTownId->fetch_assoc();
    $townId = $row2["id"];

    //Get the user_id
    $sqlUserId = "SELECT `id` FROM `users` WHERE `email` LIKE '$email'";
    $resultUserId = $conn->query($sqlUserId);
    $row3 = $resultUserId->fetch_assoc();
    $userId = $row3["id"];

    //Get the type_id
    $sqlTypeId = "SELECT `id` FROM `types` WHERE `name` LIKE '$type'";
    $resultTypeId = $conn->query($sqlTypeId);
    $row4 = $resultTypeId->fetch_assoc();
    $typeId = $row4["id"];


    $sql = "INSERT INTO properties ( `price`, `area`, `img` , `user_id`, `town_id`, `neighborhood_id`, `type_id`) VALUES ( '$price', '$area', '$image' ,'$userId', '$townId', '$neighborhoodId', '$typeId')";

    if ($conn->query($sql)) {
        $property_id = mysqli_insert_id($conn);
        return TRUE;
    } else {
        echo " Грешка : " . $conn->error;
    }
    $conn->close();
}

function sortProps($type, $area, $town, $neighborhood)
{
    $conn = connect();
    $array = [];
    $trim = str_replace("-", " ", $area);

    $areaValues = explode(" ", $trim);

    $areaMin = $areaValues[0];
    $areaMax = $areaValues[1];

    $sql2 = "SELECT p.price, p.area, p.img, p.status, t.name as town, n.name as neighborhood, u.email as email, u.name as name, ty.name as type 
        FROM properties p
        JOIN neighborhoods n ON p.neighborhood_id = n.id
        JOIN users u ON p.user_id = u.id
        JOIN towns t ON p.town_id = t.id
        JOIN types ty ON p.type_id = ty.id
        WHERE ty.name LIKE '$type'
                AND
              p.area BETWEEN $areaMin AND $areaMax
                AND
              t.name LIKE '$town'
                AND
              n.name LIKE '$neighborhood'
                AND
              p.status = 'accept'";

    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
    }
    return $array;
    $conn->close();
}

function allProps()
{
    $conn = connect();
    $array = [];
    $sql = "SELECT p.status, p.price, p.area, p.img, t.name as town, n.name as neighborhood, u.email as email, u.name as name, ty.name as type
      FROM properties p
      JOIN neighborhoods n ON p.neighborhood_id = n.id
      JOIN users u ON p.user_id = u.id
      JOIN types ty ON p.type_id = ty.id
      JOIN towns t ON p.town_id = t.id WHERE p.status = 'accept'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='row justify-content-center m-4 p-4 gap-4'>";
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
    }
    return $array;
    $conn->close();
}

function login($email, $password)
{
    $conn = connect();
    try {
        $cookieName = "logAndReg";
        loginValidation($email, $password);
        $sql = "SELECT * from users WHERE email = '$email'";
        $user = $conn->query($sql);
        if ($user->num_rows > 0) {
            $userInfo = $user->fetch_assoc();
            $roleId = $userInfo['role_id'];
            $sql = "SELECT * from roles WHERE id = '$roleId'";
            $role = $conn->query($sql);
            $roleInfo =  $role->fetch_assoc();
            setcookie($cookieName, $userInfo['email'], time() + 3600, "/");
            if ($roleInfo['name'] === "admin") {
                setcookie('admin', $roleInfo['name'], time() + 3600, "/");
            }
            header('Location: http://localhost/php/Php-project/Project/view/searchProp.php');
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
    $conn->close();
}

function registration($name, $email, $password)
{
    $conn = connect();
    try {
        $cookieName = "logAndReg";
        regValidation($email);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users ( `name`, `email`, `password`) VALUES ('$name', '$email', '$hash')";
        $conn->query($sql);
        setcookie($cookieName, $email, time() + 3600, "/");
        header("Location: http://localhost/php/Php-project/Project/view/searchProp.php");
    } catch (Exception $e) {
        return $e->getMessage();
    }

    $conn->close();
}

function loginValidation($email, $password)
{
    $conn = connect();
    $sql = "SELECT email, password from users WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row === null) {
        throw new Exception("Несъществуващ акаунт");
    }
    if (!password_verify($password, $row['password'])) {
        throw new Exception("Грешна парола");
    }
    $conn->close();
}

function regValidation($email)
{
    $emails = [];
    $conn = connect();
    $sql = "SELECT email from users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($emails, $row['email']);
        }
    }
    if (in_array($email, $emails)) {
        throw new Exception("Потребител с този имейл вече съществува");
    }
    $conn->close();
}

function adminProps()
{
    $conn = connect();
    $array = [];
    $sql = "SELECT p.id, p.price, p.area, p.img, p.status, t.name as town, n.name as neighborhood, u.email as email, u.name as name, ty.name as type
      FROM properties p
      JOIN neighborhoods n ON p.neighborhood_id = n.id
      JOIN users u ON p.user_id = u.id
      JOIN types ty ON p.type_id = ty.id
      JOIN towns t ON p.town_id = t.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='row justify-content-center m-4 p-4 gap-4'>";
        while ($row = $result->fetch_assoc()) {
            array_push($array, $row);
        }
    }

    return array_reverse($array);;
    $conn->close();
}

function updateStatus($id)
{
    $conn = connect();
    $sql = "UPDATE properties SET status = 'accept' WHERE id = '$id' ";
    $conn->query($sql);
    $conn->close();
}

function delete($id)
{
    $conn = connect();
    $sql = "DELETE FROM properties WHERE id = '$id' ";
    $conn->query($sql);
    $conn->close();
}

function logOut()
{
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600);
            setcookie($name, '', time() - 3600, '/');
        }
    }
}

function numValidation($num)
{
    $pattern = '/^\d+(\.\d{2})?$/';
    if (!preg_match($pattern, $num)) {
        throw new Exception("Моля въведете валиден формат на цената или площ!");
    }
}
