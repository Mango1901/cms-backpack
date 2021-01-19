<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table="posts";
    protected $primaryKey = "id";
    protected $fillable=["title","user_id","url","category_id","tag_id","description","excerpt","image","status","format_id"];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function Tag(){
        return $this->belongsTo(Tag::class,"tag_id","id");
    }
    public function Format(){
        return $this->belongsTo(Format::class,"format_id","id");
    }
}
