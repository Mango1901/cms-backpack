<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    use HasFactory,CrudTrait;
    public $timestamps = true;
    protected $primaryKey=["taggable_id","tag_id","taggable_type"];
    protected $table="taggable";
}
