<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - NHPC Blog System</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f4f4;
    }

    header {
      background-color: #dc3545;
      color: white;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
      margin: 0;
      font-size: 2.2rem;
    }

    .container {
      padding: 3rem 2rem;
      max-width: 900px;
      margin: auto;
    }

    .dashboard-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-top: 2rem;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .card h3 {
      margin-bottom: 1rem;
      color: #dc3545;
    }

    .card a {
      display: inline-block;
      padding: 0.6rem 1.2rem;
      background: #dc3545;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .card a:hover {
      background: #c82333;
    }

    footer {
      text-align: center;
      padding: 1rem;
      background: #eaeaea;
      color: #555;
      font-size: 0.9rem;
      margin-top: 4rem;
    }

    .logout {
      text-align: right;
      margin: 1rem 2rem 0 0;
    }

    .logout a {
      color: #dc3545;
      text-decoration: none;
      font-weight: bold;
    }

  </style>
</head>
<body>

  <header>
    <h1>Admin Dashboard</h1>
    <p>Welcome! Manage content and users</p>
    
    
  </header>


  <div class="container">
    <div class="dashboard-buttons">
      <div class="card">
        <h3>📝 Pending Blogs</h3>
        <a href="<?= site_url('/admin/pending-blogs') ?>">Review Now</a>
      </div>

      <div class="card">
        <h3>🆔 Pending Admins</h3>
        <a href="<?= site_url('/admin/pending-admins') ?>">Approve Admins</a>
      </div>

      <div class="card">
        <h3>👥 All Users</h3>
<a href="<?= site_url('/admin/all-users') ?>">Manage Users</a>
      </div>

      <div class="card">
        <h3>📰 All Blogs</h3>
        <a href="<?= site_url('/admin/all-blogs') ?>">View Blogs</a>
      </div>

      <div class="card">
        <h3>👥 Rejected Blogs</h3>
<a href="<?= site_url('/admin/rejected-blogs') ?>">View Rejected Blogs</a>
      </div>
    </div>
  </div>

  <div class="card">
        <h3>⏻Logout</h3>
        <p>Exit your admin account</p>
        <a href="<?= site_url('/logout') ?>">Logout</a>
      </div>

  <footer>
    © <?= date('Y') ?> NHPC Blog System | Admin Panel
  </footer>

</body>
</html>
