<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Add this line
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generateQrCode($menuId)
    {
        $menuData = [
            'id' => $menuId,
            // other menu details...
        ];

        // Generate QR code
        $qrCode = QrCode::size(300)->generate(json_encode($menuData));

        // Directory to save QR codes
        $directory = public_path('qr_codes');

        // Create the directory if it doesn't exist
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory);
        }

        // File path to save the QR code
        $filePath = public_path("qr_codes/menu_{$menuId}.png");

        // Write the QR code to the file
        file_put_contents($filePath, $qrCode);

        // Debugging statements
        if (file_exists($filePath)) {
            echo "QR Code generated successfully!";
        } else {
            echo "Error generating QR Code.";
        }

        return view('restaurant_owner.menus.qrcode', ['menuId' => $menuId]);
    }
}