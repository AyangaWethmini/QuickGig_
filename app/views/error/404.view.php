<h1>View file not found</h1>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #A3C9FF, #4682B4, #1D3C6B);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* .container {
            text-align: center;
            color: #fff;
        } */

        .error {
            font-size: 180px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 15px;
            color: #fff;
            text-shadow: 0 0 15px #190773, 0 0 30px #190773, 0 0 45px #190773;
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        @keyframes glow {
            0% {
                text-shadow: 0 0 5px #190773, 0 0 10px #190773, 0 0 15px #190773;
            }

            100% {
                text-shadow: 0 0 20px #190773, 0 0 40px #190773, 0 0 60px #190773;
            }
        }

        .message {
            font-size: 24px;
            color: #fff;
            margin-top: 20px;
            opacity: 0.8;
        }

        .sad-face {
            font-size: 80px;
            margin-top: 50px;
            color: #ff4747;
            animation: sadBlink 1s infinite alternate;
        }

        @keyframes sadBlink {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .button {
            margin-top: 40px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #190773;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            display: inline-block;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: #4640de;
            transition: all 0.4s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
        }

        .button:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .button:hover {
            background-color: #d43f3f;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateY(-5px);
        }

        .button span {
            position: relative;
            z-index: 10;
        }

        /* Bouncing dots animation */
        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background-color: #190773;
            border-radius: 50%;
            animation: bounce 0.6s infinite alternate;
        }

        .dot:nth-child(1) {
            animation-delay: 0s;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="error">404</div>
        <div class="message">Oops! The page you’re looking for doesn’t exist.</div>
        <div class="message">Please check the URL or click below to go back home.</div>

        <div class="sad-face">
            &#128577; <!-- Sad face emoji -->
        </div>

        <a href="<?php echo BASEURL; ?>/" class="button">
            <span>Back to Home</span>
        </a>

        <div class="message" style="margin-top: 20px;">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
        </div>
    </div>

    <script>
        // Optional JavaScript for smooth scrolling when clicking the button
        document.querySelector('.button').addEventListener('click', function(e) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

</body>

</html>