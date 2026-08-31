<?php
require_once 'includes/header.php';
$db = getDB();

$calls = $db->query("SELECT * FROM calls ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-indigo-900 text-white py-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold serif mb-6">Call for Papers</h1>
        <p class="text-indigo-200 max-w-2xl mx-auto text-lg">Join the discourse. We invite scholars, practitioners, and artists to contribute to the evolving canon of contemporary African art.</p>
    </div>
</div>

<div class="container mx-auto px-6 py-24">
    <div class="grid grid-cols-1 gap-12">
        <?php foreach($calls as $call): ?>
            <div class="border rounded-3xl p-10 md:p-16 flex flex-col md:flex-row justify-between items-start gap-12 hover:shadow-xl transition">
                <div class="flex-grow">
                    <div class="flex items-center space-x-4 mb-6">
                        <?php if($call['is_active']): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-widest">Active</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-widest">Closed</span>
                        <?php endif; ?>
                        <span class="text-gray-400 text-xs uppercase tracking-widest font-bold">Deadline: <?php echo htmlspecialchars($call['deadline']); ?></span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold serif mb-6"><?php echo htmlspecialchars($call['title']); ?></h2>
                    <p class="text-gray-600 text-lg mb-8 max-w-3xl line-clamp-3"><?php echo htmlspecialchars($call['description']); ?></p>
                    <a href="call_view.php?id=<?php echo $call['id']; ?>" class="bg-black text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition inline-block">View Full Call &rarr;</a>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(!$calls): ?>
            <div class="text-center py-20 border-2 border-dashed rounded-3xl">
                <p class="text-gray-400 italic">There are no open calls for papers at this time. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
