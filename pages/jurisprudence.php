<?php
require '../config.php';

// --- Fetch Jurisprudence Hero ---
$stmt = $pdo->query("SELECT * FROM jurisprudence_hero ORDER BY id DESC LIMIT 1");
$hero = $stmt->fetch();

// --- Fetch Statistics ---
$stmt = $pdo->query("SELECT * FROM jurisprudence_stats WHERE is_active = 1 ORDER BY sort_order ASC");
$stats = $stmt->fetchAll();

// --- Fetch Categories ---
$stmt = $pdo->query("SELECT * FROM jurisprudence_categories WHERE is_active = 1 ORDER BY sort_order ASC");
$categories = $stmt->fetchAll();

// --- Fetch Featured Cases ---
$stmt = $pdo->query("SELECT c.*, cat.name as category_name, cat.slug, cat.icon as category_icon 
                     FROM jurisprudence_cases c 
                     LEFT JOIN jurisprudence_categories cat ON c.category_id = cat.id 
                     WHERE c.is_active = 1 
                     ORDER BY c.featured DESC, c.sort_order ASC, c.year DESC");
$cases = $stmt->fetchAll();

// Group cases by category for filtering
$caseCategories = [];
foreach ($cases as $case) {
    if ($case['category_id']) {
        $caseCategories[$case['category_id']] = true;
    }
}

// --- Fetch Timeline Milestones ---
$stmt = $pdo->query("SELECT * FROM jurisprudence_timeline WHERE is_active = 1 ORDER BY year DESC, sort_order ASC");
$timeline = $stmt->fetchAll();

// --- Fetch CTA Section ---
$stmt = $pdo->query("SELECT * FROM jurisprudence_cta WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$cta = $stmt->fetch();

// Function to get color classes
function getColorClasses($color)
{
    $colors = [
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-[#1C4D8D]', 'border' => 'border-[#1C4D8D]', 'light' => 'bg-blue-100'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-700', 'light' => 'bg-purple-100'],
        'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-700', 'light' => 'bg-orange-100'],
        'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-700', 'light' => 'bg-green-100'],
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-700', 'light' => 'bg-red-100']
    ];
    return $colors[$color] ?? $colors['blue'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurisprudence - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Hero Section with Dark Overlay */
        .hero-section {
            background: linear-gradient(rgba(79, 79, 79, 0.132), rgba(0, 0, 0, 0.7)), url('<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>');
            background-size: cover;
            background-position: center;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }

        /* Card Hover Effects */
        .case-card {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            position: relative;
        }

        .case-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(28, 77, 141, 0.15);
            border-color: #1C4D8D;
        }

        .case-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #1C4D8D, transparent);
            transition: left 0.6s ease;
        }

        .case-card:hover::before {
            left: 100%;
        }

        /* Category Filter Buttons */
        .category-btn {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 1rem;
        }

        .category-btn:hover {
            border-color: #1C4D8D;
            color: #1C4D8D;
            transform: translateY(-2px);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(28, 77, 141, 0.2);
        }

        /* Animated Badge */
        .animated-badge {
            animation: pulse 2s infinite;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            font-size: 1rem;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(28, 77, 141, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(28, 77, 141, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(28, 77, 141, 0);
            }
        }

        /* Stat Counter Animation */
        .stat-counter {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
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

        /* Section Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
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

    <!-- Navigation - Increased text size -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4 shadow-sm">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="text-[#D4AF37] font-bold text-2xl tracking-tight">
                    <i class="fas fa-balance-scale mr-2"></i>Precision Law Firm
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../accueil.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Home
                    </a>
                    <a href="overview.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Overview
                    </a>
                    <a href="team.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Our Team
                    </a>
                    <a href="expertise.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Expertise
                    </a>
                    <a href="jurisprudence.php"
                        class="text-[#D4AF37] font-semibold transition duration-300 text-base border-b-2 border-[#D4AF37]">
                        Jurisprudence
                    </a>
                    <a href="courses.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Courses
                    </a>
                    <a href="appointment.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base">
                        Appointment
                    </a>
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-6 py-3 rounded-full font-medium hover:opacity-90 transition duration-300 text-base">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-4">
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
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Expertise
                    </a>
                    <a href="jurisprudence.php"
                        class="text-[#D4AF37] font-semibold transition duration-300 text-base py-2">
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
                        class="bg-[#0A1F44] text-white px-4 py-3 rounded-md font-medium text-center transition duration-300 text-base">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Larger text -->
    <section class="hero-section">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto text-center">
                <span class="animated-badge mb-6 inline-block" data-aos="fade-up-slow" data-aos-duration="1400">
                    <i class="fas fa-gavel mr-2"></i><?= htmlspecialchars($hero['badge_text'] ?? 'Landmark Cases') ?>
                </span>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <?= htmlspecialchars($hero['title'] ?? 'Our Jurisprudence') ?>
                </h1>

                <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                    <?= htmlspecialchars($hero['subtitle'] ?? 'Discover landmark cases and significant legal precedents handled by our firm. Each case represents our commitment to excellence in legal strategy and advocacy.') ?>
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="400">
                    <a href="#featured-cases"
                        class="bg-white text-[#0F2854] px-10 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 inline-flex items-center justify-center text-lg">
                        <i class="fas fa-book-open mr-3"></i> Explore Cases
                    </a>
                    <a href="#stats"
                        class="border-2 border-white text-white px-10 py-4 rounded-xl font-semibold hover:bg-white/20 transition duration-300 inline-flex items-center justify-center text-lg">
                        <i class="fas fa-chart-bar mr-3"></i> View Statistics
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section - Larger text -->
    <section id="stats" class="py-20 bg-gradient-to-b from-white to-gray-50 pattern-bg">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <?php if (!empty($stats)): ?>
                    <?php foreach ($stats as $index => $stat): ?>
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300"
                            data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
                            <div class="stat-counter mb-2" data-count="<?= preg_replace('/[^0-9]/', '', $stat['value']) ?>"><?= htmlspecialchars($stat['value']) ?><?= htmlspecialchars($stat['suffix']) ?></div>
                            <p class="text-gray-600 text-lg font-medium"><?= htmlspecialchars($stat['label']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback stats -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="100">
                        <div class="stat-counter mb-2" data-count="150">150+</div>
                        <p class="text-gray-600 text-lg font-medium">Cases Handled</p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-counter mb-2" data-count="95">95%</div>
                        <p class="text-gray-600 text-lg font-medium">Success Rate</p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-counter mb-2" data-count="25">25+</div>
                        <p class="text-gray-600 text-lg font-medium">Years Experience</p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="400">
                        <div class="stat-counter mb-2" data-count="12">12+</div>
                        <p class="text-gray-600 text-lg font-medium">Landmark Precedents</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Case Filter - Larger text -->
    <section class="py-12 bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h3 class="text-3xl font-bold text-[#0F2854] mb-3">Filter by Practice Area</h3>
                    <p class="text-gray-600 text-lg">Select a category to view relevant cases</p>
                </div>

                <div class="flex flex-wrap gap-3 justify-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    <button class="category-btn active" data-category="all">
                        <i class="fas fa-layer-group mr-2"></i>All Cases
                    </button>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <button class="category-btn" data-category="<?= htmlspecialchars($category['slug']) ?>">
                                <i class="fas <?= htmlspecialchars($category['icon'] ?? 'fa-folder') ?> mr-2"></i><?= htmlspecialchars($category['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback categories -->
                        <button class="category-btn" data-category="commercial"><i class="fas fa-briefcase mr-2"></i>Commercial Law</button>
                        <button class="category-btn" data-category="constitutional"><i class="fas fa-landmark mr-2"></i>Constitutional Law</button>
                        <button class="category-btn" data-category="civil"><i class="fas fa-balance-scale mr-2"></i>Civil Litigation</button>
                        <button class="category-btn" data-category="employment"><i class="fas fa-users mr-2"></i>Employment Law</button>
                        <button class="category-btn" data-category="property"><i class="fas fa-home mr-2"></i>Property Law</button>
                        <button class="category-btn" data-category="corporate"><i class="fas fa-building mr-2"></i>Corporate Law</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cases Section - Larger text -->
    <section id="featured-cases" class="py-24 bg-gray-50 pattern-bg">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F2854] mb-4">Landmark Cases & Precedents</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-gray-600 text-xl max-w-2xl mx-auto">Significant legal matters where our strategic approach made a decisive impact</p>
                </div>

                <div class="space-y-8">
                    <?php if (!empty($cases)): ?>
                        <?php foreach ($cases as $index => $case):
                            $colors = getColorClasses($case['icon_color'] ?? 'blue');
                            $categorySlug = '';
                            // RECHERCHE DU SLUG DE CATÉGORIE - CORRIGÉ
                            foreach ($categories as $cat) {
                                if (isset($cat['id']) && $cat['id'] == $case['category_id']) {
                                    $categorySlug = $cat['slug'];
                                    break;
                                }
                            }
                        ?>
                            <div class="case-card bg-white rounded-2xl p-8 reveal" data-category="<?= $categorySlug ?>" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                <div class="flex flex-col lg:flex-row gap-8">
                                    <div class="lg:w-1/3">
                                        <div class="bg-gradient-to-br from-<?= $colors['bg'] ?> to-gray-50 p-6 rounded-xl h-full">
                                            <div class="mb-6">
                                                <div class="flex items-center justify-between mb-4">
                                                    <span class="<?= $colors['light'] ?> <?= $colors['text'] ?> text-base font-semibold px-3 py-1 rounded-full">
                                                        <?= $case['year'] ?> • <?= htmlspecialchars($case['court'] ?? 'Court') ?>
                                                    </span>
                                                    <?php if ($case['duration_months']): ?>
                                                        <span class="text-sm text-gray-500">
                                                            <i class="fas fa-clock mr-1"></i><?= $case['duration_months'] ?> months
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($case['title']) ?></h3>
                                                <div class="flex flex-wrap gap-2">
                                                    <?php
                                                    // CORRIGÉ : Utiliser category_name qui vient de la jointure
                                                    if (!empty($case['category_name'])) {
                                                        $catNames = explode(',', $case['category_name']);
                                                        foreach ($catNames as $catName):
                                                    ?>
                                                            <span class="text-sm <?= $colors['light'] ?> <?= $colors['text'] ?> px-3 py-1 rounded-full"><?= htmlspecialchars(trim($catName)) ?></span>
                                                    <?php
                                                        endforeach;
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="text-base text-gray-600">
                                                <?php if ($case['case_number']): ?>
                                                    <div class="flex items-center mb-2">
                                                        <i class="fas fa-file-alt <?= $colors['text'] ?> mr-2"></i>
                                                        <span>Case No: <?= htmlspecialchars($case['case_number']) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex items-center">
                                                    <i class="fas fa-user-tie <?= $colors['text'] ?> mr-2"></i>
                                                    <span>Lead Attorney: <?= htmlspecialchars($case['lead_attorney'] ?? 'Me') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:w-2/3">
                                        <h4 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($case['title']) ?></h4>
                                        <div class="space-y-4 text-gray-700 text-base">
                                            <p>
                                                <?= htmlspecialchars($case['summary']) ?>
                                            </p>

                                            <?php if ($case['key_issues']): ?>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="<?= $colors['bg'] ?> p-4 rounded-lg">
                                                        <p class="text-base font-semibold <?= $colors['text'] ?> mb-2">
                                                            <i class="fas fa-gavel mr-2"></i>Key Legal Issues:
                                                        </p>
                                                        <ul class="text-base text-gray-600 space-y-1">
                                                            <?php
                                                            $issues = explode(',', $case['key_issues']);
                                                            foreach ($issues as $issue):
                                                            ?>
                                                                <li class="flex items-start">
                                                                    <i class="fas fa-check-circle <?= $colors['text'] ?> text-sm mt-1 mr-2"></i>
                                                                    <span><?= htmlspecialchars(trim($issue)) ?></span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>

                                                    <?php if ($case['outcome']): ?>
                                                        <div class="bg-green-50 p-4 rounded-lg">
                                                            <p class="text-base font-semibold text-green-700 mb-2">
                                                                <i class="fas fa-trophy mr-2"></i>Case Outcome:
                                                            </p>
                                                            <ul class="text-base text-gray-600 space-y-1">
                                                                <?php
                                                                $outcomes = explode(',', $case['outcome']);
                                                                foreach ($outcomes as $outcome):
                                                                ?>
                                                                    <li class="flex items-start">
                                                                        <i class="fas fa-check text-green-600 text-sm mt-1 mr-2"></i>
                                                                        <span><?= htmlspecialchars(trim($outcome)) ?></span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                                <?php if ($case['impact']): ?>
                                                    <span class="text-base font-medium <?= $colors['text'] ?>">
                                                        <i class="fas fa-star mr-1"></i><?= htmlspecialchars($case['impact']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <a href="#" class="<?= $colors['text'] ?> font-medium hover:opacity-80 transition text-base">
                                                    Read Full Case Study <i class="fas fa-arrow-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback case -->
                        <div class="case-card bg-white rounded-2xl p-8 reveal" data-category="commercial corporate" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="lg:w-1/3">
                                    <div class="bg-gradient-to-br from-blue-50 to-gray-50 p-6 rounded-xl h-full">
                                        <div class="mb-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="bg-blue-100 text-[#1C4D8D] text-base font-semibold px-3 py-1 rounded-full">2023 • Supreme Court</span>
                                                <span class="text-sm text-gray-500"><i class="fas fa-clock mr-1"></i>6 months</span>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-800 mb-2">Doe v. Mauritius Commercial Bank</h3>
                                            <div class="flex flex-wrap gap-2">
                                                <span class="text-sm bg-blue-100 text-[#1C4D8D] px-3 py-1 rounded-full">Banking Law</span>
                                                <span class="text-sm bg-blue-100 text-[#1C4D8D] px-3 py-1 rounded-full">Contract Law</span>
                                            </div>
                                        </div>
                                        <div class="text-base text-gray-600">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-file-alt text-[#1C4D8D] mr-2"></i>
                                                <span>Case No: SCJ 2023-45</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie text-[#1C4D8D] mr-2"></i>
                                                <span>Lead Attorney: Maître Jean Dupont</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:w-2/3">
                                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Redefining Banking Liability in Digital Transactions</h4>
                                    <p class="text-base text-gray-700 mb-4">This landmark case established new standards for bank liability in unauthorized digital transactions. Our firm successfully argued for expanded consumer protection in the rapidly evolving digital banking landscape.</p>
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                        <span class="text-base font-medium text-[#1C4D8D]"><i class="fas fa-star mr-1"></i>Landmark Precedent Established</span>
                                        <a href="#" class="text-[#1C4D8D] font-medium hover:opacity-80 transition text-base">Read Full Case Study <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section - Design Amélioré -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F2854] mb-4">Our Legal Journey</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-gray-600 text-xl max-w-2xl mx-auto">Key milestones and landmark cases that shaped our practice</p>
                </div>

                <div class="relative">
                    <!-- Timeline Line with Gradient -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-[#1C4D8D] via-[#0F2854] to-[#1C4D8D] rounded-full"></div>

                    <!-- Timeline Items -->
                    <div class="space-y-16">
                        <?php if (!empty($timeline)): ?>
                            <?php foreach ($timeline as $index => $item):
                                $colors = getColorClasses($item['color'] ?? 'blue');
                                $position = ($index % 2 == 0) ? 'left' : 'right';
                            ?>
                                <div class="relative" data-aos="<?= ($position == 'left') ? 'fade-right-slow' : 'fade-left-slow' ?>" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                    <div class="flex flex-col md:flex-row items-center <?= ($position == 'left') ? 'md:flex-row' : 'md:flex-row-reverse' ?>">
                                        <!-- Content -->
                                        <div class="md:w-5/12 <?= ($position == 'left') ? 'md:text-right md:pr-12' : 'md:text-left md:pl-12' ?>">
                                            <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-[#1C4D8D] hover-lift">
                                                <!-- Year Badge -->
                                                <div class="inline-block px-4 py-2 rounded-full <?= $colors['light'] ?> <?= $colors['text'] ?> font-bold text-sm mb-4">
                                                    <i class="fas fa-calendar-alt mr-2"></i><?= $item['year'] ?>
                                                </div>

                                                <!-- Title -->
                                                <h3 class="text-2xl font-bold text-gray-800 mb-3 flex items-center <?= ($position == 'left') ? 'justify-end' : 'justify-start' ?>">
                                                    <?php if ($position == 'right'): ?>
                                                        <i class="fas <?= htmlspecialchars($item['icon'] ?? 'fa-star') ?> <?= $colors['text'] ?> mr-3"></i>
                                                    <?php endif; ?>
                                                    <?= htmlspecialchars($item['title']) ?>
                                                    <?php if ($position == 'left'): ?>
                                                        <i class="fas <?= htmlspecialchars($item['icon'] ?? 'fa-star') ?> <?= $colors['text'] ?> ml-3"></i>
                                                    <?php endif; ?>
                                                </h3>

                                                <!-- Description -->
                                                <p class="text-gray-600 text-base leading-relaxed"><?= htmlspecialchars($item['description']) ?></p>

                                                <!-- Decorative elements -->
                                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-white rotate-45 border-r border-b border-gray-200"></div>
                                            </div>
                                        </div>

                                        <!-- Center Point with Icon -->
                                        <div class="md:w-2/12 flex justify-center relative z-10 my-4 md:my-0">
                                            <div class="relative">
                                                <!-- Pulse Animation -->
                                                <div class="absolute inset-0 rounded-full animate-ping opacity-20 <?= $colors['light'] ?>"></div>
                                                <!-- Main Icon -->
                                                <div class="w-16 h-16 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl transform hover:scale-110 transition-all duration-500">
                                                    <i class="fas <?= htmlspecialchars($item['icon'] ?? 'fa-star') ?> text-white text-xl"></i>
                                                </div>
                                                <!-- Year on hover (tooltip) -->
                                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap bg-gray-900 text-white px-3 py-1 rounded-full text-sm">
                                                    <?= $item['year'] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Spacer for right column -->
                                        <div class="md:w-5/12"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback timeline items with improved design -->
                            <div class="relative" data-aos="fade-right-slow" data-aos-duration="1400">
                                <div class="flex flex-col md:flex-row items-center">
                                    <!-- Left Content -->
                                    <div class="md:w-5/12 md:text-right md:pr-12">
                                        <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-[#1C4D8D] hover-lift">
                                            <div class="inline-block px-4 py-2 rounded-full bg-blue-100 text-[#1C4D8D] font-bold text-sm mb-4">
                                                <i class="fas fa-calendar-alt mr-2"></i>2023
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-3 flex items-center justify-end">
                                                Digital Banking Precedent
                                                <i class="fas fa-mobile-alt text-[#1C4D8D] ml-3"></i>
                                            </h3>
                                            <p class="text-gray-600 text-base leading-relaxed">Established new standards for consumer protection in digital transactions, setting a landmark precedent in Mauritian banking law.</p>
                                        </div>
                                    </div>

                                    <!-- Center Point -->
                                    <div class="md:w-2/12 flex justify-center relative z-10 my-4 md:my-0">
                                        <div class="relative group">
                                            <div class="absolute inset-0 rounded-full animate-ping bg-blue-200 opacity-20"></div>
                                            <div class="w-16 h-16 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-all duration-500">
                                                <i class="fas fa-mobile-alt text-white text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Spacer -->
                                    <div class="md:w-5/12"></div>
                                </div>
                            </div>

                            <div class="relative" data-aos="fade-left-slow" data-aos-duration="1400" data-aos-delay="100">
                                <div class="flex flex-col md:flex-row items-center md:flex-row-reverse">
                                    <!-- Right Content -->
                                    <div class="md:w-5/12 md:text-left md:pl-12">
                                        <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-purple-600 hover-lift">
                                            <div class="inline-block px-4 py-2 rounded-full bg-purple-100 text-purple-700 font-bold text-sm mb-4">
                                                <i class="fas fa-calendar-alt mr-2"></i>2022
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-3 flex items-center">
                                                <i class="fas fa-comments text-purple-700 mr-3"></i>
                                                Free Speech Expansion
                                            </h3>
                                            <p class="text-gray-600 text-base leading-relaxed">Redefined constitutional protections for digital expression, expanding free speech rights in the online sphere.</p>
                                        </div>
                                    </div>

                                    <!-- Center Point -->
                                    <div class="md:w-2/12 flex justify-center relative z-10 my-4 md:my-0">
                                        <div class="relative group">
                                            <div class="absolute inset-0 rounded-full animate-ping bg-purple-200 opacity-20"></div>
                                            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-all duration-500">
                                                <i class="fas fa-comments text-white text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Left Spacer -->
                                    <div class="md:w-5/12"></div>
                                </div>
                            </div>

                            <div class="relative" data-aos="fade-right-slow" data-aos-duration="1400" data-aos-delay="200">
                                <div class="flex flex-col md:flex-row items-center">
                                    <!-- Left Content -->
                                    <div class="md:w-5/12 md:text-right md:pr-12">
                                        <div class="bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-orange-500 hover-lift">
                                            <div class="inline-block px-4 py-2 rounded-full bg-orange-100 text-orange-700 font-bold text-sm mb-4">
                                                <i class="fas fa-calendar-alt mr-2"></i>2021
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-3 flex items-center justify-end">
                                                Workplace Rights Milestone
                                                <i class="fas fa-briefcase text-orange-700 ml-3"></i>
                                            </h3>
                                            <p class="text-gray-600 text-base leading-relaxed">Set new standards for employment discrimination cases, strengthening worker protections across Mauritius.</p>
                                        </div>
                                    </div>

                                    <!-- Center Point -->
                                    <div class="md:w-2/12 flex justify-center relative z-10 my-4 md:my-0">
                                        <div class="relative group">
                                            <div class="absolute inset-0 rounded-full animate-ping bg-orange-200 opacity-20"></div>
                                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-700 rounded-full flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-all duration-500">
                                                <i class="fas fa-briefcase text-white text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Spacer -->
                                    <div class="md:w-5/12"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - Larger text -->
    <section class="py-24 bg-gradient-to-r from-[#0F2854] to-[#1C4D8D] relative overflow-hidden">
        <!-- Background Pattern - CORRIGÉ -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;">
            </div>
        </div>

        <div class="container mx-auto px-6 md:px-12 lg:px-24 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <?php if (!empty($cta)): ?>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        <?= htmlspecialchars($cta['title']) ?>
                    </h2>
                    <p class="text-blue-100 text-xl mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        <?= htmlspecialchars($cta['description']) ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <a href="<?= htmlspecialchars($cta['primary_button_link']) ?>"
                            class="bg-white text-[#0F2854] px-10 py-4 rounded-xl font-bold hover:bg-blue-50 transition duration-300 inline-flex items-center justify-center text-lg">
                            <i class="fas fa-calendar-check mr-3"></i> <?= htmlspecialchars($cta['primary_button_text']) ?>
                        </a>
                        <?php if (!empty($cta['secondary_button_text']) && !empty($cta['secondary_button_link'])): ?>
                            <a href="<?= htmlspecialchars($cta['secondary_button_link']) ?>"
                                class="border-2 border-white text-white px-10 py-4 rounded-xl font-bold hover:bg-white/10 transition duration-300 inline-flex items-center justify-center text-lg">
                                <i class="fas fa-phone mr-3"></i> <?= htmlspecialchars($cta['secondary_button_text']) ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Fallback CTA -->
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        Ready to Build Your Case Strategy?
                    </h2>
                    <p class="text-blue-100 text-xl mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        Our proven track record in landmark cases demonstrates our ability to develop winning strategies for complex legal challenges.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <a href="contact.php"
                            class="bg-white text-[#0F2854] px-10 py-4 rounded-xl font-bold hover:bg-blue-50 transition duration-300 inline-flex items-center justify-center text-lg">
                            <i class="fas fa-calendar-check mr-3"></i> Schedule Consultation
                        </a>
                        <a href="tel:+2302144607"
                            class="border-2 border-white text-white px-10 py-4 rounded-xl font-bold hover:bg-white/10 transition duration-300 inline-flex items-center justify-center text-lg">
                            <i class="fas fa-phone mr-3"></i> +230 214 4607
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer - Larger text -->
    <footer class="bg-[#0F2854] text-white py-16">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid md:grid-cols-4 gap-10">
                <!-- Firm Info -->
                <div class="md:col-span-2">
                    <div class="text-3xl font-bold mb-4">
                        <span class="text-white">Precision</span>
                        <span class="text-blue-300">Law Firm</span>
                    </div>
                    <p class="text-gray-300 text-base mb-6 max-w-md">
                        Strategic legal representation with a proven track record in landmark cases across Mauritian courts and tribunals.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fas fa-envelope text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Practice Areas Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Practice Areas</h3>
                    <ul class="space-y-2">
                        <?php if (!empty($categories)): ?>
                            <?php foreach (array_slice($categories, 0, 5) as $category): ?>
                                <li><a href="#" class="text-gray-300 hover:text-white transition text-base"><?= htmlspecialchars($category['name']) ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="#" class="text-gray-300 hover:text-white transition text-base">Commercial Litigation</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition text-base">Constitutional Law</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition text-base">Employment Law</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition text-base">Corporate Law</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition text-base">Property Disputes</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start text-base">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-300"></i>
                            <span>7th floor, Astor Court<br>Georges Guibert Street<br>Port Louis, Mauritius</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-phone mr-3 text-blue-300"></i>
                            <span>+230 214 4607</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-envelope mr-3 text-blue-300"></i>
                            <span>LawfirmPrecision@outlook.com</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-clock mr-3 text-blue-300"></i>
                            <span>Mon-Fri: 9AM-6PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-800 mt-10 pt-8 text-center text-gray-400">
                <p class="text-base">© 2024 Precision Law Firm. All rights reserved.</p>
                <p class="text-sm mt-2">Case summaries are for informational purposes only. Past results do not guarantee similar outcomes.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1500,
            offset: 80,
            easing: 'ease-out-cubic',
            once: true,
            mirror: false
        });

        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const icon = this.querySelector('i');

            menu.classList.toggle('hidden');

            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Case Filtering System
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const caseCards = document.querySelectorAll('.case-card');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const selectedCategory = this.getAttribute('data-category');

                    // Filter case cards
                    caseCards.forEach(card => {
                        const cardCategories = card.getAttribute('data-category');

                        if (selectedCategory === 'all' || (cardCategories && cardCategories.includes(selectedCategory))) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Animated counters
            const counters = document.querySelectorAll('[data-count]');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const suffix = counter.textContent.replace(/[0-9]/g, '');
                let current = 0;
                const increment = target / 100;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current) + suffix;
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.textContent = target + suffix;
                    }
                };

                // Start counter when in viewport
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(counter);
            });

            // Scroll reveal animations
            const revealElements = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            revealElements.forEach(el => revealObserver.observe(el));
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>