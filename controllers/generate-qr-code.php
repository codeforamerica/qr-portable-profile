<?php	
    include('../resources/php/phpqrcode/qrlib.php');
	
	QRcode::png($_GET["id"], false, QR_ECLEVEL_L, 10);
?>