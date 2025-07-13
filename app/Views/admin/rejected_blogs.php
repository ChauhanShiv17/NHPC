<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rejected Blogs - Admin Panel</title>
<style>
    body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f6fb; margin: 0; padding: 0; color: #333; }
    header { background-color: #b71c1c; color: white; padding: 1rem 2rem; text-align: center; }
    h1 { margin: 0; }
    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    .blog-card {
        display: flex; align-items: center;
        background: white; border-radius: 12px; overflow: hidden;
        margin-bottom: 1rem; text-decoration: none; color: inherit;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: transform 0.2s ease;
    }
    .blog-card:hover { transform: translateY(-4px); }
    .blog-card img { width: 140px; height: 100px; object-fit: cover; flex-shrink: 0; }
    .blog-content { padding: 0.8rem 1rem; }
    .blog-title { font-size: 1.2rem; font-weight: bold; color: #b71c1c; margin-bottom: 0.3rem; }
    .blog-author { font-size: 0.9rem; color: #555; margin-bottom: 0.2rem; }
    .blog-snippet { font-size: 0.95rem; color: #555; }
    .no-blogs { text-align: center; margin-top: 3rem; font-size: 1.2rem; color: #777; }
    footer { text-align: center; padding: 1rem; font-size: 0.9rem; color: #555; margin-top: 3rem; }
    @media (max-width: 600px) {
        .blog-card { flex-direction: column; align-items: flex-start; }
        .blog-card img { width: 100%; height: 180px; }
    }
</style>
</head>
<body>

<header>
    <h1>Rejected Blogs</h1>
</header>

<div class="container">
<?php if ($blogs): ?>
    <?php foreach ($blogs as $blog): ?>
        <a href="<?= site_url('blog/' . $blog['id']) ?>" class="blog-card">
            <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">
            <div class="blog-content">
                <div class="blog-title"><?= esc($blog['title']) ?></div>
                <div class="blog-author">By <?= esc($blog['author_name']) ?></div>
                <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 15) ?></div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-blogs">No rejected blogs found.</div>
<?php endif; ?>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System. All rights reserved.</footer>
</body>
</html>
