<?php

namespace SmartpostShippingPhp\Shipment\Destination;

/**
 * Use this destination type for finnish or estonian parcelshop/terminal
 *
 * Smartpost documentation says:
 *   - When sending parcel to EE parcel terminal, fill “Place_id”.
 *   - When sending parcel to FI parcel terminal or post office,
 *     fill  and “”.
 */

class ParcelTerminal {

  private array $destinationData;
  private bool $parcelShop;

  public function __construct(array $destinationData, bool $parcelShop = true){
    $this->destinationData = $destinationData;
    $this->parcelShop = $parcelShop;
  }

  /**
   * Generate XML for destination part
   *
   * @return string
   */
  public function getXml(): string{
    if ($this->parcelShop) {
      return "
        <destination>
          <place_id>" . $this->destinationData['place_id'] . "</place_id>
        </destination>
      ";
    } else {
      return "
        <destination>
          <street>" . $this->destinationData['street'] . "</street>
          <house>" . $this->destinationData['house'] . "</house>
          <apartment>" . $this->destinationData['apt'] . "</apartment>
          <city>" . $this->destinationData['city'] . "</city>
          <country>" . $this->destinationData['country'] . "</country>
          <postalcode>" . $this->destinationData['zip'] . "</postalcode>
          <details>" . $this->destinationData['details'] . "</details>
          <timewindow>" . $this->destinationData['time_window'] . "</timewindow>
        </destination>
      ";
    }
  }
}

?>
