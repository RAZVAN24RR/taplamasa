<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'price',
        'item_1',
        'item_2',
        'item_3'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function scopeForDay($query, $day)
    {
        return $query->where('day', $day);
    }

    public function getItemsAttribute()
    {
        return [
            $this->item_1,
            $this->item_2,
            $this->item_3
        ];
    }
}
