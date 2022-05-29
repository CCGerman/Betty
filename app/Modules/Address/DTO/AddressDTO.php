<?php 

namespace App\Modules\Address\DTO;


final class AddressDTO {

    private $address1;
    private $address2;
    private $city;
    private $postalcode;
    private $country;

    public function __construct(string $address1, string $address2, string $city, string $postalcode, string $country)
    {
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->postalcode = $postalcode;
        $this->country = $country;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function getAddress2(): string
    {
        return $this->address2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalcode()
    {
        return $this->postalcode;
    }

    public function getCountry(){
        return $this->country;
    }

}
