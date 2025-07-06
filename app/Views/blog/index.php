<?= view('partials/header') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Published Blogs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f4f8;
            color: #333;
        }

        header {
            background-color: #004aad;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
            margin: 0;
            font-size: 2.4rem;
        }

        p.subtitle {
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .blog-card {
            background: rgba(134, 103, 103, 0.32);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
        }

        .blog-title {
            font-size: 1.8rem;
            color: #004aad;
            margin-bottom: 0.6rem;
        }

        .blog-content {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #444;
        }

        .no-blogs {
            text-align: center;
            margin-top: 4rem;
            font-size: 1.2rem;
            color: #777;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background: #eaeaea;
            margin-top: 4rem;
            font-size: 0.9rem;
            color: #555;
        }

        @media (max-width: 600px) {
            .blog-title {
                font-size: 1.4rem;
            }

            .blog-content {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Published Blogs</h1>
        <p class="subtitle">Explore insightful posts shared by our authors</p>
    </header>

    <div class="container">
        <?php if (isset($blogs) && !empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card">
                    <div class="blog-title"><?= esc($blog['title']) ?></div>
                    <div class="blog-content"><?= esc($blog['content']) ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-blogs">No blogs have been published yet. Check back soon!</div>
        <?php endif; ?>
    </div>

    <footer>
        © <?= date('Y') ?> NHPC Blog System. All rights reserved.
    </footer>
</body>
</html>
