<!-- Navbar - EXACT copy from client site with admin badge added -->
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-2 sm:py-4" data-aos="fade-down-slow"
    data-aos-duration="1200" data-aos-easing="ease-out-cubic">
    <div class="container mx-auto px-4 sm:px-6 md:px-12 lg:px-24">
        <div class="flex justify-between items-center">

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4 lg:space-x-8 w-full justify-between">

                <!-- Logo with Admin Badge -->
                <div class="flex items-center flex-shrink-0">
                    <div class="text-[#D4AF37] font-bold text-lg lg:text-2xl tracking-tight whitespace-nowrap">
                        Precision Law Firm
                    </div>
                    <span class="admin-badge ml-2 px-2 py-1 bg-[#D4AF37] text-white text-xs rounded-full font-semibold">Admin</span>
                </div>

                <!-- Navigation - EXACT same links with /plf/admin/ prefix -->
                <div class="flex items-center space-x-3 lg:space-x-6 xl:space-x-8 overflow-x-auto hide-scrollbar">
                    <a href="/plf/admin/accueil.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Home
                    </a>

                    <a href="/plf/admin/overview.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Overview
                    </a>

                    <a href="/plf/admin/team.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Our Team
                    </a>

                    <a href="/plf/admin/expertise.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Expertise
                    </a>

                    <a href="/plf/admin/jurisprudence.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Jurisprudence
                    </a>

                    <a href="/plf/admin/courses.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Courses
                    </a>

                    <a href="/plf/admin/appointment.php"
                        class="text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm lg:text-base tracking-wide whitespace-nowrap">
                        Appointment
                    </a>
                </div>

                <!-- Contact Button - points to admin contact page -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="/plf/admin/contact.php"
                        class="bg-[#0A1F44] text-white px-4 lg:px-6 py-2 lg:py-3 rounded-full font-medium
                     hover:opacity-90 transition duration-300 hover-lift text-sm lg:text-base tracking-wide shadow-sm hover:shadow-md whitespace-nowrap">
                        Contact Us
                    </a>
                    
                    <!-- Admin Logout (visible only in desktop) - CORRIGÉ -->
                    <a href="/plf/admin/logout.php"
                        class="bg-red-600 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-full font-medium
                     hover:bg-red-700 transition duration-300 text-sm lg:text-base tracking-wide shadow-sm hover:shadow-md whitespace-nowrap">
                        <i class="fas fa-sign-out-alt mr-1 lg:mr-2"></i>
                        <span class="hidden lg:inline">Logout</span>
                        <span class="lg:hidden">Exit</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Header -->
            <div class="md:hidden flex items-center justify-between w-full">
                <div class="flex items-center min-w-0">
                    <div class="text-[#D4AF37] font-bold text-base sm:text-xl truncate">
                        Precision Law Firm
                    </div>
                    <span class="admin-badge ml-2 px-2 py-0.5 bg-[#D4AF37] text-white text-xs rounded-full font-semibold flex-shrink-0">Admin</span>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Mobile logout button (quick access) - CORRIGÉ -->
                    <a href="/plf/admin/logout.php" 
                       class="text-red-600 text-xl p-2 hover:bg-red-50 rounded-full transition duration-300"
                       title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                    
                    <button id="mobile-menu-button" class="text-gray-700 text-2xl transition duration-300 hover:text-[#D4AF37]">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu - EXACT same links with /plf/admin/ prefix -->
        <div id="mobile-menu" class="hidden md:hidden py-4 border-t mt-3">
            <div class="flex flex-col space-y-2 max-h-[70vh] overflow-y-auto">
                <a href="/plf/admin/accueil.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-home w-6 text-[#D4AF37]"></i> Home
                </a>

                <a href="/plf/admin/overview.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-info-circle w-6 text-[#D4AF37]"></i> Overview
                </a>

                <a href="/plf/admin/team.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-users w-6 text-[#D4AF37]"></i> Our Team
                </a>

                <a href="/plf/admin/expertise.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-gavel w-6 text-[#D4AF37]"></i> Expertise
                </a>

                <a href="/plf/admin/jurisprudence.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-book w-6 text-[#D4AF37]"></i> Jurisprudence
                </a>

                <a href="/plf/admin/courses.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-graduation-cap w-6 text-[#D4AF37]"></i> Courses
                </a>

                <a href="/plf/admin/appointment.php"
                    class="text-gray-700 font-medium hover:text-[#D4AF37] hover:bg-gray-50 transition duration-300 text-base py-3 px-4 rounded-lg">
                    <i class="fas fa-calendar-check w-6 text-[#D4AF37]"></i> Appointment
                </a>

                <a href="/plf/admin/contact.php"
                    class="bg-[#0A1F44] text-white px-4 py-3 rounded-lg font-medium text-center transition duration-300 text-base hover:bg-[#0A1F44]/90 mt-2">
                    <i class="fas fa-envelope mr-2"></i> Contact Us
                </a>

                <!-- Admin Logout button (mobile) - CORRIGÉ -->
                <a href="/plf/admin/logout.php"
                    class="bg-red-600 text-white px-4 py-3 rounded-lg font-medium text-center mt-2 transition duration-300 text-base hover:bg-red-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout (Admin)
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Add this CSS for scrollbar hiding -->
<style>
.hide-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
.hide-scrollbar::-webkit-scrollbar {
    display: none;  /* Chrome, Safari, Opera */
}

/* Active link style */
.nav-active {
    color: #D4AF37 !important;
    position: relative;
}
.nav-active::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #D4AF37;
    border-radius: 2px;
}

/* Mobile menu animation */
#mobile-menu {
    transition: all 0.3s ease-in-out;
}
#mobile-menu.show {
    display: block;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .admin-badge {
        font-size: 10px;
        padding: 2px 6px;
    }
}
</style>

<script>
// Mobile menu toggle with animation
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const icon = mobileMenuButton.querySelector('i');

    mobileMenuButton.addEventListener('click', function() {
        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            mobileMenu.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Highlight active link based on current page
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('a[href*="' + currentPage + '"]');
    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
            link.classList.add('nav-active');
        }
    });

    // Close mobile menu on window resize if desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            mobileMenu.classList.add('hidden');
            const icon = mobileMenuButton.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    });
});

// Logout function with redirection
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '/plf/admin/logout.php';
    }
}
</script>