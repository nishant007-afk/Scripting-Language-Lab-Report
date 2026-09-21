<!DOCTYPE html>
<html>
<head>
    <title>Simple Interest Calculator</title>
</head>
<body>
    <h2>Calculate Simple Interest</h2>
    <form method="post">
        Principal: <input type="number" step="any" name="p" min="0" required><br><br>
        Time (Years): <input type="number" step="any" name="t" min="0" required><br><br>
        Rate (%): <input type="number" step="any" name="r" min="0" required><br><br>
        <input type="submit" value="Calculate">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $p = $_POST["p"];
        $t = $_POST["t"];
        $r = $_POST["r"];

        if ($p >= 0 && $t >= 0 && $r >= 0) {
            $si = ($p * $t * $r) / 100;
            $total = $p + $si;

            echo "<h3>Result</h3>";
            echo "Principal: " . $p . "<br>";
            echo "Time: " . $t . " years<br>";
            echo "Rate: " . $r . "%<br>";
            echo "Simple Interest: " . $si . "<br>";
            echo "Total Amount: " . $total;
        } else {
            echo "Values cannot be negative.";
        }
    }
    ?>
</body>
</html>