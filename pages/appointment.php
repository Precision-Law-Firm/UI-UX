<?php
require '../config.php';

// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Fetch Appointment Hero ---
$hero = null;
try {
    $stmt = $pdo->query("SELECT * FROM appointment_hero ORDER BY id DESC LIMIT 1");
    $hero = $stmt->fetch();
} catch (Exception $e) {
    // Silently fail, will use defaults
}

// --- Fetch Appointment Steps ---
$steps = [];
try {
    $stmt = $pdo->query("SELECT * FROM appointment_steps WHERE is_active = 1 ORDER BY step_number ASC");
    $steps = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Appointment Features ---
$features = [];
try {
    $stmt = $pdo->query("SELECT * FROM appointment_features WHERE is_active = 1 ORDER BY sort_order ASC");
    $features = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Consultation Types ---
$consultationTypes = [];
try {
    $stmt = $pdo->query("SELECT * FROM consultation_types WHERE is_active = 1 ORDER BY sort_order ASC");
    $consultationTypes = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Attorneys ---
$attorneys = [];
try {
    $stmt = $pdo->query("SELECT * FROM attorneys WHERE is_active = 1 AND available = 1 ORDER BY sort_order ASC");
    $attorneys = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Time Slots ---
$timeSlots = [];
try {
    $stmt = $pdo->query("SELECT * FROM time_slots WHERE is_active = 1 ORDER BY sort_order ASC");
    $timeSlots = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Today's booked slots for demo ---
$bookedSlots = [];
try {
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT time_slot FROM booked_slots WHERE appointment_date = ?");
    $stmt->execute([$today]);
    $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    // For demo, use some default booked slots
    $bookedSlots = ['10:00', '13:00', '15:00'];
}

// --- Fetch Info Cards ---
$infoCards = [];
try {
    $stmt = $pdo->query("SELECT * FROM appointment_info_cards WHERE is_active = 1 ORDER BY sort_order ASC");
    $infoCards = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// DONNÉES PAR DÉFAUT SI RIEN N'EST TROUVÉ
if (empty($hero)) {
    $hero = [
        'badge_text' => 'Book Your Consultation',
        'title_line1' => 'Expert Legal',
        'title_line2' => 'Consultation',
        'description' => 'Schedule a personalized consultation with our experienced attorneys. Your first step towards legal resolution starts here.',
        'background_image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
        'phone_number' => '214-4607'
    ];
}

if (empty($steps)) {
    $steps = [
        ['step_number' => 1, 'title' => 'Personal Information', 'description' => 'Provide your contact details so we can reach you for confirmation.'],
        ['step_number' => 2, 'title' => 'Select Date & Time', 'description' => 'Choose your preferred consultation date and available time slot.'],
        ['step_number' => 3, 'title' => 'Consultation Details', 'description' => 'Specify the type of consultation and attorney preference.'],
        ['step_number' => 4, 'title' => 'Confirmation', 'description' => 'Review and submit your appointment. We\'ll confirm within 24 hours.']
    ];
}

if (empty($features)) {
    $features = [
        ['icon' => 'fa-calendar-check', 'title' => 'Why Book With Us?', 'description' => 'Flexible consultation options (in-person, video, phone)'],
        ['icon' => 'fa-check-circle', 'title' => 'Experienced Attorneys', 'description' => 'Experienced attorneys in specialized legal fields'],
        ['icon' => 'fa-check-circle', 'title' => 'Confidential Communication', 'description' => 'Confidential and secure client-attorney communication'],
        ['icon' => 'fa-check-circle', 'title' => 'Transparent Pricing', 'description' => 'Transparent pricing with no hidden fees'],
        ['icon' => 'fa-check-circle', 'title' => 'Quick Confirmation', 'description' => '24-hour appointment confirmation guarantee']
    ];
}

if (empty($consultationTypes)) {
    $consultationTypes = [
        ['value' => 'in-person', 'name' => 'In-person at Office'],
        ['value' => 'video', 'name' => 'Video Conference'],
        ['value' => 'phone', 'name' => 'Phone Call']
    ];
}

if (empty($attorneys)) {
    $attorneys = [
        ['value' => 'general', 'name' => 'Any Available Attorney', 'specialization' => 'General Practice'],
        ['value' => 'corporate', 'name' => 'Maître Jean Dupont', 'specialization' => 'Corporate Law Specialist'],
        ['value' => 'family', 'name' => 'Maître Marie Curé', 'specialization' => 'Family Law Specialist'],
        ['value' => 'property', 'name' => 'Maître Pierre Laurent', 'specialization' => 'Property Law Specialist']
    ];
}

if (empty($timeSlots)) {
    $timeSlots = [
        ['time_value' => '09:00', 'display_time' => '9:00 AM'],
        ['time_value' => '10:00', 'display_time' => '10:00 AM'],
        ['time_value' => '11:00', 'display_time' => '11:00 AM'],
        ['time_value' => '12:00', 'display_time' => '12:00 PM'],
        ['time_value' => '13:00', 'display_time' => '1:00 PM'],
        ['time_value' => '14:00', 'display_time' => '2:00 PM'],
        ['time_value' => '15:00', 'display_time' => '3:00 PM'],
        ['time_value' => '16:00', 'display_time' => '4:00 PM']
    ];
}

if (empty($infoCards)) {
    $infoCards = [
        ['icon' => 'fa-shield-alt', 'title' => 'Confidentiality Guaranteed', 'description' => 'All consultations are protected by attorney-client privilege and strict confidentiality protocols.'],
        ['icon' => 'fa-clock', 'title' => 'Flexible Scheduling', 'description' => 'We offer appointments during extended hours, including Saturdays, to accommodate your schedule.'],
        ['icon' => 'fa-file-contract', 'title' => 'No Obligation Consultation', 'description' => 'Initial consultations carry no obligation to retain our services. Get expert advice first.']
    ];
}

// Function to check if a time slot is booked
function isTimeSlotBooked($timeValue, $bookedSlots) {
    return in_array($timeValue, $bookedSlots);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Hero Section avec overlay */
        .hero-section {
            background: linear-gradient(rgba(15, 40, 84, 0.85), rgba(28, 77, 141, 0.9)), url('<?= htmlspecialchars($hero['background_image']) ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            padding-top: 120px;
            padding-bottom: 100px;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Cartes améliorées */
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-card-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Formulaires améliorés */
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(28, 77, 141, 0.15);
            overflow: hidden;
            border: 1px solid rgba(28, 77, 141, 0.1);
        }

        .form-input {
            transition: all 0.3s;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 16px;
        }

        .form-input:focus {
            border-color: #1C4D8D;
            box-shadow: 0 0 0 4px rgba(28, 77, 141, 0.1);
            transform: translateY(-1px);
        }

        /* Boutons améliorés */
        .btn-primary {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            position: relative;
            overflow: hidden;
            font-size: 16px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(28, 77, 141, 0.3);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::after {
            left: 100%;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 8px 18px;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Section spacing améliorée */
        .section-spacing {
            padding: 80px 0;
        }

        /* Timeline pour les étapes */
        .timeline-step {
            position: relative;
            padding-left: 40px;
            margin-bottom: 30px;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
        }

        .timeline-step::after {
            content: '';
            position: absolute;
            left: 11px;
            top: 24px;
            bottom: -30px;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-step:last-child::after {
            display: none;
        }

        /* Animation lente et douce */
        .aos-init[data-aos] {
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

        [data-aos="fade-left-slow"] {
            transform: translateX(-40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-left-slow"].aos-animate {
            transform: translateX(0);
            opacity: 1;
        }

        [data-aos="fade-right-slow"] {
            transform: translateX(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-right-slow"].aos-animate {
            transform: translateX(0);
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

        /* Styles pour le chatbox */
        .chatbox-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .chatbox-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(28, 77, 141, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 3px solid white;
        }

        .chatbox-toggle:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 15px 40px rgba(28, 77, 141, 0.4);
        }

        .chatbox-toggle i {
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .chatbox-toggle:hover i {
            transform: scale(1.2);
        }

        .chatbox-window {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid #e5e7eb;
        }

        .chatbox-window.active {
            display: block;
            transform: translateY(0);
            opacity: 1;
            animation: slideInUp 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chatbox-header {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chatbox-header h3 {
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chatbox-header h3 i {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
        }

        .close-chat {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .close-chat:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .chatbox-body {
            height: 360px;
            padding: 20px;
            overflow-y: auto;
            background: #f8fafc;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }

        .message.bot {
            align-self: flex-start;
        }

        .message.user {
            align-self: flex-end;
            margin-left: auto;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
        }

        .message.bot .message-content {
            background: white;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 5px;
            color: #374151;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
            margin-left: 12px;
        }

        .message.user .message-time {
            text-align: right;
            margin-right: 12px;
        }

        .chatbox-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            background: white;
        }

        .message-input {
            display: flex;
            gap: 10px;
        }

        .message-input input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
            transition: border 0.3s;
        }

        .message-input input:focus {
            border-color: #1C4D8D;
            box-shadow: 0 0 0 3px rgba(28, 77, 141, 0.1);
        }

        .send-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .send-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(28, 77, 141, 0.3);
        }

        /* Styles pour le calendrier */
        .date-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-top: 15px;
        }

        .date-cell {
            padding: 12px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
            font-size: 16px;
        }

        .date-cell:hover:not(.disabled):not(.selected) {
            background: #f3f4f6;
            border-color: #dbeafe;
        }

        .date-cell.selected {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            transform: scale(1.05);
        }

        .date-cell.disabled {
            color: #d1d5db;
            cursor: not-allowed;
            background: #f9fafb;
        }

        .date-cell.today {
            border: 2px solid #1C4D8D;
            background: #eff6ff;
        }

        /* Styles pour les créneaux horaires */
        .time-slots {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .time-slot {
            padding: 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
            font-weight: 500;
        }

        .time-slot:hover:not(.booked) {
            border-color: #1C4D8D;
            background: #eff6ff;
            transform: translateY(-2px);
        }

        .time-slot.selected {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(28, 77, 141, 0.2);
        }

        .time-slot.booked {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* Animation pour les messages */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message {
            animation: fadeIn 0.3s ease-out;
        }

        /* Styles pour le formulaire de rendez-vous */
        .appointment-form-step {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .appointment-form-step.active {
            display: block;
        }

        .form-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .form-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #e5e7eb;
            transform: translateY(-50%);
            z-index: 1;
        }

        .progress-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #9ca3af;
            position: relative;
            z-index: 2;
            transition: all 0.3s;
            font-size: 16px;
        }

        .progress-step.active {
            border-color: #1C4D8D;
            background: #1C4D8D;
            color: white;
            transform: scale(1.1);
        }

        .progress-step.completed {
            border-color: #10b981;
            background: #10b981;
            color: white;
        }

        /* Badge de notification sur le chatbox */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        /* Stats counter */
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
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

    <!-- Navbar - Increased text size -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4 shadow-sm">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 w-full justify-between">
                    <!-- Logo -->
                    <div class="text-[#D4AF37] font-bold text-2xl tracking-tight">
                        <i class="fas fa-balance-scale mr-2"></i>Precision Law Firm
                    </div>

                    <!-- Navigation - from text-sm to text-base -->
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
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Courses
                        </a>
                        <a href="appointment.php"
                            class="text-[#D4AF37] font-medium transition duration-300 text-base tracking-wide">
                            Appointment
                        </a>
                    </div>

                    <!-- Contact Button -->
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-6 py-3 rounded-full font-medium hover:opacity-90 transition duration-300 hover-lift text-base tracking-wide shadow-sm hover:shadow-md">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden flex items-center justify-between w-full">
                    <div class="text-[#D4AF37] font-bold text-xl">
                        <i class="fas fa-balance-scale mr-2"></i>Precision Law Firm
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
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
                        Courses
                    </a>
                    <a href="appointment.php"
                        class="text-[#D4AF37] font-medium transition duration-300 text-base py-2">
                        Appointment
                    </a>
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-4 py-3 rounded-md font-medium text-center mt-2 transition duration-300 text-base">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section relative overflow-hidden" data-aos="fade-up-slow" data-aos-duration="1500">
        <div class="hero-pattern"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span class="badge mb-6" data-aos="fade-up-slow" data-aos-delay="100">
                    <i class="fas fa-calendar-alt mr-2"></i><?= htmlspecialchars($hero['badge_text']) ?>
                </span>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6" data-aos="fade-up-slow" data-aos-delay="200">
                    <?= htmlspecialchars($hero['title_line1']) ?> <span class="text-[#D4AF37]"><?= htmlspecialchars($hero['title_line2']) ?></span>
                </h1>

                <p class="text-xl md:text-2xl text-blue-100 mb-10 max-w-2xl mx-auto" data-aos="fade-up-slow" data-aos-delay="300">
                    <?= htmlspecialchars($hero['description']) ?>
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up-slow" data-aos-delay="400">
                    <a href="#booking-form" class="btn-primary inline-flex items-center justify-center text-lg">
                        <i class="fas fa-calendar-check mr-3"></i> Book Appointment Now
                    </a>
                    <a href="tel:<?= htmlspecialchars($hero['phone_number']) ?>"
                        class="bg-white text-[#0F2854] px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition duration-300 inline-flex items-center justify-center text-lg">
                        <i class="fas fa-phone mr-3"></i> Call: <?= htmlspecialchars($hero['phone_number']) ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Process - Larger text -->
    <section class="section-spacing bg-white">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4" data-aos="fade-up-slow">
                    Simple <span class="text-[#1C4D8D]">4-Step</span> Appointment Process
                </h2>
                <p class="text-gray-600 text-xl" data-aos="fade-up-slow" data-aos-delay="100">
                    Our streamlined process ensures you get the legal assistance you need quickly and efficiently.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <?php foreach ($steps as $index => $step): ?>
                    <div class="timeline-step" data-aos="fade-right-slow" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $step['step_number'] ?>. <?= htmlspecialchars($step['title']) ?></h3>
                        <p class="text-gray-600 text-lg"><?= htmlspecialchars($step['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="feature-card" data-aos="zoom-slow" data-aos-delay="500">
                    <div class="feature-card-icon">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Why Book With Us?</h3>
                    <ul class="space-y-4 text-gray-600 text-lg">
                        <?php foreach ($features as $feature): ?>
                        <li class="flex items-start">
                            <i class="fas <?= $feature['icon'] ?> text-green-500 mr-3 mt-1"></i>
                            <span><?= htmlspecialchars($feature['description']) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Booking Section - Larger text -->
    <section class="section-spacing bg-gray-50" id="booking-form">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="form-container" data-aos="fade-up-slow" data-aos-duration="1500">
                    <div class="p-8 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white">
                        <h2 class="text-3xl md:text-4xl font-bold mb-2">Schedule Your Legal Consultation</h2>
                        <p class="text-blue-100 text-lg">Complete the form below to book your appointment</p>
                    </div>

                    <div class="p-8 md:p-10">
                        <!-- Form Progress Steps -->
                        <div class="form-progress mb-10">
                            <div class="progress-step active">1</div>
                            <div class="progress-step">2</div>
                            <div class="progress-step">3</div>
                            <div class="progress-step">4</div>
                        </div>

                        <form id="appointment-form" class="space-y-6" method="POST" action="process-appointment.php">
                            <!-- Step 1: Personal Info -->
                            <div class="appointment-form-step active" id="step1">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Personal Information</h3>
                                <div class="space-y-6">
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-gray-700 mb-2 font-medium text-lg">First Name</label>
                                            <input type="text" name="first_name" required class="form-input w-full text-base"
                                                placeholder="Enter your first name">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 mb-2 font-medium text-lg">Last Name</label>
                                            <input type="text" name="last_name" required class="form-input w-full text-base"
                                                placeholder="Enter your last name">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium text-lg">Email Address</label>
                                        <input type="email" name="email" required class="form-input w-full text-base"
                                            placeholder="Enter your email">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium text-lg">Phone Number</label>
                                        <input type="tel" name="phone" required class="form-input w-full text-base"
                                            placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="mt-10 flex justify-end">
                                    <button type="button" onclick="nextStep(2)" class="btn-primary text-lg">
                                        Next: Choose Date <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Date Selection -->
                            <div class="appointment-form-step" id="step2">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Select Date</h3>
                                <div class="date-grid" id="calendar-grid">
                                    <!-- Date cells will be generated by JavaScript -->
                                </div>
                                <div class="mt-10 flex justify-between">
                                    <button type="button" onclick="prevStep(1)"
                                        class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300 font-medium text-lg">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="button" onclick="nextStep(3)" class="btn-primary text-lg">
                                        Next: Choose Time <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Time Selection -->
                            <div class="appointment-form-step" id="step3">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Select Time Slot</h3>
                                <div class="time-slots" id="time-slots">
                                    <!-- Time slots will be generated by JavaScript -->
                                </div>
                                <div class="mt-10 flex justify-between">
                                    <button type="button" onclick="prevStep(2)"
                                        class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300 font-medium text-lg">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="button" onclick="nextStep(4)" class="btn-primary text-lg">
                                        Next: Final Details <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 4: Final Details -->
                            <div class="appointment-form-step" id="step4">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Appointment Details</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium text-lg">Consultation Type</label>
                                        <select name="consultation_type" class="form-input w-full text-base" required>
                                            <option value="">Select Consultation Type</option>
                                            <?php foreach ($consultationTypes as $type): ?>
                                            <option value="<?= htmlspecialchars($type['value']) ?>"><?= htmlspecialchars($type['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium text-lg">Attorney Preference</label>
                                        <select name="attorney_preference" class="form-input w-full text-base">
                                            <option value="">Select Attorney</option>
                                            <?php foreach ($attorneys as $attorney): ?>
                                            <option value="<?= htmlspecialchars($attorney['value']) ?>"><?= htmlspecialchars($attorney['name']) ?> - <?= htmlspecialchars($attorney['specialization']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium text-lg">Case Description (Optional)</label>
                                        <textarea name="case_description" rows="4" class="form-input w-full text-base"
                                            placeholder="Brief description of your legal matter"></textarea>
                                    </div>
                                    <input type="hidden" name="appointment_date" id="selected-date">
                                    <input type="hidden" name="appointment_time" id="selected-time">
                                </div>
                                <div class="mt-10 flex justify-between">
                                    <button type="button" onclick="prevStep(3)"
                                        class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300 font-medium text-lg">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </button>
                                    <button type="submit"
                                        class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-lg hover:opacity-90 transition duration-300 font-bold text-lg">
                                        <i class="fas fa-calendar-check mr-2"></i> Confirm Appointment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Info Cards - Larger text -->
                <div class="grid md:grid-cols-3 gap-8 mt-12">
                    <?php foreach ($infoCards as $index => $card): ?>
                    <div class="feature-card" data-aos="fade-up-slow" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="feature-card-icon">
                            <i class="fas <?= htmlspecialchars($card['icon']) ?> text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($card['title']) ?></h3>
                        <p class="text-gray-600 text-base"><?= htmlspecialchars($card['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbox -->
    <div class="chatbox-container">
        <div class="chatbox-toggle" id="chatbox-toggle">
            <i class="fas fa-comments"></i>
            <div class="notification-badge">1</div>
        </div>
        <div class="chatbox-window" id="chatbox-window">
            <div class="chatbox-header">
                <h3><i class="fas fa-robot"></i> Legal Assistant Bot</h3>
                <button class="close-chat" id="close-chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chatbox-body" id="chatbox-body">
                <div class="message bot">
                    <div class="message-content">
                        Hello! I'm your legal assistant. How can I help you today? You can ask about:
                        <br><br>
                        • Appointment booking<br>
                        • Legal consultation types<br>
                        • Office hours<br>
                        • Document requirements<br>
                        • Or type your question
                    </div>
                    <div class="message-time">Just now</div>
                </div>
            </div>
            <div class="chatbox-footer">
                <div class="message-input">
                    <input type="text" id="chat-input" placeholder="Type your message here...">
                    <button class="send-btn" id="send-message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1500,
            offset: 80,
            easing: 'ease-out-cubic',
            once: true,
            delay: 0,
            mirror: false,
            anchorPlacement: 'top-bottom',
            startEvent: 'DOMContentLoaded',
            disable: false
        });

        // Appointment form functionality
        let currentStep = 1;
        let selectedDate = '';
        let selectedTime = '';

        // Time slots data from PHP
        const timeSlots = <?= json_encode($timeSlots) ?>;
        const bookedSlots = <?= json_encode($bookedSlots) ?>;

        function nextStep(step) {
            // Validate current step before proceeding
            if (currentStep === 1) {
                const firstName = document.querySelector('input[name="first_name"]').value;
                const lastName = document.querySelector('input[name="last_name"]').value;
                const email = document.querySelector('input[name="email"]').value;
                const phone = document.querySelector('input[name="phone"]').value;

                if (!firstName || !lastName || !email || !phone) {
                    alert('Please fill in all required fields');
                    return;
                }
            }

            if (currentStep === 2 && !selectedDate) {
                alert('Please select a date');
                return;
            }

            if (currentStep === 3 && !selectedTime) {
                alert('Please select a time slot');
                return;
            }

            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('completed');

            currentStep = step;
            document.getElementById(`step${currentStep}`).classList.add('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('active');

            // Generate calendar for step 2
            if (step === 2) {
                generateCalendar();
            }
            // Generate time slots for step 3
            else if (step === 3) {
                generateTimeSlots();
            }
        }

        function prevStep(step) {
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('completed');

            currentStep = step;
            document.getElementById(`step${currentStep}`).classList.add('active');
            document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('active');
        }

        function generateCalendar() {
            const calendar = document.getElementById('calendar-grid');
            calendar.innerHTML = '';

            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            // Add day headers
            days.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'text-center text-sm font-medium text-gray-500 py-2 text-base';
                dayHeader.textContent = day;
                calendar.appendChild(dayHeader);
            });

            const today = new Date();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            // Get first day of current month
            const firstDay = new Date(currentYear, currentMonth, 1);
            // Get last day of current month
            const lastDay = new Date(currentYear, currentMonth + 1, 0);

            // Add empty cells for days before first day of month
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyCell = document.createElement('div');
                calendar.appendChild(emptyCell);
            }

            // Add days of the month
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dateCell = document.createElement('div');
                dateCell.className = 'date-cell text-base';
                dateCell.textContent = day;

                const cellDate = new Date(currentYear, currentMonth, day);
                const dateString = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                // Mark today
                if (day === today.getDate() && currentMonth === today.getMonth()) {
                    dateCell.classList.add('today');
                }

                // Disable past dates
                if (cellDate < today) {
                    dateCell.classList.add('disabled');
                } else {
                    dateCell.addEventListener('click', () => {
                        document.querySelectorAll('.date-cell.selected').forEach(cell => {
                            cell.classList.remove('selected');
                        });
                        dateCell.classList.add('selected');
                        selectedDate = dateString;
                        document.getElementById('selected-date').value = dateString;
                    });
                }

                calendar.appendChild(dateCell);
            }
        }

        function generateTimeSlots() {
            const timeSlotsContainer = document.getElementById('time-slots');
            timeSlotsContainer.innerHTML = '';

            timeSlots.forEach((slot, index) => {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot text-base';
                timeSlot.textContent = slot.display_time;

                if (bookedSlots.includes(slot.time_value)) {
                    timeSlot.classList.add('booked');
                } else {
                    timeSlot.addEventListener('click', () => {
                        document.querySelectorAll('.time-slot.selected').forEach(slot => {
                            slot.classList.remove('selected');
                        });
                        timeSlot.classList.add('selected');
                        selectedTime = slot.time_value;
                        document.getElementById('selected-time').value = slot.time_value;
                    });
                }

                timeSlotsContainer.appendChild(timeSlot);
            });
        }

        // Chatbox functionality
        const chatboxToggle = document.getElementById('chatbox-toggle');
        const chatboxWindow = document.getElementById('chatbox-window');
        const closeChat = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const sendMessageBtn = document.getElementById('send-message');
        const chatboxBody = document.getElementById('chatbox-body');

        chatboxToggle.addEventListener('click', () => {
            chatboxWindow.classList.toggle('active');
            document.querySelector('.notification-badge').style.display = 'none';
        });

        closeChat.addEventListener('click', () => {
            chatboxWindow.classList.remove('active');
        });

        sendMessageBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            addMessage(message, 'user');
            chatInput.value = '';

            setTimeout(() => {
                const botResponse = getBotResponse(message);
                addMessage(botResponse, 'bot');
            }, 1000);
        }

        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;

            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';
            contentDiv.textContent = text;

            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            const now = new Date();
            timeDiv.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            messageDiv.appendChild(contentDiv);
            messageDiv.appendChild(timeDiv);
            chatboxBody.appendChild(messageDiv);

            chatboxBody.scrollTop = chatboxBody.scrollHeight;
        }

        function getBotResponse(message) {
            const lowerMessage = message.toLowerCase();

            if (lowerMessage.includes('appointment') || lowerMessage.includes('book')) {
                return "You can book an appointment using the form above. Our office hours are Monday-Friday 9AM-5PM and Saturday 9AM-1PM.";
            } else if (lowerMessage.includes('hour') || lowerMessage.includes('time')) {
                return "Our office hours are: Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM.";
            } else if (lowerMessage.includes('phone') || lowerMessage.includes('call')) {
                return "You can call us at <?= $hero['phone_number'] ?> during office hours.";
            } else if (lowerMessage.includes('email') || lowerMessage.includes('contact')) {
                return "You can email us at LawfirmPrecision@outlook.com. We typically respond within 24 hours.";
            } else if (lowerMessage.includes('location') || lowerMessage.includes('address')) {
                return "We're located at: 7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis.";
            } else if (lowerMessage.includes('document') || lowerMessage.includes('paper')) {
                return "For your consultation, please bring any relevant documents related to your case. If it's your first visit, bring identification and any court documents if applicable.";
            } else if (lowerMessage.includes('cost') || lowerMessage.includes('price') || lowerMessage.includes('fee')) {
                return "Our consultation fees vary based on the type of legal matter. Initial consultation fees will be discussed when you book your appointment.";
            } else {
                return "Thank you for your message. For specific legal advice, please book an appointment with one of our attorneys. Is there anything else I can help you with regarding appointments, hours, or general information?";
            }
        }

        // Appointment form submission
        document.getElementById('appointment-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all required fields
            if (!selectedDate || !selectedTime) {
                alert('Please select both date and time');
                return;
            }

            // You can add AJAX submission here
            // For now, show success message
            const formData = new FormData(this);
            
            // Simulate successful submission
            const successHTML = `
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Appointment Request Submitted!</h3>
                    <p class="text-gray-600 text-lg mb-6">
                        Thank you for scheduling with Precision Law Firm. We will contact you within 24 hours to confirm your appointment.
                    </p>
                    <div class="space-y-2 text-gray-700 text-base">
                        <p><i class="fas fa-envelope text-blue-500 mr-2"></i> Confirmation email sent to your inbox</p>
                        <p><i class="fas fa-phone text-blue-500 mr-2"></i> You'll receive a confirmation call shortly</p>
                    </div>
                    <button onclick="resetForm()" class="btn-primary mt-8 text-lg">
                        <i class="fas fa-calendar-plus mr-2"></i> Book Another Appointment
                    </button>
                </div>
            `;

            document.querySelector('.form-container').innerHTML = successHTML;
        });

        function resetForm() {
            location.reload();
        }

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

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <!-- Script to load footer component -->
    <script>
        fetch("/components/footer.html")
            .then(res => res.text())
            .then(data => {
                document.getElementById("footer").innerHTML = data;
                setTimeout(() => {
                    AOS.refresh();
                }, 300);
            })
            .catch(error => {
                console.error('Error loading footer:', error);
            });
    </script>
</body>

</html>