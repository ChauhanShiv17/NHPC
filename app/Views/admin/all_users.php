<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Registered Users - Admin Panel</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f4f4;
    }
    header {
        background-color: #6c63ff;
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
        background-color: #4a42f5;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    a.remove-btn {
        color: red;
        font-weight: bold;
        text-decoration: none;
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
    <h1>All Registered Users</h1>
    <p>Admins, Authors, and Viewers</p>
</header>

<div class="container">
<?php if (!empty($allUsers)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Blog Count</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allUsers as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= ucfirst($user['role']) ?></td>
                <td><?= ($user['role'] == 'author') ? esc($user['blog_count']) : '-' ?></td>
                <td>
                    <?php 
                        if($user['is_approved']==1) echo 'Active';
                        elseif($user['is_approved']==0) echo 'Pending';
                        elseif($user['is_approved']==-1) echo 'Blocked';
                    ?>
                </td>
                <td>
                    <?php if($user['is_approved'] != -1): ?>
                        <a class="remove-btn" href="<?= site_url('/admin/remove-user/'.$user['id']) ?>" onclick="return confirm('Are you sure you want to remove this user?')">Remove</a>
                    <?php else: ?>
                        Blocked
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>
</div>

<footer>
    © <?= date('Y') ?> NHPC Blog System | Admin Panel
</footer>
</body>
</html>
