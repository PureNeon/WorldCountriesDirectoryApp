<?php

namespace App\Model;

class Country {
    public $shortName;
    public $fullName;
    public $isoAlpha2;
    public $isoAlpha3;
    public $isoNumeric;
    public $population;
    public $square;

    public function __construct($shortName, $fullName, $isoAlpha2, $isoAlpha3, $isoNumeric, $population, $square)
    {
        $this->shortName = $shortName;
        $this->fullName = $fullName;
        $this->isoAlpha2 = $isoAlpha2;
        $this->isoAlpha3 = $isoAlpha3;
        $this->isoNumeric = $isoNumeric;
        $this->population = $population;
        $this->square = $square;
    }
}
