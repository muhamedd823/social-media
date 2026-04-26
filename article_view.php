<?php
require_once 'includes/header.php';
$db = getDB();

$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT a.*, c.name as cat_name, c.slug FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    echo "<div class='container mx-auto px-6 py-20 text-center'><h1 class='serif text-4xl'>Article not found.</h1><a href='index.php' class='text-indigo-600 mt-4 inline-block'>Back home</a></div>";
    require_once 'includes/footer.php';
    exit;
}
?>

<article class="py-20">
    <div class="container mx-auto px-6 max-w-4xl">
        <header class="text-center mb-16">
            <a href="sections.php?slug=<?php echo $article['slug']; ?>" class="text-xs uppercase tracking-widest text-indigo-600 font-bold mb-4 inline-block"><?php echo htmlspecialchars($article['cat_name']); ?></a>
            <h1 class="text-4xl md:text-6xl font-bold serif leading-tight mb-8"><?php echo htmlspecialchars($article['title']); ?></h1>
            <div class="flex justify-center items-center space-x-4 text-sm text-gray-500">
                <span class="font-bold text-black">YESEFERSEW Journal</span>
                <span>&bull;</span>
                <span><?php echo date('F d, Y', strtotime($article['created_at'])); ?></span>
            </div>
        </header>

        <?php if($article['image']): ?>
            <div class="mb-16 rounded-3xl overflow-hidden shadow-2xl">
                <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="" class="w-full">
            </div>
        <?php endif; ?>

        <div class="prose prose-lg mx-auto serif leading-relaxed text-gray-800 space-y-6">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>

        <div class="mt-20 border-t pt-12">
            <h3 class="text-xl font-bold serif mb-8">Share this article</h3>
            <div class="flex space-x-4">
                <a href="#" class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full hover:bg-indigo-600 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full hover:bg-indigo-600 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full hover:bg-indigo-600 hover:text-white transition"><i class="fas fa-link"></i></a>
            </div>
        </div>
    </div>
</article>

<?php require_once 'includes/footer.php'; ?>
