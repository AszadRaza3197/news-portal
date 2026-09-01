<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['uid']) || empty($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit;
}

if (isset($_GET['memindex'])) {
    $page = 'memindex';
} elseif (isset($_GET['profile'])) {
    $page = 'profile';
} elseif (isset($_GET['ve'])) {
    $page = 've';
} elseif (isset($_GET['nve'])) {
    $page = 'nve';
} elseif (isset($_GET['vr'])) {
    $page = 'vr';
} elseif (isset($_GET['nvr'])) {
    $page = 'nvr';
} elseif (isset($_GET['vm'])) {
    $page = 'vm';
} elseif (isset($_GET['nvm'])) {
    $page = 'nvm';
} elseif (isset($_GET['adpnews'])) {
    $page = 'adpnews';
} elseif (isset($_GET['adupnews'])) {
    $page = 'adupnews';
} elseif (isset($_GET['vc'])) {
    $page = 'vc';
} elseif (isset($_GET['nvc'])) {
    $page = 'nvc';
} elseif (isset($_GET['loc'])) {
    $page = 'loc';
} elseif (isset($_GET['cat'])) {
    $page = 'cat';
} elseif (isset($_GET['message'])) {
    $page = 'message';
} elseif (isset($_GET['act'])) {
    $page = 'act';
} elseif (basename($_SERVER['PHP_SELF']) == 'dashboard.php') {
    $page = 'dashboard';
} else {
    $page = '';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BizNews - Admin Dashboard</title>
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
                <h1 class="m-0 h4 font-weight-bold text-dark">ADMIN <span class="text-primary h6 font-weight-normal">| Panel</span></h1>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark sticky-top shadow-sm py-1">
        <div class="container-fluid px-lg-4">

            <!-- Mobile Brand Header -->
            <a href="dashboard.php" class="navbar-brand d-lg-none font-weight-bold h5 mb-0 text-uppercase">
                ADMIN
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-between" id="adminNavbar">

                <!-- Main Navigation Links -->
                <ul class="navbar-nav mr-auto">

                    <!-- Home -->
                    <li class="nav-item">
                        <a href="db.php?memindex"
                            class="nav-link px-2 <?php echo ($page == 'memindex') ? 'active' : ''; ?>">
                            Home
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item">
                        <a href="db.php?profile"
                            class="nav-link px-2 <?php echo ($page == 'profile') ? 'active' : ''; ?>">
                            Profile
                        </a>
                    </li>

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="dashboard.php"
                            class="nav-link px-2 <?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                            Dashboard
                        </a>
                    </li>

                    <!-- Editors -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2
            <?php echo in_array($page, ['ve', 'nve']) ? 'active' : ''; ?>"
                            href="#"
                            id="editorsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            Editors
                        </a>

                        <div class="dropdown-menu dropdown-menu-right rounded-0 border-0 shadow"
                            aria-labelledby="editorsDropdown">

                            <a href="db.php?ve"
                                class="dropdown-item <?php echo ($page == 've') ? 'active' : ''; ?>">
                                Verified
                            </a>

                            <a href="db.php?nve"
                                class="dropdown-item <?php echo ($page == 'nve') ? 'active' : ''; ?>">
                                Non Verified
                            </a>
                        </div>
                    </li>

                    <!-- Reporters -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2
            <?php echo in_array($page, ['vr', 'nvr']) ? 'active' : ''; ?>"
                            href="#"
                            id="reportersDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            Reporters
                        </a>

                        <div class="dropdown-menu dropdown-menu-right rounded-0 border-0 shadow"
                            aria-labelledby="reportersDropdown">

                            <a href="db.php?vr"
                                class="dropdown-item <?php echo ($page == 'vr') ? 'active' : ''; ?>">
                                Verified
                            </a>

                            <a href="db.php?nvr"
                                class="dropdown-item <?php echo ($page == 'nvr') ? 'active' : ''; ?>">
                                Non Verified
                            </a>
                        </div>
                    </li>

                    <!-- Members -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2
            <?php echo in_array($page, ['vm', 'nvm']) ? 'active' : ''; ?>"
                            href="#"
                            id="membersDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            Members
                        </a>

                        <div class="dropdown-menu dropdown-menu-right rounded-0 border-0 shadow"
                            aria-labelledby="membersDropdown">

                            <a href="db.php?vm"
                                class="dropdown-item <?php echo ($page == 'vm') ? 'active' : ''; ?>">
                                Verified
                            </a>

                            <a href="db.php?nvm"
                                class="dropdown-item <?php echo ($page == 'nvm') ? 'active' : ''; ?>">
                                Non Verified
                            </a>
                        </div>
                    </li>

                    <!-- News -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2
            <?php echo in_array($page, ['adpnews', 'adupnews']) ? 'active' : ''; ?>"
                            href="#"
                            id="newsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            News
                        </a>

                        <div class="dropdown-menu dropdown-menu-right rounded-0 border-0 shadow"
                            aria-labelledby="newsDropdown">

                            <a href="db.php?adpnews"
                                class="dropdown-item <?php echo ($page == 'adpnews') ? 'active' : ''; ?>">
                                Published
                            </a>

                            <a href="db.php?adupnews"
                                class="dropdown-item <?php echo ($page == 'adupnews') ? 'active' : ''; ?>">
                                Unpublished
                            </a>
                        </div>
                    </li>

                    <!-- Comments -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2
            <?php echo in_array($page, ['vc', 'nvc']) ? 'active' : ''; ?>"
                            href="#"
                            id="commentsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            Comments
                        </a>

                        <div class="dropdown-menu dropdown-menu-right rounded-0 border-0 shadow"
                            aria-labelledby="commentsDropdown">

                            <a href="db.php?vc"
                                class="dropdown-item <?php echo ($page == 'vc') ? 'active' : ''; ?>">
                                Verified
                            </a>

                            <a href="db.php?nvc"
                                class="dropdown-item <?php echo ($page == 'nvc') ? 'active' : ''; ?>">
                                Non Verified
                            </a>
                        </div>
                    </li>

                    <!-- Locations -->
                    <li class="nav-item">
                        <a href="db.php?loc"
                            class="nav-link px-2 <?php echo ($page == 'loc') ? 'active' : ''; ?>">
                            Locations
                        </a>
                    </li>

                    <!-- Category -->
                    <li class="nav-item">
                        <a href="db.php?cat"
                            class="nav-link px-2 <?php echo ($page == 'cat') ? 'active' : ''; ?>">
                            Category
                        </a>
                    </li>

                </ul>

                <!-- Right Side Action Icons & Logout -->
                <div class="d-flex align-items-center pt-2 pt-lg-0 border-top border-lg-0 border-secondary">
                    <a href="db.php?message" class="nav-link text-light h5 mb-0 px-2" title="Messages">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="db.php?act" class="nav-link text-light h5 mb-0 px-2" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </a>
                    <a href="db.php?logout" class="btn btn-outline-danger btn-sm px-3 ml-2">
                        Logout
                    </a>
                </div>

            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Bootstrap 4 Required JS Libraries (In exact order) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>