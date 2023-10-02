<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1669568625853-9a5ae8de190e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY4MDI1NjAzNw&ixlib=rb-4.0.3&q=50&w=1000');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container-inside {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            flex-direction: column;
            gap: 10px;
        }

        .container-inside>a {
            padding: 10px;
            display: block;
            background-color: #151210;
            color: silver;
            font-size: 2rem;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 1px solid silver;
            font-family: 'Courier New', Courier, monospace;
        }

        .container-inside>a:hover {
            transform: translateX(-5px) translateY(-5px);
            box-shadow: 5px 5px 0px 0px black;
        }

        .container-inside>h1 {
            text-align: center;
            color: silver;
            font-family: 'Courier New', Courier, monospace;
        }

        .container-inside>h1 strong {
            font-size: 5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-inside">
            <h1><strong role="status">404</strong> <br> Page Not Found</h1>
            <a href="/" role="button">
                Go to Homepage
            </a>
        </div>
    </div>
</body>

</html>