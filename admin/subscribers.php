<?php
require_once 'header.php';
$db = getDB();

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM subscribers WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: subscribers.php");
    exit;
}

$subscribers = $db->query("SELECT * FROM subscribers ORDER BY created_at DESC")->fetchAll();
?>

<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Newsletter Subscribers</h2>
    <p class="text-gray-600">People who signed up for the monthly digest.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-sm uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Subscription Date</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 divide-y divide-gray-100">
            <?php foreach($subscribers as $s): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900"><?php echo htmlspecialchars($s['email']); ?></td>
                <td class="px-6 py-4 text-sm"><?php echo date('M d, Y', strtotime($s['created_at'])); ?></td>
                <td class="px-6 py-4 text-right">
                    <a href="?delete=<?php echo $s['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$subscribers): ?>
            <tr>
                <td colspan="3" class="px-6 py-10 text-center text-gray-500">No subscribers yet.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
