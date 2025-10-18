<!-- Top Navigation Bar -->
<style>
    .bg-gradient-custom {
        background: linear-gradient(135deg, #0a0f24, #0d1117);
    }

    .navbar-custom {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .navbar-custom .navbar-brand {
        color: #fff !important;
        font-weight: 800;
    }

    .navbar-custom .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        padding: 0.75rem 1rem;
        border-radius: 0.35rem;
        margin: 0 0.25rem;
        transition: all 0.3s;
    }

    .navbar-custom .navbar-nav .nav-link:hover,
    .navbar-custom .navbar-nav .nav-link.active {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-custom .navbar-nav .nav-link i {
        margin-right: 0.5rem;
    }

    .dropdown-menu-custom {
        background-color: #f8f9fc;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    /* Fixed navbar positioning */
    .navbar-fixed {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        margin-bottom: 0;
    }

    /* Add top padding to body content to account for fixed navbar */
    body {
        padding-top: 90px;
        /* Adjust based on navbar height */
    }

    /* Theme toggle button */
    .theme-toggle {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        padding: 0.5rem;
        margin: 0 0.5rem;
        border-radius: 0.35rem;
        transition: all 0.3s;
    }

    .theme-toggle:hover {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Responsive Navigation Styles */
    @media (max-width: 1200px) {
        .navbar-custom .navbar-nav .nav-link {
            padding: 0.6rem 0.8rem;
            margin: 0 0.1rem;
        }

        body {
            padding-top: 80px;
        }
    }

    @media (max-width: 992px) {
        .navbar-custom .navbar-nav .nav-link {
            padding: 0.5rem 0.6rem;
            margin: 0;
            text-align: center;
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-collapse {
            margin-top: 1rem;
        }

        body {
            padding-top: 70px;
        }
    }

    @media (max-width: 768px) {
        .navbar-custom {
            padding: 0.5rem 1rem;
        }

        .navbar-custom .navbar-brand {
            font-size: 1.1rem;
        }

        .navbar-custom .navbar-nav {
            margin-top: 1rem;
            text-align: center;
        }

        .navbar-custom .navbar-nav .nav-link {
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .dropdown-menu-custom {
            position: static !important;
            float: none;
            width: auto;
            margin-top: 0;
            background-color: rgba(255, 255, 255, 0.1);
            border: 0;
            box-shadow: none;
        }

        .dropdown-menu-custom .dropdown-item {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 0.5rem 1rem;
        }

        .dropdown-menu-custom .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff !important;
        }

        .theme-toggle {
            margin-left: 0.5rem;
        }

        body {
            padding-top: 65px;
        }
    }

    @media (max-width: 576px) {
        .navbar-custom {
            padding: 0.4rem 0.8rem;
        }

        .navbar-custom .navbar-brand {
            font-size: 1rem;
        }

        .navbar-custom .navbar-nav .nav-link {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        .theme-toggle {
            font-size: 1rem;
            padding: 0.4rem;
        }

        body {
            padding-top: 60px;
        }
    }

    @media (max-width: 400px) {
        .navbar-custom {
            padding: 0.3rem 0.5rem;
        }

        .navbar-custom .navbar-brand {
            font-size: 0.9rem;
        }

        .navbar-custom .navbar-nav .nav-link {
            font-size: 0.85rem;
            padding: 0.5rem 0.6rem;
        }

        .navbar-brand img {
            width: 30px !important;
            height: 30px !important;
        }

        body {
            padding-top: 55px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg bg-gradient-custom navbar-custom navbar-fixed">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="../dashboard/">
            <img src="../../img/logo2.png" alt="iSUMBONG" style="width: 40px; height: 40px;" class="me-2">
            <span class="text-primary">iSUMBONG</span>
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span style="color: white;">
                <i class="fas fa-bars"></i>
            </span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Empty space on left for brand only -->
            <div class="navbar-nav me-auto"></div>

            <!-- Right side items - All navigation and account -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard/">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../about/">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../threats/">
                        <i class="fas fa-shield-alt"></i>
                        <span>Threats</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">
                        <i class="fas fa-newspaper"></i>
                        <span>News</span>
                    </a>
                </li>
                <!-- Separator -->
                <li class="nav-item">
                    <div class="nav-link px-2">
                        <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.3);"></div>
                    </div>
                </li>

                <!-- Theme Toggle -->
                <li class="nav-item">
                    <button class="theme-toggle" onclick="handleThemeToggle(event)" title="Toggle Theme">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                </li>

                <!-- User dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span>Account</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-custom" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../incident/">
                            <i class="fas fa-edit text-gray-400 me-2"></i>My Incidents
                        </a>
                        <a class="dropdown-item" href="../profile/">
                            <i class="fas fa-user text-gray-400 me-2"></i>Profile
                        </a>
                        <a class="dropdown-item" href="../settings/">
                            <i class="fas fa-cog text-gray-400 me-2"></i>Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt text-gray-400 me-2"></i>Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Theme Toggle Handler -->
<script>
    function handleThemeToggle(event) {
        event.preventDefault();
        event.stopPropagation();

        if (window.themeManager) {
            const newTheme = window.themeManager.toggleTheme();
            console.log('Theme toggled to:', newTheme);
        } else {
            console.log('Theme manager not available yet');
            // Fallback for when theme manager isn't loaded yet
            setTimeout(() => {
                if (window.themeManager) {
                    window.themeManager.toggleTheme();
                }
            }, 100);
        }

        return false;
    }
</script>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../../logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>