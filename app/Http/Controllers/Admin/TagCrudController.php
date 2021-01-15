<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\NewsCRUD\app\Http\Requests\TagRequest;
use CRUD;

class TagCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    public function setup()
    {
        $this->crud->setModel("App\Models\Tag");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/tag');
        $this->crud->setEntityNameStrings('tag', 'tags');
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        $this->crud->addColumn([
            // any type of relationship
            'name'         => 'user_id', // name of relationship method in the model
            'type'         => 'select',
            'label'        => 'Author', // Table column heading
            // OPTIONAL
             'entity'    => 'User', // the method that defines the relationship in your Model
             'attribute' => 'name', // foreign key attribute that is shown to user
             'model'     => \App\Models\User::class, // foreign key model
        ]);
        CRUD::addColumn("name");
        CRUD::addColumn("slug");
        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');

    }
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TagRequest::class);
        CRUD::addField([
            "label"=>"User",
            "name"=>"user_id",
            "type"=>"hidden",
            "default"=>backpack_user()->id
        ]);
        CRUD::setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(TagRequest::class);
    }
}
