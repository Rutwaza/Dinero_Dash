<?php
// Start a session
session_start();

// Check if the user is logged in, redirect to login if not
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
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

// Fetch user-specific data (example: total income and total expense)
$userID = $_SESSION["user_id"];

$currentDate = date('Y-m-d');

$totalIncomeQuery = "SELECT SUM(Amount) AS totalIncome FROM Income WHERE UserID = '$userID'";
$totalExpenseQuery = "SELECT SUM(Amount) AS totalExpense FROM Expenses WHERE UserID = '$userID'";

$totalIncomeResult = $conn->query($totalIncomeQuery);
$totalExpenseResult = $conn->query($totalExpenseQuery);

$totalIncome = $totalIncomeResult->fetch_assoc()["totalIncome"];
$totalExpense = $totalExpenseResult->fetch_assoc()["totalExpense"];

$category="Salary";
$category_salary="SELECT SUM(Amount) AS totalsalary FROM income WHERE UserID='$userID' AND Category='Salary';";
$category_salary_result=$conn->query($category_salary);
$category_salary_amount=$category_salary_result->fetch_assoc()["totalsalary"];

$category2="Gifts";
$category_gifts="SELECT SUM(Amount) AS totalgifts FROM income WHERE UserID='$userID' AND Category='Gift';";
$category_gifts_result=$conn->query($category_gifts);
$category_gifts_amount=$category_gifts_result->fetch_assoc()["totalgifts"];

$category3="Others";
$category_others="SELECT SUM(Amount) AS totalothers FROM income WHERE UserID='$userID' AND Category='Others';";
$category_others_result=$conn->query($category_others);
$category_others_amount=$category_others_result->fetch_assoc()["totalothers"];



// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <title>dash</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
.main{
    width: 100%;
    height: 900px;
    background-color: rgb(249, 250, 215);
        }

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

.t-balance{
  margin: 10px;
  background:  aliceblue ;
  text-align: center;
  border-radius: 20px;
  padding: 1px;
  
}
.t-income{
  
  margin: 10px;
  background:  aliceblue ;
  text-align: center;
  border-radius: 20px;
  padding: 1px;
  
}
.t-expense{

  margin: 10px;
  background: aliceblue ;
  text-align: center;
  border-radius: 20px;
  padding: 1px;
  
}

.section1 {
            display: flex;           
            background-color: rgba(255, 255, 255, 0.5); /* Transparent black background */
            padding: 5px;
        }

.t-balance, .t-income,.t-expense{
            width: 20%; /* Adjust the width to your preference */
            margin: 10px;
            background: rgb(178, 206, 230);
            text-align: center;
            border-radius: 20px;
            padding: 1px;
        }


.fa-circle-ellipsis {
            color: #FAC435; /* Set the color for the ellipsis icon */
            font-size: 1em;
        }

