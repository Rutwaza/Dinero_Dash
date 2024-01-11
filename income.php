<?php
// Start or resume the session
session_start();

// Assuming you store the user ID in a session variable after login
if (isset($_SESSION['user_id'])) {
    $UserID = $_SESSION['user_id'];
} else {
    // Redirect to the login page or handle the case where user is not logged in
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DineroDash";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalIncomeQuery = "SELECT SUM(Amount) AS totalIncome FROM Income WHERE UserID = '$UserID'";
$totalExpenseQuery = "SELECT SUM(Amount) AS totalExpense FROM Expenses WHERE UserID = '$UserID'";

$totalIncomeResult = $conn->query($totalIncomeQuery);
$totalExpenseResult = $conn->query($totalExpenseQuery);

$totalIncome = $totalIncomeResult->fetch_assoc()["totalIncome"];
$totalExpense = $totalExpenseResult->fetch_assoc()["totalExpense"];

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Insert new income
  if (isset($_POST["save-button"])) {
      $amount = $_POST["amount"];
      $currency = $_POST["currency"];
      $frequency = $_POST["frequency"];
      $category = $_POST["category"];
      $description = $_POST["description"];

      $sql = "INSERT INTO Income (UserID, Category, Amount, Currency, Frequency, Description) VALUES ($UserID, '$category', '$amount', '$currency', '$frequency', '$description')";

      if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
        // Generate a notification
        $category = 'financial-alert1';
        $totalIncomeQuery = "SELECT SUM(Amount) AS totalIncome FROM Income WHERE UserID = '$UserID'";
        $totalIncomeResult = $conn->query($totalIncomeQuery);
        $totalIncome = $totalIncomeResult->fetch_assoc()["totalIncome"];
        $message_income = 'Your current income amount is: ' . $totalIncome;
        
        // Insert the notification into the database
        $query = "INSERT INTO notifications (UserID, category, message) VALUES ('$UserID', '$category', '$message_income')";
      
              if ($conn->query($query) === TRUE) {
                echo "Notification inserted successfully";
            }
    }
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }

  // Update income
  elseif (isset($_POST["newIncomeAmount"])) {
      $newIncomeAmount = $_POST["newIncomeAmount"];

      $updateSql = "UPDATE income SET Amount = '0.00' WHERE UserID = $UserID";

      if ($conn->query($updateSql) === TRUE) {
          echo "Income updated successfully";
      } else {
          echo "Error updating income: " . $conn->error;
      }
  }


?>



