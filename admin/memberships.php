<?php
require_once 'header.php';
$db = getDB();

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM memberships WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: memberships.php");
    exit;
}

$type_filter = $_GET['type'] ?? '';
$query = "SELECT * FROM memberships";
$params = [];
if ($type_filter) {
    $query .= " WHERE type = ?";
    $params = [$type_filter];
}
$query .= " ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$members = $stmt->fetchAll();
?>

<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Memberships & Networks</h2>
    <p class="text-gray-600">Review applications from various networks.</p>
</div>

<div class="mb-6 flex space-x-2">
    <a href="memberships.php" class="px-4 py-2 rounded-lg <?php echo !$type_filter ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border'; ?>">All</a>
    <a href="?type=Artist" class="px-4 py-2 rounded-lg <?php echo $type_filter == 'Artist' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border'; ?>">Artists</a>
    <a href="?type=Curator" class="px-4 py-2 rounded-lg <?php echo $type_filter == 'Curator' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border'; ?>">Curators</a>
    <a href="?type=Institutional" class="px-4 py-2 rounded-lg <?php echo $type_filter == 'Institutional' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border'; ?>">Institutional</a>
    <a href="?type=Diaspora" class="px-4 py-2 rounded-lg <?php echo $type_filter == 'Diaspora' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border'; ?>">Diaspora</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-sm uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Type</th>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 divide-y divide-gray-100">
            <?php foreach($members as $m): ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900"><?php echo htmlspecialchars($m['name']); ?></td>
                <td class="px-6 py-4"><?php echo htmlspecialchars($m['email']); ?></td>
                <td class="px-6 py-4"><span class="px-3 py-1 bg-gray-100 rounded-full text-xs"><?php echo htmlspecialchars($m['type']); ?></span></td>
                <td class="px-6 py-4 text-sm"><?php echo date('M d, Y', strtotime($m['created_at'])); ?></td>
                <td class="px-6 py-4 text-right">
                    <a href="?delete=<?php echo $m['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <tr class="bg-gray-50/30">
                <td colspan="5" class="px-6 py-2 text-xs text-gray-500">
                    <strong>Details:</strong> <?php echo htmlspecialchars($m['details']); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(!$members): ?>
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">No membership requests found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
