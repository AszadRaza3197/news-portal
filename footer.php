<!-- Footer Start -->
<?php
$conn = mysqli_connect("localhost", "root", "", "news");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<footer class="container-fluid bg-dark text-white-50 pt-5 px-sm-3 px-md-5 mt-5">
    <div class="row py-4">
        <!-- Column 1: Get In Touch -->
        <div class="col-lg-4 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Get In Touch</h5>
            <p class="font-weight-medium mb-2">
                <i class="fa fa-map-marker-alt mr-2 text-primary"></i>Hyderabad, India
            </p>
            <p class="font-weight-medium mb-2">
                <i class="fa fa-phone-alt mr-2 text-primary"></i>+91-7970350***
            </p>
            <p class="font-weight-medium mb-4">
                <i class="fa fa-envelope mr-2 text-primary"></i>raszad75@gmail.com
            </p>
            <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">Follow Us</h6>
            <div class="d-flex justify-content-start">
                <a class="btn btn-lg btn-secondary btn-lg-square mr-2 text-white"
                    href="https://www.linkedin.com/in/aszad-raza"
                    target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Column 2: Popular News -->
        <?php

        $popular_sql = " SELECT n.nid, n.heading, n.posted_date, c.category,
        COUNT(l.like_id) AS total_likes FROM news_table n 
        LEFT JOIN category c ON n.n_category_id = c.cat_id LEFT JOIN `likes` l ON n.nid = l.news_id 
        WHERE n.is_publish = 1 AND n.is_delete = 0 GROUP BY  n.nid, n.heading, n.posted_date, c.category 
        ORDER BY total_likes DESC LIMIT 3
";

        $popular_result = mysqli_query($conn, $popular_sql);

        ?>

        <!-- Column 2: Popular News -->
        <div class="col-lg-4 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">
                Popular News
            </h5>
            <?php foreach ($popular_result as $popular) { ?>
                <div class="mb-3">
                    <div class="mb-2 d-flex align-items-center">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                            href="index.php?catcat=<?php echo urlencode($popular['category']); ?>">
                            <?php echo $popular['category']; ?>
                        </a>
                        <a class="text-white-50 small" href="#">
                            <?php echo date("M d, Y", strtotime($popular['posted_date'])); ?>
                        </a>
                    </div>
                    <a class="small text-light text-uppercase font-weight-medium text-decoration-none"
                        href="db.php?singlenews2=<?php echo $popular['nid']; ?>">

                        <?php echo $popular['heading']; ?>
                    </a>
                </div>
            <?php } ?>

        </div>

        <!-- Column 3: Categories -->
        <?php

        $category_sql = "SELECT * FROM category ORDER BY category ASC";
        $category_result = mysqli_query($conn, $category_sql);
        ?>

        <!-- Column 3: Categories -->
        <div class="col-lg-4 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Categories</h5>
            <div class="m-n1">
                <?php
                foreach ($category_result as $category) {
                ?>

                    <a href="index.php?catcat=<?php echo urlencode($category['category']); ?>"
                        class="btn btn-sm btn-secondary m-1 text-white">
                        <?php echo $category['category']; ?>
                    </a>

                <?php
                }
                ?>

            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>