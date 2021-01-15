@if ($crud->hasAccess('impersonate') && backpack_user()->can("update",$crud->model->where("id",$entry->id)->first()))
   <a href="{{ url($crud->route.'/'.$entry->getKey().'/impersonate') }} " class="btn btn-sm btn-link {{ backpack_user()->id == $entry->getKey()? 'disabled': '' }}"><i class="fa fa-user"></i> Impersonate</a>
@endif
