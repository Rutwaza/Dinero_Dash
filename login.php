<?php
// Start a session
session_start();

// Check if the user is already logged in, redirect to the dashboard if true
if (isset($_SESSION["user_id"])) {
   //header("Location: Dash.php");
    //exit();
}

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

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE Email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["PasswordHash"])) {
            // Password is correct, set session variables
            $_SESSION["user_id"] = $row["UserID"];
            $_SESSION["user_email"] = $row["Email"];

            // Redirect to the dashboard
            header("Location: Dash.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>login</title>
<style>
    /* Reset some default styles for all elements */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Styles for the main container with animated background */
.main-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url(star-bg.gif);
    height: 100vh;
    width: 100%;
    overflow: hidden;
}

/* Animated twinkling stars background */
@keyframes stars {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-100vh);
    }
}

/* Styles for the animated stars */
.stars {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 200vh;
    background: url('path-to-your-star-image.png');
    animation: stars 10s linear infinite;
}

/* Styles for the outer container */
.main-wrap .outer-wrap {
    width: 400px; /* Adjusted width */
    height: 460px;
    background: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
    border-radius: 20px;
    box-shadow:
        0 0 10px rgba(255, 255, 255, 0.1),
        0 0 20px rgba(255, 255, 255, 0.1);
    text-align: center;
    padding: 50px 40px;
    position: relative; /* Needed for the absolute positioning of stars */
}

/* Styles for the heading */
h1 {
    font-size: 36px;
    color: #fff;
    text-shadow:
    0 0 10px #fff,
    0 0 42px #0fa;
}

/* Styles for the horizontal rule */
hr {
    width: 40px;
    background-color: #4cff00;
    margin: auto;
    margin-top: 8px;
    height: 4px;
}

/* Styles for the social login section */
.social-login {
    margin-top: 20px;
}

/* Styles for social login icons */
.social-login a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #4cff00;
    margin: 10px;
    text-decoration: none;
    padding: 8px;
    display: inline-block;
}

.social-login a img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

/* Styles for the paragraph */
p {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #4cff00;
}

/* Styles for the form section */
.form {
    text-align: left;
}

/* Styles for form labels */
.form label {
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    text-shadow:
    0 0 10px #fff,
    0 0 42px #0fa;
}

/* Styles for form inputs */
.form input {
    width: 100%;
    height: 40px;
    border: 2px solid #4cff00;
    border-radius: 8px;
    padding: 10px;
    margin: 10px 0;
    background: #1a1a1a;
    color: #fff;
}

.form input:focus {
    border: 2px solid #4cff00;
    outline: none;
}

.form input::placeholder {
    color: #8c8c8c;
}

/* Styles for the checkbox */
.form input[type="checkbox"] {
    height: 18px;
    width: 18px;
    background-color: #1a1a1a;
}

/* Styles for the "Remember Me" text */
.rm-me {
    font-size: 14px;
    font-weight: 600;
    margin-left: 8px;
    color: #fff;
}

/* Styles for the "Forgot Password?" link */
.fg-pa {
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    color: #4cff00;
    margin-left: 20px;
}

.p{
    margin-top: 10px;
}

.fg-pa:hover {
    border-bottom: 2px solid #4cff00;
}

/* Styles for the login button */
.btn{
    height: 44px;
    width: 50%;
    margin-left: 23%;
    border-radius: 22px;
    background: linear-gradient(to right, #4cff00, #00a1ff);
    border: none;
    color: #fff;
    cursor: pointer;
    margin-top: 5px;
    font-size: 18px;
    font-weight: 700;
    
}
.btn:hover{
    background: linear-gradient(to top, blue, red, orange);
    text-shadow: 0 0 10px #fff, 0 0 20px #ff0, 0 0 30px #ff0;
    border: 2px solid #ffa;
    border: 2px dashed red;
}


.reg{
    font-weight: bold;
    margin-left: 20%;
}
/* ... */


</style>
</head>

<body>
    <div class="main-wrap">
        <div class="outer-wrap">
            <h1>Log in</h1>
            
            <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="email">Email</label>
                <br>
                <input type="email" name="email" id="email" placeholder="Email">
                <br>
                <label for="password">Password</label>
                <br>
                <input type="password" name="password" id="password" placeholder="Password">
                <br>
                <input type="checkbox" name="check" id="check">
                <span class="rm-me">Remember Me</span>
                <a href="#" class="fg-pa">Forgot Password?</a>
                <p class="p">Do not have an account? <a class='reg' href="signup.php">register</a> <br> <br>---------------- Back to <a class="hom" href="home.php">Home</a>--------------</p>
                <br>
                <button type="submit" class="btn">Log in</button>
            </form>
        </div>
    </div>
</body>
</html>