<!-- Navbar - 100% responsive -->

<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4" data-aos="fade-down-slow"
        data-aos-duration="1200" data-aos-easing="ease-out-cubic">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
            <div class="flex justify-between items-center">

                <!-- LOGO - carrément collé à gauche -->
                <div class="text-[#D4AF37] font-bold 
            text-lg sm:text-xl md:text-2xl lg:text-2xl xl:text-3xl 2xl:text-3xl
            tracking-tight whitespace-nowrap -ml-4 sm:-ml-6">
                    Precision Law Firm
                </div>


                <!-- MENU DESKTOP GRAND ÉCRAN (> 1536px) -->
                <div class="hidden 2xl:flex items-center space-x-8 mx-4">
                    <div class="flex items-center space-x-8">
                        <a href="accueil.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Home</a>
                        <a href="pages/overview.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Overview</a>
                        <a href="pages/team.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Our Team</a>
                        <a href="pages/expertise.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Expertise</a>
                        <a href="pages/jurisprudence.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Jurisprudence</a>
                        <a href="pages/courses.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Courses</a>
                        <a href="pages/appointment.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-base whitespace-nowrap">Appointment</a>
                    </div>
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-6 py-3 rounded-full font-medium hover:opacity-90 transition duration-300 text-base whitespace-nowrap shadow-sm hover:shadow-md">Contact Us</a>
                </div>

                <!-- MENU DESKTOP MOYEN (1280px - 1536px) -->
                <div class="hidden xl:flex 2xl:hidden items-center space-x-6">
                    <div class="flex items-center space-x-6">
                        <a href="accueil.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Home</a>
                        <a href="pages/overview.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Overview</a>
                        <a href="pages/team.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Team</a>
                        <a href="pages/expertise.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Expertise</a>
                        <a href="pages/jurisprudence.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Jurisprudence</a>
                        <a href="pages/courses.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Courses</a>
                        <a href="pages/appointment.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Appointment</a>
                    </div>
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-5 py-2.5 rounded-full font-medium text-sm hover:opacity-90 transition duration-300 whitespace-nowrap shadow-sm">Contact</a>
                </div>

                <!-- MENU TABLETTE LARGE (1024px - 1280px) -->
                <div class="hidden lg:flex xl:hidden items-center space-x-4">
                    <div class="flex items-center space-x-4">
                        <a href="accueil.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Home</a>
                        <a href="pages/overview.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Overview</a>
                        <a href="pages/team.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Team</a>
                        <a href="pages/expertise.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Expertise</a>
                        <a href="pages/jurisprudence.php" class="nav-link text-gray-700 font-medium hover:text-[#D4AF37] transition duration-300 text-sm whitespace-nowrap">Jurisprudence</a>
                    </div>
                    <button id="tablet-wide-menu-button" class="menu-toggle text-gray-700 text-xl" data-panel="tablet-wide-menu">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-4 py-2 rounded-full font-medium text-sm hover:opacity-90 transition duration-300 whitespace-nowrap">Contact</a>
                </div>

                <!-- MENU TABLETTE (768px - 1024px) -->
                <div class="hidden md:flex lg:hidden items-center space-x-3">
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-4 py-2 rounded-full font-medium text-sm hover:opacity-90 transition duration-300 whitespace-nowrap">Contact</a>
                    <button id="tablet-menu-button" class="menu-toggle text-gray-700 text-2xl" data-panel="tablet-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- MENU MOBILE LARGE (640px - 768px) -->
                <div class="hidden sm:flex md:hidden items-center space-x-2">
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-3 py-1.5 rounded-full font-medium text-xs hover:opacity-90 transition duration-300 whitespace-nowrap">Contact</a>
                    <button id="mobile-large-menu-button" class="menu-toggle text-gray-700 text-2xl" data-panel="mobile-large-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- MENU MOBILE PETIT (< 640px) -->
                <div class="flex sm:hidden items-center space-x-2">
                    <a href="pages/contact.php" class="bg-[#0A1F44] text-white px-2 py-1 rounded-full font-medium text-xs hover:opacity-90 transition duration-300 whitespace-nowrap">Contact</a>
                    <button id="mobile-small-menu-button" class="menu-toggle text-gray-700 text-2xl" data-panel="mobile-small-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- PANELS DE MENU -->

            <!-- Panel tablette large -->
            <div id="tablet-wide-menu" class="menu-panel hidden lg:block xl:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
                <div class="py-4 border-t border-gray-100 mt-3">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="pages/courses.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center text-sm bg-gray-50 rounded-lg">Courses</a>
                        <a href="pages/appointment.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center text-sm bg-gray-50 rounded-lg col-span-2">Appointment</a>
                    </div>
                </div>
            </div>

            <!-- Panel tablette -->
            <div id="tablet-menu" class="menu-panel hidden md:block lg:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
                <div class="py-4 border-t border-gray-100 mt-3">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="accueil.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Home</a>
                        <a href="pages/overview.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Overview</a>
                        <a href="pages/team.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Our Team</a>
                        <a href="pages/expertise.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Expertise</a>
                        <a href="pages/jurisprudence.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Jurisprudence</a>
                        <a href="pages/courses.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg">Courses</a>
                        <a href="pages/appointment.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-3 px-3 text-center bg-gray-50 rounded-lg col-span-2">Appointment</a>
                    </div>
                </div>
            </div>

            <!-- Panel mobile large -->
            <div id="mobile-large-menu" class="menu-panel hidden sm:block md:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
                <div class="py-4 border-t border-gray-100 mt-3">
                    <div class="flex flex-col space-y-3">
                        <a href="accueil.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Home</a>
                        <a href="pages/overview.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Overview</a>
                        <a href="pages/team.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Our Team</a>
                        <a href="pages/expertise.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Expertise</a>
                        <a href="pages/jurisprudence.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Jurisprudence</a>
                        <a href="pages/courses.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Courses</a>
                        <a href="pages/appointment.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-base">Appointment</a>
                    </div>
                </div>
            </div>

            <!-- Panel mobile petit -->
            <div id="mobile-small-menu" class="menu-panel block sm:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 opacity-0">
                <div class="py-4 border-t border-gray-100 mt-3">
                    <div class="flex flex-col space-y-3">
                        <a href="accueil.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Home</a>
                        <a href="pages/overview.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Overview</a>
                        <a href="pages/team.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Our Team</a>
                        <a href="pages/expertise.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Expertise</a>
                        <a href="pages/jurisprudence.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Jurisprudence</a>
                        <a href="pages/courses.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Courses</a>
                        <a href="pages/appointment.php" class="menu-link text-gray-700 font-medium hover:text-[#D4AF37] transition py-2 px-2 text-sm">Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>



