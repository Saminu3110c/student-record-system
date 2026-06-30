<?php
require_once "../includes/db.php";

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
}

?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            <i class="bi bi-people-fill"></i>

            Students Records

        </h2>

        <a href="add.php" class="btn btn-primary">

            <i class="bi bi-person-plus-fill"></i>

            Add Student

        </a>

    </div>

    <?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>

    <div class="card shadow border-0 mb-4">


        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-10">

                        <input type="text" name="search" class="form-control"
                            placeholder="Search by Matric Number, First Name, Last Name or Department"
                            value="<?php echo htmlspecialchars($search); ?>">

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-success">

                            <i class="bi bi-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                Students List

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Matric No</th>

                            <th>Name</th>

                            <th>Gender</th>

                            <th>Department</th>

                            <th>Level</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>
                        <?php

if ($search != "") {

$sql = "SELECT *
        FROM students
        WHERE matric_no LIKE '%$search%'
        OR first_name LIKE '%$search%'
        OR last_name LIKE '%$search%'
        OR department LIKE '%$search%'
        ORDER BY id DESC";

} else {

$sql = "SELECT *
        FROM students
        ORDER BY id DESC";

}

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

$sn = 1;

while($student = mysqli_fetch_assoc($result)){

?>
                        <tr>

                            <td><?php echo $sn++; ?></td>

                            <td><?php echo htmlspecialchars($student['matric_no']); ?></td>

                            <td>

                                <?php

echo htmlspecialchars($student['first_name'])
." ".
htmlspecialchars($student['last_name']);

?>

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    <?php echo htmlspecialchars($student['gender']); ?>

                                </span>

                            </td>

                            <td><?php echo htmlspecialchars($student['department']); ?></td>

                            <td><?php echo htmlspecialchars($student['level']); ?></td>

                            <td><?php echo htmlspecialchars($student['email']); ?></td>

                            <td><?php echo htmlspecialchars($student['phone']); ?></td>

                            <td>

                                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                    Edit

                                </a>

                                <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </a>

                            </td>

                        </tr>
                        <?php

}

}else{

?>

                        <tr>

                            <td colspan="9" class="text-center">

                                No student records found.

                            </td>

                        </tr>

                        <?php

}

?>
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>