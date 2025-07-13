<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Blogs - Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 0.6s ease-in-out;
        }
        .container {
            padding: 2rem;
            animation: fadeInUp 0.6s ease-in-out;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 1rem;
            text-align: left;
        }
        th {
            background-color: #0073e6;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .actions a {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            margin: 0 0.3rem;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .approve {
            background-color: #28a745;
        }
        .approve:hover {
            background-color: #218838;
        }
        .reject {
            background-color: #dc3545;
        }
        .reject:hover {
            background-color: #c82333;
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
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<header>
    <h1>Pending Blogs</h1>
    <p>Approve or reject submitted blogs</p>
</header>

<div class="container">
    <?php if (!empty($blogs)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content Preview</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?= $blog['id'] ?></td>
                        <td><?= esc($blog['title']) ?></td>
                        <td><?= word_limiter(esc($blog['content']), 10) ?></td>
                        <td class="actions">
                            <a href="<?= site_url('admin/approve/' . $blog['id']) ?>" class="approve">Approve</a>
                            <a href="<?= site_url('admin/reject/' . $blog['id']) ?>" class="reject">Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending blogs to review at the moment.</p>
    <?php endif; ?>
</div>

<footer>
    © <?= date('Y') ?> NHPC Blog System | Admin Panel
</footer>
</body>
</html>
