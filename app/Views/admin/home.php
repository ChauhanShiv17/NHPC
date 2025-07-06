<!DOCTYPE html>
<html>
<head>
    <title>Admin Overview - NHPC Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 2rem;
        }

        h1 {
            color: #004aad;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .card h2 {
            margin: 0;
            font-size: 1.2rem;
            color: #222;
        }

        a.btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: #004aad;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <h1>Welcome Admin 👋</h1>

    <div class="card">
        <h2>Pending Blog Approvals</h2>
        <p>Moderate and manage submitted blogs from authors.</p>
        <a href="<?= site_url('/admin') ?>" class="btn">Go to Blog Moderation</a>
    </div>

    <div class="card">
        <h2>Logout</h2>
        <a href="<?= site_url('/logout') ?>" class="btn" style="background:#888;">Logout</a>
    </div>

</body>
</html>
