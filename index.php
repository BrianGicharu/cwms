<?php
session_start();

if (!file_exists("appConfig.json"))
    die(header("Location:./install/"));

$dsn = 'mysql:host=127.0.0.1;dbname=INFORMATION_SCHEMA';

try {
    $pdo = new PDO($dsn, "root", "");
} catch (PDOException $e) {
    session_unset();
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$connectConfig = json_decode(file_get_contents("appConfig.json"));

if (
    ($pdo->query("SELECT COUNT(*) FROM SCHEMATA WHERE SCHEMA_NAME = '$connectConfig->database'"))->fetchColumn() > 0
) {
    $pdo = null;

    include_once('includes/config.php');
    include_once('includes/functions.php');

    if (isset($_POST['book'])) {
        book();
        /*
    // Assert that customer has paid the service fee before inserting data
    $payInfo = payWithMPesaSTK($_POST['contactno'], 2000);
    echo json_encode($payInfo);
    if ($payInfo['ResponseCode'] === MPESA_PAY_SUCCESS) {
        book();
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_INSUFFICIENT_FUNDS) {
        echo "<script>console.log('Insufficient Funds on MPesa no.')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_INVALID_TRANSACTION) {
        echo "<script>console.log('Invalid Transaction')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_AUTH_FAILURE) {
        echo "<script>console.log('Authentication Failed.')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_INVALID_AMOUNT) {
        echo "<script>console.log('Invalid Amount')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_INVALID_PAYBILL_NO) {
        echo "<script>console.log('Invalid PayBill Number')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAY_INVALID_DEBIT_ACC) {
        echo "<script>console.log('Debit Account Invalid')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_INVALID_PHONE_NUMBER) {
        echo "<script>console.log('Invalid Phone Number.')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_DUPLICATE_PAYMENT_REQUEST) {
        echo "<script>console.log('Payment Request is already being processed')</script>";
    } else if ($payInfo['ResponseCode'] === MPESA_PAYMENT_REQUEST_ERROR) {
        echo "<script>console.log('Failed to process request')</script>";
    } else {
        echo "<script>console.log('Unknown Error!')</script>";
    }
    */
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>
            <?php
            $q = "SELECT businessName FROM `businessInfo`;";
            $stmt = $dbh->query($q);
            $bsName = $stmt->fetch(PDO::FETCH_COLUMN);
            echo "{$bsName} | Home Page";
            ?>
        </title>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once('includes/header.php'); ?>

        <div class="container">
            <h1>
                <div>
                    <?php
                    $dir = "./img/";
                    $images = scandir($dir);
                    $images = array_diff($images, array(".", ".."));
                    $image = $images[array_rand($images)];
                    ?>
                    <img src="<?php echo $dir . $image; ?>" alt="Image" height="auto" width="1080">
                </div>
            </h1>
        </div>

        <!-- About Start -->
        <div class="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-img">
                            <img src="./img/single.jpg" alt="Image" id="randImg">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-header text-left">
                            <p>About Us</p>
                            <h2>
                                <?php echo  ucfirst(strtolower($bsName . " CAR WASH")); ?>
                            </h2>
                        </div>
                        <div class="about-content">
                            <p>
                                <?php echo  $bsName; ?> car wash is a mobile car valeting service covering nanyuki town.
                                With over 10 years of experience working with the highest-quality products and brands, we
                                guarantee the highest standards of care within the industry.

                                The amount of care and attention given to your vehicle will be critical in how long its
                                parts, components, interior, and exterior last. Having it valeted regularly by our
                                experienced and talented team will help to increase its lifespan and keep it gleaming for
                                years to come. If you love your car, then choosing benjy car wash is the only option that
                                makes sense.

                                Our services are just a booking away from giving your car a glamorous look it deserves.
                                We supply everything, you don’t have to worry about a thing, everything is hand washed and
                                finished with the finest of products.

                                Simply place your order and we will do the rest.
                            </p>
                            <ul>
                                <li><i class="far fa-check-circle"></i>Seats washing</li>
                                <li><i class="far fa-check-circle"></i>Vacuum cleaning</li>
                                <li><i class="far fa-check-circle"></i>Interior wet cleaning</li>
                                <li><i class="far fa-check-circle"></i>Window wiping</li>
                            </ul>
                            <a class="btn btn-custom" href="about.php">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Service Start -->
        <div class="service">
            <div class="container">
                <div class="section-header text-center">
                    <p>What We Do?</p>
                    <h2>Premium Washing Services</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-car-wash-1"></i>
                            <h3>Exterior Washing</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-car-wash"></i>
                            <h3>Interior Washing</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-vacuum-cleaner"></i>
                            <h3>Vacuum Cleaning</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-seat"></i>
                            <h3>Seats Washing</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-car-service"></i>
                            <h3>Window Wiping</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-car-service-2"></i>
                            <h3>Wet Cleaning</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-car-wash"></i>
                            <h3>Oil Changing</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="service-item">
                            <i class="flaticon-brush-1"></i>
                            <h3>Brake Reparing</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->

        <!-- Price Start -->
        <div class="price">
            <div class="container">
                <div class="section-header text-center">
                    <p>Washing Plan</p>
                    <h2>Choose Your Plan</h2>
                </div>

                <div class="container text-center">
                    <h5>
                        Our Pricing
                    </h5>
                    <div class="justify-content-center d-flex">
                        <table id="my-table">
                            <?php
                            $wash_services = getTable("tblwashservice");
                            if (count($wash_services) > 0) { ?>
                                <th>
                                    <h4>SERVICE</h4>
                                </th>
                                <th>
                                    <h4>SALOON (KSHS)</h4>
                                </th>
                                <th>
                                    <h4>SUV 4*4 (KSHS)</h4>
                                </th>
                                <?php foreach ($wash_services as $service) { ?>
                                    <tr id=<?php $service; ?>>
                                        <?php
                                        foreach ($service as $key => $column) {
                                            if ($key === 'id') {
                                            } else {
                                                echo "<td>$column</td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="container" style="padding:20px;">
                        <button type="button" class="btn btn-custom" id="bookNow" data-toggle="modal" data-target="#myModal">
                            Book Now
                        </button>
                    </div>
                    <div class="container">
                        <?php
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Price End -->

        <!-- Footer Start -->
        <?php include_once('includes/footer.php'); ?>

        <!--Model-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <?php
                $services = getTableCol('service', 'tblwashservice');
                // $services = getTable("tblwashservice");
                ?>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Car Wash Booking</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <p>
                                <select name="packagetype" required class="form-control">
                                    <option value="">Package Type</option>
                                    <?php
                                    foreach ($services as $record) { ?>
                                        <option value="<?php echo $record['id']; ?>">
                                            <?php echo $record['service']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </p>
                            <p>
                                <select name="vehicletype" required class="form-control" id="packageSelect">
                                    <option value="">Vehicle Type</option>
                                    <?php
                                    $vehicles = getTable('tblvehicletypes');
                                    foreach ($vehicles as $vehicle) { ?>
                                        <option value="<?php echo $vehicle['id']; ?>">
                                            <?php echo $vehicle['vehicle_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </p>
                            <p>
                                <select name="washingpoint" required class="form-control">
                                    <option value="">Select Washing Point</option>
                                    <?php $sql = "SELECT * from tblwashingpoints";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($results as $result) : ?>
                                        <option value="<?php echo htmlentities($result->id); ?>">
                                            <?php echo htmlentities($result->washingPointName); ?>
                                            (<?php echo htmlentities($result->washingPointAddress); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <input type="text" name="fname" class="form-control" pattern="[a-zA-Z]+" required placeholder="Full Name">
                            </p>
                            <p>
                                <input type="text" name="contactno" class="form-control" pattern="[0-9]{10}" title="10 numeric characters only" required placeholder="Mobile No.">
                            </p>
                            <p>
                                Wash Date <br /><input type="date" name="washdate" required class="form-control">
                            </p>
                            <p>
                                Wash Time <br /><input type="time" name="washtime" required class="form-control">
                            </p>
                            <p>
                                <textarea name="message" class="form-control" placeholder="Message if any"></textarea>
                            </p>
                            <p>
                            <div class="d-flex justify-content-between">
                                <span>
                                    <input type="radio" name="payOption" value="mpesa">
                                    <!-- <i class="fas fa-mobile-signal"></i> -->
                                    MPesa
                                </span>
                                <span>
                                    <input type="radio" name="payOption" value="cash">
                                    <i class="fa fa-dollar-sign"></i>
                                    Cash
                                </span>
                                <span>
                                    <input type="radio" name="payOption" value="debit" disabled>
                                    <i class="fa fa-credit-card"></i>
                                    Debit/ ATM Card
                                </span>
                            </div>
                            </p>
                            <p>
                                <input type="submit" class="btn btn-custom" name="book" value="Book Now">
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

    </html>

<?php
} else {
    session_unset();
    die(header("Location:./install/index.php"));
}
?>