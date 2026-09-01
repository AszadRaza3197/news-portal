<?php
include 'header.php';
?>

<style>
    /* Modern Login Form Enhancements */
    .login-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .login-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
    }

    .login-card-header {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
    }

    .form-control-custom {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .btn-login {
        border-radius: 8px;
        padding: 0.75rem;
        letter-spacing: 0.5px;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-login:hover {
        transform: translateY(-1px);
    }
</style>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card login-card shadow-sm">

                <!-- Card Header -->
                <div class="card-header login-card-header text-dark text-center border-0">
                    <h3 class="mb-0 font-weight-bold">
                        <i class="fa fa-sign-in-alt mr-2"></i> Login
                    </h3>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 p-md-5">

                    <!-- Message Alert -->
                    <?php if (isset($_GET['msg'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center rounded-lg py-2 mb-4" role="alert">
                            <small class="font-weight-bold"><?php echo $_GET['msg']; ?></small>
                        </div>
                    <?php } ?>

                    <form action="db.php" method="POST">

                        <!-- Email Input Group -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-envelope mr-1 text-warning"></i> Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-custom"
                                placeholder="name@example.com"
                                required>
                        </div>

                        <!-- Password Input Group -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-lock mr-1 text-warning"></i> Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-custom"
                                placeholder="Enter your password"
                                required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="login" class="btn btn-warning btn-block font-weight-bold text-dark btn-login shadow-sm">
                            <i class="fa fa-sign-in-alt mr-2"></i> LOGIN
                        </button>

                    </form>

                    <hr class="my-4">

                    <!-- Signup Link -->
                    <div class="text-center text-muted">
                        Don't have an account?
                        <a href="signup.php" class="text-warning font-weight-bold text-decoration-none">
                            Sign Up
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>