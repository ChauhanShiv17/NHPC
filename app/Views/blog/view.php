<?php
$likeModel = new \App\Models\LikeModel();
$commentModel = new \App\Models\CommentModel();

$likeCount = $likeModel->where('blog_id', $blog['id'])->countAllResults();
$commentCount = $commentModel->where('blog_id', $blog['id'])->countAllResults();

$userLiked = false;
if (session()->get('user_id')) {
    $userLiked = $likeModel
        ->where('blog_id', $blog['id'])
        ->where('user_id', session()->get('user_id'))
        ->countAllResults() > 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= esc($blog['title']) ?> - NHPC Blog</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f4f6fb;
  color: #333;
}
.container {
  max-width: 900px;
  background: white;
  margin: 2rem auto;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  padding: 2rem;
  text-align: center;
}
h2 {
  margin-top: 0;
  color: #004aad;
  font-size: 2rem;
}
.blog-image img {
  width: 100%;
  max-height: 500px;
  object-fit: cover;
  border-radius: 12px;
  margin-top: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.meta {
  margin-top: 1rem;
  display: flex;
  justify-content: center;
  gap: 0.6rem;
  flex-wrap: wrap;
}
.meta-item {
  background: #eef2f7;
  color: #333;
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  gap: 0.3rem;
}
.category-badge {
  background: #004aad;
  color: white;
  padding: 0.25rem 0.6rem;
  border-radius: 12px;
  font-size: 0.8rem;
}
.blog-content {
  text-align: left;
  line-height: 1.7;
  font-size: 1.05rem;
  color: #444;
  white-space: pre-wrap;
  margin-top: 1.5rem;
}
.like-share-box {
  margin-top: 1.5rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}
.button-red {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #e50914;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.95rem;
  text-decoration: none;
  transition: background 0.2s;
}
.button-red i {
  font-size: 1rem;
}
.button-red:hover { background: #b0060f; }
.like-count {
  font-size: 0.9rem;
  color: #555;
  margin-top: 0.4rem;
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
/* Modal styles */
.modal {
  display: none; 
  position: fixed; 
  z-index: 999; 
  padding-top: 100px; 
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
}
.modal-content {
  background-color: #fff;
  margin: auto;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  text-align: center;
}
.close-btn {
  float: right;
  font-size: 1.2rem;
  cursor: pointer;
}
/* Comments section styling */
.comments-section {
  max-width: 600px;
  margin: 2rem auto;
  text-align: left;
}
.comment-item {
  background: #f9fafc;
  border: 1px solid #e0e5ec;
  border-radius: 8px;
  padding: 0.8rem 1rem;
  margin-bottom: 0.6rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.comment-item strong {
  color: #004aad;
  margin-right: 0.3rem;
}
.load-more-btn {
  display: inline-block;
  margin: 1rem auto;
  background: #004aad;
  color: white;
  padding: 0.4rem 0.9rem;
  border-radius: 20px;
  font-size: 0.9rem;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
}
.load-more-btn:hover {
  background: #003377;
}
</style>
</head>
<body>

<div class="container">
  <h2><?= esc($blog['title']) ?></h2>
  <div class="blog-image">
    <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">
  </div>
  <div class="meta">
    <span class="meta-item"><i class="fas fa-user"></i> <?= esc($blog['author_name'] ?? 'Unknown') ?></span>
    <span class="meta-item"><i class="fas fa-calendar-alt"></i> <?= date('F j, Y', strtotime($blog['created_at'])) ?></span>
    <?php if (!empty($blog['category'])): ?>
      <span class="meta-item category-badge"><i class="fas fa-tag"></i> <?= esc($blog['category']) ?></span>
    <?php endif; ?>
  </div>
  <div class="blog-content"><?= ($blog['content']) ?></div>

  <div class="like-share-box">
    <form action="<?= site_url('blog/like/' . $blog['id']) ?>" method="post">
      <?= csrf_field() ?>
      <button type="submit" class="button-red">
        <i class="fas fa-thumbs-up"></i> <?= $userLiked ? 'UNLIKE' : 'LIKE' ?>
      </button>
    </form>
    <button onclick="openCommentModal()" class="button-red">
      <i class="fas fa-comment"></i> COMMENT (<?= $commentCount ?>)
    </button>
    <button onclick="openShareModal()" class="button-red">
      <i class="fas fa-share"></i> SHARE
    </button>
  </div>
  <div class="like-count"><?= $likeCount ?> <?= $likeCount == 1 ? 'Like' : 'Likes' ?></div>
  <a href="<?= site_url('/blog') ?>" class="back-btn">← Back to All Blogs</a>
</div>

<!-- Comments display -->
<div class="comments-section">
  <h3>Comments</h3>
  <?php foreach($comments as $c): ?>
    <div class="comment-item">
      <strong><?= esc($c['username'] ?? 'Anonymous') ?>:</strong> <?= esc($c['comment']) ?>
    </div>
  <?php endforeach; ?>
  <?php if(count($comments) == 10): ?>
    <a href="#" class="load-more-btn">Load More</a>
  <?php endif; ?>
</div>

<!-- Comment Modal -->
<div id="commentModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeCommentModal()">&times;</span>
    <h3>Add your comment</h3>
    <form action="<?= site_url('blog/comment/' . $blog['id']) ?>" method="post">
      <?= csrf_field() ?>
      <textarea name="comment" rows="3" required placeholder="Write your comment..." style="width:100%; border-radius:8px; border:1px solid #ccc; padding:0.6rem;"></textarea><br>
      <button type="submit" class="button-red" style="margin-top:0.5rem;">
        <i class="fas fa-paper-plane"></i> Submit Comment
      </button>
    </form>
  </div>
</div>

<!-- Share Modal -->
<div id="shareModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeShareModal()">&times;</span>
    <h3>Share this blog</h3>
    <div class="share-options">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
      <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($blog['title']) ?>" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
      <a href="https://wa.me/?text=<?= urlencode($blog['title'] . ' ' . current_url()) ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
      <button onclick="copyLink()"><i class="fas fa-link"></i> Copy Link</button>
    </div>
  </div>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System. All rights reserved.</footer>

<script>
function openCommentModal() { document.getElementById('commentModal').style.display = 'block'; }
function closeCommentModal() { document.getElementById('commentModal').style.display = 'none'; }
function openShareModal() { document.getElementById('shareModal').style.display = 'block'; }
function closeShareModal() { document.getElementById('shareModal').style.display = 'none'; }
function copyLink() {
  const dummy = document.createElement('input');
  dummy.value = "<?= current_url() ?>";
  document.body.appendChild(dummy);
  dummy.select();
  document.execCommand('copy');
  document.body.removeChild(dummy);
  alert('Link copied to clipboard!');
}
// Close modal when clicking outside
window.onclick = function(e) {
  if(e.target == document.getElementById('commentModal')) closeCommentModal();
  if(e.target == document.getElementById('shareModal')) closeShareModal();
}
</script>

</body>
</html>
