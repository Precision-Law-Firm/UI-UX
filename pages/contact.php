<?php
require '../config.php';

// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Fetch Contact Hero ---
$hero = null;
try {
    $stmt = $pdo->query("SELECT * FROM contact_hero ORDER BY id DESC LIMIT 1");
    $hero = $stmt->fetch();
} catch (Exception $e) {
    // Silently fail, will use defaults
}

// --- Fetch Contact Cards ---
$contactCards = [];
try {
    $stmt = $pdo->query("SELECT * FROM contact_cards WHERE is_active = 1 ORDER BY sort_order ASC");
    $contactCards = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Office Hours ---
$officeHours = [];
try {
    $stmt = $pdo->query("SELECT * FROM office_hours WHERE is_active = 1 ORDER BY sort_order ASC");
    $officeHours = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Social Links ---
$socialLinks = [];
try {
    $stmt = $pdo->query("SELECT * FROM social_links WHERE is_active = 1 ORDER BY sort_order ASC");
    $socialLinks = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Career Positions ---
$careerPositions = [];
try {
    $stmt = $pdo->query("SELECT * FROM career_positions WHERE is_active = 1 ORDER BY sort_order ASC");
    $careerPositions = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// --- Fetch Chat Responses ---
$chatResponses = [];
try {
    $stmt = $pdo->query("SELECT * FROM chat_responses WHERE is_active = 1 ORDER BY sort_order ASC");
    $chatResponses = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fail
}

// DONNÉES PAR DÉFAUT SI RIEN N'EST TROUVÉ
if (empty($hero)) {
    $hero = [
        'title_line1' => 'Contact Us &',
        'title_line2' => 'Careers',
        'description' => 'Get in touch with our legal experts or explore career opportunities at Precision Law Firm.'
    ];
}

if (empty($contactCards)) {
    $contactCards = [
        [
            'icon' => 'fa-map-marker-alt',
            'title' => 'Our Office',
            'content' => '7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius',
            'additional_info' => null,
            'action_text' => 'Get Directions',
            'action_link' => '#'
        ],
        [
            'icon' => 'fa-phone-alt',
            'title' => 'Contact Details',
            'content' => null,
            'additional_info' => 'Phone: 214-4607, Email: LawfirmPrecision@outlook.com',
            'action_text' => null,
            'action_link' => null
        ],
        [
            'icon' => 'fa-headset',
            'title' => 'Quick Support',
            'content' => 'Need immediate assistance? Our support team is available during business hours to help with your inquiries.',
            'additional_info' => null,
            'action_text' => 'Live Chat Support',
            'action_link' => '#'
        ]
    ];
}

if (empty($officeHours)) {
    $officeHours = [
        ['day_range' => 'Mon-Fri', 'hours' => '9AM-5PM'],
        ['day_range' => 'Sat', 'hours' => '9AM-1PM']
    ];
}

if (empty($socialLinks)) {
    $socialLinks = [
        ['platform' => 'LinkedIn', 'icon' => 'fa-linkedin-in', 'url' => '#'],
        ['platform' => 'Twitter', 'icon' => 'fa-twitter', 'url' => '#'],
        ['platform' => 'Facebook', 'icon' => 'fa-facebook-f', 'url' => '#']
    ];
}

if (empty($careerPositions)) {
    $careerPositions = [
        ['value' => 'associate-attorney', 'title' => 'Associate Attorney'],
        ['value' => 'attorney-clerk', 'title' => "Attorney's Clerk"],
        ['value' => 'legal-intern', 'title' => 'Legal Intern'],
        ['value' => 'other', 'title' => 'Other Position']
    ];
}

if (empty($chatResponses)) {
    $chatResponses = [
        ['keyword' => 'contact', 'response' => 'You can contact us at: Phone: 214-4607 | Email: LawfirmPrecision@outlook.com'],
        ['keyword' => 'phone', 'response' => 'Our phone number is: 214-4607'],
        ['keyword' => 'hour', 'response' => 'Our office hours are: Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM.'],
        ['keyword' => 'time', 'response' => 'Our office hours are: Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM.'],
        ['keyword' => 'career', 'response' => 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.'],
        ['keyword' => 'job', 'response' => 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.'],
        ['keyword' => 'apply', 'response' => 'You can apply for positions using the application form above. We have openings for Associate Attorney, Attorney\'s Clerk, and Legal Intern positions.'],
        ['keyword' => 'location', 'response' => 'We\'re located at: 7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius.'],
        ['keyword' => 'address', 'response' => 'We\'re located at: 7th floor, Astor Court (Block B), Georges Guibert Street, Port Louis, Mauritius.']
    ];
}

// Build hours string for display
$hoursString = '';
foreach ($officeHours as $index => $hour) {
    if ($index > 0) $hoursString .= '<br>';
    $hoursString .= htmlspecialchars($hour['day_range']) . ': ' . htmlspecialchars($hour['hours']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Careers - Precision Law Firm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Title Badge - Version sans retour à la ligne */
        .chatbox-title-badge {
            position: absolute;
            bottom: 85px;
            right: 20px;
            background: white;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(28, 77, 141, 0.15);
            padding: 10px 20px 10px 15px;
            display: inline-flex;
            /* Changé de flex à inline-flex */
            align-items: center;
            gap: 10px;
            animation: slideInLeft 0.5s ease;
            border: 1px solid rgba(28, 77, 141, 0.1);
            z-index: 999;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
            /* Empêche le retour à la ligne */
        }

        .title-content {
            display: inline-flex;
            /* Changé de flex à inline-flex */
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            /* Empêche le retour à la ligne */
        }

        .title-content i {
            font-size: 18px;
            color: #1C4D8D;
            background: rgba(28, 77, 141, 0.1);
            padding: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            /* Empêche l'icône de rétrécir */
        }

        .title-content span {
            font-size: 16px;
            font-weight: 600;
            color: #1C4D8D;
            white-space: nowrap;
            /* Empêche le retour à la ligne */
            overflow: hidden;
            text-overflow: ellipsis;

        }

        .title-arrow {
            width: 24px;
            height: 24px;
            background: #F8FAFC;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #1C4D8D;
            flex-shrink: 0;
            animation: bounceArrow 2s infinite;
        }


        .chatbox-title-badge.premium {
            background: linear-gradient(135deg, #1C4D8D, #2A6BBF);
            border: none;
            box-shadow: 0 10px 25px rgba(28, 77, 141, 0.3);
        }

        .chatbox-title-badge.premium .title-content i {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .chatbox-title-badge.premium .title-content span {
            color: white;
        }

        .chatbox-title-badge.premium .title-arrow {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Chatbox Container */
        .chatbox-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            font-family: 'Inter', sans-serif;
        }

        /* Toggle Button */
        .chatbox-toggle {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #1C4D8D 0%, #2A6BBF 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(28, 77, 141, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .chatbox-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 30px rgba(28, 77, 141, 0.4);
        }

        .chatbox-toggle i {
            color: white;
            font-size: 28px;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #EF4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Chat Window */
        .chatbox-window {
            position: absolute;
            bottom: 85px;
            right: 0;
            width: 380px;
            height: 600px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chatbox-window.active {
            display: flex;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .chatbox-header {
            background: linear-gradient(135deg, #1C4D8D 0%, #2A6BBF 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title i {
            font-size: 28px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 12px;
        }

        .header-title h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .online-status {
            font-size: 12px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .online-status::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #10B981;
            border-radius: 50%;
            margin-right: 5px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .close-chat {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-chat:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        /* Body */
        .chatbox-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #F8FAFC;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Messages */
        .message {
            display: flex;
            gap: 10px;
            max-width: 85%;
            animation: fadeIn 0.3s ease;
        }

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

        .message.user {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .message.bot .message-avatar {
            background: linear-gradient(135deg, #1C4D8D 20%, #2A6BBF 100%);
            color: white;
        }

        .message.user .message-avatar {
            background: #E2E8F0;
            color: #1C4D8D;
        }

        .message-wrapper {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .message.bot .message-content {
            background: white;
            border: 1px solid #E2E8F0;
            border-top-left-radius: 4px;
            color: #1E293B;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #1C4D8D 0%, #2A6BBF 100%);
            color: white;
            border-top-right-radius: 4px;
        }

        .message-time {
            font-size: 11px;
            color: #94A3B8;
            margin-left: 5px;
        }

        .message.user .message-time {
            text-align: right;
        }

        /* Quick Questions */
        .quick-questions {
            margin-top: 15px;
            padding: 15px;
            background: white;
            border-radius: 15px;
            border: 1px solid #E2E8F0;
        }

        .quick-questions-title {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .questions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .question-btn {
            padding: 10px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 12px;
            color: #1C4D8D;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            font-weight: 500;
            width: 100%;
        }

        .question-btn:hover {
            background: #1C4D8D;
            color: white;
            border-color: #1C4D8D;
            transform: translateY(-2px);
        }

        .question-btn i {
            font-size: 14px;
        }

        /* Footer - CORRIGÉ */
        .chatbox-footer {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #E2E8F0;
            flex-shrink: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .typing-indicator {
            display: none;
            margin-bottom: 10px;
            height: 20px;
        }

        .typing-indicator.active {
            display: flex;
            gap: 4px;
            justify-content: center;
            align-items: center;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: #94A3B8;
            border-radius: 50%;
            animation: typing 1s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }
        }

        /* Message Input - CORRIGÉ */
        .message-input {
            display: flex;
            gap: 10px;
            background: #F8FAFC;
            border-radius: 25px;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .message-input input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 12px 15px;
            font-size: 14px;
            outline: none;
            min-width: 0;
            /* Important pour que le flex fonctionne correctement */
            width: 100%;
        }

        .message-input input:focus {
            outline: none;
        }

        .message-input input::placeholder {
            color: #94A3B8;
            font-size: 14px;
        }

        .send-btn {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1C4D8D 0%, #2A6BBF 100%);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
            /* Empêche le bouton de rétrécir */
        }

        .send-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(28, 77, 141, 0.4);
        }

        .footer-note {
            text-align: center;
            margin-top: 8px;
            font-size: 11px;
            color: #94A3B8;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .chatbox-container {
                bottom: 15px;
                right: 15px;
            }

            .chatbox-window {
                width: calc(100vw - 30px);
                height: 80vh;
                bottom: 75px;
                right: 0;
            }

            .questions-grid {
                grid-template-columns: 1fr;
            }

            .message {
                max-width: 90%;
            }

            .message-input input {
                padding: 10px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 380px) {
            .chatbox-window {
                width: calc(100vw - 20px);
                height: 85vh;
            }
        }
    </style>
</head>

<body class="bg-white">

    <!-- Navbar -->
    <?php include "../includes/navbar.php"; ?>

    <!-- Header Section - Larger text -->
    <div class="pt-24 pb-16 text-center" data-aos="fade-up-slow">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">
                <span class="text-[#0F2854]"><?= htmlspecialchars($hero['title_line1']) ?></span>
                <span class="text-[#1C4D8D]"><?= htmlspecialchars($hero['title_line2']) ?></span>
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?= htmlspecialchars($hero['description']) ?>
            </p>
        </div>
    </div>

    <!-- Contact Information Section - 2 columns responsive -->
    <section class="py-16 md:py-20 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <!-- Grille : 1 colonne sur mobile, 2 colonnes à partir de md -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <?php foreach ($contactCards as $index => $card): ?>
                        <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300" data-aos="zoom-slow" data-aos-delay="<?= ($index + 1) * 100 ?>">
                            <div class="w-12 h-12 sm:w-14 md:w-16 bg-blue-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                                <i class="fas <?= htmlspecialchars($card['icon']) ?> text-xl sm:text-2xl md:text-2xl text-[#1C4D8D]"></i>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2 sm:mb-4"><?= htmlspecialchars($card['title']) ?></h3>

                            <?php if (!empty($card['content'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg mb-3 sm:mb-4">
                                    <?= nl2br(htmlspecialchars($card['content'])) ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($card['additional_info'])): ?>
                                <div class="space-y-2 sm:space-y-3 text-gray-600 text-sm sm:text-lg">
                                    <?php
                                    $infoLines = explode(',', $card['additional_info']);
                                    foreach ($infoLines as $line):
                                    ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-[#1C4D8D] mr-2 sm:mr-3"></i>
                                            <span><?= htmlspecialchars(trim($line)) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($card['action_text'])): ?>
                                <div class="mt-4 sm:mt-6 max-width-fit">
                                    <a href="<?= htmlspecialchars($card['action_link']) ?>" class="text-[#1C4D8D] font-medium hover:underline flex items-center text-sm sm:text-lg">
                                        <i class="fas fa-directions mr-2"></i>
                                        <?= htmlspecialchars($card['action_text']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Social Links -->
                <?php
                $activeSocialLinks = array_filter($socialLinks, function ($link) {
                    return !empty($link['is_active']);
                });
                ?>

                <?php if (!empty($activeSocialLinks)): ?>
                    <div class="mt-8 sm:mt-12 text-center">
                        <p class="text-gray-600 text-base sm:text-lg mb-3 sm:mb-4">
                            Connect with us on social media
                        </p>

                        <div class="flex justify-center flex-wrap gap-3 sm:gap-4">
                            <?php foreach ($activeSocialLinks as $link): ?>

                                <?php
                                $url = trim($link['url']);

                                // Force https si oublié
                                if (!preg_match("~^https?://~", $url)) {
                                    $url = "https://" . $url;
                                }
                                ?>

                                <a href="<?= htmlspecialchars($url) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 rounded-full flex items-center justify-center hover:bg-[#1C4D8D] hover:text-white transition-all duration-300 text-[#1C4D8D] transform hover:-translate-y-1">

                                    <i class="fab <?= htmlspecialchars($link['icon']) ?> text-base sm:text-xl"></i>

                                </a>

                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Apply Now Section (Careers) - Larger text -->
    <section id="apply-now" class="py-24 bg-gradient-to-b from-white to-blue-50">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-4xl mx-auto">
                <!-- Section title -->
                <div class="text-center mb-16" data-aos="fade-up-slow">
                    <h2 class="text-5xl md:text-6xl font-bold mb-4">
                        <span class="text-[#0F2854]">Join Our</span>
                        <span class="text-[#1C4D8D]">Team</span>
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] mx-auto mb-6"></div>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Ready to join Our Partner? Submit your application and we'll get back to you shortly.
                    </p>
                </div>

                <!-- Application Form -->
                <div class="bg-white rounded-2xl shadow-lg p-10 md:p-16" data-aos="zoom-slow">
                    <form id="career-form" class="space-y-6" method="POST" action="process-career.php" enctype="multipart/form-data">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 text-lg" for="full-name">
                                    Full Name *
                                </label>
                                <input type="text" id="full-name" name="full_name" required
                                    class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-100 outline-none transition duration-300 text-base"
                                    placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 text-lg" for="email">
                                    Email Address *
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-100 outline-none transition duration-300 text-base"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 text-lg" for="phone">
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-100 outline-none transition duration-300 text-base"
                                    placeholder="+230 123 4567">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 text-lg" for="position">
                                    Position *
                                </label>
                                <select id="position" name="position" required
                                    class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-100 outline-none transition duration-300 modern-select text-base">
                                    <option value="">Select a position</option>
                                    <?php foreach ($careerPositions as $position): ?>
                                        <option value="<?= htmlspecialchars($position['value']) ?>"><?= htmlspecialchars($position['title']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-lg" for="cover-letter">
                                Cover Letter *
                            </label>
                            <textarea id="cover-letter" name="cover_letter" rows="5" required
                                class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:border-[#1C4D8D] focus:ring-2 focus:ring-blue-100 outline-none transition duration-300 resize-none text-base"
                                placeholder="Tell us about yourself and why you're interested in joining Our Partner..."></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-lg" for="resume">
                                Upload Resume/CV *
                            </label>
                            <div class="file-upload-area" onclick="document.getElementById('resume-file').click()">
                                <div class="mb-4">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-[#1C4D8D] mb-3"></i>
                                    <p class="text-gray-600 text-lg">Drag & drop your file here or click to browse</p>
                                </div>
                                <input type="file" id="resume-file" name="resume" class="hidden" accept=".pdf,.doc,.docx" required>
                                <span
                                    class="bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition duration-300 inline-flex items-center gap-2 cursor-pointer text-base">
                                    <i class="fas fa-folder-open"></i>
                                    Browse Files
                                </span>
                                <p class="text-sm text-gray-500 mt-4">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    Supports: PDF, DOC, DOCX (Max 5MB)
                                </p>
                            </div>
                            <div id="file-name" class="mt-2 text-sm text-green-600 hidden">
                                <i class="fas fa-check-circle mr-1"></i> Selected: <span></span>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-[#1C4D8D] to-[#0F2854] text-white py-5 rounded-xl font-medium text-xl hover:opacity-90 transition duration-300 btn-primary">
                                Submit Application
                            </button>
                        </div>
                    </form>

                    <!-- Form Success Message -->
                    <?php if (!empty($_SESSION['career_success'])): ?>
                        <div class="mt-8 p-6 bg-green-50 border border-green-200 rounded-2xl text-green-800 text-lg flex items-center gap-3 animate-fade-in" id="form-success">
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            <?= htmlspecialchars($_SESSION['career_success']) ?>
                        </div>
                    <?php unset($_SESSION['career_success']);
                    endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbox -->
    <div class="chatbox-container">

        <!-- Title Badge -->
        <div class="chatbox-title-badge">
            <div class="title-content">
                <i class="fas fa-scale-balanced"></i>
                <span>Law Bot</span>
            </div>
            <div class="title-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>

        <div class="chatbox-toggle" id="chatbox-toggle">
            <i class="fas fa-comments"></i>
            <div class="notification-badge">3</div>
        </div>

        <div class="chatbox-window" id="chatbox-window">
            <div class="chatbox-header">
                <div class="header-title">
                    <i class="fas fa-scale-balanced"></i>
                    <div>
                        <h3>Legal Assistant</h3>
                        <span class="online-status">● Online</span>
                    </div>
                </div>
                <button class="close-chat" id="close-chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="chatbox-body" id="chatbox-body">
                <div class="message bot">
                    <div class="message-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-wrapper">
                        <div class="message-content">
                            👋 Hello! I'm your legal assistant. How can I help you today?
                        </div>
                        <div class="message-time">Just now</div>
                    </div>
                </div>

                <!-- Quick Questions -->
                <div class="quick-questions" id="quickQuestions">
                    <p class="quick-questions-title">📋 Suggested questions:</p>
                    <div class="questions-grid">
                        <button class="question-btn" data-question="appointment">
                            <i class="fas fa-calendar-check"></i>
                            Book appointment
                        </button>
                        <button class="question-btn" data-question="hours">
                            <i class="fas fa-clock"></i>
                            Office hours
                        </button>
                        <button class="question-btn" data-question="phone">
                            <i class="fas fa-phone"></i>
                            Phone number
                        </button>
                        <button class="question-btn" data-question="email">
                            <i class="fas fa-envelope"></i>
                            Email us
                        </button>
                        <button class="question-btn" data-question="location">
                            <i class="fas fa-location-dot"></i>
                            Our location
                        </button>
                        <button class="question-btn" data-question="career">
                            <i class="fas fa-briefcase"></i>
                            Careers
                        </button>
                    </div>
                </div>
            </div>

            <div class="chatbox-footer">
                <div class="typing-indicator" id="typingIndicator">
                    <span></span><span></span><span></span>
                </div>
                <div class="message-input">
                    <input type="text" id="chat-input" placeholder="Type your message here..." autocomplete="off">
                    <button class="send-btn" id="send-message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="footer-note">
                    <i class="fas fa-shield-alt"></i> Secure & confidential
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "../includes/footer.php" ?>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/chatbox.js"></script>


</body>

</html>