<?php
require_once 'includes/header.php';
$db = getDB();

$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM calls WHERE id = ?");
$stmt->execute([$id]);
$call = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$call) {
    echo "<div class='container mx-auto px-6 py-20 text-center'><h1 class='serif text-4xl'>Call not found.</h1><a href='calls.php' class='text-indigo-600 mt-4 inline-block'>Back to Calls</a></div>";
    require_once 'includes/footer.php';
    exit;
}
?>

<div class="py-20">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="flex flex-col md:flex-row justify-between items-start gap-12 mb-16 pb-16 border-b">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold serif mb-6 leading-tight"><?php echo htmlspecialchars($call['title']); ?></h1>
                <p class="text-xl text-gray-600"><?php echo nl2br(htmlspecialchars($call['description'])); ?></p>
            </div>
            <div class="bg-gray-50 p-8 rounded-3xl w-full md:w-80 flex-shrink-0">
                <h3 class="font-bold text-sm uppercase tracking-widest text-gray-400 mb-6">Details</h3>
                <div class="space-y-6">
                    <div>
                        <span class="block text-xs uppercase tracking-widest font-bold text-indigo-600 mb-1">Deadline</span>
                        <span class="font-bold"><?php echo htmlspecialchars($call['deadline']); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs uppercase tracking-widest font-bold text-indigo-600 mb-1">Publication Date</span>
                        <span class="font-bold"><?php echo htmlspecialchars($call['publication_date']); ?></span>
                    </div>
                    <a href="#submit" class="block bg-indigo-600 text-white text-center py-4 rounded-xl font-bold hover:bg-indigo-700 transition">Submit Abstract</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
            <div class="md:col-span-2 space-y-16">
                <section>
                    <h2 class="text-2xl font-bold serif mb-8 border-b pb-4">Suggested Topics</h2>
                    <ul class="space-y-4 list-disc list-inside text-gray-700 leading-relaxed">
                        <?php
                        $topics = explode("\n", $call['topics']);
                        foreach($topics as $topic): if(trim($topic)):
                        ?>
                            <li><?php echo htmlspecialchars($topic); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </section>

                <section id="guidelines">
                    <h2 class="text-2xl font-bold serif mb-8 border-b pb-4">Submission Guidelines</h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <?php echo nl2br(htmlspecialchars($call['guidelines'])); ?>
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <div class="p-8 border rounded-3xl">
                    <h3 class="font-bold serif text-xl mb-4">Peer Review</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Double-blind peer review process ensures the highest academic standards and impartiality.</p>
                </div>
                <div class="p-8 border rounded-3xl">
                    <h3 class="font-bold serif text-xl mb-4">No APC</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">YESEFERSEW is a diamond open access journal. No article processing charges for authors.</p>
                </div>
                <div class="p-8 bg-indigo-50 rounded-3xl">
                    <h3 class="font-bold serif text-xl mb-4">Support</h3>
                    <p class="text-sm text-gray-600 leading-relaxed font-semibold">Mentorship available for early-career researchers from Ethiopian institutions.</p>
                </div>
            </div>
        </div>

        <section id="submit" class="mt-24 bg-gray-900 text-white p-12 md:p-20 rounded-[3rem] text-center">
            <h2 class="text-3xl md:text-4xl font-bold serif mb-8">Ready to Submit?</h2>
            <p class="text-gray-400 mb-12 max-w-2xl mx-auto">Please prepare your abstract (300-500 words) according to the guidelines and email it to submissions@yesefersew.com</p>
            <a href="mailto:submissions@yesefersew.com" class="inline-block bg-white text-black px-12 py-5 rounded-2xl font-bold hover:bg-gray-200 transition">Email Submission &rarr;</a>
        </section>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
