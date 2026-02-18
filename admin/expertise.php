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
    
    // Update Expertise Hero
    if (isset($_POST['update_hero'])) {
        $check = $pdo->query("SELECT COUNT(*) FROM expertise_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE expertise_hero SET title = ?, subtitle = ?, background_image = ? WHERE id = ?");
            $stmt->execute([$_POST['title'], $_POST['subtitle'], $_POST['background_image'], $_POST['hero_id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO expertise_hero (title, subtitle, background_image) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['title'], $_POST['subtitle'], $_POST['background_image']]);
        }
        $success = "Expertise hero section updated successfully!";
    }
    
    // Add Category
    if (isset($_POST['add_category'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM expertise_categories")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO expertise_categories (title, description, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Category added successfully!";
    }
    
    // Update Category
    if (isset($_POST['update_category'])) {
        $stmt = $pdo->prepare("UPDATE expertise_categories SET title = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['category_id']]);
        $success = "Category updated successfully!";
    }
    
    // Delete Category
    if (isset($_POST['delete_category'])) {
        // First delete all practice areas in this category
        $stmt = $pdo->prepare("DELETE FROM practice_areas_expertise WHERE category_id = ?");
        $stmt->execute([$_POST['category_id']]);
        // Then delete the category
        $stmt = $pdo->prepare("DELETE FROM expertise_categories WHERE id = ?");
        $stmt->execute([$_POST['category_id']]);
        $success = "Category and its practice areas deleted successfully!";
    }
    
    // Update category sort order
    if (isset($_POST['update_category_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE expertise_categories SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Category sort order updated successfully!";
    }
    
    // Add Practice Area
    if (isset($_POST['add_practice'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM practice_areas_expertise WHERE category_id = " . $_POST['category_id'])->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        
        // Convert features array to comma-separated string
        $features = is_array($_POST['features']) ? implode(',', $_POST['features']) : $_POST['features'];
        
        $stmt = $pdo->prepare("INSERT INTO practice_areas_expertise (category_id, title, icon, features, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['category_id'], $_POST['title'], $_POST['icon'], $features, $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Practice area added successfully!";
    }
    
    // Update Practice Area
    if (isset($_POST['update_practice'])) {
        $features = is_array($_POST['features']) ? implode(',', $_POST['features']) : $_POST['features'];
        $stmt = $pdo->prepare("UPDATE practice_areas_expertise SET title = ?, icon = ?, features = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['icon'], $features, isset($_POST['is_active']) ? 1 : 0, $_POST['practice_id']]);
        $success = "Practice area updated successfully!";
    }
    
    // Delete Practice Area
    if (isset($_POST['delete_practice'])) {
        $stmt = $pdo->prepare("DELETE FROM practice_areas_expertise WHERE id = ?");
        $stmt->execute([$_POST['practice_id']]);
        $success = "Practice area deleted successfully!";
    }
    
    // Add Specialized Area
    if (isset($_POST['add_specialized'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM specialized_areas")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO specialized_areas (title, description, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Specialized area added successfully!";
    }
    
    // Update Specialized Area
    if (isset($_POST['update_specialized'])) {
        $stmt = $pdo->prepare("UPDATE specialized_areas SET title = ?, description = ?, icon = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], isset($_POST['is_active']) ? 1 : 0, $_POST['specialized_id']]);
        $success = "Specialized area updated successfully!";
    }
    
    // Delete Specialized Area
    if (isset($_POST['delete_specialized'])) {
        $stmt = $pdo->prepare("DELETE FROM specialized_areas WHERE id = ?");
        $stmt->execute([$_POST['specialized_id']]);
        $success = "Specialized area deleted successfully!";
    }
    
    // Add Why Choose Feature
    if (isset($_POST['add_feature'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM why_choose_features")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO why_choose_features (title, description, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Feature added successfully!";
    }
    
    // Update Why Choose Feature
    if (isset($_POST['update_feature'])) {
        $stmt = $pdo->prepare("UPDATE why_choose_features SET title = ?, description = ?, icon = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], isset($_POST['is_active']) ? 1 : 0, $_POST['feature_id']]);
        $success = "Feature updated successfully!";
    }
    
    // Delete Why Choose Feature
    if (isset($_POST['delete_feature'])) {
        $stmt = $pdo->prepare("DELETE FROM why_choose_features WHERE id = ?");
        $stmt->execute([$_POST['feature_id']]);
        $success = "Feature deleted successfully!";
    }
    
    // Update CTA
    if (isset($_POST['update_cta'])) {
        $check = $pdo->query("SELECT COUNT(*) FROM expertise_cta")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE expertise_cta SET title = ?, description = ?, primary_button_text = ?, primary_button_link = ?, secondary_button_text = ?, secondary_button_link = ?, is_active = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $_POST['primary_button_text'],
                $_POST['primary_button_link'],
                $_POST['secondary_button_text'],
                $_POST['secondary_button_link'],
                isset($_POST['is_active']) ? 1 : 0,
                $_POST['cta_id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO expertise_cta (title, description, primary_button_text, primary_button_link, secondary_button_text, secondary_button_link, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $_POST['primary_button_text'],
                $_POST['primary_button_link'],
                $_POST['secondary_button_text'],
                $_POST['secondary_button_link'],
                isset($_POST['is_active']) ? 1 : 0
            ]);
        }
        $success = "CTA section updated successfully!";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM expertise_hero ORDER BY id DESC LIMIT 1")->fetch();
$categories = $pdo->query("SELECT * FROM expertise_categories ORDER BY sort_order ASC")->fetchAll();

// Fetch practice areas for each category
$practiceAreasByCategory = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT * FROM practice_areas_expertise WHERE category_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$category['id']]);
    $practiceAreasByCategory[$category['id']] = $stmt->fetchAll();
}

$specializedAreas = $pdo->query("SELECT * FROM specialized_areas ORDER BY sort_order ASC")->fetchAll();
$whyChooseFeatures = $pdo->query("SELECT * FROM why_choose_features ORDER BY sort_order ASC")->fetchAll();
$cta = $pdo->query("SELECT * FROM expertise_cta WHERE is_active = 1 ORDER BY id DESC LIMIT 1")->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Expertise | Precision Law Firm</title>
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

        .feature-input-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
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
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
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
                        class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">
                        Expertise
                    </a>
                    <a href="jurisprudence.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
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
            <h1 class="text-3xl font-bold text-[#0F2854]">Expertise Page Management</h1>
            <a href="expertise.php" target="_blank" class="btn-primary inline-flex items-center">
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
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($hero['title'] ?? 'OUR EXPERTISE') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <textarea name="subtitle" rows="2" class="form-textarea"><?= htmlspecialchars($hero['subtitle'] ?? 'Comprehensive legal services across diverse practice areas, combining deep Mauritian legal knowledge with strategic commercial insight.') ?></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Image URL</label>
                            <input type="text" name="background_image" value="<?= htmlspecialchars($hero['background_image'] ?? '../components/img/bg-try.png') ?>" class="form-input">
                        </div>
                    </div>
                    <button type="submit" name="update_hero" class="btn-primary mt-4">
                        <i class="fas fa-save mr-2"></i>Update Hero Section
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Management -->
        <div id="categories-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('categories-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-folder mr-2"></i>Expertise Categories</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="categories-content" class="section-content p-6">
                <!-- Add New Category -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Category</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Category Title" class="form-input" required>
                        <div></div>
                        <div class="col-span-2">
                            <textarea name="description" rows="2" placeholder="Category Description" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_category" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Category
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Category Sort Order -->
                <form method="POST" class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Category Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Category Title</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <input type="hidden" name="sort_ids[]" value="<?= $cat['id'] ?>">
                                    <input type="number" name="sort_orders[]" value="<?= $cat['sort_order'] ?>" class="form-input text-sm w-20">
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                                        <input type="text" name="title" value="<?= htmlspecialchars($cat['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $cat['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_category" class="text-blue-600 hover:text-blue-800 mr-2" title="Save Category">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category and all its practice areas?')">
                                        <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                                        <button type="submit" name="delete_category" class="text-red-600 hover:text-red-800" title="Delete Category">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_category_sort" class="btn-warning mt-4">
                        <i class="fas fa-sort mr-2"></i>Update Category Sort Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Practice Areas Management (by category) -->
        <?php foreach ($categories as $category): ?>
        <div id="practice-<?= $category['id'] ?>" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('practice-content-<?= $category['id'] ?>')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-briefcase mr-2"></i>Practice Areas - <?= htmlspecialchars($category['title']) ?></h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="practice-content-<?= $category['id'] ?>" class="section-content p-6">
                <!-- Add New Practice Area -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Practice Area</h3>
                    <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Practice Area Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-gavel)" class="form-input" required>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Features (one per line or comma-separated)</label>
                            <textarea name="features" rows="3" class="form-textarea" placeholder="Contract disputes and breach of contract matters&#10;Tort claims and negligence cases&#10;Debt recovery and enforcement proceedings" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_practice" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Practice Area
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Practice Areas -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Icon</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Features</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($practiceAreasByCategory[$category['id']])): ?>
                            <?php foreach ($practiceAreasByCategory[$category['id']] as $area): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="practice_id" value="<?= $area['id'] ?>">
                                        <input type="text" name="icon" value="<?= htmlspecialchars($area['icon']) ?>" class="form-input text-sm w-24">
                                </td>
                                <td class="px-4 py-3">
                                        <input type="text" name="title" value="<?= htmlspecialchars($area['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                        <textarea name="features" rows="2" class="form-textarea text-sm"><?= htmlspecialchars($area['features']) ?></textarea>
                                </td>
                                <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $area['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_practice" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this practice area?')">
                                        <input type="hidden" name="practice_id" value="<?= $area['id'] ?>">
                                        <button type="submit" name="delete_practice" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No practice areas added yet for this category.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Specialized Areas Management -->
        <div id="specialized-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('specialized-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-star mr-2"></i>Specialized Practice Areas</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="specialized-content" class="section-content p-6">
                <!-- Add New Specialized Area -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Specialized Area</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-chart-line)" class="form-input" required>
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
                            <button type="submit" name="add_specialized" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Specialized Area
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Specialized Areas -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Icon</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($specializedAreas as $area): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="specialized_id" value="<?= $area['id'] ?>">
                                    <input type="text" name="icon" value="<?= htmlspecialchars($area['icon']) ?>" class="form-input text-sm w-24">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($area['title']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="description" value="<?= htmlspecialchars($area['description']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $area['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_specialized" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this specialized area?')">
                                    <input type="hidden" name="specialized_id" value="<?= $area['id'] ?>">
                                    <button type="submit" name="delete_specialized" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Why Choose Features Management -->
        <div id="features-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('features-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-check-circle mr-2"></i>Why Choose Our Expertise</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="features-content" class="section-content p-6">
                <!-- Add New Feature -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Feature</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-gem)" class="form-input" required>
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
                            <th class="px-4 py-2 text-left">Icon</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($whyChooseFeatures as $feature): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="feature_id" value="<?= $feature['id'] ?>">
                                    <input type="text" name="icon" value="<?= htmlspecialchars($feature['icon']) ?>" class="form-input text-sm w-24">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($feature['title']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="description" value="<?= htmlspecialchars($feature['description']) ?>" class="form-input text-sm">
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

        <!-- CTA Section Management -->
        <div id="cta-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('cta-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-bullhorn mr-2"></i>Call to Action Section</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="cta-content" class="section-content p-6">
                <form method="POST">
                    <input type="hidden" name="cta_id" value="<?= $cta['id'] ?? '' ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($cta['title'] ?? 'Need Specialized Legal Assistance?') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" class="form-textarea"><?= htmlspecialchars($cta['description'] ?? 'Contact us to discuss how our expertise can help with your specific legal requirements.') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                            <input type="text" name="primary_button_text" value="<?= htmlspecialchars($cta['primary_button_text'] ?? 'Contact Our Team') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Link</label>
                            <input type="text" name="primary_button_link" value="<?= htmlspecialchars($cta['primary_button_link'] ?? 'contact.php') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                            <input type="text" name="secondary_button_text" value="<?= htmlspecialchars($cta['secondary_button_text'] ?? 'Meet Our Experts') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Link</label>
                            <input type="text" name="secondary_button_link" value="<?= htmlspecialchars($cta['secondary_button_link'] ?? 'team.php') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" <?= (isset($cta['is_active']) && $cta['is_active']) ? 'checked' : '' ?> class="mr-2">
                                <span class="text-sm text-gray-700">Active (show on page)</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="update_cta" class="btn-primary mt-4">
                        <i class="fas fa-save mr-2"></i>Update CTA Section
                    </button>
                </form>
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