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

    <!-- Navbar - Increased text size -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4" data-aos="fade-down-slow"
        data-aos-duration="1200" data-aos-easing="ease-out-cubic">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 w-full justify-between">

                    <!-- Logo -->
                    <div class="text-[#D4AF37] font-bold text-2xl tracking-tight">
                        Precision Law Firm
                    </div>

                    <!-- Navigation - from text-sm to text-base -->
                    <div class="flex items-center space-x-8">
                        <a href="../accueil.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Home
                        </a>

                        <a href="overview.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Overview
                        </a>

                        <a href="team.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Our Team
                        </a>

                        <a href="expertise.php"
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
                            Expertise
                        </a>

                        <a href="jurisprudence.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Jurisprudence
                        </a>

                        <a href="courses.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Courses
                        </a>

                        <a href="appointment.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Appointment
                        </a>
                    </div>

                    <!-- Contact Button -->
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-6 py-3 rounded-full font-medium
                     hover:opacity-90 transition duration-300 hover-lift text-base tracking-wide shadow-sm hover:shadow-md">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden flex items-center justify-between w-full">
                    <div class="text-[#D4AF37] font-bold text-xl">
                        Precision Law Firm
                    </div>

                    <button id="mobile-menu-button" class="text-gray-700 text-2xl transition duration-300">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu - from text-sm to text-base -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-3">
                <div class="flex flex-col space-y-4">
                    <a href="../accueil.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Home
                    </a>
                    <a href="overview.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Overview
                    </a>
                    <a href="team.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Our Team
                    </a>
                    <a href="expertise.php"
                        class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">
                        Expertise
                    </a>
                    <a href="jurisprudence.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Jurisprudence
                    </a>
                    <a href="courses.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Courses
                    </a>
                    <a href="appointment.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Appointment
                    </a>
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-4 py-3 rounded-md font-medium text-center mt-2 transition duration-300 text-base">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

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
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8" data-aos="fade-up-slow" data-aos-duration="1400">
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
    <div class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            
            <?php foreach ($categories as $categoryIndex => $category): ?>
            <!-- <?= htmlspecialchars($category['title']) ?> Section -->
            <div class="max-w-6xl mx-auto <?= $categoryIndex < count($categories) - 1 ? 'mb-20' : '' ?>" data-aos="fade-up-slow" data-aos-duration="1400">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-8 mb-12">
                    <div class="md:w-1/3">
                        <div class="w-16 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mb-4"></div>
                        <h2 class="text-4xl md:text-5xl font-bold text-[#0F2854]"><?= htmlspecialchars($category['title']) ?></h2>
                    </div>
                    <div class="md:w-2/3">
                        <p class="text-gray-700 text-xl leading-relaxed">
                            <?= htmlspecialchars($category['description']) ?>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <?php if (!empty($practiceAreasByCategory[$category['id']])): ?>
                        <?php foreach ($practiceAreasByCategory[$category['id']] as $index => $area): ?>
                        <div class="expertise-card bg-white border border-gray-200 rounded-xl p-8 hover-lift"
                            data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                            <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-6 expertise-icon">
                                <i class="fas <?= htmlspecialchars($area['icon']) ?> text-2xl text-[#1C4D8D]"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($area['title']) ?></h3>
                            <ul class="space-y-2 text-gray-600">
                                <?php 
                                $features = explode(',', $area['features']);
                                foreach ($features as $feature): 
                                ?>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-[#1C4D8D] text-sm mt-1 mr-2"></i>
                                    <span class="text-base"><?= htmlspecialchars(trim($feature)) ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback practice areas -->
                        <div class="expertise-card bg-white border border-gray-200 rounded-xl p-8 hover-lift" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-6 expertise-icon">
                                <i class="fas fa-gavel text-2xl text-[#1C4D8D]"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Civil & Commercial Litigation</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-sm mt-1 mr-2"></i><span class="text-base">Contract disputes and breach of contract matters</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-sm mt-1 mr-2"></i><span class="text-base">Tort claims and negligence cases</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-[#1C4D8D] text-sm mt-1 mr-2"></i><span class="text-base">Debt recovery and enforcement proceedings</span></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Specialized Practice Areas -->
            <?php if (!empty($specializedAreas)): ?>
            <div class="max-w-6xl mx-auto mt-20" data-aos="fade-up-slow" data-aos-duration="1400">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F2854] mb-4">Specialized Practice Areas</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-gray-600 text-xl max-w-2xl mx-auto">Focused expertise in key legal domains requiring specialized knowledge</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($specializedAreas as $index => $area): ?>
                    <div class="bg-white border border-gray-200 rounded-xl p-8 text-center hover-lift"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                        <div class="w-16 h-16 bg-blue-50 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas <?= htmlspecialchars($area['icon']) ?> text-2xl text-[#1C4D8D]"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xl mb-3"><?= htmlspecialchars($area['title']) ?></h4>
                        <p class="text-gray-600 text-base"><?= htmlspecialchars($area['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Why Choose Our Expertise -->
    <?php if (!empty($whyChooseFeatures)): ?>
    <div class="bg-gradient-to-b from-white to-gray-50 py-24">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F2854] mb-4">Why Choose Our Legal Expertise</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($whyChooseFeatures as $index => $feature): ?>
                    <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas <?= htmlspecialchars($feature['icon']) ?> text-3xl text-[#1C4D8D]"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xl mb-3"><?= htmlspecialchars($feature['title']) ?></h4>
                        <p class="text-gray-600 text-base"><?= htmlspecialchars($feature['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- CTA Section - Larger text -->
    <div class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto text-center">
                <?php if (!empty($cta)): ?>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    <?= htmlspecialchars($cta['title']) ?>
                </h2>
                <p class="text-gray-600 text-xl mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    <?= htmlspecialchars($cta['description']) ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= htmlspecialchars($cta['primary_button_link']) ?>"
                        class="inline-flex items-center bg-[#1C4D8D] text-white px-10 py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-lg"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <span class="mr-3 font-medium"><?= htmlspecialchars($cta['primary_button_text']) ?></span>
                        <i class="fas fa-arrow-right text-lg"></i>
                    </a>
                    <?php if (!empty($cta['secondary_button_text'])): ?>
                    <a href="<?= htmlspecialchars($cta['secondary_button_link']) ?>"
                        class="inline-flex items-center bg-white text-[#1C4D8D] border border-[#1C4D8D] px-10 py-4 rounded-lg hover:bg-blue-50 transition-all duration-300 hover-lift text-lg"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                        <span class="mr-3 font-medium"><?= htmlspecialchars($cta['secondary_button_text']) ?></span>
                        <i class="fas fa-users text-lg"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <!-- Fallback CTA -->
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    Need Specialized Legal Assistance?
                </h2>
                <p class="text-gray-600 text-xl mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    Contact us to discuss how our expertise can help with your specific legal requirements.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="contact.php"
                        class="inline-flex items-center bg-[#1C4D8D] text-white px-10 py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-lg"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <span class="mr-3 font-medium">Contact Our Team</span>
                        <i class="fas fa-arrow-right text-lg"></i>
                    </a>
                    <a href="team.php"
                        class="inline-flex items-center bg-white text-[#1C4D8D] border border-[#1C4D8D] px-10 py-4 rounded-lg hover:bg-blue-50 transition-all duration-300 hover-lift text-lg"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                        <span class="mr-3 font-medium">Meet Our Experts</span>
                        <i class="fas fa-users text-lg"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer - Larger text -->
    <footer class="bg-[#0F2854] text-white py-16">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid md:grid-cols-4 gap-10">
                <!-- Logo and description -->
                <div class="md:col-span-2">
                    <div class="text-3xl font-bold mb-4">
                        <span class="text-white">Precision</span>
                        <span class="text-blue-300">Law Firm</span>
                    </div>
                    <p class="text-gray-300 text-base mb-6 max-w-md">
                        Comprehensive legal expertise combined with strategic commercial insight for Mauritian and international clients.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fas fa-phone text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="../accueil.php" class="text-gray-300 hover:text-white transition text-base">Home</a></li>
                        <li><a href="overview.php" class="text-gray-300 hover:text-white transition text-base">Overview</a></li>
                        <li><a href="team.php" class="text-gray-300 hover:text-white transition text-base">Our Team</a></li>
                        <li><a href="expertise.php" class="text-gray-300 hover:text-white transition text-base">Expertise</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start text-base">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-300"></i>
                            <span>7th floor, Astor Court<br>Georges Guibert Street, Port Louis</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-phone mr-3 text-blue-300"></i>
                            <span>+230 214 4607</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-envelope mr-3 text-blue-300"></i>
                            <span>LawfirmPrecision@outlook.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-800 mt-10 pt-8 text-center text-gray-400">
                <p class="text-base">© 2024 Precision Law Firm. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1500,
            offset: 80,
            easing: 'ease-out-cubic',
            once: true,
            delay: 0,
            mirror: false,
            anchorPlacement: 'top-bottom'
        });

        // Toggle mobile menu
        const mobileButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileButton && mobileMenu) {
            mobileButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');

                // Change burger icon
                const icon = mobileButton.querySelector('i');
                if (icon.classList.contains('fa-bars')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        }
    </script>
</body>

</html>