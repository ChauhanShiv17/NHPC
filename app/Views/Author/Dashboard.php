<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>Author Dashboard</title>
  <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
        }

        header {
            background-color: #0066cc;
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 0.6s ease-in-out;
        }

        h1 {
            margin: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            padding: 2rem;
            animation: fadeInUp 0.6s ease-in-out;
        }

        .card {
            background: white;
            padding: 1.5rem;
            width: 280px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .card a {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            background: #0066cc;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .card a:hover {
            background:  #0066cc;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background: #eaeaea;
            font-size: 0.9rem;
            color: #555;
            margin-top: 3rem;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
            }
    }
  </style>
</head>
<body>
    <header>
        <h1>Welcome to Author Dashboard</h1>
        <p>Manage your blogs and submissions</p>
    </header>

    <div class="container">
        <div class="card">
            <h3>Write a New Blog</h3>
            <p>Submit your thoughts and stories</p>
            <a href="/blog/create">Write Blog</a>
        </div>

        <div class="card">
            <h3>All Blogs</h3>
            <p>See what's been published</p>
            <a href="/blog">View Blogs</a>
        </div>

        <div class="card">
            <h3>Rejected</h3>
            <p>My Rejected Blogs</p>
            <a href="<?= site_url('/author/rejected-blogs') ?>">View My Rejected Blogs</a>

        </div>

        <div class="card">
            <h3>Logout</h3>
            <p>Exit your author account</p>
            <a href="/logout">Logout</a>
        </div>

  </div>

    <footer>
        © <?= date('Y') ?> NHPC Blog System | Author Panel
    </footer>
</body>
</html>
