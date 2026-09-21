<!DOCTYPE html>
<html>
<head>
    <title>Nepal Income Tax Calculator FY 2083/84</title>
</head>
<body>
    <h2>Nepal Income Tax Calculator (FY 2083/84)</h2>
    <form method="post">
        Annual Taxable Income: <input type="number" step="any" name="income" min="0" required><br><br>
        Gender:
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>
        <input type="submit" value="Calculate Tax">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $income = (float)$_POST["income"];
        $gender = $_POST["gender"];

        $rem = $income;
        $s1 = min($rem, 1000000); $t1 = $s1 * 0.01; $rem -= $s1;
        $s2 = min($rem, 500000);  $t2 = $s2 * 0.10; $rem -= $s2;
        $s3 = min($rem, 1000000); $t3 = $s3 * 0.20; $rem -= $s3;
        $s4 = min($rem, 1500000); $t4 = $s4 * 0.27; $rem -= $s4;
        $s5 = max($rem, 0);       $t5 = $s5 * 0.29;

        $gross = $t1 + $t2 + $t3 + $t4 + $t5;
        $discount = ($gender == "Female") ? ($gross * 0.10) : 0;
        $total = $gross - $discount;
        $net = $income - $total;

        echo "<h3>Tax Breakdown</h3>";
        echo "Taxpayer: Nishant Dahal ($gender)<br>";
        echo "1. Annual Taxable Income: NPR " . number_format($income, 2) . "<br><br>";

        echo "<table border='1' cellpadding='6'>
            <tr><th>Slab</th><th>Amount</th><th>Rate</th><th>Tax</th></tr>
            <tr><td>Up to 1,000,000</td><td>" . number_format($s1, 2) . "</td><td>1%</td><td>" . number_format($t1, 2) . "</td></tr>
            <tr><td>Next 500,000</td><td>" . number_format($s2, 2) . "</td><td>10%</td><td>" . number_format($t2, 2) . "</td></tr>
            <tr><td>Next 1,000,000</td><td>" . number_format($s3, 2) . "</td><td>20%</td><td>" . number_format($t3, 2) . "</td></tr>
            <tr><td>Next 1,500,000</td><td>" . number_format($s4, 2) . "</td><td>27%</td><td>" . number_format($t4, 2) . "</td></tr>
            <tr><td>Above 4,000,000</td><td>" . number_format($s5, 2) . "</td><td>29%</td><td>" . number_format($t5, 2) . "</td></tr>
        </table><br>";

        echo "2. Gross Tax: NPR " . number_format($gross, 2) . "<br>";
        if ($gender == "Female") {
            echo "Female Concession (10%): NPR " . number_format($discount, 2) . "<br>";
        }
        echo "3. Total Tax Payable: NPR " . number_format($total, 2) . "<br>";
        echo "4. Net Income After Tax: NPR " . number_format($net, 2);
    }
    ?>
</body>
</html>