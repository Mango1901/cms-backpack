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
        CRUD::addField([
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
        ]);
        CRUD::addField([
            "name"=>"title",
            'type'  => 'text',
            "label"=>"title"
        ]);
        CRUD::addField([
            "name"=>"description",
            'type'  => 'ckeditor',
            "label"=>"Description",
        ]);
        CRUD::addField([
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
