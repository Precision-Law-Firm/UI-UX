<?php
require '../config.php';

// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Fetch Courses Hero ---
$hero = null;
try {
    $stmt = $pdo->query("SELECT * FROM courses_hero ORDER BY id DESC LIMIT 1");
    $hero = $stmt->fetch();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Course Benefits ---
$benefits = [];
try {
    $stmt = $pdo->query("SELECT * FROM course_benefits WHERE is_active = 1 ORDER BY sort_order ASC");
    $benefits = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Course Levels ---
$levels = [];
$levelsById = [];
try {
    $stmt = $pdo->query("SELECT * FROM course_levels WHERE is_active = 1 ORDER BY sort_order ASC");
    $levels = $stmt->fetchAll();
    foreach ($levels as $level) {
        $levelsById[$level['id']] = $level;
    }
} catch (Exception $e) {
}

// --- Fetch Courses ---
$courses = [];
try {
    $stmt = $pdo->query("SELECT * FROM courses WHERE is_active = 1 ORDER BY sort_order ASC, featured DESC");
    $courses = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Course Modules ---
$modules = [];
try {
    $stmt = $pdo->query("SELECT * FROM course_modules WHERE is_active = 1 ORDER BY sort_order ASC");
    $modules = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Course Features ---
$features = [];
try {
    $stmt = $pdo->query("SELECT * FROM course_features WHERE is_active = 1 ORDER BY sort_order ASC");
    $features = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Course Stats ---
$stats = [];
try {
    $stmt = $pdo->query("SELECT * FROM course_stats ORDER BY sort_order ASC");
    $stats = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Instructors ---
$instructors = [];
try {
    $stmt = $pdo->query("SELECT * FROM instructors WHERE is_active = 1 ORDER BY sort_order ASC");
    $instructors = $stmt->fetchAll();
} catch (Exception $e) {
}

// --- Fetch Student Testimonials ---
$testimonials = [];
try {
    $stmt = $pdo->query("SELECT * FROM student_testimonials WHERE is_active = 1 ORDER BY sort_order ASC");
    $testimonials = $stmt->fetchAll();
} catch (Exception $e) {
}

// DONNÉES PAR DÉFAUT SI RIEN N'EST TROUVÉ
if (empty($hero)) {
    $hero = [
        'title_line1' => 'Continuous Learning Legal Education',
        'title_line2' => 'for Students',
        'subtitle' => 'Bridging theory with practice. Join our specialized legal courses designed for law students and aspiring legal professionals.',
        'background_image' => '../components/img/bg-try.png',
        'primary_button_text' => 'Explore Courses',
        'primary_button_link' => '#courses',
        'secondary_button_text' => 'Why Join Our Program?',
        'secondary_button_link' => '#why-join'
    ];
}

if (empty($benefits)) {
    $benefits = [
        ['icon' => 'fa-user-tie', 'title' => 'Expert Instructors', 'description' => 'Learn from practicing attorneys who handle real cases daily. Get insights you won\'t find in textbooks.'],
        ['icon' => 'fa-hands-helping', 'title' => 'Practical Skills', 'description' => 'Master practical legal skills: drafting, negotiation, research, and courtroom procedures.'],
        ['icon' => 'fa-network-wired', 'title' => 'Career Networking', 'description' => 'Connect with legal professionals and build relationships that can launch your career.']
    ];
}

if (empty($courses)) {
    $courses = [
        [
            'id' => 1,
            'title' => 'Introduction to Legal Practice',
            'description' => 'Foundation course covering legal research, writing, and basic courtroom procedures for new law students.',
            'category' => 'beginner',
            'level_id' => 1,
            'duration_text' => '8 weeks',
            'price_rs' => 12500,
            'instructor_name' => 'Maître Jean Dupont',
            'start_date' => '2024-01-15',
            'icon' => 'fa-balance-scale',
            'features' => 'Legal research basics,Introduction to courtroom procedures,Legal writing fundamentals'
        ],
        [
            'id' => 2,
            'title' => 'Corporate Law Essentials',
            'description' => 'Deep dive into corporate structures, M&A, compliance, and commercial contract drafting.',
            'category' => 'advanced',
            'level_id' => 2,
            'duration_text' => '12 weeks',
            'price_rs' => 18000,
            'instructor_name' => 'Maître Sophie Martin',
            'start_date' => '2024-02-10',
            'icon' => 'fa-briefcase',
            'features' => 'Corporate structures,M&A transactions,Compliance and regulations'
        ],
        [
            'id' => 3,
            'title' => 'Courtroom Advocacy Workshop',
            'description' => 'Intensive practical workshop on courtroom presentation, cross-examination, and legal argumentation.',
            'category' => 'workshop',
            'level_id' => 3,
            'duration_text' => '2 days',
            'price_rs' => 8500,
            'instructor_name' => 'Maître Pierre Laurent',
            'start_date' => '2024-03-20',
            'icon' => 'fa-gavel',
            'features' => 'Courtroom presentation,Cross-examination techniques,Legal argumentation'
        ],
        [
            'id' => 4,
            'title' => 'Legal Research & Writing',
            'description' => 'Master legal research techniques, citation formats, and professional legal writing skills.',
            'category' => 'beginner',
            'level_id' => 1,
            'duration_text' => '6 weeks',
            'price_rs' => 10500,
            'instructor_name' => 'Maître Claire Dubois',
            'start_date' => '2024-04-05',
            'icon' => 'fa-pen-fancy',
            'features' => 'Research techniques,Legal citation,Professional writing'
        ]
    ];
}

if (empty($levels)) {
    $levels = [
        ['id' => 1, 'name' => 'Beginner', 'slug' => 'beginner', 'color' => 'blue'],
        ['id' => 2, 'name' => 'Advanced', 'slug' => 'advanced', 'color' => 'purple'],
        ['id' => 3, 'name' => 'Workshop', 'slug' => 'workshop', 'color' => 'green']
    ];
    $levelsById = [
        1 => ['id' => 1, 'name' => 'Beginner', 'slug' => 'beginner', 'color' => 'blue'],
        2 => ['id' => 2, 'name' => 'Advanced', 'slug' => 'advanced', 'color' => 'purple'],
        3 => ['id' => 3, 'name' => 'Workshop', 'slug' => 'workshop', 'color' => 'green']
    ];
}

if (empty($modules)) {
    $modules = [
        ['title' => 'Legal Research Skills', 'description' => 'Master online databases, case law research, and legal citation methods.'],
        ['title' => 'Drafting & Documentation', 'description' => 'Learn to draft legal documents, contracts, and court submissions professionally.'],
        ['title' => 'Courtroom Procedures', 'description' => 'Understand courtroom etiquette, filing procedures, and advocacy techniques.'],
        ['title' => 'Client Management', 'description' => 'Develop skills for client interviews, communication, and case management.']
    ];
}

if (empty($features)) {
    $features = [
        ['feature' => 'Interactive online sessions'],
        ['feature' => 'Real case studies'],
        ['feature' => 'Personal feedback from instructors'],
        ['feature' => 'Certificate of completion'],
        ['feature' => 'Access to course materials for 1 year']
    ];
}

if (empty($stats)) {
    $stats = [
        ['label' => 'Hours of Content', 'value' => '20+'],
        ['label' => 'Practical Exercises', 'value' => '100%']
    ];
}

if (empty($instructors)) {
    $instructors = [
        [
            'name' => 'Maître Jean Dupont',
            'title' => 'Corporate Law Specialist',
            'bio' => '15+ years experience in corporate law. Former lecturer at University of Mauritius Law School.',
            'icon_color' => 'blue',
            'specialties' => 'Contracts,M&A'
        ],
        [
            'name' => 'Maître Sophie Martin',
            'title' => 'Litigation Expert',
            'bio' => 'Senior litigator with 12+ years courtroom experience. Specializes in commercial and civil litigation.',
            'icon_color' => 'purple',
            'specialties' => 'Litigation,Advocacy'
        ],
        [
            'name' => 'Maître Pierre Laurent',
            'title' => 'Legal Writing Coach',
            'bio' => 'Former legal editor and writing instructor. Published author on legal writing and research methodology.',
            'icon_color' => 'green',
            'specialties' => 'Writing,Research'
        ]
    ];
}

if (empty($testimonials)) {
    $testimonials = [
        [
            'student_name' => 'Sarah Chen',
            'student_year' => '3rd Year Law Student',
            'content' => 'The Corporate Law Essentials course gave me practical skills that weren\'t covered in my university curriculum. I was able to secure an internship thanks to what I learned.',
            'rating' => 5,
            'icon_color' => 'blue'
        ],
        [
            'student_name' => 'David Wong',
            'student_year' => 'Recent Law Graduate',
            'content' => 'The Courtroom Advocacy Workshop was transformative. The hands-on exercises and feedback from practicing attorneys prepared me for real courtroom situations.',
            'rating' => 4.5,
            'icon_color' => 'green'
        ]
    ];
}

// Function to get color classes
function getColorClasses($color)
{
    $colors = [
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-[#1C4D8D]', 'border' => 'border-[#1C4D8D]', 'light' => 'bg-blue-100', 'hover' => 'hover:bg-blue-50'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-700', 'light' => 'bg-purple-100', 'hover' => 'hover:bg-purple-50'],
        'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-700', 'light' => 'bg-green-100', 'hover' => 'hover:bg-green-50'],
        'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-700', 'light' => 'bg-orange-100', 'hover' => 'hover:bg-orange-50'],
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-700', 'light' => 'bg-red-100', 'hover' => 'hover:bg-red-50']
    ];
    return $colors[$color] ?? $colors['blue'];
}

// Function to get level color
function getLevelColor($levelId, $levelsById)
{
    if (isset($levelsById[$levelId])) {
        return $levelsById[$levelId]['color'] ?? 'blue';
    }
    return 'blue';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        [data-aos] {
            transition-duration: 1500ms !important;
        }

        .course-card {
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-10px) scale(1.01);
            box-shadow: 0 25px 50px -12px rgba(28, 77, 141, 0.25);
            border-color: #1C4D8D;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px -10px rgba(28, 77, 141, 0.4);
        }

        .tab-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-button:hover {
            transform: translateY(-2px);
        }

        .tab-button.active {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(28, 77, 141, 0.3);
        }

        .module-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            padding-left: 1.5rem;
        }

        .module-item::before {
            content: '▸';
            position: absolute;
            left: 0;
            color: #1C4D8D;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .module-item:hover {
            color: #1C4D8D;
            padding-left: 2rem;
        }

        .module-item:hover::before {
            transform: translateX(5px);
        }

        .instructor-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid #e5e7eb;
        }

        .instructor-card:hover {
            transform: translateY(-8px);
            border-color: #1C4D8D;
            box-shadow: 0 20px 40px -15px rgba(28, 77, 141, 0.2);
        }

        .testimonial-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid #e5e7eb;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            border-color: #1C4D8D;
            box-shadow: 0 15px 35px -10px rgba(28, 77, 141, 0.15);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
            margin: 4px 0;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #cbd5e1, #94a3b8);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #94a3b8, #64748b);
        }

        [x-show="selected"] {
            animation: fadeInScale 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shine {
            0% {
                left: -100%;
            }

            100% {
                left: 200%;
            }
        }

        .group-hover\:animate-shine {
            animation: shine 1.5s ease infinite;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Text justification */
        p,
        .description-text,
        .testimonial-text,
        .course-description {
            text-align: justify;
        }

        /* Keep titles left-aligned */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .title,
        .heading {
            text-align: left;
        }

        /* Center specific titles */
        .text-center h1,
        .text-center h2,
        .text-center h3,
        .text-center h4 {
            text-align: center;
        }

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

    <!-- Navbar - Correction du chemin -->
    <?php include "../includes/navbar.php"; ?>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-28 md:py-36"
        style="background-image: url('<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up-slow">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6">
                    <span class="text-white"><?= htmlspecialchars($hero['title_line1']) ?></span>
                    <span class="text-[#8FB8FF] block"><?= htmlspecialchars($hero['title_line2']) ?></span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-[#8FB8FF] to-white mx-auto mb-8"></div>
                <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto text-justify">
                    <?= htmlspecialchars($hero['subtitle']) ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= htmlspecialchars($hero['primary_button_link']) ?>" class="bg-[#1C4D8D] text-white px-10 py-4 rounded-full font-medium inline-flex items-center justify-center hover:bg-[#163A6B] text-lg">
                        <?= htmlspecialchars($hero['primary_button_text']) ?>
                        <i class="fas fa-book-open ml-3"></i>
                    </a>
                    <a href="<?= htmlspecialchars($hero['secondary_button_link']) ?>" class="border border-white text-white px-10 py-4 rounded-full font-medium inline-flex items-center justify-center hover:bg-white hover:text-[#1C4D8D] text-lg">
                        <?= htmlspecialchars($hero['secondary_button_text']) ?>
                        <i class="fas fa-graduation-cap ml-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Section -->
    <section id="why-join" class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-16" data-aos="fade-up-slow">
                    <div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-4">
                            <span class="text-[#0F2854]">Why Join Our</span>
                            <span class="text-[#1C4D8D]">Legal Program?</span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854]"></div>
                    </div>
                    <p class="text-xl text-gray-600 mt-4 md:mt-0 max-w-xl text-justify">
                        Practical legal education taught by practicing attorneys with real-world experience.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($benefits as $index => $benefit): ?>
                        <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-xl border border-gray-100 hover-lift course-card"
                            data-aos="zoom-slow" data-aos-delay="<?= $index * 200 ?>">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] flex items-center justify-center mb-6">
                                <i class="fas <?= $benefit['icon'] ?> text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($benefit['title']) ?></h3>
                            <p class="text-gray-600 text-lg text-justify"><?= htmlspecialchars($benefit['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl font-bold mb-4">
                        <span class="text-[#0F2854]">Legal Courses</span>
                        <span class="text-[#1C4D8D]">& Workshops</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto text-justify">
                        Choose from our specialized courses designed to complement your academic studies with practical expertise.
                    </p>
                </div>

                <!-- Course Tabs -->
                <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up-slow">
                    <button class="tab-button active px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base" onclick="filterCourses('all')">
                        All Courses
                    </button>
                    <?php foreach ($levels as $level): ?>
                        <button class="tab-button px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base"
                            onclick="filterCourses('<?= $level['slug'] ?>')">
                            <?= $level['name'] ?> Level
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Courses Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($courses as $index => $course):
                        $levelColor = getLevelColor($course['level_id'] ?? 1, $levelsById);
                        $colors = getColorClasses($levelColor);
                    ?>
                        <div class="course-card bg-white rounded-xl border border-gray-200 p-8 hover-lift"
                            data-aos="zoom-slow" data-aos-delay="<?= ($index % 3) * 100 ?>"
                            data-category="<?= $course['category'] ?? 'beginner' ?>">
                            <div class="mb-4">
                                <?php if (isset($course['level_id']) && isset($levelsById[$course['level_id']])): ?>
                                    <span class="<?= $colors['light'] ?> <?= $colors['text'] ?> px-3 py-1 rounded-full text-sm font-medium">
                                        <?= $levelsById[$course['level_id']]['name'] ?>
                                    </span>
                                <?php endif; ?>
                                <span class="text-gray-500 text-base ml-3">
                                    <i class="far fa-clock mr-1"></i> <?= $course['duration_text'] ?? '8 weeks' ?>
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($course['title']) ?></h3>
                            <p class="text-gray-600 text-lg mb-4 text-justify"><?= htmlspecialchars($course['description']) ?></p>
                            <div class="mb-4">
                                <div class="flex items-center text-gray-700 text-base mb-2">
                                    <i class="fas fa-user-graduate mr-2 <?= $colors['text'] ?>"></i>
                                    <span>Instructor: <?= htmlspecialchars($course['instructor_name'] ?? 'TBD') ?></span>
                                </div>
                                <?php if (!empty($course['start_date'])): ?>
                                    <div class="flex items-center text-gray-700 text-base">
                                        <i class="fas fa-calendar-alt mr-2 <?= $colors['text'] ?>"></i>
                                        <span>Starts: <?= date('F j, Y', strtotime($course['start_date'])) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center justify-between mt-6 pt-4 border-t">
                                <div class="text-2xl font-bold text-[#0F2854]">Rs <?= number_format($course['price_rs'] ?? 0, 0) ?></div>
                                <a href="#enroll" data-course-id="<?= $course['id'] ?? $index ?>" data-course-title="<?= htmlspecialchars($course['title']) ?>"
                                    class="btn-primary text-white px-6 py-3 rounded-lg font-medium text-base hover-lift select-course">
                                    Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- View All Courses -->
                <div class="text-center mt-12" data-aos="fade-up-slow">
                    <a href="#all-courses" class="inline-flex items-center text-[#1C4D8D] font-medium hover:text-[#0F2854] transition duration-300 text-lg">
                        View All Courses
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Details Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl font-bold mb-4">
                        <span class="text-[#0F2854]">Course</span>
                        <span class="text-[#1C4D8D]">Structure</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto text-justify">
                        Our courses are designed with a balanced mix of theory and practical application.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Column - What You'll Learn -->
                    <div data-aos="fade-right-slow">
                        <h3 class="text-3xl font-bold text-gray-800 mb-6">What You'll Learn</h3>
                        <div class="space-y-4">
                            <?php foreach ($modules as $module): ?>
                                <div class="module-item">
                                    <h4 class="font-semibold text-gray-800 text-xl mb-1"><?= htmlspecialchars($module['title']) ?></h4>
                                    <p class="text-gray-600 text-base text-justify"><?= htmlspecialchars($module['description']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Column - Course Features -->
                    <div data-aos="fade-left-slow" data-aos-delay="200">
                        <h3 class="text-3xl font-bold text-gray-800 mb-6">Course Features</h3>
                        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-8 border border-blue-100">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <?php foreach ($stats as $stat): ?>
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-[#1C4D8D]"><?= htmlspecialchars($stat['value']) ?></div>
                                        <div class="text-base text-gray-600"><?= htmlspecialchars($stat['label']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <ul class="space-y-3">
                                <?php foreach ($features as $feature): ?>
                                    <li class="flex items-center text-base">
                                        <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                        <span class="text-gray-700 text-justify"><?= htmlspecialchars($feature['feature']) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instructors Section -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl font-bold mb-4">
                        <span class="text-[#0F2854]">Meet Our</span>
                        <span class="text-[#1C4D8D]">Instructors</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto text-justify">
                        Learn from experienced legal practitioners who bring real-world expertise to the classroom.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($instructors as $index => $instructor):
                        $colors = getColorClasses($instructor['icon_color'] ?? 'blue');
                        $specialties = explode(',', $instructor['specialties'] ?? '');
                    ?>
                        <div class="instructor-card bg-white rounded-xl p-8 text-center" data-aos="zoom-slow" data-aos-delay="<?= $index * 200 ?>">
                            <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                <div class="w-full h-full <?= $colors['bg'] ?> flex items-center justify-center">
                                    <i class="fas fa-user-tie text-4xl <?= $colors['text'] ?>"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($instructor['name']) ?></h3>
                            <p class="<?= $colors['text'] ?> text-base font-medium mb-3"><?= htmlspecialchars($instructor['title']) ?></p>
                            <p class="text-gray-600 text-base mb-4 text-justify"><?= htmlspecialchars($instructor['bio']) ?></p>
                            <div class="flex justify-center space-x-2">
                                <?php foreach ($specialties as $specialty): ?>
                                    <span class="<?= $colors['bg'] ?> <?= $colors['text'] ?> px-3 py-1 rounded-full text-sm"><?= htmlspecialchars(trim($specialty)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl font-bold mb-4">
                        <span class="text-[#0F2854]">Student</span>
                        <span class="text-[#1C4D8D]">Testimonials</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto text-justify">
                        Hear from students who have transformed their legal education through our programs.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <?php foreach ($testimonials as $index => $testimonial):
                        $colors = getColorClasses($testimonial['icon_color'] ?? 'blue');
                    ?>
                        <div class="testimonial-card bg-gradient-to-br from-gray-50 to-white rounded-xl p-8"
                            data-aos="<?= $index % 2 == 0 ? 'fade-right-slow' : 'fade-left-slow' ?>" data-aos-delay="<?= $index * 200 ?>">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full <?= $colors['bg'] ?> flex items-center justify-center mr-4">
                                    <i class="fas fa-user <?= $colors['text'] ?> text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($testimonial['student_name']) ?></h4>
                                    <p class="text-base text-gray-500"><?= htmlspecialchars($testimonial['student_year']) ?></p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg italic mb-4 text-justify">
                                "<?= htmlspecialchars($testimonial['content']) ?>"
                            </p>
                            <div class="flex text-yellow-400">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= floor($testimonial['rating'])): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 == $testimonial['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Enrollment Section -->
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-blue-100 to-transparent rounded-full -translate-x-1/2 -translate-y-1/2 opacity-30"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-blue-100 to-transparent rounded-full translate-x-1/3 translate-y-1/3 opacity-30"></div>

        <div class="container mx-auto px-6 md:px-12 lg:px-24 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-4">
                        <span class="text-[#0F2854]">Ready to</span>
                        <span class="text-[#1C4D8D] relative">
                            Enroll?
                            <span class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#1C4D8D] to-transparent opacity-50"></span>
                        </span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed text-justify">
                        Take the next step in your legal education journey. Limited seats available for each course.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-6">
                        <div class="flex items-center text-green-600 text-base">
                            <i class="fas fa-check-circle mr-2"></i><span class="font-medium">Personalized Guidance</span>
                        </div>
                        <div class="h-2 w-2 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center text-blue-600 text-base">
                            <i class="fas fa-clock mr-2"></i><span class="font-medium">48-Hour Response</span>
                        </div>
                        <div class="h-2 w-2 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center text-purple-600 text-base">
                            <i class="fas fa-lock mr-2"></i><span class="font-medium">Secure Application</span>
                        </div>
                    </div>
                </div>


                <!-- Enrollment Form -->

                <!-- Enrollment Form -->
                <div class="bg-white rounded-3xl shadow-2xl p-10 md:p-16 border border-gray-100 relative overflow-hidden" data-aos="zoom-slow">
                    <div class="absolute -top-3 -right-3 bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] text-white px-6 py-2 rounded-full font-semibold text-base transform rotate-3 shadow-lg z-20">
                        <i class="fas fa-star mr-2"></i>Limited Seats
                    </div>

                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 mb-6 shadow-inner">
                            <i class="fas fa-graduation-cap text-3xl text-[#1C4D8D]"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-3">Begin Your Legal Journey</h3>
                        <p class="text-gray-600 text-lg max-w-lg mx-auto text-justify">Complete the form below and our team will guide you through the enrollment process.</p>
                    </div>

                    <form id="enrollment-form" class="space-y-8" method="POST" action="enroll.php" x-data="courseSelector()">
                        <div class="relative">
                            <!-- Stepper -->
                            <div class="flex justify-between items-center mb-8">
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1C4D8D] to-[#0F2854] flex items-center justify-center text-white font-bold shadow-lg text-base">1</div>
                                    <span class="mt-2 text-sm font-medium text-gray-600">Personal Info</span>
                                </div>
                                <div class="flex-1 h-1 bg-gradient-to-r from-[#1C4D8D] via-blue-300 to-gray-200 mx-2"></div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-gray-400 font-bold border-2 border-gray-200 text-base">2</div>
                                    <span class="mt-2 text-sm font-medium text-gray-400">Course Details</span>
                                </div>
                                <div class="flex-1 h-1 bg-gradient-to-r from-gray-200 via-gray-200 to-gray-200 mx-2"></div>
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-gray-400 font-bold border-2 border-gray-200 text-base">3</div>
                                    <span class="mt-2 text-sm font-medium text-gray-400">Submit</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Personal Info -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-gray-700 font-semibold mb-3 flex items-center text-lg">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-[#1C4D8D] text-sm"></i>
                                        </div>
                                        Full Name *
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="student_name" id="student-name" required
                                            class="w-full px-5 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] focus:ring-4 focus:ring-blue-50/50 outline-none transition-all duration-500 hover:border-blue-300 hover:shadow-lg placeholder-gray-400 text-base"
                                            placeholder="Enter your full name">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="block text-gray-700 font-semibold mb-3 flex items-center text-lg">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-envelope text-[#1C4D8D] text-sm"></i>
                                        </div>
                                        Email Address *
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="student_email" id="student-email" required
                                            class="w-full px-5 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] focus:ring-4 focus:ring-blue-50/50 outline-none transition-all duration-500 hover:border-blue-300 hover:shadow-lg placeholder-gray-400 text-base"
                                            placeholder="your.email@example.com">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-at"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone & Course -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-gray-700 font-semibold mb-3 flex items-center text-lg">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-phone text-[#1C4D8D] text-sm"></i>
                                        </div>
                                        Phone Number *
                                    </label>
                                    <div class="relative">
                                        <input type="tel" name="student_phone" id="student-phone" required
                                            class="w-full px-5 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] focus:ring-4 focus:ring-blue-50/50 outline-none transition-all duration-500 hover:border-blue-300 hover:shadow-lg placeholder-gray-400 text-base"
                                            placeholder="+230 123 4567">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="block text-gray-700 font-semibold mb-3 flex items-center text-lg">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-book-open text-[#1C4D8D] text-sm"></i>
                                        </div>
                                        Select Course *
                                    </label>
                                    <div class="relative">
                                        <select name="course_id" id="course-select" required class="hidden" x-ref="select">
                                            <option value="">Choose your course</option>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course['id'] ?>" data-title="<?= htmlspecialchars($course['title']) ?>">
                                                    <?= htmlspecialchars($course['title']) ?> - Rs <?= number_format($course['price_rs'], 0) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <button type="button"
                                            @click="open = !open; if(open) $nextTick(() => $refs.searchInput?.focus())"
                                            @click.away="open = false"
                                            :class="open ? 'border-[#1C4D8D] shadow-xl ring-4 ring-blue-50/50 transform -translate-y-1' : 'border-gray-200 hover:border-blue-300 hover:shadow-lg'"
                                            class="w-full px-5 py-4 pl-12 border-2 rounded-xl bg-white text-left transition-all duration-500 flex items-center justify-between focus:outline-none group-hover:shadow-lg text-base">

                                            <span class="flex items-center gap-3">
                                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <span x-text="selected ? selectedTitle : 'Choose your course'"
                                                    :class="selected ? 'text-[#1C4D8D] font-semibold' : 'text-gray-400'"
                                                    class="text-base"></span>
                                            </span>

                                            <div class="flex items-center gap-2">
                                                <span x-show="selected" class="text-xs px-2 py-1 rounded bg-blue-50 text-[#1C4D8D] font-medium">
                                                    <i class="fas fa-check mr-1"></i>Selected
                                                </span>
                                                <svg class="h-5 w-5 text-gray-500 transition-transform duration-500"
                                                    :class="open ? 'rotate-180 text-[#1C4D8D]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </button>

                                        <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border-2 border-gray-200 rounded-xl shadow-2xl overflow-hidden">
                                            <div class="p-4 border-b border-gray-100">
                                                <div class="relative">
                                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <input type="text" x-model="search" x-ref="searchInput"
                                                        placeholder="Search courses..."
                                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-50 outline-none transition duration-300 text-base">
                                                </div>
                                            </div>

                                            <div class="py-2 max-h-80 overflow-y-auto custom-scrollbar">
                                                <?php foreach ($courses as $course):
                                                    $colors = getColorClasses(getLevelColor($course['level_id'] ?? 1, $levelsById));
                                                ?>
                                                    <button type="button"
                                                        @click="selectCourse(<?= $course['id'] ?>, '<?= htmlspecialchars(addslashes($course['title'])) ?>')"
                                                        x-show="!search || '<?= htmlspecialchars(addslashes($course['title'])) ?>'.toLowerCase().includes(search.toLowerCase())"
                                                        :class="selected === <?= $course['id'] ?> ? 'bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white' : 'text-gray-700 hover:bg-blue-50'"
                                                        class="w-full px-6 py-4 text-left transition-all duration-300 flex items-center gap-4 hover:pl-8 group/option">

                                                        <div :class="selected === <?= $course['id'] ?> ? 'bg-white/20' : '<?= $colors['bg'] ?>'"
                                                            class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                                            <i class="fas <?= $course['icon'] ?? 'fa-balance-scale' ?>"
                                                                :class="selected === <?= $course['id'] ?> ? 'text-white' : '<?= $colors['text'] ?>'"></i>
                                                        </div>

                                                        <div class="flex-1">
                                                            <div class="font-semibold text-base"><?= htmlspecialchars($course['title']) ?></div>
                                                            <div class="text-sm opacity-75 flex items-center gap-2 mt-1"
                                                                :class="selected === <?= $course['id'] ?> ? 'text-white/90' : 'text-gray-500'">
                                                                <span><i class="far fa-clock mr-1"></i><?= $course['duration_text'] ?></span>
                                                                <?php if (isset($course['level_id']) && isset($levelsById[$course['level_id']])): ?>
                                                                    <span class="h-1 w-1 rounded-full bg-current opacity-50"></span>
                                                                    <span><i class="fas fa-user-graduate mr-1"></i><?= $levelsById[$course['level_id']]['name'] ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <div class="text-right">
                                                            <div class="font-bold" :class="selected === <?= $course['id'] ?> ? 'text-white' : 'text-[#0F2854]'">
                                                                Rs <?= number_format($course['price_rs'], 0) ?>
                                                            </div>
                                                        </div>

                                                        <i x-show="selected === <?= $course['id'] ?>" class="fas fa-check text-white ml-4"></i>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Educational Background -->
                            <div class="group">
                                <label class="block text-gray-700 font-semibold mb-3 flex items-center text-lg">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-university text-[#1C4D8D] text-sm"></i>
                                    </div>
                                    Educational Background *
                                </label>
                                <div class="relative">
                                    <textarea name="student_background" id="student-background" rows="4" required
                                        class="w-full px-5 py-4 pl-12 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] focus:ring-4 focus:ring-blue-50/50 outline-none transition-all duration-500 hover:border-blue-300 hover:shadow-lg resize-none placeholder-gray-400 text-base"
                                        placeholder="Tell us about your current studies, university, year, and any relevant experience..."></textarea>
                                    <div class="absolute left-4 top-6 transform -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-pen-fancy"></i>
                                    </div>
                                    <div class="absolute right-4 bottom-4 text-xs text-gray-400">
                                        <span id="char-count">0</span>/500 characters
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-4">
                                            <i class="fas fa-info-circle text-[#1C4D8D]"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-lg mb-2">Additional Information</h4>
                                        <p class="text-gray-600 text-base mb-3 text-justify">
                                            Please include any specific questions or requirements you may have.
                                        </p>
                                        <textarea name="additional_info" id="additional-info"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-50 outline-none transition duration-300 resize-none text-base"
                                            rows="2" placeholder="Additional comments or questions..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-8 border-t border-gray-100">
                            <button type="submit"
                                class="relative w-full btn-primary text-white py-5 rounded-2xl font-semibold text-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    <span>Submit Enrollment Request</span>
                                    <i class="fas fa-paper-plane transition-transform duration-500 group-hover:translate-x-2 group-hover:rotate-12"></i>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#0F2854] via-[#1C4D8D] to-[#0F2854] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent via-white/30 to-transparent group-hover:animate-shine"></div>
                            </button>

                            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center text-gray-500 text-base">
                                        <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                                        <span>Secure & Encrypted</span>
                                    </div>
                                    <div class="h-4 w-px bg-gray-300"></div>
                                    <div class="flex items-center text-gray-500 text-base">
                                        <i class="fas fa-lock text-blue-500 mr-2"></i>
                                        <span>Privacy Protected</span>
                                    </div>
                                </div>
                                <p class="text-center text-gray-500 text-base">
                                    <i class="far fa-clock mr-1"></i>
                                    We'll contact you within 48 hours
                                </p>
                            </div>
                        </div>
                    </form>

                    <!-- Success Message -->
                    <div id="enrollment-success" class="hidden mt-8 p-8 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl shadow-lg animate-fade-in">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-2xl font-bold text-green-800 mb-2">Enrollment Request Submitted!</h4>
                                <p class="text-green-700 text-lg mb-4 text-justify">Thank you for your interest. We'll contact you shortly.</p>
                                <div class="flex items-center text-green-600 text-base">
                                    <i class="fas fa-envelope-open-text mr-2"></i>
                                    <span>Confirmation email sent</span>
                                </div>
                                <div class="flex items-center text-green-600 text-base mt-2">
                                    <i class="fas fa-user-check mr-2"></i>
                                    <span>Application ID: #STU-<span id="application-id">0000</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Support Info -->
                <div class="text-center mt-10">
                    <div class="inline-flex items-center text-gray-600 text-base">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                            <i class="fas fa-headset text-[#1C4D8D]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-base">Need help with enrollment?</p>
                            <a href="mailto:contact@precisionlawfirm.net" class="font-semibold text-[#1C4D8D] hover:text-[#0F2854] text-base">
                                contact@precisionlawfirm.net
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer - Correction du chemin -->
    <?php include "../includes/footer.php"; ?>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50
        });

        // Course filtering
        function filterCourses(category) {
            const courses = document.querySelectorAll('.course-card');
            const tabs = document.querySelectorAll('.tab-button');

            tabs.forEach(tab => {
                tab.classList.remove('active');
                if (category === 'all' && tab.textContent.includes('All')) tab.classList.add('active');
                else if (tab.textContent.toLowerCase().includes(category)) tab.classList.add('active');
            });

            courses.forEach(course => {
                if (category === 'all' || course.dataset.category === category) {
                    course.style.display = 'block';
                } else {
                    course.style.display = 'none';
                }
            });
        }

        // --- Alpine.js Course Selector ---
        function courseSelector() {
            return {
                open: false,
                search: '',
                selected: null,
                selectedTitle: '',
                selectCourse(id, title) {
                    this.selected = id;
                    this.selectedTitle = title;
                    this.$refs.select.value = id; // met à jour le <select> caché
                    this.open = false;
                    this.search = '';
                    // met à jour l'input caché pour le formulaire
                    const selectedCourseInput = document.getElementById('selected-course-id');
                    if (selectedCourseInput) selectedCourseInput.value = id;
                }
            }
        }

        // --- Character counter for textarea ---
        const backgroundTextarea = document.getElementById('student-background');
        const charCount = document.getElementById('char-count');
        if (backgroundTextarea) {
            backgroundTextarea.addEventListener('input', () => {
                let length = backgroundTextarea.value.length;
                if (length > 500) {
                    backgroundTextarea.value = backgroundTextarea.value.substring(0, 500);
                    length = 500;
                }
                charCount.textContent = length;
            });
        }

        // --- Form Submission ---
        document.getElementById('enrollment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const courseSelect = document.getElementById('course-select');
            if (!courseSelect.value) {
                alert('Please select a course');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
        <div class="flex items-center justify-center gap-3">
            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            <span>Processing...</span>
        </div>
    `;

            // Envoi via fetch vers enroll.php
            const formData = new FormData(this);
            fetch('enroll.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('application-id').textContent = data.applicationCode.slice(4);
                        document.getElementById('enrollment-success').classList.remove('hidden');
                        this.reset();
                        courseSelect.value = '';
                        if (document.getElementById('selected-course-id')) {
                            document.getElementById('selected-course-id').value = '';
                        }
                        charCount.textContent = '0';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(() => {
                    alert('Erreur lors de l\'envoi. Veuillez réessayer.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `
            <span class="relative z-10 flex items-center justify-center gap-3">
                <span>Submit Enrollment Request</span>
                <i class="fas fa-paper-plane"></i>
            </span>
        `;
                });
        });

        // --- Smooth scrolling for anchors ---
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href') !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>