<?php
/*
 * How to verify Mollie API Payments in a webhook.
 *
 * See: https://docs.mollie.com/guides/webhooks
 */
try {
    /*
     * Initialize the Mollie API library with your API key.
     *
     * See: https://www.mollie.com/dashboard/developers/api-keys
     */
    require "mollie-api-php-master/initialize.php";
    /*
     * Retrieve the payment's current state.
     */
    $payment = $mollie->payments->get($_POST["id"]);
    $orderId = $payment->metadata->order_id;
    $userid = $payment->metadata->user_id;

//    Haalt gegevens uit de database van de ingelogde gebruiker
    $conn = dbconect();
    $userquery = mysqli_query($conn, "SELECT * FROM client WHERE clientID='$userid'") or die('Geen overeenkomst');

    $row = mysqli_fetch_array($userquery);


    $naam = $row['firstname'];
    $eMail = $row['eMail'];
    $adres = $row ['adres'];
    $postcode = $row ['postcode'];
    $plaats = $row ['plaats'];

    mysqli_close($conn);
     /* Update the order in the database.
     */
    database_write_payment($orderId, $payment->status);
    if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
        // stuur hier de mail
        $to = $eMail;
        $subject = "Orderid: " . $orderId .".";
        $headers = 'From: wwi_site@yahoo.com' . "\r\n" . "MIME-Version: 1.0" . "\r\n" .
            "Content-type:text/html;charset=UTF-8" . "\r\n";

        $htmlContent = '
                                    <html> 
                                    <head> 
                                        <title>'. $naam . ' uw WWI bestelling ' . $orderId . ' is voltooid</title> 
                                    </head> 
                                    <body> 
                                        <h1>Dankjewel voor uw bestelling! </h1> 
                                           <table cellspacing="0" style="border: 2px dashed #0b7dda; width: 100%;"> 
                                                <tr> 
                                                    <th>Webshop:</th><td>World Wide Importers</td> 
                                                </tr> 
                                                <tr style="background-color: #e0e0e0;"> 
                                                    <th>order:</th><td>' . $orderId . '</td> 
                                                </tr>
                                                <tr style="background-color: #e0e0e0;"> 
                                                    <th>Verzonden naar:</th><td>' . $adres . ' <br>
                                                                                ' . $postcode .' '. $plaats .'</td>
                                                </tr>
                                            </table> 
                                    </body> 
                                    </html>';
        mail($to, $subject, $htmlContent, $headers);
        echo 'gelukt';
    } elseif ($payment->isOpen()) {
        /*
         * The payment is open.
         */
    } elseif ($payment->isPending()) {
        /*
         * The payment is pending.
         */
    } elseif ($payment->isFailed()) {
        /*
         * The payment has failed.
         */
    } elseif ($payment->isExpired()) {
        /*
         * The payment is expired.
         */
    } elseif ($payment->isCanceled()) {
        /*
         * The payment has been canceled.
         */
    } elseif ($payment->hasRefunds()) {
        /*
         * The payment has been (partially) refunded.
         * The status of the payment is still "paid"
         */
    } elseif ($payment->hasChargebacks()) {
        /*
         * The payment has been (partially) charged back.
         * The status of the payment is still "paid"
         */
    }
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}
