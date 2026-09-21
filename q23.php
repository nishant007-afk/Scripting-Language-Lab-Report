<!DOCTYPE html>
<html>
<head>
 <title>Array to HTML Table</title>
</head>
<body>
<h2>Info Table</h2>
<?php
$info = [
 'name' => 'Nishant Dahal',
 'address' => 'Kathmandu',
 'email' => 'nishantdahal0007@gmail.com',
 'phone' => 98454545,
 'website' => 'www.nishantdahal.com.np'
];
echo "<table border='1' cellpadding='8'>";
foreach ($info as $key => $value) {
 echo "<tr><th>" . ucfirst($key) . "</th><td>$value</td></tr>";
}
echo "</table>";
?>
</body>
</html>