<?php
require_once '../config.php';
session_start();

// Simple authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Handle form submissions (same as before)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update Hero
    if (isset($_POST['update_hero'])) {
        $stmt = $pdo->prepare("UPDATE hero SET title = ?, subtitle = ?, description = ?, button_label = ?, button_link = ?, image_url = ? WHERE id = ?");
        $stmt->execute([
            $_POST['title'],
            $_POST['subtitle'],
            $_POST['description'],
            $_POST['button_label'],
            $_POST['button_link'],
            $_POST['image_url'],
            $_POST['hero_id']
        ]);
        $success = "Hero section updated successfully!";
    }

    // Add About Us
    if (isset($_POST['add_about'])) {
        $stmt = $pdo->prepare("INSERT INTO about_us (content) VALUES (?)");
        $stmt->execute([$_POST['content']]);
        $success = "About Us section added successfully!";
    }

    // Update About Us
    if (isset($_POST['update_about'])) {
        $stmt = $pdo->prepare("UPDATE about_us SET content = ? WHERE id = ?");
        $stmt->execute([$_POST['content'], $_POST['about_id']]);
        $success = "About Us section updated successfully!";
    }

    // Delete About Us
    if (isset($_POST['delete_about'])) {
        $stmt = $pdo->prepare("DELETE FROM about_us WHERE id = ?");
        $stmt->execute([$_POST['about_id']]);
        $success = "About Us section deleted successfully!";
    }

    // Add Expertise Area
    if (isset($_POST['add_expertise'])) {
        $stmt = $pdo->prepare("INSERT INTO expertise_areas (name, description) VALUES (?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description']]);
        $success = "Expertise area added successfully!";
    }

    // Update Expertise Area
    if (isset($_POST['update_expertise'])) {
        $stmt = $pdo->prepare("UPDATE expertise_areas SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['expertise_id']]);
        $success = "Expertise area updated successfully!";
    }

    // Delete Expertise Area
    if (isset($_POST['delete_expertise'])) {
        $stmt = $pdo->prepare("DELETE FROM expertise_areas WHERE id = ?");
        $stmt->execute([$_POST['expertise_id']]);
        $success = "Expertise area deleted successfully!";
    }

    // Add Public Service Experience
    if (isset($_POST['add_service'])) {
        $stmt = $pdo->prepare("INSERT INTO public_service (title, description, icon) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon']]);
        $success = "Public service experience added successfully!";
    }

    // Update Public Service Experience
    if (isset($_POST['update_service'])) {
        $stmt = $pdo->prepare("UPDATE public_service SET title = ?, description = ?, icon = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $_POST['service_id']]);
        $success = "Public service experience updated successfully!";
    }

    // Delete Public Service Experience
    if (isset($_POST['delete_service'])) {
        $stmt = $pdo->prepare("DELETE FROM public_service WHERE id = ?");
        $stmt->execute([$_POST['service_id']]);
        $success = "Public service experience deleted successfully!";
    }

    // Add Testimonial
    if (isset($_POST['add_testimonial'])) {
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, position, company, text, rating, initials) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['position'],
            $_POST['company'],
            $_POST['text'],
            $_POST['rating'],
            $_POST['initials']
        ]);
        $success = "Testimonial added successfully!";
    }

    // Update Testimonial
    if (isset($_POST['update_testimonial'])) {
        $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, position = ?, company = ?, text = ?, rating = ?, initials = ? WHERE id = ?");
        $stmt->execute([
            $_POST['name'],
            $_POST['position'],
            $_POST['company'],
            $_POST['text'],
            $_POST['rating'],
            $_POST['initials'],
            $_POST['testimonial_id']
        ]);
        $success = "Testimonial updated successfully!";
    }

    // Delete Testimonial
    if (isset($_POST['delete_testimonial'])) {
        $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$_POST['testimonial_id']]);
        $success = "Testimonial deleted successfully!";
    }

    // Update Stats
    if (isset($_POST['update_stats'])) {
        // You could save these to a database table if needed
        $success = "Statistics updated successfully!";
    }
}

