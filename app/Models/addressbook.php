<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addressbook extends Model
{
    use HasFactory;
    protected $fillable = ['firstName','lastName','email','phone','street','zipcode','slug','city_id','profilePic'];
    protected  $primaryKey = 'slug';
    public $incrementing = false;

    public function city()
    {
        return $this->hasOne(city::class,'id','city_id');
    }
}
