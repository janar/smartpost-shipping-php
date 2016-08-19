# Client library for Itella Smartpost API written in PHP. 

PHP client for creating (Itella) Smartpost parcels via web API. 
Currently in development, but shipments to 
parcel terminals (Estonia and Finland) work. 

API docs can be found here: 
* http://uus.smartpost.ee/ariklient/ostukorvi-rippmenuu-lisamise-opetus/automaatse-andmevahetuse-opetus


***


# 3. pictures say more than 1000 words

### 1) Creating shipments: 
```
$spApi = new Client( "smartpost username", "smartpost password" );


//create shipments
$shipment = new Shipment();
$shipment->setRecipient( new Recipient( "John Doe", "56666661", "john.doe@doe123.com" ) );
$shipment->setReference( '[MyAwsomeWebShop] - test #1' );
$shipment->setDestination( new ParcelTerminal( 172 ) );
$spApi->addShipment( $shipment );


$shipment = new Shipment();
$shipment->setRecipient( new Recipient( "John Doe2", "56666662", "john.doe2@doe123.com" ) );
$shipment->setReference( '[MyAwsomeWebShop] - test #2' );
$shipment->setDestination( new ParcelTerminal( 171 ) );
$spApi->addShipment( $shipment );


$shipment = new Shipment();
$shipment->setRecipient( new Recipient( "John Doe3", "56666663", "john.doe3@doe123.com" ) );
$shipment->setDestination( new ParcelTerminal( null, "3202", "00215" ) );
$spApi->addShipment( $shipment );

$result = $spApi->postShipments();
```

### 2) Creating shipments result: 
![Alt text](https://cloud.githubusercontent.com/assets/893499/17436624/ffff0786-5b20-11e6-8107-4b967971af61.png "Creating shipments result") 

### 3) Shipments in Smartpost dashboard: 
![Alt text](https://cloud.githubusercontent.com/assets/893499/17436622/fffa4caa-5b20-11e6-8c34-dee707488b22.png "Shipments in Smartpost dashboard") 



***

