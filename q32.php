<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Mark Ledger Form</title>
</head>
<body>
    <h2>Enter Student Details and Marks</h2>
    <form method="post">
        Name: <input type="text" name="name" value="Nishant Dahal" required><br><br>
        Roll No: <input type="text" name="roll" value="25" required><br><br>
        Web Tech II: <input type="number" name="web" min="0" max="100" required><br><br>
        DBMS: <input type="number" name="dbms" min="0" max="100" required><br><br>
        Economics: <input type="number" name="eco" min="0" max="100" required><br><br>
        DSA: <input type="number" name="dsa" min="0" max="100" required><br><br>
        Account: <input type="number" name="acc" min="0" max="100" required><br><br>
        <input type="submit" value="Generate Mark Ledger">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $roll = $_POST["roll"];
        $web = (int)$_POST["web"];
        $dbms = (int)$_POST["dbms"];
        $eco = (int)$_POST["eco"];
        $dsa = (int)$_POST["dsa"];
        $acc = (int)$_POST["acc"];

        $total = $web + $dbms + $eco + $dsa + $acc;
        $pass = ($web >= 24 && $dbms >= 24 && $eco >= 24 && $dsa >= 24 && $acc >= 24);
        $result = $pass ? "Pass" : "Fail";
        $color = $pass ? "#3ddc84" : "#ff4d4d";

        echo "<h3>Mark Ledger</h3>";
        echo "<table border='1' cellpadding='8'>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Roll</th>
                <th>Web Tech II</th>
                <th>DBMS</th>
                <th>Economics</th>
                <th>DSA</th>
                <th>Account</th>
                <th>Total</th>
                <th>Result</th>
            </tr>
            <tr style='background:$color;'>
                <td>1</td>
                <td>$name</td>
                <td>$roll</td>
                <td>$web</td>
                <td>$dbms</td>
                <td>$eco</td>
                <td>$dsa</td>
                <td>$acc</td>
                <td>$total</td>
                <td>$result</td>
            </tr>
        </table>";
    }
    ?>
</body>
</html>