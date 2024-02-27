<!-- resources/views/qrcode.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu QR Code</title>
</head>
<body>
    <h1>Menu QR Code</h1>

    {{-- Debugging statement for image URL --}}
    <?php echo "Image URL: " . asset('qr_codes/menu_' . $menuId . '.svg'); ?>

    <img src="{{ asset('qr_codes/menu_' . $menuId . '.svg') }}" alt="Menu QR Code">
    
</body>
</html>

