<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="footer-contact">
                    <h2>Get In Touch</h2>
                    <?php
                    $sql = "SELECT * from tblpages where type='contact'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result) {
                    ?>

                        <p><i class="fa fa-map-marker-alt"></i><?php echo $result->detail; ?></p>
                        <p><i class="fa fa-phone-alt"></i>+<?php echo $result->phoneNumber; ?></p>
                        <p><i class="fa fa-envelope"></i><?php echo $result->emailId; ?></p>

                    <?php } ?>
                    <div class="footer-social">
                        <a class="btn" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="footer-link">
                    <h2>Popular Links</h2>
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="washing-plans.php">Washing Plans</a>
                    <a href="location.php">Washing Points</a>
                    <a href="contact.php">Contact Us</a>
                </div>
            </div>

        </div>
    </div>
    <div class="container copyright">
        <div class="copyrights">
            <p>&copy;<?php echo date('Y'); ?>
                <?php
                $q = "SELECT businessName FROM `businessInfo`;";
                $stmt = $dbh->query($q);
                echo "PCLKE Kenya All Rights Reserved <i style='color:pink;'>0725200738</i> &nbsp;| <a href='#'>{$stmt->fetch(PDO::FETCH_COLUMN)}</a>";
                ?>
            </p>
        </div>
    </div>
</div>
<!-- Footer End --> <!-- Back to top button -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- Pre Loader -->
<div id="loader" class="show">
    <div class="loader"></div>
</div>