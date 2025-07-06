<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        header {
            background: #004aad;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        .container {
            padding: 2rem;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h2 {
            font-size: 2rem;
            margin: 0.5rem 0;
            color: #004aad;
        }
        .label {
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Analytics Dashboard</h1>
    </header>

    <div class="container">
        <div class="card">
            <div class="label">Total Blogs</div>
            <h2><?= $totalBlogs ?></h2>
        </div>
        <div class="card">
            <div class="label">Total Admins</div>
            <h2><?= $totalAdmins ?></h2>
        </div>
        <div class="card">
            <div class="label">Total Authors</div>
            <h2><?= $totalAuthors ?></h2>
        </div>
        <div class="card">
            <div class="label">Total Viewers</div>
            <h2><?= $totalViewers ?></h2>
        </div>
    </div>
</body>
</html>
