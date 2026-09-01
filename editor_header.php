<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['uid']) || empty($_SESSION['uid']) || $_SESSION['role'] !== 'editor') {
    header("Location: signin.php");
    exit;
}

if (isset($_GET['memindex'])) {
    $page = 'memindex';
} elseif (isset($_GET['editor'])) {
    $page = 'editor';
} elseif (isset($_GET['pnews'])) {
    $page = 'pnews';
} elseif (isset($_GET['upnews'])) {
    $page = 'upnews';
} elseif (isset($_GET['message'])) {
    $page = 'message';
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
    <title>BizNews - Editor Panel</title>
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
                <h1 class="m-0 h4 font-weight-bold text-dark">EDITOR <span class="text-primary h6 font-weight-normal">| Panel</span></h1>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-1">
        <div class="container-fluid px-lg-4">

            <!-- Mobile Brand Header -->
            <a href="dashboard.php" class="navbar-brand d-lg-none font-weight-bold h5 mb-0 text-uppercase">
                EDITOR
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#editorNavbar" aria-controls="editorNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-between" id="editorNavbar">

                <!-- Main Navigation Links -->
                <ul class="navbar-nav mr-auto">

                    <!-- Home -->
                    <li class="nav-item">
                        <a href="db.php?memindex"
                            class="nav-link px-3 <?php echo ($page == 'memindex') ? 'active' : ''; ?>">
                            Home
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item">
                        <a href="db.php?editor"
                            class="nav-link px-3 <?php echo ($page == 'editor') ? 'active' : ''; ?>">
                            Profile
                        </a>
                    </li>

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="dashboard.php"
                            class="nav-link px-3 <?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                            Dashboard
                        </a>
                    </li>

                    <!-- Manage News -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle px-3
            <?php echo in_array($page, ['pnews', 'upnews']) ? 'active' : ''; ?>"
                            href="#"
                            id="manageNewsDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">

                            Manage News

                        </a>

                        <div class="dropdown-menu rounded-0 border-0 shadow"
                            aria-labelledby="manageNewsDropdown">

                            <a href="db.php?pnews"
                                class="dropdown-item <?php echo ($page == 'pnews') ? 'active' : ''; ?>">
                                Published
                            </a>

                            <a href="db.php?upnews"
                                class="dropdown-item <?php echo ($page == 'upnews') ? 'active' : ''; ?>">
                                Unpublished
                            </a>

                        </div>
                    </li>

                    <!-- Message -->
                    <li class="nav-item">
                        <a href="db.php?message"
                            class="nav-link px-3 <?php echo ($page == 'message') ? 'active' : ''; ?>">

                            <i class="fas fa-envelope mr-1"></i> Message

                        </a>
                    </li>

                </ul>

                <!-- Right Side Action & Logout -->
                <div class="d-flex align-items-center pt-2 pt-lg-0 border-top border-lg-0 border-secondary">
                    <a href="db.php?logout" class="btn btn-outline-danger btn-sm px-3 ml-2">
                        Logout
                    </a>
                </div>

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