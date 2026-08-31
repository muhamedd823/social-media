<?php
require_once 'header.php';
$db = getDB();

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: articles.php");
    exit;
}

$articles = $db->query("SELECT a.*, c.name as cat_name FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY a.created_at DESC")->fetchAll();
?>

<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Manage Articles</h2>
    <a href="article_edit.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        <i class="fas fa-plus mr-2"></i> New Article
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-sm uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Title</th>
                <th class="px-6 py-4">Category</th>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 divide-y divide-gray-100">
            <?php foreach($articles as $art): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900"><?php echo htmlspecialchars($art['title']); ?></td>
                <td class="px-6 py-4"><span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold"><?php echo htmlspecialchars($art['cat_name']); ?></span></td>
                <td class="px-6 py-4 text-sm"><?php echo date('M d, Y', strtotime($art['created_at'])); ?></td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="article_edit.php?id=<?php echo $art['id']; ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                    <a href="?delete=<?php echo $art['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$articles): ?>
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-gray-500">No articles found. Start by creating one!</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
