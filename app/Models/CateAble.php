<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateAble extends Model
{
    use HasFactory,CrudTrait;
    public $timestamps = true;
    protected $primaryKey=["cateable_id","category_id","cateable_type"];
    protected $table="cateable";
}
