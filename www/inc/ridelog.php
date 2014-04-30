<?php

final class BikeLogDB{

    private static $instance = null;
    private static $dbcon = null;

    //would be better to move to config file
    private static $config = array(
		'db_host' => '',
		'db_user' => '',
		'db_pass' => '',
		'db_schema' => 'ride_log'
	);
    

    public static function getInstance(){
    	if(self::$instance === null){
    		self::$instance = new BikeLogDB();
    	}

    	return self::$instance;
    }

    private function __construct(){

    }

    public function __destruct() {
    	self::$dbcon = null;
	}	

	private static function getConnection(){
		if(self::$dbcon === null){
			$db_host = self::$config['db_host'];
			$db_user = self::$config['db_user'];
			$db_pass = self::$config['db_pass'];
			$db_schema = self::$config['db_schema'];

			self::$dbcon = new PDO("mysql:host=$db_host;dbname=$db_schema", $db_user, $db_pass);
		}
		return self::$dbcon;
	}


	public function getBike($id){
		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT *, s.description AS style, br.description as brand, 
						r.rider_name AS owner_name FROM bike b 
						JOIN style s ON s.style_id = b.style_id
						JOIN brand br ON br.brand_id = b.brand_id
						LEFT JOIN rider r ON b.owner_id = r.rider_id 
						WHERE b.bike_id = :bike_id ");
		$stmt->bindParam(':bike_id', $id);
		$stmt->execute();

		$row = $stmt->fetch();
		if($row){
			return $this->bindBike($row);			
		}else{
			return null;
		}

	}

	public function getBikes(){

		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT *, s.description AS style, br.description as brand,
						r.rider_name AS owner_name FROM bike b 
						JOIN style s ON s.style_id = b.style_id
						JOIN brand br ON br.brand_id = b.brand_id
						LEFT JOIN rider r ON b.owner_id = r.rider_id ");		
		$stmt->execute();

		
		$arrayOfBikes = array();
		while($row = $stmt->fetch()) {
        	$arrayOfBikes[] = $this->bindBike($row);
    	}

    	return $arrayOfBikes;
	}

	private function bindBike($assoc){
		
		$id = null;
		if($assoc != null){
			$id = $assoc['bike_id'];
		}
		$bike = new Bike($id);
		$bike->setModel($assoc['model']);
		$bike->setStyle($assoc['style_id'], $assoc['style']);
		$bike->setBrand($assoc['brand_id'], $assoc['brand']);
		$bike->setNickname($assoc['nickname']);

		//In case this bike has no owner
		if($assoc['owner_id'] == null){			
			$bike->setOwner(null);
		}else{
			$bike->setOwner($this->bindOwner($assoc));
		}
		
		return $bike;
	}

	private function bindOwner($assoc){
		$id = null;
		if($assoc != null){
			$id = $assoc['owner_id'];
		}
		$rider = new Rider($id);
		$rider->setRiderName($assoc['owner_name']);

		return $rider;
	}

	public function getRider($id){
		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT * FROM rider 
						WHERE rider_id = :rider_id ");
		$stmt->bindParam(':rider_id', $id);
		$stmt->execute();

		$row = $stmt->fetch();
		if($row){
			return $this->bindRider($row);			
		}else{
			return null;
		}
	}

	public function getRiders(){
		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT * FROM rider ");		
		$stmt->execute();

		
		$arrayOfRiders = array();
		while($row = $stmt->fetch()) {
        	$arrayOfRiders[] = $this->bindRider($row);
    	}

    	return $arrayOfRiders;
	}

	private function bindRider($assoc){
		$id = null;
		if($assoc != null){
			$id = $assoc['rider_id'];
		}
		$rider = new Rider($id);
		$rider->setRiderName($assoc['rider_name']);

		return $rider;
	}
	    
