<?php
require '../config.php';

// --- Fetch Team Hero ---
$stmt = $pdo->query("SELECT * FROM team_hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- Fetch Founder ---
$stmt = $pdo->query("SELECT * FROM founder WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 1");
$founder = $stmt->fetch();

// --- Fetch Team Members ---
$stmt = $pdo->query("SELECT * FROM team_members WHERE is_active = 1 ORDER BY sort_order ASC");
$teamMembers = $stmt->fetchAll();

// --- Fetch Team Stats ---
$stmt = $pdo->query("SELECT * FROM team_stats WHERE is_active = 1 ORDER BY sort_order ASC");
$teamStats = $stmt->fetchAll();

// --- Fetch Team CTA ---
$stmt = $pdo->query("SELECT * FROM team_cta WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$cta = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Partner - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        /* Pour les très petits écrans (moins de 400px) */
        @media (min-width: 400px) {
            .xs\:text-sm {
                font-size: 0.875rem;
            }

            .xs\:text-base {
                font-size: 1rem;
            }

            .xs\:text-3xl {
                font-size: 1.875rem;
            }

            .xs\:max-w-\[300px\] {
                max-width: 300px;
            }
        }

        /* Ajustements spécifiques pour mobile */
        @media (max-width: 640px) {
            .grid>div:last-child {
                grid-column: span 1;
            }
        }

        /* Pour que le dernier élément ne prenne pas toute la largeur sur très petit */
        @media (max-width: 480px) {
            .grid>div {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .btn-hover:hover .arrow-icon {
            transform: translateX(5px);
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

        .slow-transition {
            transition: all 0.5s ease;
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
    <?php include "../includes/navbar.php"; ?>

    <!-- Team Header - Larger text -->
    <div class="relative overflow-hidden py-24 text-center min-h-[500px] md:min-h-[550px] flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0">
                <img src="<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>"
                    alt="Precision Law Firm Team"
                    class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0F2854]/60 to-[#1C4D8D]/40"></div>
            </div>
        </div>

        <div class="container mx-auto px-6 z-10 relative">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-white" data-aos="fade-up-slow" data-aos-duration="1400">
                    <span>Founder</span>
                    <span class="text-blue-100">Partner</span>
                </h1>
                <div class="w-32 h-1 bg-gradient-to-r from-white to-blue-100 mx-auto mb-8"
                    data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                </div>
                <p class="text-white text-xl md:text-2xl" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <?= htmlspecialchars($hero['subtitle'] ?? 'Strategic legal professionals combining government Services with commercial insight') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Attorney at Law Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 md:mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                    <span class="text-[#0F2854]">Attorney at Law</span>
                </h2>
                <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto"></div>
            </div>

            <!-- Founder's Card - Responsive -->
            <?php if (!empty($founder)): ?>
                <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 hover-lift transition-all duration-300"
                    data-aos="zoom-slow" data-aos-duration="1400">
                    <div class="flex flex-col md:flex-row items-center p-6 sm:p-8 md:p-10">
                        <!-- Photo/Icon Area -->
                        <div class="mb-6 md:mb-0 md:mr-8 lg:mr-10">
                            <?php if (!empty($founder['photo_url'])): ?>
                                <img src="<?= htmlspecialchars($founder['photo_url']) ?>"
                                    alt="<?= htmlspecialchars($founder['name']) ?>"
                                    class="w-32 h-32 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-lg">
                            <?php else: ?>
                                <div class="w-32 h-32 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] flex items-center justify-center text-white">
                                    <div class="text-3xl sm:text-4xl font-bold"><?= htmlspecialchars($founder['initials'] ?? 'JC') ?></div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info Area -->
                        <div class="text-center md:text-left">
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($founder['name']) ?></h3>
                            <p class="text-[#1C4D8D] text-base sm:text-lg font-medium mb-3"><?= htmlspecialchars($founder['title']) ?></p>
                            <?php if (!empty($founder['former_position'])): ?>
                                <p class="text-gray-600 text-sm sm:text-base mb-4"><?= htmlspecialchars($founder['former_position']) ?></p>
                            <?php endif; ?>

                            <div class="flex justify-center md:justify-start space-x-6 sm:space-x-8">
                                <?php if (!empty($founder['experience_years'])): ?>
                                    <div class="text-center">
                                        <div class="text-xl sm:text-2xl font-bold text-[#0F2854]"><?= htmlspecialchars($founder['experience_years']) ?>+</div>
                                        <div class="text-gray-500 text-xs sm:text-sm">Years Experience</div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($founder['cases_handled'])): ?>
                                    <div class="text-center">
                                        <div class="text-xl sm:text-2xl font-bold text-[#0F2854]"><?= htmlspecialchars($founder['cases_handled']) ?>+</div>
                                        <div class="text-gray-500 text-xs sm:text-sm">Cases Handled</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($founder['bio'])): ?>
                                <p class="text-gray-600 text-sm sm:text-base mt-5 md:mt-6 max-w-lg "><?= htmlspecialchars($founder['bio']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Fallback if no founder in database -->
                <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 hover-lift transition-all duration-300" data-aos="zoom-slow" data-aos-duration="1400">
                    <div class="flex flex-col md:flex-row items-center p-6 sm:p-8 md:p-10">
                        <div class="mb-6 md:mb-0 md:mr-8 lg:mr-10">
                            <div class="w-32 h-32 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] flex items-center justify-center text-white">
                                <div class="text-3xl sm:text-4xl font-bold">JC</div>
                            </div>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2">Me Jelend Chowrimootoo</h3>
                            <p class="text-[#1C4D8D] text-base sm:text-lg font-medium mb-3">Founder & Managing Director</p>
                            <p class="text-gray-600 text-sm sm:text-base mb-4">Former Senior State Attorney, Attorney General's Office</p>
                            <div class="flex justify-center md:justify-start space-x-6 sm:space-x-8">
                                <div class="text-center">
                                    <div class="text-xl sm:text-2xl font-bold text-[#0F2854]">10+</div>
                                    <div class="text-gray-500 text-xs sm:text-sm">Years Experience</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-xl sm:text-2xl font-bold text-[#0F2854]">500+</div>
                                    <div class="text-gray-500 text-xs sm:text-sm">Cases Handled</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Legal Team Members Section -->
    <!-- <div class="bg-gradient-to-b from-white to-gray-50 py-16 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12 md:mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        <span class="text-[#0F2854]">Our Legal Team</span>
                    </h2>
                    <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-5 md:mb-6"></div>
                    <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4">Meet Our Partner of dedicated legal professionals, each bringing specialized Services to serve your needs.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <?php if (!empty($teamMembers)): ?>
                        <?php foreach ($teamMembers as $index => $member): ?>
                            <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300"
                                data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= ($index % 3) * 100 ?>">
                                <div class="flex flex-col items-center text-center">
                                    <?php if (!empty($member['photo_url'])): ?>
                                        <img src="<?= htmlspecialchars($member['photo_url']) ?>"
                                            alt="<?= htmlspecialchars($member['name']) ?>"
                                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-white shadow-lg mb-4">
                                    <?php else: ?>
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-xl sm:text-2xl">
                                            <?= htmlspecialchars($member['initials'] ?? substr($member['name'], 0, 1) . substr(explode(' ', $member['name'])[1] ?? '', 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($member['name']) ?></h4>
                                    <p class="text-[#1C4D8D] text-sm sm:text-base font-medium mb-3"><?= htmlspecialchars($member['position']) ?></p>
                                    <?php if (!empty($member['bio'])): ?>
                                        <p class="text-gray-500 text-xs sm:text-sm "><?= htmlspecialchars(substr($member['bio'], 0, 100)) ?>...</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback team members -->
                        <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-xl sm:text-2xl">LA</div>
                                <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">Lorem Amet</h4>
                                <p class="text-[#1C4D8D] text-sm sm:text-base font-medium mb-3">Senior Associate</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-xl sm:text-2xl">CD</div>
                                <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">Consectetur Dolor</h4>
                                <p class="text-[#1C4D8D] text-sm sm:text-base font-medium mb-3">Legal Counsel</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-xl sm:text-2xl">SI</div>
                                <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">Sit Ipsum</h4>
                                <p class="text-[#1C4D8D] text-sm sm:text-base font-medium mb-3">Associate Attorney</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div> -->


    <!-- Team Stats Section - VRAIMENT responsive -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gradient-to-br from-blue-50 to-gray-50 rounded-xl p-5 sm:p-6 md:p-8 lg:p-10 border border-blue-100 transition-all duration-300"
                data-aos="fade-up-slow" data-aos-duration="1600">

                <!-- Grid complètement responsive -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-5 md:gap-6 lg:gap-8">

                    <?php if (!empty($teamStats)): ?>
                        <?php foreach ($teamStats as $index => $stat): ?>
                            <!-- Stat Card -->
                            <div class="text-center px-2 sm:px-0 <?= $index >= 2 ? 'sm:col-span-2 lg:col-span-1' : '' ?>"
                                data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="<?= $index * 100 ?>">

                                <!-- Title - taille progressive -->
                                <div class="text-2xl xs:text-3xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 text-[#0F2854] leading-tight">
                                    <?= htmlspecialchars($stat['title']) ?>
                                </div>

                                <!-- Stat text - taille progressive -->
                                <p class="text-[#1C4D8D] text-sm xs:text-base sm:text-sm md:text-base lg:text-lg font-medium mb-1 px-2">
                                    <?= htmlspecialchars($stat['stat_text']) ?>
                                </p>

                                <!-- Description - taille progressive -->
                                <p class="text-gray-500 text-xs xs:text-sm sm:text-xs md:text-sm lg:text-base max-w-[250px] xs:max-w-[300px] sm:max-w-none mx-auto">
                                    <?= htmlspecialchars($stat['description']) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <!-- Fallback stats avec gestion spéciale pour mobile -->

                        <!-- Stat 1 - Government -->
                        <div class="text-center px-2 sm:px-0" data-aos="fade-up-slow" data-aos-duration="1200">
                            <div class="text-2xl xs:text-3xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 text-[#0F2854] leading-tight">
                                Government
                            </div>
                            <p class="text-[#1C4D8D] text-sm xs:text-base sm:text-sm md:text-base lg:text-lg font-medium mb-1 px-2">
                                Former Senior State Attorney Experience
                            </p>
                            <p class="text-gray-500 text-xs xs:text-sm sm:text-xs md:text-sm lg:text-base max-w-[250px] xs:max-w-[300px] sm:max-w-none mx-auto">
                                Direct experience representing the State of Mauritius
                            </p>
                        </div>

                        <!-- Stat 2 - Strategic -->
                        <div class="text-center px-2 sm:px-0" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="100">
                            <div class="text-2xl xs:text-3xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 text-[#0F2854] leading-tight">
                                Strategic
                            </div>
                            <p class="text-[#1C4D8D] text-sm xs:text-base sm:text-sm md:text-base lg:text-lg font-medium mb-1 px-2">
                                Commercial Legal Insight
                            </p>
                            <p class="text-gray-500 text-xs xs:text-sm sm:text-xs md:text-sm lg:text-base max-w-[250px] xs:max-w-[300px] sm:max-w-none mx-auto">
                                Practical solutions aligned with business objectives
                            </p>
                        </div>

                        <!-- Stat 3 - Versatile (sur toute la largeur sur mobile) -->
                        <div class="text-center px-2 sm:px-0 sm:col-span-2 lg:col-span-1" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="200">
                            <div class="text-2xl xs:text-3xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 text-[#0F2854] leading-tight">
                                Versatile
                            </div>
                            <p class="text-[#1C4D8D] text-sm xs:text-base sm:text-sm md:text-base lg:text-lg font-medium mb-1 px-2">
                                Multi-Practice Services
                            </p>
                            <p class="text-gray-500 text-xs xs:text-sm sm:text-xs md:text-sm lg:text-base max-w-[250px] xs:max-w-[300px] sm:max-w-none mx-auto">
                                Comprehensive legal services across diverse areas
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- CTA Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="max-w-4xl mx-auto text-center">
            <?php if (!empty($cta)): ?>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    <?= htmlspecialchars($cta['title']) ?>
                </h2>
                <p class="text-gray-600 text-sm sm:text-base md:text-lg mb-6 md:mb-10 max-w-2xl mx-auto px-4 " data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    <?= htmlspecialchars($cta['description']) ?>
                </p>
                <a href="<?= htmlspecialchars($cta['button_link']) ?>"
                    class="inline-flex items-center bg-[#1C4D8D] text-white px-6 md:px-8 py-3 md:py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-sm sm:text-base md:text-lg"
                    data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <span class="mr-2 md:mr-3"><?= htmlspecialchars($cta['button_text']) ?></span>
                    <i class="fas fa-arrow-right text-sm md:text-base"></i>
                </a>
            <?php else: ?>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    Work With Us
                </h2>
                <p class="text-gray-600 text-sm sm:text-base md:text-lg mb-6 md:mb-10 max-w-2xl mx-auto px-4 " data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    Benefit from legal counsel backed by government-level experience and strategic commercial insight.
                </p>
                <a href="contact.php"
                    class="inline-flex items-center bg-[#1C4D8D] text-white px-6 md:px-8 py-3 md:py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-sm sm:text-base md:text-lg"
                    data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <span class="mr-2 md:mr-3">Contact Our Partner</span>
                    <i class="fas fa-arrow-right text-sm md:text-base"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer - Larger text -->
    <?php include "../includes/footer.php"; ?>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script src="../js/script.js"></script>
</body>

</html>