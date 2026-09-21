<!DOCTYPE html>
<html>
<head>
    <title>File Operations</title>
</head>
<body>
    <h2>File Handling Operations</h2>
    <form method="post">
        Filename: <input type="text" name="filename" value="example.txt" required><br><br>
        Operation:
        <select name="op" required>
            <option value="check">Check File</option>
            <option value="write">Open & Write File</option>
            <option value="read">Open, Read & Close File</option>
            <option value="rename">Rename File</option>
            <option value="checkperm">Check Permissions</option>
            <option value="changeperm">Change Permissions</option>
        </select><br><br>
        Content (for write):<br>
        <textarea name="content" rows="4" cols="40">Lab 2 File handling task completed by Nishant Dahal.</textarea><br><br>
        New Filename (for rename): <input type="text" name="newname"><br><br>
        <input type="submit" value="Perform Operation">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $file = trim($_POST["filename"]);
        $op = $_POST["op"];

        echo "<h3>Result</h3>";
        if ($op == "check") {
            echo file_exists($file) ? "File '$file' exists." : "File '$file' does not exist.";
        } elseif ($op == "write") {
            $f = fopen($file, "w");
            if ($f) {
                fwrite($f, $_POST["content"]);
                fclose($f);
                echo "File opened, written, and closed successfully.";
            } else {
                echo "Unable to open file for writing.";
            }
        } elseif ($op == "read") {
            if (file_exists($file)) {
                $f = fopen($file, "r");
                $content = filesize($file) > 0 ? fread($f, filesize($file)) : "(empty)";
                fclose($f);
                echo "<strong>Content:</strong><br><pre>" . htmlspecialchars($content) . "</pre>";
            } else {
                echo "File does not exist.";
            }
        } elseif ($op == "rename") {
            $new = trim($_POST["newname"]);
            if (!empty($new) && file_exists($file)) {
                rename($file, $new);
                echo "File renamed from '$file' to '$new'.";
            } else {
                echo "Invalid filename or original file missing.";
            }
        } elseif ($op == "checkperm") {
            if (file_exists($file)) {
                echo "Permissions: " . substr(sprintf('%o', fileperms($file)), -4);
            } else {
                echo "File does not exist.";
            }
        } elseif ($op == "changeperm") {
            if (file_exists($file)) {
                chmod($file, 0755);
                echo "Updated Permissions: " . substr(sprintf('%o', fileperms($file)), -4);
            } else {
                echo "File does not exist.";
            }
        }
    }
    ?>
</body>
</html>