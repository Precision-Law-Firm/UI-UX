<?php
require '../config.php';

// --- Fetch Expertise Hero ---
$stmt = $pdo->query("SELECT * FROM expertise_hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- Fetch Expertise Categories ---
$stmt = $pdo->query("SELECT * FROM expertise_categories WHERE is_active = 1 ORDER BY sort_order ASC");
$categories = $stmt->fetchAll();

// --- Fetch Practice Areas for each category ---
$practiceAreasByCategory = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT * FROM practice_areas_expertise WHERE category_id = ? AND is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute([$category['id']]);
    $practiceAreasByCategory[$category['id']] = $stmt->fetchAll();
}

// --- Fetch Specialized Areas ---
$stmt = $pdo->query("SELECT * FROM specialized_areas WHERE is_active = 1 ORDER BY sort_order ASC");
$specializedAreas = $stmt->fetchAll();

// --- Fetch Why Choose Features ---
$stmt = $pdo->query("SELECT * FROM why_choose_features WHERE is_active = 1 ORDER BY sort_order ASC");
$whyChooseFeatures = $stmt->fetchAll();

// --- Fetch CTA Section ---
$stmt = $pdo->query("SELECT * FROM expertise_cta WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$cta = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expertise - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .slow-transition {
            transition: all 0.3s ease;
        }

        .expertise-icon {
            transition: transform 0.3s ease;
        }

        .expertise-card:hover .expertise-icon {
            transform: scale(1.1);
        }

        /* Custom AOS animations */
        [data-aos="fade-up-slow"] {
            transform: translateY(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-up-slow"].aos-animate {
            transform: translateY(0);
            opacity: 1;
        }

        [data-aos="fade-right-slow"] {
            transform: translateX(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-right-slow"].aos-animate {
            transform: translateX(0);
            opacity: 1;
        }

        [data-aos="fade-left-slow"] {
            transform: translateX(-40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-left-slow"].aos-animate {
            transform: translateX(0);
            opacity: 1;
        }

        /* Larger base font size */
        html {
            font-size: 16px;
        }

        @media (min-width: 768px) {
            html {
                font-size: 18px;
            }
        }
    </style>
</head>

<body class="bg-white">

    <!-- Navbar  -->
    <?php include "../includes/navbar.php"; ?>

    <!-- Hero Section - Larger text -->
    <div class="relative overflow-hidden py-24 md:py-32 min-h-[450px] md:min-h-[500px] flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0">
                <img src="<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>"
                    alt="Precision Law Firm Expertise"
                    class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0F2854]/70 to-[#1C4D8D]/50"></div>
            </div>
        </div>

        <div class="container mx-auto px-6 md:px-12 lg:px-24 z-10 relative">
            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-blue-100 mb-8" data-aos="fade-up-slow" data-aos-duration="1400">
                    <?= htmlspecialchars($hero['title'] ?? 'OUR EXPERTISE') ?>
                </h1>
                <div class="text-white text-xl md:text-2xl leading-relaxed space-y-4" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <p class="opacity-95">
                        <?= htmlspecialchars($hero['subtitle'] ?? 'Comprehensive legal services across diverse practice areas, combining deep Mauritian legal knowledge with strategic commercial insight.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Expertise Sections -->
    <div class="py-16 md:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <?php foreach ($categories as $categoryIndex => $category): ?>
                <!-- <?= htmlspecialchars($category['title']) ?> Section -->
                <div class="max-w-6xl mx-auto <?= $categoryIndex < count($categories) - 1 ? 'mb-16 md:mb-20' : '' ?>" data-aos="fade-up-slow" data-aos-duration="1400">

                    <!-- Category Header - Responsive -->
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8 mb-10 md:mb-12">
                        <div class="md:w-1/3">
                            <div class="w-12 md:w-16 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mb-3 md:mb-4"></div>
                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854]"><?= htmlspecialchars($category['title']) ?></h2>
                        </div>
                        <div class="md:w-2/3">
                            <p class="text-gray-700 text-base sm:text-lg md:text-xl leading-relaxed text-justify">
                                <?= htmlspecialchars($category['description']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Practice Areas Grid - Responsive -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        <?php if (!empty($practiceAreasByCategory[$category['id']])): ?>
                            <?php foreach ($practiceAreasByCategory[$category['id']] as $index => $area): ?>
                                <div class="expertise-card bg-white border border-gray-200 rounded-xl p-6 sm:p-8 hover-lift"
                                    data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">

                                    <!-- Icon -->
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-4 sm:mb-6 expertise-icon">
                                        <i class="fas <?= htmlspecialchars($area['icon']) ?> text-xl sm:text-2xl text-[#1C4D8D]"></i>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($area['title']) ?></h3>

                                    <!-- Features List -->
                                    <ul class="space-y-2 text-gray-600">
                                        <?php
                                        $features = explode(',', $area['features']);
                                        foreach ($features as $feature):
                                        ?>
                                            <li class="flex items-start">
                                                <i class="fas fa-check text-[#1C4D8D] text-xs sm:text-sm mt-1 mr-2 flex-shrink-0"></i>
                                                <span class="text-sm sm:text-base text-justify"><?= htmlspecialchars(trim($feature)) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback practice areas -->
                            <div class="expertise-card bg-white border border-gray-200 rounded-xl p-6 sm:p-8 hover-lift" data-aos="fade-up-slow" data-aos-duration="1400">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-4 sm:mb-6 expertise-icon">
                                    <i class="fas fa-gavel text-xl sm:text-2xl text-[#1C4D8D]"></i>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3">Civil & Commercial Litigation</h3>
                                <ul class="space-y-2 text-gray-600">
                                    <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-xs sm:text-sm mt-1 mr-2 flex-shrink-0"></i><span class="text-sm sm:text-base text-justify">Contract disputes and breach of contract matters</span></li>
                                    <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-xs sm:text-sm mt-1 mr-2 flex-shrink-0"></i><span class="text-sm sm:text-base text-justify">Tort claims and negligence cases</span></li>
                                    <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-xs sm:text-sm mt-1 mr-2 flex-shrink-0"></i><span class="text-sm sm:text-base text-justify">Debt recovery and enforcement proceedings</span></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Specialized Practice Areas -->
            <?php if (!empty($specializedAreas)): ?>
                <div class="max-w-6xl mx-auto mt-16 md:mt-20" data-aos="fade-up-slow" data-aos-duration="1400">

                    <!-- Section Header -->
                    <div class="text-center mb-12 md:mb-16">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-3 md:mb-4">Specialized Practice Areas</h2>
                        <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-4 md:mb-6"></div>
                        <p class="text-gray-600 text-base sm:text-lg md:text-xl max-w-2xl mx-auto px-4 text-justify">
                            Focused expertise in key legal domains requiring specialized knowledge
                        </p>
                    </div>

                    <!-- Specialized Areas Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">
                        <?php foreach ($specializedAreas as $index => $area): ?>
                            <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-8 text-center hover-lift"
                                data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">

                                <!-- Icon -->
                                <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-50 rounded-lg flex items-center justify-center mx-auto mb-3 md:mb-4">
                                    <i class="fas <?= htmlspecialchars($area['icon']) ?> text-xl md:text-2xl text-[#1C4D8D]"></i>
                                </div>

                                <!-- Title -->
                                <h4 class="font-bold text-gray-800 text-lg md:text-xl mb-2 md:mb-3"><?= htmlspecialchars($area['title']) ?></h4>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm md:text-base text-justify"><?= htmlspecialchars($area['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Why Choose Our Expertise -->
    <?php if (!empty($whyChooseFeatures)): ?>
        <div class="bg-gradient-to-b from-white to-gray-50 py-16 md:py-20 lg:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">

                    <!-- Section Header -->
                    <div class="text-center mb-12 md:mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-3 md:mb-4">Why Choose Our Legal Expertise</h2>
                        <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-4 md:mb-6"></div>
                    </div>

                    <!-- Features Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        <?php foreach ($whyChooseFeatures as $index => $feature): ?>
                            <div class="text-center px-4" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">

                                <!-- Icon -->
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                                    <i class="fas <?= htmlspecialchars($feature['icon']) ?> text-2xl md:text-3xl text-[#1C4D8D]"></i>
                                </div>

                                <!-- Title -->
                                <h4 class="font-bold text-gray-800 text-lg md:text-xl mb-2 md:mb-3"><?= htmlspecialchars($feature['title']) ?></h4>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm md:text-base text-justify"><?= htmlspecialchars($feature['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- CTA Section -->
    <div class="py-16 md:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">

                <?php if (!empty($cta)): ?>
                    <!-- Title -->
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        <?= htmlspecialchars($cta['title']) ?>
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-600 text-base sm:text-lg md:text-xl mb-8 md:mb-10 max-w-2xl mx-auto px-4 text-justify" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        <?= htmlspecialchars($cta['description']) ?>
                    </p>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center px-4">
                        <a href="<?= htmlspecialchars($cta['primary_button_link']) ?>"
                            class="inline-flex items-center justify-center bg-[#1C4D8D] text-white px-6 md:px-10 py-3 md:py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-sm md:text-lg"
                            data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            <span class="mr-2 md:mr-3 font-medium"><?= htmlspecialchars($cta['primary_button_text']) ?></span>
                            <i class="fas fa-arrow-right text-sm md:text-lg"></i>
                        </a>

                        <?php if (!empty($cta['secondary_button_text'])): ?>
                            <a href="<?= htmlspecialchars($cta['secondary_button_link']) ?>"
                                class="inline-flex items-center justify-center bg-white text-[#1C4D8D] border border-[#1C4D8D] px-6 md:px-10 py-3 md:py-4 rounded-lg hover:bg-blue-50 transition-all duration-300 hover-lift text-sm md:text-lg"
                                data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                                <span class="mr-2 md:mr-3 font-medium"><?= htmlspecialchars($cta['secondary_button_text']) ?></span>
                                <i class="fas fa-users text-sm md:text-lg"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <!-- Fallback CTA -->
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        Need Specialized Legal Assistance?
                    </h2>
                    <p class="text-gray-600 text-base sm:text-lg md:text-xl mb-8 md:mb-10 max-w-2xl mx-auto px-4 text-justify" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        Contact us to discuss how our expertise can help with your specific legal requirements.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center px-4">
                        <a href="contact.php"
                            class="inline-flex items-center justify-center bg-[#1C4D8D] text-white px-6 md:px-10 py-3 md:py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-sm md:text-lg"
                            data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            <span class="mr-2 md:mr-3 font-medium">Contact Our Team</span>
                            <i class="fas fa-arrow-right text-sm md:text-lg"></i>
                        </a>
                        <a href="team.php"
                            class="inline-flex items-center justify-center bg-white text-[#1C4D8D] border border-[#1C4D8D] px-6 md:px-10 py-3 md:py-4 rounded-lg hover:bg-blue-50 transition-all duration-300 hover-lift text-sm md:text-lg"
                            data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                            <span class="mr-2 md:mr-3 font-medium">Meet Our Experts</span>
                            <i class="fas fa-users text-sm md:text-lg"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "../includes/footer.php"; ?>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="../js/script.js">
    </script>
</body>

</html>