<?php
namespace App\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFields extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'custom_fields';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name',"user_id",'content'];
    // protected $hidden = [];
    // protected $dates = [];
}
