<?php require 'config.php';

// --- Hero ---
$stmt = $pdo->query("SELECT * FROM hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- About Us ---
$stmt = $pdo->query("SELECT * FROM about_us ORDER BY id ASC");
$about_us = $stmt->fetchAll();

// --- Services Areas ---
$stmt = $pdo->query("SELECT * FROM expertise_areas ORDER BY id ASC");
$Services = $stmt->fetchAll();

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
    <link rel="stylesheet" href="style.css">


</head>

<body>

    <!-- Navbar -->
    <?php include "includes/navbar.php"; ?>

    <!-- Main Section -->
    <section class="relative overflow-hidden min-h-[550px] md:min-h-[650px] flex items-center py-8 md:py-10">
        <!-- Fond principal -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1A1F2C] via-[#2A2F3C] to-[#1E2432]"></div>

        <!-- Texture subtile de papier / lin -->
        <div class="absolute inset-0 opacity-5 mix-blend-overlay"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\" 60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.15\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;">
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
            <!-- Search Bar -->
            <!-- <div class="max-w-2xl mx-auto mb-8 md:mb-10" data-aos="fade-down" data-aos-duration="800">
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#1C4D8D] to-[#D4B28C] rounded-full opacity-0 group-hover:opacity-30 blur transition duration-500"></div>
                    <div class="relative flex items-center bg-white/10 backdrop-blur-xl rounded-full border border-white/20 shadow-2xl hover:border-white/30 transition-all duration-300">
                        <div class="pl-5 pr-3">
                            <i class="fas fa-search text-white/60 text-sm"></i>
                        </div>
                        <input type="text"
                            placeholder="Search for legal Services, cases, or information..."
                            class="w-full py-3.5 pr-3 outline-none text-white placeholder-white/50 text-sm bg-transparent">
                        <button class="relative mr-2 group/btn">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#1C4D8D] to-[#2A5A9E] rounded-full opacity-90 group-hover/btn:opacity-100 transition-opacity duration-300 blur-[2px] group-hover/btn:blur-[3px]"></div>
                            <div class="relative flex items-center gap-2 bg-gradient-to-r from-[#1C4D8D] to-[#2A5A9E] text-white px-5 py-2.5 rounded-full text-sm font-medium
                                   hover:from-[#0F2854] hover:to-[#1C4D8D] transition-all duration-300 shadow-lg
                                   border border-white/20 hover:border-white/40">
                                <span>Search</span>
                                <i class="fas fa-arrow-right text-xs transform group-hover/btn:translate-x-0.5 transition-transform duration-300"></i>
                            </div>
                        </button>
                    </div>
                    <div class="absolute -bottom-5 left-5 text-[10px] text-white/30">
                        Press Enter to search
                    </div>
                </div>
            </div> -->

            <!-- Main content - Flex row -->
            <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-14 max-w-6xl mx-auto">
                <!-- Texte à gauche -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="mb-5" data-aos="fade-right" data-aos-delay="100">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-white/90 text-sm font-medium tracking-wide">
                            <span class="w-2 h-2 bg-[#D4B28C] rounded-full mr-2 animate-pulse"></span>
                            Legal excellence
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight mb-5"
                        data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                        <span class="text-white"><?= htmlspecialchars($hero['title'] ?? 'Strategic legal attorneys') ?></span>
                        <span class="text-[#1C4D8D]"> <?= htmlspecialchars($hero['subtitle'] ?? 'with commercial foresight') ?></span>
                    </h1>

                    <p class="text-lg sm:text-xl text-white/80 max-w-xl mb-7  leading-relaxed"
                        data-aos="fade-right" data-aos-delay="300">
                        <?= htmlspecialchars($hero['description'] ?? 'We help businesses resolve disputes, secure deals, and navigate risk through clear thinking, agile action, and strategic precision.') ?>
                    </p>

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

                    <div data-aos="fade-right" data-aos-delay="500">
                        <a href="pages/about us.php"
                            class="inline-flex items-center gap-4 group relative">
                            <span class="relative z-10 bg-[#1C4D8D] text-white px-8 py-3 rounded-full font-semibold text-base
                                   hover:bg-[#0F2854] transition-all duration-300 shadow-lg hover:shadow-xl
                                   group-hover:pr-12">
                                <?= htmlspecialchars($hero['button_label'] ?? 'Discover our Services') ?>
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

                <!-- Image à droite -->
                <?php if ($hero && !empty($hero['image_url'])): ?>
                    <div class="flex-1 relative max-w-xl lg:max-w-2xl" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="300">
                        <div class="relative z-10">
                            <img src="<?= htmlspecialchars($hero['image_url']) ?>"
                                alt="Hero Image"
                                class="w-full h-auto object-contain drop-shadow-2xl transform hover:scale-105 transition-transform duration-700 hero-image opacity-80 hover:opacity-100">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#D4B28C]/30 to-transparent rounded-full blur-3xl -z-10"></div>
                        <div class="absolute -top-8 -right-8 w-32 h-32 border border-[#D4B28C]/30 rounded-full"></div>
                        <div class="absolute -bottom-8 -left-8 w-48 h-48 border border-[#E5D3B0]/20 rounded-full"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[#D4B28C]/5 rounded-full blur-2xl"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="section py-16 md:py-20 lg:py-24 relative overflow-hidden">

        <!-- Arrière-plan stylisé avec motifs -->
        <div class="absolute inset-0 -z-10">
            <!-- Motif de base léger -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-50"></div>

            <!-- Cercles décoratifs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-[#1C4D8D]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#0F2854]/5 rounded-full blur-3xl"></div>

            <!-- Lignes diagonales élégantes (motif discret) -->
            <div class="absolute inset-0 opacity-[0.15]"
                style="background-image: repeating-linear-gradient(45deg, #1C4D8D 0px, #1C4D8D 1px, transparent 1px, transparent 20px);">
            </div>

            <!-- Points décoratifs subtils (motif) -->
            <div class="absolute inset-0 opacity-[0.2]"
                style="background-image: radial-gradient(#0F2854 1px, transparent 1px); background-size: 30px 30px;">
            </div>

            <!-- Formes géométriques -->
            <svg class="absolute top-40 right-20 w-64 h-64 opacity-[0.03]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 20 L80 20 L80 80 L20 80 Z" stroke="#0F2854" stroke-width="2" stroke-dasharray="5 5" />
                <circle cx="50" cy="50" r="30" stroke="#1C4D8D" stroke-width="2" stroke-dasharray="5 5" />
            </svg>

            <svg class="absolute bottom-40 left-20 w-48 h-48 opacity-[0.03]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,15 85,85 15,85" stroke="#0F2854" stroke-width="2" stroke-dasharray="4 4" />
                <rect x="35" y="35" width="30" height="30" stroke="#1C4D8D" stroke-width="2" stroke-dasharray="4 4" />
            </svg>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-6xl mx-auto">

                <!-- Title + Description -->
                <div class="mb-14">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">
                        <span class="text-[#0F2854]">About</span>
                        <span class="text-[#1C4D8D]"> Us</span>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl">
                        A Mauritian law firm founded by former Senior State Attorney,
                        combining government Services with private practice excellence.
                    </p>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mt-6"></div>
                </div>

                <!-- GRID -->
                <div class="grid lg:grid-cols-2 gap-12 items-stretch">

                    <!-- LEFT COLUMN -->
                    <div class="h-full flex">
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl border border-gray-200 flex flex-col w-full justify-between h-full shadow-lg shadow-gray-200/50">

                            <!-- Main Title -->
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#0F2854] mb-6">
                                From Attorney General's Office to Strategic Private Practice
                            </h3>

                            <!-- Cards -->
                            <div class="space-y-6 flex-grow flex flex-col">
                                <?php if (!empty($about_us)): ?>
                                    <?php foreach ($about_us as $section): ?>
                                        <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                            <p class="text-gray-700 leading-relaxed text-justify">
                                                <?= htmlspecialchars($section['content']) ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                        <p class="text-gray-700 leading-relaxed text-justify">
                                            Precision Law Firm was founded by
                                            <strong class="text-[#0F2854]">Mr. Jelend Chowrimootoo</strong>,
                                            Attorney-at-Law and former
                                            <strong class="text-[#0F2854]">Senior State Attorney</strong>.
                                            His career spans distinguished public service and private legal practice.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Services -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="text-xl font-bold text-[#0F2854] mb-2">
                                    Multi-Specialist
                                </div>
                                <div class="text-gray-600 mb-4">
                                    Civil, Commercial & Regulatory Law
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <?php if (!empty($Services)): ?>
                                        <?php foreach (array_slice($Services, 0, 3) as $area): ?>
                                            <span class="px-4 py-2 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full text-sm shadow-sm">
                                                <?= htmlspecialchars($area['name']) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="px-4 py-2 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full text-sm shadow-sm">Civil Law</span>
                                        <span class="px-4 py-2 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full text-sm shadow-sm">Commercial Law</span>
                                        <span class="px-4 py-2 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-full text-sm shadow-sm">Regulatory Law</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="h-full flex">
                        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl border border-gray-200 flex flex-col w-full justify-between h-full shadow-lg shadow-gray-200/50">

                            <!-- Main Title -->
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#0F2854] mb-4">
                                Public Service Experience
                            </h3>

                            <!-- Cards -->
                            <div class="space-y-6 flex-grow flex flex-col">
                                <?php if (!empty($public_service)): ?>
                                    <?php foreach ($public_service as $service): ?>
                                        <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                            <h5 class="font-semibold text-gray-800 mb-2">
                                                <?= htmlspecialchars($service['title']) ?>
                                            </h5>
                                            <p class="text-gray-600 text-sm text-justify">
                                                <?= htmlspecialchars($service['description']) ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                        <h5 class="font-semibold text-gray-800 mb-2">
                                            Government Representation
                                        </h5>
                                        <p class="text-gray-600 text-sm text-justify">
                                            Civil, commercial, constitutional and administrative litigation before courts and tribunals.
                                        </p>
                                    </div>

                                    <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                        <h5 class="font-semibold text-gray-800 mb-2">
                                            Legal Advisory
                                        </h5>
                                        <p class="text-gray-600 text-sm text-justify">
                                            Provided legal opinions and advice to government ministries and departments.
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <!-- Extra Card -->
                                <div class="p-6 bg-gradient-to-r from-[#0F2854]/10 to-[#1C4D8D]/10 backdrop-blur-sm rounded-xl border border-gray-200 flex-1">
                                    <h5 class="text-lg font-bold text-[#0F2854] mb-3">
                                        Core Values & Strategic Approach
                                    </h5>
                                    <ul class="space-y-2 text-gray-700 text-sm">
                                        <li class="flex items-start gap-2">
                                            <span class="text-[#1C4D8D] text-lg leading-5">•</span>
                                            <span>Integrity and ethical advocacy</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-[#1C4D8D] text-lg leading-5">•</span>
                                            <span>Strategic, solution-oriented thinking</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-[#1C4D8D] text-lg leading-5">•</span>
                                            <span>Client-focused representation</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-[#1C4D8D] text-lg leading-5">•</span>
                                            <span>Precision in legal drafting & litigation</span>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <!-- Button bottom aligned -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="pages/team.php"
                                    class="inline-block bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg">
                                    View Founder's Profile
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- Testimonials Section -->
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20px_20px,_#1C4D8D_1px,_transparent_1px)] bg-[length:40px_40px]"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Title + Description (column) -->
                <div class="flex flex-col items-start mb-10 md:mb-16 gap-4">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold">
                        <span class="text-[#0F2854]">Client</span>
                        <span class="text-[#1C4D8D]"> Testimonials</span>
                    </h2>
                    <div class="w-20 sm:w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mt-3"></div>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-xl">
                        What our clients say about working with Precision Law Firm
                    </p>
                </div>

                <!-- Testimonials Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $index => $test): ?>
                            <div class="bg-white p-6 sm:p-8 lg:p-10 rounded-xl border border-gray-100 hover:border-[#1C4D8D]/20 transition-all duration-300 group"
                                data-aos="fade-up" data-aos-duration="1400" data-aos-delay="<?= $index * 200 ?>">
                                <div class="mb-4 lg:mb-6">
                                    <div class="flex items-center mb-3 lg:mb-4">
                                        <div class="flex text-yellow-400 mr-2 text-base sm:text-lg lg:text-xl">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-xs sm:text-sm text-gray-500"><?= htmlspecialchars($test['rating'] ?? '5.0') ?></span>
                                    </div>
                                    <p class="text-gray-700 text-sm sm:text-base lg:text-lg italic leading-relaxed">
                                        "<?= htmlspecialchars($test['text'] ?? 'Excellent service and professional approach.') ?>"
                                    </p>
                                </div>
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
                        <!-- No testimonials message -->
                        <div class="col-span-full flex justify-center items-center py-16 lg:py-20">
                            <div class="text-center">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6">
                                    <i class="fas fa-comment-slash text-gray-400 text-3xl sm:text-4xl lg:text-5xl"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-700 mb-2">No Testimonials Yet</h3>
                                <p class="text-sm sm:text-base text-gray-500 max-w-md mx-auto">
                                    There are no testimonials available at the moment. Please check back later or contact us to share your experience.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Stats Section -->
                <div class="mt-12 lg:mt-16 bg-gradient-to-br from-blue-50 to-gray-50 rounded-xl p-6 sm:p-8 lg:p-10 border border-blue-100 transition-all duration-300" data-aos="fade-up" data-aos-duration="1600" data-aos-delay="300">
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

            </div>
        </div>
    </section>

    <!-- Quarterly Newsletter Section -->
    <section class="py-16 bg-white section-mt-5rem">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex flex-col md:flex-row items-center gap-8 max-w-5xl mx-auto" data-aos="fade-up-slow"
                data-aos-duration="1500">
                <!-- Left side: Icon -->
                <div class="md:w-2/5 flex justify-center" data-aos="zoom-slow" data-aos-duration="1400"
                    data-aos-delay="200">
                    <div
                        class="w-48 h-48 sm:w-56 sm:h-56 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center hover-lift transition-all duration-300">
                        <i class="fas fa-envelope text-6xl sm:text-7xl text-[#1C4D8D]"></i>
                    </div>
                </div>

                <!-- Right side: Content -->
                <div class="md:w-3/5 text-center md:text-left" data-aos="fade-left-slow" data-aos-duration="1400" data-aos-delay="300">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        <span class="text-[#0F2854]">Quarterly Newsletter</span>
                    </h2>

                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mb-6 mx-auto md:mx-0"></div>

                    <p class="text-gray-600 text-base sm:text-lg mb-6">
                        Get legal insights and business updates delivered to your inbox every quarter.
                    </p>

                    <form action="newsletter.php" method="POST" class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="email" placeholder="Enter your email" required
                            class="flex-1 px-4 sm:px-5 py-3 sm:py-4 rounded-lg border border-gray-300 focus:border-[#1C4D8D] focus:ring-1 focus:ring-[#1C4D8D] outline-none transition-all duration-300 text-sm sm:text-base">
                        <button type="submit"
                            class="bg-[#1C4D8D] text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 font-medium whitespace-nowrap hover-lift text-sm sm:text-base">
                            Subscribe
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include "includes/footer.php"; ?>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="js/script.js"></script>

</body>

</html>