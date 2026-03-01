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
        $check = $pdo->query("SELECT COUNT(*) FROM jurisprudence_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE jurisprudence_hero SET badge_text = ?, title = ?, subtitle = ?, background_image = ? WHERE id = ?");
            $stmt->execute([$_POST['badge_text'], $_POST['title'], $_POST['subtitle'], $_POST['background_image'], $_POST['hero_id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO jurisprudence_hero (badge_text, title, subtitle, background_image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['badge_text'], $_POST['title'], $_POST['subtitle'], $_POST['background_image']]);
        }
        $success = "Hero section updated successfully!";
    }

    // Add Statistic
    if (isset($_POST['add_stat'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM jurisprudence_stats")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO jurisprudence_stats (value, suffix, label, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['value'], $_POST['suffix'], $_POST['label'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Statistic added successfully!";
    }

    // Update Statistic
    if (isset($_POST['update_stat'])) {
        $stmt = $pdo->prepare("UPDATE jurisprudence_stats SET value = ?, suffix = ?, label = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['value'], $_POST['suffix'], $_POST['label'], isset($_POST['is_active']) ? 1 : 0, $_POST['stat_id']]);
        $success = "Statistic updated successfully!";
    }

    // Delete Statistic
    if (isset($_POST['delete_stat'])) {
        $stmt = $pdo->prepare("DELETE FROM jurisprudence_stats WHERE id = ?");
        $stmt->execute([$_POST['stat_id']]);
        $success = "Statistic deleted successfully!";
    }

    // Add Category
    if (isset($_POST['add_category'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM jurisprudence_categories")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;

        // Generate slug from name
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));

        $stmt = $pdo->prepare("INSERT INTO jurisprudence_categories (name, slug, icon, color, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $slug, $_POST['icon'], $_POST['color'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Category added successfully!";
    }

    // Update Category
    if (isset($_POST['update_category'])) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));
        $stmt = $pdo->prepare("UPDATE jurisprudence_categories SET name = ?, slug = ?, icon = ?, color = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $slug, $_POST['icon'], $_POST['color'], isset($_POST['is_active']) ? 1 : 0, $_POST['category_id']]);
        $success = "Category updated successfully!";
    }

    // Delete Category
    if (isset($_POST['delete_category'])) {
        // First update cases in this category to remove category_id
        $stmt = $pdo->prepare("UPDATE jurisprudence_cases SET category_id = NULL WHERE category_id = ?");
        $stmt->execute([$_POST['category_id']]);
        // Then delete the category
        $stmt = $pdo->prepare("DELETE FROM jurisprudence_categories WHERE id = ?");
        $stmt->execute([$_POST['category_id']]);
        $success = "Category deleted successfully!";
    }

    // Add Case
    if (isset($_POST['add_case'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM jurisprudence_cases")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO jurisprudence_cases (
            title, summary, category_id, year, court, case_number, lead_attorney, 
            key_issues, outcome, impact, duration_months, featured, icon_color, sort_order, is_active
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['title'],
            $_POST['summary'],
            $_POST['category_id'] ?: null,
            $_POST['year'],
            $_POST['court'],
            $_POST['case_number'],
            $_POST['lead_attorney'],
            $_POST['key_issues'],
            $_POST['outcome'],
            $_POST['impact'],
            $_POST['duration_months'] ?: null,
            isset($_POST['featured']) ? 1 : 0,
            $_POST['icon_color'] ?? 'blue',
            $sort_order,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Case added successfully!";
    }

    // Update Case
    if (isset($_POST['update_case'])) {
        $stmt = $pdo->prepare("UPDATE jurisprudence_cases SET 
            title = ?, summary = ?, category_id = ?, year = ?, court = ?, case_number = ?, 
            lead_attorney = ?, key_issues = ?, outcome = ?, impact = ?, duration_months = ?, 
            featured = ?, icon_color = ?, is_active = ? WHERE id = ?");

        $stmt->execute([
            $_POST['title'],
            $_POST['summary'],
            $_POST['category_id'] ?: null,
            $_POST['year'],
            $_POST['court'],
            $_POST['case_number'],
            $_POST['lead_attorney'],
            $_POST['key_issues'],
            $_POST['outcome'],
            $_POST['impact'],
            $_POST['duration_months'] ?: null,
            isset($_POST['featured']) ? 1 : 0,
            $_POST['icon_color'] ?? 'blue',
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['case_id']
        ]);
        $success = "Case updated successfully!";
    }

    // Delete Case
    if (isset($_POST['delete_case'])) {
        $stmt = $pdo->prepare("DELETE FROM jurisprudence_cases WHERE id = ?");
        $stmt->execute([$_POST['case_id']]);
        $success = "Case deleted successfully!";
    }

    // Add Timeline Item
    if (isset($_POST['add_timeline'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM jurisprudence_timeline")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO jurisprudence_timeline (year, title, description, icon, color, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['year'], $_POST['title'], $_POST['description'], $_POST['icon'], $_POST['color'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Timeline item added successfully!";
    }

    // Update Timeline Item
    if (isset($_POST['update_timeline'])) {
        $stmt = $pdo->prepare("UPDATE jurisprudence_timeline SET year = ?, title = ?, description = ?, icon = ?, color = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['year'], $_POST['title'], $_POST['description'], $_POST['icon'], $_POST['color'], isset($_POST['is_active']) ? 1 : 0, $_POST['timeline_id']]);
        $success = "Timeline item updated successfully!";
    }

    // Delete Timeline Item
    if (isset($_POST['delete_timeline'])) {
        $stmt = $pdo->prepare("DELETE FROM jurisprudence_timeline WHERE id = ?");
        $stmt->execute([$_POST['timeline_id']]);
        $success = "Timeline item deleted successfully!";
    }

    // Update CTA Section
    if (isset($_POST['update_cta'])) {
        $check = $pdo->query("SELECT COUNT(*) FROM jurisprudence_cta")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE jurisprudence_cta SET title = ?, description = ?, primary_button_text = ?, primary_button_link = ?, secondary_button_text = ?, secondary_button_link = ?, is_active = ? WHERE id = ?");
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
            $stmt = $pdo->prepare("INSERT INTO jurisprudence_cta (title, description, primary_button_text, primary_button_link, secondary_button_text, secondary_button_link, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
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

    // Update sort order for categories
    if (isset($_POST['update_category_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE jurisprudence_categories SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Category sort order updated successfully!";
    }

    // Update sort order for cases
    if (isset($_POST['update_case_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE jurisprudence_cases SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Case sort order updated successfully!";
    }

    // Update sort order for timeline
    if (isset($_POST['update_timeline_sort'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE jurisprudence_timeline SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Timeline sort order updated successfully!";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM jurisprudence_hero ORDER BY id DESC LIMIT 1")->fetch();
$stats = $pdo->query("SELECT * FROM jurisprudence_stats ORDER BY sort_order ASC")->fetchAll();
$categories = $pdo->query("SELECT * FROM jurisprudence_categories ORDER BY sort_order ASC")->fetchAll();
$cases = $pdo->query("SELECT c.*, cat.name as category_name 
                      FROM jurisprudence_cases c 
                      LEFT JOIN jurisprudence_categories cat ON c.category_id = cat.id 
                      ORDER BY c.featured DESC, c.sort_order ASC, c.year DESC")->fetchAll();
$timeline = $pdo->query("SELECT * FROM jurisprudence_timeline ORDER BY sort_order ASC")->fetchAll();
$cta = $pdo->query("SELECT * FROM jurisprudence_cta WHERE is_active = 1 ORDER BY id DESC LIMIT 1")->fetch();

// Color options for dropdown
$colorOptions = [
    'blue' => 'Blue',
    'purple' => 'Purple',
    'orange' => 'Orange',
    'green' => 'Green',
    'red' => 'Red'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Jurisprudence | Precision Law Firm</title>
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
    <?php include "navbar.php"; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-24 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8" data-aos="fade-up-slow">
            <h1 class="text-3xl font-bold text-[#0F2854]">Jurisprudence Page Management</h1>
            <a href="jurisprudence.php" target="_blank" class="btn-primary inline-flex items-center">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                            <input type="text" name="badge_text" value="<?= htmlspecialchars($hero['badge_text'] ?? 'Landmark Cases') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($hero['title'] ?? 'Our Jurisprudence') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <textarea name="subtitle" rows="2" class="form-textarea"><?= htmlspecialchars($hero['subtitle'] ?? 'Discover landmark cases and significant legal precedents handled by our firm. Each case represents our commitment to excellence in legal strategy and advocacy.') ?></textarea>
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

        <!-- Statistics Management -->
        <div id="stats-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('stats-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-chart-bar mr-2"></i>Statistics</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="stats-content" class="section-content p-6">
                <!-- Add New Stat -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Statistic</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" name="value" placeholder="Value (e.g., 150)" class="form-input" required>
                        <input type="text" name="suffix" placeholder="Suffix (e.g., +)" class="form-input">
                        <input type="text" name="label" placeholder="Label (e.g., Cases Handled)" class="form-input" required>
                        <div class="col-span-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-3">
                            <button type="submit" name="add_stat" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Statistic
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Stats -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Value</th>
                            <th class="px-4 py-2 text-left">Suffix</th>
                            <th class="px-4 py-2 text-left">Label</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $stat): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="stat_id" value="<?= $stat['id'] ?>">
                                        <input type="text" name="value" value="<?= htmlspecialchars($stat['value']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="suffix" value="<?= htmlspecialchars($stat['suffix']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="label" value="<?= htmlspecialchars($stat['label']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $stat['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_stat" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this statistic?')">
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

        <!-- Categories Management -->
        <div id="categories-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('categories-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-folder mr-2"></i>Categories</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="categories-content" class="section-content p-6">
                <!-- Add New Category -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Category</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Category Name" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-briefcase)" class="form-input" required>
                        <select name="color" class="form-select">
                            <option value="blue">Blue</option>
                            <option value="purple">Purple</option>
                            <option value="orange">Orange</option>
                            <option value="green">Green</option>
                            <option value="red">Red</option>
                        </select>
                        <div></div>
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
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Slug</th>
                                <th class="px-4 py-2 text-left">Icon</th>
                                <th class="px-4 py-2 text-left">Color</th>
                                <th class="px-4 py-2 text-left">Active</th>
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
                                            <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-gray-600"><?= htmlspecialchars($cat['slug']) ?></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="icon" value="<?= htmlspecialchars($cat['icon']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <select name="color" class="form-input text-sm">
                                            <?php foreach ($colorOptions as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= $cat['color'] == $value ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $cat['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_category" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                </form>
                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? Cases in this category will be uncategorized.')">
                    <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                    <button type="submit" name="delete_category" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Cases Management -->
        <div id="cases-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('cases-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-gavel mr-2"></i>Cases</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="cases-content" class="section-content p-6">
                <!-- Add New Case -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Case</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <input type="text" name="title" placeholder="Case Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <textarea name="summary" rows="2" placeholder="Summary" class="form-textarea" required></textarea>
                        </div>
                        <div>
                            <select name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="year" placeholder="Year (e.g., 2023)" class="form-input">
                        </div>
                        <div>
                            <input type="text" name="court" placeholder="Court" class="form-input">
                        </div>
                        <div>
                            <input type="text" name="case_number" placeholder="Case Number" class="form-input">
                        </div>
                        <div>
                            <input type="text" name="lead_attorney" placeholder="Lead Attorney" class="form-input">
                        </div>
                        <div>
                            <input type="text" name="duration_months" placeholder="Duration (months)" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <textarea name="key_issues" rows="2" placeholder="Key Issues (comma separated)" class="form-textarea"></textarea>
                        </div>
                        <div class="col-span-2">
                            <textarea name="outcome" rows="2" placeholder="Outcome (comma separated)" class="form-textarea"></textarea>
                        </div>
                        <div class="col-span-2">
                            <input type="text" name="impact" placeholder="Impact (e.g., Landmark Precedent Established)" class="form-input">
                        </div>
                        <div>
                            <select name="icon_color" class="form-select">
                                <?php foreach ($colorOptions as $value => $label): ?>
                                    <option value="<?= $value ?>"><?= $label ?> Color</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" class="mr-2">
                                <span class="text-sm text-gray-700">Featured</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_case" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Case
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Cases List -->
                <form method="POST" class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Cases Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Year</th>
                                <th class="px-4 py-2 text-left">Featured</th>
                                <th class="px-4 py-2 text-left">Active</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cases as $case): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <input type="hidden" name="sort_ids[]" value="<?= $case['id'] ?>">
                                        <input type="number" name="sort_orders[]" value="<?= $case['sort_order'] ?>" class="form-input text-sm w-20">
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                                            <input type="text" name="title" value="<?= htmlspecialchars($case['title']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <select name="category_id" class="form-input text-sm">
                                            <option value="">None</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>" <?= $case['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="year" value="<?= htmlspecialchars($case['year']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="featured" value="1" <?= $case['featured'] ? 'checked' : '' ?>>
                                        </label>
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $case['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_case" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                </form>
                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this case?')">
                    <input type="hidden" name="case_id" value="<?= $case['id'] ?>">
                    <button type="submit" name="delete_case" class="text-red-600 hover:text-red-800" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <button type="submit" name="update_case_sort" class="btn-warning mt-4">
                <i class="fas fa-sort mr-2"></i>Update Case Sort Order
            </button>
            </form>
            </div>
        </div>

        <!-- Timeline Management -->
        <div id="timeline-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('timeline-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-clock mr-2"></i>Timeline Milestones</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="timeline-content" class="section-content p-6">
                <!-- Add New Timeline Item -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Timeline Item</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="year" placeholder="Year (e.g., 2023)" class="form-input" required>
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-mobile-alt)" class="form-input">
                        <select name="color" class="form-select">
                            <?php foreach ($colorOptions as $value => $label): ?>
                                <option value="<?= $value ?>"><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
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
                            <button type="submit" name="add_timeline" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Timeline Item
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Timeline Sort Order -->
                <form method="POST">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Timeline Sort Order</h3>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Year</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Icon</th>
                                <th class="px-4 py-2 text-left">Color</th>
                                <th class="px-4 py-2 text-left">Active</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($timeline as $item): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <input type="hidden" name="sort_ids[]" value="<?= $item['id'] ?>">
                                        <input type="number" name="sort_orders[]" value="<?= $item['sort_order'] ?>" class="form-input text-sm w-20">
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="timeline_id" value="<?= $item['id'] ?>">
                                            <input type="text" name="year" value="<?= htmlspecialchars($item['year']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="title" value="<?= htmlspecialchars($item['title']) ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="icon" value="<?= htmlspecialchars($item['icon'] ?? 'fa-star') ?>" class="form-input text-sm">
                                    </td>
                                    <td class="px-4 py-3">
                                        <select name="color" class="form-input text-sm">
                                            <?php foreach ($colorOptions as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= ($item['color'] ?? 'blue') == $value ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" <?= $item['is_active'] ? 'checked' : '' ?>>
                                        </label>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_timeline" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                </form>
                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this timeline item?')">
                    <input type="hidden" name="timeline_id" value="<?= $item['id'] ?>">
                    <button type="submit" name="delete_timeline" class="text-red-600 hover:text-red-800" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <button type="submit" name="update_timeline_sort" class="btn-warning mt-4">
                <i class="fas fa-sort mr-2"></i>Update Timeline Sort Order
            </button>
            </form>
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
                            <input type="text" name="title" value="<?= htmlspecialchars($cta['title'] ?? 'Ready to Build Your Case Strategy?') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" class="form-textarea"><?= htmlspecialchars($cta['description'] ?? 'Our proven track record in landmark cases demonstrates our ability to develop winning strategies for complex legal challenges.') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Text</label>
                            <input type="text" name="primary_button_text" value="<?= htmlspecialchars($cta['primary_button_text'] ?? 'Schedule Consultation') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Button Link</label>
                            <input type="text" name="primary_button_link" value="<?= htmlspecialchars($cta['primary_button_link'] ?? 'contact.php') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Text</label>
                            <input type="text" name="secondary_button_text" value="<?= htmlspecialchars($cta['secondary_button_text'] ?? '') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Button Link</label>
                            <input type="text" name="secondary_button_link" value="<?= htmlspecialchars($cta['secondary_button_link'] ?? '') ?>" class="form-input">
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