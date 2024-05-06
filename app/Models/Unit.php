<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Unit
{

    const GRAM = "G";
    const KILOGRAM = "KG";
    const BOTTLE = "BTL";
    const PIECE = "PC.";
    const MILLILITER = "ML";
    const LITER = "L";


    public static $unitTexts = [
        self::GRAM => "Gram",
        self::KILOGRAM => "Kilogram",
        self::BOTTLE => "Bottle",
        self::PIECE => "Piece",
        self::MILLILITER => "Milliliter",
        self::LITER => "Liter",
    ];

    public static function getUnits(): Collection
    {
        return collect([
            (object)[
                'name' => self::$unitTexts[self::GRAM],
                'base_unit' => self::GRAM,
            ],
            (object)[
                'name' => self::$unitTexts[self::KILOGRAM],
                'base_unit' => self::KILOGRAM,
            ],
            (object)[
                'name' => self::$unitTexts[self::BOTTLE],
                'base_unit' => self::BOTTLE,
            ],
            (object)[
                'name' => self::$unitTexts[self::PIECE],
                'base_unit' => self::PIECE,
            ],
            (object)[
                'name' => self::$unitTexts[self::MILLILITER],
                'base_unit' => self::MILLILITER,
            ],
            (object)[
                'name' => self::$unitTexts[self::LITER],
                'base_unit' => self::LITER,
            ],
        ]);
    }
}
