<?php
use Illuminate\Support\Facades\Route;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['web', backpack_middleware()]
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
    Route::get('posts/ajax-custom-fields-options', 'PostCrudControllerOperation@customFieldsOptions');
    Route::get('posts/ajax-category-options', 'PostCrudControllerOperation@categoryOptions');
    Route::get('posts/ajax-tag-options', 'PostCrudControllerOperation@tagOptions');
    Route::crud('permission', 'PermissionCrudControllerOperation');
    Route::crud('role', 'RoleCrudControllerOperation');
    Route::crud('user', 'UserCrudControllerOperation');
    Route::crud('category', 'CategoryCrudControllerOperation');
    Route::crud('tag', 'TagCrudControllerOperation');
    Route::crud('post', 'PostCrudControllerOperation');
    Route::get('charts/new-entries', 'Charts\NewEntriesChartController@response')->name('charts.new-entries.index');
}); // this should be the absolute last line of this file
