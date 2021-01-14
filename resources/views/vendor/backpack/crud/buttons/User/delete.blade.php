@if(backpack_user()->hasRole("Admin"))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/delete') }} " class="btn btn-sm btn-link"><i class="la la-edit"></i>Delete</a>
@endif
