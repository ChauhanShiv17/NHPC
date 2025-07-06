<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 2rem;
        }

        .profile-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        h2 {
            color: #004aad;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1rem;
            margin: 0.5rem 0;
        }

        .btn {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.5rem 1rem;
            background-color: #004aad;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <h2>👤 My Profile</h2>

        <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
        <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
        <p><strong>Email:</strong> <?= esc($user['email'] ?? 'Not added') ?></p>

        <a href="/" class="btn">← Back to Home</a>
    </div>

</body>
</html>
