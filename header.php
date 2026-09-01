<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['memindex'])) {
    $page = 'memindex';
} elseif (isset($_GET['profile'])) {
    $page = 'profile';
} elseif (basename($_SERVER['PHP_SELF']) == 'signup.php') {
    $page = 'signup';
} elseif (basename($_SERVER['PHP_SELF']) == 'signin.php') {
    $page = 'signin';
} else {
    $page = '';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A News</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    $url = "https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $googleTranslateScript = curl_exec($ch);
    curl_close($ch);
    ?>
    <div class="container-fluid bg-light py-2">
        <div class="container">
            <div class="col-lg-2 text-center" id="google_translate_element"></div>
        </div>
    </div>

    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center bg-white py-3 px-lg-5">
            <div class="col-lg-4">
                <a href="index.php" class="navbar-brand p-0 d-none d-lg-block">
                    <h1 class="m-0 display-4 text-uppercase text-primary">A<span class="text-secondary font-weight-normal">News</span></h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                <a href="https://htmlcodex.com/downloading/?item=1541"><img class="img-fluid" src="img/ads-728x90.png" alt=""></a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">

            <a href="index.php" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-uppercase text-primary">
                    A<span class="text-white font-weight-normal">News</span>
                </h1>
            </a>

            <button type="button"
                class="navbar-toggler"
                data-toggle="collapse"
                data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3"
                id="navbarCollapse">

                <div class="navbar-nav mr-auto py-0">

                    <!-- Home -->
                    <a href="db.php?memindex"
                        class="nav-item nav-link <?php echo ($page == 'memindex') ? 'active' : ''; ?>">
                        Home
                    </a>

                    <?php if (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) { ?>

                        <!-- Profile -->
                        <a href="db.php?profile"
                            class="nav-item nav-link <?php echo ($page == 'profile') ? 'active' : ''; ?>">
                            Profile
                        </a>

                        <!-- Logout -->
                        <a href="db.php?logout"
                            class="nav-item nav-link">
                            Logout
                        </a>

                    <?php } else { ?>

                        <!-- Signup -->
                        <a href="signup.php"
                            class="nav-item nav-link <?php echo ($page == 'signup') ? 'active' : ''; ?>">
                            Signup
                        </a>

                        <!-- Signin -->
                        <a href="signin.php"
                            class="nav-item nav-link <?php echo ($page == 'signin') ? 'active' : ''; ?>">
                            Signin
                        </a>

                    <?php } ?>

                </div>

                <!-- Search -->
                <form action="index.php" method="post">

                    <div class="input-group ml-auto d-none d-lg-flex"
                        style="width: 100%; max-width: 300px;">

                        <input type="text"
                            class="form-control border-0"
                            name="keyword"
                            placeholder="Keyword">
                        <div class="input-group-append">
                            <button type="submit"
                                class="input-group-text bg-primary text-dark border-0 px-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </div>


    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,hi,bn,gu',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <?php
    echo "<script type='text/javascript'>";
    echo $googleTranslateScript;
    echo "</script>";
    ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <!-- Navbar End -->
    <!-- Navbar End -->