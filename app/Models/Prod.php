<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

#[Fillable(['name', 'item_code', 'unit_price', 'discount_percentage', 'height', 'width', 'length', 'weight', 'description', 'search_keys', 'image_path', 'vehicle_brand_id', 'vehicle_type_id', 'category_product_id'])]
class Prod extends Model
{
    protected $table = 'prod';

    protected function casts(): array
    {
        return [
            'unit_price' => 'float',
            'discount_percentage' => 'float',
            'height' => 'float',
            'width' => 'float',
            'length' => 'float',
            'weight' => 'float',
        ];
    }

    public function vehicleBrandIdList(): array
    {
        return $this->idListFromColumn($this->vehicle_brand_id);
    }

    public function vehicleBrands(): Collection
    {
        $ids = $this->vehicleBrandIdList();

        if ($ids === []) {
            return collect();
        }

        return VehicleBrand::query()
            ->whereIn('id', $ids)
            ->orderBy('name')
            ->get();
    }

    public function vehicleBrandNames(): string
    {
        $names = $this->vehicleBrands()->pluck('name');

        return $names->isNotEmpty() ? $names->implode(', ') : 'Not provided';
    }

    public function vehicleTypeIdList(): array
    {
        return $this->idListFromColumn($this->vehicle_type_id);
    }

    public function vehicleTypes(): Collection
    {
        $ids = $this->vehicleTypeIdList();

        if ($ids === []) {
            return collect();
        }

        return VehicleType::query()
            ->whereIn('id', $ids)
            ->orderBy('name')
            ->get();
    }

    public function vehicleTypeNames(): string
    {
        $names = $this->vehicleTypes()->pluck('name');

        return $names->isNotEmpty() ? $names->implode(', ') : 'Not provided';
    }

    public function scopeMatchingSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $query) use ($search) {
            $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('item_code', 'like', "%{$search}%")
                ->orWhere('search_keys', 'like', "%{$search}%");

            self::applyCommaSeparatedMatch(
                $query,
                'vehicle_brand_id',
                VehicleBrand::query()->where('name', 'like', "%{$search}%")->pluck('id')
            );

            self::applyCommaSeparatedMatch(
                $query,
                'vehicle_type_id',
                VehicleType::query()->where('name', 'like', "%{$search}%")->pluck('id')
            );
        });
    }

    private function idListFromColumn(mixed $value): array
    {
        if ($value === null || trim((string) $value) === '') {
            return [];
        }

        return array_values(array_filter(array_map(
            fn ($id) => (int) $id,
            explode(',', (string) $value)
        )));
    }

    private static function applyCommaSeparatedMatch(Builder $query, string $column, Collection $ids): void
    {
        foreach ($ids as $id) {
            $id = (string) $id;

            $query
                ->orWhere($column, $id)
                ->orWhere($column, 'like', "{$id},%")
                ->orWhere($column, 'like', "%,{$id},%")
                ->orWhere($column, 'like', "%,{$id}");
        }
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

    public function hasSize(): bool
    {
        return $this->height !== null || $this->width !== null || $this->length !== null;
    }

    public function formattedSize(): string
    {
        $parts = [];

        if ($this->height !== null) {
            $parts[] = 'H: '.number_format($this->height, 2);
        }

        if ($this->width !== null) {
            $parts[] = 'W: '.number_format($this->width, 2);
        }

        if ($this->length !== null) {
            $parts[] = 'L: '.number_format($this->length, 2);
        }

        return implode(' | ', $parts);
    }

    public function formattedWeight(): ?string
    {
        return $this->weight !== null ? number_format($this->weight, 2) : null;
    }
}
