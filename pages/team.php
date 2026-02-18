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
    <title>Our Team - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
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

                    <!-- Navigation - Increased text size -->
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
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
                            Our Team
                        </a>
                        <a href="expertise.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
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

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-3">
                <div class="flex flex-col space-y-4">
                    <a href="../accueil.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Home</a>
                    <a href="overview.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Overview</a>
                    <a href="team.php" class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">Our Team</a>
                    <a href="expertise.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Expertise</a>
                    <a href="jurisprudence.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Jurisprudence</a>
                    <a href="courses.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Courses</a>
                    <a href="appointment.php" class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">Appointment</a>
                    <a href="contact.php" class="bg-[#0A1F44] text-white px-4 py-3 rounded-md font-medium text-center mt-2 transition duration-300 text-base">Contact Us</a>
                </div>
            </div>
        </div>
    </nav>

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
                    <span>Our</span>
                    <span class="text-blue-100">Team</span>
                </h1>
                <div class="w-32 h-1 bg-gradient-to-r from-white to-blue-100 mx-auto mb-8" 
                     data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                </div>
                <p class="text-white text-xl md:text-2xl" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <?= htmlspecialchars($hero['subtitle'] ?? 'Strategic legal professionals combining government expertise with commercial insight') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Attorney at Law - Larger text -->
    <div class="container mx-auto px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="text-[#0F2854]">Attorney at Law</span>
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto"></div>
            </div>

            <!-- Founder's Card - Larger text -->
            <?php if (!empty($founder)): ?>
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 hover-lift transition-all duration-300" 
                 data-aos="zoom-slow" data-aos-duration="1400">
                <div class="flex flex-col md:flex-row items-center p-10">
                    <!-- Photo/Icon Area - Larger -->
                    <div class="mb-8 md:mb-0 md:mr-10">
                        <?php if (!empty($founder['photo_url'])): ?>
                            <img src="<?= htmlspecialchars($founder['photo_url']) ?>" 
                                 alt="<?= htmlspecialchars($founder['name']) ?>"
                                 class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-lg">
                        <?php else: ?>
                            <div class="w-40 h-40 rounded-full bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] flex items-center justify-center text-white">
                                <div class="text-4xl font-bold"><?= htmlspecialchars($founder['initials'] ?? 'JC') ?></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Info Area - Larger text -->
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($founder['name']) ?></h3>
                        <p class="text-[#1C4D8D] text-lg font-medium mb-3"><?= htmlspecialchars($founder['title']) ?></p>
                        <?php if (!empty($founder['former_position'])): ?>
                        <p class="text-gray-600 text-base mb-4"><?= htmlspecialchars($founder['former_position']) ?></p>
                        <?php endif; ?>

                        <div class="flex justify-center md:justify-start space-x-8">
                            <?php if (!empty($founder['experience_years'])): ?>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#0F2854]"><?= htmlspecialchars($founder['experience_years']) ?>+</div>
                                <div class="text-gray-500 text-sm">Years Experience</div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($founder['cases_handled'])): ?>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#0F2854]"><?= htmlspecialchars($founder['cases_handled']) ?>+</div>
                                <div class="text-gray-500 text-sm">Cases Handled</div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($founder['bio'])): ?>
                        <p class="text-gray-600 text-base mt-6 max-w-lg"><?= htmlspecialchars($founder['bio']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Fallback if no founder in database -->
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 hover-lift transition-all duration-300" data-aos="zoom-slow" data-aos-duration="1400">
                <div class="flex flex-col md:flex-row items-center p-10">
                    <div class="mb-8 md:mb-0 md:mr-10">
                        <div class="w-40 h-40 rounded-full bg-gradient-to-br from-[#0F2854] to-[#1C4D8D] flex items-center justify-center text-white">
                            <div class="text-4xl font-bold">JC</div>
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Me Jelend Chowrimootoo</h3>
                        <p class="text-[#1C4D8D] text-lg font-medium mb-3">Founder & Managing Director</p>
                        <p class="text-gray-600 text-base mb-4">Former Senior State Attorney, Attorney General's Office</p>
                        <div class="flex justify-center md:justify-start space-x-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#0F2854]">10+</div>
                                <div class="text-gray-500 text-sm">Years Experience</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#0F2854]">500+</div>
                                <div class="text-gray-500 text-sm">Cases Handled</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Legal Team Members - Larger text -->
    <div class="bg-gradient-to-b from-white to-gray-50 py-20">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        <span class="text-[#0F2854]">Our Legal Team</span>
                    </h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">Meet our team of dedicated legal professionals, each bringing specialized expertise to serve your needs.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if (!empty($teamMembers)): ?>
                        <?php foreach ($teamMembers as $index => $member): ?>
                        <div class="bg-white p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300"
                             data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= ($index % 3) * 100 ?>">
                            <div class="flex flex-col items-center text-center">
                                <?php if (!empty($member['photo_url'])): ?>
                                    <img src="<?= htmlspecialchars($member['photo_url']) ?>" 
                                         alt="<?= htmlspecialchars($member['name']) ?>"
                                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg mb-4">
                                <?php else: ?>
                                    <div class="w-24 h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-2xl">
                                        <?= htmlspecialchars($member['initials'] ?? substr($member['name'], 0, 1) . substr(explode(' ', $member['name'])[1] ?? '', 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <h4 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($member['name']) ?></h4>
                                <p class="text-[#1C4D8D] text-base font-medium mb-3"><?= htmlspecialchars($member['position']) ?></p>
                                <?php if (!empty($member['bio'])): ?>
                                <p class="text-gray-500 text-sm"><?= htmlspecialchars(substr($member['bio'], 0, 100)) ?>...</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback team members -->
                        <div class="bg-white p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-2xl">LA</div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Lorem Amet</h4>
                                <p class="text-[#1C4D8D] text-base font-medium mb-3">Senior Associate</p>
                            </div>
                        </div>
                        <div class="bg-white p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-2xl">CD</div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Consectetur Dolor</h4>
                                <p class="text-[#1C4D8D] text-base font-medium mb-3">Legal Counsel</p>
                            </div>
                        </div>
                        <div class="bg-white p-8 rounded-xl border border-gray-200 hover-lift transition-all duration-300" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center mb-4 text-white font-bold text-2xl">SI</div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Sit Ipsum</h4>
                                <p class="text-[#1C4D8D] text-base font-medium mb-3">Associate Attorney</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Stats - Larger text -->
    <div class="container mx-auto px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gradient-to-br from-blue-50 to-gray-50 rounded-xl p-10 border border-blue-100 hover-lift transition-all duration-300"
                 data-aos="fade-up-slow" data-aos-duration="1600">
                <div class="grid md:grid-cols-3 gap-10">
                    <?php if (!empty($teamStats)): ?>
                        <?php foreach ($teamStats as $index => $stat): ?>
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="<?= $index * 100 ?>">
                            <div class="text-5xl font-bold mb-3 text-[#0F2854]"><?= htmlspecialchars($stat['title']) ?></div>
                            <p class="text-[#1C4D8D] text-lg font-medium mb-2"><?= htmlspecialchars($stat['stat_text']) ?></p>
                            <p class="text-gray-500 text-base"><?= htmlspecialchars($stat['description']) ?></p>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback stats -->
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200">
                            <div class="text-5xl font-bold mb-3 text-[#0F2854]">Government</div>
                            <p class="text-[#1C4D8D] text-lg font-medium mb-2">Former Senior State Attorney Experience</p>
                            <p class="text-gray-500 text-base">Direct experience representing the State of Mauritius</p>
                        </div>
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="100">
                            <div class="text-5xl font-bold mb-3 text-[#0F2854]">Strategic</div>
                            <p class="text-[#1C4D8D] text-lg font-medium mb-2">Commercial Legal Insight</p>
                            <p class="text-gray-500 text-base">Practical solutions aligned with business objectives</p>
                        </div>
                        <div class="text-center" data-aos="fade-up-slow" data-aos-duration="1200" data-aos-delay="200">
                            <div class="text-5xl font-bold mb-3 text-[#0F2854]">Versatile</div>
                            <p class="text-[#1C4D8D] text-lg font-medium mb-2">Multi-Practice Expertise</p>
                            <p class="text-gray-500 text-base">Comprehensive legal services across diverse areas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section - Larger text -->
    <div class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <?php if (!empty($cta)): ?>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    <?= htmlspecialchars($cta['title']) ?>
                </h2>
                <p class="text-gray-600 text-lg mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    <?= htmlspecialchars($cta['description']) ?>
                </p>
                <a href="<?= htmlspecialchars($cta['button_link']) ?>" 
                   class="inline-flex items-center bg-[#1C4D8D] text-white px-8 py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-lg"
                   data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <span class="mr-3"><?= htmlspecialchars($cta['button_text']) ?></span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            <?php else: ?>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                    Work With Our Team
                </h2>
                <p class="text-gray-600 text-lg mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    Benefit from legal counsel backed by government-level experience and strategic commercial insight.
                </p>
                <a href="contact.php" 
                   class="inline-flex items-center bg-[#1C4D8D] text-white px-8 py-4 rounded-lg hover:bg-[#0F2854] transition-all duration-300 hover-lift text-lg"
                   data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <span class="mr-3">Contact Our Team</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            <?php endif; ?>
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
                        A premier Mauritian law firm founded by former Senior State Attorney, combining government
                        litigation expertise with strategic private practice.
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
            <div class="border-t border-blue-800 mt-10 pt-8 text-center text-gray-400 text-base">
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