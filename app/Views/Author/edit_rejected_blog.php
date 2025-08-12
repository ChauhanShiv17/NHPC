<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit & Resubmit Blog - NHPC Blog System</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6fb;
        margin: 0;
        padding: 0;
        color: #333;
    }
    header {
        background-color: #b71c1c;
        color: white;
        padding: 1.5rem;
        text-align: center;
    }
    .form-container {
        max-width: 600px;
        background: white;
        padding: 2rem;
        margin: 2rem auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
        margin-top: 0;
        color: #003366;
        text-align: center;
    }
    label {
        display: block;
        margin-top: 1rem;
        font-weight: 500;
        color: #333;
    }
    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 0.8rem;
        margin-top: 0.5rem;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }
    button {
        margin-top: 2rem;
        background-color: #cc0000ff;
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background-color: #990000ff;
    }
    .admin-review {
        margin-top: 1.5rem;
        background: #ffe4e1;
        padding: 1rem;
        border-radius: 6px;
        color: #a94442;
    }
    .back-link {
        display: block;
        text-align: center;
        margin-top: 1.5rem;
        text-decoration: none;
        color: #0066cc;
    }
    footer {
        text-align: center;
        padding: 1rem;
        font-size: 0.9rem;
        color: #555;
        margin-top: 3rem;
    }
</style>
</head>
<body>

<header>
    <h1>Edit & Resubmit Blog</h1>
</header>

<div class="form-container">
    <h2><?= esc($blog['title']) ?></h2>

    <form action="<?= site_url('author/dashboard/updateRejected/' . $blog['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="text" name="title" value="<?= esc($blog['title']) ?>" required>

        <label for="content">Content</label>
        <textarea name="content" id="editor" rows="6"><?= esc($blog['content']) ?></textarea>

        <?php if (!empty($blog['image'])): ?>
            <label>Current Image</label>
            <img src="<?= base_url('uploads/' . $blog['image']) ?>" alt="Blog Image" style="max-width: 200px; display:block; margin-top:0.5rem;">
        <?php endif; ?>

        <label for="image">Change Image (optional)</label>
        <input type="file" name="image">

        <label for="category">Category</label>
        <input type="text" name="category" value="<?= esc($blog['category']) ?>" required>

        <?php if (!empty($blog['admin_review'])): ?>
            <div class="admin-review">
                <strong>Admin review:</strong> <?= esc($blog['admin_review']) ?>
            </div>
        <?php endif; ?>

        <button type="submit">Update & Resubmit</button>
    </form>

    <a class="back-link" href="<?= site_url('author/rejectedBlogs') ?>">← Back to Rejected Blogs</a>
</div>

<footer>© <?= date('Y') ?> NHPC Blog System</footer>

<!-- CKEditor script -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#editor'), {
            simpleUpload: {
                uploadUrl: '<?= site_url('blog/uploadImage') ?>'
            }
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    document.querySelector('form').addEventListener('submit', function() {
        document.querySelector('#editor').value = editorInstance.getData();
    });
</script>

</body>
</html>
