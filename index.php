<?php
require_once 'includes/header.php';
$db = getDB();

// Fetch latest items for the homepage
function getLatestArticles($db, $slug, $limit = 1) {
    $stmt = $db->prepare("SELECT a.* FROM articles a JOIN categories c ON a.category_id = c.id WHERE c.slug = ? ORDER BY a.created_at DESC LIMIT ?");
    $stmt->execute([$slug, $limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$essays = getLatestArticles($db, 'essays');
$interviews = getLatestArticles($db, 'interviews');
$curatorial = getLatestArticles($db, 'curatorial');
$reports = getLatestArticles($db, 'reports');
$milestones = getLatestArticles($db, 'milestones');
$latest_call = $db->query("SELECT * FROM calls WHERE is_active = 1 ORDER BY created_at DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<header class="py-24 bg-gray-50 border-b">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-6xl md:text-8xl font-bold mb-8 serif tracking-tighter">YESEFERSEW</h1>
        <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            A critical platform for contemporary art from Ethiopia and its diaspora, fostering scholarship, dialogue, and institutional exchange.
        </p>
    </div>
</header>

<!-- Primary Content Grid -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">

            <!-- Critical Essays -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold serif border-b pb-4">Critical Essays</h2>
                <?php if($essays): ?>
                    <?php foreach($essays as $art): ?>
                        <div class="group">
                            <h3 class="text-xl font-bold mb-3 group-hover:text-indigo-600 transition underline decoration-gray-200 underline-offset-8"><?php echo htmlspecialchars($art['title']); ?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($art['excerpt']); ?></p>
                            <a href="article_view.php?id=<?php echo $art['id']; ?>" class="text-sm font-bold uppercase tracking-widest text-indigo-600">Read Essays &rarr;</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400 italic">Scholarly articles on Ethiopian modernism and postcolonial aesthetics.</p>
                <?php endif; ?>
            </div>

            <!-- Artist Interviews -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold serif border-b pb-4">Artist Interviews</h2>
                <?php if($interviews): ?>
                    <?php foreach($interviews as $art): ?>
                        <div class="group">
                            <h3 class="text-xl font-bold mb-3 group-hover:text-indigo-600 transition underline decoration-gray-200 underline-offset-8"><?php echo htmlspecialchars($art['title']); ?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($art['excerpt']); ?></p>
                            <a href="article_view.php?id=<?php echo $art['id']; ?>" class="text-sm font-bold uppercase tracking-widest text-indigo-600">Explore Interviews &rarr;</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400 italic">In-depth conversations with established and emerging Ethiopian artists.</p>
                <?php endif; ?>
            </div>

            <!-- Newsletter -->
            <div class="bg-gray-100 p-8 rounded-2xl">
                <h2 class="text-2xl font-bold serif mb-4">Monthly Newsletter</h2>
                <p class="text-gray-600 mb-6 text-sm">Curated monthly digest featuring exhibition openings, residency opportunities, and grant deadlines.</p>
                <form action="api/subscribe.php" method="POST" class="space-y-4">
                    <input type="email" name="email" placeholder="Your email address" class="w-full p-4 rounded-xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-500" required>
                    <button type="submit" class="w-full bg-black text-white p-4 rounded-xl font-bold hover:bg-gray-800 transition">Subscribe Now &rarr;</button>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- Secondary Content -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20">
            <!-- Curatorial Notes -->
            <div>
                <h2 class="text-3xl font-bold serif mb-8">Curatorial Notes</h2>
                <?php if($curatorial): ?>
                    <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($curatorial[0]['title']); ?></h3>
                        <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($curatorial[0]['excerpt']); ?></p>
                        <a href="article_view.php?id=<?php echo $curatorial[0]['id']; ?>" class="inline-block border-b-2 border-black pb-1 font-bold text-sm uppercase tracking-widest">View Curatorial &rarr;</a>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">Exition reviews and curatorial methodologies from curators worldwide.</p>
                <?php endif; ?>
            </div>

            <!-- Call for Papers / Reports -->
            <div class="flex flex-col justify-between">
                <div>
                    <h2 class="text-3xl font-bold serif mb-8">Recent Reports</h2>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center border-b pb-4">
                            <span class="font-bold">1-54 Contemporary African Art Fair</span>
                            <a href="sections.php?slug=reports" class="text-indigo-600 font-semibold">Exhibition Report &rarr;</a>
                        </div>
                        <div class="flex justify-between items-center border-b pb-4">
                            <span class="font-bold">Residency Milestones</span>
                            <a href="sections.php?slug=milestones" class="text-indigo-600 font-semibold">View &rarr;</a>
                        </div>
                    </div>
                </div>

                <?php if($latest_call): ?>
                <div class="mt-12 p-8 bg-indigo-900 text-white rounded-2xl">
                    <span class="text-xs uppercase tracking-widest text-indigo-300 font-bold mb-2 block">Open Call</span>
                    <h3 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($latest_call['title']); ?></h3>
                    <p class="text-indigo-100 mb-6 text-sm line-clamp-2"><?php echo htmlspecialchars($latest_call['description']); ?></p>
                    <a href="call_view.php?id=<?php echo $latest_call['id']; ?>" class="bg-white text-indigo-900 px-6 py-3 rounded-xl font-bold inline-block hover:bg-indigo-50 transition text-sm">Submit Abstract &rarr;</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Networks -->
<section class="py-24">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold serif mb-16">Join the YESEFERSEW Network</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <a href="membership.php?type=Artist" class="p-8 border rounded-2xl hover:border-indigo-600 hover:shadow-lg transition">
                <i class="fas fa-palette text-3xl mb-6 text-indigo-600"></i>
                <h3 class="font-bold mb-2">Artist Membership</h3>
                <p class="text-xs text-gray-500">Professional portfolios and exhibition opportunities.</p>
            </a>
            <a href="membership.php?type=Curator" class="p-8 border rounded-2xl hover:border-indigo-600 hover:shadow-lg transition">
                <i class="fas fa-eye text-3xl mb-6 text-indigo-600"></i>
                <h3 class="font-bold mb-2">Curators & Critics</h3>
                <p class="text-xs text-gray-500">Curatorial exchanges and review platforms.</p>
            </a>
            <a href="membership.php?type=Institutional" class="p-8 border rounded-2xl hover:border-indigo-600 hover:shadow-lg transition">
                <i class="fas fa-university text-3xl mb-6 text-indigo-600"></i>
                <h3 class="font-bold mb-2">Institutional Partners</h3>
                <p class="text-xs text-gray-500">Galleries, museums, and universities collaborating.</p>
            </a>
            <a href="membership.php?type=Diaspora" class="p-8 border rounded-2xl hover:border-indigo-600 hover:shadow-lg transition">
                <i class="fas fa-globe-africa text-3xl mb-6 text-indigo-600"></i>
                <h3 class="font-bold mb-2">Diaspora Network</h3>
                <p class="text-xs text-gray-500">Ethiopian professionals across the global diaspora.</p>
            </a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
