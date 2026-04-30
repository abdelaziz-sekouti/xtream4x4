/**
 * Main JavaScript for Xtreme Plugin
 */

(function($) {
    'use strict';
    
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