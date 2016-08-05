<?php

namespace SmartpostShippingPhp\Shipment;

/**
 * TODO: 
 *   <cash>number</cash>
 *   <idcode>number</idcode>
 * 
 */

class Recipient {
  private $fullname = "";
  private $phone = "";
  private $email = "";
  

  public function __construct( $fullname, $phone, $email ){
    
    if( !$fullname || !$phone || !$email ){
      throw new \Exception( "Please provide full Recipient data" );
    }
    
    $this->fullname = $fullname;
    $this->phone = $phone;
    $this->email = $email;
  }
  
  /**
   * Generate XML for posting new shipments to Smartpost service
   * 
   * @return string
   */
  public function getXml(){
    $xml = "
      <recipient>
        <name>" . $this->fullname . "</name>
        <phone>" . $this->phone . "</phone>
        <email>" . $this->email . "</email>
      </recipient>
    ";
    
    return $xml;
  }
}

?>