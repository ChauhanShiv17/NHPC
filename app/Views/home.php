<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>NHPC Blog System - Home</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6fb; margin: 0; padding: 0; }
    header { background-color: #0066cc; color: white; display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .logo img { height: 50px; }
    .nav-buttons { display: flex; gap: 1rem; }
    .nav-buttons a { background-color: white; color: #0066cc; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-weight: bold; transition: 0.3s ease; }
    .nav-buttons a:hover { background-color: #e6f0ff; }

    .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }

    /* Search bar styling */
    .search-bar { display: flex; justify-content: center; margin-bottom: 2rem; }
    .search-bar input[type="text"] {
        width: 300px; padding: 0.6rem 1rem; border: 1px solid #ccc;
        border-radius: 20px 0 0 20px; outline: none; font-size: 1rem;
    }
    .search-bar button {
        background-color: #0066cc; color: white; border: none;
        padding: 0.6rem 1rem; border-radius: 0 20px 20px 0;
        cursor: pointer; font-size: 1rem;
    }
    .search-bar button:hover { background-color: #004b99; }

    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
    .blog-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.08); transition: transform 0.2s ease; text-decoration: none; color: inherit; display: block; }
    .blog-card:hover { transform: translateY(-5px); }
    .blog-card img { width: 100%; height: 160px; object-fit: cover; }
    .blog-content { padding: 1rem; }
    .blog-title { font-size: 1.1rem; font-weight: bold; color: #003366; margin-bottom: 0.5rem; }
    .blog-snippet { font-size: 0.95rem; color: #555; }

    .category-section { margin: 3rem auto; max-width: 1000px; padding: 0 1rem; }
    .category-section h2 { text-align: center; margin-bottom: 1rem; color: #333; }
    .categories { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
.category-btn {
    background-color: #0066cc;
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s ease, font-weight 0s; /* Remove font-weight animation */
}

.category-btn:hover, .category-btn.active {
    background-color: #004b99;
    font-weight: 500; /* keep same font-weight to avoid shifting */
}

    footer { text-align: center; padding: 1rem; background: #e9e9e9; margin-top: 4rem; font-size: 0.9rem; color: #555; }
</style>
</head>
<body>
<header>
  <div class="logo">
    <img src="<?= base_url('assets/nhpc_logo.png') ?>" alt="NHPC Logo">
  </div>
  <div class="nav-buttons">
    <a href="<?= site_url('/blog') ?>">All Blogs</a>
    <?php if (session()->get('role') === 'author' || session()->get('role') === 'admin'): ?>
<a href="<?= site_url('/author/dashboard') ?>">Author Panel</a>
    <?php endif; ?>
<?php if (session()->get('role') === 'admin'): ?>
  <a href="<?= site_url('/admin/dashboard') ?>">Admin Panel</a>
<?php endif; ?>

    <?php if (session()->get('isLoggedIn')): ?>
      <a href="<?= site_url('/logout') ?>">Logout</a>
    <?php endif; ?>
  </div>
</header>

<div class="container">

  <!-- ✅ Search bar -->
  <form action="<?= site_url('search') ?>" method="get" class="search-bar">
    <input type="text" name="q" placeholder="Search blogs..." value="<?= esc($query ?? '') ?>">
    <button type="submit">🔍</button>
  </form>

  <div class="grid">
    <?php if (!empty($blogs)): ?>
      <?php foreach ($blogs as $blog): ?>
        <a href="<?= session()->get('isLoggedIn') ? site_url('blog/' . $blog['id']) : site_url('login') ?>" class="blog-card">
          <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">
          <div class="blog-content">
            <div class="blog-title"><?= esc($blog['title']) ?></div>
            <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 7) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No recent blogs found.</p>
    <?php endif; ?>
  </div>
</div>

<div class="category-section">
  <h2>Explore by Category</h2>
  <div class="categories">
    <?php if (!empty($categories)): ?>
      <?php $selectedCategory = $selectedCategory ?? null; ?>
      <?php foreach ($categories as $cat): ?>
        <a class="category-btn <?= ($selectedCategory === $cat['category_name']) ? 'active' : '' ?>"
           href="<?= session()->get('isLoggedIn') ? site_url('category/' . urlencode($cat['category_name'])) : site_url('login') ?>">
          <?= esc($cat['category_name']) ?>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No categories found.</p>
    <?php endif; ?>
  </div>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System. All rights reserved.</footer>
</body>
</html>
