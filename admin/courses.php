<?php
require '../config.php';
session_start();

// Simple authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Update Hero Section
    if (isset($_POST['update_hero'])) {
        $check = $pdo->query("SELECT COUNT(*) FROM courses_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE courses_hero SET title_line1 = ?, title_line2 = ?, subtitle = ?, background_image = ?, primary_button_text = ?, primary_button_link = ?, secondary_button_text = ?, secondary_button_link = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title_line1'],
                $_POST['title_line2'],
                $_POST['subtitle'],
                $_POST['background_image'],
                $_POST['primary_button_text'],
                $_POST['primary_button_link'],
                $_POST['secondary_button_text'],
                $_POST['secondary_button_link'],
                $_POST['hero_id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO courses_hero (title_line1, title_line2, subtitle, background_image, primary_button_text, primary_button_link, secondary_button_text, secondary_button_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['title_line1'],
                $_POST['title_line2'],
                $_POST['subtitle'],
                $_POST['background_image'],
                $_POST['primary_button_text'],
                $_POST['primary_button_link'],
                $_POST['secondary_button_text'],
                $_POST['secondary_button_link']
            ]);
        }
        $success = "Hero section updated successfully!";
    }
    
    // Add Benefit
    if (isset($_POST['add_benefit'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM course_benefits")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO course_benefits (icon, title, description, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['icon'], $_POST['title'], $_POST['description'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Benefit added successfully!";
    }
    
    // Update Benefit
    if (isset($_POST['update_benefit'])) {
        $stmt = $pdo->prepare("UPDATE course_benefits SET icon = ?, title = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['icon'], $_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['benefit_id']]);
        $success = "Benefit updated successfully!";
    }
    
    // Delete Benefit
    if (isset($_POST['delete_benefit'])) {
        $stmt = $pdo->prepare("DELETE FROM course_benefits WHERE id = ?");
        $stmt->execute([$_POST['benefit_id']]);
        $success = "Benefit deleted successfully!";
    }
    
    // Add Level
    if (isset($_POST['add_level'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM course_levels")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));
        $stmt = $pdo->prepare("INSERT INTO course_levels (name, slug, color, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $slug, $_POST['color'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Level added successfully!";
    }
    
    // Update Level
    if (isset($_POST['update_level'])) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));
        $stmt = $pdo->prepare("UPDATE course_levels SET name = ?, slug = ?, color = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $slug, $_POST['color'], isset($_POST['is_active']) ? 1 : 0, $_POST['level_id']]);
        $success = "Level updated successfully!";
    }
    
    // Delete Level
    if (isset($_POST['delete_level'])) {
        // First update courses with this level
        $stmt = $pdo->prepare("UPDATE courses SET level_id = NULL WHERE level_id = ?");
        $stmt->execute([$_POST['level_id']]);
        // Then delete the level
        $stmt = $pdo->prepare("DELETE FROM course_levels WHERE id = ?");
        $stmt->execute([$_POST['level_id']]);
        $success = "Level deleted successfully!";
    }
    
    // Add Course
    if (isset($_POST['add_course'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM courses")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO courses (title, description, category, level_id, duration_text, price_rs, instructor_name, start_date, icon, features, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $_POST['category'],
            $_POST['level_id'] ?: null,
            $_POST['duration_text'],
            $_POST['price_rs'],
            $_POST['instructor_name'],
            $_POST['start_date'],
            $_POST['icon'],
            $_POST['features'],
            $sort_order,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Course added successfully!";
    }
    
    // Update Course
    if (isset($_POST['update_course'])) {
        $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ?, category = ?, level_id = ?, duration_text = ?, price_rs = ?, instructor_name = ?, start_date = ?, icon = ?, features = ?, featured = ?, is_active = ? WHERE id = ?");
        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $_POST['category'],
            $_POST['level_id'] ?: null,
            $_POST['duration_text'],
            $_POST['price_rs'],
            $_POST['instructor_name'],
            $_POST['start_date'],
            $_POST['icon'],
            $_POST['features'],
            isset($_POST['featured']) ? 1 : 0,
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['course_id']
        ]);
        $success = "Course updated successfully!";
    }
    
    // Delete Course
    if (isset($_POST['delete_course'])) {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$_POST['course_id']]);
        $success = "Course deleted successfully!";
    }
    
    // Add Module
    if (isset($_POST['add_module'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM course_modules")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO course_modules (title, description, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Module added successfully!";
    }
    
    // Update Module
    if (isset($_POST['update_module'])) {
        $stmt = $pdo->prepare("UPDATE course_modules SET title = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['module_id']]);
        $success = "Module updated successfully!";
    }
    
    // Delete Module
    if (isset($_POST['delete_module'])) {
        $stmt = $pdo->prepare("DELETE FROM course_modules WHERE id = ?");
        $stmt->execute([$_POST['module_id']]);
        $success = "Module deleted successfully!";
    }
    
    // Add Feature
    if (isset($_POST['add_feature'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM course_features")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO course_features (feature, sort_order, is_active) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['feature'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Feature added successfully!";
    }
    
    // Update Feature
    if (isset($_POST['update_feature'])) {
        $stmt = $pdo->prepare("UPDATE course_features SET feature = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['feature'], isset($_POST['is_active']) ? 1 : 0, $_POST['feature_id']]);
        $success = "Feature updated successfully!";
    }
    
    // Delete Feature
    if (isset($_POST['delete_feature'])) {
        $stmt = $pdo->prepare("DELETE FROM course_features WHERE id = ?");
        $stmt->execute([$_POST['feature_id']]);
        $success = "Feature deleted successfully!";
    }
    
    // Add Stat
    if (isset($_POST['add_stat'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM course_stats")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO course_stats (label, value, sort_order) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['label'], $_POST['value'], $sort_order]);
        $success = "Stat added successfully!";
    }
    
    // Update Stat
    if (isset($_POST['update_stat'])) {
        $stmt = $pdo->prepare("UPDATE course_stats SET label = ?, value = ? WHERE id = ?");
        $stmt->execute([$_POST['label'], $_POST['value'], $_POST['stat_id']]);
        $success = "Stat updated successfully!";
    }
    
    // Delete Stat
    if (isset($_POST['delete_stat'])) {
        $stmt = $pdo->prepare("DELETE FROM course_stats WHERE id = ?");
        $stmt->execute([$_POST['stat_id']]);
        $success = "Stat deleted successfully!";
    }
    
    // Add Instructor
    if (isset($_POST['add_instructor'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM instructors")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO instructors (name, title, bio, icon_color, specialties, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['title'],
            $_POST['bio'],
            $_POST['icon_color'],
            $_POST['specialties'],
            $sort_order,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Instructor added successfully!";
    }
    
    // Update Instructor
    if (isset($_POST['update_instructor'])) {
        $stmt = $pdo->prepare("UPDATE instructors SET name = ?, title = ?, bio = ?, icon_color = ?, specialties = ?, is_active = ? WHERE id = ?");
        $stmt->execute([
            $_POST['name'],
            $_POST['title'],
            $_POST['bio'],
            $_POST['icon_color'],
            $_POST['specialties'],
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['instructor_id']
        ]);
        $success = "Instructor updated successfully!";
    }
    
    // Delete Instructor
    if (isset($_POST['delete_instructor'])) {
        $stmt = $pdo->prepare("DELETE FROM instructors WHERE id = ?");
        $stmt->execute([$_POST['instructor_id']]);
        $success = "Instructor deleted successfully!";
    }
    
    // Add Testimonial
    if (isset($_POST['add_testimonial'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM student_testimonials")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO student_testimonials (student_name, student_year, content, rating, icon_color, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['student_name'],
            $_POST['student_year'],
            $_POST['content'],
            $_POST['rating'],
            $_POST['icon_color'],
            $sort_order,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Testimonial added successfully!";
    }
    
    // Update Testimonial
    if (isset($_POST['update_testimonial'])) {
        $stmt = $pdo->prepare("UPDATE student_testimonials SET student_name = ?, student_year = ?, content = ?, rating = ?, icon_color = ?, is_active = ? WHERE id = ?");
        $stmt->execute([
            $_POST['student_name'],
            $_POST['student_year'],
            $_POST['content'],
            $_POST['rating'],
            $_POST['icon_color'],
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['testimonial_id']
        ]);
        $success = "Testimonial updated successfully!";
    }
    
    // Delete Testimonial
    if (isset($_POST['delete_testimonial'])) {
        $stmt = $pdo->prepare("DELETE FROM student_testimonials WHERE id = ?");
        $stmt->execute([$_POST['testimonial_id']]);
        $success = "Testimonial deleted successfully!";
    }
    
    // Update sort order for benefits
    if (isset($_POST['update_benefit_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE course_benefits SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Benefit sort order updated successfully!";
    }
    
    // Update sort order for courses
    if (isset($_POST['update_course_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE courses SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Course sort order updated successfully!";
    }
    
    // Update sort order for modules
    if (isset($_POST['update_module_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE course_modules SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Module sort order updated successfully!";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM courses_hero ORDER BY id DESC LIMIT 1")->fetch();
$benefits = $pdo->query("SELECT * FROM course_benefits ORDER BY sort_order ASC")->fetchAll();
$levels = $pdo->query("SELECT * FROM course_levels ORDER BY sort_order ASC")->fetchAll();
$courses = $pdo->query("SELECT * FROM courses ORDER BY sort_order ASC")->fetchAll();
$modules = $pdo->query("SELECT * FROM course_modules ORDER BY sort_order ASC")->fetchAll();
$features = $pdo->query("SELECT * FROM course_features ORDER BY sort_order ASC")->fetchAll();
$stats = $pdo->query("SELECT * FROM course_stats ORDER BY sort_order ASC")->fetchAll();
$instructors = $pdo->query("SELECT * FROM instructors ORDER BY sort_order ASC")->fetchAll();
$testimonials = $pdo->query("SELECT * FROM student_testimonials ORDER BY sort_order ASC")->fetchAll();

// Color options for dropdown
$colorOptions = [
    'blue' => 'Blue',
    'purple' => 'Purple',
    'green' => 'Green',
    'orange' => 'Orange',
    'red' => 'Red'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Courses | Precision Law Firm</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
        }
        
        .admin-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }
        .admin-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .section-header {
            background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem 0.75rem 0 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .section-header:hover {
            opacity: 0.95;
        }
        .section-header i {
            transition: transform 0.3s ease;
        }
        .section-header.collapsed i {
            transform: rotate(-90deg);
        }
        .section-content {
            transition: all 0.3s ease;
        }
        .section-content.collapsed {
            display: none;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-input:focus {
            outline: none;
            border-color: #1C4D8D;
            box-shadow: 0 0 0 3px rgba(28, 77, 141, 0.1);
        }
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
            min-height: 100px;
        }
        .form-textarea:focus {
            outline: none;
            border-color: #1C4D8D;
            box-shadow: 0 0 0 3px rgba(28, 77, 141, 0.1);
        }
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
            background-color: white;
        }
        .form-select:focus {
            outline: none;
            border-color: #1C4D8D;
            box-shadow: 0 0 0 3px rgba(28, 77, 141, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .btn-danger {
            background: #dc2626;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .btn-success {
            background: #059669;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: #047857;
        }
        .btn-warning {
            background: #d97706;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            background: #b45309;
        }
        .table-row {
            transition: all 0.3s ease;
        }
        .table-row:hover {
            background: #f9fafb;
        }
        .success-message {
            background: #10b981;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            animation: slideDown 0.5s ease;
        }
        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Admin badge */
        .admin-badge {
            background: #D4AF37;
            color: #0F2854;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-left: 1rem;
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* AOS animations */
        [data-aos] {
            transition-duration: 1500ms !important;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar - EXACT same as accueil admin panel -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4" data-aos="fade-down-slow"
        data-aos-duration="1200" data-aos-easing="ease-out-cubic">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 w-full justify-between">

                    <!-- Logo with Admin Badge -->
                    <div class="flex items-center">
                        <div class="text-[#D4AF37] font-bold text-2xl tracking-tight">
                            Precision Law Firm
                        </div>
                        <span class="admin-badge">Admin</span>
                    </div>

                    <!-- Navigation - Points to client pages -->
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
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
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
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
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
                    <div class="flex items-center">
                        <div class="text-[#D4AF37] font-bold text-xl">
                            Precision Law Firm
                        </div>
                        <span class="admin-badge text-xs ml-2">Admin</span>
                    </div>

                    <button id="mobile-menu-button" class="text-gray-700 text-2xl transition duration-300">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-3">
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
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Jurisprudence
                    </a>
                    <a href="courses.php"
                        class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">
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
                    <!-- Admin Logout in mobile -->
                    <a href="logout.php"
                        class="bg-red-600 text-white px-4 py-3 rounded-md font-medium text-center mt-4 transition duration-300 text-base">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout (Admin)
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-24 py-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8" data-aos="fade-up-slow">
            <h1 class="text-3xl font-bold text-[#0F2854]">Courses Page Management</h1>
            <a href="courses.php" target="_blank" class="btn-primary inline-flex items-center">
                <i class="fas fa-external-link-alt mr-2"></i>View Live Page
            </a>
        </div>

        <!-- Success Message -->
        <?php if (isset($success)): ?>
            <div class="success-message" data-aos="fade-up-slow">
                <i class="fas fa-check-circle mr-2"></i><?= $success ?>
            </div>
        <?php endif; ?>

        <!-- Hero Section Management -->
        <div id="hero-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('hero-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-home mr-2"></i>Hero Section</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="hero-content" class="section-content p-6">
                <form method="POST">
                    <input type="hidden" name="hero_id" value="<?= $hero['id'] ?? '' ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title Line 1</label>
                            <input type="text" name="title_line1" value="<?= htmlspecialchars($hero['title_line1'] ?? 'Continuous Learning Legal Education') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title Line 2</label>
                            <input type="text" name="title_line2" value="<?= htmlspecialchars($hero['title_line2'] ?? 'for Students') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <textarea name="subtitle" rows="2" class="form-textarea"><?= htmlspecialchars($hero['subtitle'] ?? 'Bridging theory with practice. Join our specialized legal courses designed for law students and aspiring legal professionals.') ?></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Image URL</label>
                            <input type="text" name="background_image" value="<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                            <input type="text" name="primary_button_text" value="<?= htmlspecialchars($hero['primary_button_text'] ?? 'Explore Courses') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Link</label>
                            <input type="text" name="primary_button_link" value="<?= htmlspecialchars($hero['primary_button_link'] ?? '#courses') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                            <input type="text" name="secondary_button_text" value="<?= htmlspecialchars($hero['secondary_button_text'] ?? 'Why Join Our Program?') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Link</label>
                            <input type="text" name="secondary_button_link" value="<?= htmlspecialchars($hero['secondary_button_link'] ?? '#why-join') ?>" class="form-input">
                        </div>
                    </div>
                    <button type="submit" name="update_hero" class="btn-primary mt-4">
                        <i class="fas fa-save mr-2"></i>Update Hero Section
                    </button>
                </form>
            </div>
        </div>

        <!-- Benefits Management -->
        <div id="benefits-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('benefits-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-gem mr-2"></i>Why Join Benefits</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="benefits-content" class="section-content p-6">
                <!-- Add New Benefit -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Benefit</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-user-tie)" class="form-input" required>
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <div class="col-span-2">
                            <textarea name="description" rows="2" placeholder="Description" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_benefit" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Benefit
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Benefit Sort Order -->
                <form method="POST" class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Benefits Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Icon</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-left">Active</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($benefits as $benefit): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <input type="hidden" name="sort_ids[]" value="<?= $benefit['id'] ?>">
                                    <input type="number" name="sort_orders[]" value="<?= $benefit['sort_order'] ?>" class="form-input text-sm w-20">
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="benefit_id" value="<?= $benefit['id'] ?>">
                                        <input type="text" name="icon" value="<?= htmlspecialchars($benefit['icon']) ?>" class="form-input text-sm w-24">
                                </td>
                                <td class="px-4 py-3">
                                        <input type="text" name="title" value="<?= htmlspecialchars($benefit['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <input type="text" name="description" value="<?= htmlspecialchars($benefit['description']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $benefit['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_benefit" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this benefit?')">
                                        <input type="hidden" name="benefit_id" value="<?= $benefit['id'] ?>">
                                        <button type="submit" name="delete_benefit" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_benefit_sort" class="btn-warning mt-4">
                        <i class="fas fa-sort mr-2"></i>Update Benefit Sort Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Course Levels Management -->
        <div id="levels-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('levels-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-layer-group mr-2"></i>Course Levels</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="levels-content" class="section-content p-6">
                <!-- Add New Level -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Level</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Level Name (e.g., Beginner)" class="form-input" required>
                        <select name="color" class="form-select" required>
                            <?php foreach ($colorOptions as $value => $label): ?>
                                <option value="<?= $value ?>"><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_level" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Level
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Levels -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Slug</th>
                            <th class="px-4 py-2 text-left">Color</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($levels as $level): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="level_id" value="<?= $level['id'] ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($level['name']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <span class="text-sm text-gray-600"><?= htmlspecialchars($level['slug']) ?></span>
                            </td>
                            <td class="px-4 py-3">
                                    <select name="color" class="form-input text-sm">
                                        <?php foreach ($colorOptions as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= $level['color'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $level['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_level" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this level? Courses with this level will be unassigned.')">
                                    <input type="hidden" name="level_id" value="<?= $level['id'] ?>">
                                    <button type="submit" name="delete_level" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Courses Management -->
        <div id="courses-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('courses-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-book mr-2"></i>Courses</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="courses-content" class="section-content p-6">
                <!-- Add New Course -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Course</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <input type="text" name="title" placeholder="Course Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <textarea name="description" rows="2" placeholder="Course Description" class="form-textarea" required></textarea>
                        </div>
                        <div>
                            <input type="text" name="category" placeholder="Category (e.g., beginner)" class="form-input">
                        </div>
                        <div>
                            <select name="level_id" class="form-select">
                                <option value="">Select Level</option>
                                <?php foreach ($levels as $level): ?>
                                    <option value="<?= $level['id'] ?>"><?= htmlspecialchars($level['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="duration_text" placeholder="Duration (e.g., 8 weeks)" class="form-input" required>
                        </div>
                        <div>
                            <input type="number" name="price_rs" placeholder="Price (Rs)" class="form-input" required>
                        </div>
                        <div>
                            <input type="text" name="instructor_name" placeholder="Instructor Name" class="form-input" required>
                        </div>
                        <div>
                            <input type="date" name="start_date" placeholder="Start Date" class="form-input">
                        </div>
                        <div>
                            <input type="text" name="icon" placeholder="Icon (e.g., fa-balance-scale)" class="form-input">
                        </div>
                        <div></div>
                        <div class="col-span-2">
                            <textarea name="features" rows="2" placeholder="Features (comma separated)" class="form-textarea"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center mr-4">
                                <input type="checkbox" name="featured" value="1" class="mr-2">
                                <span class="text-sm text-gray-700">Featured</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_course" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Course
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Course Sort Order -->
                <form method="POST">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Courses Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Level</th>
                                <th class="px-4 py-2 text-left">Price</th>
                                <th class="px-4 py-2 text-left">Featured</th>
                                <th class="px-4 py-2 text-left">Active</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <input type="hidden" name="sort_ids[]" value="<?= $course['id'] ?>">
                                    <input type="number" name="sort_orders[]" value="<?= $course['sort_order'] ?>" class="form-input text-sm w-20">
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                        <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <input type="text" name="category" value="<?= htmlspecialchars($course['category'] ?? '') ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <select name="level_id" class="form-input text-sm">
                                            <option value="">None</option>
                                            <?php foreach ($levels as $level): ?>
                                                <option value="<?= $level['id'] ?>" <?= ($course['level_id'] ?? '') == $level['id'] ? 'selected' : '' ?>><?= htmlspecialchars($level['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </td>
                                <td class="px-4 py-3">
                                        <input type="number" name="price_rs" value="<?= $course['price_rs'] ?>" class="form-input text-sm w-24">
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="featured" value="1" <?= ($course['featured'] ?? 0) ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $course['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_course" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                        <button type="submit" name="delete_course" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_course_sort" class="btn-warning mt-4">
                        <i class="fas fa-sort mr-2"></i>Update Course Sort Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Modules Management -->
        <div id="modules-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('modules-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-cubes mr-2"></i>Course Modules</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="modules-content" class="section-content p-6">
                <!-- Add New Module -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Module</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <input type="text" name="title" placeholder="Module Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <textarea name="description" rows="2" placeholder="Module Description" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_module" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Module
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Module Sort Order -->
                <form method="POST">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Modules Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-left">Active</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $module): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <input type="hidden" name="sort_ids[]" value="<?= $module['id'] ?>">
                                    <input type="number" name="sort_orders[]" value="<?= $module['sort_order'] ?>" class="form-input text-sm w-20">
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                                        <input type="text" name="title" value="<?= htmlspecialchars($module['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <input type="text" name="description" value="<?= htmlspecialchars($module['description']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $module['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_module" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this module?')">
                                        <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                                        <button type="submit" name="delete_module" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_module_sort" class="btn-warning mt-4">
                        <i class="fas fa-sort mr-2"></i>Update Module Sort Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Features Management -->
        <div id="features-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('features-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-list-check mr-2"></i>Course Features</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="features-content" class="section-content p-6">
                <!-- Add New Feature -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Feature</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <input type="text" name="feature" placeholder="Feature (e.g., Interactive online sessions)" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_feature" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Feature
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Features -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Feature</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($features as $feature): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="feature_id" value="<?= $feature['id'] ?>">
                                    <input type="text" name="feature" value="<?= htmlspecialchars($feature['feature']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $feature['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_feature" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this feature?')">
                                    <input type="hidden" name="feature_id" value="<?= $feature['id'] ?>">
                                    <button type="submit" name="delete_feature" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stats Management -->
        <div id="stats-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('stats-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-chart-simple mr-2"></i>Course Stats</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="stats-content" class="section-content p-6">
                <!-- Add New Stat -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Stat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="label" placeholder="Label (e.g., Hours of Content)" class="form-input" required>
                        <input type="text" name="value" placeholder="Value (e.g., 20+)" class="form-input" required>
                        <div class="col-span-2">
                            <button type="submit" name="add_stat" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Stat
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Stats -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Label</th>
                            <th class="px-4 py-2 text-left">Value</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $stat): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="stat_id" value="<?= $stat['id'] ?>">
                                    <input type="text" name="label" value="<?= htmlspecialchars($stat['label']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="value" value="<?= htmlspecialchars($stat['value']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_stat" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this stat?')">
                                    <input type="hidden" name="stat_id" value="<?= $stat['id'] ?>">
                                    <button type="submit" name="delete_stat" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Instructors Management -->
        <div id="instructors-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('instructors-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-chalkboard-user mr-2"></i>Instructors</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="instructors-content" class="section-content p-6">
                <!-- Add New Instructor -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Instructor</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <input type="text" name="name" placeholder="Full Name" class="form-input" required>
                        </div>
                        <div>
                            <input type="text" name="title" placeholder="Title (e.g., Corporate Law Specialist)" class="form-input" required>
                        </div>
                        <div>
                            <select name="icon_color" class="form-select" required>
                                <?php foreach ($colorOptions as $value => $label): ?>
                                    <option value="<?= $value ?>"><?= $label ?> Color</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <textarea name="bio" rows="2" placeholder="Biography" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <input type="text" name="specialties" placeholder="Specialties (comma separated, e.g., Contracts,M&A)" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_instructor" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Instructor
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Instructors -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Color</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instructors as $instructor): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="instructor_id" value="<?= $instructor['id'] ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($instructor['name']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($instructor['title']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <select name="icon_color" class="form-input text-sm">
                                        <?php foreach ($colorOptions as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= $instructor['icon_color'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $instructor['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_instructor" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this instructor?')">
                                    <input type="hidden" name="instructor_id" value="<?= $instructor['id'] ?>">
                                    <button type="submit" name="delete_instructor" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Testimonials Management -->
        <div id="testimonials-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('testimonials-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-star mr-2"></i>Student Testimonials</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="testimonials-content" class="section-content p-6">
                <!-- Add New Testimonial -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Testimonial</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="student_name" placeholder="Student Name" class="form-input" required>
                        <input type="text" name="student_year" placeholder="Student Year (e.g., 3rd Year Law Student)" class="form-input" required>
                        <div class="col-span-2">
                            <textarea name="content" rows="2" placeholder="Testimonial Content" class="form-textarea" required></textarea>
                        </div>
                        <div>
                            <input type="number" name="rating" placeholder="Rating (1-5)" step="0.5" min="1" max="5" class="form-input" required>
                        </div>
                        <div>
                            <select name="icon_color" class="form-select" required>
                                <?php foreach ($colorOptions as $value => $label): ?>
                                    <option value="<?= $value ?>"><?= $label ?> Color</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_testimonial" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Testimonial
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Testimonials -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Year</th>
                            <th class="px-4 py-2 text-left">Rating</th>
                            <th class="px-4 py-2 text-left">Color</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $testimonial): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="testimonial_id" value="<?= $testimonial['id'] ?>">
                                    <input type="text" name="student_name" value="<?= htmlspecialchars($testimonial['student_name']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="student_year" value="<?= htmlspecialchars($testimonial['student_year']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="number" name="rating" value="<?= $testimonial['rating'] ?>" step="0.5" min="1" max="5" class="form-input text-sm w-20">
                            </td>
                            <td class="px-4 py-3">
                                    <select name="icon_color" class="form-input text-sm">
                                        <?php foreach ($colorOptions as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= $testimonial['icon_color'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $testimonial['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_testimonial" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                    <input type="hidden" name="testimonial_id" value="<?= $testimonial['id'] ?>">
                                    <button type="submit" name="delete_testimonial" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0F2854] text-white py-8 mt-12">
        <div class="container mx-auto px-6 md:px-12 lg:px-24 text-center">
            <p class="text-gray-300 text-base">© 2024 Precision Law Firm Admin Panel. All rights reserved.</p>
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
            once: true
        });

        // Toggle mobile menu
        const mobileButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileButton && mobileMenu) {
            mobileButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
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

        // Toggle sections
        function toggleSection(contentId) {
            const content = document.getElementById(contentId);
            const header = content.previousElementSibling;
            const icon = header.querySelector('i.fa-chevron-down');
            
            content.classList.toggle('collapsed');
            icon.classList.toggle('rotate-[-90deg]');
        }

        // Auto-hide success message after 5 seconds
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>

</html>