<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($selectedCategory) ?> Blogs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #0066cc;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }

        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .blog-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            transition: 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .blog-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .blog-content {
            padding: 1rem;
        }

        .blog-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #003366;
        }

        .blog-snippet {
            color: #555;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background: #e9e9e9;
            margin-top: 4rem;
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1><?= esc(ucwords($selectedCategory)) ?> Blogs</h1>
    </header>

    <div class="container">
        <?php if (!empty($blogs)): ?>
        <div class="grid">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card">
                    <img src="<?= base_url('uploads/' . $blog['image']) ?>" alt="Blog Image">
                    <div class="blog-content">
                        <div class="blog-title"><?= esc($blog['title']) ?></div>
                        <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 7) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p>No blogs available in this category.</p>
        <?php endif; ?>
    </div>

    <footer>
        © <?= date('Y') ?> NHPC Blog System. All rights reserved.
    </footer>
</body>
</html>
