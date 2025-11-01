<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

include '../../connectMySql.php';
include '../../includes/theme_system.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cybercrime News - iReport</title>

    <!-- Custom fonts for this template (CDN to avoid /vendor 403) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?>
    
    <!-- Theme Debug Script -->
    <script>
        // Ensure theme manager is available and working
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit for theme manager to initialize
            setTimeout(function() {
                if (window.themeManager) {
                    console.log('Theme manager loaded successfully');
                    console.log('Current theme:', window.themeManager.getCurrentTheme());
                } else {
                    console.error('Theme manager not loaded');
                }
            }, 200);
        });
    </script>
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="80" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .hero-content {
            z-index: 2;
            position: relative;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-hero {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .news-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .card-img-top {
            transition: all 0.3s ease;
        }
        
        .news-card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        /* Responsive Design for News Page */
        @media (max-width: 1200px) {
            .container-fluid {
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-section {
                min-height: 280px;
            }
        }
        
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-section {
                min-height: 320px;
                padding: 2rem 0;
            }
            
            .btn-hero {
                margin: 0.5rem;
                display: inline-block;
            }
            
            .news-card {
                margin-bottom: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-section {
                min-height: 350px;
                padding: 2rem 0;
            }
            
            .btn-hero {
                display: block;
                width: 80%;
                margin: 0.5rem auto;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
            
            .news-card {
                margin-bottom: 1.5rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .card-title {
                font-size: 1.1rem;
            }
            
            .card-text {
                font-size: 0.9rem;
            }
            
            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            h3 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 0.95rem;
            }
            
            .hero-section {
                min-height: 400px;
                padding: 1.5rem 0;
            }
            
            .btn-hero {
                width: 90%;
                font-size: 0.85rem;
                padding: 8px 16px;
            }
            
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .py-5 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            
            .news-card {
                margin-bottom: 1rem;
            }
            
            .card-body {
                padding: 0.8rem;
            }
            
            .card-title {
                font-size: 1rem;
            }
            
            .card-text {
                font-size: 0.85rem;
            }
            
            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
            
            h2 {
                font-size: 1.6rem;
            }
            
            h3 {
                font-size: 1.3rem;
            }
            
            .col-lg-4, .col-md-6 {
                margin-bottom: 1rem;
            }
            
            .card-img-top {
                height: 180px;
                object-fit: cover;
            }
        }
        
        @media (max-width: 400px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
            
            .container-fluid {
                padding-left: 8px;
                padding-right: 8px;
            }
            
            .card-body {
                padding: 0.6rem;
            }
            
            .card-title {
                font-size: 0.95rem;
            }
            
            .card-text {
                font-size: 0.8rem;
            }
            
            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
            
            h2 {
                font-size: 1.4rem;
            }
            
            h3 {
                font-size: 1.2rem;
            }
            
            .btn-hero {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
            
            .card-img-top {
                height: 160px;
            }
        }
        
        /* Animation for cards */
        .news-card {
            animation: fadeInUp 0.6s ease-in-out;
        }
        
        .news-card:nth-child(2) {
            animation-delay: 0.1s;
        }
        
        .news-card:nth-child(3) {
            animation-delay: 0.2s;
        }
        
        .news-card:nth-child(4) {
            animation-delay: 0.3s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Hero animation */
        .hero-content {
            animation: heroFadeIn 1s ease-in-out;
        }
        
        @keyframes heroFadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .news-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Sticky sidebar for Facebook page */
        .sticky-sidebar {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .fb-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .news-articles {
            padding-left: 30px;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .news-articles {
                padding-left: 0;
                margin-top: 30px;
            }
            
            .sticky-sidebar {
                position: relative;
                top: auto;
            }
        }

        .news-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .news-date {
            background: #f8f9fa;
            padding: 8px 15px;
            font-size: 14px;
            color: #6c757d;
            border-bottom: 1px solid #e9ecef;
        }

        .news-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-arrest {
            background: #dc3545;
            color: white;
        }

        .badge-alert {
            background: #fd7e14;
            color: white;
        }

        .news-content {
            padding: 25px;
        }

        .news-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .news-title:hover {
            color: #3498db;
            cursor: pointer;
        }

        .news-excerpt {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .news-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-read-more {
            background: #3498db;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-read-more:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
            transform: translateX(5px);
        }

        .share-btn {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 18px;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
        }

        .share-btn:hover {
            color: #3498db;
            background: #f8f9fa;
        }

        .news-image-placeholder {
            width: 100px;
            height: 80px;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 24px;
            margin-left: 20px;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .news-card {
                margin-bottom: 20px;
            }
            
            .news-content {
                padding: 20px;
            }
            
            .news-image-placeholder {
                display: none;
            }
        }
    </style>
</head>

<body id="page-top" style="background: #f8f9fa;">
    
    <!-- Facebook SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0&appId=1798513134073749"></script>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                
                <!-- Include Navigation -->
                <?php include '../nav.php'; ?>

                <!-- Hero Section -->
                <section class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">Cybercrime News</h1>
                        <p class="hero-subtitle">Stay informed about the latest cybersecurity incidents and alerts</p>
                        <div>
                            <a href="../dashboard/" class="btn btn-outline-light btn-hero">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                            </a>
                            <a href="#latest-news" class="btn btn-danger btn-hero">
                                <i class="fas fa-newspaper mr-2"></i>Read Latest News
                            </a>
                        </div>
                    </div>
                </section>

                <!-- News Content -->
                <div class="news-container" id="latest-news">
                    <div class="row">
                        <!-- Left Column - PNP-ACG FB PAGE -->
                        <div class="col-lg-4 col-md-5">
                            <div class="sticky-sidebar">
                                <div class="fb-container">
                                    <h4 class="text-center mb-3" style="color: #2c3e50; font-weight: 600;">
                                        <i class="fab fa-facebook mr-2"></i>PNP Anti-Cybercrime Group
                                    </h4>
                                    
                                    <!-- Facebook Page Plugin -->
                                    <div class="fb-page" 
                                         data-href="https://www.facebook.com/anticybercrimegroup" 
                                         data-tabs="timeline" 
                                         data-width="320" 
                                         data-height="600" 
                                         data-small-header="false" 
                                         data-adapt-container-width="true" 
                                         data-hide-cover="false" 
                                         data-show-facepile="true">
                                        <blockquote cite="https://www.facebook.com/anticybercrimegroup" class="fb-xfbml-parse-ignore">
                                             <a href="https://www.facebook.com/anticybercrimegroup" target="_blank" rel="noopener">
                                                <div class="fb-fallback p-4 text-center" style="border: 2px solid #e9ecef; border-radius: 10px; background: #f8f9fa;">
                                                    <i class="fab fa-facebook fa-3x text-primary mb-3"></i>
                                                    <h5>PNP Anti-Cybercrime Group</h5>
                                                    <p class="text-muted">Click to visit our Facebook page</p>
                                                    <div class="btn btn-primary">
                                                        <i class="fab fa-facebook mr-2"></i>Visit Facebook Page
                                                    </div>
                                                </div>
                                            </a>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - News Articles -->
                        <div class="col-lg-8 col-md-7">
                            <div class="news-articles">
                                <h4 class="mb-4" style="color: #2c3e50; font-weight: 600;">
                                    <i class="fas fa-newspaper mr-2"></i>Latest Cybercrime News
                                </h4>
                    <!-- News Article 1 -->
                    <div class="news-card">
                        <div class="news-date">
                            <i class="fas fa-calendar-alt mr-2"></i>August 22, 2025
                            <span class="news-badge badge-arrest ml-3">ARREST</span>
                        </div>
                        <div class="d-flex">
                            <div class="news-content flex-grow-1">
                                <h3 class="news-title">Woman Arrested in Laguna for Online Scam</h3>
                                <p class="news-excerpt">
                                    On August 19, 2025, at about 8:30 PM in Calamba City, Laguna, operatives of the Manila District Anti-Cybercrime Team conducted an entrapment operation that led to the arrest of a 23-year-old woman, alias "Fel," for committing fraudulent activities through a social media platform. "Fel" is facing charges for violation of Article 315 (Swindling/Estafa) of the...
                                </p>
                                <div class="news-actions">
                                    <a href="https://acg.pnp.gov.ph/%f0%9d%90%96%f0%9d%90%a8%f0%9d%90%a6%f0%9d%90%9a%f0%9d%90%a7-%f0%9d%90%80%f0%9d%90%ab%f0%9d%90%ab%f0%9d%90%9e%f0%9d%90%ac%f0%9d%90%ad%f0%9d%90%9e%f0%9d%90%9d-%f0%9d%90%a2%f0%9d%90%a7-%f0%9d%90%8b/" target="_blank" class="btn-read-more">Read Full Article</a>
                                    <button class="share-btn" title="Share Article">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="news-image-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                    </div>

                    <!-- News Article 2 -->
                    <div class="news-card">
                        <div class="news-date">
                            <i class="fas fa-calendar-alt mr-2"></i>August 22, 2025
                            <span class="news-badge badge-arrest ml-3">ARREST</span>
                        </div>
                        <div class="d-flex">
                            <div class="news-content flex-grow-1">
                                <h3 class="news-title">Man Arrested in Baguio City for Online Extortion</h3>
                                <p class="news-excerpt">
                                    On August 19, 2025, at about 8:00 PM in Baguio City, operatives of the Mt Province Cyber Response Team conducted an entrapment operation that led to the arrest of a 26-year-old man, alias "Bikoy," for extorting through a social media platform. "Bikoy" is facing charges for violations of Articles 294 (Robbery with Intimidation of Persons)...
                                </p>
                                <div class="news-actions">
                                    <a href="https://acg.pnp.gov.ph/%f0%9d%90%8c%f0%9d%90%9a%f0%9d%90%a7-%f0%9d%90%80%f0%9d%90%ab%f0%9d%90%ab%f0%9d%90%9e%f0%9d%90%ac%f0%9d%90%ad%f0%9d%90%9e%f0%9d%90%9d-%f0%9d%90%a2%f0%9d%90%a7-%f0%9d%90%81%f0%9d%90%9a%f0%9d%90%a0/" class="btn-read-more">Read Full Article</a>
                                    <button class="share-btn" title="Share Article">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="news-image-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                    </div>

                    <!-- News Article 3 -->
                    <div class="news-card">
                        <div class="news-date">
                            <i class="fas fa-calendar-alt mr-2"></i>August 20, 2025
                            <span class="news-badge badge-alert ml-3">ALERT</span>
                        </div>
                        <div class="d-flex">
                            <div class="news-content flex-grow-1">
                                <h3 class="news-title"> Two Online Sellers of Financial Accounts Arrested in Cavite</h3>
                                <p class="news-excerpt">
                                    On August 19, 2025, operatives of the Cavite Provincial Cyber Response Team conducted two separate entrapment operations in Cavite that led to the arrest of two suspects, identified by their aliases “Ruben,” 36, male, and “Dyna,” 29, female, for the illegal sale of financial accounts. “Dyna” is facing charges for violations of Section 5(d) of...
                                </p>
                                <div class="news-actions">
                                    <a href="https://acg.pnp.gov.ph/%f0%9d%90%93%f0%9d%90%b0%f0%9d%90%a8-%f0%9d%90%8e%f0%9d%90%a7%f0%9d%90%a5%f0%9d%90%a2%f0%9d%90%a7%f0%9d%90%9e-%f0%9d%90%92%f0%9d%90%9e%f0%9d%90%a5%f0%9d%90%a5%f0%9d%90%9e%f0%9d%90%ab%f0%9d%90%ac-24/" target="_blank" class="btn-read-more">Read Full Article</a>
                                    <button class="share-btn" title="Share Article">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="news-image-placeholder">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Load More Section -->
                    <div class="text-center mt-5">
                        <button class="btn btn-outline-primary btn-lg" style="border-radius: 50px; padding: 12px 40px; font-weight: 600;">
                            <i class="fas fa-plus mr-2"></i>Load More Articles
                        </button>
                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include'../footer.php';?>

    <!-- Core JavaScript via CDN to avoid blocked /vendor assets -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <script>
        // Smooth scrolling for anchor links
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });

            // Share functionality
            $('.share-btn').click(function() {
                const url = window.location.href;
                const title = $(this).closest('.news-card').find('.news-title').text();
                
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    });
                } else {
                    // Fallback to copy to clipboard
                    navigator.clipboard.writeText(url).then(function() {
                        alert('Article link copied to clipboard!');
                    });
                }
            });

            // Load more functionality
            $('.btn:contains("Load More")').click(function() {
                $(this).html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');
                
                // Simulate loading
                setTimeout(() => {
                    $(this).html('<i class="fas fa-check mr-2"></i>No more articles');
                    $(this).prop('disabled', true);
                }, 2000);
            });
        });
    </script>

</body>

</html>
