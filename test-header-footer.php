<?php
/**
 * Test file to check if header.php and footer.php are being loaded
 */

// Load WordPress
require_once('/var/www/html/xtream4x4/wp-load.php');

echo "Testing get_header() and get_footer()...\n";

// Start output buffering to capture what get_header() outputs
ob_start();
get_header();
$header_output = ob_get_clean();

if (empty($header_output)) {
    echo "ERROR: get_header() produced NO output!\n";
    echo "This means header.php is NOT being loaded.\n";
} else {
    echo "SUCCESS: get_header() produced output (" . strlen($header_output) . " bytes)\n";
    // Check for key strings
    if (strpos($header_output, '<!DOCTYPE html>') !== false) {
        echo "  - Found <!DOCTYPE html> - GOOD!\n";
    } else {
        echo "  - MISSING <!DOCTYPE html> - BAD!\n";
    }
    if (strpos($header_output, 'masthead') !== false) {
        echo "  - Found masthead - GOOD!\n";
    } else {
        echo "  - MISSING masthead - BAD!\n";
    }
}

echo "\nTesting get_footer()...\n";

ob_start();
get_footer();
$footer_output = ob_get_clean();

if (empty($footer_output)) {
    echo "ERROR: get_footer() produced NO output!\n";
    echo "This means footer.php is NOT being loaded.\n";
} else {
    echo "SUCCESS: get_footer() produced output (" . strlen($footer_output) . " bytes)\n";
    if (strpos($footer_output, 'colophon') !== false) {
        echo "  - Found colophon - GOOD!\n";
    } else {
        echo "  - MISSING colophon - BAD!\n";
    }
}

echo "\nTest complete.\n";
?>