<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    
        <title>Income</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
        <style>

    
    .nav-container{
        text-align: left;
        background-color: rgb(223, 216, 216);
        border-radius: 1em;
        display: flex;
    }
    ul{
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .nav-list{
        display: flex;
        justify-content: left;
        margin-left: 0%;
    }
    .nav-item{
        margin: 0;
        margin-left: 2%;
    }
    .nav-link{
        padding: 10px 70px;
        display: block;
        text-decoration: none;
        font-size: 1.3em;
        font-weight: 600;
        color: #f71414;
    }
    .nav-link1{
        padding: 10px 150px;
        display: block;
        text-decoration: none;
        font-size: 1.6em;
        font-weight: 600;
        color: #ff0000;
    }
    
        .search-bar input[type="text"] {
            padding: 5px;
            border: 1px solid #8099a1;
            border-radius: 3px;
            margin-right: 5px;
            width: 300px;
        }
        .search-bar button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .search-bar {
            position: absolute;
            top: 5%;
            right: 3%;
            height: 20px;
            display: flex;
            align-items: center;
            margin-right: 10%;
            
        }
        .d-head{
            font-size: 1.5em;
            font-weight: 2em;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            color: #7303FA;
            text-shadow: 1px 1px 4px #fd00f1, 5px 5px 40px #ff008c;
            margin-left: 10px;
    
        }
        
    
        
        
        .all{
            display: flex;
          }
    
    
    .left {
        background-color: #2c3e50;
        height: 690px;
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
   
        
     
        .card1{
          background-color: #8099a1;
          height: 600px;
          padding-inline: 5px;
          width: 800px;
          border-radius: 5px;
          border: 1px solid #ccc;
          text-align: center;
          width: 300px;
          margin-left: 2%;
          margin-top: 2%
        }

  

  .card1 i {
    font-size: 24px;
    margin-bottom: 10px;
  }

  .card1 h3 {
    font-size: 18px;
    margin-bottom: 15px;
  }

  .card1 label {
    display: block;
    margin-bottom: 5px;
    font-size: 24px;
    text-align: left;
    color: #000000;
  }

  .card1 input[type="number"],
  .card1 textarea,
  .card1 select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
  }
  .card1 button {
    width: 30%;
    padding: 8px;
    background-color: #109215;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 300;
  }
  .card1 button:hover{
    background-color: #07f10e;
  }

  .course{
    display: flex;
  
  }
  .histogram{
    width: 900px;
    height: 250px;
  }

  .total-income {
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    text-align: center;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .total-income h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
  }

  .total-income p {
    font-size: 18px;
    margin-bottom: 15px;
    color: #555;
  }

  .total-income .amount {
    font-size: 36px;
    font-weight: bold;
    color: #ff8c00;
  }
  .total-income select {
    font-size: 16px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 200px;
  }

  .total-income select option {
    font-size: 14px;
    background-color: #f9f9f9;
    color: #333;
  }
  .main-cards{
    width: 1300px;
    height: 630px;
    background-color:#fff;
    background-color: rgb(255, 255, 255);
    display: flex;
    border-radius:10px;
  }
  .inner{
    display: flex;
  }

  .outa {
            max-width: 500px;
            margin-left: 2%;
            margin-top: 2%;
            background-color:#7EB8FF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
          }
          .in-out{
            width: 800px;
            margin-left:2%;
          }
          .reset{
            text-align: center;
            font-size: 1.3em;
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
    
      <div class="nav-container">
        <div class="d-prag">
          <p class="d-head">INCOME</p>
        </div>
        <div class="search-bar">
          <input type="text" id="searchInput" placeholder="Search...">
          <button type="button" onclick="performSearch()">Search</button>
        </div>
      </div>
      <div class="main-cards">
        <div class="card1">
          <i class="fas fa-coins"></i>
          <h3>Salary</h3>
          
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <label for="current-salary">Current Salary</label>
          <input type="text" id="amount" name="amount" placeholder="Enter your current salary amount">

          <label for="currency">Currency</label>
          <select id="currency" name="currency">
            <option value="USD">USD</option>
            <option value="RWF">RWF</option>
            <!-- Add more currency options as needed -->
          </select>

          <label for="frequency">Salary Frequency</label>
          <select id="frequency" name="frequency">
            <option value="hourly">Hourly</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
          </select>

          <label for="category">Category</label>
          <select id="category" name="category">
            <option value="Salary">Salary</option>
            <option value="Gift">Gift</option>
            <option value="Others">Others</option>
          </select>

          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" placeholder="Enter a description"></textarea>

          <button type="submit" id="save-button" name="save-button">Save</button>
        </div>
        </form>  
         
        <div class="in-out">
          <div class="inner">
            <div class="oth">
              <section class="main-course">
                <h1>Out standings</h1>
                <div class="total-income">
                  <h3>Total Income</h3>
                  <p>Your Total Income:</p>
                  <p class="amount" id="amount"><?php echo number_format($totalIncome, 2); ?></p>
                </div>
              </section>
            </div>
            <div class="histogram">
              <p class="histogram-heading">Histogram</p>
              <canvas id="myHistogram" width="100" height="80"></canvas>
            </div>
          </div>
          <div class="outa">
              <h2>Reset Income</h2>

              <form id="updateIncomeForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <p class="reset">This will reset your amount to zero 
                  <br> Note that your Expenses and Budget will remain still. 
                  <br>And this will affect your new income 
                  <br>If you Don' t want so, You can <a href="expense.php">clear expenses</a> history </p>
                  <button type="submit" id="newIncomeAmount" name="newIncomeAmount">Reset</button>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Histogram data
      var histogramData = {
          labels: ['Gifts', 'Side Hustle', 'Salary', 'Others'],
          datasets: [{
                label: 'Histogram Data',
                backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1,
                data: [100, 200, 300, 230],
            }],
        
      };

      // Set up the options
      var histogramOptions = {
          scales: {
              x: {
                  beginAtZero: true,
                  fontSize: 10, // Adjust the font size as needed
              },
              y: {
                  beginAtZero: true,
                  fontSize: 10, // Adjust the font size as needed
              }
          }
      };

      // Create the histogram chart
      var myHistogram = new Chart(document.getElementById('myHistogram').getContext('2d'), {
          type: 'bar',
          data: histogramData,
          options: histogramOptions
      });
  });
</script>
<script>
  function performSearch() {
      var searchInput = document.getElementById('searchInput').value.toLowerCase();
      var items = document.querySelectorAll('.t-balance, .t-income, .t-expense');

      items.forEach(function (item) {
          var itemName = item.querySelector('.prg').textContent.toLowerCase();

          if (itemName.includes(searchInput)) {
              item.classList.remove('hidden');
          } else {
              item.classList.add('hidden');
          }
      });
  }
</script>



</div>
</body>
</html>