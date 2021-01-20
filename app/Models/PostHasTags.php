<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHasTags extends Model
{
    use HasFactory,CrudTrait;
    public $timestamps = true;
    protected $primaryKey=["tagable_id","tag_id","tagable_type"];
    protected $table="post_has_tags";
}