<script>

    /**
         * Navbar - Gestionnaire de menus 100% responsive
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration des menus avec leurs boutons et panels
            const menuConfigs = [{
                    buttonId: 'tablet-wide-menu-button',
                    panelId: 'tablet-wide-menu'
                },
                {
                    buttonId: 'tablet-menu-button',
                    panelId: 'tablet-menu'
                },
                {
                    buttonId: 'mobile-large-menu-button',
                    panelId: 'mobile-large-menu'
                },
                {
                    buttonId: 'mobile-small-menu-button',
                    panelId: 'mobile-small-menu'
                }
            ];

            // État des menus
            let openMenuPanel = null;

            // Fonction pour fermer tous les menus
            function closeAllMenus() {
                document.querySelectorAll('.menu-panel').forEach(panel => {
                    panel.classList.remove('max-h-96', 'opacity-100');
                    panel.classList.add('max-h-0', 'opacity-0');
                });
                openMenuPanel = null;
            }

            // Fonction pour ouvrir un menu spécifique
            function openMenu(panelId) {
                const panel = document.getElementById(panelId);
                if (!panel) return;

                closeAllMenus();

                panel.classList.remove('max-h-0', 'opacity-0');
                panel.classList.add('max-h-96', 'opacity-100');
                openMenuPanel = panelId;
            }

            // Fonction pour basculer un menu
            function toggleMenu(button, panelId) {
                return function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (openMenuPanel === panelId) {
                        closeAllMenus();
                    } else {
                        openMenu(panelId);
                    }
                };
            }

            // Initialiser chaque menu
            menuConfigs.forEach(config => {
                const button = document.getElementById(config.buttonId);
                const panel = document.getElementById(config.panelId);

                if (button && panel) {
                    button.addEventListener('click', toggleMenu(button, config.panelId));

                    panel.querySelectorAll('.menu-link').forEach(link => {
                        link.addEventListener('click', function() {
                            closeAllMenus();
                        });
                    });
                }
            });

            // Fermer les menus quand on clique en dehors
            document.addEventListener('click', function(event) {
                const isClickInsideButton = Array.from(document.querySelectorAll('.menu-toggle')).some(
                    button => button.contains(event.target)
                );
                const isClickInsidePanel = Array.from(document.querySelectorAll('.menu-panel')).some(
                    panel => panel.contains(event.target) && !panel.classList.contains('max-h-0')
                );

                if (!isClickInsideButton && !isClickInsidePanel && openMenuPanel) {
                    closeAllMenus();
                }
            });

            // Fermer les menus au redimensionnement
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if (openMenuPanel) {
                        closeAllMenus();
                    }
                }, 200);
            });

            // Fermer les menus avec la touche Echap
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && openMenuPanel) {
                    closeAllMenus();
                }
            });
        });
</script>