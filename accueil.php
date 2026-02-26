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
        #mobile-menu-panel,
        #small-menu-panel,
        #tablet-menu-panel,
        #mid-menu-panel {
            transition: max-height 0.3s ease-in-out, opacity 0.2s ease-in-out;
            will-change: max-height, opacity;
        }

        /* Optimisation pour les très petits écrans */
        @media (max-width: 480px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

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

<!-- Navbar -->
<?php include "includes/navbar.php"; ?>

    <!-- Main Section -->
    <section class="relative overflow-hidden min-h-[550px] md:min-h-[650px] flex items-center py-8 md:py-10">
        <!-- Fond principal - Élégant et raffiné (sans bleu) -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1A1F2C] via-[#2A2F3C] to-[#1E2432]"></div>

        <!-- Texture subtile de papier / lin -->
        <div class="absolute inset-0 opacity-5 mix-blend-overlay"
            style="background-image: url('data:image/svg+xml,%3Csvg width=" 60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none" fill-rule="evenodd" %3E%3Cg fill="%23ffffff" fill-opacity="0.15" %3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;">
        </div>

        <!-- Overlay dégradé doux -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/10"></div>

        <!-- Éléments décoratifs abstraits -->
        <div class="absolute top-0 right-0 w-full max-w-3xl h-full opacity-30">
            <svg class="w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#D4B28C" stop-opacity="0.2" />
                        <stop offset="50%" stop-color="#A67B5B" stop-opacity="0.1" />
                        <stop offset="100%" stop-color="#8B5A2B" stop-opacity="0.05" />
                    </linearGradient>
                    <linearGradient id="grad2" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#C0C0C0" stop-opacity="0.1" />
                        <stop offset="50%" stop-color="#808080" stop-opacity="0.05" />
                        <stop offset="100%" stop-color="#404040" stop-opacity="0.02" />
                    </linearGradient>
                </defs>
                <circle cx="600" cy="200" r="250" fill="url(#grad1)" />
                <circle cx="200" cy="500" r="300" fill="url(#grad2)" />
                <path d="M0 800 L800 0 L800 800 Z" fill="black" opacity="0.02" />
            </svg>
        </div>

        <!-- Effet de lumière douce -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#D4B28C]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#A67B5B]/5 rounded-full blur-3xl"></div>

        <!-- Content -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Search Bar - Style glass transparent amélioré avec bouton intégré -->
            <div class="max-w-2xl mx-auto mb-8 md:mb-10" data-aos="fade-down" data-aos-duration="800">
                <div class="relative group">
                    <!-- Effet de glow au hover -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#1C4D8D] to-[#D4B28C] rounded-full opacity-0 group-hover:opacity-30 blur transition duration-500"></div>

                    <!-- Barre de recherche glass -->
                    <div class="relative flex items-center bg-white/10 backdrop-blur-xl rounded-full border border-white/20 shadow-2xl hover:border-white/30 transition-all duration-300">
                        <div class="pl-5 pr-3">
                            <i class="fas fa-search text-white/60 text-sm"></i>
                        </div>
                        <input type="text"
                            placeholder="Search for legal expertise, cases, or information..."
                            class="w-full py-3.5 pr-3 outline-none text-white placeholder-white/50 text-sm bg-transparent">

                        <!-- Bouton Search élégant et intégré -->
                        <button class="relative mr-2 group/btn">
                            <!-- Fond du bouton avec dégradé subtil -->
                            <div class="absolute inset-0 bg-gradient-to-r from-[#1C4D8D] to-[#2A5A9E] rounded-full opacity-90 group-hover/btn:opacity-100 transition-opacity duration-300 blur-[2px] group-hover/btn:blur-[3px]"></div>

                            <!-- Contenu du bouton -->
                            <div class="relative flex items-center gap-2 bg-gradient-to-r from-[#1C4D8D] to-[#2A5A9E] text-white px-5 py-2.5 rounded-full text-sm font-medium
                                   hover:from-[#0F2854] hover:to-[#1C4D8D] transition-all duration-300 shadow-lg
                                   border border-white/20 hover:border-white/40">
                                <span>Search</span>
                                <i class="fas fa-arrow-right text-xs transform group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                            </div>
                        </button>
                    </div>

                    <!-- Hint text subtil -->
                    <div class="absolute -bottom-5 left-5 text-[10px] text-white/30">
                        Press Enter to search
                    </div>
                </div>
            </div>

            <!-- Main content - Flex row -->
            <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-14 max-w-6xl mx-auto">
                <!-- Texte à gauche -->
                <div class="flex-1 text-center lg:text-left">
                    <!-- Badge/Statut -->
                    <div class="mb-5" data-aos="fade-right" data-aos-delay="100">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-white/90 text-sm font-medium tracking-wide">
                            <span class="w-2 h-2 bg-[#D4B28C] rounded-full mr-2 animate-pulse"></span>
                            Legal excellence since 1985
                        </span>
                    </div>

                    <!-- Titre -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight mb-5"
                        data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                        <span class="text-white"><?= htmlspecialchars($hero['title'] ?? 'Strategic legal attorneys') ?></span>
                        <span class="text-[#1C4D8D]"> <?= htmlspecialchars($hero['subtitle'] ?? 'with commercial foresight') ?></span>
                    </h1>

                    <!-- Description justifiée sur toutes les tailles -->
                    <p class="text-lg sm:text-xl text-white/80 max-w-xl mb-7 text-justify leading-relaxed"
                        data-aos="fade-right" data-aos-delay="300">
                        <?= htmlspecialchars($hero['description'] ?? 'We help businesses resolve disputes, secure deals, and navigate risk through clear thinking, agile action, and strategic precision.') ?>
                    </p>

                    <!-- Statistiques mises à jour -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-7 sm:gap-9 mb-7" data-aos="fade-right" data-aos-delay="400">
                        <div class="text-center lg:text-left">
                            <div class="text-2xl font-bold text-[#E5D3B0]">8+</div>
                            <div class="text-sm text-white/50 tracking-wide">Years experience</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-2xl font-bold text-[#E5D3B0]">500+</div>
                            <div class="text-sm text-white/50 tracking-wide">Cases handled</div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div data-aos="fade-right" data-aos-delay="500">
                        <a href="pages/overview.php"
                            class="inline-flex items-center gap-4 group relative">
                            <span class="relative z-10 bg-[#1C4D8D] text-white px-8 py-3 rounded-full font-semibold text-base
               hover:bg-[#0F2854] transition-all duration-300 shadow-lg hover:shadow-xl
               group-hover:pr-12">
                                <?= htmlspecialchars($hero['button_label'] ?? 'Discover our expertise') ?>
                            </span>
                            <span class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/30
               flex items-center justify-center text-white
               group-hover:bg-white group-hover:text-[#1C4D8D] 
               transition-all duration-300 -ml-4 group-hover:ml-2">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Image à droite (horse.png) - Plus grande et transparente -->
                <?php if ($hero && !empty($hero['image_url'])): ?>
                    <div class="flex-1 relative max-w-xl lg:max-w-2xl" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="300">
                        <div class="relative z-10">
                            <img src="<?= htmlspecialchars($hero['image_url']) ?>"
                                alt="Hero Image - Horse"
                                class="w-full h-auto object-contain drop-shadow-2xl transform hover:scale-105 transition-transform duration-700 
                                    max-h-[450px] lg:max-h-[550px] opacity-80 hover:opacity-100">
                        </div>

                        <!-- Effet de glow plus prononcé autour de l'image -->
                        <div class="absolute inset-0 bg-gradient-to-r from-[#D4B28C]/30 to-transparent rounded-full blur-3xl -z-10"></div>

                        <!-- Éléments décoratifs autour de l'image adaptés à la taille -->
                        <div class="absolute -top-8 -right-8 w-32 h-32 border border-[#D4B28C]/30 rounded-full"></div>
                        <div class="absolute -bottom-8 -left-8 w-48 h-48 border border-[#E5D3B0]/20 rounded-full"></div>

                        <!-- Effet de lumière supplémentaire -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[#D4B28C]/5 rounded-full blur-2xl"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- About Us Section - Design responsive avec motif de fond -->
    <section class="section bg-white py-16 md:py-20 lg:py-24 relative overflow-hidden">
        <!-- Motif géométrique élégant en arrière-plan (très subtil) -->
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
            <!-- Lignes diagonales -->
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #1C4D8D 0px, #1C4D8D 1px, transparent 1px, transparent 30px);"></div>
            <!-- Points discrets -->
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20px 20px, #0F2854 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <!-- Dégradé lumineux très subtil -->
        <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-[#1C4D8D]/[0.02] to-transparent pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-[#0F2854]/[0.02] to-transparent pointer-events-none"></div>

        <!-- Éléments décoratifs très légers -->
        <div class="absolute top-20 right-20 w-64 h-64 bg-[#1C4D8D]/[0.01] rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-20 w-80 h-80 bg-[#0F2854]/[0.01] rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Section title - responsive -->
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-10 md:mb-16 gap-4"
                    data-aos="fade-up" data-aos-duration="1400">
                    <div>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold">
                            <span class="text-[#0F2854]">About</span>
                            <span class="text-[#1C4D8D]">Us</span>
                        </h2>
                        <div class="w-20 sm:w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mt-3"></div>
                    </div>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-xl text-left md:text-right">
                        A Mauritian law firm founded by former Senior State Attorney, combining government expertise
                        with private practice excellence.
                    </p>
                </div>

                <!-- Main content - responsive grid -->
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16">
                    <!-- Main text - About Us content -->
                    <div class="space-y-6 lg:space-y-8" data-aos="fade-right" data-aos-duration="1500">
                        <!-- Title with accent -->
                        <div class="relative pt-1">
                            <div class="absolute -left-3 lg:-left-4 top-1 w-1 h-full bg-gradient-to-b from-[#1C4D8D] to-[#0F2854] rounded-full">
                            </div>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#0F2854] pl-4 lg:pl-6">
                                From Attorney General's Office to Strategic Private Practice
                            </h3>
                        </div>

                        <!-- Text content with cards - TEXTE JUSTIFIÉ -->
                        <div class="space-y-4 lg:space-y-6">
                            <?php if (!empty($about_us)): ?>
                                <?php foreach ($about_us as $index => $section): ?>
                                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200/80 transition-all duration-300 relative group"
                                        data-aos="fade-right" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                        <!-- Accent bar subtle -->
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1C4D8D] to-[#0F2854] rounded-l-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <p class="text-gray-700 text-base sm:text-lg leading-relaxed text-justify"><?= htmlspecialchars($section['content']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback content if no data -->
                                <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200/80 transition-all duration-300 relative group">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1C4D8D] to-[#0F2854] rounded-l-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <p class="text-gray-700 text-base sm:text-lg leading-relaxed text-justify">
                                        Precision Law Firm was founded by <strong class="text-[#0F2854]">Mr. Jelend
                                            Chowrimootoo</strong>, Attorney-at-Law and former <strong class="text-[#0F2854]">Senior State
                                            Attorney</strong> at the Attorney General's Office of Mauritius. His career spans both distinguished public service and private legal practice.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Statistics badge - responsive -->
                        <div class="pt-2 lg:pt-4">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 bg-gradient-to-r from-[#0F2854]/[0.02] to-[#1C4D8D]/[0.02] p-5 sm:p-6 lg:p-8 rounded-2xl border border-gray-200/80 transition-all duration-300 w-full relative overflow-hidden group"
                                data-aos="fade-up" data-aos-duration="1200" data-aos-delay="500">
                                <!-- Effet de lumière au hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>

                                <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto relative">
                                    <div class="relative flex-shrink-0">
                                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-gavel text-white text-base sm:text-xl"></i>
                                        </div>
                                        <div class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-white rounded-full border-2 border-[#0F2854] flex items-center justify-center">
                                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#0F2854] rounded-full"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xl sm:text-2xl lg:text-4xl font-bold text-[#0F2854]">Multi-Specialist</div>
                                        <div class="text-sm sm:text-base lg:text-lg text-gray-600">Civil, Commercial & Regulatory Law</div>
                                    </div>
                                </div>

                                <div class="hidden sm:block h-12 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

                                <div class="w-full sm:w-auto relative">
                                    <div class="text-xs sm:text-sm font-semibold text-[#0F2854] uppercase tracking-wider mb-2">
                                        Expertise Areas
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <?php if (!empty($expertise)): ?>
                                            <?php foreach (array_slice($expertise, 0, 3) as $area): ?>
                                                <span class="px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-200 rounded-full text-xs sm:text-sm font-medium text-gray-700 transition-all duration-300">
                                                    <?= htmlspecialchars($area['name']) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-200 rounded-full text-xs sm:text-sm font-medium text-gray-700 transition-all duration-300">Civil Law</span>
                                            <span class="px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-200 rounded-full text-xs sm:text-sm font-medium text-gray-700 transition-all duration-300">Commercial Law</span>
                                            <span class="px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-200 rounded-full text-xs sm:text-sm font-medium text-gray-700 transition-all duration-300">Regulatory Law</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card/Box - Public Service Experience - SANS BOX SHADOW AU HOVER -->
                    <div class="relative group mt-8 lg:mt-0" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="200">
                        <!-- Main card - sans shadow et sans effet au hover -->
                        <div class="relative bg-white p-6 sm:p-8 lg:p-10 rounded-2xl border border-gray-200/80 transition-none">
                            <!-- Card header with icon -->
                            <div class="mb-6 lg:mb-8">
                                <div class="flex items-start gap-3 sm:gap-4 mb-4">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                        <i class="fas fa-university text-white text-base sm:text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#0F2854]">Public Service
                                            Experience</h4>
                                        <div class="w-16 sm:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-full mt-2">
                                        </div>
                                    </div>
                                </div>

                                <!-- Citation avec texte justifié -->
                                <div class="relative">
                                    <span class="absolute -left-1 top-0 text-3xl sm:text-4xl lg:text-5xl text-[#0F2854]/10 font-serif">"</span>
                                    <p class="text-gray-700 text-sm sm:text-base lg:text-lg pl-4 sm:pl-6 text-justify">
                                        As Senior State Attorney at the Attorney General's Office,
                                        Mr. Chowrimootoo represented the <strong class="text-[#0F2854]">State of Mauritius</strong> in a wide range
                                        of matters.
                                    </p>
                                </div>
                            </div>

                            <!-- Key points - TEXTE JUSTIFIÉ avec responsive -->
                            <div class="space-y-4 lg:space-y-5">
                                <?php if (!empty($public_service)): ?>
                                    <?php foreach ($public_service as $index => $service): ?>
                                        <div class="flex items-start group/item" data-aos="fade-left"
                                            data-aos-duration="1200" data-aos-delay="<?= 400 + ($index * 100) ?>">
                                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-3 sm:mr-4 shadow-md">
                                                <i class="fas <?= htmlspecialchars($service['icon'] ?? 'fa-file-alt') ?> text-white text-xs sm:text-base"></i>
                                            </div>
                                            <div class="flex-1 bg-white p-3 sm:p-4 lg:p-5 rounded-lg border border-gray-100">
                                                <h5 class="font-semibold text-gray-800 text-base sm:text-lg mb-1"><?= htmlspecialchars($service['title'] ?? 'Service Title') ?></h5>
                                                <p class="text-gray-600 text-xs sm:text-sm lg:text-base text-justify"><?= htmlspecialchars($service['description'] ?? 'Service description') ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Fallback content avec responsive -->
                                    <div class="flex items-start group/item">
                                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-3 sm:mr-4 shadow-md">
                                            <i class="fas fa-file-alt text-white text-xs sm:text-base"></i>
                                        </div>
                                        <div class="flex-1 bg-white p-3 sm:p-4 lg:p-5 rounded-lg border border-gray-100">
                                            <h5 class="font-semibold text-gray-800 text-base sm:text-lg mb-1">Government Representation</h5>
                                            <p class="text-gray-600 text-xs sm:text-sm lg:text-base text-justify">Civil, commercial, constitutional & administrative litigation before Supreme Court, Intermediate Court, and tribunals</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start group/item">
                                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-3 sm:mr-4 shadow-md">
                                            <i class="fas fa-balance-scale text-white text-xs sm:text-base"></i>
                                        </div>
                                        <div class="flex-1 bg-white p-3 sm:p-4 lg:p-5 rounded-lg border border-gray-100">
                                            <h5 class="font-semibold text-gray-800 text-base sm:text-lg mb-1">Legal Advisory</h5>
                                            <p class="text-gray-600 text-xs sm:text-sm lg:text-base text-justify">Provided legal opinions and advice to government ministries and departments on complex legal matters</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start group/item">
                                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-xl flex items-center justify-center mr-3 sm:mr-4 shadow-md">
                                            <i class="fas fa-gavel text-white text-xs sm:text-base"></i>
                                        </div>
                                        <div class="flex-1 bg-white p-3 sm:p-4 lg:p-5 rounded-lg border border-gray-100">
                                            <h5 class="font-semibold text-gray-800 text-base sm:text-lg mb-1">Prosecution Experience</h5>
                                            <p class="text-gray-600 text-xs sm:text-sm lg:text-base text-justify">Handled sensitive prosecutions and appeals on behalf of the State</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Enhanced Button - responsive -->
                            <div class="mt-8 lg:mt-10 pt-6 lg:pt-8 border-t border-gray-200/80 relative" data-aos="fade-up"
                                data-aos-duration="1200" data-aos-delay="700">
                                <!-- Arrow line decoration -->
                                <div class="absolute left-0 right-0 top-0 flex justify-center">
                                    <div class="w-16 h-px bg-gradient-to-r from-transparent via-[#1C4D8D] to-transparent"></div>
                                </div>

                                <a href="pages/team.php"
                                    class="group/btn inline-flex flex-col sm:flex-row items-start sm:items-center justify-between w-full bg-white p-4 sm:p-5 rounded-xl border border-gray-200/80 transition-all duration-300 gap-4 sm:gap-0">
                                    <div class="flex items-center w-full sm:w-auto">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] rounded-lg flex items-center justify-center mr-3 sm:mr-4 shadow-md flex-shrink-0">
                                            <i class="fas fa-user-tie text-white text-sm sm:text-lg"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-[#0F2854] font-bold text-base sm:text-lg lg:text-xl truncate">View Founder's Profile</div>
                                            <div class="text-gray-600 text-xs sm:text-sm lg:text-base truncate">Comprehensive background & achievements</div>
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white rounded-full flex items-center justify-center group-hover/btn:translate-x-2 transition-transform duration-300 shadow-md flex-shrink-0 self-end sm:self-center">
                                        <i class="fas fa-arrow-right text-sm sm:text-base lg:text-lg"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Testimonials Section - Design responsive avec textes justifiés -->
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
        <!-- Motif subtil en arrière-plan (optionnel pour cohérence) -->
        <div class="absolute inset-0 opacity-[0.01] pointer-events-none">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20px 20px, #1C4D8D 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Section title - responsive -->
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-10 md:mb-16 gap-4"
                    data-aos="fade-up" data-aos-duration="1400">
                    <div>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold">
                            <span class="text-[#0F2854]">Client</span>
                            <span class="text-[#1C4D8D]">Testimonials</span>
                        </h2>
                        <div class="w-20 sm:w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mt-3"></div>
                    </div>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-xl text-left md:text-right">
                        What our clients say about working with Precision Law Firm
                    </p>
                </div>

                <!-- Testimonials grid - responsive -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $index => $test): ?>
                            <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-xl border border-gray-100 hover:border-[#1C4D8D]/20 transition-all duration-300 group"
                                data-aos="fade-up" data-aos-duration="1400" data-aos-delay="<?= $index * 200 ?>">
                                <div class="mb-4 lg:mb-6">
                                    <!-- Rating responsive -->
                                    <div class="flex items-center mb-3 lg:mb-4">
                                        <div class="flex text-yellow-400 mr-2 text-base sm:text-lg lg:text-xl">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-xs sm:text-sm text-gray-500"><?= htmlspecialchars($test['rating'] ?? '5.0') ?></span>
                                    </div>

                                    <!-- Testimonial text justifié -->
                                    <p class="text-gray-700 text-sm sm:text-base lg:text-lg italic leading-relaxed text-justify">
                                        "<?= htmlspecialchars($test['text'] ?? 'Excellent service and professional approach.') ?>"
                                    </p>
                                </div>

                                <!-- Client info responsive -->
                                <div class="flex items-center pt-4 lg:pt-6 border-t border-gray-100">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base lg:text-xl mr-3 sm:mr-4 flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                        <?= htmlspecialchars($test['initials'] ?? substr($test['name'] ?? 'C', 0, 1) . substr(explode(' ', $test['name'] ?? 'Client')[1] ?? '', 0, 1)) ?>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base lg:text-lg truncate"><?= htmlspecialchars($test['name'] ?? 'Client Name') ?></h4>
                                        <p class="text-xs sm:text-sm text-gray-600 truncate"><?= htmlspecialchars($test['position'] ?? 'CEO') ?>, <?= htmlspecialchars($test['company'] ?? 'Company') ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback testimonials avec responsive -->
                        <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-xl border border-gray-100 hover:border-[#1C4D8D]/20 transition-all duration-300 group"
                            data-aos="fade-up" data-aos-duration="1400">
                            <div class="mb-4 lg:mb-6">
                                <div class="flex items-center mb-3 lg:mb-4 text-base sm:text-lg lg:text-xl">
                                    <div class="flex text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-500">5.0</span>
                                </div>
                                <p class="text-gray-700 text-sm sm:text-base lg:text-lg italic leading-relaxed text-justify">
                                    "Precision Law Firm provided exceptional guidance through our company's acquisition. Their commercial insight was invaluable."
                                </p>
                            </div>
                            <div class="flex items-center pt-4 lg:pt-6 border-t border-gray-100">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base lg:text-xl mr-3 sm:mr-4 flex-shrink-0 group-hover:scale-105 transition-transform duration-300">MS</div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm sm:text-base lg:text-lg truncate">Michael Sullivan</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">CEO, TechCorp Solutions</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-xl border border-gray-100 hover:border-[#1C4D8D]/20 transition-all duration-300 group"
                            data-aos="fade-up" data-aos-duration="1400" data-aos-delay="200">
                            <div class="mb-4 lg:mb-6">
                                <div class="flex items-center mb-3 lg:mb-4 text-base sm:text-lg lg:text-xl">
                                    <div class="flex text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-500">5.0</span>
                                </div>
                                <p class="text-gray-700 text-sm sm:text-base lg:text-lg italic leading-relaxed text-justify">
                                    "The team at Precision Law Firm handled our complex litigation matter with exceptional skill and dedication. Highly recommended."
                                </p>
                            </div>
                            <div class="flex items-center pt-4 lg:pt-6 border-t border-gray-100">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base lg:text-xl mr-3 sm:mr-4 flex-shrink-0 group-hover:scale-105 transition-transform duration-300">JD</div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm sm:text-base lg:text-lg truncate">Jean Dupont</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">Director, Groupe Financier</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-xl border border-gray-100 hover:border-[#1C4D8D]/20 transition-all duration-300 group"
                            data-aos="fade-up" data-aos-duration="1400" data-aos-delay="400">
                            <div class="mb-4 lg:mb-6">
                                <div class="flex items-center mb-3 lg:mb-4 text-base sm:text-lg lg:text-xl">
                                    <div class="flex text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-500">5.0</span>
                                </div>
                                <p class="text-gray-700 text-sm sm:text-base lg:text-lg italic leading-relaxed text-justify">
                                    "Their strategic approach to corporate law has been instrumental in our growth. Truly partners in our success."
                                </p>
                            </div>
                            <div class="flex items-center pt-4 lg:pt-6 border-t border-gray-100">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base lg:text-xl mr-3 sm:mr-4 flex-shrink-0 group-hover:scale-105 transition-transform duration-300">SW</div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm sm:text-base lg:text-lg truncate">Sarah Williams</h4>
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">Founder, Innovate Ventures</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Stats bar - responsive avec texte justifié -->
                <div class="mt-12 lg:mt-16 bg-gradient-to-br from-blue-50 to-gray-50 rounded-xl p-6 sm:p-8 lg:p-10 border border-blue-100 transition-all duration-300"
                    data-aos="fade-up" data-aos-duration="1600" data-aos-delay="300">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        <div class="text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400">
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-1 lg:mb-2 text-[#0F2854]"><?= $stats['retention'] ?? '98%' ?></div>
                            <p class="text-[#1C4D8D] text-sm sm:text-base lg:text-lg font-medium">Client Retention Rate</p>
                        </div>
                        <div class="text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="500">
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-1 lg:mb-2 text-[#0F2854]"><?= $stats['rating'] ?? '5.0' ?></div>
                            <p class="text-[#1C4D8D] text-sm sm:text-base lg:text-lg font-medium">Average Client Rating</p>
                        </div>
                        <div class="text-center sm:col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="600">
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-1 lg:mb-2 text-[#0F2854]"><?= $stats['cases'] ?? '500+' ?></div>
                            <p class="text-[#1C4D8D] text-sm sm:text-base lg:text-lg font-medium">Successful Cases</p>
                        </div>
                    </div>
                </div>

                <!-- CTA button responsive -->
                <div class="mt-10 lg:mt-12 text-center" data-aos="fade-up" data-aos-duration="1400" data-aos-delay="700">
                    <a href="pages/testimonials.php"
                        class="inline-flex items-center group bg-white border border-gray-200 hover:border-[#1C4D8D]/30 rounded-full transition-all duration-300">
                        <span class="text-base sm:text-lg lg:text-xl font-semibold text-[#0F2854] px-6 sm:px-8 py-3 sm:py-4">View All Testimonials</span>
                        <span class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform duration-300 shadow-md mr-1">
                            <i class="fas fa-arrow-right text-xs sm:text-sm lg:text-base"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--  Quarterly -->
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
                        <span class="text-[#0F2854]">Quarterly</span>
                    </h2>

                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mb-6" data-aos="fade-right-slow"
                        data-aos-duration="1200" data-aos-delay="400"></div>

                    <p class="text-gray-600 text-lg mb-6" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="500">
                        Get legal insights and business updates.
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

    <!-- FOOTER -->
   <?php include "includes/footer.php"; ?>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
    <!-- JS -->
    <script src="js/script.js"></script>

   


</body>

</html>