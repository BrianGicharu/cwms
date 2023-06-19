<?php

include_once("config.php");
include_once("common_functions.php");

// Function to book a car was service
function book()
{
    global $dbh;
    $ptype = $_POST['packagetype'];
    $vtype = $_POST['vehicletype'];
    $wpoint = $_POST['washingpoint'];
    $fname = $_POST['fname'];
    $mobile = $_POST['contactno'];
    $date = $_POST['washdate'];
    $time = $_POST['washtime'];
    $message = $_POST['message'];
    $status = 'New';
    $bno = mt_rand(100000000, 999999999);
    $sql = "INSERT INTO tblcarwashbooking(bookingId,packageType,vehicleType,carWashPoint,fullName,mobileNumber,washDate,washTime,message,status) VALUES
                                        (:bno,:ptype,:vtype,:wpoint,:fname,:mobile,:date,:time,:message,:status)";
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
        die(header("Location:./washing-plans.php"));
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}

// Function to fetch a table
function getTable(?string $table_name): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare("SELECT * FROM $table_name WHERE 1;");
        $stmt->execute();
    } catch (PDOException $ex) {
        return [["Error: " => $ex->getMessage()]];
    }
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Function to get table columns
function getTableCol(string $col, string $table_name): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare("SELECT id, $col FROM $table_name WHERE 1;");
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return ["Error: " => $ex->getMessage()];
    }
}

// Function to get carwash service price
function getServPrice(?string $bookId): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare(
            "SELECT id, fullName, (SELECT vehicle_name FROM tblvehicletypes WHERE id = vehicleType LIMIT 1) AS vehicle,
                (SELECT
                    CASE
                        WHEN vehicle LIKE 'suv' THEN `suv`
                        WHEN vehicle LIKE 'saloon' THEN `saloon`
                        ELSE NULL
                    END
                FROM tblwashservice  WHERE id = packageType) AS price
            FROM `tblcarwashbooking`
            WHERE bookingId LIKE :bookId LIMIT 1;"
        );

        $stmt->bindValue(':bookId', $bookId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return ['Error' => $ex->getMessage()];
    }
    return ["ERROR" =>"Unknown Error!"];
}

// Function to get a table record
function getRecord(string $table, string $col, int $id)
{
    global $dbh;
    try {
        $stmt = $dbh->prepare("SELECT $col FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        return $result;
    } catch (PDOException $ex) {
        return ["Error" => $ex->getMessage()];
    }
}

// Function to get table wash service
function getPrice(string $table, string $col, int $serviceType): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare("SELECT $col FROM $table WHERE service = ?");
        $stmt->execute([$serviceType]);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    } catch (PDOException $ex) {
        return ["Error" => $ex->getMessage()];
    }
}

// Function to add a records to transaction table
function addTransaction($amount, $currency = "KES")
{
    $randIdNum = randId("T");
    $date = time();
    $response = "NO RESPONSE";

    global $dbh;
    try {
        $sql = "INSERT INTO `transactions`(`paymentId`, `paymentTypeId`, `customerId`, `customerName`, `customerEmail`, 
                `customerPhone`, `paymentType`, `cardNo`, `cvv`, `transactionResponse`, `amount`, `date`, `currency`, `status`, 
                `description`, `address`) 
                VALUES
                (:paymentId,:paymentTypeId,:customerId,:customerName,:customerEmail,:customerPhone,:paymentType,:cardNo,
                :cvv,:transactionResponse,:amount,:date,:currency,:status,:description,:address);";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":paymentId", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":paymentTypeId", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":customerId", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":customerName", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":customerEmail", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":customerPhone", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":paymentType", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":cardNo", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":cvv", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":transactionResponse", $response, PDO::PARAM_STR);
        $stmt->bindParam(":amount", $randIdNum, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":currency", $currency, PDO::PARAM_STR);
        $stmt->bindParam(":status", $currency, PDO::PARAM_STR);
        $stmt->bindParam(":description", $currency, PDO::PARAM_STR);
        $stmt->bindParam(":address", $currency, PDO::PARAM_STR);
    } catch (PDOException $ex) {
        return ["Error" => $ex->getMessage()];
    }
}

// Function to get the transaction table
function getTransactionTable(): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare(
            "SELECT `paymentId`, `customerName`, `serviceType`, `customerEmail`, 
            `customerPhone`, `paymentType`, `transactionResponse`, `amount`, `date`, `status`, 
            `description`, `address` FROM `transactions` WHERE 1;"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return [["Error: " => $ex->getMessage()]];
    }
}

// Function to get paid orders only
function getPaidBookings()
{
    global $dbh;
    try {
        $stmt = $dbh->prepare(
            "SELECT 
                bookingId, 
                (SELECT service FROM tblwashservice WHERE id = packageType) AS servicePackage,
                fullName, 
                (SELECT vehicle_name FROM tblvehicletypes WHERE id = vehicleType) AS vehicle,
                CONCAT('+254', mobileNumber) AS contactInfo,
                (SELECT paymentType FROM tblpaymenttypes WHERE id LIKE paymentMode) AS payment, 
                txnNumber, paidAmount, lastUpdationDate AS updatedOn
                FROM tblcarwashbooking 
                WHERE status LIKE '%Completed%' AND paidAmount IS NOT NULL"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return [["Error: " => $ex->getMessage()]];
    }
}

// testing purposes only
function getDistinct($col, $table): array
{
    global $dbh;
    try {
        $stmt = $dbh->prepare("SELECT DISTINCT ? FROM $table;");
        $stmt->execute([$col]);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return [["Error: " => $ex->getMessage()]];
    }
}
