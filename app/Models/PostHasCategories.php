<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHasCategories extends Model
{
    use HasFactory,CrudTrait;
    public $timestamps = true;
    protected $primaryKey=["post_id","category_id"];
    protected $table="post_has_categories";
}
