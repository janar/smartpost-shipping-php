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
    $this->phone = $this->cleanupPhoneNumber( $phone );
    $this->email = $email;
  }
  
  
  /**
   * Remove spaces, remove +372
   * 
   * @param string $phone
   * @return string
   */
  public function cleanupPhoneNumber( $phone ){
    $phone = str_replace(
      array(' ', '+'),
      '',
      $phone
    );
    
    if( substr( $phone, 0, 3 ) == '372' ){
      $phone = mb_substr( $phone, 3 );
    }
    
    return $phone;
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