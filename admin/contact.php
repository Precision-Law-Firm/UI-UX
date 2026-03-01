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
        $check = $pdo->query("SELECT COUNT(*) FROM contact_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE contact_hero SET title_line1 = ?, title_line2 = ?, description = ? WHERE id = ?");
            $stmt->execute([$_POST['title_line1'], $_POST['title_line2'], $_POST['description'], $_POST['hero_id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO contact_hero (title_line1, title_line2, description) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['title_line1'], $_POST['title_line2'], $_POST['description']]);
        }
        $success = "Hero section updated successfully!";
    }
    
    // Add Contact Card
    if (isset($_POST['add_contact_card'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM contact_cards")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO contact_cards (icon, title, content, additional_info, action_text, action_link, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['icon'],
            $_POST['title'],
            $_POST['content'],
            $_POST['additional_info'],
            $_POST['action_text'],
            $_POST['action_link'],
            $sort_order,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Contact card added successfully!";
    }
    
    // Update Contact Card
    if (isset($_POST['update_contact_card'])) {
        $stmt = $pdo->prepare("UPDATE contact_cards SET icon = ?, title = ?, content = ?, additional_info = ?, action_text = ?, action_link = ?, is_active = ? WHERE id = ?");
        $stmt->execute([
            $_POST['icon'],
            $_POST['title'],
            $_POST['content'],
            $_POST['additional_info'],
            $_POST['action_text'],
            $_POST['action_link'],
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['card_id']
        ]);
        $success = "Contact card updated successfully!";
    }
    
    // Delete Contact Card
    if (isset($_POST['delete_contact_card'])) {
        $stmt = $pdo->prepare("DELETE FROM contact_cards WHERE id = ?");
        $stmt->execute([$_POST['card_id']]);
        $success = "Contact card deleted successfully!";
    }
    
    // Add Office Hour
    if (isset($_POST['add_office_hour'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM office_hours")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO office_hours (day_range, hours, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['day_range'], $_POST['hours'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Office hour added successfully!";
    }
    
    // Update Office Hour
    if (isset($_POST['update_office_hour'])) {
        $stmt = $pdo->prepare("UPDATE office_hours SET day_range = ?, hours = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['day_range'], $_POST['hours'], isset($_POST['is_active']) ? 1 : 0, $_POST['hour_id']]);
        $success = "Office hour updated successfully!";
    }
    
    // Delete Office Hour
    if (isset($_POST['delete_office_hour'])) {
        $stmt = $pdo->prepare("DELETE FROM office_hours WHERE id = ?");
        $stmt->execute([$_POST['hour_id']]);
        $success = "Office hour deleted successfully!";
    }
    
    // Add Social Link
    if (isset($_POST['add_social_link'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM social_links")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO social_links (platform, icon, url, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['platform'], $_POST['icon'], $_POST['url'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Social link added successfully!";
    }
    
    // Update Social Link
    if (isset($_POST['update_social_link'])) {
        $stmt = $pdo->prepare("UPDATE social_links SET platform = ?, icon = ?, url = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['platform'], $_POST['icon'], $_POST['url'], isset($_POST['is_active']) ? 1 : 0, $_POST['social_id']]);
        $success = "Social link updated successfully!";
    }
    
    // Delete Social Link
    if (isset($_POST['delete_social_link'])) {
        $stmt = $pdo->prepare("DELETE FROM social_links WHERE id = ?");
        $stmt->execute([$_POST['social_id']]);
        $success = "Social link deleted successfully!";
    }
    
    // Add Career Position
    if (isset($_POST['add_career_position'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM career_positions")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO career_positions (value, title, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['value'], $_POST['title'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Career position added successfully!";
    }
    
    // Update Career Position
    if (isset($_POST['update_career_position'])) {
        $stmt = $pdo->prepare("UPDATE career_positions SET value = ?, title = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['value'], $_POST['title'], isset($_POST['is_active']) ? 1 : 0, $_POST['position_id']]);
        $success = "Career position updated successfully!";
    }
    
    // Delete Career Position
    if (isset($_POST['delete_career_position'])) {
        $stmt = $pdo->prepare("DELETE FROM career_positions WHERE id = ?");
        $stmt->execute([$_POST['position_id']]);
        $success = "Career position deleted successfully!";
    }
    
    // Add Chat Response
    if (isset($_POST['add_chat_response'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM chat_responses")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO chat_responses (keyword, response, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['keyword'], $_POST['response'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Chat response added successfully!";
    }
    
    // Update Chat Response
    if (isset($_POST['update_chat_response'])) {
        $stmt = $pdo->prepare("UPDATE chat_responses SET keyword = ?, response = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['keyword'], $_POST['response'], isset($_POST['is_active']) ? 1 : 0, $_POST['response_id']]);
        $success = "Chat response updated successfully!";
    }
    
    // Delete Chat Response
    if (isset($_POST['delete_chat_response'])) {
        $stmt = $pdo->prepare("DELETE FROM chat_responses WHERE id = ?");
        $stmt->execute([$_POST['response_id']]);
        $success = "Chat response deleted successfully!";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM contact_hero ORDER BY id DESC LIMIT 1")->fetch();
$contactCards = $pdo->query("SELECT * FROM contact_cards ORDER BY sort_order ASC")->fetchAll();
$officeHours = $pdo->query("SELECT * FROM office_hours ORDER BY sort_order ASC")->fetchAll();
$socialLinks = $pdo->query("SELECT * FROM social_links ORDER BY sort_order ASC")->fetchAll();
$careerPositions = $pdo->query("SELECT * FROM career_positions ORDER BY sort_order ASC")->fetchAll();
$chatResponses = $pdo->query("SELECT * FROM chat_responses ORDER BY sort_order ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact & Careers | Precision Law Firm</title>
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

        .keyword-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
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
            <h1 class="text-3xl font-bold text-[#0F2854]">Contact & Careers Page Management</h1>
            <a href="contact.php" target="_blank" class="btn-primary inline-flex items-center">
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
                            <input type="text" name="title_line1" value="<?= htmlspecialchars($hero['title_line1'] ?? 'Contact Us &') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title Line 2</label>
                            <input type="text" name="title_line2" value="<?= htmlspecialchars($hero['title_line2'] ?? 'Careers') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" class="form-textarea"><?= htmlspecialchars($hero['description'] ?? 'Get in touch with our legal experts or explore career opportunities at Precision Law Firm.') ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="update_hero" class="btn-primary mt-4">
                        <i class="fas fa-save mr-2"></i>Update Hero Section
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Cards Management -->
        <div id="cards-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('cards-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-id-card mr-2"></i>Contact Cards</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="cards-content" class="section-content p-6">
                <!-- Add New Contact Card -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Contact Card</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            <input type="text" name="icon" placeholder="e.g., fa-map-marker-alt" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" placeholder="Card Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <textarea name="content" rows="2" placeholder="Main content (optional)" class="form-textarea"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Info</label>
                            <input type="text" name="additional_info" placeholder="Additional info (comma separated)" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Action Text</label>
                            <input type="text" name="action_text" placeholder="e.g., Get Directions" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Action Link</label>
                            <input type="text" name="action_link" placeholder="e.g., #" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_contact_card" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Contact Card
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Contact Cards -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Icon</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Content Preview</th>
                            <th class="px-4 py-2 text-left">Action</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactCards as $card): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
                                    <input type="text" name="icon" value="<?= htmlspecialchars($card['icon']) ?>" class="form-input text-sm w-24">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="content" value="<?= htmlspecialchars(substr($card['content'] ?? '', 0, 50)) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="action_text" value="<?= htmlspecialchars($card['action_text'] ?? '') ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $card['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_contact_card" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this contact card?')">
                                    <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
                                    <button type="submit" name="delete_contact_card" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Office Hours Management -->
        <div id="hours-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('hours-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-clock mr-2"></i>Office Hours</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="hours-content" class="section-content p-6">
                <!-- Add New Office Hour -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Office Hour</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Day Range</label>
                            <input type="text" name="day_range" placeholder="e.g., Mon-Fri" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hours</label>
                            <input type="text" name="hours" placeholder="e.g., 9AM-5PM" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_office_hour" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Office Hour
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Office Hours -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Day Range</th>
                            <th class="px-4 py-2 text-left">Hours</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($officeHours as $hour): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="hour_id" value="<?= $hour['id'] ?>">
                                    <input type="text" name="day_range" value="<?= htmlspecialchars($hour['day_range']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="hours" value="<?= htmlspecialchars($hour['hours']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $hour['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_office_hour" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this office hour?')">
                                    <input type="hidden" name="hour_id" value="<?= $hour['id'] ?>">
                                    <button type="submit" name="delete_office_hour" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Social Links Management -->
        <div id="social-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('social-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-share-alt mr-2"></i>Social Media Links</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="social-content" class="section-content p-6">
                <!-- Add New Social Link -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Social Link</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Platform</label>
                            <input type="text" name="platform" placeholder="e.g., LinkedIn" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            <input type="text" name="icon" placeholder="e.g., fa-linkedin-in" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                            <input type="text" name="url" placeholder="https://..." class="form-input" required>
                        </div>
                        <div class="col-span-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-3">
                            <button type="submit" name="add_social_link" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Social Link
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Social Links -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Platform</th>
                            <th class="px-4 py-2 text-left">Icon</th>
                            <th class="px-4 py-2 text-left">URL</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($socialLinks as $link): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="social_id" value="<?= $link['id'] ?>">
                                    <input type="text" name="platform" value="<?= htmlspecialchars($link['platform']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="icon" value="<?= htmlspecialchars($link['icon']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="url" value="<?= htmlspecialchars($link['url']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $link['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_social_link" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this social link?')">
                                    <input type="hidden" name="social_id" value="<?= $link['id'] ?>">
                                    <button type="submit" name="delete_social_link" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Career Positions Management -->
        <div id="career-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('career-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-briefcase mr-2"></i>Career Positions</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="career-content" class="section-content p-6">
                <!-- Add New Career Position -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Career Position</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value (slug)</label>
                            <input type="text" name="value" placeholder="e.g., associate-attorney" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" placeholder="e.g., Associate Attorney" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_career_position" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Career Position
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Career Positions -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Value</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($careerPositions as $position): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="position_id" value="<?= $position['id'] ?>">
                                    <input type="text" name="value" value="<?= htmlspecialchars($position['value']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($position['title']) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $position['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_career_position" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this career position?')">
                                    <input type="hidden" name="position_id" value="<?= $position['id'] ?>">
                                    <button type="submit" name="delete_career_position" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Chat Responses Management -->
        <div id="chat-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('chat-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-robot mr-2"></i>Chatbot Responses</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="chat-content" class="section-content p-6">
                <!-- Add New Chat Response -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Chat Response</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keyword</label>
                            <input type="text" name="keyword" placeholder="e.g., contact" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Response</label>
                            <textarea name="response" rows="2" placeholder="Bot's response when keyword is detected" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_chat_response" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Chat Response
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Chat Responses -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Keyword</th>
                            <th class="px-4 py-2 text-left">Response Preview</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chatResponses as $response): ?>
                        <tr class="table-row border-t">
                            <td class="px-4 py-3">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="response_id" value="<?= $response['id'] ?>">
                                    <span class="keyword-badge mr-2"><?= htmlspecialchars($response['keyword']) ?></span>
                                    <input type="text" name="keyword" value="<?= htmlspecialchars($response['keyword']) ?>" class="form-input text-sm hidden">
                            </td>
                            <td class="px-4 py-3">
                                    <input type="text" name="response" value="<?= htmlspecialchars(substr($response['response'], 0, 100)) ?>" class="form-input text-sm">
                            </td>
                            <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $response['is_active'] ? 'checked' : '' ?>>
                                    </label>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_chat_response" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this chat response?')">
                                    <input type="hidden" name="response_id" value="<?= $response['id'] ?>">
                                    <button type="submit" name="delete_chat_response" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Quick Preview of Hours String -->
        <div class="admin-card" data-aos="fade-up-slow">
            <div class="section-header">
                <h2 class="text-xl font-semibold"><i class="fas fa-eye mr-2"></i>Live Preview - Office Hours String</h2>
            </div>
            <div class="p-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <p class="text-blue-700 font-medium mb-2">This is how office hours appear on the site:</p>
                    <?php
                    $hoursString = '';
                    foreach ($officeHours as $index => $hour) {
                        if ($hour['is_active']) {
                            if ($index > 0) $hoursString .= '<br>';
                            $hoursString .= htmlspecialchars($hour['day_range']) . ': ' . htmlspecialchars($hour['hours']);
                        }
                    }
                    ?>
                    <div class="bg-white p-4 rounded-lg border border-blue-200">
                        <?= $hoursString ?: 'No active office hours set' ?>
                    </div>
                </div>
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