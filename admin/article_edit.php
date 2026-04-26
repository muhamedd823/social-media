<?php
require_once 'header.php';
$db = getDB();

$id = $_GET['id'] ?? null;
$article = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    if ($id) {
        $stmt = $db->prepare("UPDATE articles SET title = ?, category_id = ?, excerpt = ?, content = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $category_id, $excerpt, $content, $image, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO articles (title, category_id, excerpt, content, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category_id, $excerpt, $content, $image]);
    }
    header("Location: articles.php");
    exit;
}

$categories = $db->query("SELECT * FROM categories")->fetchAll();
?>

<div class="mb-8">
    <a href="articles.php" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i> Back to Articles
    </a>
    <h2 class="text-3xl font-bold text-gray-800"><?php echo $id ? 'Edit Article' : 'New Article'; ?></h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($article['title'] ?? ''); ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                <select name="category_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($article['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Image URL</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($article['image'] ?? ''); ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://example.com/image.jpg">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Excerpt (Short Summary)</label>
            <textarea name="excerpt" rows="3" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($article['excerpt'] ?? ''); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Content</label>
            <textarea name="content" rows="10" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($article['content'] ?? ''); ?></textarea>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                <?php echo $id ? 'Update Article' : 'Publish Article'; ?>
            </button>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
