<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= esc($blog['title']) ?> - NHPC Blog</title>
<style>
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
  background: #f4f6fb;
}
.hero {
  position: relative;
  height: 100vh;
  background: url('<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>') center/cover no-repeat;
  background-attachment: scroll; /* use JS parallax instead */
  display: flex;
  align-items: center;
  justify-content: center;
  will-change: transform;
}
.hero::before {
  content: "";
  position: absolute;
  top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.4);
}
.hero::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0; right: 0;
  height: 100px;
  background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, #f4f6fb 100%);
  pointer-events: none;
}
.hero-title {
  position: relative;
  color: white;
  font-size: 2.5rem;
  text-align: center;
  z-index: 1;
  padding: 0 1rem;
}
.sticky-wrapper {
  max-width: 1000px;  /* same as .container */
  margin: 0 auto;
}
.sticky-title {
  position: sticky;
  top: 0;
  background: white;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
  color: #004aad;
  height: 60px;
  line-height: 60px;
  z-index: 10;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border-radius: 8px;
}
.container {
  max-width: 1000px;
  background: white;
  margin: 1rem auto;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  padding: 2rem;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 1s ease, transform 1s ease;
}
.container.visible {
  opacity: 1;
  transform: translateY(0);
}
.meta {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 1rem;
  gap: 0.5rem;
}
.meta-item {
  display: flex;
  align-items: center;
}
.meta-separator {
  color: #999;
  font-size: 1.1rem;
}
.category-badge {
  display: inline-flex;
  align-items: center;
  background: #004aad;
  color: white;
  padding: 0.25rem 0.6rem;
  border-radius: 12px;
  font-size: 0.8rem;
}
.blog-content {
  line-height: 1.7;
  font-size: 1.05rem;
  color: #444;
  white-space: pre-wrap;
  margin-top: 1.5rem;
}
.back-btn {
  display: inline-block;
  margin-top: 2rem;
  padding: 0.5rem 1rem;
  background: #004aad;
  color: white;
  border-radius: 20px;
  text-decoration: none;
  font-size: 0.95rem;
}
.back-btn:hover { background: #003377; }
footer {
  text-align: center;
  font-size: 0.85rem;
  color: #777;
  margin: 3rem auto 1rem;
}
</style>
</head>
<body>

<div class="hero" id="hero">
  <div class="hero-title"><?= esc($blog['title']) ?></div>
</div>

<div class="sticky-wrapper">
  <div class="sticky-title"><?= esc($blog['title']) ?></div>
</div>

<div class="container" id="content">
  <div class="meta">
    <span class="meta-item">👤 <?= esc($blog['author_name'] ?? 'Unknown') ?></span>
    <span class="meta-separator">•</span>
    <span class="meta-item">📅 <?= date('F j, Y', strtotime($blog['created_at'])) ?></span>
    <?php if (!empty($blog['category'])): ?>
      <span class="meta-separator">•</span>
      <span class="category-badge">🏷️ <?= esc($blog['category']) ?></span>
    <?php endif; ?>
  </div>

  <div class="blog-content">
    <?= esc($blog['content']) ?>
  </div>

  <a href="<?= site_url('/blog') ?>" class="back-btn">← Back to All Blogs</a>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System. All rights reserved.</footer>

<script>
// subtle parallax: translateY based on scroll
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset;
  const hero = document.getElementById('hero');
  hero.style.transform = 'translateY(' + (scrolled * 0.2) + 'px)';
});

// fade in effect
window.addEventListener('DOMContentLoaded', () => {
  document.getElementById('content').classList.add('visible');
});
</script>

</body>
</html>
