<?php
require '../config.php';

// --- Fetch Overview Hero ---
$stmt = $pdo->query("SELECT * FROM overview_hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- Fetch Overview Description paragraphs ---
$stmt = $pdo->query("SELECT * FROM overview_description ORDER BY sort_order ASC");
$descriptions = $stmt->fetchAll();

// --- Fetch What We Do content (split by column) ---
$stmt = $pdo->query("SELECT * FROM what_we_do ORDER BY column_number, sort_order ASC");
$whatWeDo = $stmt->fetchAll();

// Separate into columns
$whatWeDoCol1 = array_filter($whatWeDo, function ($item) {
    return $item['column_number'] == 1;
});
$whatWeDoCol2 = array_filter($whatWeDo, function ($item) {
    return $item['column_number'] == 2;
});

// --- Fetch Practice Areas ---
$stmt = $pdo->query("SELECT * FROM practice_areas ORDER BY sort_order ASC");
$practiceAreas = $stmt->fetchAll();

// --- Fetch Approach Content ---
$stmt = $pdo->query("SELECT * FROM approach_content ORDER BY sort_order ASC");
$approachContent = $stmt->fetchAll();

// --- Fetch Approach Features ---
$stmt = $pdo->query("SELECT * FROM approach_features ORDER BY sort_order ASC");
$approachFeatures = $stmt->fetchAll();

// --- Fetch CTA Section ---
$stmt = $pdo->query("SELECT * FROM cta_section WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$cta = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS for consistent animations with homepage -->
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

        .slow-transition {
            transition: all 0.3s ease;
        }

        /* Hover lift effect from homepage */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom animations */
        [data-aos="fade-up-slow"] {
            transform: translateY(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-up-slow"].aos-animate {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body class="bg-white">

    <!-- Navbar (same as homepage) -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-3" data-aos="fade-down-slow"
        data-aos-duration="1200" data-aos-easing="ease-out-cubic">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 w-full justify-between">

                    <!-- Logo à gauche -->
                    <div class="text-[#D4AF37] font-bold text-xl tracking-tight">
                        Precision Law Firm
                    </div>

                    <!-- Navigation -->
                    <div class="flex items-center space-x-8">
                        <a href="../accueil.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Home
                        </a>

                        <a href="overview.php"
                            class="text-[#D4AF37] font-medium transition duration-300 text-sm tracking-wide">
                            Overview
                        </a>

                        <a href="team.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Our Team
                        </a>

                        <a href="expertise.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Expertise
                        </a>

                        <a href="jurisprudence.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Jurisprudence
                        </a>

                        <a href="courses.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Courses
                        </a>

                        <a href="appointment.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm tracking-wide">
                            Appointment
                        </a>
                    </div>

                    <!-- Bouton à droite -->
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-6 py-2.5 rounded-full font-medium
                     hover:opacity-90 transition duration-300 hover-lift text-sm tracking-wide shadow-sm hover:shadow-md">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden flex items-center justify-between w-full">
                    <div class="text-[#D4AF37] font-bold text-lg">
                        Precision Law Firm
                    </div>

                    <button id="mobile-menu-button" class="text-gray-700 text-xl transition duration-300">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-3">
                <div class="flex flex-col space-y-4">
                    <a href="../accueil.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Home
                    </a>
                    <a href="overview.php"
                        class="text-[#D4AF37] font-medium transition duration-300 text-sm py-2">
                        Overview
                    </a>
                    <a href="team.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Our Team
                    </a>
                    <a href="expertise.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Expertise
                    </a>
                    <a href="jurisprudence.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Jurisprudence
                    </a>
                    <a href="courses.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Courses
                    </a>
                    <a href="appointment.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm py-2">
                        Appointment
                    </a>
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-4 py-2.5 rounded-md font-medium text-center mt-2 transition duration-300 text-sm">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden py-20 md:py-28 min-h-[500px] md:min-h-[600px] flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0">
                <img src="<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>"
                    alt="Precision Law Firm Overview"
                    class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0F2854]/70 to-[#1C4D8D]/50"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-6 md:px-12 lg:px-24 z-10 relative">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-8 animate-on-scroll"
                    data-aos="fade-up-slow" data-aos-duration="1400">
                    <?= htmlspecialchars($hero['title'] ?? 'OVERVIEW') ?>
                </h1>
                <div class="text-white text-lg md:text-xl leading-relaxed space-y-4">
                    <?php if (!empty($descriptions)): ?>
                        <?php foreach ($descriptions as $desc): ?>
                            <p class="opacity-95 animate-on-scroll" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                                <?= htmlspecialchars($desc['paragraph']) ?>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="opacity-95 animate-on-scroll" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            Precision Law Firm is a well established Law Firm which delivers legal advice with precision. We act for local and international clients across various sectors, combining deep legal knowledge with strategic commercial insight.
                        </p>
                        <p class="opacity-95 animate-on-scroll" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                            Founded by a former Senior State Attorney, our firm brings unique government experience to private practice, ensuring comprehensive legal solutions tailored to our clients' specific needs.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- What We Do Section -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F2854] mb-6">What we do</h2>
                    <div class="grid md:grid-cols-2 gap-12">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <?php if (!empty($whatWeDoCol1)): ?>
                                <?php foreach ($whatWeDoCol1 as $item): ?>
                                    <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400">
                                        <?= htmlspecialchars($item['content']) ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400">
                                    We advise on all legal issues that arise in commercial transactions and business operations in Mauritius. Our expertise spans from routine corporate matters to complex regulatory compliance.
                                </p>
                                <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                                    Our litigation team represents clients before Mauritian courts including the Supreme Court, Intermediate Court, and various specialized tribunals.
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <?php if (!empty($whatWeDoCol2)): ?>
                                <?php foreach ($whatWeDoCol2 as $item): ?>
                                    <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                                        <?= htmlspecialchars($item['content']) ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                                    We provide strategic legal opinions for corporate and individual clients, ensuring compliance with Mauritian legislation while protecting their business interests.
                                </p>
                                <p class="text-gray-700 leading-relaxed" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                                    Our practice includes both contentious and non-contentious matters, with particular strength in regulatory frameworks specific to Mauritius's financial and business landscape.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Practice Areas Grid -->
                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <?php if (!empty($practiceAreas)): ?>
                        <?php foreach ($practiceAreas as $index => $area): ?>
                            <div class="border border-gray-200 p-6 hover:border-[#1C4D8D] transition-colors hover-lift"
                                data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center mb-4">
                                    <i class="fas <?= htmlspecialchars($area['icon']) ?> text-[#1C4D8D]"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($area['title']) ?></h4>
                                <p class="text-gray-600 text-sm"><?= htmlspecialchars($area['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback practice areas -->
                        <div class="border border-gray-200 p-6 hover:border-[#1C4D8D] transition-colors hover-lift" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center mb-4">
                                <i class="fas fa-gavel text-[#1C4D8D]"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Commercial Litigation</h4>
                            <p class="text-gray-600 text-sm">Strategic dispute resolution across Mauritian courts</p>
                        </div>
                        <div class="border border-gray-200 p-6 hover:border-[#1C4D8D] transition-colors hover-lift" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                            <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center mb-4">
                                <i class="fas fa-lightbulb text-[#1C4D8D]"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Intellectual Property</h4>
                            <p class="text-gray-600 text-sm">Industrial Property Act 2019 expertise</p>
                        </div>
                        <div class="border border-gray-200 p-6 hover:border-[#1C4D8D] transition-colors hover-lift" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center mb-4">
                                <i class="fas fa-briefcase text-[#1C4D8D]"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Employment Law</h4>
                            <p class="text-gray-600 text-sm">Workers' Rights Act compliance & disputes</p>
                        </div>
                        <div class="border border-gray-200 p-6 hover:border-[#1C4D8D] transition-colors hover-lift" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                            <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center mb-4">
                                <i class="fas fa-chart-line text-[#1C4D8D]"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Financial Services</h4>
                            <p class="text-gray-600 text-sm">Regulatory compliance & advisory</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Approach Section -->
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-16 items-start">
                    <!-- Left column - Approach content -->
                    <div data-aos="fade-right-slow" data-aos-duration="1500">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#0F2854] mb-6">Our approach</h2>
                        <div class="space-y-6">
                            <?php if (!empty($approachContent)): ?>
                                <?php foreach ($approachContent as $content): ?>
                                    <p class="text-gray-700 leading-relaxed"><?= $content['content'] ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-700 leading-relaxed">
                                    <strong>Commercial thinking</strong> is at the heart of our approach. We take the time to understand the commercial rationale of every assignment, whether it's a transaction, dispute, or regulatory matter.
                                </p>
                                <p class="text-gray-700 leading-relaxed">
                                    We analyze and discuss with our clients the possible means to achieve their objectives, leveraging our unique government experience to anticipate challenges and opportunities.
                                </p>
                                <p class="text-gray-700 leading-relaxed">
                                    We agree with clients on clear timelines for delivery and adopt a transparent pricing policy so that legal costs are predictable from the outset.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right column - Features cards -->
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200"
                        data-aos="fade-left-slow" data-aos-duration="1500" data-aos-delay="200">
                        <div class="space-y-6">
                            <?php if (!empty($approachFeatures)): ?>
                                <?php foreach ($approachFeatures as $feature): ?>
                                    <div class="flex items-start group hover-lift transition-all duration-300">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas <?= htmlspecialchars($feature['icon']) ?> text-[#1C4D8D]"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($feature['title']) ?></h4>
                                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($feature['description']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="flex items-start group hover-lift transition-all duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-search text-[#1C4D8D]"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Analytical Precision</h4>
                                        <p class="text-gray-600 text-sm">Meticulous attention to legal detail and strategic implications</p>
                                    </div>
                                </div>
                                <div class="flex items-start group hover-lift transition-all duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-university text-[#1C4D8D]"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Government Insight</h4>
                                        <p class="text-gray-600 text-sm">Unique perspective from former State Attorney experience</p>
                                    </div>
                                </div>
                                <div class="flex items-start group hover-lift transition-all duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-handshake text-[#1C4D8D]"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-2">Client Partnership</h4>
                                        <p class="text-gray-600 text-sm">Collaborative approach focused on your business objectives</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto text-center">
                <?php if (!empty($cta)): ?>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        <?= htmlspecialchars($cta['title']) ?>
                    </h2>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        <?= htmlspecialchars($cta['description']) ?>
                    </p>
                    <a href="<?= htmlspecialchars($cta['button_link']) ?>"
                        class="inline-flex items-center bg-[#1C4D8D] text-white px-8 py-3 rounded hover:bg-[#0F2854] transition-all duration-300 hover-lift"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <span class="mr-2 font-medium"><?= htmlspecialchars($cta['button_text']) ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        Ready to discuss your legal needs?
                    </h2>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        Contact us for strategic legal advice from attorneys with government-level expertise and commercial insight.
                    </p>
                    <a href="contact.php"
                        class="inline-flex items-center bg-[#1C4D8D] text-white px-8 py-3 rounded hover:bg-[#0F2854] transition-all duration-300 hover-lift"
                        data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <span class="mr-2 font-medium">Contact Our Team</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0F2854] text-white py-12">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo and description -->
                <div class="md:col-span-2">
                    <div class="text-2xl font-bold mb-4">
                        <span class="text-white">Precision</span>
                        <span class="text-blue-300">Law Firm</span>
                    </div>
                    <p class="text-gray-300 mb-6 max-w-md">
                        A premier Mauritian law firm founded by former Senior State Attorney, combining government
                        litigation expertise with strategic private practice.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="../accueil.php" class="text-gray-300 hover:text-white transition">Home</a></li>
                        <li><a href="overview.php" class="text-gray-300 hover:text-white transition">Overview</a></li>
                        <li><a href="team.php" class="text-gray-300 hover:text-white transition">Our Team</a></li>
                        <li><a href="expertise.php" class="text-gray-300 hover:text-white transition">Expertise</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-300"></i>
                            <span>7th floor, Astor Court<br>Georges Guibert Street, Port Louis</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-300"></i>
                            <span>+230 214 4607</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-300"></i>
                            <span>LawfirmPrecision@outlook.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-800 mt-8 pt-8 text-center text-gray-400">
                <p>© 2024 Precision Law Firm. All rights reserved.</p>
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