<?php
require_once 'includes/header.php';
$db = getDB();

$slug = $_GET['slug'] ?? '';
$stmt = $db->prepare("SELECT * FROM categories WHERE slug = ?");
$stmt->execute([$slug]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo "<div class='container mx-auto px-6 py-20 text-center'><h1 class='serif text-4xl'>Category not found.</h1><a href='index.php' class='text-indigo-600 mt-4 inline-block'>Back home</a></div>";
    require_once 'includes/footer.php';
    exit;
}

$stmt = $db->prepare("SELECT * FROM articles WHERE category_id = ? ORDER BY created_at DESC");
$stmt->execute([$category['id']]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-gray-50 py-20 border-b">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold serif mb-4"><?php echo htmlspecialchars($category['name']); ?></h1>
        <p class="text-gray-500 max-w-2xl mx-auto">Exploring the depth of contemporary artistic practice and critical discourse.</p>
    </div>
</div>

<div class="container mx-auto px-6 py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        <?php foreach($articles as $art): ?>
            <article class="group">
                <?php if($art['image']): ?>
                    <div class="aspect-video overflow-hidden rounded-2xl mb-6 bg-gray-100">
                        <img src="<?php echo htmlspecialchars($art['image']); ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                <?php endif; ?>
                <span class="text-xs uppercase tracking-widest text-indigo-600 font-bold mb-2 block"><?php echo date('M d, Y', strtotime($art['created_at'])); ?></span>
                <h2 class="text-2xl font-bold serif mb-3 group-hover:text-indigo-600 transition leading-tight">
                    <a href="article_view.php?id=<?php echo $art['id']; ?>"><?php echo htmlspecialchars($art['title']); ?></a>
                </h2>
                <p class="text-gray-600 line-clamp-3 mb-6"><?php echo htmlspecialchars($art['excerpt']); ?></p>
                <a href="article_view.php?id=<?php echo $art['id']; ?>" class="text-sm font-bold border-b border-black pb-1">Read Full Article</a>
            </article>
        <?php endforeach; ?>

        <?php if(!$articles): ?>
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 italic">No articles published in this section yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
