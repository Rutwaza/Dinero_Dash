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

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DineroDash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding new expense
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense = $_POST["expense"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];

    // Insert data into the database
    $sql = "INSERT INTO expenses (UserID, ExpenseName, Amount, Description) VALUES ('$UserID','$expense', '$amount', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "Expense added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle clearing expense history
if (isset($_GET['action']) && $_GET['action'] == 'clearExpenseHistory') {
  $sql = "DELETE FROM expenses WHERE UserID = '$UserID'";
  
  if ($conn->query($sql) === TRUE) {
      echo "Expense history cleared successfully";
  } else {
      echo "Error clearing expense history: " . $conn->error;
  }
}

// Fetch expense history
$sql = "SELECT ExpenseName, Amount, Description FROM expenses WHERE UserID = '$UserID'";
$result = $conn->query($sql);
$expenseHistory = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenseHistory[] = $row;
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>expenses</title>
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <style>

body{
  background: #a7a7a7;
}


.search-container {
  display: flex;
  margin-left: 45%;
  width: 40%;
  margin-top: 10px;
  height: 30px;
  align-items: center;

}

.search-input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-sizing: border-box;
}

.search-button {
  padding: 8px 12px;
  margin-left: 10px;
  background-color: #3498db;
  color: #fff;
  border: darkblue;
  border-radius: 5px;
  cursor: pointer;
}

