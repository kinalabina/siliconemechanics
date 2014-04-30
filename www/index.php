<?php
require_once 'inc/ridelog.php';

$db = BikeLogDB::getInstance();
$rides = $db->getRides();

?>
<html>
<head>
	<style type="text/css">
		.ride-description{
			font-style: italic;
		}

		.distance{
			font-weight: bold;
		}

	</style>
</head>
<body>

	<h1>Bike Log</h1>

	<?php
		if($rides !== null && !empty($rides)){
	?>
	<h2>Rides</h2>

	<?php

		foreach ($rides as $ride) {
			$rider = $ride->getRider();
			$bike = $ride->getBike();

			$bikeLink = '<a href="/bike.php?bike='.urlencode($bike->getId()).'" >'.
						htmlspecialchars($bike->getNickname())."</a>";
			$riderLink = '<a href="/rider.php?rider='.urlencode($rider->getId()).'" >'.
						htmlspecialchars ($rider->getRiderName())."</a>";
			
			echo "On ".date("l  F jS,  Y ", strtotime($ride->getStartTime())).", ".
				$riderLink." rode ".$bikeLink." for <span class=\"distance\">".$ride->getDistance()."</span> miles".
				" and described the ride as <span class=\"ride-description\" >&ldquo;".
				htmlspecialchars($ride->getDescription())."&rdquo;</span> <br/>";
			
		}

	?>

	<?php
	}else{ ?>
		<div class="empty" />no rides found</div>
	<?php
	}	
	?>

</body>
</html>
