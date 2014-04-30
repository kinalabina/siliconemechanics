<?php

require_once 'inc/ridelog.php';

$db = BikeLogDB::getInstance();

$riderId;
if(isset($_GET['rider'])){
	$riderId = $_GET['rider'];
}else{
	$riderId = null;
}

$rider = $db->getRider($riderId);

?>
<html>
<head>
</head>
<body>

	<h1>Bike Log</h1>

	<?php
		if($rider !== null){
	?>
	<h2>Rider Details</h2>

	<?php

		echo "Rider Name: ".htmlspecialchars($rider->getRiderName())."<br/>";
		
	?>

	<?php
	}else{ ?>
		<div class="empty" />rider not found</div>
	<?php
	}	
	?>
	<a href="/">back to rides</a>
</body>
</html>