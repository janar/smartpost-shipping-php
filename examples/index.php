<?php
namespace SmartpostExamples;

use SmartpostShippingPhp\Client;
use SmartpostShippingPhp\Shipment;
use SmartpostShippingPhp\Shipment\Recipient;
use SmartpostShippingPhp\Shipment\Destination\ParcelTerminal;

//TODO: add autoloader later
include '../src/Client.php';
include '../src/Shipment.php';
include '../src/Shipment/Recipient.php';
include '../src/Shipment/Destination/ParcelTerminal.php';


//get configuration
include 'config.php';
if( !isset($smartConfig) || !isset( $smartConfig['username'] ) ){
  die('Rename "config-sample.php"  to "config.php" and fill in appropriate data to make this demo work');
}


$spApi = new Client( $smartConfig['username'], $smartConfig['password'] );


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


print '<pre>';
    
$result = $spApi->postShipments();
if( $result === false  ){
  echo $spApi->getLastError() . "<br />";
} else {
  print_r( $result );
}

print '</pre>';
