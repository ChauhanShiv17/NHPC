<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Rejected Blogs - Author Panel</title>
<style>
    body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f6fb; margin: 0; padding: 0; color: #333; }
    header { background-color: #b71c1c; color: white; padding: 1rem 2rem; text-align: center; }
    h1 { margin: 0; }
    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    .blog-card {
        display: flex; flex-direction: column;
        background: white; border-radius: 12px; overflow: hidden;
        margin-bottom: 1rem; text-decoration: none; color: inherit;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: transform 0.2s ease;
    }
    .blog-card:hover { transform: translateY(-4px); }
    .blog-header { display: flex; align-items: center; }
    .blog-header img { width: 140px; height: 100px; object-fit: cover; flex-shrink: 0; }
    .blog-content { padding: 0.8rem 1rem; flex: 1; }
    .blog-title { font-size: 1.2rem; font-weight: bold; color: #b71c1c; margin-bottom: 0.3rem; }
    .blog-snippet { font-size: 0.95rem; color: #555; }
    .admin-review {
        background: #ffe6e6; color: #b71c1c;
        padding: 0.5rem 1rem; font-size: 0.9rem;
        border-top: 1px solid #f1b0b0;
    }
    .edit-btn {
        display: inline-block; background-color: #b71c1c; color: white;
        padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.95rem;
        margin: 0.8rem 1rem; align-self: flex-start;
        transition: background 0.3s ease;
    }
    .edit-btn:hover { background-color: #a31a1a; }
    .no-blogs { text-align: center; margin-top: 3rem; font-size: 1.2rem; color: #777; }
    footer { text-align: center; padding: 1rem; font-size: 0.9rem; color: #555; margin-top: 3rem; }
    @media (max-width: 600px) {
        .blog-header { flex-direction: column; align-items: flex-start; }
        .blog-header img { width: 100%; height: 180px; }
    }
</style>
</head>
<body>

<header>
    <h1>My Rejected Blogs</h1>
</header>

<div class="container">
<?php if ($blogs): ?>
    <?php foreach ($blogs as $blog): ?>
        <div class="blog-card">
            <div class="blog-header">
                <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">
                <div class="blog-content">
                    <div class="blog-title"><?= esc($blog['title']) ?></div>
                    <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 15) ?></div>
                </div>
            </div>
            <div class="admin-review">
                <strong>Admin Review:</strong>
                <?= esc($blog['admin_review'] ?: 'No review provided.') ?>
            </div>
            <a href="<?= site_url('author/dashboard/editRejected/' . $blog['id']) ?>" class="edit-btn">Edit & Resubmit</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-blogs">You have no rejected blogs.</div>
<?php endif; ?>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System. All rights reserved.</footer>
</body>
</html>
