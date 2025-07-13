<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Blog - NHPC Blog System</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6fb;
            padding: 2rem;
            margin: 0;
        }
        .form-container {
            max-width: 600px;
            background: white;
            padding: 2rem;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #003366;
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
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #004b99;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            text-decoration: none;
            color: #0066cc;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create New Blog</h2>

    <form action="<?= site_url('blog/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="text" name="title" required>

        <label for="content">Content</label>
        <textarea name="content" rows="6" required></textarea>

        <label for="image">Image</label>
        <input type="file" name="image">

        <?php if (!empty($categories)): ?>
            <label for="category">Select Category</label>
            <select name="category" required>
                <option value="">-- Choose Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['category_name']) ?>"><?= esc($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <label for="category">Enter Category</label>
            <input type="text" name="category" required>
        <?php endif; ?>

        <button type="submit">Submit Blog</button>
    </form>

    <a class="back-link" href="<?= site_url('/') ?>">← Back to Home</a>
</div>

</body>
</html>
