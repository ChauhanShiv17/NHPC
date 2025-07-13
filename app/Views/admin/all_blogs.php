<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Blogs</title>
<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6fb; margin: 0; padding: 0; }
    header { background-color: #0066cc; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
    .logo img { height: 50px; }
    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    .blog-list { display: flex; flex-direction: column; gap: 1rem; }
    .blog-item { display: flex; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); text-decoration: none; color: inherit; transition: transform 0.2s ease; }
    .blog-item:hover { transform: translateY(-3px); }
    .blog-img { flex: 0 0 180px; height: 120px; object-fit: cover; }
    .blog-info { padding: 1rem; display: flex; flex-direction: column; justify-content: center; }
    .blog-title { font-size: 1.2rem; font-weight: bold; color: #003366; margin-bottom: 0.3rem; }
    .blog-snippet { font-size: 0.95rem; color: #555; }
</style>
</head>
<body>
<header>
  <h1>Published Blogs</h1>
  <div class="logo">
    <img src="<?= base_url('assets/nhpc_logo.png') ?>" alt="NHPC Logo">
  </div>
</header>

<div class="container">
  <div class="blog-list">
    <?php if (!empty($blogs)): ?>
      <?php foreach ($blogs as $blog): ?>
        <a href="<?= site_url('blog/' . $blog['id']) ?>" class="blog-item">
          <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image" class="blog-img">
          <div class="blog-info">
            <div class="blog-title"><?= esc($blog['title']) ?></div>
            <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 15) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No blogs found.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
