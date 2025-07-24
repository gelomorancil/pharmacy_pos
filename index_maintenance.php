<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Down</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1d1f21;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #333;
            border-radius: 8px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .btn {
            padding: 15px 30px;
            background-color: #ff4747;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }
        .btn:hover {
            background-color: #e43a3a;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>System is Currently Down</h1>
        <p>We are working hard to get things back online. Please try again later.</p>
        <button class="btn" onclick="window.location.reload();">Refresh</button>
    </div>

</body>
</html>
