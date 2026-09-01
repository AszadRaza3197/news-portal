<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page = key($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BizNews - Member Panel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Customized Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light border-bottom d-none d-lg-block">
        <div class="row align-items-center py-2 px-lg-5">
            <div class="col-lg-12">
                <h1 class="m-0 h4 font-weight-bold text-dark">MEMBER <span class="text-primary h6 font-weight-normal">| Panel</span></h1>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-1">
        <div class="container-fluid px-lg-4">

            <!-- Mobile Brand Header -->
            <a href="dashboard.php" class="navbar-brand d-lg-none font-weight-bold h5 mb-0 text-uppercase">
                MEMBER
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#memberNavbar" aria-controls="memberNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-between" id="memberNavbar">

                <!-- Main Navigation Links -->
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a href="db.php?memindex"
                            class="nav-link px-3 <?php echo ($page == 'memindex') ? 'active' : ''; ?>">
                            Home
                        </a>
                    </li>

                    <?php if (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) { ?>

                        <li class="nav-item">
                            <a href="db.php?profile"
                                class="nav-link px-3 <?php echo ($page == 'profile') ? 'active' : ''; ?>">
                                Profile
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#"
                                class="nav-link px-3 dropdown-toggle <?php echo in_array($page, ['likem', 'commentm', 'bookmarkm']) ? 'active' : ''; ?>"
                                id="activityDropdown"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                Activity
                            </a>

                            <div class="dropdown-menu" aria-labelledby="activityDropdown">

                                <a class="dropdown-item" href="db.php?likem">
                                    <i class="fas fa-thumbs-up mr-2"></i> Like
                                </a>

                                <a class="dropdown-item" href="db.php?commentm">
                                    <i class="fas fa-comment mr-2"></i> Comment
                                </a>

                                <a class="dropdown-item" href="db.php?bookmarkm">
                                    <i class="fas fa-bookmark mr-2"></i> Bookmark
                                </a>

                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="dashboard.php"
                                class="nav-link px-3 <?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="db.php?message"
                                class="nav-link px-3 <?php echo ($page == 'message') ? 'active' : ''; ?>">
                                <i class="fas fa-envelope mr-1"></i> Message
                            </a>
                        </li>

                    <?php } else { ?>

                        <li class="nav-item">
                            <a href="signup.php"
                                class="nav-link px-3 <?php echo ($page == 'signup') ? 'active' : ''; ?>">
                                Signup
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="signin.php"
                                class="nav-link px-3 <?php echo ($page == 'signin') ? 'active' : ''; ?>">
                                Signin
                            </a>
                        </li>

                    <?php } ?>

                </ul>

                <!-- Right Side Action & Logout -->
                <?php if (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) { ?>
                    <div class="d-flex align-items-center pt-2 pt-lg-0 border-top border-lg-0 border-secondary">
                        <a href="db.php?logout" class="btn btn-outline-danger btn-sm px-3 ml-2">
                            Logout
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Bootstrap 4 Required JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>