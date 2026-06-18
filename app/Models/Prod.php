<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'item_code', 'unit_price', 'discount_percentage', 'description', 'search_keys', 'image_path', 'vehicle_brand_id', 'vehicle_type_id', 'category_product_id'])]
class Prod extends Model
{
    protected $table = 'prod';

    protected function casts(): array
    {
        return [
            'unit_price' => 'float',
            'discount_percentage' => 'float',
        ];
    }

    public function vehicleBrand(): BelongsTo
    {
        return $this->belongsTo(VehicleBrand::class);
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function categoryProduct(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class);
    }

    public function discountedPrice(): ?float
    {
        if ($this->unit_price === null) {
            return null;
        }

        $discount = $this->discount_percentage ?? 0;

        if ($discount <= 0) {
            return $this->unit_price;
        }

        return round($this->unit_price * (1 - ($discount / 100)), 2);
    }

    public function hasActiveDiscount(): bool
    {
        return $this->unit_price !== null && ($this->discount_percentage ?? 0) > 0;
    }
}
