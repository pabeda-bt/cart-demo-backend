<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $appends=['total'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status'
    ];

    public function items(){
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute(){
        return $this->items()->sum('total_price');
    }
}
