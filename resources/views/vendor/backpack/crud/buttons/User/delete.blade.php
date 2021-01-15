@if(backpack_user()->can("delete",$crud->model->where("id",$entry->id)->first()))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/delete') }} " class="btn btn-sm btn-link"><i class="la la-trash"></i>Delete</a>
@endif
