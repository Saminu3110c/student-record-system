<?php
require_once "../includes/db.php";
session_start();

// Check if ID exists
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit;
}

$id = (int) $_GET['id'];

// Check if student exists
$check = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");

if (mysqli_num_rows($check) == 0) {
    $_SESSION['error'] = "Student not found.";
    header("Location: view.php");
    exit;
}

// Delete query
$sql = "DELETE FROM students WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    $_SESSION['success'] = "Student deleted successfully.";

} else {

    $_SESSION['error'] = "Delete failed: " . mysqli_error($conn);

}

// Redirect back to view page
header("Location: view.php");
exit;
?>