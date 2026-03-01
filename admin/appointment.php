<?php
require '../config.php';
session_start();

// Simple authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Récupérer toutes les demandes de rendez-vous
$stmt = $pdo->query("SELECT * FROM appointments ORDER BY created_at DESC");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update Hero Section
    if (isset($_POST['update_hero'])) {
        $check = $pdo->query("SELECT COUNT(*) FROM appointment_hero")->fetchColumn();
        if ($check > 0) {
            $stmt = $pdo->prepare("UPDATE appointment_hero SET badge_text = ?, title_line1 = ?, title_line2 = ?, description = ?, background_image = ?, phone_number = ? WHERE id = ?");
            $stmt->execute([
                $_POST['badge_text'],
                $_POST['title_line1'],
                $_POST['title_line2'],
                $_POST['description'],
                $_POST['background_image'],
                $_POST['phone_number'],
                $_POST['hero_id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO appointment_hero (badge_text, title_line1, title_line2, description, background_image, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['badge_text'],
                $_POST['title_line1'],
                $_POST['title_line2'],
                $_POST['description'],
                $_POST['background_image'],
                $_POST['phone_number']
            ]);
        }
        $success = "Hero section updated successfully!";
    }

    // Add Step
    if (isset($_POST['add_step'])) {
        $stmt = $pdo->prepare("INSERT INTO appointment_steps (step_number, title, description, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['step_number'], $_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0]);
        $success = "Step added successfully!";
    }

    // Update Step
    if (isset($_POST['update_step'])) {
        $stmt = $pdo->prepare("UPDATE appointment_steps SET step_number = ?, title = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['step_number'], $_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['step_id']]);
        $success = "Step updated successfully!";
    }

    // Delete Step
    if (isset($_POST['delete_step'])) {
        $stmt = $pdo->prepare("DELETE FROM appointment_steps WHERE id = ?");
        $stmt->execute([$_POST['step_id']]);
        $success = "Step deleted successfully!";
    }

    // Add Feature
    if (isset($_POST['add_feature'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM appointment_features")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO appointment_features (icon, description, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['icon'], $_POST['description'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Feature added successfully!";
    }

    // Update Feature
    if (isset($_POST['update_feature'])) {
        $stmt = $pdo->prepare("UPDATE appointment_features SET icon = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['icon'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['feature_id']]);
        $success = "Feature updated successfully!";
    }

    // Delete Feature
    if (isset($_POST['delete_feature'])) {
        $stmt = $pdo->prepare("DELETE FROM appointment_features WHERE id = ?");
        $stmt->execute([$_POST['feature_id']]);
        $success = "Feature deleted successfully!";
    }

    // Add Consultation Type
    if (isset($_POST['add_consultation'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM consultation_types")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO consultation_types (value, name, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['value'], $_POST['name'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Consultation type added successfully!";
    }

    // Update Consultation Type
    if (isset($_POST['update_consultation'])) {
        $stmt = $pdo->prepare("UPDATE consultation_types SET value = ?, name = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['value'], $_POST['name'], isset($_POST['is_active']) ? 1 : 0, $_POST['consultation_id']]);
        $success = "Consultation type updated successfully!";
    }

    // Delete Consultation Type
    if (isset($_POST['delete_consultation'])) {
        $stmt = $pdo->prepare("DELETE FROM consultation_types WHERE id = ?");
        $stmt->execute([$_POST['consultation_id']]);
        $success = "Consultation type deleted successfully!";
    }

    // Add Attorney
    if (isset($_POST['add_attorney'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM attorneys")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO attorneys (value, name, specialization, sort_order, available, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['value'],
            $_POST['name'],
            $_POST['specialization'],
            $sort_order,
            isset($_POST['available']) ? 1 : 0,
            isset($_POST['is_active']) ? 1 : 0
        ]);
        $success = "Attorney added successfully!";
    }

    // Update Attorney
    if (isset($_POST['update_attorney'])) {
        $stmt = $pdo->prepare("UPDATE attorneys SET value = ?, name = ?, specialization = ?, available = ?, is_active = ? WHERE id = ?");
        $stmt->execute([
            $_POST['value'],
            $_POST['name'],
            $_POST['specialization'],
            isset($_POST['available']) ? 1 : 0,
            isset($_POST['is_active']) ? 1 : 0,
            $_POST['attorney_id']
        ]);
        $success = "Attorney updated successfully!";
    }

    // Delete Attorney
    if (isset($_POST['delete_attorney'])) {
        $stmt = $pdo->prepare("DELETE FROM attorneys WHERE id = ?");
        $stmt->execute([$_POST['attorney_id']]);
        $success = "Attorney deleted successfully!";
    }

    // Add Time Slot
    if (isset($_POST['add_timeslot'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM time_slots")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO time_slots (time_value, display_time, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['time_value'], $_POST['display_time'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Time slot added successfully!";
    }

    // Update Time Slot
    if (isset($_POST['update_timeslot'])) {
        $stmt = $pdo->prepare("UPDATE time_slots SET time_value = ?, display_time = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['time_value'], $_POST['display_time'], isset($_POST['is_active']) ? 1 : 0, $_POST['timeslot_id']]);
        $success = "Time slot updated successfully!";
    }

    // Delete Time Slot
    if (isset($_POST['delete_timeslot'])) {
        $stmt = $pdo->prepare("DELETE FROM time_slots WHERE id = ?");
        $stmt->execute([$_POST['timeslot_id']]);
        $success = "Time slot deleted successfully!";
    }

    // Add Info Card
    if (isset($_POST['add_infocard'])) {
        $maxSort = $pdo->query("SELECT MAX(sort_order) FROM appointment_info_cards")->fetchColumn();
        $sort_order = ($maxSort !== null) ? $maxSort + 1 : 1;
        $stmt = $pdo->prepare("INSERT INTO appointment_info_cards (icon, title, description, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['icon'], $_POST['title'], $_POST['description'], $sort_order, isset($_POST['is_active']) ? 1 : 0]);
        $success = "Info card added successfully!";
    }

    // Update Info Card
    if (isset($_POST['update_infocard'])) {
        $stmt = $pdo->prepare("UPDATE appointment_info_cards SET icon = ?, title = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$_POST['icon'], $_POST['title'], $_POST['description'], isset($_POST['is_active']) ? 1 : 0, $_POST['infocard_id']]);
        $success = "Info card updated successfully!";
    }

    // Delete Info Card
    if (isset($_POST['delete_infocard'])) {
        $stmt = $pdo->prepare("DELETE FROM appointment_info_cards WHERE id = ?");
        $stmt->execute([$_POST['infocard_id']]);
        $success = "Info card deleted successfully!";
    }

    // Update Booked Slots (for demo purposes)
    if (isset($_POST['update_booked_slots'])) {
        // This would typically be managed by the booking system
        // For admin, we'll just show a message
        $success = "Booked slots are managed automatically by the booking system.";
    }
}

// Fetch all data
$hero = $pdo->query("SELECT * FROM appointment_hero ORDER BY id DESC LIMIT 1")->fetch();
$steps = $pdo->query("SELECT * FROM appointment_steps ORDER BY step_number ASC")->fetchAll();
$features = $pdo->query("SELECT * FROM appointment_features ORDER BY sort_order ASC")->fetchAll();
$consultationTypes = $pdo->query("SELECT * FROM consultation_types ORDER BY sort_order ASC")->fetchAll();
$attorneys = $pdo->query("SELECT * FROM attorneys ORDER BY sort_order ASC")->fetchAll();
$timeSlots = $pdo->query("SELECT * FROM time_slots ORDER BY sort_order ASC")->fetchAll();
$infoCards = $pdo->query("SELECT * FROM appointment_info_cards ORDER BY sort_order ASC")->fetchAll();

// For demo, get today's booked slots
$today = date('Y-m-d');
$bookedSlots = [];
try {
    $stmt = $pdo->prepare("SELECT time_slot FROM booked_slots WHERE appointment_date = ?");
    $stmt->execute([$today]);
    $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $bookedSlots = ['10:00', '13:00', '15:00']; // Demo data
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointment | Precision Law Firm</title>
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

        .preview-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .booked-slot-badge {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            display: inline-block;
            margin: 0.25rem;
        }
    </style>
</head>

<body class="bg-gray-50">

   <?php include "navbar.php"; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-6 md:px-12 lg:px-24 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8" data-aos="fade-up-slow">
            <h1 class="text-3xl font-bold text-[#0F2854]">Appointment Page Management</h1>
            <a href="appointment.php" target="_blank" class="btn-primary inline-flex items-center">
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
                            <input type="text" name="badge_text" value="<?= htmlspecialchars($hero['badge_text'] ?? 'Book Your Consultation') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title Line 1</label>
                            <input type="text" name="title_line1" value="<?= htmlspecialchars($hero['title_line1'] ?? 'Expert Legal') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title Line 2</label>
                            <input type="text" name="title_line2" value="<?= htmlspecialchars($hero['title_line2'] ?? 'Consultation') ?>" class="form-input">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" class="form-textarea"><?= htmlspecialchars($hero['description'] ?? 'Schedule a personalized consultation with our experienced attorneys. Your first step towards legal resolution starts here.') ?></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Image URL</label>
                            <input type="text" name="background_image" value="<?= htmlspecialchars($hero['background_image'] ?? 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="phone_number" value="<?= htmlspecialchars($hero['phone_number'] ?? '214-4607') ?>" class="form-input">
                        </div>
                    </div>
                    <button type="submit" name="update_hero" class="btn-primary mt-4">
                        <i class="fas fa-save mr-2"></i>Update Hero Section
                    </button>
                </form>
            </div>
        </div>

        <!-- Appointment request -->
        <div class="admin-section p-6 bg-white rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Appointment Requests</h2>

            <?php if (!empty($appointments)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 border">#</th>
                                <th class="p-3 border">Name</th>
                                <th class="p-3 border">Email</th>
                                <th class="p-3 border">Phone</th>
                                <th class="p-3 border">Date</th>
                                <th class="p-3 border">Time</th>
                                <th class="p-3 border">Type</th>
                                <th class="p-3 border">Attorney</th>
                                <th class="p-3 border">Status</th>
                                <th class="p-3 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $index => $appt): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 border"><?= $index + 1 ?></td>
                                    <td class="p-3 border font-semibold">
                                        <?= htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']) ?>
                                    </td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['email']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['phone']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['appointment_date']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['appointment_time']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['consultation_type']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($appt['attorney_preference'] ?? '-') ?></td>

                                    <!-- STATUS SELECT -->
                                    <td class="p-3 border">
                                        <select
                                            class="appointment-status border rounded px-2 py-1"
                                            data-id="<?= $appt['id'] ?>">
                                            <option value="pending" <?= $appt['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="confirmed" <?= $appt['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                            <option value="completed" <?= $appt['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                            <option value="canceled" <?= $appt['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                                        </select>
                                    </td>

                                    <td class="p-3 border">
                                        <form method="POST" action="delete-appointment.php"
                                            onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No appointment requests found.</p>
            <?php endif; ?>
        </div>


        <!-- Steps Management -->
        <div id="steps-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('steps-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-stairs mr-2"></i>Appointment Steps</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="steps-content" class="section-content p-6">
                <!-- Add New Step -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Step</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Step Number</label>
                            <input type="number" name="step_number" placeholder="e.g., 1" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" placeholder="Step Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" placeholder="Step Description" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_step" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Step
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Steps -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Step #</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($steps as $step): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="step_id" value="<?= $step['id'] ?>">
                                        <input type="number" name="step_number" value="<?= $step['step_number'] ?>" class="form-input text-sm w-20">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($step['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="description" value="<?= htmlspecialchars($step['description']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $step['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_step" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this step?')">
                                        <input type="hidden" name="step_id" value="<?= $step['id'] ?>">
                                        <button type="submit" name="delete_step" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Features Management -->
        <div id="features-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('features-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-check-circle mr-2"></i>Why Book With Us Features</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="features-content" class="section-content p-6">
                <!-- Add New Feature -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Feature</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            <input type="text" name="icon" placeholder="e.g., fa-calendar-check" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <input type="text" name="description" placeholder="Feature Description" class="form-input" required>
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
                            <th class="px-4 py-2 text-left">Description</th>
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
                                        <input type="text" name="icon" value="<?= htmlspecialchars($feature['icon']) ?>" class="form-input text-sm w-24">
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

        <!-- Consultation Types Management -->
        <div id="consultation-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('consultation-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-comments mr-2"></i>Consultation Types</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="consultation-content" class="section-content p-6">
                <!-- Add New Consultation Type -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Consultation Type</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value (slug)</label>
                            <input type="text" name="value" placeholder="e.g., in-person" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Name</label>
                            <input type="text" name="name" placeholder="e.g., In-person at Office" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_consultation" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Consultation Type
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Consultation Types -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Value</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultationTypes as $type): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="consultation_id" value="<?= $type['id'] ?>">
                                        <input type="text" name="value" value="<?= htmlspecialchars($type['value']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="name" value="<?= htmlspecialchars($type['name']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $type['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_consultation" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this consultation type?')">
                                        <input type="hidden" name="consultation_id" value="<?= $type['id'] ?>">
                                        <button type="submit" name="delete_consultation" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Attorneys Management -->
        <div id="attorneys-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('attorneys-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-user-tie mr-2"></i>Attorneys</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="attorneys-content" class="section-content p-6">
                <!-- Add New Attorney -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Attorney</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value (slug)</label>
                            <input type="text" name="value" placeholder="e.g., corporate" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" name="name" placeholder="e.g., Maître Jean Dupont" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                            <input type="text" name="specialization" placeholder="e.g., Corporate Law Specialist" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center mr-4">
                                <input type="checkbox" name="available" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Available</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_attorney" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Attorney
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Attorneys -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Value</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Specialization</th>
                            <th class="px-4 py-2 text-left">Available</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attorneys as $attorney): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="attorney_id" value="<?= $attorney['id'] ?>">
                                        <input type="text" name="value" value="<?= htmlspecialchars($attorney['value']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="name" value="<?= htmlspecialchars($attorney['name']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="specialization" value="<?= htmlspecialchars($attorney['specialization']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="available" value="1" <?= $attorney['available'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $attorney['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_attorney" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this attorney?')">
                                        <input type="hidden" name="attorney_id" value="<?= $attorney['id'] ?>">
                                        <button type="submit" name="delete_attorney" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Time Slots Management -->
        <div id="timeslots-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('timeslots-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-clock mr-2"></i>Time Slots</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="timeslots-content" class="section-content p-6">
                <!-- Add New Time Slot -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Time Slot</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Time Value (24h)</label>
                            <input type="text" name="time_value" placeholder="e.g., 09:00" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Time</label>
                            <input type="text" name="display_time" placeholder="e.g., 9:00 AM" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_timeslot" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Time Slot
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Today's Booked Slots Preview -->
                <div class="preview-box mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Today's Booked Slots (<?= date('Y-m-d') ?>)</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($bookedSlots as $slot): ?>
                            <span class="booked-slot-badge"><i class="fas fa-ban mr-1"></i><?= $slot ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Note: Booked slots are managed automatically by the booking system.</p>
                </div>

                <!-- Existing Time Slots -->
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Time Value</th>
                            <th class="px-4 py-2 text-left">Display Time</th>
                            <th class="px-4 py-2 text-left">Active</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($timeSlots as $slot): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="timeslot_id" value="<?= $slot['id'] ?>">
                                        <input type="text" name="time_value" value="<?= htmlspecialchars($slot['time_value']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="display_time" value="<?= htmlspecialchars($slot['display_time']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $slot['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_timeslot" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this time slot?')">
                                        <input type="hidden" name="timeslot_id" value="<?= $slot['id'] ?>">
                                        <button type="submit" name="delete_timeslot" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Info Cards Management -->
        <div id="infocards-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('infocards-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-info-circle mr-2"></i>Additional Info Cards</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="infocards-content" class="section-content p-6">
                <!-- Add New Info Card -->
                <form method="POST" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-[#0F2854]">Add New Info Card</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            <input type="text" name="icon" placeholder="e.g., fa-shield-alt" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" placeholder="Card Title" class="form-input" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="2" placeholder="Card Description" class="form-textarea" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" name="add_infocard" class="btn-success">
                                <i class="fas fa-plus mr-2"></i>Add Info Card
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Existing Info Cards -->
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
                        <?php foreach ($infoCards as $card): ?>
                            <tr class="table-row border-t">
                                <td class="px-4 py-3">
                                    <form method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="infocard_id" value="<?= $card['id'] ?>">
                                        <input type="text" name="icon" value="<?= htmlspecialchars($card['icon']) ?>" class="form-input text-sm w-24">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="description" value="<?= htmlspecialchars($card['description']) ?>" class="form-input text-sm">
                                </td>
                                <td class="px-4 py-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" value="1" <?= $card['is_active'] ? 'checked' : '' ?>>
                                    </label>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" name="update_infocard" class="text-blue-600 hover:text-blue-800 mr-2" title="Save">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    </form>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this info card?')">
                                        <input type="hidden" name="infocard_id" value="<?= $card['id'] ?>">
                                        <button type="submit" name="delete_infocard" class="text-red-600 hover:text-red-800" title="Delete">
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

        <!-- Booked Slots Preview (Read-only) -->
        <div id="booked-section" class="admin-card" data-aos="fade-up-slow">
            <div class="section-header flex justify-between items-center" onclick="toggleSection('booked-content')">
                <h2 class="text-xl font-semibold"><i class="fas fa-chevron-down mr-3 transition-transform"></i><i class="fas fa-calendar-check mr-2"></i>Today's Booked Slots</h2>
                <span class="text-sm opacity-75">Click to toggle</span>
            </div>
            <div id="booked-content" class="section-content p-6">
                <form method="POST">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Booked slots are managed automatically by the booking system. This is a read-only preview of today's booked slots.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        <?php
                        $allTimes = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];
                        foreach ($allTimes as $time):
                            $isBooked = in_array($time, $bookedSlots);
                        ?>
                            <div class="p-3 border rounded-lg <?= $isBooked ? 'bg-red-50 border-red-300' : 'bg-green-50 border-green-300' ?>">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium"><?= $time ?></span>
                                    <?php if ($isBooked): ?>
                                        <span class="text-red-600 text-sm"><i class="fas fa-times-circle"></i> Booked</span>
                                    <?php else: ?>
                                        <span class="text-green-600 text-sm"><i class="fas fa-check-circle"></i> Available</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
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

    <script>
        document.querySelectorAll('.appointment-status').forEach(select => {
            select.addEventListener('change', function() {

                const id = this.dataset.id;
                const status = this.value;

                fetch('update-appointment-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + id + '&status=' + status
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.style.border = "2px solid green";
                            setTimeout(() => {
                                this.style.border = "";
                            }, 800);
                        } else {
                            alert('Update failed');
                        }
                    })
                    .catch(() => {
                        alert('Server error');
                    });
            });
        });
    </script>
</body>

</html>