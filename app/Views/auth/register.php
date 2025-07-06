<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f6fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #004aad;
            margin-bottom: 1.5rem;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #004aad;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0061c2;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            color: green;
        }

        .footer-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required> <!-- ✅ Email field -->
            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="viewer">Viewer</option>
                <option value="author">Author</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
        </form>

        <div class="footer-text">
            Already have an account? <a href="<?= site_url('login') ?>">Login here</a>
        </div>
    </div>
</body>
</html>
