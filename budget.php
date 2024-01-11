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

// Check if the budget form is submitted
if (isset($_POST['total-amount-button'])) {
    // Get the budget value from the form
    $budget = $_POST['total-amount'];

    // Validate the budget value
    if ($budget <= 0) {
       
    } else {
        // Insert the budget into the database table
        $sql = "INSERT INTO budget (`userID`, `bug_amount`) VALUES ('$UserID', '$budget')";

        if ($conn->query($sql) === TRUE) {
        
        } else {
            echo "Error inserting budget: " . $conn->error;
        }
    }
}

// Check if the expense form is submitted
if (isset($_POST['check-amount'])) {
  // Get the product title and expense amount from the form
  $productTitle = $_POST['product_title'];
  $expenseAmount = $_POST['expense_amount'];

  // Validate the product title and expense amount
  if (empty($productTitle) || empty($expenseAmount)) {
      // Handle validation error
  } else {
      // Insert the expense into the database table
      $sql = "INSERT INTO budget (userID, prod_title, exp_amount) VALUES ('$UserID', '$productTitle', '$expenseAmount')";

      if ($conn->query($sql) === TRUE) {
          // Check if the total expense amount exceeds the budget total amount
          $totalExpenseQuery = "SELECT SUM(exp_amount) AS total_expense FROM budget WHERE userID = '$UserID'";
          $totalBudgetQuery = "SELECT SUM(bug_amount) AS total_bugamount FROM budget WHERE userID = '$UserID'";

          // Execute the queries
          $totalExpenseResult = $conn->query($totalExpenseQuery);
          $totalBudgetResult = $conn->query($totalBudgetQuery);

          // Check if the queries were successful
          if ($totalExpenseResult && $totalBudgetResult) {
              $totalExpenseRow = $totalExpenseResult->fetch_assoc();
              $totalBudgetRow = $totalBudgetResult->fetch_assoc();

              $totalExpense = $totalExpenseRow['total_expense'];
              $totalBudget = $totalBudgetRow['total_bugamount'];

              // Compare the total expense amount with the budget total amount
              if ($totalExpense > $totalBudget) {
                  // Insert a notification into the database table
                  $notificationCategory = 'financial-alert';
                  $financialalertMessage = 'Your budget has been exceeded.';
                  $notificationInsertQuery = "INSERT INTO notifications (userID, category, message) VALUES ('$UserID', '$notificationCategory', '$financialalertMessage')";

                  if ($conn->query($notificationInsertQuery) === TRUE) {
                      echo "Notification inserted successfully";
                  }
              }
          } else {
              echo "Error retrieving total expense and budget: " . $conn->error;
          }
      } else {
          echo "Error inserting expense: " . $conn->error;
      }
  }
}

// Check if the expense form is submitted
if (isset($_POST['reset-amount-button'])) {
    // Delete all data from the "budget" table
    $sql = "DELETE FROM budget";

    if ($conn->query($sql) === TRUE) {
      
    } else {
        echo "Error deleting expenses: " . $conn->error;
    }
}

if (isset($_POST['update-amount-button'])) {
  // Retrieve the new budget amount from the form input
  $newBudgetAmount = $_POST['total-amount'];
  
  // Update data in the "budget" table
  $sql = "UPDATE budget SET total_amount = '$newBudgetAmount' WHERE userID = $UserID";
  if ($conn->query($sql) === TRUE) {
     echo "Edited successfully";
  } else {
      echo "Error editing budget: " . $conn->error;
  }
}


// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Budget App</title>
    <style>
        @font-face {
  font-family: "General";
  src: url("./font/Nunito-ExtraLight.ttf");
}
@font-face {
  font-family: "heading";
  src: url("./font/Nunito-Bold.ttf");
}
body {
  margin: 0;
  padding: 0;
  width: 100%;
  font-family: "General";
  height: 100vh;
  background-color: #f5f5f5;
}
.container {
  width: 100%;
}
.header {
    background-color: #0000006b;
    text-align: center;
    border-radius: 10px;
    width: 100%;
    height: 130px;
}


