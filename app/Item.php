<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=[
        'name', 'description', 'collection_id'
    ];
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    public function image()
    {
        return $this->hasOne(Image::class);
    }
    public function lovedByUsers() 
    {
        return $this->belongsToMany(User::class);
    }
}
