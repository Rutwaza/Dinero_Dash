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

// SQL query to retrieve user data
$sql = "SELECT firstname, secondname, email, phone FROM users";

// Execute the query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Loop through each row and display the data
    while ($row = $result->fetch_assoc()) {
        $FirstName = $row["firstname"];
        $SecondName = $row["secondname"];
        $Email = $row["email"];
        $Phone = $row["phone"];
        echo "<br>";
    }
} else {
    echo "No users found.";
}

// Close the connection
$conn->close();
?>


<?php

// Start a session
session_start();

// Check if the user is logged in, redirect to login if not
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DineroDash";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the submitted form data
        $firstname = $_POST["FirstName"];
        $secondname = $_POST["SecondName"];
        $email = $_POST["Email"];
        $phone = $_POST["Phone"];
        $password = $_POST["Password"];

        // Prepare the update statement with the UserID condition
        $sql = "UPDATE users SET ";
        $updateFields = array();

        if (!empty($firstname)) {
            $updateFields[] = "FirstName = '$firstname'";
        }
        if (!empty($secondname)) {
            $updateFields[] = "SecondName = '$secondname'";
        }
        if (!empty($email)) {
            $updateFields[] = "Email = '$email'";
        }
        if (!empty($phone)) {
            $updateFields[] = "Phone = '$phone'";
        }
        if (!empty($password)) {
            $updateFields[] = "Password = '$password'";
        }

        if (!empty($updateFields)) {
            $sql .= implode(", ", $updateFields);
            $sql .= " WHERE UserID = $userID";

            // Execute the update statement
            if ($conn->query($sql) === TRUE) {
                echo "Profile updated successfully.";
                // Generate a notification
                $category = 'profile_update';
                $message = 'Your profile has been successfully updated.';
                
                // Insert the notification into the database
                $query = "INSERT INTO notifications (userID, category, message) VALUES ('$userID', '$category', '$message')";
                mysqli_query($conn, $query);
            } else {
                echo "Error updating profile: " . $conn->error;
            }
        } else {
            echo "No fields to update.";
        }
    }

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width. initial-scale=1.0">
        <title>Profile</title> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

           <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
        body{
            margin : 0;
            padding : 0;
            font-family : 'Montserrat', sans-serif;
            background-color: #ddd;
            align-items: center;
            justify-content: center;
        }
        *{
            box-sizing: border-box;
        }

        .container{
            display: flex;
            width: 100%;
            padding: 20px 20px;
            background-color: black;
        }

        .box{
            flex: 30%;
            display: table;
            align-items: center;
            text-align: center;
            font-size: 20px;
            background-color: #0d1425;
            color: #fff;
            padding: 30px 30px;
            border-radius: 20px;
        }

        .box img{
            width: 250px;
            height: 100px;
            border-radius: 50%;
           border: 2px solid #fff;
        }

        .box ul{
            margin-top: 30px;
            font-size: 30px;
            text-align: center;
        }

        .box ul li{
            list-style: none;
            margin-top: 50px;
            font-weight: 100;
        }

        .box ul li i{
            cursor: pointer;
            margin: 10px;
        }

        .box ul li i:hover{
            opacity: 0.6;
        }

        .About{
            margin-left: 20px;
            flex: 50%;
            display: table;
            padding: 30px 30px;
            font-size: 20px;
            background-color: #fff;
            border-radius: 20px;
            background-image: url("userbg.jpg");
            color: #ddd;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        .styled-form {
    max-width: 400px;
    margin: 0 auto;
}


.About h1 {
    text-align: center;
    color: #fff;
    text-shadow: 3px  3px 6px#ff0055;
    font-size: 50px;
    margin-left: 1%;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
}

.input-container {
    position: relative;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}




button.changepass {
    background-color: #b700ff;
    color: white;
    border: none;
    font-size: large;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 2px 2px 5px#acaf01;
    margin-left: 32%;
    transition: background-color 0.3s;
}

button.changepass:hover {
    background-color: #0056b3;
}
.profile-box {
    max-width: 300px;
    margin: 20px auto;
    text-align: center;
    height: 650px;
    background-color: #0d1425;
    border-radius: 10px;
}

.change-profile-btn {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 10px;
    transition: background-color 0.3s;
    margin-top: 30px;
}
.back-btn{
    background-color: #ff0000;
    color: white;
    border: none;
    font-size: 1.3em;
    box-shadow: 3px 3px 5px#970101;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 10px;
    transition: background-color 0.3s;
    margin-top: 30px;
}
.back-btn:hover{
        background-color: #ff00008e;
}

.change-profile-btn:hover {
    background-color: #0056b3;
}

#profile-image {
    width: 100%;
    max-width: 200px;
    border-radius: 50%;
    margin-bottom: 10px;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    color: #ddd;
    font-size: 1.1em;
    font-weight: bold;
    padding-top: 15px;
}
ul li i{
    padding-inline: 10px;
}
.userinfo{
    display: flex;
    height: 500px;
}
.info{
    width: 300px;
    margin-left: 3%;
}
.editor{
    width: 300px;
    margin-left: 20%;
}

    </style>

    </head>
 
    <body>
        <div class="container">
            <div class="profile-box">

                <img id="profile-image" src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                <button class="change-profile-btn">Change Profile</button>

                <ul>
                    <li><?php echo $FirstName?></li>
                    <li><?php echo $Email?></li>
                    <li>------------</li>
                    <li>Dinero-Dash</li>
                    <li>------------</li>

                    <button onclick="redirectToDash()" class="back-btn">Go Back</button>
                    <li>
                        <i style="font-size: 24px" class="fa">&#xf230;</i>
                        <i style="font-size: 24px" class="fa">&#xf0d5;</i>
                        <i style="font-size: 24px" class="fa">&#xf0e1;</i>
                    </li>
                </ul>
            </div>
            
           <div class="About">
            <ul>
                <h1>General Information</h1>
                <div class="userinfo">
                    <div class="info">
                        <h2>Profile Information</h2>
                        <form class="styled-form">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <p><?php echo $FirstName?></p>
                            </div>
                        
                            <div class="form-group">
                                <label for="secondname">Second Name</label>
                                <p><?php echo $SecondName?></p>
                            </div>
                        
                            <div class="form-group">
                                <label for="email">Email</label>
                                <p><?php echo $Email?></p>
                            </div>
                        
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <p><?php echo $Phone?></p>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <p>*******</p>
                            </div>
                        </form>
                    </div>
                    <div class="editor">
                        <h2>Edit Profile</h2>
                        <form class="styled-form" method="POST">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <div class="input-container">
                                <input type="text" name="FirstName" id="firstnameInput" >
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="secondname">Second Name</label>
                            <div class="input-container">
                                <input type="text" name="SecondName" id="secondname">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-container">
                                <input type="email" name="Email" id="email">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <div class="input-container">
                                <input type="number" name="Phone" id="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-container">
                                <input type="password" name="Password" id="password">
                            </div>
                        </div>
                        <button class="changepass">Save changes</button>
                    </form>
                    </div>
                    
                </div>
         
        </div>
        </div> 
        <script>
            function redirectToDash() {
              window.location.href = "Dash.php";
            }
          </script>

    </body>
</html>