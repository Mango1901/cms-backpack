<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
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
        if(!backpack_user()->hasRole("Admin")){
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
        CRUD::addColumn('title');
        CRUD::addColumn([
            "name"=>"user_id",
            'type'=> 'select',
            "label"=>"Author",
            'entity' => "User",
            'attribute' => 'name',
            'model' => "App\Models\User",
        ]);
        CRUD::addColumn([
                'name'         => 'category_id', // name of relationship method in the model
                'type'         => 'select',
                'label'        => 'Category',
                'entity' => "Category",
                'attribute' =>'name',
                'model' => "App\Models\Category",
        ]); // Table column heading);
        CRUD::addColumn([
            'name'         => 'tag_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Tags',
            'entity' => "Tag",
            'attribute' =>'name',
            'model' => "App\Models\Tag",
        ]); // Table column heading);
        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
    public function setupShowOperation(){
        CRUD::addColumn('title');
        CRUD::addColumn([
            "name"=>"user_id",
            'type'=> 'select',
            "label"=>"Author",
            'entity' => "User",
            'attribute' => 'name',
            'model' => "App\Models\User",
        ]);
        CRUD::addColumn([
            'name'         => 'category_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Category',
            'entity' => "Category",
            'attribute' =>'name',
            'model' => "App\Models\Category",
        ]); // Table column heading);
        CRUD::addColumn([
            'name'         => 'tag_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Tags',
            'entity' => "Tag",
            'attribute' =>'name',
            'model' => "App\Models\Tag",
        ]); // Table column heading);
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
            'type'      => 'select',
            'name'      => 'category_id', // the db column for the foreign key

            // optional
            'entity'    => 'Category', // the method that defines the relationship in your Model
            'model'     => "\App\Models\Category", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 2, // set the default value of the select2

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
            'label'     => "Tags",
            'type'      => 'select',
            'name'      => 'tag_id', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'Tag', // the method that defines the relationship in your Model
            'model'     => "App\Models\Tag", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
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
        $this->setupCreateOperation();
    }
}
