<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Sample blog posts (replace with DB fetch later)
$blogs = [
    ["title" => "My First Blog", "category" => "Programming", "image" => "https://via.placeholder.com/150", "content" => "This is a short intro to my blog..."],
    ["title" => "Healthy Lifestyle", "category" => "Lifestyle", "image" => "https://via.placeholder.com/150", "content" => "Some lifestyle tips and tricks..."],
];
?>

<style>
  :root {
    --bg: #f5f7fa;
    --card: #ffffff;
    --primary: #007bff;
    --primary-dark: #0056b3;
    --danger: #dc3545;
    --danger-dark: #b02a37;
    --text: #333;
    --muted: #666;
    --radius: 12px;
    --shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: var(--bg);
    margin: 0;
    padding: 0;
    color: var(--text);
  }

  .dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--card);
    padding: 20px 30px;
    box-shadow: var(--shadow);
  }

  .dashboard-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: var(--primary-dark);
  }

  .logout-btn {
    background: var(--danger);
    color: #fff;
    padding: 10px 16px;
    border: none;
    border-radius: var(--radius);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
  }

  .logout-btn:hover {
    background: var(--danger-dark);
    transform: translateY(-2px);
  }

  .dashboard-content {
    max-width: 1100px;
    margin: 30px auto;
    padding: 20px;
  }

  .header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }

  .btn-create {
    background: var(--primary);
    color: #fff;
    padding: 10px 20px;
    border-radius: var(--radius);
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
  }

  .btn-create:hover {
    background: var(--primary-dark);
  }

  .blog-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
  }

  .blog-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .blog-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .blog-card .content {
    padding: 15px;
  }

  .blog-card h3 {
    margin: 0;
    color: var(--primary-dark);
    font-size: 18px;
  }

  .blog-card p {
    margin: 8px 0;
    color: var(--muted);
    font-size: 14px;
  }

  /* Modal styles */
  .modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    background: var(--card);
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    width: 90%;
    max-width: 600px;
    animation: slideDown 0.3s ease;
  }

  @keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 15px;
  }

  .btn-submit {
    background: var(--primary);
    color: #fff;
  }
  .btn-cancel {
    background: #e0e0e0;
    color: var(--text);
  }
</style>

<!-- Dashboard Header -->
<div class="dashboard-header">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?> </h2>
  <form action="../auth/logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</div>

<!-- Dashboard Content -->
<div class="dashboard-content">
  <div class="header-actions">
    <h1>Your Blogs</h1>
    <button class="btn-create" onclick="openModal()">+ Create New Post</button>
  </div>

  <!-- Blog List -->
  <div class="blog-list">
    <?php foreach ($blogs as $blog): ?>
      <div class="blog-card">
        <img src="<?= $blog['image'] ?>" alt="Blog Image">
        <div class="content">
          <h3><?= htmlspecialchars($blog['title']) ?></h3>
          <p><strong>Category:</strong> <?= htmlspecialchars($blog['category']) ?></p>
          <p><?= htmlspecialchars($blog['content']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Create Post Modal -->
<div class="modal" id="createModal">
  <div class="modal-content">
    <h2>Create New Post</h2>
    <form action="save_post.php" method="POST" enctype="multipart/form-data">
      <div>
        <label for="title">Post Title</label>
        <input type="text" id="title" name="title" required>
      </div>

      <div>
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="">-- Select Category --</option>
          <option value="Guides">Guides</option>
          <option value="Programming">Programming</option>
          <option value="Lifestyle">Lifestyle</option>
          <option value="Technology">Technology</option>
        </select>
      </div>

      <div>
        <label for="image">Featured Image</label>
        <input type="file" id="image" name="image" accept="image/*">
      </div>

      <div>
        <label for="content">Content</label>
        <textarea id="content" name="content" required></textarea>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-submit">Publish</button>
        <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  const modal = document.getElementById('createModal');
  function openModal() { modal.style.display = 'flex'; }
  function closeModal() { modal.style.display = 'none'; }
  window.onclick = function(e) {
    if (e.target === modal) closeModal();
  }
</script>

<?php include('../layouts/footer.php'); ?>
