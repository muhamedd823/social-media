<?php
require_once 'header.php';
$db = getDB();

$id = $_GET['id'] ?? null;
$call = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM calls WHERE id = ?");
    $stmt->execute([$id]);
    $call = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $publication_date = $_POST['publication_date'];
    $topics = $_POST['topics'];
    $guidelines = $_POST['guidelines'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($id) {
        $stmt = $db->prepare("UPDATE calls SET title = ?, description = ?, deadline = ?, publication_date = ?, topics = ?, guidelines = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$title, $description, $deadline, $publication_date, $topics, $guidelines, $is_active, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO calls (title, description, deadline, publication_date, topics, guidelines, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $deadline, $publication_date, $topics, $guidelines, $is_active]);
    }
    header("Location: calls.php");
    exit;
}
?>

<div class="mb-8">
    <a href="calls.php" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i> Back to Calls
    </a>
    <h2 class="text-3xl font-bold text-gray-800"><?php echo $id ? 'Edit Call for Papers' : 'New Call for Papers'; ?></h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($call['title'] ?? ''); ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
            </div>
            <div class="flex items-center pt-8">
                <input type="checkbox" name="is_active" id="is_active" class="w-5 h-5 text-indigo-600" <?php echo ($call['is_active'] ?? 1) ? 'checked' : ''; ?>>
                <label for="is_active" class="ml-2 text-sm font-bold text-gray-700">Active (Accepting Submissions)</label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deadline</label>
                <input type="text" name="deadline" value="<?php echo htmlspecialchars($call['deadline'] ?? ''); ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. October 15, 2024">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Expected Publication Date</label>
                <input type="text" name="publication_date" value="<?php echo htmlspecialchars($call['publication_date'] ?? ''); ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. January 2025">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Introduction / Description</label>
            <textarea name="description" rows="4" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($call['description'] ?? ''); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Suggested Topics (One per line)</label>
            <textarea name="topics" rows="6" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($call['topics'] ?? ''); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Submission Guidelines</label>
            <textarea name="guidelines" rows="6" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($call['guidelines'] ?? ''); ?></textarea>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                <?php echo $id ? 'Update Call' : 'Save Call'; ?>
            </button>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
