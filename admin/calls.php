<?php
require_once 'header.php';
$db = getDB();

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM calls WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: calls.php");
    exit;
}

$calls = $db->query("SELECT * FROM calls ORDER BY created_at DESC")->fetchAll();
?>

<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Call for Papers</h2>
    <a href="call_edit.php" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        <i class="fas fa-plus mr-2"></i> New Call
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-sm uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Title</th>
                <th class="px-6 py-4">Deadline</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 divide-y divide-gray-100">
            <?php foreach($calls as $call): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900"><?php echo htmlspecialchars($call['title']); ?></td>
                <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($call['deadline']); ?></td>
                <td class="px-6 py-4">
                    <?php if($call['is_active']): ?>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Active</span>
                    <?php else: ?>
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Closed</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="call_edit.php?id=<?php echo $call['id']; ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                    <a href="?delete=<?php echo $call['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$calls): ?>
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-gray-500">No calls found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
