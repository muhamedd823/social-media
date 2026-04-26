<?php
require_once 'includes/header.php';

$types = [
    'Artist' => 'Professional portfolios, exhibition opportunities, grant access, and peer mentorship.',
    'Curator' => 'Curatorial exchanges, review platforms, and critical discourse networks.',
    'Institutional' => 'Galleries, museums, universities, and cultural centers collaborating with YESEFERSEW.',
    'Diaspora' => 'Ethiopian artists and professionals across the global diaspora connected through YESEFERSEW.'
];

$active_type = $_GET['type'] ?? 'Artist';
if (!array_key_exists($active_type, $types)) {
    $active_type = 'Artist';
}
?>

<div class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold serif mb-6">Join the YESEFERSEW Network</h1>
                <p class="text-xl text-gray-600">Building a robust ecosystem for contemporary art and discourse.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <?php foreach($types as $type => $desc): ?>
                    <a href="?type=<?php echo $type; ?>" class="px-8 py-4 rounded-2xl font-bold transition <?php echo $active_type == $type ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-gray-500 hover:bg-gray-100'; ?>">
                        <?php echo $type; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 bg-white p-12 md:p-20 rounded-[3rem] shadow-xl border border-gray-100">
                <div>
                    <h2 class="text-3xl font-bold serif mb-6"><?php echo $active_type; ?> Network</h2>
                    <p class="text-lg text-gray-600 mb-8"><?php echo $types[$active_type]; ?></p>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-600 mr-3"></i> Exclusive networking events</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-600 mr-3"></i> Early access to open calls</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-600 mr-3"></i> Profile featured in our registry</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-600 mr-3"></i> Collaborative project opportunities</li>
                    </ul>
                </div>

                <div>
                    <form action="api/join.php" method="POST" class="space-y-6">
                        <input type="hidden" name="type" value="<?php echo $active_type; ?>">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Name / Institution Name</label>
                            <input type="text" name="name" class="w-full p-4 rounded-xl bg-gray-50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full p-4 rounded-xl bg-gray-50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Short Bio / Interest</label>
                            <textarea name="details" rows="4" class="w-full p-4 rounded-xl bg-gray-50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-500" placeholder="Tell us about your practice or institution..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white p-5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">Submit Application &rarr;</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
