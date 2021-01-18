<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\NewsCRUD\app\Http\Requests\TagRequest;
use CRUD;

class TagCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    public function setup()
    {
        $this->crud->setModel("App\Models\Tag");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/tag');
        $this->crud->setEntityNameStrings('tag', 'tags');
        $this->setupListOperation();
        if(backpack_user()->hasRole("User")){
            $this->crud->denyAccess("create");
            $this->crud->denyAccess("update");
            $this->crud->denyAccess("delete");
        }
    }
    protected function setupListOperation(){
        $this->crud->removeButton("update");
            $this->crud->addButton('line', 'edit', 'view', 'crud::buttons.Tags.edit',"beginning");
        $this->crud->removeButton("delete");
            $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.Tags.delete');
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
    protected function setupShowOperation(){
        $this->crud->removeButton("update");
        $this->crud->addButton('line', 'edit', 'view', 'crud::buttons.Post.edit',"beginning");
        $this->crud->removeButton("delete");
        $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.Post.delete');
        $this->setupListOperation();
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
        $tag = Tag::where("id",$this->crud->getCurrentEntryId())->first();
        if(backpack_user()->cannot("update",$tag)){
            abort(403);
        }
        $this->crud->setValidation(TagRequest::class);
    }
}
