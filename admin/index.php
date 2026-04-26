<?php
require_once 'header.php';
$db = getDB();

$stats = [
    'articles' => $db->query("SELECT COUNT(*) FROM articles")->fetchColumn(),
    'calls' => $db->query("SELECT COUNT(*) FROM calls")->fetchColumn(),
    'memberships' => $db->query("SELECT COUNT(*) FROM memberships")->fetchColumn(),
    'subscribers' => $db->query("SELECT COUNT(*) FROM subscribers")->fetchColumn(),
];
?>

<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p class="text-gray-600">Here's what's happening with YESEFERSEW Journal today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-blue-100 text-blue-600 rounded-full mr-4">
            <i class="fas fa-newspaper text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold">Total Articles</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo $stats['articles']; ?></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-purple-100 text-purple-600 rounded-full mr-4">
            <i class="fas fa-file-contract text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold">Open Calls</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo $stats['calls']; ?></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-green-100 text-green-600 rounded-full mr-4">
            <i class="fas fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold">Members</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo $stats['memberships']; ?></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-orange-100 text-orange-600 rounded-full mr-4">
            <i class="fas fa-envelope text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 uppercase font-semibold">Subscribers</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo $stats['subscribers']; ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Articles</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-sm border-b">
                    <th class="pb-3 font-semibold uppercase">Title</th>
                    <th class="pb-3 font-semibold uppercase">Category</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                <?php
                $recent_articles = $db->query("SELECT a.title, c.name as cat_name FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY a.created_at DESC LIMIT 5")->fetchAll();
                foreach($recent_articles as $art):
                ?>
                <tr class="border-b last:border-0">
                    <td class="py-3"><?php echo htmlspecialchars($art['title']); ?></td>
                    <td class="py-3"><span class="px-2 py-1 bg-gray-100 rounded text-xs"><?php echo htmlspecialchars($art['cat_name']); ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php if(!$recent_articles): ?>
                    <tr><td colspan="2" class="py-4 text-center">No articles found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Latest Subscribers</h3>
        <ul class="space-y-4">
            <?php
            $recent_subs = $db->query("SELECT email, created_at FROM subscribers ORDER BY created_at DESC LIMIT 5")->fetchAll();
            foreach($recent_subs as $sub):
            ?>
            <li class="flex justify-between items-center text-sm">
                <span class="text-gray-700"><?php echo htmlspecialchars($sub['email']); ?></span>
                <span class="text-gray-400 text-xs"><?php echo date('M d, Y', strtotime($sub['created_at'])); ?></span>
            </li>
            <?php endforeach; ?>
            <?php if(!$recent_subs): ?>
                <li class="text-center py-4 text-gray-500 text-sm">No subscribers yet.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php require_once 'footer.php'; ?>
