/**
 * Navigation functionality for Xtreme theme
 */

(function($) {
    'use strict';
    
    // Mobile menu toggle
    function initMobileMenu() {
        const mobileMenuBtn = $('.menu-toggle');
        const navMenu = $('#primary-menu');
        
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
                if ($(window).width() < 768) {
                    e.preventDefault();
                    
                    // Close other dropdowns
                    dropdowns.not($this).find('> .sub-menu').slideUp();
                    dropdowns.not($this).find('> a').removeClass('active');
                    
                    // Toggle current dropdown
                    subMenu.slideToggle();
                    dropdownToggle.toggleClass('active');
                }
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
    
    // Contact form AJAX submission
    function initContactForm() {
        $('#shortcode-contact-form, .contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const messageDiv = form.find('.form-message');
            
            // Disable submit button
            submitButton.prop('disabled', true).text('Sending...');
            
            // Send AJAX request
            $.ajax({
                url: xtreme_ajax.ajax_url,
                type: 'POST',
                data: formData + '&action=xtreme_contact_form&nonce=' + xtreme_ajax.nonce,
                success: function(response) {
                    if (response.success) {
                        messageDiv.removeClass('error').addClass('success').text(response.data.message).show();
                        form[0].reset();
                    } else {
                        messageDiv.removeClass('success').addClass('error').text(response.data.message).show();
                    }
                },
                error: function() {
                    messageDiv.removeClass('success').addClass('error').text('An error occurred. Please try again.').show();
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Send Message');
                }
            });
        });
    }
    
    // Booking form AJAX submission
    function initBookingForm() {
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const messageDiv = form.find('.form-message');
            
            // Disable submit button
            submitButton.prop('disabled', true).text('Booking...');
            
            // Send AJAX request
            $.ajax({
                url: xtreme_ajax.ajax_url,
                type: 'POST',
                data: formData + '&action=xtreme_booking_form&nonce=' + xtreme_ajax.nonce,
                success: function(response) {
                    if (response.success) {
                        messageDiv.removeClass('error').addClass('success').text(response.data.message).show();
                        form[0].reset();
                    } else {
                        messageDiv.removeClass('success').addClass('error').text(response.data.message).show();
                    }
                },
                error: function() {
                    messageDiv.removeClass('success').addClass('error').text('An error occurred. Please try again.').show();
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Book Now');
                }
            });
        });
    }
    
    // Testimonial submission
    function initTestimonialForm() {
        $('#testimonial-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const messageDiv = form.find('.form-message');
            
            // Disable submit button
            submitButton.prop('disabled', true).text('Submitting...');
            
            // Send AJAX request
            $.ajax({
                url: xtreme_ajax.ajax_url,
                type: 'POST',
                data: formData + '&action=xtreme_testimonial_submission&nonce=' + xtreme_ajax.nonce,
                success: function(response) {
                    if (response.success) {
                        messageDiv.removeClass('error').addClass('success').text(response.data.message).show();
                        form[0].reset();
                    } else {
                        messageDiv.removeClass('success').addClass('error').text(response.data.message).show();
                    }
                },
                error: function() {
                    messageDiv.removeClass('success').addClass('error').text('An error occurred. Please try again.').show();
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Submit Testimonial');
                }
            });
        });
    }
    
    // Newsletter subscription
    function initNewsletterForm() {
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const email = form.find('input[name="email"]').val();
            const submitButton = form.find('button[type="submit"]');
            const messageDiv = form.find('.form-message');
            
            // Disable submit button
            submitButton.prop('disabled', true).text('Subscribing...');
            
            // Send AJAX request
            $.ajax({
                url: xtreme_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'xtreme_newsletter_subscription',
                    email: email,
                    nonce: xtreme_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        messageDiv.removeClass('error').addClass('success').text(response.data.message).show();
                        form[0].reset();
                    } else {
                        messageDiv.removeClass('success').addClass('error').text(response.data.message).show();
                    }
                },
                error: function() {
                    messageDiv.removeClass('success').addClass('error').text('An error occurred. Please try again.').show();
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Subscribe');
                }
            });
        });
    }
    
    // Search functionality
    function initSearch() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const searchTerm = form.find('input[name="s"]').val();
            const resultsDiv = $('#search-results');
            
            if (!searchTerm) {
                return;
            }
            
            // Send AJAX request
            $.ajax({
                url: xtreme_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'xtreme_search',
                    search_term: searchTerm,
                    nonce: xtreme_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        let html = '<ul>';
                        response.data.results.forEach(function(result) {
                            html += '<li><a href="' + result.link + '">' + result.title + '</a> (' + result.type_label + ')</li>';
                        });
                        html += '</ul>';
                        resultsDiv.html(html).show();
                    } else {
                        resultsDiv.html('<p>' + response.data.message + '</p>').show();
                    }
                },
                error: function() {
                    resultsDiv.html('<p>An error occurred. Please try again.</p>').show();
                }
            });
        });
    }
    
    // Initialize all functions when DOM is ready
    $(document).ready(function() {
        initMobileMenu();
        initDropdownMenus();
        initStickyHeader();
        initSmoothScroll();
        initContactForm();
        initBookingForm();
        initTestimonialForm();
        initNewsletterForm();
        initSearch();
    });
    
    // Initialize when Elementor widgets are loaded
    $(window).on('elementor/frontend/init', function() {
        // Add any Elementor-specific functionality here
    });
    
})(jQuery);