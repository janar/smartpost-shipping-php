<?php

namespace SmartpostShippingPhp\Shipment\Destination;

/**
 * Use this destination type for finnish or estonian parcel automat/terminal
 *
 * Smartpost documentation says:
 *   - When sending parcel to EE parcel terminal, fill “Place_id”.
 *   - When sending parcel to FI parcel terminal or post office,
 *     fill  and “”.
 */

class ParcelTerminal {
  private $placeId = "";
  private $postalCode = "";
  private $routingCode= "";


  public function __construct( $placeId, $routingCode = null, $postalCode = null ){

    if( !$placeId && ( !$postalCode || !$routingCode ) ){
      throw new \Exception( "Please provide destination data" );
    }

    $this->placeId = $placeId;
    $this->postalCode = $postalCode;
    $this->routingCode = $routingCode;
  }

  /**
   * Generate XML for destination part
   *
   * @return string
   */
  public function getXml(){
    if( $this->routingCode && $this->postalCode ){
        $xml = "
        <destination>
          <street>Test1</street>
          <house>Test2</house>
          <apartment>Test3</apartment>
          <city>Test4</city>
          <country>Test5</country>
          <postalcode>Test6</postalcode>
          <details>Test7</details>
          <timewindow>Test8</timewindow>
        </destination>
      ";
    } else {
      $xml = "
        <destination>
          <place_id>" . $this->placeId . "</place_id>
        </destination>
      ";
    }

    return $xml;
  }
}

?>
