<?php
require '../config.php';
session_start();

// Simple authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update Overview Hero
    if (isset($_POST['update_hero'])) {
        // First check if record exists
        $check = $pdo->query("SELECT COUNT(*) FROM overview_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE overview_hero SET title = ?, background_image = ? WHERE id = ?");
            $stmt->execute([$_POST['title'], $_POST['background_image'], $_POST['hero_id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO overview_hero (title, background_image) VALUES (?, ?)");
            $stmt->execute([$_POST['title'], $_POST['background_image']]);
        }
        $success = "Hero section updated successfully!";
    }

    // Add Overview Description
    if (isset($_POST['add_description'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM overview_description")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO overview_description (paragraph, sort_order) VALUES (?, ?)");
        $stmt->execute([$_POST['paragraph'], $sort_order]);
        $success = "Description paragraph added successfully!";
    }

    // Update Overview Description
    if (isset($_POST['update_description'])) {
        $stmt = $pdo->prepare("UPDATE overview_description SET paragraph = ? WHERE id = ?");
        $stmt->execute([$_POST['paragraph'], $_POST['desc_id']]);
        $success = "Description paragraph updated successfully!";
    }

    // Delete Overview Description
    if (isset($_POST['delete_description'])) {
        $stmt = $pdo->prepare("DELETE FROM overview_description WHERE id = ?");
        $stmt->execute([$_POST['desc_id']]);
        $success = "Description paragraph deleted successfully!";
    }

    // Update sort order
    if (isset($_POST['update_sort_order'])) {
        $ids = $_POST['sort_ids'] ?? [];
        $orders = $_POST['sort_orders'] ?? [];
        for ($i = 0; $i < count($ids); $i++) {
            $stmt = $pdo->prepare("UPDATE overview_description SET sort_order = ? WHERE id = ?");
            $stmt->execute([$orders[$i], $ids[$i]]);
        }
        $success = "Sort order updated successfully!";
    }

    // Add What We Do content
    if (isset($_POST['add_whatwedo'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM what_we_do WHERE column_number = " . $_POST['column_number'])->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO what_we_do (content, column_number, sort_order) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['content'], $_POST['column_number'], $sort_order]);
        $success = "What We Do content added successfully!";
    }

    // Update What We Do content
    if (isset($_POST['update_whatwedo'])) {
        $stmt = $pdo->prepare("UPDATE what_we_do SET content = ? WHERE id = ?");
        $stmt->execute([$_POST['content'], $_POST['whatwedo_id']]);
        $success = "What We Do content updated successfully!";
    }

    // Delete What We Do content
    if (isset($_POST['delete_whatwedo'])) {
        $stmt = $pdo->prepare("DELETE FROM what_we_do WHERE id = ?");
        $stmt->execute([$_POST['whatwedo_id']]);
        $success = "What We Do content deleted successfully!";
    }

    // Add Practice Area
    if (isset($_POST['add_practice'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM practice_areas")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO practice_areas (title, description, icon, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $sort_order]);
        $success = "Practice area added successfully!";
    }

    // Update Practice Area
    if (isset($_POST['update_practice'])) {
        $stmt = $pdo->prepare("UPDATE practice_areas SET title = ?, description = ?, icon = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $_POST['practice_id']]);
        $success = "Practice area updated successfully!";
    }

    // Delete Practice Area
    if (isset($_POST['delete_practice'])) {
        $stmt = $pdo->prepare("DELETE FROM practice_areas WHERE id = ?");
        $stmt->execute([$_POST['practice_id']]);
        $success = "Practice area deleted successfully!";
    }

    // Add Approach Content
    if (isset($_POST['add_approach'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM approach_content")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO approach_content (content, sort_order) VALUES (?, ?)");
        $stmt->execute([$_POST['content'], $sort_order]);
        $success = "Approach content added successfully!";
    }

    // Update Approach Content
    if (isset($_POST['update_approach'])) {
        $stmt = $pdo->prepare("UPDATE approach_content SET content = ? WHERE id = ?");
        $stmt->execute([$_POST['content'], $_POST['approach_id']]);
        $success = "Approach content updated successfully!";
    }

    // Delete Approach Content
    if (isset($_POST['delete_approach'])) {
        $stmt = $pdo->prepare("DELETE FROM approach_content WHERE id = ?");
        $stmt->execute([$_POST['approach_id']]);
        $success = "Approach content deleted successfully!";
    }

    // Add Approach Feature
    if (isset($_POST['add_feature'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM approach_features")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO approach_features (title, description, icon, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $sort_order]);
        $success = "Approach feature added successfully!";
    }

    // Update Approach Feature
    if (isset($_POST['update_feature'])) {
        $stmt = $pdo->prepare("UPDATE approach_features SET title = ?, description = ?, icon = ? WHERE id = ?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $_POST['feature_id']]);
        $success = "Approach feature updated successfully!";
    }

    // Delete Approach Feature
    if (isset($_POST['delete_feature'])) {
        $stmt = $pdo->prepare("DELETE FROM approach_features WHERE id = ?");
        $stmt->execute([$_POST['feature_id']]);
        $success = "Approach feature deleted successfully!";
    }

    // Update CTA Section
    if (isset($_POST['update_cta'])) {
        // First check if record exists
        $check = $pdo->query("SELECT COUNT(*) FROM cta_section")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE cta_section SET title = ?, description = ?, button_text = ?, button_link = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$_POST['title'], $_POST['description'], $_POST['button_text'], $_POST['button_link'], isset($_POST['is_active']) ? 1 : 0, $_POST['cta_id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO cta_section (title, description, button_text, button_link, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['title'], $_POST['description'], $_POST['button_text'], $_POST['button_link'], isset($_POST['is_active']) ? 1 : 0]);
        }
        $success = "CTA section updated successfully!";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM overview_hero ORDER BY id DESC LIMIT 1")->fetch();
$descriptions = $pdo->query("SELECT * FROM overview_description ORDER BY sort_order ASC")->fetchAll();
$whatWeDo = $pdo->query("SELECT * FROM what_we_do ORDER BY column_number, sort_order ASC")->fetchAll();
$whatWeDoCol1 = array_filter($whatWeDo, function ($item) {
    return $item['column_number'] == 1;
});
$whatWeDoCol2 = array_filter($whatWeDo, function ($item) {
    return $item['column_number'] == 2;
});
$practiceAreas = $pdo->query("SELECT * FROM practice_areas ORDER BY sort_order ASC")->fetchAll();
$approachContent = $pdo->query("SELECT * FROM approach_content ORDER BY sort_order ASC")->fetchAll();
$approachFeatures = $pdo->query("SELECT * FROM approach_features ORDER BY sort_order ASC")->fetchAll();
$cta = $pdo->query("SELECT * FROM cta_section WHERE is_active = 1 ORDER BY id DESC LIMIT 1")->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Overview | Precision Law Firm</title>
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
                        <a href="../index.php"
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Home
                        </a>

                        <a href="overview.php"
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
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
                    <a href="../index.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Home
                    </a>
                    <a href="overview.php"
                        class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">
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
            <h1 class="text-3xl font-bold text-[#0F2854]">Overview Page Management</h1>
            <a href="overview.php" target="_blank" class="btn-primary inline-flex items-center">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($hero['title'] ?? 'OVERVIEW') ?>" class="form-input">
                        </div>
                        <div>
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

        <!-- Description Paragraphs Management -->
        <div id="description-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('description-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-paragraph mr-2"></i>Description Paragraphs</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="description-content" class="section-content p-6">
                <!-- Add New Paragraph -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Paragraph</h3>
                    <div class="flex gap-4">
                        <textarea name="paragraph" rows="2" class="form-input flex-1" placeholder="Enter paragraph text..." required></textarea>
                        <button type="submit" name="add_description" class="btn-success whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>Add Paragraph
                        </button>
                    </div>
                </form>

                <!-- Sort Order Form -->
                <form method="POST" class="mb-4">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order</th>
                                <th class="px-4 py-2 text-left">Paragraph</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($descriptions as $desc): ?>
                                <tr class="table-row border-t">
                                    <td class="px-4 py-3">
                                        <input type="hidden" name="sort_ids[]" value="<?= $desc['id'] ?>">
                                        <input type="number" name="sort_orders[]" value="<?= $desc['sort_order'] ?>" class="form-input text-sm w-20">
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="desc_id" value="<?= $desc['id'] ?>">
                                            <input type="text" name="paragraph" value="<?= htmlspecialchars($desc['paragraph']) ?>" class="form-input text-sm flex-1">
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button type="submit" name="update_description" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                </form>
                <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    <input type="hidden" name="desc_id" value="<?= $desc['id'] ?>">
                    <button type="submit" name="delete_description" class="text-red-600 hover:text-red-800" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <button type="submit" name="update_sort_order" class="btn-warning mt-4">
                <i class="fas fa-sort mr-2"></i>Update Sort Order
            </button>
            </form>
            </div>
        </div>

        <!-- What We Do Management -->
        <div id="whatwedo-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('whatwedo-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-tasks mr-2"></i>What We Do</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="whatwedo-content" class="section-content p-6">
                <!-- Add New Content -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Content</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Column</label>
                            <select name="column_number" class="form-input" required>
                                <option value="1">Column 1 (Left)</option>
                                <option value="2">Column 2 (Right)</option>
                            </select>
                        </div>
                        <div></div>
                        <div class="col-span-2">
                            <textarea name="content" rows="3" class="form-input" placeholder="Enter content..." required></textarea>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_whatwedo" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Content
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Left Column Content -->
                <h4 class="font-semibold text-[#0F2854] mb-2">Column 1 (Left)</h4>
                <table class="w-full mb-6">
                    <tbody>
                        <?php foreach ($whatWeDoCol1 as $item): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="whatwedo_id" value="<?= $item['id'] ?>">
                                        <input type="text" name="content" value="<?= htmlspecialchars($item['content']) ?>" class="form-input text-sm flex-1">
                                        <button type="submit" name="update_whatwedo" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="whatwedo_id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="delete_whatwedo" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Right Column Content -->
                <h4 class="font-semibold text-[#0F2854] mb-2 mt-4">Column 2 (Right)</h4>
                <table class="w-full">
                    <tbody>
                        <?php foreach ($whatWeDoCol2 as $item): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="whatwedo_id" value="<?= $item['id'] ?>">
                                        <input type="text" name="content" value="<?= htmlspecialchars($item['content']) ?>" class="form-input text-sm flex-1">
                                        <button type="submit" name="update_whatwedo" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="whatwedo_id" value="<?= $item['id'] ?>">
                                        <button type="submit" name="delete_whatwedo" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Practice Areas Management -->
        <div id="practice-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('practice-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-briefcase mr-2"></i>Practice Areas</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="practice-content" class="section-content p-6">
                <!-- Add New Practice Area -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Practice Area</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Font Awesome Icon (e.g., fa-gavel)" class="form-input" required>
                        <div class="col-span-2">
                            <textarea name="description" rows="2" placeholder="Description" class="form-input" required></textarea>
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
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($practiceAreas as $area): ?>
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
                                    <input type="text" name="description" value="<?= htmlspecialchars($area['description']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_practice" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="practice_id" value="<?= $area['id'] ?>">
                                        <button type="submit" name="delete_practice" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Approach Content Management -->
        <div id="approach-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('approach-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-lightbulb mr-2"></i>Our Approach</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="approach-content" class="section-content p-6">
                <!-- Add New Approach Content -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Approach Paragraph</h3>
                    <div class="flex gap-4">
                        <textarea name="content" rows="2" class="form-input flex-1" placeholder="Enter paragraph..." required></textarea>
                        <button type="submit" name="add_approach" class="btn-success whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>Add Paragraph
                        </button>
                    </div>
                </form>

                <!-- Existing Approach Content -->
                <table class="w-full mb-8">
                    <tbody>
                        <?php foreach ($approachContent as $content): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="approach_id" value="<?= $content['id'] ?>">
                                        <input type="text" name="content" value="<?= htmlspecialchars($content['content']) ?>" class="form-input text-sm flex-1">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_approach" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="approach_id" value="<?= $content['id'] ?>">
                                        <button type="submit" name="delete_approach" class="text-red-600 hover:text-red-800" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Approach Features -->
                <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Approach Features</h3>

                <!-- Add New Feature -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-medium mb-2">Add New Feature</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" name="title" placeholder="Title" class="form-input" required>
                        <input type="text" name="icon" placeholder="Icon (e.g., fa-search)" class="form-input" required>
                        <div class="col-span-3">
                            <textarea name="description" rows="2" placeholder="Description" class="form-input" required></textarea>
                        </div>
                        <div class="col-span-3">
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
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approachFeatures as $feature): ?>
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
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_feature" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
                            <input type="text" name="title" value="<?= htmlspecialchars($cta['title'] ?? 'Ready to discuss your legal needs?') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" class="form-input"><?= htmlspecialchars($cta['description'] ?? 'Contact us for strategic legal advice from attorneys with government-level expertise and commercial insight.') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="button_text" value="<?= htmlspecialchars($cta['button_text'] ?? 'Contact Our Team') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="button_link" value="<?= htmlspecialchars($cta['button_link'] ?? 'contact.php') ?>" class="form-input">
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