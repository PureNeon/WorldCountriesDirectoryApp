<?php

namespace App\Model;

interface CountryRepository
{
    public function GetAll():array;
    public function Get($code): ?Country;
    public function Store($country): void;
    public function Edit($code, $country): void;
    public function Delete($code): void;
}