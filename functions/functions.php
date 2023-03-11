<?php
include_once("connectToDatabase.php");

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
