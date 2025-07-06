<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #004aad;
            margin-bottom: 1.5rem;
        }

        .info {
            margin-bottom: 1rem;
        }

        .info label {
            font-weight: bold;
            color: #444;
        }

        .info span {
            display: block;
            margin-top: 0.25rem;
            color: #333;
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
        }

        .back-link a {
            color: #004aad;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Profile</h2>

        <div class="info">
            <label>Username:</label>
            <span><?= esc($user['username']) ?></span>
        </div>

        <div class="info">
            <label>Email:</label>
            <span><?= esc($user['email']) ?: 'Not provided' ?></span>
        </div>

        <div class="info">
            <label>Role:</label>
            <span style="text-transform: capitalize;"><?= esc($user['role']) ?></span>
        </div>

        <div class="back-link">
            <a href="/">← Back to Home</a>
        </div>
    </div>
</body>
</html>
