<?php
require_once "../includes/db.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit;
}

$id = (int) $_GET['id'];

// Fetch existing student
$sql = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: view.php");
    exit;
}

$student = mysqli_fetch_assoc($result);

// Update logic
if (isset($_POST['update_student'])) {

    $matric_no  = mysqli_real_escape_string($conn, $_POST['matric_no']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $level      = mysqli_real_escape_string($conn, $_POST['level']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);

    if (
        empty($matric_no) ||
        empty($first_name) ||
        empty($last_name) ||
        empty($gender) ||
        empty($department) ||
        empty($level)
    ) {
        $_SESSION['error'] = "Please fill all required fields.";
    } else {

        $update = "UPDATE students SET
            matric_no='$matric_no',
            first_name='$first_name',
            last_name='$last_name',
            gender='$gender',
            department='$department',
            level='$level',
            email='$email',
            phone='$phone'
            WHERE id=$id";

        if (mysqli_query($conn, $update)) {

            $_SESSION['success'] = "Student updated successfully.";
            header("Location: view.php");
            exit;

        } else {
            $_SESSION['error'] = "Update failed: " . mysqli_error($conn);
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

                <div class="card-header bg-warning">

                    <h4 class="text-white">

                        <i class="bi bi-pencil-square"></i>

                        Edit Student

                    </h4>

                </div>

                <div class="card-body">

                    <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php
    echo $_SESSION['error'];
    unset($_SESSION['error']);
    ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Matric Number</label>

                                <input type="text" name="matric_no" class="form-control"
                                    value="<?php echo $student['matric_no']; ?>">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>First Name</label>

                                <input type="text" name="first_name" class="form-control"
                                    value="<?php echo $student['first_name']; ?>">

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Last Name</label>

                                <input type="text" name="last_name" class="form-control"
                                    value="<?php echo $student['last_name']; ?>">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Gender</label>

                                <select name="gender" class="form-select">

                                    <option <?php if($student['gender']=="Male") echo "selected"; ?>>Male</option>

                                    <option <?php if($student['gender']=="Female") echo "selected"; ?>>Female</option>

                                </select>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label>Department</label>

                            <input type="text" name="department" class="form-control"
                                value="<?php echo $student['department']; ?>">

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Level</label>

                                <select name="level" class="form-select">

                                    <?php
$levels = ["100","200","300","400","500"];
foreach($levels as $lvl){
?>
                                    <option value="<?php echo $lvl; ?>"
                                        <?php if($student['level']==$lvl) echo "selected"; ?>>
                                        <?php echo $lvl; ?>
                                    </option>
                                    <?php } ?>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Email</label>

                                <input type="email" name="email" class="form-control"
                                    value="<?php echo $student['email']; ?>">

                            </div>

                        </div>

                        <div class="mb-3">

                            <label>Phone</label>

                            <input type="text" name="phone" class="form-control"
                                value="<?php echo $student['phone']; ?>">

                        </div>

                        <div class="d-flex gap-2">

                            <button type="submit" name="update_student" class="btn btn-warning text-white">

                                <i class="bi bi-save"></i>

                                Update Student

                            </button>

                            <a href="view.php" class="btn btn-secondary">

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>