.search-button:hover {
  background-color: #2980b9;
}
.all{
        display: flex
    }

    .left {
        background-color: #2c3e50;
        height: 130vh;
        width: 250px;
        padding-top: 20px;
        border-radius: 10px;
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




.container{
  display: flex;
}

.main-top{
  background-color:#B3CDD3 ;
  border-radius: 5px;
  width: 100%;
  display: flex;

}
.main-top h1{
  color: #0526F5 ;
  font-size: 2em;
  text-transform: capitalize;
  margin-left: 10px;
  text-shadow: 2px 3px 20px #F205F5 ;
  margin-left: 10px;
}
  


.main-skills{
  display: flex;
  margin-top: 20px;
}
.main-skills .card{
  width: 25%;
  margin: 10px;
  background: #fff;
  text-align: center;
  border-radius: 20px;
  padding: 10px;
  box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
}
.main-skills .card h3{
  margin: 10px;
  text-transform: capitalize;
}
.main-skills .card p{
  font-size: 12px;
}
.main-skills .card button{
  background: orangered;
  color: #fff;
  padding: 7px 15px;
  border-radius: 10px;
  margin-top: 15px;
  cursor: pointer;
}
.main-skills .card button:hover{
  background: rgba(223, 70, 15, 0.856);
}
.main-skills .card i{
  font-size: 22px;
  padding: 10px;
}

.box p{
  font-size: 12px;
  margin-top: 5px;
}
.box button{
  background: #000;
  color: #fff;
  padding: 7px 10px;
  border-radius: 10px;
  margin-top: 3rem;
  cursor: pointer;
}
.box button:hover{
  background: rgba(0, 0, 0, 0.842);
}
.box i{
  font-size: 7rem;
  float: right;
  margin: -20px 20px 20px 0;
}

.fxd{
    width: 50%;
    height: 300px;
    background-color: none;
  padding: 10px 10px 10px 10px;
    border-radius: 1em;
}


table {
  width: 100%;
  margin: auto;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: #B1D9EB;}

th, td {
  border: 2px solid #1a1818;
  padding: 10px;
}


table button{
  background-color:#0DA0E4;
  font-size: 1.2rem;
  border-radius: 1.1em;
  background-size: 1.5rem;
  width: 70px;
}
table button:hover{
  background-color: #0D4E98;
}

th {
  background-color: #f2f2f2;
}

form {
  margin-top: 20px;
  text-align: center;
}


form label {
  display: flex;
  margin-bottom: 5px;
  font-weight: bold;
  color: #333; /* Adjust the color as needed */
}

form input,
    form textarea {
        width: 100%;
        padding: 8px;
        text-align: left;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }



.search-container {
  display: flex;
  margin-left: 45%;
  width: 40%;
  margin-top: 10px;
  height: 30px;
  align-items: center;

}

.search-input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-sizing: border-box;
}

.search-button {
  padding: 8px 12px;
  margin-left: 10px;
  background-color: #3498db;
  color: #fff;
  border: darkblue;
  border-radius: 5px;
  cursor: pointer;
}

.search-button:hover {
  background-color: #2980b9;
}

.expense-history {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.expense-history h2 {
    font-size: 1.3em;
    margin-bottom: 10px;
    width:400px;
    color:#FF0C00 ;

}

.expense-history table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.expense-history th, .expense-history td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.expense-history th {
    background-color: #4caf50;
    color: white;
}

.expense-history tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.cont{
  display: flex;
  width: 1100px;
}

.expense-form{
  margin-left:2%;
}
.notification {
  background-color: #2c3e50;
  color: white;
  text-decoration: none;
  padding: 15px 26px;
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
              
              <li><a href="task.php">
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
            <div class="main-top">
              <h1>EXPENSES</h1>
              <!-- Add your search bar here -->
              <div class="search-container">
                  <input type="text" id="expenseSearch" class="search-input" placeholder="Search expenses...">
                  <button type="button" class="search-button" onclick="searchExpenses()">Search</button>
                </div>
            </div>
          <div class="cont">
            <div class="expense-form">
              <h2>Add New Expense</h2>
              <form id="expenseForm" method="POST">
                  <label for="expense">Expense:</label>
                  <input type="text" id="expense" name="expense" required>

                  <label for="amount">Amount:</label>
                  <input type="text" id="amount" name="amount" required>

                  <label for="description">Description:</label>
                  <textarea id="description" name="description" required></textarea>

                  <button type="submit">Add Expense</button>
              </form>
            </div>

            <div class="expense-history">
                <h2>Expense History</h2>
                <ul id="expenseList">
                    <?php
                    foreach ($expenseHistory as $expense) {
                        echo "<li>{$expense['ExpenseName']} - {$expense['Amount']} - {$expense['Description']}</li>";
                    }
                    ?>
                </ul>
                <button onclick="clearExpenseHistory()">Clear History</button>

            </div>
          </div>
    </div>
      </div>
    </div>
    </div>
    </div>

    <script>
    // Your JavaScript code goes here

    // Function to fetch and display expense history
    function fetchExpenseHistory() {
        fetch('expense.php?action=fetchExpenseHistory', {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            const expenseList = document.getElementById('expenseList');
            expenseList.innerHTML = '';

            data.forEach(expense => {
                const listItem = document.createElement('li');
                listItem.textContent = `${expense.Expense} - ${expense.Amount} - ${expense.Description}`;
                expenseList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching expense history:', error));
    }

    // Call the fetchExpenseHistory function on page load
    fetchExpenseHistory();

     // Function to clear expense history
     function clearExpenseHistory() {
        fetch('expense.php?action=clearExpenseHistory', {
            method: 'GET',
        })
        .then(response => response.text())
        .then(message => {
            console.log(message);
            fetchExpenseHistory();
        })
        .catch(error => console.error('Error clearing expense history:', error));
    }

    // Call the fetchExpenseHistory function on page load
    fetchExpenseHistory();
</script>

  
   <script>
    // Add your JavaScript function for searching expenses here
    function searchExpenses() {
        var searchInput = document.getElementById("expenseSearch").value.toLowerCase();
        var expenseRows = document.getElementById("expenseTableBody").getElementsByTagName("tr");

        for (var i = 0; i < expenseRows.length; i++) {
            var expenseData = expenseRows[i].innerText.toLowerCase();

            if (expenseData.includes(searchInput)) {
                expenseRows[i].style.display = "";
            } else {
                expenseRows[i].style.display = "none";
            }
        }
    }
</script>
</body>
</html>
