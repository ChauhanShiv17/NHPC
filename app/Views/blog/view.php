<!-- app/Views/blog/view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($blog['title']) ?> - NHPC Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6fb;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .blog-title {
            font-size: 2rem;
            color: #003366;
            margin-bottom: 1rem;
        }

        .blog-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .blog-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .blog-content {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            background: #0066cc;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
        }

        .back-link:hover {
            background: #004b99;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="blog-title"><?= esc($blog['title']) ?></h1>
        <div class="blog-meta">
            Category: <?= esc($blog['category']) ?>
            <?php if (!empty($blog['author'])): ?> | Author: <?= esc($blog['author']) ?><?php endif; ?>
        </div>

        <img class="blog-image" src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">

        <div class="blog-content">
            <?= $blog['content'] ?>
        </div>

        <a href="<?= site_url('/') ?>" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
