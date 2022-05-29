<?php

namespace App\Modules\Address\Services;

use App\Models\Address;
use App\Models\InvoiceHeader;
use App\Modules\Address\DTO\AddressDTO;

class AddressService {
        
    public function createAddress(AddressDTO $addressDTO, mixed $addressable): Address
    { 
        $address = new Address([
            'address_1' => $addressDTO->getAddress1(),
            'address_2' => $addressDTO->getAddress2(),
            'city' => $addressDTO->getCity(),
            'postalcode' => $addressDTO->getPostalcode(),
            'country' => $addressDTO->getCountry(),
        ]);
        $address->addressable_id = $addressable['id'];
        $address->addressable_type = $addressable['class'];
        $address->save();

        return $address;
    }

}
