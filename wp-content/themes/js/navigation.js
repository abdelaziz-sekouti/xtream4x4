/**
 * Navigation functionality
 */
(function($) {
    'use strict';
    
    // Mobile menu toggle
    function initMobileMenu() {
        const mobileMenuBtn = $('.mobile-menu-toggle');
        const navMenu = $('.nav-menu');
        
        if (mobileMenuBtn.length) {
            mobileMenuBtn.on('click', function(e) {
                e.preventDefault();
                navMenu.slideToggle();
                $(this).toggleClass('active');
            });
        }
    }
    
    // Dropdown menu functionality
    function initDropdownMenus() {
        const dropdowns = $('.menu-item-has-children');
        
        dropdowns.each(function() {
            const $this = $(this);
            const dropdownToggle = $this.find('> a').first();
            const subMenu = $this.find('> .sub-menu').first();
            
            dropdownToggle.on('click', function(e) {
                e.preventDefault();
                
                // Close other dropdowns
                dropdowns.not($this).find('> .sub-menu').slideUp();
                dropdowns.not($this).find('> a').removeClass('active');
                
                // Toggle current dropdown
                subMenu.slideToggle();
                dropdownToggle.toggleClass('active');
            });
        });
    }
    
    // Sticky header
    function initStickyHeader() {
        const header = $('.site-header');
        const headerHeight = header.outerHeight();
        let lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > 100) {
                header.addClass('sticky');
                $('.site-content').css('margin-top', headerHeight);
            } else {
                header.removeClass('sticky');
                $('.site-content').css('margin-top', '0');
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    // Smooth scroll for anchor links
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });
    }
    
    // Initialize all functions when DOM is ready
    $(document).ready(function() {
        initMobileMenu();
        initDropdownMenus();
        initStickyHeader();
        initSmoothScroll();
    });
    
    // Initialize when Elementor widgets are loaded
    $(window).on('elementor/frontend/init', function() {
        // Add any Elementor-specific functionality here
    });
    
})(jQuery);