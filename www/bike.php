<?php

require_once 'inc/ridelog.php';

$db = BikeLogDB::getInstance();

$bikeId;
if(isset($_GET['bike'])){
	$bikeId = $_GET['bike'];
}else{
	$bikeId = null;
}

$bike = $db->getBike($bikeId);

?>

<html>
<head>
</head>
<body>

	<h1>Bike Log</h1>

	<?php
		if($bike !== null){
	?>
	<h2>Bike Details</h2>

	<?php

		echo "Brand: ".htmlspecialchars($bike->getBrand())."<br/>";
		echo "Model: ".htmlspecialchars($bike->getModel())."<br/>";
		echo "Style: ".htmlspecialchars($bike->getStyle())."<br/>";
		echo "Nickname: ".htmlspecialchars($bike->getNickname())."<br/>";

		
		$riderLink = "un owned";
		if($bike->hasOwner()){
			$owner = $bike->getOwner();
			$riderLink = '<a href="/rider.php?rider='.urlencode($owner->getId()).'" >'.
							htmlspecialchars ($owner->getRiderName())."</a>";
		}

		echo "Owned by: ".$riderLink."<br/>";


	?>

	<?php
	}else{ ?>
		<div class="empty" />bike not found</div>
	<?php
	}	
	?>
	<a href="/">back to rides</a>
</body>
</html>