// Fetch all data for display
$hero = $pdo->query("SELECT * FROM hero ORDER BY id DESC LIMIT 1")->fetch();
$about_us = $pdo->query("SELECT * FROM about_us ORDER BY id ASC")->fetchAll();
$expertise = $pdo->query("SELECT * FROM expertise_areas ORDER BY id ASC")->fetchAll();
$public_service = $pdo->query("SELECT * FROM public_service ORDER BY id ASC")->fetchAll();
$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Precision Law Firm</title>
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

        /* Style for button arrow */
        .btn-hover:hover .arrow-icon {
            transform: translateX(5px);
        }

        /* Style for decorative lines */
        .decorative-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, #1C4D8D, transparent);
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

        /* AOS animations slow effect */
        [data-aos] {
            transition-duration: 1500ms !important;
            transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        }

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

        [data-aos="zoom-slow"] {
            transform: scale(0.9);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="zoom-slow"].aos-animate {
            transform: scale(1);
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gray-50">


    <?php include "navbar.php"; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-24 py-8">

        <!-- Header with View Site Button -->
        <div class="flex justify-between items-center mb-8" data-aos="fade-up-slow">
            <h1 class="text-3xl font-bold text-[#0F2854]">Content Management Dashboard</h1>
            <a href="../index.php" target="_blank" class="btn-primary inline-flex items-center">
                <i class="fas fa-external-link-alt mr-2"></i>View Live Site
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
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-home mr-2"></i>Intro Section</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="hero-content" class="section-content p-6">
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="hero_id" value="<?= $hero['id'] ?? '' ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($hero['title'] ?? 'Strategic legal attorneys') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <input type="text" name="subtitle" value="<?= htmlspecialchars($hero['subtitle'] ?? 'with commercial foresight') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="form-input"><?= htmlspecialchars($hero['description'] ?? 'We help businesses resolve disputes, secure deals, and navigate risk through clear thinking, agile action, and strategic precision.') ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="update_hero" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Hero Section
                    </button>
                </form>
            </div>
        </div>

        <!-- About Us Management -->
        <div id="about-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('about-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-info-circle mr-2"></i>About Us Sections</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="about-content" class="section-content p-6">
                <!-- Add New About Section -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New About Section</h3>
                    <div class="flex gap-4">
                        <textarea name="content" rows="2" class="form-input flex-1" placeholder="Enter about us content..." required></textarea>
                        <button type="submit" name="add_about" class="btn-success whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>Add Section
                        </button>
                    </div>
                </form>

                <!-- Existing About Sections -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Content</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($about_us as $about): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="about_id" value="<?= $about['id'] ?>">
                                            <input type="text" name="content" value="<?= htmlspecialchars($about['content']) ?>" class="form-input text-sm flex-1">
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_about" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        </form>
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this section?')">
                                            <input type="hidden" name="about_id" value="<?= $about['id'] ?>">
                                            <button type="submit" name="delete_about" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Public Service Experience Management -->
        <div id="service-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('service-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-university mr-2"></i>Public Service Experience</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="service-content" class="section-content p-6">
                <!-- Add New Service -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Service Experience</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Title (e.g., Government Representation)" class="form-input" required>
                        <input type="text" name="description" placeholder="Description" class="form-input" required>
                        <div class="col-span-2">
                            <button type="submit" name="add_service" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Service
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Services -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($public_service as $service): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                            <input type="text" name="title" value="<?= htmlspecialchars($service['title']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="description" value="<?= htmlspecialchars($service['description']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_service" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        </form>
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                            <button type="submit" name="delete_service" class="text-red-600 hover:text-red-800" title="Delete">
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
        <!-- Testimonials Management -->
        <div id="testimonials-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('testimonials-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-star mr-2"></i>Testimonials</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="testimonials-content" class="section-content p-6">
                <!-- Add New Testimonial -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Testimonial</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Client Name" class="form-input" required>
                        <input type="text" name="position" placeholder="Position (e.g., CEO)" class="form-input" required>
                        <input type="text" name="company" placeholder="Company Name" class="form-input" required>
                        <input type="text" name="rating" placeholder="Rating (e.g., 5.0)" class="form-input" required>
                        <input type="text" name="initials" placeholder="Initials (e.g., MS)" class="form-input" required>
                        <div class="col-span-2">
                            <textarea name="text" rows="3" placeholder="Testimonial text" class="form-input" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_testimonial" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Testimonial
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Testimonials -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Company</th>
                                <th class="px-4 py-2 text-left">Rating</th>
                                <th class="px-4 py-2 text-left">Text</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $test): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="testimonial_id" value="<?= $test['id'] ?>">
                                            <input type="text" name="name" value="<?= htmlspecialchars($test['name']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="company" value="<?= htmlspecialchars($test['company']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="rating" value="<?= htmlspecialchars($test['rating'] ?? '5.0') ?>" class="form-input text-sm w-20">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="text" value="<?= htmlspecialchars($test['text']) ?>" class="form-input text-sm">
                                        <input type="hidden" name="position" value="<?= htmlspecialchars($test['position'] ?? '') ?>">
                                        <input type="hidden" name="initials" value="<?= htmlspecialchars($test['initials'] ?? '') ?>">
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_testimonial" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        </form>
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                            <input type="hidden" name="testimonial_id" value="<?= $test['id'] ?>">
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

        <!-- Statistics Management -->
        <div id="stats-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('stats-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-chart-bar mr-2"></i>Statistics</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="stats-content" class="section-content p-6">
                <form method="POST" class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client Retention Rate</label>
                        <input type="text" name="retention" value="98%" class="form-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Average Rating</label>
                        <input type="text" name="rating" value="4.9/5" class="form-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Successful Cases</label>
                        <input type="text" name="cases" value="200+" class="form-input">
                    </div>
                    <div class="col-span-3">
                        <button type="submit" name="update_stats" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Update Statistics
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer - Simplified -->
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

        // Smooth scroll for anchor links
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

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