	public function getRide($id){
		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT ri.*,b.*, s.*,r.*, ri.description AS ride_description, 
						s.description AS style, br.description as brand,
						ow.rider_id AS owner_id, ow.rider_name AS owner_name
						FROM 
						ride ri JOIN
						bike b ON ri.bike_id = b.bike_id
						JOIN style s ON s.style_id = b.style_id
						JOIN brand br ON br.brand_id = b.brand_id
						JOIN rider r ON r.rider_id = ri.rider_id
						LEFT JOIN rider ow ON b.owner_id = ow.rider_id 						
						WHERE ride_id = :ride_id");

		$stmt->bindParam(':ride_id', $id);
		$stmt->execute();

		$row = $stmt->fetch();
		if($row){
			return $this->bindRide($row);			
		}else{
			return null;
		}
	}

	public function getRides(){
		$db = self::getConnection();

		$stmt = $db->prepare(" 
						SELECT ri.*,b.*, r.*, s.*, ri.description AS ride_description, 
						s.description AS style, br.description as brand,
						ow.rider_id AS owner_id, ow.rider_name AS owner_name
						FROM 
						ride ri JOIN
						bike b ON ri.bike_id = b.bike_id
						JOIN style s ON s.style_id = b.style_id
						JOIN brand br ON br.brand_id = b.brand_id
						JOIN rider r ON r.rider_id = ri.rider_id
						LEFT JOIN rider ow ON b.owner_id = ow.rider_id 
						ORDER BY start_time DESC
						");
		
		$stmt->execute();

		$arrayOfRides = array();
		while($row = $stmt->fetch()) {
			
        	$arrayOfRides[] = $this->bindRide($row);
    	}

    	return $arrayOfRides;
	}

	private function bindRide($assoc){
		
		$id = null;
		if($assoc != null){
			$id = $assoc['ride_id'];
		}
		$ride = new Ride($id);

    	$ride->setStartTime($assoc['start_time']);
    	$ride->setFinishTime($assoc['finish_time']);
    	$ride->setDistance($assoc['distance']);
    	$ride->setDescription($assoc['ride_description']);
		

		$ride->setRider($this->bindRider($assoc));
		$ride->setBike($this->bindBike($assoc));
		
		return $ride;
	}

}

class Rider{

	private $id;
	private $riderName;

	public function __construct($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function getRiderName(){
		return $this->riderName;
	}

	public function setRiderName($riderName){
		$this->riderName = $riderName;
	}

}

class Bike {

	private $id;
	private $styleId;
	private $style;
	private $brandId;
	private $brand;
	private $model;
	private $nickname;
	 
	private $owner = null;

	public function __construct($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setStyle($styleId, $style){
		$this->styleId = $styleId;
		$this->style = $style;
	}

	public function getStyle(){
		return $this->style;
	}

	public function getStyleId(){
		return $this->styleId;
	}

	public function setBrand($brandId, $brand){
		$this->brandId = $brandId;
		$this->brand = $brand;
	}

	public function getBrand(){
		return $this->brand;
	}

	public function getBrandId(){
		return $this->brandId;
	}

	public function setModel($model){
		$this->model = $model;
	}

	public function getModel(){
		return $this->model;
	}

	public function setNickname($nickname){
		$this->nickname = $nickname;
	}

	public function getNickname(){
		return $this->nickname;
	}

	public function setOwner($owner){
		$this->owner = $owner;
	}

	public function getOwner(){
		return $this->owner;
	}

	public function hasOwner(){
		return $this->owner !== null;
	}

}

class Ride {

	private $id;
	private $rider;
	private $bike;

	private $startTime;
	private $finishTime;
	private $distance;
	private $description;

	public function __construct($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setStartTime($startTime){
		$this->startTime = $startTime;
	}

	public function getStartTime(){
		return $this->startTime;
	}

	public function setFinishTime($finishTime){
		$this->finishTime = $finishTime;
	}

	public function getFinishTime(){
		return $this->finishTime;
	}


	public function setDescription($description){
		$this->description = $description;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDistance($distance){
		$this->distance = $distance;
	}

	public function getDistance(){
		return $this->distance;
	}

	public function getRider(){
		return $this->rider;
	}

	public function setRider($rider){
		$this->rider = $rider;
	}

	public function getBike(){
		return $this->bike;
	}

	public function setBike($bike){
		$this->bike = $bike;
	}

}





?>
