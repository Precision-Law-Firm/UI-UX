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
        .category-btn {
            transition: all 0.3s ease;
            border-color: #e5e7eb;
            background-color: white;
            color: #374151;
        }

        .category-btn:hover {
            border-color: #1C4D8D;
            color: #1C4D8D;
        }

        .category-btn.active {
            background-color: #1C4D8D;
            color: white;
            border-color: #1C4D8D;
        }

        .category-btn.active:hover {
            background-color: #0F2854;
            color: white;
        }

        .case-card {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

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

    <!-- Navbar -->
    <?php include "../includes/navbar.php"; ?>

    <!-- Hero Section -->
    <section class="hero-section py-16 md:py-20 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <span class="inline-flex items-center bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm sm:text-base mb-6" 
                      data-aos="fade-up-slow" data-aos-duration="1400">
                    <i class="fas fa-gavel mr-2"></i><?= htmlspecialchars($hero['badge_text'] ?? 'Landmark Cases') ?>
                </span>

                <!-- Title -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white mb-6" 
                    data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                    <?= htmlspecialchars($hero['title'] ?? 'Our Jurisprudence') ?>
                </h1>

                <!-- Description justifiée -->
                <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-8 md:mb-10 max-w-2xl mx-auto text-justify px-4" 
                   data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="300">
                    <?= htmlspecialchars($hero['subtitle'] ?? 'Discover landmark cases and significant legal precedents handled by our firm. Each case represents our commitment to excellence in legal strategy and advocacy.') ?>
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center px-4" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="400">
                    <a href="#featured-cases"
                        class="bg-white text-[#0F2854] px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                        <i class="fas fa-book-open mr-2 md:mr-3"></i> Explore Cases
                    </a>
                    <a href="#stats"
                        class="border-2 border-white text-white px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-semibold hover:bg-white/10 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                        <i class="fas fa-chart-bar mr-2 md:mr-3"></i> View Statistics
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="stats" class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-white to-gray-50 pattern-bg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8 text-center">
                <?php if (!empty($stats)): ?>
                    <?php foreach ($stats as $index => $stat): ?>
                        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300"
                            data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
                            <div class="stat-counter text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-1 md:mb-2">
                                <?= htmlspecialchars($stat['value']) ?><?= htmlspecialchars($stat['suffix'] ?? '') ?>
                            </div>
                            <p class="text-gray-600 text-xs sm:text-sm md:text-base lg:text-lg font-medium"><?= htmlspecialchars($stat['label']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback stats -->
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="100">
                        <div class="stat-counter text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-1 md:mb-2">150+</div>
                        <p class="text-gray-600 text-xs sm:text-sm md:text-base lg:text-lg font-medium">Cases Handled</p>
                    </div>
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-counter text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-1 md:mb-2">95%</div>
                        <p class="text-gray-600 text-xs sm:text-sm md:text-base lg:text-lg font-medium">Success Rate</p>
                    </div>
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-counter text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-1 md:mb-2">25+</div>
                        <p class="text-gray-600 text-xs sm:text-sm md:text-base lg:text-lg font-medium">Years Experience</p>
                    </div>
                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="400">
                        <div class="stat-counter text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-1 md:mb-2">12+</div>
                        <p class="text-gray-600 text-xs sm:text-sm md:text-base lg:text-lg font-medium">Landmark Precedents</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Case Filter Section -->
    <section class="py-10 md:py-12 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-6 md:mb-8" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#0F2854] mb-2">Filter by Practice Area</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Select a category to view relevant cases</p>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2 justify-center px-2" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                    <button class="category-btn active px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border transition-all duration-300" data-category="all">
                        <i class="fas fa-layer-group mr-1 sm:mr-2"></i>All Cases
                    </button>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border transition-all duration-300" data-category="<?= htmlspecialchars($category['slug']) ?>">
                                <i class="fas <?= htmlspecialchars($category['icon'] ?? 'fa-folder') ?> mr-1 sm:mr-2"></i><?= htmlspecialchars($category['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback categories -->
                        <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border" data-category="commercial"><i class="fas fa-briefcase mr-1 sm:mr-2"></i>Commercial</button>
                        <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border" data-category="constitutional"><i class="fas fa-landmark mr-1 sm:mr-2"></i>Constitutional</button>
                        <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border" data-category="civil"><i class="fas fa-balance-scale mr-1 sm:mr-2"></i>Civil</button>
                        <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border" data-category="employment"><i class="fas fa-users mr-1 sm:mr-2"></i>Employment</button>
                        <button class="category-btn px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border" data-category="property"><i class="fas fa-home mr-1 sm:mr-2"></i>Property</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cases Section -->
    <section id="featured-cases" class="py-16 md:py-20 lg:py-24 bg-gray-50 pattern-bg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-3 md:mb-4">Landmark Cases & Precedents</h2>
                    <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-4 md:mb-6"></div>
                    <p class="text-gray-600 text-base sm:text-lg md:text-xl max-w-2xl mx-auto px-4">Significant legal matters where our strategic approach made a decisive impact</p>
                </div>

                <!-- Cases List -->
                <div class="space-y-6 md:space-y-8">
                    <?php if (!empty($cases)): ?>
                        <?php foreach ($cases as $index => $case):
                            $colors = getColorClasses($case['icon_color'] ?? 'blue');
                            $categorySlug = '';
                            foreach ($categories as $cat) {
                                if (isset($cat['id']) && $cat['id'] == $case['category_id']) {
                                    $categorySlug = $cat['slug'];
                                    break;
                                }
                            }
                        ?>
                            <div class="case-card bg-white rounded-xl md:rounded-2xl p-4 sm:p-6 md:p-8 reveal" 
                                 data-category="<?= $categorySlug ?>" 
                                 data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                
                                <div class="flex flex-col lg:flex-row gap-6 md:gap-8">
                                    <!-- Left Column - Case Info -->
                                    <div class="lg:w-1/3">
                                        <div class="bg-gradient-to-br from-<?= $colors['bg'] ?> to-gray-50 p-4 sm:p-5 md:p-6 rounded-xl h-full">
                                            <!-- Header -->
                                            <div class="mb-4 md:mb-6">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                                    <span class="<?= $colors['light'] ?> <?= $colors['text'] ?> text-xs sm:text-sm font-semibold px-2 sm:px-3 py-1 rounded-full">
                                                        <?= $case['year'] ?> • <?= htmlspecialchars($case['court'] ?? 'Court') ?>
                                                    </span>
                                                    <?php if ($case['duration_months']): ?>
                                                        <span class="text-xs text-gray-500">
                                                            <i class="fas fa-clock mr-1"></i><?= $case['duration_months'] ?> months
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($case['title']) ?></h3>
                                                <div class="flex flex-wrap gap-1 sm:gap-2">
                                                    <?php if (!empty($case['category_name'])): 
                                                        $catNames = explode(',', $case['category_name']);
                                                        foreach ($catNames as $catName): ?>
                                                            <span class="text-xs <?= $colors['light'] ?> <?= $colors['text'] ?> px-2 sm:px-3 py-1 rounded-full"><?= htmlspecialchars(trim($catName)) ?></span>
                                                    <?php endforeach; endif; ?>
                                                </div>
                                            </div>
                                            
                                            <!-- Case Details -->
                                            <div class="text-xs sm:text-sm text-gray-600">
                                                <?php if ($case['case_number']): ?>
                                                    <div class="flex items-center mb-2">
                                                        <i class="fas fa-file-alt <?= $colors['text'] ?> mr-2 text-xs"></i>
                                                        <span class="truncate">Case No: <?= htmlspecialchars($case['case_number']) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex items-center">
                                                    <i class="fas fa-user-tie <?= $colors['text'] ?> mr-2 text-xs"></i>
                                                    <span class="truncate">Lead: <?= htmlspecialchars($case['lead_attorney'] ?? 'Me') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Case Details -->
                                    <div class="lg:w-2/3">
                                        <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4"><?= htmlspecialchars($case['title']) ?></h4>
                                        
                                        <div class="space-y-3 md:space-y-4 text-gray-700 text-sm sm:text-base">
                                            <!-- Summary justifié -->
                                            <p class="text-justify">
                                                <?= htmlspecialchars($case['summary']) ?>
                                            </p>

                                            <!-- Key Issues & Outcome -->
                                            <?php if ($case['key_issues']): ?>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                                                    <!-- Key Issues -->
                                                    <div class="<?= $colors['bg'] ?> p-3 sm:p-4 rounded-lg">
                                                        <p class="text-sm sm:text-base font-semibold <?= $colors['text'] ?> mb-2">
                                                            <i class="fas fa-gavel mr-2"></i>Key Issues:
                                                        </p>
                                                        <ul class="text-xs sm:text-sm text-gray-600 space-y-1">
                                                            <?php $issues = explode(',', $case['key_issues']); ?>
                                                            <?php foreach ($issues as $issue): ?>
                                                                <li class="flex items-start">
                                                                    <i class="fas fa-check-circle <?= $colors['text'] ?> text-xs mt-1 mr-2 flex-shrink-0"></i>
                                                                    <span class="text-justify"><?= htmlspecialchars(trim($issue)) ?></span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>

                                                    <!-- Outcome -->
                                                    <?php if ($case['outcome']): ?>
                                                        <div class="bg-green-50 p-3 sm:p-4 rounded-lg">
                                                            <p class="text-sm sm:text-base font-semibold text-green-700 mb-2">
                                                                <i class="fas fa-trophy mr-2"></i>Outcome:
                                                            </p>
                                                            <ul class="text-xs sm:text-sm text-gray-600 space-y-1">
                                                                <?php $outcomes = explode(',', $case['outcome']); ?>
                                                                <?php foreach ($outcomes as $outcome): ?>
                                                                    <li class="flex items-start">
                                                                        <i class="fas fa-check text-green-600 text-xs mt-1 mr-2 flex-shrink-0"></i>
                                                                        <span class="text-justify"><?= htmlspecialchars(trim($outcome)) ?></span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Footer -->
                                            <div class="flex flex-wrap items-center justify-between pt-3 md:pt-4 border-t border-gray-200 gap-2">
                                                <?php if ($case['impact']): ?>
                                                    <span class="text-xs sm:text-sm font-medium <?= $colors['text'] ?>">
                                                        <i class="fas fa-star mr-1"></i><?= htmlspecialchars($case['impact']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <a href="#" class="<?= $colors['text'] ?> font-medium hover:opacity-80 transition text-xs sm:text-sm">
                                                    Read Full Case Study <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback case -->
                        <div class="case-card bg-white rounded-xl md:rounded-2xl p-4 sm:p-6 md:p-8 reveal" data-category="commercial corporate" data-aos="fade-up-slow" data-aos-duration="1400">
                            <div class="flex flex-col lg:flex-row gap-6 md:gap-8">
                                <div class="lg:w-1/3">
                                    <div class="bg-gradient-to-br from-blue-50 to-gray-50 p-4 sm:p-5 md:p-6 rounded-xl h-full">
                                        <div class="mb-4 md:mb-6">
                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                                <span class="bg-blue-100 text-[#1C4D8D] text-xs sm:text-sm font-semibold px-2 sm:px-3 py-1 rounded-full">2023 • Supreme Court</span>
                                                <span class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i>6 months</span>
                                            </div>
                                            <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-2">Doe v. Mauritius Commercial Bank</h3>
                                            <div class="flex flex-wrap gap-1 sm:gap-2">
                                                <span class="text-xs bg-blue-100 text-[#1C4D8D] px-2 sm:px-3 py-1 rounded-full">Banking Law</span>
                                                <span class="text-xs bg-blue-100 text-[#1C4D8D] px-2 sm:px-3 py-1 rounded-full">Contract Law</span>
                                            </div>
                                        </div>
                                        <div class="text-xs sm:text-sm text-gray-600">
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-file-alt text-[#1C4D8D] mr-2 text-xs"></i>
                                                <span>Case No: SCJ 2023-45</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie text-[#1C4D8D] mr-2 text-xs"></i>
                                                <span>Lead: Maître Jean Dupont</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:w-2/3">
                                    <h4 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Redefining Banking Liability</h4>
                                    <p class="text-sm sm:text-base text-gray-700 mb-3 md:mb-4 text-justify">This landmark case established new standards for bank liability in unauthorized digital transactions. Our firm successfully argued for expanded consumer protection in the rapidly evolving digital banking landscape.</p>
                                    <div class="flex flex-wrap items-center justify-between pt-3 md:pt-4 border-t border-gray-200 gap-2">
                                        <span class="text-xs sm:text-sm font-medium text-[#1C4D8D]"><i class="fas fa-star mr-1"></i>Landmark Precedent</span>
                                        <a href="#" class="text-[#1C4D8D] font-medium hover:opacity-80 transition text-xs sm:text-sm">Read Full Case Study <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="py-16 md:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16" data-aos="fade-up-slow" data-aos-duration="1400">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#0F2854] mb-3 md:mb-4">Our Legal Journey</h2>
                    <div class="w-16 md:w-20 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-4 md:mb-6"></div>
                    <p class="text-gray-600 text-base sm:text-lg md:text-xl max-w-2xl mx-auto px-4">Key milestones and landmark cases that shaped our practice</p>
                </div>

                <!-- Timeline -->
                <div class="relative">
                    <!-- Timeline Line (hidden on mobile) -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-[#1C4D8D] via-[#0F2854] to-[#1C4D8D] rounded-full hidden md:block"></div>

                    <!-- Timeline Items -->
                    <div class="space-y-8 md:space-y-16">
                        <?php if (!empty($timeline)): ?>
                            <?php foreach ($timeline as $index => $item):
                                $colors = getColorClasses($item['color'] ?? 'blue');
                                $position = ($index % 2 == 0) ? 'left' : 'right';
                            ?>
                                <div class="relative" data-aos="<?= ($position == 'left') ? 'fade-right-slow' : 'fade-left-slow' ?>" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                    <!-- Mobile Layout (stacked) -->
                                    <div class="md:hidden">
                                        <div class="flex flex-col items-center text-center">
                                            <!-- Icon -->
                                            <div class="relative group mb-4">
                                                <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl">
                                                    <i class="fas <?= htmlspecialchars($item['icon'] ?? 'fa-star') ?> text-white text-lg"></i>
                                                </div>
                                            </div>
                                            <!-- Content -->
                                            <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-xl shadow-lg border-l-4 border-[#1C4D8D]">
                                                <div class="inline-block px-3 py-1 rounded-full <?= $colors['light'] ?> <?= $colors['text'] ?> font-bold text-xs mb-3">
                                                    <i class="fas fa-calendar-alt mr-1"></i><?= $item['year'] ?>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($item['title']) ?></h3>
                                                <p class="text-sm text-gray-600 text-justify"><?= htmlspecialchars($item['description']) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Desktop Layout (alternating) -->
                                    <div class="hidden md:flex flex-row items-center <?= ($position == 'left') ? '' : 'flex-row-reverse' ?>">
                                        <!-- Content -->
                                        <div class="w-5/12 <?= ($position == 'left') ? 'text-right pr-8' : 'text-left pl-8' ?>">
                                            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-[#1C4D8D]">
                                                <div class="inline-block px-3 py-1 rounded-full <?= $colors['light'] ?> <?= $colors['text'] ?> font-bold text-xs mb-3">
                                                    <i class="fas fa-calendar-alt mr-1"></i><?= $item['year'] ?>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($item['title']) ?></h3>
                                                <p class="text-sm text-gray-600 text-justify"><?= htmlspecialchars($item['description']) ?></p>
                                            </div>
                                        </div>

                                        <!-- Center Icon -->
                                        <div class="w-2/12 flex justify-center">
                                            <div class="relative group">
                                                <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-all duration-500">
                                                    <i class="fas <?= htmlspecialchars($item['icon'] ?? 'fa-star') ?> text-white text-lg"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Spacer -->
                                        <div class="w-5/12"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback timeline items -->
                            <?php
                            $fallbackItems = [
                                ['year' => '2023', 'title' => 'Digital Banking Precedent', 'desc' => 'Established new standards for consumer protection in digital transactions, setting a landmark precedent in Mauritian banking law.', 'icon' => 'fa-mobile-alt', 'color' => 'blue'],
                                ['year' => '2022', 'title' => 'Free Speech Expansion', 'desc' => 'Redefined constitutional protections for digital expression, expanding free speech rights in the online sphere.', 'icon' => 'fa-comments', 'color' => 'purple'],
                                ['year' => '2021', 'title' => 'Workplace Rights Milestone', 'desc' => 'Set new standards for employment discrimination cases, strengthening worker protections across Mauritius.', 'icon' => 'fa-briefcase', 'color' => 'orange']
                            ];
                            foreach ($fallbackItems as $index => $item):
                                $position = ($index % 2 == 0) ? 'left' : 'right';
                            ?>
                                <div class="relative" data-aos="<?= ($position == 'left') ? 'fade-right-slow' : 'fade-left-slow' ?>" data-aos-duration="1400" data-aos-delay="<?= $index * 100 ?>">
                                    <!-- Mobile -->
                                    <div class="md:hidden">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="relative group mb-4">
                                                <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl">
                                                    <i class="fas <?= $item['icon'] ?> text-white text-lg"></i>
                                                </div>
                                            </div>
                                            <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-xl shadow-lg border-l-4 border-[#1C4D8D]">
                                                <div class="inline-block px-3 py-1 rounded-full bg-blue-100 text-[#1C4D8D] font-bold text-xs mb-3">
                                                    <i class="fas fa-calendar-alt mr-1"></i><?= $item['year'] ?>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-800 mb-2"><?= $item['title'] ?></h3>
                                                <p class="text-sm text-gray-600 text-justify"><?= $item['desc'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Desktop -->
                                    <div class="hidden md:flex flex-row items-center <?= ($position == 'left') ? '' : 'flex-row-reverse' ?>">
                                        <div class="w-5/12 <?= ($position == 'left') ? 'text-right pr-8' : 'text-left pl-8' ?>">
                                            <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 border-l-4 border-[#1C4D8D]">
                                                <div class="inline-block px-3 py-1 rounded-full bg-blue-100 text-[#1C4D8D] font-bold text-xs mb-3">
                                                    <i class="fas fa-calendar-alt mr-1"></i><?= $item['year'] ?>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-800 mb-2"><?= $item['title'] ?></h3>
                                                <p class="text-sm text-gray-600 text-justify"><?= $item['desc'] ?></p>
                                            </div>
                                        </div>
                                        <div class="w-2/12 flex justify-center">
                                            <div class="relative group">
                                                <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] rounded-full flex items-center justify-center shadow-xl">
                                                    <i class="fas <?= $item['icon'] ?> text-white text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-5/12"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-r from-[#0F2854] to-[#1C4D8D] relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <?php if (!empty($cta)): ?>
                    <!-- Title -->
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        <?= htmlspecialchars($cta['title']) ?>
                    </h2>
                    <!-- Description justifiée -->
                    <p class="text-blue-100 text-sm sm:text-base md:text-lg lg:text-xl mb-6 md:mb-8 lg:mb-10 max-w-2xl mx-auto px-4 text-justify" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        <?= htmlspecialchars($cta['description']) ?>
                    </p>
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center px-4" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <a href="<?= htmlspecialchars($cta['primary_button_link']) ?>"
                            class="bg-white text-[#0F2854] px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-bold hover:bg-blue-50 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                            <i class="fas fa-calendar-check mr-2 md:mr-3"></i> <?= htmlspecialchars($cta['primary_button_text']) ?>
                        </a>
                        <?php if (!empty($cta['secondary_button_text']) && !empty($cta['secondary_button_link'])): ?>
                            <a href="<?= htmlspecialchars($cta['secondary_button_link']) ?>"
                                class="border-2 border-white text-white px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-bold hover:bg-white/10 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                                <i class="fas fa-phone mr-2 md:mr-3"></i> <?= htmlspecialchars($cta['secondary_button_text']) ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Fallback CTA -->
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 md:mb-6" data-aos="fade-up-slow" data-aos-duration="1400">
                        Ready to Build Your Case Strategy?
                    </h2>
                    <p class="text-blue-100 text-sm sm:text-base md:text-lg lg:text-xl mb-6 md:mb-8 lg:mb-10 max-w-2xl mx-auto px-4 text-justify" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="100">
                        Our proven track record in landmark cases demonstrates our ability to develop winning strategies for complex legal challenges.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center px-4" data-aos="fade-up-slow" data-aos-duration="1400" data-aos-delay="200">
                        <a href="contact.php"
                            class="bg-white text-[#0F2854] px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-bold hover:bg-blue-50 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                            <i class="fas fa-calendar-check mr-2 md:mr-3"></i> Schedule Consultation
                        </a>
                        <a href="tel:+2302144607"
                            class="border-2 border-white text-white px-6 md:px-8 lg:px-10 py-3 md:py-4 rounded-xl font-bold hover:bg-white/10 transition duration-300 inline-flex items-center justify-center text-sm md:text-base lg:text-lg">
                            <i class="fas fa-phone mr-2 md:mr-3"></i> +230 214 4607
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "../includes/footer.php"; ?>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../js/script.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Case Filter Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.category-btn');
            const caseCards = document.querySelectorAll('.case-card');

            if (filterButtons.length && caseCards.length) {
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        filterButtons.forEach(btn => btn.classList.remove('active', 'bg-[#1C4D8D]', 'text-white'));

                        // Add active class to clicked button
                        this.classList.add('active', 'bg-[#1C4D8D]', 'text-white');

                        const category = this.getAttribute('data-category');

                        // Filter cases
                        caseCards.forEach(card => {
                            if (category === 'all' || card.getAttribute('data-category').includes(category)) {
                                card.style.display = 'block';
                                setTimeout(() => {
                                    card.style.opacity = '1';
                                    card.style.transform = 'scale(1)';
                                }, 50);
                            } else {
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.95)';
                                setTimeout(() => {
                                    card.style.display = 'none';
                                }, 300);
                            }
                        });
                    });
                });
            }
        });
    </script>
</body>

</html>