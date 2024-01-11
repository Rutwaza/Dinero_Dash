<?php 
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $UserID = $_SESSION['user_id'];
} else {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

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


// Retrieve message for category 'profile_update'
$messagesql = "SELECT message FROM notifications WHERE UserID='$UserID' AND category='profile_update' ORDER BY timestamp DESC LIMIT 1";
$messagesqlresult = $conn->query($messagesql);
$message = "No new notificatios";
if ($messagesqlresult && $messagesqlresult->num_rows > 0) {
    $message = $messagesqlresult->fetch_assoc()["message"];
}

// Retrieve latest message for category 'financial_alert'
$message1sql = "SELECT message FROM notifications WHERE UserID='$UserID' AND category='financial-alert' ORDER BY id DESC LIMIT 1";
$message1sqlresult = $conn->query($message1sql);
$message1 = "No new notificatios";
if ($message1sqlresult && $message1sqlresult->num_rows > 0) {
    $message1 = $message1sqlresult->fetch_assoc()["message"];
}

// Retrieve latest message for category 'financial_alert1'
$message2sql = "SELECT message FROM notifications WHERE UserID='$UserID' AND category='financial-alert1' ORDER BY id DESC LIMIT 1";
$message2sqlresult = $conn->query($message2sql);
$message2 =  "No new notificatios";
if ($message2sqlresult && $message2sqlresult->num_rows > 0) {
    $message2 = $message2sqlresult->fetch_assoc()["message"];
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0000009d;
            border-radius: 10px;
        }

        .header {
    background-color: #0000006b;
    text-align: center;
    border-radius: 10px;
    width: 100%;
    height: 130px;
}

.neon-text {
    color: #00ffea; /* Neon Blue-Green Color */
    text-shadow: 0 0 6px #00ffea;
    display: inline-block;
}

.animated-text {
    animation: colorChange 1s infinite alternate; 
    font-size: 2em;}

@keyframes colorChange {
    0% {
        color: #ff00ff; /* Neon Magenta at the start of animation */
    }
    100% {
        color: #00ffea; /* Neon Blue-Green at the end of animation */
    }
}

section{
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    align-items: center;
}
        #notifications {
            width: 100%;
            margin: 20px auto;
            color: #fff1f1;
        }

        .notification-category {
            margin-bottom: 10px;
            background-color: #000000;
            border-radius: 10px;
            align-items: center;
            margin-left: 20px;
        }

        .category-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        #notificationList {
            list-style-type: none;
            padding: 0;
           
        }

        #notificationList li {
            margin-bottom: 15px;
            padding: 15px;
            list-style: none;
            margin-top: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .financial-alert {
            background-color: #ff020252;
            border: 2px solid #d63031;
            list-style: none;
            border-radius: 10px;
        }

        .user-update {
            background-color: #007efc5d;
            border: 2px solid #0984e3;
            border-radius: 10px;
            list-style: none;
        }

        .system-notice {
            background-color: #08f10059;
            border: 2px solid #00b894;
            border-radius: 10px;
            list-style: none;

        }

        .timestamp {
            color: #eeff00;
            font-size: 1em;
            text-shadow:2px 2px 4px #ff3c00;
        }
        .delete-button,
