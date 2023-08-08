<?php


namespace App\Services;
/* require "PrintLabel.php";
$printLabel = new PrintLabel("192.168.1.100", "TSPL", "40_20");
$qrCode = "932113607001#CompteurX03#3500#2430#19/01/2023 09:29";
$sn = "2430";
$of_num = "001";
$product_name = "CompteurX03";
$printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
$printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
$printLabel->printProductLabel($qrCode, $of_num, $product_name, $sn);
*/

/**
 * @version 1.0.0
 * @author  Bouhezila Nassim
 */

class PrintLabelService
{
    private $languageCode;
    private $labelSize;
    private $iP;

    /**
     * Constructor of the PrintLabel class.
     *
     * @param string $iP The ip address of the printer
     *
     * @param string $languageCode The language code that used by the printer must be "ESC","EZPL", "TSPL"
     *
     * @param string $labelSize The size of the label that the printer use, must be like "Width_Hight" Ex:"40_20"
     *
     */
    public function __construct(string $iP, string $languageCode, string  $labelSize)
    {
        $this->languageCode = $languageCode;
        $this->labelSize = $labelSize;
        $this->iP = $iP;
    }

    /**
     * Generate Label based on printer communication language
     *
     * @param string $qrcode The product qrcode
     * @param string $of_num The OF number
     * @param string $product_name The Name of the product
     * @param string $sn The serial number of the product
     */
    public function printProductLabel(string $qrcode, string $of_num, string $product_name, string $sn)
    {
        // dd($qrCode);
        $label = '';
        switch ($this->languageCode) {

                //If label printer support TSPL (Taiwan Semiconductor Printing/Programming Language)
                //like (Gprinters, IT POS,..)
            case "TSPL":
                switch ($this->labelSize) {
                    case "40_20":
                        $label =
                            "SIZE 40 mm, 20 mm\n" . //Specify label size width hight
                            "GAP 2 mm, 0 mm\n" .     // Specify space between two labels
                            "DIRECTION 1\n" .       //Specify the printing direction (up to down or down to up)
                            "REFERENCE 0,0\n" .      // specify the initial label starting coordinates
                            "CLS\n" .                 // clears the image buffer
                            "QRCODE 15,20,M,4,A,0,\"$qrcode\"" .
                            "TEXT 5,10,\"2\",0,1,1," . "\"Test1\"" . "\n" .
                            "TEXT 140,20,\"2\",0,1,1," . "\"$sn\"" . "\n" .
                            "TEXT 140,50,\"2\",0,1,1," . "\"$of_num\"" . "\n" .
                            "TEXT 140,80,\"2\",0,1,1," . "\"$product_name\"" . "\n" .
                            "PRINT 1,1\n";              // Print x,y with one copy : y = 1 copy
                        break;
                }
                break;

                //If label printer support EZPL (E Zebra Programming languag)
                //like (Godex,..)
            case "EZPL":

                break;

                //If label printer support ESC (Epson Scripting Code)
                //like (Xprinter,Epson..)
            case "ESC":

                break;
        }
        $this->print($label);
    }

    /**
     * Print label to printer using the generateProductLabel() public methode
     *
     */
    public function print($label)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 1, 'usec' => 0));
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 1, 'usec' => 0));

        if ($socket === FALSE) {
            echo json_encode(array("state" => "f", "message" => "socket_create() failed" . " " . __FUNCTION__));
            // addTrace("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
        }

        $result = socket_connect($socket, $this->iP, "9100");
        if ($result === FALSE) {
            echo json_encode(array("state" => "f", "message" => "Printer_connect() failed" . " " . __FUNCTION__));
            // addTrace("socket_connect() failed. Reason: ($result) " . socket_strerror(socket_last_error($socket)));
        }
        $sWrite = socket_write($socket, $label, strlen($label));
        if ($sWrite === FALSE) {
            // addTrace("socket_write() failed. Reason: " . socket_strerror(socket_last_error($socket)));
        } else {
            socket_close($socket);
            echo json_encode(array("state" => "s"));
        }
    }
}
