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

// --- Fetch Courses ---
$courses = [];
try {
    $stmt = $pdo->query("SELECT * FROM courses WHERE is_active = 1 ORDER BY sort_order ASC");
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



// Function to format category name
function formatCategory($category)
{
    $categories = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced'
    ];
    return $categories[$category] ?? ucfirst($category);
}

// Function to get color classes based on category
function getCategoryColor($category)
{
    $colors = [
        'beginner' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-700', 'light' => 'bg-blue-100'],
        'intermediate' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-700', 'light' => 'bg-green-100'],
        'advanced' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-700', 'light' => 'bg-purple-100']
    ];
    return $colors[$category] ?? $colors['beginner'];
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
                <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto ">
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
                    <p class="text-xl text-gray-600 mt-4 md:mt-0 max-w-xl ">
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
                            <p class="text-gray-600 text-lg "><?= htmlspecialchars($benefit['description']) ?></p>
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
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto ">
                        Choose from our specialized courses designed to complement your academic studies with practical Services.
                    </p>
                </div>

                <!-- Course Tabs -->
                <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up-slow">
                    <button class="tab-button active px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base" onclick="filterCourses('all')">
                        All Courses
                    </button>
                    <button class="tab-button px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base" onclick="filterCourses('beginner')">
                        Beginner
                    </button>
                    <button class="tab-button px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base" onclick="filterCourses('intermediate')">
                        Intermediate
                    </button>
                    <button class="tab-button px-8 py-3 rounded-full font-medium bg-white border border-gray-200 text-base" onclick="filterCourses('advanced')">
                        Advanced
                    </button>
                </div>

                <!-- Courses Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($courses as $index => $course):
                        $colors = getCategoryColor($course['category'] ?? 'beginner');
                    ?>
                        <div class="course-card bg-white rounded-xl border border-gray-200 p-8 hover-lift"
                            data-aos="zoom-slow" data-aos-delay="<?= ($index % 3) * 100 ?>"
                            data-category="<?= $course['category'] ?? 'beginner' ?>">
                            <div class="mb-4 flex justify-between items-center">
                                <span class="<?= $colors['light'] ?> <?= $colors['text'] ?> px-3 py-1 rounded-full text-sm font-medium">
                                    <?= formatCategory($course['category'] ?? 'beginner') ?>
                                </span>
                                <span class="text-gray-500 text-base">
                                    <i class="far fa-clock mr-1"></i> <?= $course['duration_weeks'] ?? 8 ?> weeks
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($course['title']) ?></h3>
                            <p class="text-gray-600 text-lg mb-4 "><?= htmlspecialchars($course['description']) ?></p>
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
                                <a href="#enroll"
                                    data-course-id="<?= $course['id'] ?>"
                                    data-course-title="<?= htmlspecialchars($course['title']) ?>"
                                    data-course-category="<?= $course['category'] ?? 'beginner' ?>"
                                    data-course-duration="<?= $course['duration_weeks'] ?? 8 ?>"
                                    data-course-instructor="<?= htmlspecialchars($course['instructor_name'] ?? 'TBD') ?>"
                                    class="btn-primary text-white px-6 py-3 rounded-lg font-medium text-base hover-lift select-course enroll-btn">
                                    Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto ">
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
                                    <p class="text-gray-600 text-base "><?= htmlspecialchars($module['description']) ?></p>
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
                                        <span class="text-gray-700 "><?= htmlspecialchars($feature['feature']) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
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
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Hear from students who have transformed their legal education through our programs.
                    </p>
                </div>

                <?php if (empty($testimonials)): ?>
                    <!-- No Testimonials Yet - Simple Design -->
                    <div class="max-w-2xl mx-auto text-center py-16 px-8" data-aos="fade-up-slow">
                        <div class="mb-8">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-comment-dots text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">No Testimonials Yet</h3>
                            <p class="text-xl text-gray-600 mb-8">
                                Be the first to share your experience with our legal education programs.
                            </p>
                            <div class="inline-flex items-center gap-2 text-[#1C4D8D] font-medium">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span>Your story could inspire future students</span>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                        </div>

                        <!-- Simple decorative elements -->
                        <div class="flex justify-center gap-4 mt-12">
                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Testimonials Grid -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <?php foreach ($testimonials as $index => $testimonial):
                            $colors = getCategoryColor($testimonial['icon_color'] ?? 'blue');
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
                                <p class="text-gray-600 text-lg italic mb-4">
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
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Enrollment Section -->
    <section id="enroll" class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 lg:px-24 relative z-10">
            <div class="max-w-4xl mx-auto">

                <!-- Header -->
                <div class="text-center mb-16">
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-4">
                        <span class="text-[#0F2854]">Ready to</span>
                        <span class="text-[#1C4D8D] relative">
                            Enroll?
                        </span>
                    </h2>
                    <p class="text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Take the next step in your legal education journey.
                        Limited seats available for each course.
                    </p>
                </div>

                <!-- Selected Course Preview -->
                <div id="selected-course-preview" class="bg-white rounded-xl p-6 mb-8 border-2 border-[#1C4D8D] hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Selected Course:</h3>
                            <p class="text-2xl font-bold text-[#1C4D8D]" id="preview-title"></p>
                            <div class="flex gap-4 mt-2 text-sm text-gray-600">
                                <span id="preview-category"></span>
                                <span id="preview-duration"></span>
                                <span id="preview-instructor"></span>
                            </div>
                        </div>
                        <button onclick="clearSelectedCourse()" class="text-gray-400 hover:text-red-500">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-10 md:p-16 border border-gray-100">
                    <form id="enrollment-form"
                        class="space-y-8"
                        method="POST"
                        action="enroll.php"
                        x-data="courseSelector()">

                        <!-- PERSONAL INFO -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold mb-3">Full Name *</label>
                                <input type="text"
                                    name="student_name"
                                    required
                                    class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] outline-none">
                            </div>
                            <div>
                                <label class="block font-semibold mb-3">Email Address *</label>
                                <input type="email"
                                    name="student_email"
                                    required
                                    class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] outline-none">
                            </div>
                        </div>

                        <!-- PHONE -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold mb-3">Phone Number *</label>
                                <input type="tel"
                                    name="student_phone"
                                    required
                                    class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] outline-none">
                            </div>
                            <div>
                                <label class="block font-semibold mb-3">Year of Study</label>
                                <select name="student_year"
                                    class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] outline-none">
                                    <option value="">Select your year</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="LLM">LLM</option>
                                    <option value="Graduate">Graduate</option>
                                </select>
                            </div>
                        </div>

                        <!-- COURSE SELECTOR (Hidden but maintained for form submission) -->
                        <select name="course_id" required class="hidden" id="course-select" x-ref="select">
                            <option value="">Choose your course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>"
                                    data-title="<?= htmlspecialchars($course['title']) ?>"
                                    data-category="<?= formatCategory($course['category'] ?? 'beginner') ?>"
                                    data-duration="<?= $course['duration_weeks'] ?? 8 ?> weeks"
                                    data-instructor="<?= htmlspecialchars($course['instructor_name'] ?? 'TBD') ?>">
                                    <?= htmlspecialchars($course['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- EDUCATION -->
                        <div>
                            <label class="block font-semibold mb-3">Educational Background *</label>
                            <textarea name="student_background"
                                rows="4"
                                required
                                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-[#1C4D8D] outline-none"></textarea>
                        </div>

                        <!-- ADDITIONAL INFO -->
                        <div>
                            <label class="block font-semibold mb-3">Additional Information</label>
                            <textarea name="additional_info"
                                rows="2"
                                class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] outline-none"></textarea>
                        </div>

                        <!-- SUBMIT -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#0F2854] to-[#1C4D8D] text-white py-4 rounded-2xl font-semibold text-lg hover:shadow-xl transition">
                            Submit Enrollment Request
                        </button>
                    </form>
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

        // Alpine.js component for course selector
        function courseSelector() {
            return {
                open: false,
                selected: null,
                selectedTitle: '',

                selectCourse(id, title) {
                    this.selected = id;
                    this.selectedTitle = title;
                    this.$refs.select.value = id;
                    this.open = false;
                }
            }
        }

        // Handle Enroll Now buttons
        document.addEventListener('DOMContentLoaded', function() {
            const enrollButtons = document.querySelectorAll('.enroll-btn');
            const courseSelect = document.getElementById('course-select');
            const previewDiv = document.getElementById('selected-course-preview');
            const previewTitle = document.getElementById('preview-title');
            const previewCategory = document.getElementById('preview-category');
            const previewDuration = document.getElementById('preview-duration');
            const previewInstructor = document.getElementById('preview-instructor');

            enrollButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const courseId = this.dataset.courseId;
                    const courseTitle = this.dataset.courseTitle;
                    const courseCategory = this.dataset.courseCategory;
                    const courseDuration = this.dataset.courseDuration;
                    const courseInstructor = this.dataset.courseInstructor;

                    // Update hidden select
                    if (courseSelect) {
                        courseSelect.value = courseId;
                    }

                    // Update preview
                    if (previewDiv && previewTitle) {
                        previewTitle.textContent = courseTitle;
                        previewCategory.textContent = '📚 ' + formatCategory(courseCategory);
                        previewDuration.textContent = '⏱️ ' + courseDuration + ' weeks';
                        previewInstructor.textContent = '👨‍🏫 ' + courseInstructor;
                        previewDiv.classList.remove('hidden');
                    }

                    // Scroll to enrollment form
                    document.getElementById('enroll').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Check for course ID in URL (for direct links)
            const urlParams = new URLSearchParams(window.location.search);
            const courseId = urlParams.get('course');
            if (courseId) {
                const courseOption = document.querySelector(`#course-select option[value="${courseId}"]`);
                if (courseOption) {
                    courseSelect.value = courseId;
                    previewTitle.textContent = courseOption.dataset.title;
                    previewCategory.textContent = '📚 ' + courseOption.dataset.category;
                    previewDuration.textContent = '⏱️ ' + courseOption.dataset.duration;
                    previewInstructor.textContent = '👨‍🏫 ' + courseOption.dataset.instructor;
                    previewDiv.classList.remove('hidden');
                }
            }
        });

        // Clear selected course
        function clearSelectedCourse() {
            const courseSelect = document.getElementById('course-select');
            const previewDiv = document.getElementById('selected-course-preview');

            if (courseSelect) {
                courseSelect.value = '';
            }
            if (previewDiv) {
                previewDiv.classList.add('hidden');
            }
        }

        // Helper function to format category
        function formatCategory(category) {
            const categories = {
                'beginner': 'Beginner',
                'intermediate': 'Intermediate',
                'advanced': 'Advanced'
            };
            return categories[category] || category.charAt(0).toUpperCase() + category.slice(1);
        }

        // Form submission
        document.getElementById('enrollment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const courseSelect = document.getElementById('course-select');
            if (!courseSelect || !courseSelect.value) {
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
                        alert('Enrollment submitted successfully! We will contact you soon.');
                        this.reset();
                        clearSelectedCourse();
                    } else {
                        alert(data.message || 'Error submitting enrollment. Please try again.');
                    }
                })
                .catch(() => {
                    alert('Error submitting enrollment. Please try again.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `Submit Enrollment Request`;
                });
        });
    </script>
</body>

</html>