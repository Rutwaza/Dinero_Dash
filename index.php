<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="xstyle.css">
    <title>Financial Tracker</title>

</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to <span>Dinero*Dash</span></h1>
            <p>Your Financial Compass</p>
        </header>
       
        <div class="popup" id="popupCard">
            <p id="greetingMessage"></p>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
              var popup = document.getElementById("popupCard");
              var greetingMessage = document.getElementById("greetingMessage");
          
              // Display the popup
              popup.style.display = "block";
          
              // Set a timeout to hide the popup after 3 seconds
              setTimeout(function () {
                popup.style.display = "none";
              }, 3000);
          
              // Determine the time of day and update the greeting message
              var now = new Date();
              var hour = now.getHours();
          
              if (hour >= 5 && hour < 12) {
                greetingMessage.innerHTML = "Good morning <br> you're welcome to our site!";
              } else if (hour >= 12 && hour < 18) {
                greetingMessage.innerHTML = "Good afternoon <br> you're welcome to our site!";
              } else {
                greetingMessage.innerHTML = "Good evening <br> you're welcome to our site!";
              }
            });
          </script>


        <section>
            <p>Take control of your finances effortlessly with <span>Dinero*Dash</span>. Our intuitive personal finance tracker is designed to simplify money management and empower you on your financial journey.</p>
            <ul>
                <li><strong>Seamless Tracking</strong> 
                <br>Easily monitor your income, expenses, and savings in one place.</li>
                <li><strong>Smart Budgeting</strong> 
                <br>Set realistic budgets and receive personalized insights to achieve your financial goals.</li>
                <li><strong>Secure and Private</strong> 
                <br>Your financial data is encrypted and secure. Your privacy is our priority.</li>
            </ul>
        </section>
        <section class="cta">

            <div class="cta-container">
                <div class="in-cta">
                    <img src="giphy (3).gif" alt="gif3">
                </div>
                <div class="in-cta">
                    <h2>Get Started Today</h2>
                    <p title="Create account by clicking Register">New User? <a href="signup.php">Register</a> - Start your journey towards financial well-being.</p>
                    <p title="Get back into your account by clicking login">Already a Member? <a href="login.php">Login</a> - Dive back into your financial world.</p>
                    <p><span>Dinero*Dash</span> is more than a tool; it's your companion in achieving financial success. Sign up now and let's build a brighter financial future together!</p>
                </div>
            </div>
        </section>
    </div>

    <div class="description">
    <div class="feature-container">
            <div class="feature">
                <h2>Expense Tracking</h2>
                <p>Effortlessly track your daily expenses and gain insights into your spending habits. Our intuitive expense tracking feature helps you stay on top of your budget.</p>
                <ul>
                    <li> Categorize expenses for better organization.</li>
                    <li> Set monthly spending goals and receive notifications.</li>
                    <li> Visualize your spending patterns with interactive charts.</li>
                </ul>
                <img src="giphy (1).gif" alt="gif1">
            </div>
            <div class="feature">
                <h2>Goal Setting</h2>
                <p>Plan for your financial future by setting and tracking your financial goals. Achieve milestones and build a brighter future with our goal-setting feature.</p>
            
                <ul>
                    <li> Set short-term and long-term financial goals.</li>
                    <li> Track your progress with real-time updates.</li>
                    <li> Receive personalized tips to reach your goals faster.</li>
                </ul>
                <img src="giphy.gif" alt="giphy" height="350px" width="290px">
            </div>
            <div class="feature">
                <h2>Budget Management</h2>
                <p>Effortlessly manage your finances with our budgeting tools. Take control of your spending, save more, and achieve your financial goals.</p>
                <ul>
                    <li> Create personalized budgets based on your income and expenses.</li>
                    <li> Receive real-time alerts when you approach budget limits.</li>
                    <li> Analyze spending patterns with detailed budget reports.</li>
                </ul>
                <img src="giphy (2).gif" alt="gif2" height="350px" width="290px" margin-top="50px]">
            </div>
    </div>
            <h3>Why Use Our Financial Tracker App?</h3>
            <ul>
                <li><strong>User-Friendly Design:</strong> The Task Manager features a clean and intuitive interface, making financial fit a breeze.</li>
                <li><strong>Integration with Finance Tracker:</strong> Seamlessly switch between your Income and your Expenses for a holistic financial management experience.</li>
                <li><strong>Secure and Private:</strong> Your financial data is encrypted and secure, ensuring the utmost privacy and confidentiality.</li>
            </ul>

            <h3>JOIN US:</h3>
            <p>Join our community of users taking control of their finances effortlessly. Sign up and experience the synergy of a powerful financial tracker. Build a brighter financial future with ease!</p>
            <div class="buttons">
                <button class="loginbtn" onclick="redirectTo('login.php')">LOGIN</button>
                <button class="registerbtn" onclick="redirectTo('signup.php')">REGISTER</button>
              </div>

    </div>
    <script>
        function redirectTo(url) {
      window.location.href = url;
    }
    </script>

</body>
</html>