/* Add Animation */
@keyframes slideIn {
  from {
    top: -300px;
    opacity: 0;
  }
  to {
    top: 0;
    opacity: 1;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.all{
        display: flex
    }


    .left {
        background-color: #2c3e50;
        height: 120vh;
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
.right{
    width: 80%;
    background-color: rgba(167, 167, 167, 0.336);
    border-radius: 10px;
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
.wrapper {
  width: 90%;
  font-size: 16px;
  max-width: 43.75em;
  margin: 1em auto;
}

.sub-container {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3em;
}
.flex {
  display: flex;
  align-items: center;
}
.flex-space {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.wrapper h3 {
  color: #363d55;
  font-weight: 500;
  margin-bottom: 0.6em;
}
.container input {
  display: block;
  width: 100%;
  padding: 0.6em 0.3em;
  border: 1px solid #d0d0d0;
  border-radius: 0.3em;
  color: #414a67;
  outline: none;
  font-weight: 400;
  margin-bottom: 0.6em;
}
.container input:focus {
  border-color: #587ef4;
}
.total-amount-container,
.user-amount-container {
  background-color: #ffffff;
  padding: 1.25em 0.9em;
  border-radius: 0.3em;
  box-shadow: 0 0.6em 1.2em rgba(28, 0, 80, 0.06);
}
.output-container {
  background-color: #587ef4;
  color: #ffffff;
  border-radius: 0.3em;
  box-shadow: 0 0.6em 1.2em rgba(28, 0, 80, 0.06);
  margin: 2em 0;
  padding: 1.2em;
}
.output-container p {
  font-weight: 500;
  margin-bottom: 0.6em;
}
.output-container span {
  display: block;
  text-align: center;
  font-weight: 400;
  color: #e5e5e5;
}
.submit {
  font-size: 1em;
  margin-top: 0.8em;
  background-color: #587ef4;
  border: none;
  outline: none;
  color: #ffffff;
  padding: 0.6em 1.2em;
  border-radius: 0.3em;
  cursor: pointer;
}
.list {
  background-color: #ffffff;
  padding: 1.8em 1.2em;
  box-shadow: 0 0.6em 1.2em rgba(28, 0, 80, 0.06);
  border-radius: 0.6em;
}
.sublist-content {
  width: 100%;
  border-left: 0.3em solid #587ef4;
  margin-bottom: 0.6em;
  padding: 0.5em 1em;
  display: grid;
  grid-template-columns: 3fr 2fr 1fr 1fr;
}
.product {
  font-weight: 500;
  color: #363d55;
}
.amount {
  color: #414a67;
  margin-left: 20%;
}
.icons-container {
  width: 5em;
  margin: 1.2em;
  align-items: center;
}
.product-title {
  margin-bottom: 1em;
}
.hide {
  display: none;
}
.error {
  color: #ff465a;
}
.edit {
  margin-left: auto;
}
.edit,
.delete {
  background: transparent;
  cursor: pointer;
  margin-right: 1.5em;
  border: none;
  color: #587ef4;
}
@media screen and (max-width: 600px) {
  .wrapper {
    font-size: 14px;
  }
  .sub-container {
    grid-template-columns: 1fr;
    gap: 1em;
  }
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
    <div class="container">
      <div class="header">
        <h1 class="animated-text">BUDGET</h1>
        <p class="animated-text">Dollars and Sense</p>
      </div>
      <div class="wrapper">
        <div class="container">
          <div class="sub-container">
            <!-- Budget -->

<form method="post">
    <div class="total-amount-container">
        <h3>Budget</h3>
        <p class="hide error" id="budget-error">
            Value cannot be empty or negative
        </p>
        <input
            type="number"
            id="total-amount"
            name="total-amount"
            placeholder="Enter Total Amount"
        />
        <button type="submit" class="submit" id="total-amount-button" name="total-amount-button">Set Budget</button>
        <button type="submit" class="submit" id="reset-amount-button" name="reset-amount-button">Reset Budget</button> 
        <button type="submit" class="submit" id="update-amount-button" name="update-amount-button">Edit Budget</button> 

    </div>
</form>

<form method="post">
    <!-- Expenditure -->
    <div class="user-amount-container">
        <h3>Expenses</h3>
        <p class="hide error" id="product-title-error">
            Values cannot be empty
        </p>
        <input
            type="text"
            class="product-title"
            id="product-title"
            name="product_title" 
            placeholder="Enter Title of Product"
        />
        <input
            type="number"
            id="user-amount"
            name="expense_amount" 
            placeholder="Enter Cost of Product"
        />
        <button type="submit" class="submit" id="check-amount" name="check-amount">Check Amount</button> <!-- Added type and name attributes -->
    </div>
</form> <!-- Output -->
<?php
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

// Retrieve the total budget from the database
$sql_budget = "SELECT bug_amount FROM budget";
$result_budget = $conn->query($sql_budget);

if ($result_budget && $result_budget->num_rows > 0) {
    $row_budget = $result_budget->fetch_assoc();
    $total_budget = $row_budget['bug_amount'];
    

} else {
    // Handle the case when the query fails or no results are returned
    $balance_amount = 0; // Set a default value or perform alternative actions
    $total_budget= 0;
}

// Retrieve the sum of expenditure value from the database
$sql_expenditure = "SELECT SUM(exp_amount) AS total_expenditure FROM budget";
$result_expenditure = $conn->query($sql_expenditure);
$row_expenditure = $result_expenditure->fetch_assoc();
$total_expenditure = $row_expenditure['total_expenditure'];

// Calculate the balance amount
$balance_amount = $total_budget - $total_expenditure;

// Close the database connection
$conn->close();
?>

<div class="output-container flex-space">
    <div>
        <p>Total Budget</p>
        <span id="amount"><?php echo $total_budget; ?></span>
    </div>
    <div>
        <p>Expenses</p>
        <span id="expenditure-value"><?php echo $total_expenditure; ?></span>
    </div>
    <div>
        <p>Balance</p>
        <span id="balance-amount"><?php echo $balance_amount; ?></span>
    </div>
</div>
        <!-- List -->
<?php
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

// Retrieve expense data from the database
$sql = "SELECT prod_title, exp_amount FROM budget";
$result = $conn->query($sql);

// Display expense data
if ($result->num_rows > 0) {
    echo '<div class="list">';
   
  
    while ($row = $result->fetch_assoc()) {
        echo '<p>Expense title: ' . $row["prod_title"] . ' <tab>Total amount: ' . $row["exp_amount"] . '</p>';
        echo '<div class="list-container" id="list">';

    }
    echo '</div>';
    echo '</div>';
} else {
    echo "No expenses found.";
}

// Close the database connection
$conn->close();
?>
      </div>
    </div>
  </div>

    
  </body>
</html>