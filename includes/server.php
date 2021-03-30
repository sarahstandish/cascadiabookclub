<?php 
session_start();
include 'config.php';

$FirstName = '';
$LastName = '';
$Email = '';
$UserName = '';
$errors = [];
$success = "You are now logged in.";

if (isset($_POST['RegisterUser'])) {
    
    $FirstName = mysqli_real_escape_string($db, $_POST['FirstName']);
    $LastName = mysqli_real_escape_string($db, $_POST['LastName']);
    $Email = mysqli_real_escape_string($db, $_POST['Email']);
    $UserName = mysqli_real_escape_string($db, $_POST['UserName']);
    $Password1 = mysqli_real_escape_string($db, $_POST['Password1']);
    $Password2 = mysqli_real_escape_string($db, $_POST['Password2']);

    if (empty($FirstName)) {
        array_push($errors, 'First name is required.');
    }

    if (empty($LastName)) {
        array_push($errors, 'Last name is required.');
    }

    if (empty($UserName)) {
        array_push($errors, 'Username is required.');
    }

    if (empty($Email)) {
        array_push($errors, 'Email is required.');
    }

    if (empty($Password1)) {
        array_push($errors, 'Password is required.');
    }

    if ($Password1 != $Password2) {
        array_push($errors, 'Passwords do not match.');
    }

    $user_check_query = "SELECT * FROM users WHERE UserName = '$UserName' OR Email = '$Email' LIMIT 1";

    $result = mysqli_query($db, $user_check_query) or die(myError(__FILE__, __LINE__, mysqli_error($db)));

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['UserName'] == $UserName) {
            array_push($errors, "Username already exists.");
        }
        if ($user['Email'] == $Email) {
            array_push($errors, "This email has already been registered.");
        }
    }

    if (empty($errors)) {
        $Password = md5($Password1);

        $query = "INSERT INTO users (FirstName, LastName, UserName, Email, Password) VALUE ('$FirstName', '$LastName', '$UserName', '$Email', '$Password')";

        mysqli_query($db, $query);

        $_SESSION['UserName'] = $UserName;
        $_SESSION['success'] = $success;

        header('Location:/it261/cascadiabookclub/login.php');
    }
}

if (isset($_POST['LoginUser'])) {
    
    $UserName = mysqli_real_escape_string($db, $_POST['UserName']);
    $Password = mysqli_real_escape_string($db, $_POST['Password']);

    if (empty($UserName)) {
        array_push($errors, 'Username is required.');
    }

    if (empty($Password)) {
        array_push($errors, 'Password is required.');
    }

    if (empty($errors)) {
        $Password = md5($Password);

        $query = "SELECT * FROM users WHERE UserName = '$UserName' AND Password = '$Password'";

        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {
            
            $_SESSION['UserName'] = $UserName;
            $_SESSION['success'] = $success;

            header('Location:/it261/cascadiabookclub/index.php');
        } else {
            array_push($errors, "<p class='red'>Wrong username or password.</p>");
        }
    }

}