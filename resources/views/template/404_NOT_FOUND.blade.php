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
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .container {
            text-align: center;
            padding: 20px;
            max-width: 600px;
            animation: fadeIn 1s ease-in;
        }

        h1 {
            font-size: 120px;
            color: #ff6b6b;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 36px;
            color: #333;
            margin: 20px 0;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #357abd;
        }

        .search-bar {
            margin: 20px 0;
        }

        .search-bar input {
            padding: 10px;
            width: 70%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
        }

        .search-bar button {
            padding: 10px 20px;
            border: none;
            background-color: #4a90e2;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 16px;
        }

        .search-bar button:hover {
            background-color: #357abd;
        }

        .animation {
            position: relative;
        }

        .ghost {
            width: 100px;
            height: 100px;
            background: url('https://img.icons8.com/ios-filled/100/000000/ghost.png') no-repeat center;
            background-size: contain;
            margin: 0 auto 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
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

        @media (max-width: 600px) {
            h1 {
                font-size: 80px;
            }

            h2 {
                font-size: 24px;
            }

            p {
                font-size: 16px;
            }

            .ghost {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="animation">
            <div class="ghost"></div>
        </div>
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>It looks like the page you're looking for doesn't exist or has been moved. Let's get you back on track!</p>
        <a href="/" class="btn">Back to Home</a>
    </div>
</body>

</html>