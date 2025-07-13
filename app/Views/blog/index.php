<?= view('partials/header') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Published Blogs</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6fb;
        margin: 0;
        padding: 0;
        color: #333;
    }
    header {
        background-color: #004aad;
        color: white;
        padding: 2rem 1rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h1 { margin: 0; font-size: 2.2rem; }
    p.subtitle { font-size: 1.1rem; margin-top: 0.5rem; }
    .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }

    /* ✅ Search bar */
    .search-bar {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .search-bar input[type="text"] {
        width: 320px;
        padding: 0.6rem 1rem;
        border: 1px solid #ccc;
        border-radius: 20px 0 0 20px;
        outline: none;
        font-size: 1rem;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }
    .search-bar button {
        background-color: #004aad;
        color: white;
        border: none;
        padding: 0.6rem 1rem;
        border-radius: 0 20px 20px 0;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }
    .search-bar button:hover { background-color: #003377; }

    #search-suggestions {
        position: absolute;
        top: 100%;
        width: 320px;
        background: white;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: none;
        max-height: 250px;
        overflow-y: auto;
        z-index: 100;
    }
    #search-suggestions .suggestion-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    #search-suggestions .suggestion-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 0.7rem;
    }
    #search-suggestions .suggestion-item:hover {
        background-color: #f0f0f0;
    }

    .blog-card {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 6px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }
    .blog-card img {
        width: 140px;
        height: 100px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .blog-content { padding: 0.8rem 1.2rem; }
    .blog-title {
        font-size: 1.3rem;
        color: #004aad;
        margin-bottom: 0.3rem;
        font-weight: bold;
    }
    .blog-snippet { font-size: 0.95rem; color: #555; }
    .no-blogs { text-align: center; margin-top: 4rem; font-size: 1.2rem; color: #777; }
    #load-more {
        display: block;
        margin: 2rem auto;
        padding: 0.7rem 1.5rem;
        background-color: #004aad;
        color: white;
        border: none;
        border-radius: 20px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    #load-more:hover { background-color: #003377; }
    footer {
        text-align: center;
        padding: 1rem;
        background: #eaeaea;
        margin-top: 4rem;
        font-size: 0.9rem;
        color: #555;
    }
    @media (max-width: 600px) {
        .search-bar { flex-direction: column; }
        .search-bar input[type="text"], .search-bar button, #search-suggestions {
            width: 100%;
            border-radius: 20px;
        }
        .blog-card { flex-direction: column; align-items: flex-start; }
        .blog-card img { width: 100%; height: 180px; }
    }
</style>
</head>
<body>
<header>
    <h1>Published Blogs</h1>
    <p class="subtitle">Explore insightful posts shared by our authors</p>
</header>

<div class="container">
    <!-- ✅ Search bar with button & autocomplete -->
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search blogs...">
        <button onclick="performSearch()">🔍</button>
        <div id="search-suggestions"></div>
    </div>

    <div id="blog-list">
    <?php if (isset($blogs) && !empty($blogs)): ?>
        <?php foreach ($blogs as $blog): ?>
            <a href="<?= site_url('blog/' . $blog['id']) ?>" class="blog-card">
                <img src="<?= !empty($blog['image']) ? base_url('uploads/' . $blog['image']) : base_url('assets/default.jpg') ?>" alt="Blog Image">
                <div class="blog-content">
                    <div class="blog-title"><?= esc($blog['title']) ?></div>
                    <div class="blog-snippet"><?= word_limiter(strip_tags($blog['content']), 12) ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-blogs">No blogs have been published yet. Check back soon!</div>
    <?php endif; ?>
    </div>

    <button id="load-more">Load More</button>
</div>

<footer>
    © <?= date('Y') ?> NHPC Blog System. All rights reserved.
</footer>

<!-- ✅ JS for Load More & Autocomplete -->
<script>
let offset = <?= count($blogs) ?>;

document.getElementById('load-more').addEventListener('click', function() {
    fetch('<?= site_url('blog/load-more') ?>?offset=' + offset)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById('load-more').innerText = "No more blogs";
                document.getElementById('load-more').disabled = true;
            } else {
                offset += data.length;
                data.forEach(blog => {
                    const a = document.createElement('a');
                    a.href = '<?= site_url('blog/') ?>' + blog.id;
                    a.className = 'blog-card';
                    a.innerHTML = `
                        <img src="${blog.image ? '<?= base_url('uploads/') ?>/' + blog.image : '<?= base_url('assets/default.jpg') ?>'}" alt="Blog Image">
                        <div class="blog-content">
                            <div class="blog-title">${blog.title}</div>
                            <div class="blog-snippet">${blog.content.substring(0, 100)}...</div>
                        </div>
                    `;
                    document.getElementById('blog-list').appendChild(a);
                });
            }
        });
});

// Autocomplete search
const searchInput = document.getElementById('search-input');
const suggestionsBox = document.getElementById('search-suggestions');

searchInput.addEventListener('input', function() {
    const query = this.value.trim();
    if(query.length > 0){
        fetch('<?= site_url('blog/search-suggest') ?>?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';
                if(data.length > 0){
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item';
                        div.innerHTML = `
                            <img src="${item.image ? '<?= base_url('uploads/') ?>/' + item.image : '<?= base_url('assets/default.jpg') ?>'}" alt="Blog">
                            <span>${item.title}</span>
                        `;
                        div.addEventListener('click', () => {
                            window.location.href = '<?= site_url('blog/') ?>' + item.id;
                        });
                        suggestionsBox.appendChild(div);
                    });
                    suggestionsBox.style.display = 'block';
                } else {
                    suggestionsBox.style.display = 'none';
                }
            });
    } else {
        suggestionsBox.style.display = 'none';
    }
});

// Click search button
function performSearch() {
    const query = searchInput.value.trim();
    if(query.length > 0){
        window.location.href = '<?= site_url('search?q=') ?>' + encodeURIComponent(query);
    }
}
</script>
</body>
</html>