.remind-button {
    background-color: #d63031;
    color: #fff;
    border: none;
    padding: 8px 12px;
    margin-top: 10px;
    margin-left: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.remind-button {
    background-color: #0984e3;
}
.all{
    display: flex      
    }
    .left {
        background-color: #2c3e50;
        height: 118vh;
        width: 250px;
        padding-top: 20px;
        border-radius: 10px;
    }
    .right{
      width: 80%;
    }
    nav ul {
        list-style-type: none;
        padding: 0;
    }
    
    nav li {
        margin-bottom: 10px;
    }
    
    nav a {
        text-decoration: none;
        color: #ecf0f1;
        display: flex;
        align-items: center;
        padding: 10px;
        transition: background-color 0.3s ease;
        font-size: 20px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    
    nav a:hover {
        background-color: #34495e;
    }
    
    .logo {
        display: flex;
        align-items: center;
    }
    
    .logo img {
        margin-right: 10px;
        width: 100px;
    }
    
    .nav-item {
        margin-left: 10px;
    }
    .notification {
  background-color: #2c3e50;
  color: white;
  text-decoration: none;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification:hover {
  background: #34495e;
}

.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background: red;
  color: white;
  font: 1em sans-serif;
}
    </style>
</head>
<body>
<div class="all">
<div class="left">
    <nav>
        <ul>
            
            <li><a href="Dash.php" class="logo" onclick="loadDashboard()">
            <img src="logo.png" alt="LOGO" height="50%" width="50%">
            <span class="nav-item">Dashboard</span>
            </a></li>

            <li><a href="income.php" target="_self">
            <i class="fas fa-wallet"></i>
            <span class="nav-item">Income</span>
            </a></li>
            
            <li><a href="expense.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="nav-item">Expenses</span>
            </a></li>

            <li><a href="budget.php">
            <i class="fas fa-calculator"></i>
            <span class="nav-item">Budget</span>
            </a></li>
            
            <li><a href="tasks.php">
            <i class="fas fa-tasks"></i>
            <span class="nav-item">Tasks</span>
            </a></li>


            <li>
            <a href="notifications.php" class="notification">
            <i class="fas fa-envelope"></i>
            <span class="nav-item">Notifications</span>
            <span class="badge">3</span>
            </a>
            </li>

            <li><a href="user.php">
            <i class="fas fa-user"></i>
            <span class="nav-item">Profile</span>
            </a></li>
            
            <li><a href="login.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Log out</span>
            </a></li>
        </ul>
        </nav>

</div>
    
    
<div class="right">
    <div class="header">
        <h1 class="animated-text" >Notifications </h1>
        <p class="animated-text">Dinero-Dash <span class="neon-text">Real-time Updates</span> and <span class="neon-text">Important Notifications</span></p>
    </div>
    <main>
        <section id="notifications">
            <div class="notification-category" id="financialAlerts">
                <div class="category-title">Financial Alerts</div>
                <ul id="financialAlertList"></ul>
            </div>

            <div class="notification-category" id="userUpdates">
                <div class="category-title">User Updates</div>
                <ul id="userUpdateList"></ul>
            </div>

            <div class="notification-category" id="systemNotices">
                <div class="category-title">System Notices</div>
                <ul id="systemNoticeList"></ul>
            </div>
        </section>
    </main>
</div>
</div>

<script>
    window.onload = function() {
        var message = "<?php echo $message; ?>"; // message for user_update category
        var message1 = "<?php echo $message1; ?>"; // message for financial_alert category
        var message2 = "<?php echo $message2; ?>"; // message for financial_alert1 category



        var notifications = [
            { category: 'user-update', message:message},
            { category: 'financial-alert', message:message1},
            { category: 'financial-alert', message:message2},
            { category: 'system-notice', message: 'No new notifications yet.' }
        ];

        var financialAlertList = document.getElementById('financialAlertList');
        var userUpdateList = document.getElementById('userUpdateList');
        var systemNoticeList = document.getElementById('systemNoticeList');

        for (var i = 0; i < notifications.length; i++) {
            var li = document.createElement('li');
            li.className = notifications[i].category;

            // Create buttons
            var deleteButton = createDeleteButton(li);
            var remindButton = createRemindButton(li);

            // Set notification content
            li.innerHTML = '<p>' + notifications[i].message + '</p><span class="timestamp">' + getTimestamp() + '</span>';

            // Append buttons and notification to the list
            li.appendChild(deleteButton);
            li.appendChild(remindButton);

            switch (notifications[i].category) {
                case 'financial-alert':
                    financialAlertList.appendChild(li);
                    break;
                case 'user-update':
                    userUpdateList.appendChild(li);
                    break;
                case 'system-notice':
                    systemNoticeList.appendChild(li);
                    break;
                default:
                    console.log('You have no new notifications');
                    break;
            }
        }

        function createDeleteButton(notificationElement) {
            var deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.className = 'delete-button'; // Apply the CSS class
            deleteButton.onclick = function() {
                notificationElement.remove();
            };
            return deleteButton;
        }

        function createRemindButton(notificationElement) {
            var remindButton = document.createElement('button');
            remindButton.textContent = 'Remind Later';
            remindButton.className = 'remind-button'; // Apply the CSS class
            remindButton.onclick = function() {
                alert('Reminder set for later, in 5 minutes!');
            };
            return remindButton;
        }

        function getTimestamp() {
            var now = new Date();
            return now.toLocaleString();
        }
    };
</script>

</body>
</html>
