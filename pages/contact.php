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

        /* Animation lente et douce */
        .aos-init[data-aos] {
            transition-duration: 1500ms !important;
            transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        }

        /* Custom animations */
        [data-aos="fade-up-slow"] {
            transform: translateY(40px);
            opacity: 0;
            transition-property: transform, opacity;
        }

        [data-aos="fade-up-slow"].aos-animate {
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

        /* Chatbox styles */
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
            transition: all 0.3s ease;
            border: 3px solid white;
        }

        .chatbox-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(28, 77, 141, 0.4);
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
            border: 1px solid #e5e7eb;
        }

        .chatbox-window.active {
            display: block;
            animation: slideInUp 0.4s ease-out;
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

        .message.bot .message-content {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 12px 16px;
            font-size: 14px;
            line-height: 1.5;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #1C4D8D 0%, #0F2854 100%);
            color: white;
            border-radius: 18px;
            padding: 12px 16px;
            font-size: 14px;
            line-height: 1.5;
            margin-left: auto;
        }

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

        /* Form styles */
        .modern-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%231C4D8D' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
        }

        .file-upload-area {
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #1C4D8D;
            background: #f8fafc;
        }

        /* Hover lift effect */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4" data-aos="fade-down-slow"
        data-aos-duration="1200" data-aos-easing="ease-out-cubic">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="flex justify-between items-center">

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 w-full justify-between">

                    <!-- Logo -->
                    <div class="text-[#D4AF37] font-bold text-2xl tracking-tight">
                        Precision Law Firm
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
                            class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base tracking-wide">
                            Appointment
                        </a>
                    </div>

                    <!-- Contact Button - active state -->
                    <a href="contact.php"
                        class="bg-[#0A1F44] text-white px-6 py-3 rounded-full font-medium
                     hover:opacity-90 transition duration-300 hover-lift text-base tracking-wide shadow-sm hover:shadow-md">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden flex items-center justify-between w-full">
                    <div class="text-[#D4AF37] font-bold text-xl">
                        Precision Law Firm
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
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base py-2">
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

    <!-- Contact Information Section - Larger text -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($contactCards as $index => $card): ?>
                    <div class="bg-white rounded-xl p-10 shadow-sm hover-lift transition-all duration-300" data-aos="zoom-slow" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas <?= htmlspecialchars($card['icon']) ?> text-2xl text-[#1C4D8D]"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($card['title']) ?></h3>
                        
                        <?php if (!empty($card['content'])): ?>
                        <p class="text-gray-600 text-lg mb-4">
                            <?= nl2br(htmlspecialchars($card['content'])) ?>
                        </p>
                        <?php endif; ?>
                        
                        <?php if (!empty($card['additional_info'])): ?>
                        <div class="space-y-3 text-gray-600 text-lg">
                            <?php 
                            $infoLines = explode(',', $card['additional_info']);
                            foreach ($infoLines as $line): 
                            ?>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-[#1C4D8D] mr-3"></i>
                                <span><?= htmlspecialchars(trim($line)) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($card['action_text'])): ?>
                        <div class="mt-6">
                            <a href="<?= htmlspecialchars($card['action_link']) ?>" class="text-[#1C4D8D] font-medium hover:underline flex items-center text-lg">
                                <i class="fas fa-directions mr-2"></i>
                                <?= htmlspecialchars($card['action_text']) ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Social Links -->
                <?php if (!empty($socialLinks)): ?>
                <div class="mt-12 text-center">
                    <p class="text-gray-600 text-lg mb-4">Connect with us on social media</p>
                    <div class="flex justify-center space-x-4">
                        <?php foreach ($socialLinks as $link): ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>" 
                           class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center hover:bg-[#1C4D8D] hover:text-white transition-all duration-300 text-[#1C4D8D] hover-lift">
                            <i class="fab <?= htmlspecialchars($link['icon']) ?> text-xl"></i>
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
                        Ready to join our team? Submit your application and we'll get back to you shortly.
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
                                placeholder="Tell us about yourself and why you're interested in joining our team..."></textarea>
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
                    <div id="form-success" class="hidden mt-8 p-8 bg-green-50 border border-green-200 rounded-2xl animate-fade-in">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-check text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-2xl font-bold text-green-800 mb-1">Application Submitted Successfully!</h4>
                                <p class="text-green-700 text-lg">Thank you for your interest in joining our team. We'll review your application and get back to you within 5-7 business days.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbox -->
    <div class="chatbox-container">
        <div class="mb-2 text-right mr-4">
            <span class="bg-[#1C4D8D] text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md">
                Live Support
            </span>
        </div>
        <div class="chatbox-toggle" id="chatbox-toggle">
            <i class="fas fa-comments"></i>
            <div class="notification-badge">1</div>
        </div>
        <div class="chatbox-window" id="chatbox-window">
            <div class="chatbox-header">
                <h3><i class="fas fa-robot mr-2"></i> Legal Assistant Bot</h3>
                <button class="close-chat" id="close-chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chatbox-body" id="chatbox-body">
                <div class="message bot">
                    <div class="message-content">
                        Hello! I'm your legal assistant. How can I help you today? You can ask about:
                        <br><br>
                        • Contact information<br>
                        • Office hours<br>
                        • Career opportunities<br>
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

    <!-- Footer -->
    <footer class="bg-[#0F2854] text-white py-16 mt-20">
        <div class="container mx-auto px-6 md:px-12 lg:px-24">
            <div class="grid md:grid-cols-4 gap-10">
                <!-- Logo and description -->
                <div class="md:col-span-2">
                    <div class="text-3xl font-bold mb-4">
                        <span class="text-white">Precision</span>
                        <span class="text-blue-300">Law Firm</span>
                    </div>
                    <p class="text-gray-300 text-base mb-6 max-w-md">
                        A forward-thinking legal practice combining commercial insight with legal excellence.
                    </p>
                    <div class="flex space-x-4">
                        <?php foreach ($socialLinks as $link): ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>"
                            class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab <?= htmlspecialchars($link['icon']) ?> text-lg"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="../accueil.php" class="text-gray-300 hover:text-white transition text-base">Home</a></li>
                        <li><a href="overview.php" class="text-gray-300 hover:text-white transition text-base">Overview</a></li>
                        <li><a href="team.php" class="text-gray-300 hover:text-white transition text-base">Our Team</a></li>
                        <li><a href="expertise.php" class="text-gray-300 hover:text-white transition text-base">Expertise</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start text-base">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-300"></i>
                            <span>7th floor, Astor Court<br>Georges Guibert Street, Port Louis</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-phone mr-3 text-blue-300"></i>
                            <span>214-4607</span>
                        </li>
                        <li class="flex items-center text-base">
                            <i class="fas fa-envelope mr-3 text-blue-300"></i>
                            <span>LawfirmPrecision@outlook.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-800 mt-10 pt-8 text-center text-gray-400">
                <p class="text-base">© 2024 Precision Law Firm. All rights reserved.</p>
                <p class="mt-2 text-base">Strategic legal attorneys with commercial foresight</p>
            </div>
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
            once: true,
            delay: 0,
            mirror: false,
            anchorPlacement: 'top-bottom'
        });

        // Chatbox functionality
        const chatboxToggle = document.getElementById('chatbox-toggle');
        const chatboxWindow = document.getElementById('chatbox-window');
        const closeChat = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const sendMessageBtn = document.getElementById('send-message');
        const chatboxBody = document.getElementById('chatbox-body');

        // Chat responses from PHP
        const chatResponses = <?= json_encode($chatResponses) ?>;

        function openChatbox() {
            chatboxWindow.classList.add('active');
            const badge = document.querySelector('.notification-badge');
            if (badge) badge.style.display = 'none';
        }

        if (chatboxToggle) {
            chatboxToggle.addEventListener('click', openChatbox);
        }

        if (closeChat) {
            closeChat.addEventListener('click', () => {
                chatboxWindow.classList.remove('active');
            });
        }

        if (sendMessageBtn) {
            sendMessageBtn.addEventListener('click', sendMessage);
        }

        if (chatInput) {
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage();
            });
        }

        function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, 'user');
            chatInput.value = '';

            // Simulate bot response
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
            
            // Check each keyword in chatResponses
            for (const response of chatResponses) {
                if (lowerMessage.includes(response.keyword)) {
                    return response.response;
                }
            }
            
            // Default response
            return "Thank you for your message. For specific inquiries, please contact us directly via phone or email. How else can I assist you?";
        }

        // Career form submission
        const careerForm = document.getElementById('career-form');
        if (careerForm) {
            careerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate file
                const resumeFile = document.getElementById('resume-file').files[0];
                if (!resumeFile) {
                    alert('Please upload your resume/CV');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
                submitBtn.disabled = true;

                // Simulate AJAX submission
                setTimeout(() => {
                    // Show success message
                    const successMsg = document.getElementById('form-success');
                    successMsg.classList.remove('hidden');
                    
                    // Reset form
                    this.reset();
                    document.getElementById('file-name').classList.add('hidden');
                    
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Scroll to success message
                    successMsg.scrollIntoView({ behavior: 'smooth' });

                    // Hide success message after 8 seconds
                    setTimeout(() => {
                        successMsg.classList.add('hidden');
                    }, 8000);
                }, 2000);
            });
        }

        // File upload preview
        const resumeFile = document.getElementById('resume-file');
        if (resumeFile) {
            resumeFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(1);
                    if (fileSizeMB > 5) {
                        alert('File size must be less than 5MB');
                        this.value = '';
                        document.getElementById('file-name').classList.add('hidden');
                    } else {
                        const fileNameDiv = document.getElementById('file-name');
                        fileNameDiv.querySelector('span').textContent = file.name;
                        fileNameDiv.classList.remove('hidden');
                    }
                }
            });
        }

        // Toggle mobile menu
        const mobileButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileButton && mobileMenu) {
            mobileButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');

                // Change burger icon
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
</body>

</html>