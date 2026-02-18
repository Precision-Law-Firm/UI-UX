<?php require 'config.php';
// --- Hero ---
$stmt = $pdo->query("SELECT * FROM hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- About Us ---
$stmt = $pdo->query("SELECT * FROM about_us ORDER BY id ASC");
$about_us = $stmt->fetchAll();

// --- Expertise Areas ---
$stmt = $pdo->query("SELECT * FROM expertise_areas ORDER BY id ASC");
$expertise = $stmt->fetchAll();

// --- Public Service Experience ---
$stmt = $pdo->query("SELECT * FROM public_service ORDER BY id ASC");
$public_service = $stmt->fetchAll();

// --- Testimonials ---
$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY id ASC");
$testimonials = $stmt->fetchAll();

// --- Stats ---
$stats = [
    'retention' => '98%',
    'rating' => '4.9/5',
    'cases' => '200+'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precision Law Firm</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Inter for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Style for button arrow */
        .btn-hover:hover .arrow-icon {
            transform: translateX(5px);
        }

        /* Style for decorative lines */
        .decorative-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, #1C4D8D, transparent);
        }

        /* Main content takes all available space */
        .main-content {
            flex: 1 0 auto;
        }

        /* Footer stays at bottom */
        .site-footer {
            flex-shrink: 0;
        }

        /* 5rem = 80px exactly */
        .section-mt-5rem {
            margin-top: 5rem;
            /* 80px */
        }

        /* AOS animations slow effect */
        [data-aos] {
            transition-duration: 1500ms !important;
            transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        }

        /* Custom slow animations */
        [data-aos="fade-up-slow"] {
            transform: translateY(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-up-slow"].aos-animate {
            transform: translateY(0);
            opacity: 1;
        }

        [data-aos="fade-down-slow"] {
            transform: translateY(-40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-down-slow"].aos-animate {
            transform: translateY(0);
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

        [data-aos="fade-right-slow"] {
            transform: translateX(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-right-slow"].aos-animate {
            transform: translateX(0);
            opacity: 1;
        }

        [data-aos="zoom-slow"] {
            transform: scale(0.9);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="zoom-slow"].aos-animate {
            transform: scale(1);
            opacity: 1;
        }

        /* Hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Stagger delays */
        .stagger-delay-1 {
            animation-delay: 0.1s;
        }

        .stagger-delay-2 {
            animation-delay: 0.2s;
        }

        .stagger-delay-3 {
            animation-delay: 0.3s;
        }

        .stagger-delay-4 {
            animation-delay: 0.4s;
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
                        <a href="accueil.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Home
                        </a>

                        <a href="pages/overview.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Overview
                        </a>

                        <a href="pages/team.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Our Team
                        </a>

                        <a href="pages/expertise.html"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Expertise
                        </a>

                        <a href="pages/jurisprudence.html"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Jurisprudence
                        </a>

                        <a href="pages/courses.html"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Courses
                        </a>

                        <a href="pages/appointment.html"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Appointment
                        </a>
                    </div>

                    <!-- Contact Button - from text-sm to text-base -->
                    <a href="pages/contact.html"
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
                    <a href="accueil.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Home
                    </a>

                    <a href="pages/overview.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Overview
                    </a>

                    <a href="pages/team.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Our Team
                    </a>

                    <a href="pages/expertise.html"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Expertise
                    </a>

                    <a href="pages/jurisprudence.html"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Jurisprudence
                    </a>

                    <a href="pages/courses.html"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Courses
                    </a>

                    <a href="pages/appointment.html"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Appointment
                    </a>

                    <a href="pages/contact.html"
                        class="bg-[#0A1F44] text-white px-4 py-3 rounded-md font-medium text-center mt-2 transition duration-300 text-base">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Section (Hero) - Larger text -->
    <section class="relative overflow-hidden min-h-[600px] md:min-h-[700px] flex items-center p-4">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0F2854] via-[#173A6B] to-[#1C4D8D]"></div>

        <!-- Soft grain overlay -->
        <div class="absolute inset-0 opacity-[0.05] bg-[url('components/img/noise.png')]"></div>

        <!-- Hero Image (dynamique) -->
        <?php if ($hero && !empty($hero['image_url'])): ?>
            <div class="absolute right-[-80px] top-1/2 -translate-y-1/2 z-0">
                <img src="<?= htmlspecialchars($hero['image_url']) ?>" alt="Hero Image"
                    class="w-[520px] md:w-[650px] opacity-[0.12] blur-[0.3px]" data-aos="zoom-in-slow"
                    data-aos-duration="2200">
            </div>
        <?php endif; ?>

        <!-- Light radial glow -->
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[500px] h-[500px]
                bg-blue-200/10 rounded-full blur-3xl"></div>

        <!-- Content -->
        <div class="container mx-auto px-6 md:px-12 lg:px-24 relative z-10">
            <!-- Search bar - from text-sm to text-base -->
            <div class="max-w-xl mx-auto mb-12" data-aos="fade-up-slow" data-aos-duration="1400">
                <div class="relative">
                    <div class="flex items-center bg-white rounded-full border border-gray-300 overflow-hidden focus-within:border-[#1C4D8D] focus-within:ring-2 focus-within:ring-white/30 transition-all duration-300 shadow-lg">
                        <div class="pl-4 pr-2">
                            <i class="fas fa-search text-gray-400 text-base"></i>
                        </div>
                        <input type="text" placeholder="Search for legal expertise, cases, or information..."
                            class="w-full py-4 px-2 outline-none text-gray-700 placeholder-gray-500 text-base">
                        <button class="bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white px-6 py-4 hover:opacity-90 transition-all duration-300 font-medium text-base">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content aligned left -->
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-8 text-white"
                    data-aos="fade-up-slow" data-aos-delay="200">
                    <?= htmlspecialchars($hero['title'] ?? 'Strategic legal attorneys') ?><br>
                    <span class="text-blue-200"><?= htmlspecialchars($hero['subtitle'] ?? 'with commercial foresight') ?></span>
                </h1>

                <div class="w-24 h-1 bg-gradient-to-r from-blue-200 to-white mb-10"></div>

                <p class="text-xl md:text-2xl text-white/90 max-w-xl mb-10" data-aos="fade-up-slow" data-aos-delay="400">
                    <?= htmlspecialchars($hero['description'] ?? 'We help businesses resolve disputes, secure deals, and navigate risk through clear thinking, agile action, and strategic precision.') ?>
                </p>

                <div data-aos="fade-up-slow" data-aos-delay="600">
                    <a href="<?= htmlspecialchars($hero['button_link'] ?? 'pages/expertise.html') ?>" class="inline-flex items-center gap-4 text-white font-semibold text-lg group">
                        <?= htmlspecialchars($hero['button_label'] ?? 'Discover') ?>
                        <span class="w-14 h-14 rounded-full bg-white text-[#1C4D8D]
                               flex items-center justify-center
                               group-hover:translate-x-1 transition transform hover:scale-110">
                            <i class="fas fa-arrow-right text-base"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section - Larger text -->
    <section class="section bg-white section-mt-5rem">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <!-- Section title - from text-4xl to text-5xl/6xl -->
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-16"
                    data-aos="fade-up-slow" data-aos-duration="1400">
                    <div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-4">
                            <span class="text-[#0F2854]">About</span>
                            <span class="text-[#1C4D8D]">Us</span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854]" data-aos="fade-right-slow"
                            data-aos-duration="1200" data-aos-delay="200"></div>
                    </div>
                    <p class="text-xl text-gray-600 mt-4 md:mt-0 max-w-xl text-left md:text-right"
                        data-aos="fade-left-slow" data-aos-duration="1400" data-aos-delay="300">
                        A Mauritian law firm founded by former Senior State Attorney, combining government expertise
                        with private practice excellence.
                    </p>
                </div>

                <!-- Main content -->
                <div class="grid md:grid-cols-2 gap-12 items-start">
                    <!-- Main text - About Us content -->
                    <div class="space-y-8" data-aos="fade-right-slow" data-aos-duration="1500">
                        <!-- Title with accent - from text-2xl to text-3xl/4xl -->
                        <div class="relative pt-1">
                            <div
                                class="absolute -left-4 top-1 w-1 h-full bg-gradient-to-b from-[#1C4D8D] to-[#0F2854] rounded-full">
                            </div>
                            <h3 class="text-3xl md:text-4xl font-bold text-[#0F2854] pl-6">
                                From Attorney General's Office to Strategic Private Practice
                            </h3>
                        </div>

                        <!-- Text content with enhanced cards - from text-base to text-lg -->
                        <div class="space-y-6">
                            <?php if (!empty($about_us)): ?>
                                <?php foreach ($about_us as $index => $section): ?>
                                    <div class="bg-gradient-to-r from-white to-gray-50 p-8 rounded-xl border-l-4 border-[#1C4D8D] shadow-sm hover:shadow-md transition-all duration-300"
                                        data-aos="fade-right-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                        <p class="text-gray-700 text-lg leading-relaxed"><?= htmlspecialchars($section['content']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback content if no data -->
                                <div class="bg-gradient-to-r from-white to-gray-50 p-8 rounded-xl border-l-4 border-[#1C4D8D] shadow-sm hover:shadow-md transition-all duration-300">
                                    <p class="text-gray-700 text-lg leading-relaxed">
                                        Precision Law Firm was founded by <strong class="text-[#0F2854]">Mr. Jelend
                                            Chowrimootoo</strong>, Attorney-at-Law and former <strong class="text-[#0F2854]">Senior State
                                            Attorney</strong> at the Attorney General's Office of Mauritius. His career spans both distinguished public service and private legal practice.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Statistics badge - larger text -->
                        <div class="pt-4">
                            <div class="inline-flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-6 bg-gradient-to-r from-[#0F2854]/5 to-[#1C4D8D]/5 p-8 rounded-2xl border border-gray-200 hover:border-[#1C4D8D]/20 transition-all duration-300 w-full"
                                data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="500">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div
                                            class="w-14 h-14 bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] rounded-full flex items-center justify-center">
                                            <i class="fas fa-gavel text-white text-xl"></i>
                                        </div>
                                        <div
                                            class="absolute -top-1 -right-1 w-6 h-6 bg-white rounded-full border-2 border-[#0F2854] flex items-center justify-center">
                                            <div class="w-2 h-2 bg-[#0F2854] rounded-full"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-4xl font-bold text-[#0F2854]">Multi-Specialist</div>
                                        <div class="text-gray-600 text-lg">Civil, Commercial & Regulatory Law</div>
                                    </div>
                                </div>
                                <div
                                    class="hidden sm:block h-12 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent">
                                </div>
                                <div class="text-center sm:text-left">
                                    <div class="text-base font-semibold text-[#0F2854] uppercase tracking-wider mb-2">
                                        Expertise Areas</div>
                                    <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                        <?php if (!empty($expertise)): ?>
                                            <?php foreach ($expertise as $area): ?>
                                                <span class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700">
                                                    <?= htmlspecialchars($area['name']) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700">Civil Law</span>
                                            <span class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700">Commercial Law</span>
                                            <span class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700">Regulatory Law</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card/Box - Public Service Experience - larger text -->
                    <div class="relative group" data-aos="fade-left-slow" data-aos-duration="1500" data-aos-delay="200">
                        <!-- Decorative background elements -->
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-[#0F2854]/10 to-[#1C4D8D]/10 rounded-2xl blur opacity-0 group-hover:opacity-100 transition-all duration-500">
                        </div>

                        <!-- Main card -->
                        <div
                            class="relative bg-white p-10 rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                            <!-- Card header with icon -->
                            <div class="mb-8">
                                <div class="flex items-start gap-4 mb-4">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                        <i class="fas fa-university text-white text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-2xl md:text-3xl font-bold text-[#0F2854] pt-1">Public Service
                                            Experience</h4>
                                        <div
                                            class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-full mt-2">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg mb-6 relative" data-aos="fade-up-slow" data-aos-duration="1200"
                                    data-aos-delay="300">
                                    <span class="absolute -left-2 top-0 text-5xl text-[#0F2854]/10 font-serif">"</span>
                                    <span class="pl-6 block">As Senior State Attorney at the Attorney General's Office,
                                        Mr. Chowrimootoo represented the <strong class="text-[#0F2854]">State of Mauritius</strong> in a wide range
                                        of matters.</span>
                                </p>
                            </div>

                            <!-- Key points with enhanced design - larger text -->
                            <div class="space-y-5">
                                <?php if (!empty($public_service)): ?>
                                    <?php foreach ($public_service as $index => $service): ?>
                                        <div class="flex items-start group/item" data-aos="fade-left-slow"
                                            data-aos-duration="1200" data-aos-delay="<?= 400 + ($index * 100) ?>">
                                            <div
                                                class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 transition-all duration-300 shadow-md">
                                                <i class="fas <?= htmlspecialchars($service['icon'] ?? 'fa-file-alt') ?> text-white text-base"></i>
                                            </div>
                                            <div
                                                class="flex-1 bg-gray-50/50 p-5 rounded-lg group-hover/item:bg-gray-50 transition-all duration-300">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h5 class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($service['title'] ?? 'Service Title') ?></h5>
                                                    <div
                                                        class="w-2 h-2 bg-[#0F2854] rounded-full opacity-0 group-hover/item:opacity-100 transition-opacity duration-300">
                                                    </div>
                                                </div>
                                                <p class="text-gray-600 text-base"><?= htmlspecialchars($service['description'] ?? 'Service description') ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Fallback content -->
                                    <div class="flex items-start group/item" data-aos="fade-left-slow" data-aos-duration="1200" data-aos-delay="400">
                                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 transition-all duration-300 shadow-md">
                                            <i class="fas fa-file-alt text-white text-base"></i>
                                        </div>
                                        <div class="flex-1 bg-gray-50/50 p-5 rounded-lg group-hover/item:bg-gray-50 transition-all duration-300">
                                            <h5 class="font-semibold text-gray-800 text-lg">Government Representation</h5>
                                            <p class="text-gray-600 text-base">Civil, commercial, constitutional & administrative litigation before Supreme Court, Intermediate Court, and tribunals</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Enhanced Button - larger text -->
                            <div class="mt-10 pt-8 border-t border-gray-200 relative" data-aos="fade-up-slow"
                                data-aos-duration="1200" data-aos-delay="700">
                                <!-- Arrow line decoration -->
                                <div class="absolute left-0 right-0 top-0 flex justify-center">
                                    <div
                                        class="w-16 h-px bg-gradient-to-r from-transparent via-[#1C4D8D] to-transparent">
                                    </div>
                                </div>

                                <a href="pages/team.php"
                                    class="group/btn inline-flex items-center justify-between w-full bg-gradient-to-r from-gray-50 to-white p-5 rounded-xl border border-gray-300 hover:border-[#1C4D8D] hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-lg flex items-center justify-center mr-4 shadow-md flex-shrink-0">
                                            <i class="fas fa-user-tie text-white text-lg"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-[#0F2854] font-bold text-xl truncate">View Founder's
                                                Profile</div>
                                            <div class="text-gray-600 text-base truncate">Explore comprehensive background
                                                & achievements</div>
                                        </div>
                                    </div>
                                    <div
                                        class="w-14 h-14 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white rounded-full flex items-center justify-center group-hover/btn:translate-x-2 transition-transform duration-300 shadow-md flex-shrink-0 ml-4">
                                        <i class="fas fa-arrow-right text-lg"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Larger text -->
    <section class="py-20 bg-gradient-to-b from-white to-gray-50 section-mt-5rem">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <!-- Section title -->
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-16"
                    data-aos="fade-up-slow" data-aos-duration="1400">
                    <div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-4">
                            <span class="text-[#0F2854]">Client</span>
                            <span class="text-[#1C4D8D]">Testimonials</span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854]" data-aos="fade-right-slow"
                            data-aos-duration="1200" data-aos-delay="200"></div>
                    </div>
                    <p class="text-xl text-gray-600 mt-4 md:mt-0 max-w-xl" data-aos="fade-left-slow"
                        data-aos-duration="1400" data-aos-delay="300">
                        What our clients say about working with Precision Law Firm
                    </p>
                </div>

                <!-- Testimonials grid - larger text -->
                <div class="grid md:grid-cols-3 gap-8">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $index => $test): ?>
                            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group hover-lift"
                                data-aos="zoom-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 200 ?>">
                                <div class="mb-6">
                                    <div class="flex items-center mb-4">
                                        <div class="flex text-yellow-400 mr-2 text-xl">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-base text-gray-500"><?= htmlspecialchars($test['rating'] ?? '5.0') ?></span>
                                    </div>
                                    <p class="text-gray-700 text-lg italic leading-relaxed" data-aos="fade-up-slow"
                                        data-aos-duration="1200" data-aos-delay="200">
                                        "<?= htmlspecialchars($test['text'] ?? 'Excellent service and professional approach.') ?>"
                                    </p>
                                </div>
                                <div class="flex items-center pt-6 border-t border-gray-100" data-aos="fade-up-slow"
                                    data-aos-duration="1200" data-aos-delay="300">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <?= htmlspecialchars($test['initials'] ?? substr($test['name'] ?? 'C', 0, 1) . substr(explode(' ', $test['name'] ?? 'Client')[1] ?? '', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($test['name'] ?? 'Client Name') ?></h4>
                                        <p class="text-base text-gray-600"><?= htmlspecialchars($test['position'] ?? 'CEO') ?>, <?= htmlspecialchars($test['company'] ?? 'Company') ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback testimonials -->
                        <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group hover-lift"
                            data-aos="zoom-slow" data-aos-duration="1400">
                            <div class="mb-6">
                                <div class="flex items-center mb-4 text-xl">
                                    <div class="flex text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-base text-gray-500">5.0</span>
                                </div>
                                <p class="text-gray-700 text-lg italic leading-relaxed">
                                    "Precision Law Firm provided exceptional guidance through our company's acquisition. Their commercial insight was invaluable."
                                </p>
                            </div>
                            <div class="flex items-center pt-6 border-t border-gray-100">
                                <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">MS</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 text-lg">Michael Sullivan</h4>
                                    <p class="text-base text-gray-600">CEO, TechCorp Solutions</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Stats bar - larger text -->
                <div class="mt-16 bg-gradient-to-br from-blue-50 to-gray-50 rounded-xl p-10 border border-blue-100 shadow-sm hover-lift transition-all duration-300"
                    data-aos="fade-up-slow" data-aos-duration="1600" data-aos-delay="300">
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="400">
                            <div class="text-5xl font-bold mb-2 text-[#0F2854]"><?= $stats['retention'] ?></div>
                            <p class="text-[#1C4D8D] text-lg font-medium">Client Retention Rate</p>
                        </div>
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="500">
                            <div class="text-5xl font-bold mb-2 text-[#0F2854]"><?= $stats['rating'] ?></div>
                            <p class="text-[#1C4D8D] text-lg font-medium">Average Client Rating</p>
                        </div>
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="600">
                            <div class="text-5xl font-bold mb-2 text-[#0F2854]"><?= $stats['cases'] ?></div>
                            <p class="text-[#1C4D8D] text-lg font-medium">Successful Cases</p>
                        </div>
                    </div>
                </div>

                <!-- CTA button -->
                <div class="mt-12 text-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="700">
                    <a href="#" class="btn-hover inline-flex items-center group hover-lift">
                        <span class="text-xl font-semibold text-[#0F2854] mr-3">View All Testimonials</span>
                        <span
                            class="arrow-icon inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white rounded-full group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-arrow-right text-base"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimal Newsletter with Image - Larger text -->
    <section class="py-16 bg-white section-mt-5rem">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex flex-col md:flex-row items-center gap-8 max-w-5xl mx-auto" data-aos="fade-up-slow"
                data-aos-duration="1500">
                <!-- Left side: Minimal image/icon - larger -->
                <div class="md:w-2/5 flex justify-center" data-aos="zoom-slow" data-aos-duration="1400"
                    data-aos-delay="200">
                    <div
                        class="w-56 h-56 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center hover-lift transition-all duration-300">
                        <i class="fas fa-envelope text-7xl text-[#1C4D8D]"></i>
                    </div>
                </div>

                <!-- Right side: Content -->
                <div class="md:w-3/5" data-aos="fade-left-slow" data-aos-duration="1400" data-aos-delay="300">
                    <h2 class="text-4xl font-bold mb-4">
                        <span class="text-[#0F2854]">Newsletter</span>
                    </h2>

                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mb-6" data-aos="fade-right-slow"
                        data-aos-duration="1200" data-aos-delay="400"></div>

                    <p class="text-gray-600 text-lg mb-6" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="500">
                        Get legal insights and business updates monthly.
                    </p>

                    <!-- Simple form - larger -->
                    <form action="subscribe.php" method="POST" class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="email" placeholder="Enter your email" required
                            class="flex-1 px-5 py-4 rounded-lg border border-gray-300 focus:border-[#1C4D8D] focus:ring-1 focus:ring-[#1C4D8D] outline-none transition-all duration-300 text-base"
                            data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="600">
                        <button type="submit"
                            class="bg-[#1C4D8D] text-white px-8 py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 font-medium whitespace-nowrap hover-lift text-base"
                            data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="700">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer - Larger text -->
    <footer class="bg-[#0F2854] text-white py-16 mt-20">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid md:grid-cols-4 gap-10">
                <!-- Logo and description -->
                <div class="md:col-span-2">
                    <div class="text-3xl font-bold mb-4">
                        <span class="text-white">Precision</span>
                        <span class="text-blue-300">Law Firm</span>
                    </div>
                    <p class="text-gray-300 text-base mb-6 max-w-md">
                        A forward-thinking legal practice combining commercial insight with legal excellence.
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
                        <li><a href="accueil.php" class="text-gray-300 hover:text-white transition text-base">Home</a></li>
                        <li><a href="pages/overview.php" class="text-gray-300 hover:text-white transition text-base">Overview</a></li>
                        <li><a href="pages/team.php" class="text-gray-300 hover:text-white transition text-base">Our Team</a></li>
                        <li><a href="pages/expertise.html" class="text-gray-300 hover:text-white transition text-base">Expertise</a></li>
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
                            <span>214-4607</span>
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
                <p class="mt-2 text-base">Strategic legal attorneys with commercial foresight</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Initialize AOS with slow settings
        AOS.init({
            duration: 1500,
            offset: 80,
            easing: 'ease-out-cubic',
            once: true,
            delay: 0,
            mirror: false,
            anchorPlacement: 'top-bottom',
            startEvent: 'DOMContentLoaded',
            disable: false,
            animatedClassName: 'aos-animate',
            initClassName: 'aos-init',
            disableMutationObserver: false,
            debounceDelay: 50,
            throttleDelay: 99
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