<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'make_id', 'type', 'model', 'year', 'price',
        'mileage', 'fuel_type', 'transmission', 'engine_cc',
        'color', 'condition_type', 'city', 'description',
        'status', 'featured', 'views',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price'    => 'decimal:2',
    ];

    // ---- Relationships ----
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // ---- Scopes ----
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOfType($query, $type)
    {
        return $type ? $query->where('type', $type) : $query;
    }

    // ---- Helpers ----
    public function formattedPrice(): string
    {
        $p = $this->price;
        if ($p >= 10000000) return 'Rs. ' . number_format($p / 10000000, 2) . ' Crore';
        if ($p >= 100000)   return 'Rs. ' . number_format($p / 100000, 2)  . ' Lakh';
        return 'Rs. ' . number_format($p, 0);
    }

    public function emoji(): string
    {
        if ($this->type === 'bike') return '🏍️';
        $map = ['Toyota'=>'🚗','Honda'=>'🚙','Suzuki'=>'🚘','Hyundai'=>'🚕',
                'Kia'=>'🛻','BMW'=>'🏎️','Mercedes'=>'🚐','Audi'=>'🚗'];
        return $map[$this->make->name ?? ''] ?? '🚗';
    }

    public function title(): string
    {
        return $this->year . ' ' . ($this->make->name ?? '') . ' ' . $this->model;
    }
}
