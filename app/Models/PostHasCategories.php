<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHasCategories extends Model
{
    use HasFactory,CrudTrait;
    public $timestamps = true;
    protected $primaryKey=["able_id","category_id","able_type"];
    protected $table="post_has_categories";
}
