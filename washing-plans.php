<?php //error_reporting(0);
include_once('includes/config.php');
include_once('includes/functions.php');

if (isset($_POST['book'])) {
    $ptype = $_POST['packagetype'];
    $vtype = $_POST['packagetype'];
    $wpoint = $_POST['washingpoint'];
    $fname = $_POST['fname'];
    $mobile = $_POST['contactno'];
    $date = $_POST['washdate'];
    $time = $_POST['washtime'];
    $message = $_POST['message'];
    $status = 'New';
    $bno = mt_rand(100000000, 999999999);
    $sql = "INSERT INTO tblcarwashbooking(bookingId,packageType, vehicleType,carWashPoint,fullName,mobileNumber,washDate,washTime,message,status) VALUES(:bno,:ptype,:vtype,:wpoint,:fname,:mobile,:date,:time,:message,:status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bno', $bno, PDO::PARAM_STR);
    $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
    $query->bindParam(':vtype', $vtype, PDO::PARAM_STR);
    $query->bindParam(':wpoint', $wpoint, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':date', $date, PDO::PARAM_STR);
    $query->bindParam(':time', $time, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {

        echo '<script>alert("Your booking done successfully. Booking number is "+"' . $bno . '")</script>';
        echo "<script>window.location.href ='washing-plans.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CWMS | Washing Plans</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

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

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Washing Plan</h2>
                </div>
                <div class="col-12">
                    <a href="index.php">Home</a>
                    <a href="washing-plans.php">Price</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


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
                    // $test = sendQuery();
                    // echo count($test);
                    // foreach($test as $t){
                    //     echo json_encode($t)."<br>";
                    // }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Price End -->

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
                            <select name="vehicletype" required class="form-control">
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
                                foreach ($results as $result) { ?>
                                    <option value="<?php echo htmlentities($result->id); ?>">
                                        <?php echo htmlentities($result->washingPointName); ?>
                                        (<?php echo htmlentities($result->washingPointAddress); ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </p>
                        <p>
                            <input type="text" name="fname" class="form-control" required placeholder="Full Name">
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


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>