<?php
/** 
 * Base clas for 
 * 
 */

namespace SmartpostShippingPhp;

class Client {
  public $apiBaseUrl = "http://iseteenindus.smartpost.ee/api/";
  public $username = "";
  public $password = "";
  
  public $shipments = array();
  public $lastError = "";

  public function __construct( $username, $password, $baseUri = null ){
    if( !$username || !$password ){
      throw new \Exception( "Please provide username and password to use this client" );
    }
    
    $this->username = $username;
    $this->password = $password;
    
    if( $baseUri ){
      $this->apiBaseUrl = $baseUri;
    }
  }
  

  /**
   * Get destionations list from Smartpost service
   * 
   * @return array
   */
  public function getDestinations( ){
    
    return true;
  }
  
  /**
   * Send currently collected shipments to Smartpost service using CURL
   * 
   * @return array|boolean false
   */
  public function postShipments( ){
    $shipmentsXml = $this->getPushShipmentsXml();
    
    //make request
    $curl = curl_init( $this->apiBaseUrl . '?request=shipment' );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $shipmentsXml);
    $xmlstr = curl_exec( $curl );
    curl_close( $curl );
    
    
    $check = $this->xmlResultHasErrors( $xmlstr );
    if( $check ){
      return false;
    }
    
    $results = $this->xmlParseCreateShipmentsResults( $xmlstr );
    if( $results === false ){
      $this->lastError = "Successful request was made but parsing failed";
      return false;
    }
    
    return $results;
  }
  
  
  /**
   * -
   * 
   * @return string XML result given by API
   * @return boolean
   */
  private function xmlParseCreateShipmentsResults( $xmlstr ){
    $shipments = array();
    
    try {
      $result = new \SimpleXMLElement( $xmlstr );
      
      if( isset( $result->item[0] ) ){
        foreach( $result->item as $k => $item ){
        
         $barcode =  $item->barcode->__tostring();
         
         if( $barcode ){
           $shipment = new Shipment;
           $shipment->setTrackingNumber( $barcode );
           $shipment->setReference( $item->reference->__tostring() );
           
           //doorcode also assigned?
           if( isset($item->sender->doorcode) ){
             $shipment->doorcode = $item->sender->doorcode->__tostring();
           }
           
           $shipments[] = clone( $shipment );
         }
         
        }
      }
    } catch ( Exception $e ){
      $this->lastError = $e->getMessage();
      return false;
    }
    
    return $shipments;
  }
  
  /**
   * Check resulting XML for errors. If errors found 
   * return true and set last error string
   * 
   * @return string XML result given by API
   * @return boolean
   */
  private function xmlResultHasErrors( $xmlstr ){
    
    try {
      //test xml result for errors
      $doc = new \DOMDocument();
      $result = $doc->loadXML( $xmlstr );
      if( !$result ){
        $this->lastError = "Parsing results failed";
        return true;
      }
      
      $result = new \SimpleXMLElement( $xmlstr );
      
      if( $result && $result->getName() == 'error' ){
        $this->xmlResultParseItemErrors( $result );
        return true;
      }
    } catch ( Exception $e ){
      $this->lastError = $e->getMessage();
      return true;
    }
    
    return false;
  }
  
  /**
   * -
   * 
   * @return SimpleXMLElement $result
   * @return void
   */
  private function xmlResultParseItemErrors( $result ){

    $this->lastError = $result->__toString();
    
    //if items also returned return first found item with error
    if( isset( $result->item[0] ) ){
      $cnt = 0;
      foreach( $result->item as $k => $item ){
        $cnt++;
        if( isset($item->error) ){
          
          $default = "Error with item #" . $cnt;
          
          if( isset($item->error->code) && $item->error->code ){
            $default .= " (CODE: " . $item->error->code ;
            $default .= ", MSG: " . $item->error->text;
            $default .= ", VALUE: " . $item->error->input . ")";
          }
          
          $this->lastError = $default;
          return;
        }
      }
    }
  }
  
  
  /**
   * -
   * 
   * @return string
   */
  public function getLastError( ){
    return $this->lastError;
  }
  
  
  /**
   * Push new shipment into queue
   * 
   * TODO: I think this "queue" variant is not good. Should use some pattern?
   * 
   * @param Shipment $shipment
   * @return string
   */
  public function addShipment( Shipment $shipment ){
    $this->shipments[] = $shipment;
  }
  
  
  /**
   * Remove shipments from queue
   * 
   * @return void
   */
  public function clearShipmentsQueue( ){
    $this->shipments = array();
  }
  
  
  /**
   * Generate XML for posting queued shipments to Smartpost service
   * 
   * @return string
   */
  private function getPushShipmentsXml(){
    $shipments = '';
    
    foreach( $this->shipments as $k => $shipment ){
      $shipments .= $shipment->getXml();
    }
    
    $xml = "
      <orders>
        <authentication>
          <user>" . $this->username . "</user>
          <password>" . $this->password . "</password>
        </authentication>
        " . $shipments . "
      </orders>
    ";
    
    return $xml;
  }
  
}

?>