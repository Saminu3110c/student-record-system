<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../includes/db.php";

    $message = "";
    $messageType = "";

    // Save student
    if (isset($_POST['save_student'])) {

        $matric_no  = trim($_POST['matric_no']);
        $first_name = trim($_POST['first_name']);
        $last_name  = trim($_POST['last_name']);
        $gender     = trim($_POST['gender']);
        $department = trim($_POST['department']);
        $level      = trim($_POST['level']);
        $email      = trim($_POST['email']);
        $phone      = trim($_POST['phone']);

        // Validation
        if (
            empty($matric_no) ||
            empty($first_name) ||
            empty($last_name) ||
            empty($gender) ||
            empty($department) ||
            empty($level)
        ) {

            $message = "Please fill in all required fields.";
            $messageType = "danger";

        } else {

            // Check if matric number already exists
            $check = mysqli_query(
                $conn,
                "SELECT id FROM students WHERE matric_no='$matric_no'"
            );

            if (mysqli_num_rows($check) > 0) {

                $message = "Matric number already exists.";
                $messageType = "warning";

            } else {

                $sql = "INSERT INTO students
                (
                    matric_no,
                    first_name,
                    last_name,
                    gender,
                    department,
                    level,
                    email,
                    phone
                )
                VALUES
                (
                    '$matric_no',
                    '$first_name',
                    '$last_name',
                    '$gender',
                    '$department',
                    '$level',
                    '$email',
                    '$phone'
                )";

                if (mysqli_query($conn, $sql)) {

                    $_SESSION['success'] = "Student added successfully.";
                    header("Location: view.php");
                    exit;

                } else {

                    $message = "Error: " . mysqli_error($conn);
                    $messageType = "danger";

                }

            }

        }

    }
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4>

<i class="bi bi-person-plus-fill"></i>

Add New Student

</h4>

</div>

<div class="card-body">

<?php if(!empty($message)) { ?>

<div class="alert alert-<?php echo $messageType; ?>">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Matric Number

</label>

<input
type="text"
name="matric_no"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

First Name

</label>

<input
type="text"
name="first_name"
class="form-control"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Last Name

</label>

<input
type="text"
name="last_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Gender

</label>

<select
name="gender"
class="form-select"
required>

<option value="">Select Gender</option>

<option>Male</option>

<option>Female</option>

</select>

</div>

</div>

<div class="mb-3">

<label class="form-label">

Department

</label>

<input
type="text"
name="department"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Level

</label>

<select
name="level"
class="form-select"
required>

<option value="">Select Level</option>

<option>100</option>

<option>200</option>

<option>300</option>

<option>400</option>

<option>500</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control">

</div>

</div>

<div class="mb-3">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="d-grid gap-2 d-md-flex">

<button
type="submit"
name="save_student"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Student

</button>

<button
type="reset"
class="btn btn-secondary">

Reset

</button>

<a
href="view.php"
class="btn btn-success">

View Students

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>