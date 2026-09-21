<!DOCTYPE html>
<html>
<head>
    <title>Registration Form Validation</title>
</head>
<body>
    <h2>User Registration & Validation Form</h2>
    <form method="post">
        Name: <input type="text" name="name" value="Nishant Dahal"><br><br>
        Address: <input type="text" name="address" value="Kathmandu"><br><br>
        Username: <input type="text" name="username" value="nishant_dahal"><br><br>
        Email: <input type="text" name="email" value="nishantdahal0007@gmail.com"><br><br>
        Password: <input type="password" name="password" value="Pass@1234"><br><br>
        Website: <input type="text" name="website" value="https://nishantdahal.com.np"><br><br>
        Phone: <input type="text" name="phone" value="9845454500"><br><br>
        Gender: 
        <input type="radio" name="gender" value="Male" checked> Male
        <input type="radio" name="gender" value="Female"> Female
        <input type="radio" name="gender" value="Other"> Other<br><br>
        Course:
        <select name="course">
            <option value="">-- Select Course --</option>
            <option value="BCA" selected>BCA</option>
            <option value="CSIT">CSIT</option>
            <option value="BBM">BBM</option>
        </select><br><br>
        <input type="submit" value="Register">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"] ?? "");
        $address = trim($_POST["address"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";
        $website = trim($_POST["website"] ?? "");
        $phone = trim($_POST["phone"] ?? "");
        $gender = $_POST["gender"] ?? "";
        $course = $_POST["course"] ?? "";
        $errors = [];

        if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors[] = "Name must contain only alphabetic characters and spaces.";
        }
        if (empty($address)) {
            $errors[] = "Address must not be empty.";
        }
        if (empty($username) || !preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $errors[] = "Username must contain only letters, numbers, and underscores.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
            $errors[] = "Password must be at least 8 characters long and include uppercase, lowercase, digit, and special character.";
        }
        if (empty($website) || !filter_var($website, FILTER_VALIDATE_URL)) {
            $errors[] = "Website must be a valid URL.";
        }
        if (!preg_match("/^(96|97|98)\d{8}$/", $phone)) {
            $errors[] = "Phone must be 10 digits and start with 96, 97, or 98.";
        }
        if (empty($gender)) {
            $errors[] = "Gender is required.";
        }
        if (empty($course)) {
            $errors[] = "Course selection is required.";
        }

        if (empty($errors)) {
            echo "<h3 style='color:green;'>Validation Passed!</h3>";
            echo "Name: $name<br>";
            echo "Address: $address<br>";
            echo "Username: $username<br>";
            echo "Email: $email<br>";
            echo "Website: $website<br>";
            echo "Phone: $phone<br>";
            echo "Gender: $gender<br>";
            echo "Course: $course";
        } else {
            echo "<h3 style='color:red;'>Validation Errors:</h3><ul>";
            foreach ($errors as $e) {
                echo "<li>$e</li>";
            }
            echo "</ul>";
        }
    }
    ?>
</body>
</html>