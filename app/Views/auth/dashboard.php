<!DOCTYPE html>
<html>
<head>
    <title>Author Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        h2 {
            color: #004aad;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #0073e6;
            color: white;
        }

        .status {
            font-weight: bold;
            color: #666;
        }

        .approved {
            color: green;
        }

        .pending {
            color: orange;
        }

        a.create-btn {
            display: inline-block;
            padding: 10px 16px;
            margin-bottom: 1rem;
            background-color: #004aad;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        a.create-btn:hover {
            background-color: #00337f;
        }
    </style>
</head>
<body>
    <h2>Author Dashboard</h2>
    <a href="<?= site_url('/blog/create') ?>" class="create-btn">➕ Create New Blog</a>

    <?php if (!empty($blogs)): ?>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><?= esc($blog['title']) ?></td>
                    <td><?= esc($blog['category']) ?></td>
                    <td class="status <?= $blog['is_approved'] ? 'approved' : 'pending' ?>">
                        <?= $blog['is_approved'] ? 'Approved' : 'Pending' ?>
                    </td>
                    <td><?= esc($blog['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
        <p>You have not written any blogs yet.</p>
    <?php endif; ?>

    <div style="text-align:right; margin-bottom:10px;">
    <a href="<?= site_url('/logout') ?>" style="color:#dc3545; font-weight:bold;">Logout</a>
</div>



</body>
</html>
