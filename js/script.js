 // Initialize AOS with slow settings
 AOS.init({
    duration: 1500,
    offset: 80,
    easing: 'ease-out-cubic',
    once: true,
    delay: 0,
    mirror: false,
    anchorPlacement: 'top-bottom',
    startEvent: 'DOMContentLoaded',
    disable: false,
    animatedClassName: 'aos-animate',
    initClassName: 'aos-init',
    disableMutationObserver: false,
    debounceDelay: 50,
    throttleDelay: 99
});

