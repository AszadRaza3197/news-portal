<?php include 'header.php'; ?>

<style>
    /* Modern Signup Form Enhancements */
    .signup-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .signup-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
    }

    .signup-card-header {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
    }

    .form-control-custom {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        height: auto;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .role-box {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
    }

    .btn-signup {
        border-radius: 8px;
        padding: 0.75rem;
        letter-spacing: 0.5px;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-signup:hover {
        transform: translateY(-1px);
    }
</style>

<div class="container py-5 my-3">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card signup-card shadow-sm">

                <!-- Card Header -->
                <div class="card-header signup-card-header text-dark text-center border-0">
                    <h3 class="mb-0 font-weight-bold">
                        <i class="fa fa-user-plus mr-2"></i> Create Account
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

                        <!-- Role Selector -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-secondary small text-uppercase mb-2">
                                <i class="fa fa-users mr-1 text-warning"></i> Signup As
                            </label>
                            <div class="role-box d-flex justify-content-around flex-wrap">
                                <div class="custom-control custom-radio custom-control-inline my-1">
                                    <input type="radio" class="custom-control-input" id="editor" name="role" value="editor">
                                    <label class="custom-control-label font-weight-bold text-dark cursor-pointer" for="editor">Editor</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline my-1">
                                    <input type="radio" class="custom-control-input" id="reporter" name="role" value="reporter">
                                    <label class="custom-control-label font-weight-bold text-dark cursor-pointer" for="reporter">Reporter</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline my-1">
                                    <input type="radio" class="custom-control-input" id="member" name="role" value="member">
                                    <label class="custom-control-label font-weight-bold text-dark cursor-pointer" for="member">Member</label>
                                </div>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-user mr-1 text-warning"></i> Full Name
                            </label>
                            <input type="text" name="name" class="form-control form-control-custom" placeholder="Enter your full name" required>
                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-phone mr-1 text-warning"></i> Mobile Number
                            </label>
                            <input type="text" name="mobile" class="form-control form-control-custom" placeholder="Enter mobile number" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-envelope mr-1 text-warning"></i> Email Address
                            </label>
                            <input type="email" name="email" class="form-control form-control-custom" placeholder="name@example.com" required>
                        </div>

                        <!-- Dynamic Category Select -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-list mr-1 text-warning"></i> Category
                            </label>
                            <select class="form-control form-control-custom" id="category" name="category">
                                <option value="1" selected>Select Category</option>
                            </select>
                        </div>

                        <!-- Dynamic Location Select -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-map-marker mr-1 text-warning"></i> Location
                            </label>
                            <select class="form-control form-control-custom" id="location" name="location">
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-secondary small text-uppercase">
                                <i class="fa fa-lock mr-1 text-warning"></i> Password
                            </label>
                            <input type="password" name="password" class="form-control form-control-custom" placeholder="Create a strong password" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="signup" class="btn btn-warning btn-block font-weight-bold text-dark btn-signup shadow-sm">
                            <i class="fa fa-user-plus mr-2"></i> SIGN UP
                        </button>

                    </form>

                    <hr class="my-4">

                    <!-- Sign In Link -->
                    <div class="text-center text-muted">
                        Already Registered?
                        <a href="signin.php" class="text-warning font-weight-bold text-decoration-none">
                            Sign In
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="role"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value == "member") {
                document.getElementById("category").disabled = true;
                document.getElementById("location").disabled = true;
            } else {
                document.getElementById("category").disabled = false;
                document.getElementById("location").disabled = false;
            }
        });
    });

    $(document).ready(function() {
        loadcategory();
        loadlocation();
    });

    function loadcategory() {
        const data = {
            action: "getcategory"
        };
        fetch("db.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById("category").innerHTML = html;
            });
    }

    function loadlocation() {
        const data = {
            action: "getlocation"
        };
        fetch("db.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById("location").innerHTML = html;
            });
    }
</script>

<?php include 'footer.php'; ?>      