<?php

namespace App\Model;

use App\Model\CountryRepository;
use App\Rdb\CountryStorage;
use App\Model\Country;

class CountryScenarios {
    private $countryStorage;
    public function __construct()
    {
        $this->countryStorage = new CountryStorage();
    }

    public function GetAll(): array {
        return $this->countryStorage->GetAll();
    }
    public function Get($code): ?Country {
        return $this->countryStorage->Get($code);
    }
    public function Store($country): void {
        $this->countryStorage->Store($country);
    }
    public function Edit($code, $country): void {
        $this->countryStorage->Edit($code, $country);
    }
    public function Delete($code): void {
        $this->countryStorage->Delete($code);
    }
}