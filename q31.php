<?php
$pdo = new PDO("mysql:host=localhost;dbname=lab2_db", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$tab = $_GET['tab'] ?? 'courses';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_course'])) {
    if ($_POST['action_course'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id=?");
        $stmt->execute([$_POST['id']]);
    } else {
        $title = trim($_POST['title']);
        $duration = trim($_POST['duration']);
        $status = $_POST['status'];

        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare("UPDATE courses SET title=?, duration=?, status=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$title, $duration, $status, $_POST['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO courses (title, duration, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$title, $duration, $status]);
        }
    }
    header("Location: question31.php?tab=courses");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_student'])) {
    if ($_POST['action_student'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
        $stmt->execute([$_POST['id']]);
    } else {
        $name = trim($_POST['name']);
        $course_id = $_POST['course_id'];
        $fee = $_POST['fee'];
        $rollno = trim($_POST['rollno']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $dob = $_POST['dob'];
        $status = $_POST['status'];

        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare("UPDATE students SET name=?, course_id=?, fee=?, rollno=?, phone=?, address=?, dob=?, status=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$name, $course_id, $fee, $rollno, $phone, $address, $dob, $status, $_POST['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO students (name, course_id, fee, rollno, phone, address, dob, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $course_id, $fee, $rollno, $phone, $address, $dob, $status]);
        }
    }
    header("Location: question31.php?tab=students");
    exit;
}

$edit_course = null;
if ($tab == 'courses' && isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_course = $stmt->fetch(PDO::FETCH_ASSOC);
}

$edit_student = null;
if ($tab == 'students' && isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_student = $stmt->fetch(PDO::FETCH_ASSOC);
}

$courses_list = $pdo->query("SELECT * FROM courses ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Courses & Students CRUD</title>
</head>
<body>
    <h2>Academic Management System</h2>
    <p>
        <a href="?tab=courses"><strong>[ Manage Courses ]</strong></a> | 
        <a href="?tab=students"><strong>[ Manage Students ]</strong></a>
    </p>
    <hr>

    <?php if ($tab == 'courses'): ?>
        <h3><?= $edit_course ? "Edit Course" : "Add Course" ?></h3>
        <form method="post">
            <input type="hidden" name="action_course" value="save">
            <input type="hidden" name="id" value="<?= $edit_course['id'] ?? '' ?>">
            Title: <input type="text" name="title" value="<?= $edit_course['title'] ?? '' ?>" required><br><br>
            Duration: <input type="text" name="duration" value="<?= $edit_course['duration'] ?? '' ?>" placeholder="e.g. 4 Years" required><br><br>
            Status: 
            <select name="status">
                <option value="Active" <?= (isset($edit_course) && $edit_course['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= (isset($edit_course) && $edit_course['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
            </select><br><br>
            <input type="submit" value="<?= $edit_course ? 'Update Course' : 'Save Course' ?>">
        </form>

        <h3>Course List</h3>
        <table border="1" cellpadding="6">
            <tr>
                <th>ID</th><th>Title</th><th>Duration</th><th>Status</th><th>Created At</th><th>Action</th>
            </tr>
            <?php foreach ($courses_list as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['title']) ?></td>
                <td><?= htmlspecialchars($c['duration']) ?></td>
                <td><?= htmlspecialchars($c['status']) ?></td>
                <td><?= $c['created_at'] ?></td>
                <td>
                    <a href="?tab=courses&edit=<?= $c['id'] ?>">Edit</a>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete course?');">
                        <input type="hidden" name="action_course" value="delete">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <h3><?= $edit_student ? "Edit Student" : "Add Student" ?></h3>
        <form method="post">
            <input type="hidden" name="action_student" value="save">
            <input type="hidden" name="id" value="<?= $edit_student['id'] ?? '' ?>">
            Name: <input type="text" name="name" value="<?= $edit_student['name'] ?? 'Nishant Dahal' ?>" required><br><br>
            Course:
            <select name="course_id" required>
                <option value="">-- Select Course --</option>
                <?php foreach ($courses_list as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= (isset($edit_student) && $edit_student['course_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
            Fee: <input type="number" step="0.01" name="fee" value="<?= $edit_student['fee'] ?? '' ?>" required><br><br>
            Roll No: <input type="text" name="rollno" value="<?= $edit_student['rollno'] ?? '25' ?>" required><br><br>
            Phone: <input type="text" name="phone" value="<?= $edit_student['phone'] ?? '9845454500' ?>" required><br><br>
            Address: <input type="text" name="address" value="<?= $edit_student['address'] ?? 'Kathmandu' ?>" required><br><br>
            Date of Birth: <input type="date" name="dob" value="<?= $edit_student['dob'] ?? '' ?>" required><br><br>
            Status:
            <select name="status">
                <option value="Active" <?= (isset($edit_student) && $edit_student['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= (isset($edit_student) && $edit_student['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
            </select><br><br>
            <input type="submit" value="<?= $edit_student ? 'Update Student' : 'Save Student' ?>">
        </form>

        <h3>Student List</h3>
        <table border="1" cellpadding="6">
            <tr>
                <th>ID</th><th>Name</th><th>Course</th><th>Roll No</th><th>Fee</th><th>Phone</th><th>DOB</th><th>Status</th><th>Action</th>
            </tr>
            <?php
            $students = $pdo->query("SELECT students.*, courses.title AS course_title FROM students LEFT JOIN courses ON students.course_id = courses.id")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($students as $s):
            ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= htmlspecialchars($s['course_title'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($s['rollno']) ?></td>
                <td><?= htmlspecialchars($s['fee']) ?></td>
                <td><?= htmlspecialchars($s['phone']) ?></td>
                <td><?= htmlspecialchars($s['dob']) ?></td>
                <td><?= htmlspecialchars($s['status']) ?></td>
                <td>
                    <a href="?tab=students&edit=<?= $s['id'] ?>">Edit</a>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Delete student?');">
                        <input type="hidden" name="action_student" value="delete">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>