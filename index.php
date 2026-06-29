<?php
    require_once "includes/db.php";

    $totalStudents = 0;

    $sql = "SELECT COUNT(*) AS total FROM students";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalStudents = $row['total'];
    }
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<div class="container mt-5">

    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">
                <i class="bi bi-mortarboard-fill"></i>
                Student Record Management System
            </h2>

            <p class="text-muted">
                Manage student records efficiently using PHP, MySQL and Bootstrap.
            </p>
        </div>
    </div>

    <div class="row">

        <!-- Total Students Card -->
        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="bi bi-people-fill display-3 text-primary"></i>

                    <h5 class="mt-3">Total Students</h5>

                    <h1 class="fw-bold">
                        <?php echo $totalStudents; ?>
                    </h1>

                </div>

            </div>

        </div>

        <!-- Add Student Card -->
        <div class="col-md-8 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h4 class="mb-3">
                        Quick Actions
                    </h4>

                    <a href="students/add.php"
                       class="btn btn-primary btn-lg">

                        <i class="bi bi-person-plus-fill"></i>

                        Add New Student

                    </a>

                    <a href="students/view.php"
                       class="btn btn-success btn-lg">

                        <i class="bi bi-table"></i>

                        View Students

                    </a>

                </div>

            </div>

        </div>

    </div>

        <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Recent Students
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                    <tr>

                        <th>#</th>
                        <th>Matric No</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Level</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    $sql = "SELECT * FROM students
                            ORDER BY id DESC
                            LIMIT 5";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {

                        $sn = 1;

                        while ($student = mysqli_fetch_assoc($result)) {

                    ?>

                        <tr>

                            <td><?= $sn++; ?></td>

                            <td><?= htmlspecialchars($student['matric_no']); ?></td>

                            <td>

                                <?= htmlspecialchars($student['first_name']); ?>

                                <?= htmlspecialchars($student['last_name']); ?>

                            </td>

                            <td><?= htmlspecialchars($student['department']); ?></td>

                            <td><?= htmlspecialchars($student['level']); ?></td>

                        </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="5" class="text-center text-muted">

                                No students found.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>