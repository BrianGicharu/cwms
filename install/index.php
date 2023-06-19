<?php

include_once("../includes/config.php");

if (file_exists(("../appConfig.json"))) {
    $config = json_decode(file_get_contents("../appConfig.json"), true);
    $db = $config['database'];
}

// initialize pdo object
try {
    $conn = new PDO("mysql:host=" . $config['host'] . ";dbname=" . "INFORMATION_SCHEMA", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    die(error_log("Error: " . $e->getMessage()));
}
// Select from information schema.schemata to check if db exists
$stmt = $conn->prepare("SELECT `SCHEMA_NAME` FROM INFORMATION_SCHEMA.SCHEMATA WHERE `SCHEMA_NAME` LIKE :dbname");
$stmt->bindParam(':dbname', $db);
$stmt->execute();
$result =  $stmt->fetch(PDO::FETCH_COLUMN);
if ($result) {
    $conn = null;
    die(header("Location:../index.php"));
}

if (isset($_POST['submit'])) {
    // Install db from dump file
    if (!$result) {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec('SET FOREIGN_KEY_CHECKS=0;');
        $conn->exec(file_get_contents("../sql/db/cwmsdb.sql"));
        $conn->exec('SET FOREIGN_KEY_CHECKS=1;');

        $conn->exec("USE cwmsdb;");

        // Insert user & company info
        $company = $_POST['bsname'];
        $email = $_POST['bsemail'] ?? "";
        $address = $_POST['bsaddress'];
        $logo = $_POST['bslogo'] ?? "";

        $user = $_POST['username'];
        $passWd = md5($_POST['password']);
        $uDate = time();

        $stmt = $conn->prepare("INSERT INTO `businessinfo`(`businessName`, `email`, `address`,`logo`)VALUES(:company, :email, :address,:logo);");
        $stmt->bindParam(":company", $company, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":address", $address, PDO::PARAM_STR);
        $stmt->bindParam(":logo", $logo, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = null;

        $stmt = $conn->prepare("INSERT INTO `admin`(`UserName`, `Password`, `updationDate`)VALUES(:uname, :pwd, :udate);");
        $stmt->bindParam(":uname", $user, PDO::PARAM_STR);
        $stmt->bindParam(":pwd", $passWd, PDO::PARAM_STR);
        $stmt->bindParam(":udate", $uDate, PDO::PARAM_STR);
        $stmt->execute();

        // login now
        if (!isset($SESSION)) {
            session_start();

            $sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
            $query = $conn->prepare($sql);
            $query->bindParam(':uname', $user, PDO::PARAM_STR);
            $query->bindParam(':password', $passWd, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                $_SESSION['alogin'] = $_POST['username'];
                die(header("Location:../admin/dashboard.php"));
            } else {
                echo "<script>alert('Experienced an error creating a user profile');</script>";
            }
        }
    } else {
        die(header("Location:../index.php"));
    }
    die(header("Location:../index.php"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Car Was System</title>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
        body {
            background-color: #999;
        }

        nav {
            padding-top: 5px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .list-item {
            color: wheat;
            background-color: #000;
            list-style: none;
            text-decoration: none;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 4px;
            padding-left: 8px;
            padding-right: 8px;
            margin-right: 5px;
        }

        .list-item:hover {
            color: chartreuse;
            background-color: #999;
        }

        nav>ul>li>a>span {
            text-decoration: none;
            color: wheat;
        }

        #form {
            background-color: #ccc;
            border: 2px solid transparent;
            padding: 10px;
            border-radius: 5px;
        }

        #t_and_c {
            font-size: 9pt;
        }

        #install-modal {
            font-size: 20pt !important;
            color: white;
            position: fixed;
            padding: 10px;
            top: 25%;
            left: 35%;
            right: 35%;
            width: 30%;
            height: 25%;
            background-color: #555;
            border-radius: 2px;
        }

        #install-modal>h4 {
            color: wheat;
        }
    </style>
</head>

<body>

    <!-- Start of nav bar -->
    <nav class="text-white bg-dark d-flex justify-content-between fixed-top">

        <div>
            <h3 class="text-white">
                <i class="fa fa-cogs"></i>
                Install page
            </h3>
        </div>

        <ul class="d-flex nav-ul">
            <li class="list-item">
                <a href="">
                    <span>
                        <i class="fa fa-home"></i>
                        Home
                    </span>
                </a>
            </li>
            <li class="list-item">
                <a href="">
                    <span>
                        <i class="fa fa-info-circle"></i>
                        About
                    </span>
                </a>
            </li>
            <li class="list-item">
                <a href="../docs/install_manual.php">
                    <span>
                        <i class="fa fa-cog"></i>
                        Installation DOCS
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End of Nav bar -->

    <div class="container" style="height:8vh;"></div>

    <!-- Body start -->
    <div class="container">
        <div class="container text-center">
            <h3>
                Welcome, Guest
            </h3>
            <h5 class="bg-dark" style="border-radius:20px; border:1px solid transparent; padding:4px;color:yellowgreen;">
                Thank you for purchasing the product. <br>
                To start using the software, please go through the installation wizard inorder to setup the system database<br>
                and configure software infrastructural-critical variables
            </h5>
        </div>
        <div class="container d-flex justify-content-center">
            <form action="#" class="col-5 justify-content-center" id="form" method="POST">
                <p class="text-center text-white">
                <h5>
                    <span>
                        <i class="fas fa-cog"></i>
                        Setup
                    </span>
                </h5>
                </p>
                <h6>
                    Business Information
                </h6>
                <p>
                <div class="form-row  justify-content-center">
                    <div class="input-group">
                        <button class="btn btn-dark" disabled>
                            <i class="fas fa-building"></i>
                        </button>
                        <input type="text" class="form-control" name="bsname" id="bsname" placeholder="business name i.e (Max-cars auto wash)" required>
                    </div>
                </div>
                </p>

                <p>
                <div class="form-row  justify-content-center">
                    <div class="input-group">
                        <button class="btn btn-dark" disabled>
                            <i class="fas fa-envelope"></i>
                        </button>
                        <input type="email" class="form-control" name="bsemail" id="bsemail" placeholder="business email" required>
                    </div>
                </div>
                </p>

                <p>
                <div class="form-row  justify-content-center">
                    <div class="input-group">
                        <button class="btn btn-dark" disabled>
                            <i class="fas fa-address-book"></i>
                        </button>
                        <input type="text" class="form-control" name="bsaddress" id="bsaddress" placeholder="business address" required>
                    </div>
                </div>
                </p>

                <p>
                <div class="form-row  justify-content-center">
                    <div class="input-group">
                        <label for="bslogo">business logo (optional)</label>
                        <input type="file" class="form-control-file" name="bslogo">
                    </div>
                </div>
                </p>
                <hr>
                <h6>
                    Adminstrator
                </h6>
                <p>
                <div class="form-row justify-content-center">
                    <div class="input-group">
                        <button type="button" class="btn btn-dark" disabled>
                            <i class="fa fa-user"></i>
                        </button>
                        <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                    </div>
                </div>
                </p>

                <p>
                <div class="form-row justify-content-center">
                    <div class="input-group">
                        <button class="btn btn-dark" type="button" disabled>
                            <i class="fa fa-key"></i>
                        </button>
                        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" required placeholder="password">
                        <button type="button" class="btn btn-dark" id="showPwd1">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                </p>

                <p>
                <div class="form-row justify-content-center">
                    <div class="input-group">
                        <button class="btn btn-dark" type="button" disabled>
                            <i class="fa fa-key"></i>
                        </button>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" autocomplete="new-password" required placeholder="confirm password">
                        <button type="button" class="btn btn-dark" id="showPwd2">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                </p>

                <p>
                <div class="d-flex" id="t_and_c">
                    <input type="checkbox" name="acceptTerms" id="acceptTerms" value="accept terms and conditions">
                    &nbsp;
                    Accept terms and conditions
                </div>
                </p>

                <p>
                <div class="form-row justify-content-center">
                    <div class="input-group justify-content-end">
                        <button type="submit" class="btn btn-success" name="submit" id="submit" disabled data-toggle="modal" data-target="#install-modal">
                            install
                        </button>
                    </div>
                </div>
                </p>

            </form>
        </div>
    </div>
    <!-- Body end -->
    <div class="modal" id="install-modal">
        <h4>
            Installing System...
        </h4>
        <p>
            <i class="fa fa-cogs fa-spin"></i>
            <i class="fa fa-cog fa-spin"></i>
        </p>
        <div class="container d-flex justify-content-between" style="font-size:8pt;">
            <p>
                please wait.....
            </p>
            <button type="button" class="btn btn-danger" id="quitInstall" disabled>
                close
            </button>
        </div>
    </div>
    <footer class="footer d-flex justify-content-center text-white">
        <div class="container">
            &copy; All Rights Reserved 2023 PCLKE Kenya
        </div>
    </footer>
    <script>
        function valuesEmpty(arr) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].val() === "") {
                    return true;
                }
            }
            return false;
        }

        $('#submit').on('click', () => {
            setTimeout(function() {
                if ($("#quitInstall").attr('disabled', true)) {
                    $("#quitInstall").removeAttr('disabled')
                    $('#install-modal').modal('hide');
                    location.href = "../index.php"
                } else {
                    $("#quitInstall").attr('disabled', true)
                }
            }, 60000);
        })

        $("#showPwd1").on('click', () => {
            $("#password").attr('type', $("#password").attr('type') === 'password' ? 'text' : 'password');
            $("#showPwd1>i").toggleClass('fa-eye fa-eye-slash');
        });

        $("#showPwd2").on('click', () => {
            $("#confirmPassword").attr('type', $("#confirmPassword").attr('type') === 'password' ? 'text' : 'password');
            $("#showPwd2>i").toggleClass('fa-eye-slash fa-eye');
        });


        $("#acceptTerms").on('click', () => {
            if (
                $("#acceptTerms").prop('checked') &&
                (
                    $("#password").val() === $("#confirmPassword").val()) &&
                (
                    !valuesEmpty([$("#bsname"), $("#bsemail"), $("#bsaddress"), $("#username"), $("#password"), $("#confirmPassword")])
                )) {
                $("#submit").attr("title", "submit")
                $("#submit").attr('disabled', false)
            } else {
                $("#submit").attr("title", "Ensure that the passwords match")
                $("#submit").attr('disabled', true)
            }
        })
    </script>
</body>

</html>