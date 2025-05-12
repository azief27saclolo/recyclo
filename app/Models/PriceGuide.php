<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'type',
        'description',
        'price',
    ];

    // Categories
    const CATEGORY_PLASTIC = 'plastic';
    const CATEGORY_PAPER = 'paper';
    const CATEGORY_METAL = 'metal';
    const CATEGORY_BATTERIES = 'batteries';
    const CATEGORY_GLASS = 'glass';
    const CATEGORY_EWASTE = 'ewaste';

    /**
     * Get all available categories as an array
     *
     * @return array
     */
    public static function getCategories()
    {
        return [
            self::CATEGORY_PLASTIC => 'Plastic',
            self::CATEGORY_PAPER => 'Paper',
            self::CATEGORY_METAL => 'Metal',
            self::CATEGORY_BATTERIES => 'Batteries',
            self::CATEGORY_GLASS => 'Glass',
            self::CATEGORY_EWASTE => 'E-waste',
        ];
    }
}
