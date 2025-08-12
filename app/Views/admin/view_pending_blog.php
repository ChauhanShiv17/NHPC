<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Blog - Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
        }
        img {
            max-width: 100%;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .actions {
            margin-top: 2rem;
            text-align: center;
        }
        .actions a, .actions button {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
            border: none;
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
        /* Popup */
        .popup {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .popup-content {
            background: white;
            max-width: 400px;
            margin: 10% auto;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-top: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<header>
    <h1>Review Blog</h1>
</header>

<div class="container">
    <h2><?= esc($blog['title']) ?></h2>
    <?php if (!empty($blog['image'])): ?>
        <img src="<?= base_url('uploads/' . $blog['image']) ?>" alt="Blog Image">
    <?php endif; ?>
    <p><strong>Category:</strong> <?= esc($blog['category']) ?></p>
    <p><?= nl2br(($blog['content'])) ?></p>

    <div class="actions">
        <a href="<?= site_url('admin/approve/' . $blog['id']) ?>" class="approve">Approve</a>
        <button class="reject" onclick="openPopup()">Reject</button>
    </div>
</div>

<!-- Popup -->
<div class="popup" id="rejectPopup">
    <div class="popup-content">
        <h3>Reason for rejection</h3>
        <form method="post" action="<?= site_url('admin/reject_with_review/' . $blog['id']) ?>">
            <textarea name="review" required placeholder="Write your reason..."></textarea>
            <div style="margin-top:1rem;">
                <button type="submit" class="reject">Submit</button>
                <button type="button" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<footer>
    © <?= date('Y') ?> NHPC Blog System | Admin Panel
</footer>

<script>
    function openPopup() {
        document.getElementById('rejectPopup').style.display = 'block';
    }
    function closePopup() {
        document.getElementById('rejectPopup').style.display = 'none';
    }
</script>

</body>
</html>
