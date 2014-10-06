<?php

require_once("Includes/db.php");

/* * other variables */
$userNameIsUnique = true;
$emailIsValid = true;
$passwordIsValid = true;
$userIsEmpty = false;
$passwordIsEmpty = false;
$password2IsEmpty = false;
$emailIsEmpty = false;
$emailIsEmpty2 = false;

/** Check that the page was requested from itself via the POST method. */
/* if ($_SERVER['REQUEST_METHOD'] == "POST"){
  /** Check whether the user has filled in the users's username in the text field "username" */
if ($_POST['username'] == "") {
    $userIsEmpty = true;
}

/** Create database connection */
$userID = Recipe::getInstance()->get_user_id_by_name($_POST['username']);
if ($userID) {
    $userNameIsUnique = false;
}

/** Check whether a password was entered and confirmed correctly */
if ($_POST['password'] == "")
    $passwordIsEmpty = true;
if ($_POST['password2'] == "")
    $password2IsEmpty = true;
if ($_POST['password'] != $_POST['password2']) {
    $passwordIsValid = false;
}
//checks if email was entered and confirmed correctly
if ($_POST['email'] == "")
    $emailIsEmpty = true;
if ($_POST['email2'] == "")
    $emailIsEmpty2 = true;
if ($_POST['email'] != $_POST['email2']) {
    $emailIsValid = false;
}

/** Check whether the boolean values show that the input data was validated successfully.
 * If the data was validated successfully, add it as a new entry in the "wishers" database.
 * After adding the new entry, close the connection and redirect the application to editWishList.php.
 */
if (!$userIsEmpty && $userNameIsUnique && !$passwordIsEmpty && !$password2IsEmpty
        && $passwordIsValid && !$emailIsEmpty && !$emailIsEmpty2 && $emailIsValid) {
    Recipe::getInstance()->create_user($_POST['username'], $_POST['password'], $_POST['email']);
    session_start();
    $_SESSION['username'] = $_POST['username'];
    header('Location: index.php');
    exit;
    //}
}
?>