<!-- EXAMPLE: How to add theme support to any user page -->

<?php
// Add these includes at the top of any page (after your existing includes)
include '../../includes/theme_system.php';  // Adjust path as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
    
    <!-- Add theme meta and includes -->
    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?> <!-- Adjust path as needed -->
    
</head>
<body id="page-top">
    
    <!-- Your existing page content -->
    
    <!-- Your existing scripts -->
    
    <!-- Theme system will automatically apply saved theme on page load -->
    
</body>
</html>

<!-- 
INSTRUCTIONS FOR ADDING THEME SUPPORT TO EXISTING PAGES:

1. Add this line after your existing includes:
   include '../../includes/theme_system.php';

2. Add these lines in your HTML head section:
   <?php echo getThemeMeta(); ?>
   <?php echo getThemeIncludes('../../'); ?>

3. Adjust the path in getThemeIncludes() based on your page location:
   - For user/settings/: use '../../'
   - For user/dashboard/: use '../../'  
   - For user/: use '../'
   - For root pages: use './'

4. That's it! The theme will automatically be applied when the page loads.

The theme system will:
- Load the user's saved theme preference
- Apply the appropriate CSS classes
- Enable theme switching via the navbar toggle
- Sync theme across all pages
- Save theme preference in both localStorage and PHP session
-->
