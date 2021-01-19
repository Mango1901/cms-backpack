<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('post', 'posts');
        if(backpack_user()->hasRole("User")){
            $this->crud->denyAccess("create");
            $this->crud->denyAccess("update");
            $this->crud->denyAccess("delete");
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("update");
                $this->crud->addButton('line', 'edit', 'view', 'crud::buttons.Post.edit',"beginning");
        $this->crud->removeButton("delete");
                $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.Post.delete');
        CRUD::addColumn('title');
        CRUD::addColumn([
            "name"=>"description",
            "label"=>"Description",
            "type"=>"textarea"
        ]);
        CRUD::addColumn([
            "name"=>"excerpt",
            "label"=>"Excerpt",
            "type"=>"text"
        ]);
        CRUD::addColumn([
            "name"=>"url",
            "label"=>"Send TrackBacks",
            "type"=>"text",
            'href' => function ($crud, $column, $entry, $related_key) {
                return ($entry->url);
            },
        ]);
        CRUD::addColumn([
            'name'         => 'format_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Format',
            'entity' => "Format",
            'attribute' =>'name',
            'model' => "App\Models\Format",
        ]);
        $this->crud->addColumn([
            'name' => 'image', // The db column name
            'label' => "Post Image", // Table column heading
            'type' => 'image',
        ]);
        CRUD::addColumn([
            'name'         => 'tag_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Tags',
            'entity' => "Tag",
            'attribute' =>'name',
            'model' => "App\Models\Tag",
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('tag/'.$entry->tag_id.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'name'         => 'category_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Category',
            'entity' => "Category",
            'attribute' =>'name',
            'model' => "App\Models\Category",
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('category/'.$entry->category_id.'/show');
                },
            ],
        ]);
        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
    public function setupShowOperation(){
        $this->crud->removeButton("update");
        $this->crud->addButton('line', 'edit', 'view', 'crud::buttons.Post.edit',"beginning");
        $this->crud->removeButton("delete");
        $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.Post.delete');
        CRUD::addColumn('title');
        CRUD::addColumn([
            "name"=>"user_id",
            'type'=> 'select',
            "label"=>"Author",
            'entity' => "User",
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('user/'.$entry->user_id.'/show');
                },
            ],
            'model' => "App\Models\User",
        ]);
        CRUD::addColumn([
            'name'         => 'tag_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Tags',
            'entity' => "Tag",
            'attribute' =>'name',
            'model' => "App\Models\Tag",
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('tag/'.$entry->tag_id.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'name'         => 'category_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Category',
            'entity' => "Category",
            'attribute' =>'name',
            'model' => "App\Models\Category",
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('category/'.$entry->category_id.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'name'         => 'format_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Format',
            'entity' => "Format",
            'attribute' =>'name',
            'model' => "App\Models\Format",
        ]);
        $this->crud->addColumn([
            'name' => 'image', // The db column name
            'label' => "Post Image", // Table column heading
            'type' => 'image',
        ]);
        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');

    }
    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->addFields([
                [
                    'label'     => "Category",
                    'type'      => 'relationship',
                    'name'      => 'category_id', // the db column for the foreign key

                    // optional
                    'entity'    => 'Category', // the method that defines the relationship in your Model
                    'model'     => "\App\Models\Category", // foreign key model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'default'   => 1, // set the default value of the select2
                    'inline_create' => true,
                    'ajax' => true,
                    // also optional
                    'options'   => (function ($query) {
                        return $query->orderBy('id', 'ASC')->get();
                    }),
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'label'     => "Format",
                    'type'      => 'select',
                    'name'      => 'format_id', // the db column for the foreign key

                    // optional
                    'entity'    => 'Format', // the method that defines the relationship in your Model
                    'model'     => "\App\Models\Format", // foreign key model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'default'   => 1, // set the default value of the select2
                    // also optional
                    'options'   => (function ($query) {
                        return $query->orderBy('id', 'ASC')->get();
                    }),
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'label'     => "Tags",
                    'type'      => 'relationship',
                    'name'      => 'tag_id', // the method that defines the relationship in your Model

                    // optional
                    'entity'    => 'Tag', // the method that defines the relationship in your Model
                    'model'     => "App\Models\Tag", // foreign key model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'inline_create' => true,
                    'ajax' => true,
                    // 'select_all' => true, // show Select All and Clear buttons?

                    // optional
                    'options'   => (function ($query) {
                        return $query->orderBy('id', 'ASC')->get();
                    }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
        ]);
        CRUD::addField([
            "name"=>"title",
            'type'  => 'text',
            "label"=>"title"
        ]);
        CRUD::addField([
            "name"=>"excerpt",
            'type'  => 'text',
            "label"=>"Excerpt"
        ]);
        CRUD::addField([
            "name"=>"url",
            'type'  => 'text',
            "label"=>"Send TrackBacks"
        ]);
        CRUD::addField([
            "name"=>"description",
            'type'  => 'ckeditor',
            "label"=>"Description",
        ]);
        $this->crud->addField([
            'label'        => "Post Image",
            'name'         => "image",
            'filename'     => "image_filename", // set to null if not needed
            'type'         => 'image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);
        CRUD::addField([
            'label'     => 'Published',
            'name'  => 'status',
            'type'  => 'checkbox',
            "default"=>"1",
        ]);
        CRUD::addField([
            'label'     => 'Allow Comments',
            'name'  => 'allow_comments',
            'type'  => 'checkbox',
            "default"=>"1",
        ]);

        CRUD::addField([
            "label"=>"User",
            "name"=>"user_id",
            "type"=>"hidden",
            "default"=>backpack_user()->id
        ]);
        CRUD::setValidation(PostRequest::class);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }
    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $post = Post::where("id",$this->crud->getCurrentEntryId())->first();
        if(!backpack_user()->can("update",$post)){
            abort(403);
        }
        $this->setupCreateOperation();
    }
    public function fetchCategory()
    {
        return $this->fetch(\App\Models\Category::class);
    }
    public function fetchTag()
    {
        return $this->fetch(\App\Models\Tag::class);
    }

}
