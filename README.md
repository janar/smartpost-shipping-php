# Client library for Itella Smartpost API written in PHP. 

Simple PHP client for creating (Itella) Smartpost parcels via web API. 
Currently in development, but shipments to 
parcel terminals (Estonia and Finland) work. Uses CURL for requests. 
Many requests and features not here yet. 

*Smartpost API docs can be found here: 
* http://uus.smartpost.ee/ariklient/ostukorvi-rippmenuu-lisamise-opetus/automaatse-andmevahetuse-opetus

***

## Installation

Easiest way to install the library is through [Composer](http://getcomposer.org):

```sh
$ composer require janar/smartpost-shipping-php
```

# Basic usage

Most basic and useful feature in this library would be creating shipments on your server. Removes need for manual exporting/importing CSV files to Smartpost environment. 

## Creating shipments: 
```php
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

## Creating shipments result: 
![Alt text](https://cloud.githubusercontent.com/assets/893499/17436624/ffff0786-5b20-11e6-8107-4b967971af61.png "Creating shipments result") 

## Shipments in Smartpost dashboard: 
![Alt text](https://cloud.githubusercontent.com/assets/893499/17436622/fffa4caa-5b20-11e6-8c34-dee707488b22.png "Shipments in Smartpost dashboard") 

***

## 3. Retrieving shipping labels (as pdf document)
Shipping labels are generated on Smartpost side and they are in pdf format. Only format and barcode(s) / tracking codes are needed to get labels on pdf. 
Formats are following: 

| Format        | Description   |
| ------------- |:------------- |
| A5            | 1 label on A5 sized paper  |
| A6            | 1 label on A6 sized paper  |
| A6-4          | 4 labels fitted on A6 sized paper |
| A7            | 1 label on A7 sized paper  |
| A7-8          | 8 labels fitted on A7 sized paper  |
| A6            | 1 label on A6 sized paper  |

Labels are on one continuous pdf document. 

```php

$spApi = new Client( "smartpost username", "smartpost password" );
$trackingCodes = array( '6895100008876963', '6895100008876964' );
$result = $spApi->getShippingLabels( $trackingCodes, 'A6-4' );

if( $result === false  ){
  echo $spApi->getLastError() . "<br />";
} else {
  //Here we stream pdf directly to browser, but you may also save returned content as file for local use. 
  header("Content-type:application/pdf");
  header("Content-Disposition:inline;filename='shipping-labels.pdf'");
  echo $result;
  exit;
}
```

Results would look something like this: 
![Alt text](https://cloud.githubusercontent.com/assets/893499/17839835/75d10ef8-67fd-11e6-8733-a2727ec6d8ce.png "Labels ready for printing") 


***

