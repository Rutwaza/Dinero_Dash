<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DineroDash";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $firstName = $_POST["firstname"];
    $secondName = $_POST["secondname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["pass"], PASSWORD_DEFAULT); // Hash the password

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM Users WHERE Email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo "Error: Email already exists. Please choose a different email.";
    } else {
        // Email doesn't exist, proceed with registration
        $sql = "INSERT INTO Users (FirstName, SecondName, Email, Phone, PasswordHash) VALUES ('$firstName', '$secondName', '$email', '$phone', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    
    <div class="main-wrap">
        <div class="form-wrap">
            <h1 class="register">Register</h1>
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
                <input type="text" name="firstname" id="firstname" placeholder="First Name">
                <br>
                <input type="text" name="secondname" id="secondname" placeholder="Second Name">
                <br>
                <input type="email" name="email" id="email" placeholder="Email">
                <br>
                <input type="number" name="phone" id="phone" placeholder="Phone ">
                <br>
                <input type="password" name="pass" id="pass" placeholder="Password">
                <br>
                <input type="password" name="cpass" id="cpass" placeholder="Confirm Password">
                <br>
                <button type="submit" class="form-btn">register</button>
                <br>
                <p class="p" >Already have an acount? <a href="login.php" class="login-link">Login</a> <br> <br>---------------- Back to <a class="hom" href="home.php">Home</a>--------------</p>
            </form>
        </div>
    </div>
</body>
</html>
