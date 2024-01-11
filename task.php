<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the task information from the form inputs
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $taskDate = $_POST['myDate'];
    $description = $_POST['description'];
    $userID = 14; // Replace with the actual user ID

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database_name";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the input (to prevent SQL injection)
    $name = $conn->real_escape_string($name);
    $subject = $conn->real_escape_string($subject);
    $taskDate = $conn->real_escape_string($taskDate);
    $description = $conn->real_escape_string($description);

    // Insert the task into the database table
    $sql = "INSERT INTO tasks (name, subject, task_date, description, userID) VALUES ('$name', '$subject', '$taskDate', '$description', '$userID')";

    if ($conn->query($sql) === TRUE) {
        echo "Task inserted successfully.";
    } else {
        echo "Error inserting task: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



<html>
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    
   
    <style>
        /*Have this font on css and ttf file.*/
@font-face {
    font-family: test Sans;
    src: url('src/OpenSans-Regular.ttf');
}

html {
/*	OPEN SANS FONT PROJECT REQUIREMENT */
font-family: 'Open Sans', sans-serif;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}



body {
  margin: 0;
	
    background: #0288d1;
    color:white;
/*background Image*/
  background-image: url('https://i.imgur.com/AvhsQod.jpg');
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
  background-color: #464646;
}
	


/*MY SHADOW*/

myShadow,  .btn{
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}
.myShadow-2,.btn:hover {
  box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.container {
    width: 90%;
	margin-left: auto;
    margin-right: auto;
    text-align: center;
}
/*ROW and COL*/

.row {
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 20px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.row .col {
  float: left;
  box-sizing: border-box;
  padding: 0 0.75rem;
}

.row .col[class*="push-"], .row .col[class*="pull-"] {
  position: relative;
}

@media only screen and (max-width: 500px){
.row .col.s6 {
  width: 50%;
  margin-left: auto;
  left: auto;
  right: auto;
}



.row .col.s10 {
  width: 83.3333333333%;
  margin-left: auto;
  left: auto;
  right: auto;
}


.row .col.s12 {
  width: 100%;
  margin-left: auto;
  left: auto;
  right: auto;
}
	}

@media only screen and (min-width: 601px) {

  .row .col.m4 {
    width: 33.3333333333%;
    margin-left: auto;
    left: auto;
    right: auto;
  }

  .row .col.m6 {
    width: 50%;
    margin-left: auto;
    left: auto;
    right: auto;
  }
  
*/
  .row .col.m10 {
    width: 83.3333333333%;
    margin-left: auto;
    left: auto;
    right: auto;
  }

  .row .col.m12 {
    width: 100%;
    margin-left: auto;
    left: auto;
    right: auto;
  }
}

@media only screen and (min-width: 993px) {

  .row .col.l3 {
    width: 25%;
    margin-left: auto;
    left: auto;
    right: auto;
  }

  .row .col.l4 {
    width: 33.3333333333%;
    margin-left: auto;
    left: auto;
    right: auto;
  }
  
  .row .col.l6 {
    width: 50%;
    margin-left: auto;
    left: auto;
    right: auto;
  }
  
  .row .col.l10 {
    width: 83.3333333333%;
    margin-left: auto;
    left: auto;
    right: auto;
  }

  .row .col.l12 {
    width: 100%;
    margin-left: auto;
    left: auto;
    right: auto;
  }
}

/*FORM CONTROL*/
::-webkit-input-placeholder {
  color: #d1d1d1;
}

:-moz-placeholder {
  /* Firefox 18- */
  color: #d1d1d1;
}

::-moz-placeholder {
  /* Firefox 19+ */
  color: #d1d1d1;
}

:-ms-input-placeholder {
  color: #d1d1d1;
}

input:not([type]),
input[type=text],
textarea {
  background-color: transparent;
  border: none;
  border-bottom: 1px solid #9e9e9e;
  border-radius: 0;
  outline: none;
  height: 3rem;
/*  width: 100%;*/
  font-size: 1rem;
  margin: 0 0 15px 0;
  padding: 0;
  box-shadow: none;
  box-sizing: content-box;
  transition: all .3s;
}


textarea{
    overflow-y: hidden;
    padding: 1.6rem 0;
    resize: none;
    min-height: 3rem;
    font-family: sans-serif;
}




input:not([type]) + label:after,
input[type=text] + label:after,
textarea + label:after {
  display: block;
  content: "";
  position: absolute;
  top: 65px;
  opacity: 0;
  transition: .2s opacity ease-out, .2s color ease-out;
}



textarea {
/*  width: 100%;*/
  height: 3rem;
  background-color: transparent;
}



/*BUTTON*/
.btn{
  border: none;
  border-radius: 2px;
  display: inline-block;
  height: 36px;
  line-height: 36px;
  outline: 0;
  padding: 0 2rem;
  text-transform: uppercase;
  vertical-align: middle;
  -webkit-tap-highlight-color: transparent;
}





.btn {
  text-decoration: none;
  color: #fff;
  background-color: #4fc3f7;
  text-align: center;
  letter-spacing: .5px;
  transition: .2s ease-out;
  cursor: pointer;
}

.btn:hover {
  background-color: #81d4fa;
}


hr {
  box-sizing: content-box;
  height: 0;
}

#form {
    display:none;
}
input[type=text]{
	color:white;
}

input[type="date"]{
	border: none;
    background: none;
    border-bottom: 1px solid  #bbdefb;
    padding-bottom: 13.5px;
	color:	white;
}

textarea{
	color:white;
}

.red {
	background-color: #f44336;
}

.red:hover {
	background-color: #ef5350;
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
.right{
    width: 80%;
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
      <h1>Task Manager</h1>
      <hr>	
<!--       TASK FORM-->
        <section><div class="row">
           <form class="animated fadeIn" id="form">
           <div class="">
            <div class="s12 l12 m12">

                <input type="text" id="name" placeholder="Name">
                <input type="text" id="subject" placeholder="Subject">
                <input type="date" id="myDate">
            </div>
               
               <div class="row">
                <div class="s10 l10 m10">
                <textarea id="description" placeholder="Describe the Task" cols="30" rows="10" onClick="myObj.textSelect(this)"> Describe Your Task</textarea>
                               

            </div>
            </div>
            <div class="col s12 l12 m12">
                <div class="btn" onclick="submitInfo()">SUBMIT</div>
                <div class="btn" onclick="myObj.hide()">HIDE</div>
            </div>

            </div>
            </form>
        </div></section>
       <div class="btn" onClick="myObj.show()" id="show">New Task</div>
<!--       TASK LIST-->
  
          <div class="row" style="text-align:center;" id="myTasks">
          </div>
   </div>
</div>
</div>


   <script>
    //My Methods
var myObj= {
    //Select TextArea Func
    textSelect: function(){
        document.getElementById('description').select();
    },

//Hide form Method
    hide: function() {
    document.getElementById("form").style.display = "none";
    document.getElementById("show").style.display = "inline-block";

},
//Show Form Method
    show:function(){

    document.getElementById("form").style.display = "block";
    document.getElementById("show").style.display = "none";
    document.getElementById('myDate').valueAsDate = new Date();
    },
    //Removing task method
    removeTask: function () {
    var id = this.getAttribute('id');
    var myTasks = returnToDo();
    myTasks.splice(id, 1);
    localStorage.setItem('myData', JSON.stringify(myTasks));
    document.getElementById('myTasks').innerHTML = '';
    showMyTasks();
    console.log('delete');
    },
};


//Checks if there is already data in LocalStorage
function returnToDo(){
    var myTasks = [];
    var myTasksTemp = localStorage.getItem('myData');
    if(myTasksTemp != null){
        myTasks = JSON.parse(myTasksTemp);
    }
    return myTasks;
}
//Class that creates tasks.
function Task(){
    this.name = document.getElementById('name').value;
    this.subject = document.getElementById('subject').value;
    this.date = document.getElementById('myDate').value;
    this.describe = document.getElementById('description').value;
}
//Insert task properties into the HTML
function newTask(x, y, z, o, id) {
    document.getElementById('myTasks').innerHTML +=
        '<div class="col l3 m4 s12 animated zoomIn"> <h4>' + z + ':</h1>' +
        '<p>' + y + '</p>' +
        '<p>By: ' + x + '</p>' +
        '<p>Due: ' + o + '</p>' +
        '<div class="btn red" id="' + id + '">Delete</div>' +
        '</div>';
}
//Gets all the objects from the array.
function showMyTasks() {
    var myTasks = returnToDo();
    document.getElementById('myTasks').innerHTML = '';
    for (var i = 0; i < myTasks.length; i++) {
        newTask(
            myTasks[i].name,
            myTasks[i].describe,
            myTasks[i].subject,
            myTasks[i].date,
            i // pass the index as the id
        );
    }
    var deleteButtons = document.getElementsByClassName('red');
    for (var j = 0; j < deleteButtons.length; j++) {
        deleteButtons[j].addEventListener('click', myObj.removeTask);
    }

}
function submitInfo(){
    var myTasks = returnToDo();
    myTasks.push(new Task);
    localStorage.setItem('myData',JSON.stringify(myTasks));
    showMyTasks();
    myObj.hide();
}
showMyTasks();


   </script>



    </body>
</html>