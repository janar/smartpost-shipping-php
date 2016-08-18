<?php

namespace SmartpostShippingPhp;

class Shipment {
  
  private $referenceOrderId = 0;
  private $destinationId = '';
  private $trackingCode = '';
  private $reference = '';
  private $recipient = null;
  private $doorcode = null;
  
  public function __construct(){
    
  }
  
  /**
   * Not needed by smartpost, but can be handy to pass order id values along
   * when creating / sending shipments. 
   * 
   * @param int $referenceOrderId
   * @return void
   */
  public function setReferenceOrderId( $referenceOrderId ){
    $this->referenceOrderId = $referenceOrderId;
  }
  
  
  /**
   * -
   * 
   * @return int
   */
  public function getReferenceOrderId( ){
    return $this->referenceOrderId;
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
   * -
   * 
   * @return string
   */
  public function getTrackingNumber( ){
    return $this->trackingCode;
  }
  
  
  /**
   * Message on shipment label. something like "Storename - Order 4456" or just 
   * order ID. Can leave empty also- not required field. 
   * 
   * @param string
   * @return void
   */
  public function setReference( $reference ){
    $this->reference = $reference;
  }
  
  
  /**
   * -
   * 
   * @return string
   */
  public function getReference( ){
    return $this->reference;
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