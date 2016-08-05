<?php

namespace SmartpostShippingPhp;

class Shipment {
  
  public $destinationId = '';
  public $trackingCode = '';
  public $reference = '';
  public $recipient = null;
  public $doorcode = null;
  
  public function __construct(){
    
  }
  
  /**
   * In which parcel automat to send this shipment
   * 
   * @param int $placeId
   * @return void
   */
  public function setDestinationById( $placeId ){
    $this->destinationId = $placeId;
  }
  
  /**
   * Actually barcode. 
   * 
   * @param string $code
   * @return void
   */
  public function setTrackingNumber( $code ){
    $this->trackingCode = $code;
  }
  
  /**
   * 
   * 
   * @param int $placeId
   * @return void
   */
  public function setReference( $reference ){
    $this->reference = $reference;
  }
  
  /**
   * 
   * 
   * @param int $placeId
   * @return void
   */
  public function setDestination( $destination ){
    $this->destination = $destination;
  }
  
  /**
   * 
   * 
   * @param int $placeId
   * @return void
   */
  public function setRecipient( Shipment\Recipient $recipient ){
    $this->recipient = $recipient;
  }
  
  public function getXml( ){
    $xml = "
      <item>
        <barcode></barcode>
        <reference>" . $this->reference . "</reference>
        " . $this->destination->getXml() . "
        " . $this->recipient->getXml() . "
      </item>
    ";
    return $xml;
  }

}


?>