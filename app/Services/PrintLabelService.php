<?php


namespace App\Services;

use Exception;
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
    public function __construct($printer)
    {
        $this->languageCode = $printer->protocol;
        $this->labelSize = $printer->label_size;
        $this->iP = $printer->ip_address;
    }

    /**
     * Generate Label based on printer communication language
     *
     * @param string $qrcode The product qrcode
     * @param string $of_num The OF number
     * @param string $product_name The Name of the product
     * @param string $sn The serial number of the product
     */
    public function printProductLabel(string $qrCode)
    {
        // dd($this->iP);
        // $qrCode = $new_sn->qr;
        // 932113600012023#001#CX1000-3#001#2023-02-13 22:17:22
        $label = '';
        $qr = explode("#", $qrCode);
        $of_num = $qr[1];
        $product_name = $qr[2];
        $sn = $qr[3];
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
                            "QRCODE 15,20,M,4,A,0,\"$qrCode\"" .
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
        return $this->print($label);
    }

    /**
     * Print label to printer using the generateProductLabel() public methode
     *
     */

    public function print($label)
    {
        // Create a socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // Set socket options for receive timeout
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 1, 'usec' => 0));

        // Set socket options for send timeout
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 1, 'usec' => 0));

        // Check if socket creation was successful
        // if ($socket === FALSE) {
        //     // Return an error response
        //     return ["status" => "error", "message" => "Socket creation failed"];
        // }

        // Connect to the printer using IP and port 9100
        $result = socket_connect($socket, $this->iP, "9100"); // Use @ to suppress exceptions

        // Check if the connection was successful
        // if ($result === FALSE) {
        //     // Return an error response
        //     // return ["status" => "error", "message" => "Socket connection failed"];
        //     throw new Exception("Custom error: Socket connection failed");
        // }

        // Write the label data to the socket
        $bytesWritten = socket_write($socket, $label, strlen($label)); // Use @ to suppress exceptions

        // Check if writing to the socket was successful
        // if ($bytesWritten === FALSE) {
        //     // Return an error response
        //     return ["status" => "error", "message" => "Socket write failed"];
        // } else {

        // Close the socket and return a success response
        socket_close($socket);
        return true;
        // return ["status" => "success", "message" => "Label sent successfully"];
        // }
    }
}