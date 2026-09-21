<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]);

    if ($username === "nishant" && $password === "password123") {
        $_SESSION["user"] = $username;

        if ($remember) {
            setcookie("saved_user", $username, time() + (86400 * 7), "/");
        } else {
            setcookie("saved_user", "", time() - 3600, "/");
        }
        $msg = "Logged in successfully. Session and cookie set.";
    } else {
        $msg = "Invalid username or password.";
    }
}

$remembered_user = $_COOKIE["saved_user"] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session and Cookie Login</title>
</head>
<body>
<h2>Login (Session & Cookie)</h2>

<?php if (isset($_SESSION["user"])): ?>
    <p>Welcome back, <strong><?= htmlspecialchars($_SESSION["user"]) ?></strong>!</p>
    <p><a href="?logout=1">Logout</a></p>
    <?php
    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: question26.php");
        exit;
    }
    ?>
<?php else: ?>
    <?php if (isset($msg)) echo "<p><strong>$msg</strong></p>"; ?>
    <form method="post">
        Username: <input type="text" name="username" value="<?= htmlspecialchars($remembered_user) ?>" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="checkbox" name="remember" id="remember" <?= $remembered_user ? "checked" : "" ?>>
        <label for="remember">Remember me on this computer</label><br><br>
        <input type="submit" value="Login">
    </form>
<?php endif; ?>
</body>
</html>