<?php
$to = 'hidde.spenkelink@gmail.com';
$vkey = "eiye8372kjilj83lk2j34ji";
$subject = "Email Verificatie";
$message = "<a href='http://localhost/WWI_site/verify.php?vkey=$vkey'>Register Account</a>";
$headers = 'From: wwi_site@yahoo.com' . "\r\n" . "MIME-Version: 1.0" . "\r\n" .
    "Content-type:text/html;charset=UTF-8" . "\r\n";
$firstname = 'Hidde';

$htmlContent = " 
                                    <html> 
                                    <head> 
                                        <title>Welkom bij WorldWideImporters! </title> 
                                    </head> 
                                    <body> 
                                        <h1>Dankjewel $firstname"."! Nog een paar stappen en dan ben je klaar voor de start!</h1> 
                                           <table cellspacing='0' style='border: 2px dashed #0b7dda; width: 100%;'> 
                                                <tr> 
                                                    <th>Bedrijf:</th><td>WWI</td> 
                                                </tr> 
                                                <tr style='background-color: #e0e0e0;'> 
                                                    <th>Voor hulp:</th><td>contact@WWI.com</td> 
                                                </tr> 
                                                <tr> 
                                                    <th></th><td><a href=\'http://localhost/WWI_site/verify.php?vkey=$vkey\'>Verifieer</a></td> 
                                                </tr> 
                                            </table> 
                                    </body> 
                                    </html>";

mail($to, $subject, $htmlContent, $headers);



?>