.t-balance p,.t-income p,.t-expense p{
    font-size: 1.5em; /* Adjust the font size to your preference */
    text-align: center;
    color: #f1eded;
    margin-left: 20%;
    width: 80%; /* Adjust the width to your preference */
    margin: 10px;
    background: #80797c;
    text-align: center;
    border-radius: 20px;
    padding: 1px;
    
}
.t-balance img{
    width: 90px;
}
.t-income img{
    width: 90px;
}   
.t-expense img{
    width: 90px;
} 
.t-income select{
    border-radius: 2em;
    text-align: center;
    font-weight: 500;
    text-shadow: 2px 2px 4px rgb(0, 247, 255) ;
    color:  rgb(0, 247, 255);
    background: #80797c;
    font-size: 1.2em;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
.t-balance select{
    border-radius: 2em;
    text-align: center;
    color: rgb(0, 247, 255);
    background: #80797c;
    font-weight: 500;
    text-shadow: 2px 2px 4px rgb(0, 247, 255) ;
    font-size: 1.2em;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

}
.t-expense select{
    border-radius: 2em;
    text-align: center;
    color: rgb(0, 247, 255);
    background: #80797c;
    text-shadow: 2px 2px 4px rgb(0, 247, 255) ;
    font-weight: 500;
    font-size: 1.1em;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

}

.flow{
    width: 40%;
    height: 350px;
    background-color: aliceblue;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    border-radius: 3em;
}
.flow h2{
    margin-left: 10%;
}
.flow img{
    margin-left: 10%;
    width: 300px;
    border-radius: 1.2em;
    
}
.opts {
            display: flex;
            align-items: left; /* Optional: Align vertically center */
            justify-content: space;
            align-items: center;
            
        }

.opts img {
           padding-top: 5px;
           padding-inline: 8px;
           width: 35px;
           margin-left: 31px;
           cursor: pointer;
        }
.opts p{
    padding-inline: 4px; 
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    margin-left: 26px;
    font-weight: 500;
}
.amount {
        font-size: 18px; /* Adjust the font size as needed */
        font-weight: bold; /* Optionally make the text bold */
        background-color: #f0f0f0; /* Set the background color */
        padding: 10px; /* Add padding for better look */
        border-radius: 5px; /* Optional: Add border-radius for rounded corners */
        color: #333; /* Set the text color */
        /* Add other styles as desired */
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
        margin-right: 3%;
        
    }
    .d-head{
        font-size: 1.5em;
        font-weight: 2em;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        color: #7303FA;
        text-shadow: 1px 1px 4px #fd00f1, 5px 5px 40px #ff008c;
        margin-left: 10px;

    }.d-prag{
        width: 20%;
        text-align: center;
    }
    .user{
        margin-left: 50px;
        align-items: center;
        height: 30px;
        display: flex
    }
    .user img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
        align-items: center;
        margin-left: 20px;
        cursor: pointer;
        padding: 2px;
    }
    .user p{
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-size: 1,3em;
        padding: 0%;
        cursor: pointer;
    }
    .part2{
        display: flex;
    }
    .trans{
        width: 62%;
        height: 400px;
        background-color: #f2f0f5;
        margin-left: 10px;
        margin-top: 10px;
        border-radius: 10px;
    }
    .grp{
        width: 38%;
        height: 400px;
        background-color: #FFEAF2;
        margin-left: 10px;
        margin-top: 10px;
        border-radius: 10px;
    }
    .prag_grp{
        font-size: 1.5em;

    }
    table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 2.5%;
        }

    th, td {
            border: none;
            padding: 10px;
            text-align: left;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

    th {
            background-color: #f2f2f2;
            border-radius: 10px;
        }
    td{
        background-color: #dfa4ff;
        border-radius: 5px;
    }
    .trans p{
        font-size: 1.5em;
        color: #0334FA;
        box-sizing: 2px 2px 10px #0334FA;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-weight: 100;
        margin-left: 35%;
    }
    .graph-heading {
        font-size: 1.5em;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-weight: 100;
        margin-left: 30%;
        color: #FE0064; 
        margin-bottom: 10px;
    }
    .all{
        display: flex
    }


    .left {
        background-color: #2c3e50;
        height: 125vh;
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
                 <div class="main">
                <div class="nav-container">
                    <div class="d-prag">
                    <p class="d-head">DASHBOARD <br>Dinero*Dash</p>
                    </div>
                    <div class="search-bar">
                        <input type="text" id="searchInput" placeholder="Search...">
                        <button type="button" onclick="performSearch()">Search</button>
                        <div class="user" id="userLink">
                            <img src="user-3296.png" alt="user" id="userImage">
                            <p class="p-acc" id="accountLink">My Account</p>
                        </div>
                    </div>
                    
                </div>
                <section class="section1">
                    
                    <div class="t-balance">
                        <p class="prg">Total Balance <a href="#"><i class="fa-circle-ellipsis"></i></a></p>
                        <p>Currency
                            <select name="currency" id="currency" class="currency">
                            <option value="USD">USD</option>
                            <option value="RWF">RWF</option> 
                            </select>
                        </p>
                        <p id="currentDate"></p>
                        <script>
                            function formatDate(date) {
                                const options = { year: 'numeric', month: 'long' };
                                return date.toLocaleDateString(undefined, options);
                            }
                            const currentDate = new Date()
                            document.getElementById("currentDate").innerText = formatDate(currentDate)
                        </script>
                        <img src="Account_balance.png" alt="icon">
                        <p class="amount" id="amount">Amount <?php echo number_format($totalIncome - $totalExpense, 2);?></p>
                    </div>
                    <div class="t-income">
                        <p class="prg">Total Income <a href="#"><i class="fa-circle-ellipsis"></i></a></p>
                        <p>Currency
                            <select name="currency" id="currency" class="currency">
                            <option value="USD">USD</option>
                            <option value="RWF">RWF</option> 
                            </select>
                        </p>
                        <p id="currentDate1"></p>
                        <script>
                            function formatDate(date) {
                                const options = { year: 'numeric', month: 'long' };
                                return date.toLocaleDateString(undefined, options);
                            }
                            const currentDate1 = new Date()
                            document.getElementById("currentDate1").innerText = formatDate(currentDate1)
                        </script>
                        <img src="pngwing.com.png" alt="icon">
                        <p class="amount" id="amount">Amount <?php echo number_format($totalIncome, 2); ?></p>
                    </div>
                    <div class="t-expense">
                        <p class="prg">Total Expense <a href="#"><i class="fa-circle-ellipsis"></i></a></p>
                        <p>Currency
                            <select name="currency" id="currency" class="currency">
                            <option value="USD">USD</option>
                            <option value="RWF">RWF</option> 
                            </select>
                        </p>
                        <p id="currentDate2"></p>
                        <script>
                            function formatDate(date) {
                                const options = { year: 'numeric', month: 'long' };
                                return date.toLocaleDateString(undefined, options);
                            }
                            const currentDate2 = new Date()
                            document.getElementById("currentDate2").innerText = formatDate(currentDate2)
                        </script>
                        <img src="shopping-cart.png" alt="icon">
                        <p class="amount" id="amount">Amount <?php echo number_format($totalExpense, 2); ?></p>                    </div>
                    <div class="flow">
                        <h2>My Cards</h2>
                        <img src="mycard.png" alt="mycard">
                        <div class="opts">
                            <div>
                                <img src="right-arrow-in-a-circle.png" alt="send">
                                <p>Send</p>
                            </div>
                            <div>
                                <img src="left-arrow-symbol-in-a-circle.png" alt="recv">
                                <p>Receive</p>
                            </div>
                            <div>
                                <img src="two-circular-arrows-symbol-in-a-circle.png" alt="exchange">
                                <p>Exchange</p>
                            </div>
                            <div>
                                <img src="dots_three_circle_icon_173867.png" alt="more">
                                <p>More</p>
                            </div>
                        </div>

                    </div>
                    </section>
                    <div class="part2">
                        <div class="trans">
                            <p>Income Category</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Insert sample data here -->
                                    <tr>
                                        <td>Salary</td>
                                        <td><?php echo $currentDate;?></td>
                                        <td><?php echo $category_salary_amount?></td>
                                    </tr>
                                    <tr>
                                        <td>Gifts</td>
                                        <td><?php echo $currentDate;?></td>
                                        <td><?php echo $category_gifts_amount?></td>
                                    </tr>
                                    <tr>
                                        <td>Others</td>
                                        <td><?php echo $currentDate;?></td>
                                        <td><?php echo $category_others_amount?></td>
                                    </tr>
                                
                                    <tr>
                                        <td>TOTAL INCOME</td>
                                        <td><?php echo $currentDate;?></td>
                                        <td><?php echo $totalIncome;?></td>
                                    </tr>
                                    
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table> 
                        </div>

                        <div class="grp">
                        <p class="graph-heading">Monthly Overview</p>
                        <canvas id="myPieChart" width="400" height="400"></canvas>
                        </div>
            </div>
    </div>



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
        
            <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the canvas element
        var ctx = document.getElementById('myPieChart').getContext('2d');

        // Define the data
        var data = {
            labels: ['Current Balance', 'Budget', 'Saving', 'Expenses'],
            datasets: [{
                data: [40, 25, 15, 20],
                backgroundColor: ['#36A2EB', '#FFCE56', '#4CAF50', '#FF6384'],
            }]
        };

        // Set up the options
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                arc: {
                    borderWidth: 3,  // You can adjust the border width if needed
                }
            },
            radius: '75%',  // Adjust the radius here (e.g., '50%' for a smaller radius)
        };

        // Create the pie chart
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var userLink = document.getElementById('userLink');
    var userImage = document.getElementById('userImage');
    var accountLink = document.getElementById('accountLink');

    userLink.addEventListener('click', function() {
        // Redirect to user.html when the user div is clicked
        window.location.href = 'user.html';
    });

    // Optionally, you can add separate event listeners for the image and paragraph
    userImage.addEventListener('click', function(event) {
        // Prevent the click event from propagating to the parent div
        event.stopPropagation();
        // Redirect to user.html when the image is clicked
        window.location.href = 'user.html';
    });

    accountLink.addEventListener('click', function(event) {
        // Prevent the click event from propagating to the parent div
        event.stopPropagation();
        // Redirect to user.html when the paragraph is clicked
        window.location.href = 'user.html';
    });
});
</script>


        </div>
</div>
</body>
</html>


