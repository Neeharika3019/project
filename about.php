<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basilico - About</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: black; /* global text black */
        }

        /* Header */
        header {
            background-color: #3b873e;
            color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
        }
        header img {
            height: 60px;
        }
        nav {
            flex: 1;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }
        nav a {
            color: black;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }
        nav a:hover {
            text-decoration: underline;
        }

        /* Main */
        .main {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            min-height: 80vh;
        }
        .main div {
            color: black;
        }
        .main .green {
            background: #14823b;
            text-align: left;
            font-size: 18px;
            line-height: 1.6;
            padding: 40px 60px; /* push green text inward */
        }
        .main .white {
            background: #fff;
            text-align: center;
            padding: 40px;
        }
        .main .red {
            background: #b21e1e;
            font-size: 18px;
            line-height: 1.6;
            padding: 40px; /* keep column padding normal */
        }
        .main .red .content {
            max-width: 80%;   /* shrink content width */
            margin: 0 auto;   /* center it */
            text-align: left; /* keep text left aligned */
        }
        .main img {
            width: 90%;
            max-width: 300px;
            border-radius: 10px;
            margin: 20px 0;
        }
        /* Bigger right image */
        .main .red img {
            width: 95%;
            max-width: 350px;
            display: block;
            margin: 20px auto;
        }
        /* Lower + bigger middle logo */
        .main .white img {
            margin-top: 180px;
            height: 180px;
            width: auto;
        }

        /* Footer */
        footer {
            background: #e53935;
            color: black;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 30px;
            font-size: 14px;
        }
        footer h4 {
            margin-bottom: 10px;
        }
        footer a {
            color: black;
            text-decoration: none;
            display: block;
            margin: 5px 0;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .logo-footer {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-footer img {
            height: 120px;
        }

        /* Responsive */
        @media(max-width: 900px) {
            .main {
                grid-template-columns: 1fr;
            }
            .main img {
                width: 70%;
                max-width: 280px;
            }
            .main .red img {
                max-width: 320px;
            }
            .main .white img {
                margin-top: 60px;
                height: 120px;
            }
            footer {
                grid-template-columns: 1fr;
                text-align: center;
            }
            nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            .main .green {
                padding: 30px 40px;
            }
            .main .red .content {
                max-width: 90%; /* a bit wider on small screens */
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <img src="images/logo.jpeg" alt="Basilico Logo">
        <nav>
            <a href="home.php">Home</a>
            <a href="about.php"><b>About</b></a>
            <a href="menu.php">Menu</a>
            <a href="reservation.php">Reservation</a>
            <a href="order.php">Order Online</a>
            <a href="login.php">Login</a>
        </nav>
        <div></div>
    </header>

    <!-- Main Content -->
    <div class="main">
        <div class="green">
            <p>Welcome to Basilico, where the flavors
                     of Italy come alive.</p>
            <p>We are passionate about serving 
                authentic Italian spaghetti.</p>
            <img src="images/spag1.jpeg" alt="Spaghetti">
            <p>
                Basilico was founded with the 
                  dream of bringing the rich 
                     flavors of Italy to our 
                          community. 
            </p>
        </div>
        <div class="white">
            <img src="images/logo.jpeg" alt="Basilico Logo">
        </div>
        <div class="red">
            <div class="content">
                <p>Basilico brings the taste of 
                   <p> Italy to your table.</p>
                <p>We take pride in crafting dishes 
                    that highlight the essence of Italian cuisine.</p>
                <img src="images/spag2.jpeg" alt="Spaghetti Dish">
                <p>
                    Our restaurant celebrates the 
                    history and passion of Italian 
                    cuisine, especially the 
                    different flavors of spaghetti.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="logo-footer">
            <img src="images/logo2.jpeg" alt="Basilico Logo">
        </div>
        <div>
            <h4>Doormat Navigation</h4>
            <a href="home.php">Home</a>
            <a href="about.php"><b>About</b></a>
            <a href="menu.php">Menu</a>
            <a href="reservation.php">Reservation</a>
            <a href="order.php">Order Online</a>
            <a href="login.php">Login</a>
        </div>
        <div>
            <h4>Contact</h4>
            <p>📍 Port Louis, Mauritius</p>
            <p>📞 +230 5555 1234</p>
            <p>✉ contact@basilico.mu</p>
            <h4>Opening Hours</h4>
            <p>Mon-Fri: 11:00 AM - 10:00 PM</p>
            <p>Sat-Sun: 12:00 PM - 11:30 PM</p>
        </div>
    </footer>

</body>
</html>
