<?php
include('express-stk.php');
include('../../settings/api_settings.php');
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Lato:400,100,300,700,900);
        @import url(https://fonts.googleapis.com/css?family=Source+Code+Pro:400,200,300,500,600,700,900);

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }

        * {
            box-sizing: border-box;
        }

        html {
            background-color: #171A3D;
            font-family: 'Lato', sans-serif;
        }

        .price h1 {
            font-weight: 300;
            color: #18C2C0;
            letter-spacing: 2px;
            text-align: center;
        }

        .card {
            margin-top: 30px;
            margin-bottom: 30px;
            width: 520px;
        }

        .card .row {
            width: 100%;
            padding: 1rem 0;
            border-bottom: 1.2px solid #292C58;
        }

        .card .row.number {
            background-color: #242852;
        }

        .cardholder .info,
        .number .info {
            position: relative;
            margin-left: 40px;
        }

        .cardholder .info label,
        .number .info label {
            display: inline-block;
            letter-spacing: 0.5px;
            color: #8F92C3;
            width: 40%;
        }

        .cardholder .info input,
        .number .info input {
            display: inline-block;
            width: 55%;
            background-color: transparent;
            font-family: 'Source Code Pro';
            border: none;
            outline: none;
            margin-left: 1%;
            color: white;
        }

        .cardholder .info input::placeholder,
        .number .info input::placeholder {
            font-family: 'Source Code Pro';
            color: #444880;
        }

        #cardnumber,
        #cardnumber::placeholder {
            letter-spacing: 2px;
            font-size: 16px;
        }

        .button button {
            font-size: 1.2rem;
            font-weight: 400;
            letter-spacing: 1px;
            width: 520px;
            background-color: #18C2C0;
            border: none;
            color: #fff;
            padding: 18px;
            border-radius: 5px;
            outline: none;
            cursor: pointer;
            transition: background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .button button:hover {
            background-color: #15aeac;
        }

        .button button:active {
            background-color: #139b99;
        }

        .button button i {
            font-size: 1.2rem;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
            <div class="price">
                <h1>Awesome, that's KES 100</h1> <!-- For testing purposes, we have added the amount manually. This should proceed from your website -->
            </div>
            <div class="card__container">
                <div class="card">
                    <div class="row">
                        <img src="mpesa.png" style="width:30%;margin: 0 35%;">
                        <p style="color:#8F92C3;line-height:1.7;">1. Enter the <b>phone number</b> and press "<b>Confirm and Pay</b>"</br>2. You will receive a popup on your phone. Enter your <b>MPESA PIN</b></p>
                        <?php if ($errmsg != '') : ?>
                            <p style=" background: #cc2a24;padding: .8rem;color: #ffffff;"><?php echo $errmsg; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="row number">
                        <div class="info">
                            <input type="hidden" name="orderNo" value="#O2JDI2I3R" /> <!-- For testing purposes, we have added the value. This should proceed from your website -->
                            <label for="cardnumber">Phone number</label>
                            <input id="cardnumber" type="text" name="phone_number" maxlength="10" placeholder="0700000000" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="button">
                <button type="submit"><i class="ion-locked"></i> Confirm and Pay</button>
            </div>
        </form>
        <p style="color:#8F92C3;line-height:1.7;margin-top:5rem;">Copyright 2022 | All Rights Reserved | Made by MediaForce</p>
    </div>
</body>

</html>
</pre>
<p>&nbsp;</p>
<p><strong>II. Express STK API file</strong></p>
<p>When the customer enters the phone number and presses SEND, the POST request will be handled by an external PHP file in the API folder: <strong>express-stk.php</strong><strong>. </strong></p>
<pre class="EnlighterJSRAW" data-enlighter-language="php">
    <?php
    session_start();

    $errors  = array();
    $errmsg  = '';

    $config = array(
        "env"              => "sandbox",
        "BusinessShortCode" => "174379",
        "key"              => $consumerKey,
        "secret"           => $consumerSecret,
        "username"         => "apitest",
        "TransactionType"  => "CustomerPayBillOnline",
        "passkey"          => "", //Enter your passkey here
        "CallBackURL"      => "https://f899-41-90-64-220.ngrok.io/mpesa/callback.php", //When using localhost, Use Ngrok to forward the response to your Localhost
        "AccountReference" => "CompanyXLTD",
        "TransactionDesc"  => "Payment of X",
    );



    if (isset($_POST['phone_number'])) {

        $phone = $_POST['phone_number'];
        $orderNo = $_POST['orderNo'];
        $amount = 1;

        $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
        $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;



        $access_token = ($config['env']  == "live") ? "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" : "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $credentials = base64_encode($config['key'] . ':' . $config['secret']);

        $ch = curl_init($access_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        $token = isset($result->{'access_token'}) ? $result->{'access_token'} : "N/A";

        $timestamp = date("YmdHis");
        $password  = base64_encode($config['BusinessShortCode'] . "" . $config['passkey'] . "" . $timestamp);

        $curl_post_data = array(
            "BusinessShortCode" => $config['BusinessShortCode'],
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => $config['TransactionType'],
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => $config['BusinessShortCode'],
            "PhoneNumber" => $phone,
            "CallBackURL" => $config['CallBackURL'],
            "AccountReference" => $config['AccountReference'],
            "TransactionDesc" => $config['TransactionDesc'],
        );

        $data_string = json_encode($curl_post_data);

        $endpoint = ($config['env'] == "live") ? "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest" : "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response     = curl_exec($ch);
        curl_close($ch);

        $result = json_decode(json_encode(json_decode($response)), true);

        if (!preg_match('/^[0-9]{10}+$/', $phone) && array_key_exists('errorMessage', $result)) {
            $errors['phone'] = $result["errorMessage"];
        }

        if ($result['ResponseCode'] === "0") {         //STK Push request successful

            $MerchantRequestID = $result['MerchantRequestID'];
            $CheckoutRequestID = $result['CheckoutRequestID'];

            //Saves your request to a database
            $conn = mysqli_connect("localhost", "root", "", "mpesa");

            $sql = "INSERT INTO `orders`(`ID`, `OrderNo`, `Amount`, `Phone`, `CheckoutRequestID`, `MerchantRequestID`) VALUES ('','" . $orderNo . "','" . $amount . "','" . $phone . "','" . $CheckoutRequestID . "','" . $MerchantRequestID . "');";

            if ($conn->query($sql) === TRUE) {
                $_SESSION["MerchantRequestID"] = $MerchantRequestID;
                $_SESSION["CheckoutRequestID"] = $CheckoutRequestID;
                $_SESSION["phone"] = $phone;
                $_SESSION["orderNo"] = $orderNo;

                header('location: confirm-payment.php');
            } else {
                $errors['database'] = "Unable to initiate your order: " . $conn->error;;
                foreach ($errors as $error) {
                    $errmsg .= $error . '<br />';
                }
            }
        } else {
            $errors['mpesastk'] = $result['errorMessage'];
            foreach ($errors as $error) {
                $errmsg .= $error . '<br />';
            }
        }
    }

    ?>;