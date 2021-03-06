<?php

namespace App\Models;

use App\PostIndexConfigurator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;
use Venturecraft\Revisionable\RevisionableTrait;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use RevisionableTrait;
    use HasFactory;
    use Searchable;
    protected $indexConfigurator = PostIndexConfigurator::class;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500; //Stop tracking revisions after 500 changes have been made.
    protected $table="posts";
    protected $primaryKey = "id";
   protected $guarded = ["id"];
    protected $casts = [
        'custom_fields' => 'array',
    ];
    protected $searchRules = [
        //
    ];
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                // Also you can configure multi-fields, more details you can find here https://www.elastic.co/guide/en/elasticsearch/reference/current/multi-fields.html
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ]
                ]
            ],
        ]
    ];
    public function category()
    {
        return $this->morphToMany(
            Category::class,
            'cateable',
            "cateable",
            "cateable_id",
            'category_id'
        );
    }
    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function tag()
    {
        return $this->morphToMany(
            Tag::class,
            'taggable',
            "taggable",
           "taggable_id",
            'tag_id'
        );
    }
    public function openGoogle($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="http://google.com?q='.urlencode($this->title).'" data-toggle="tooltip" title="Just a demo custom button."><i class="la la-search"></i> Google it</a>';
    }
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = config("save_disk.post_thumb");
        $destination_path = "/";
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk(config("save_disk.post_thumb"))->delete($obj->image);
        });
    }
    public function getSlugWithLink(){
        return '<a target="_blank" href="http://google.com?q='.urlencode(($this->url)).'" data-toggle="tooltip">'.$this->url.'</a>';
    }


}
