<?php

Route::get('login', [
    'as' => 'login',
    'uses' => 'LoginController@index'
]);

Route::post('login', [
    'as' => 'login.store',
    'uses' => 'LoginController@store'
]);

Route::get('logout', [
    'as' => 'logout',
    'uses' => 'LoginController@logout'
]);

Route::get('/', [
    'middleware' => 'auth',
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Route::get('test', 'Api\OrderController@test');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'notification']], function () {

    Route::resource('target', 'Admin\TargetController');


    Route::resource('store-target-data', 'Admin\TargetController');


    Route::resource('users', 'Admin\UserController');

    Route::get('profile', [
        'as' => 'admin.profile.index',
        'uses' => 'Admin\UserController@profile']);

    Route::resource('areas', 'Admin\AreaController');

    Route::resource('companies', 'Admin\CompanyController');

    Route::post('attendence/exportExcel', [
        'as' => 'admin.attendance.exportExcel',
        'uses' => 'Admin\AttendenceController@exportExcel'
    ]);

    Route::resource('attendance', 'Admin\AttendenceController');

    Route::resource('products', 'Admin\ProductController');


    Route::resource('categories', 'Admin\CategoryController');

    Route::get('specifications/excel', [
        'as' => 'admin.specifications.excel',
        'uses' => 'Admin\PaperController@excel'
    ]);

    Route::post('specifications/excel', [
        'as' => 'admin.specifications.excelStore',
        'uses' => 'Admin\PaperController@excelStore'
    ]);

    Route::resource('specifications', 'Admin\PaperController');

    Route::get('designs/excel', [
        'as' => 'admin.designs.excel',
        'uses' => 'Admin\DesignController@excel'
    ]);

    Route::post('designs/excel', [
        'as' => 'admin.designs.excelStore',
        'uses' => 'Admin\DesignController@excelStore'
    ]);

    Route::resource('designs', 'Admin\DesignController');

    Route::get('expense', [
        'as' => 'admin.expance.datatable',
        'uses' => 'Admin\ExpanceController@dataShow'
    ]);

    Route::post('expense/exportExcel', [
        'as' => 'admin.expance.exportExcel',
        'uses' => 'Admin\ExpanceController@exportExcel'
    ]);

    Route::get('expense/{id}', [
        'as' => 'admin.expance.index',
        'uses' => 'Admin\ExpanceController@index'
    ]);

    Route::get('tasks', [
        'as' => 'admin.tasks.datatable',
        'uses' => 'Admin\TaskController@dataShow'
    ]);

    Route::get('tasks/{id}', [
        'as' => 'admin.tasks.index',
        'uses' => 'Admin\TaskController@index'
    ]);

    Route::get('tasks/{id}/create', [
        'as' => 'admin.tasks.create',
        'uses' => 'Admin\TaskController@create'
    ]);

    Route::post('tasks/{id}/store', [
        'as' => 'admin.tasks.store',
        'uses' => 'Admin\TaskController@store'
    ]);

    Route::get('tasks/{id}/edit', [
        'as' => 'admin.tasks.edit',
        'uses' => 'Admin\TaskController@edit'
    ]);

    Route::put('tasks/{id}/update', [
        'as' => 'admin.tasks.update',
        'uses' => 'Admin\TaskController@update'
    ]);

    Route::get('tasks/{id}/responce', [
        'as' => 'admin.tasks.responce',
        'uses' => 'Admin\TaskController@responce'
    ]);

    Route::post('tasks/{id}/approval', [
        'as' => 'admin.tasks.approval',
        'uses' => 'Admin\TaskController@approval'
    ]);

    Route::post('task/excel', [
        'as' => 'admin.tasks.exportExcel',
        'uses' => 'Admin\TaskController@exportExcel'
    ]);

    Route::post('orders/exportExcel', [
        'as' => 'admin.orders.exportExcel',
        'uses' => 'Admin\OrderController@exportExcel'
    ]);

    Route::resource('orders', 'Admin\OrderController');


    Route::resource('notifications', 'Admin\NotificationController');


    Route::group(['prefix' => 'ajax'], function () {
        Route::post('upload/image', [
            'as' => 'image-post',
            'uses' => 'UploadController@storeImage'
        ]);

        Route::post('users/login-list','Admin\AttendenceController@login_list');

        Route::get('map', 'Admin\MapShowController@index');

        Route::get('users/data', 'Admin\UserController@datatable');

        Route::post('users/delete', 'Admin\UserController@delete');

        Route::get('papers/data', 'Admin\PaperController@datatable');
        Route::post('papers/delete', 'Admin\PaperController@delete');

        Route::get('designs/data', 'Admin\DesignController@datatable');
        Route::post('designs/delete', 'Admin\DesignController@delete');

        Route::get('areas/data', 'Admin\AreaController@datatable');
        Route::get('areas/cities', 'Admin\AreaController@cities');
        Route::post('areas/delete', 'Admin\AreaController@delete');

        Route::get('areas', 'Admin\AreaController@data');

        Route::get('companies/data', 'Admin\CompanyController@datatable');
        Route::post('companies/delete', 'Admin\CompanyController@delete');

        Route::get('tasks/data', 'Admin\TaskController@datatable');
        Route::post('tasks/delete', 'Admin\TaskController@delete');

        Route::post('tasks/store', 'Admin\TaskController@ajaxStore');

        Route::get('tasks', 'Admin\TaskController@getTask');

        Route::post('tasks', 'Admin\TaskController@updateTask');

        Route::post('users/companies', 'Admin\UserController@getCompanies');

        Route::get('users/areas', 'Admin\UserController@getSalesperson');

        Route::get('users', 'Admin\UserController@getUsersData');

        Route::get('attendence/data', 'Admin\AttendenceController@datatable');

        Route::get('categories/data', 'Admin\CategoryController@datatable');
        Route::post('categories/delete', 'Admin\CategoryController@delete');

        Route::get('products/data', 'Admin\ProductController@datatable');
        Route::post('products/delete', 'Admin\ProductController@delete');
        Route::post('products/images', 'Admin\ProductController@images');

        Route::post('product-image/delete', 'Admin\ProductController@imageDelete');

        Route::get('expance/data', 'Admin\ExpanceController@datatable');
        Route::post('expance/approved', 'Admin\ExpanceController@approved');
        Route::post('expance/rejected', 'Admin\ExpanceController@rejected');

        Route::get('orders', 'Admin\OrderController@data');

        Route::get('multiple-orders', 'Admin\OrderController@getMultipleOrders');

        Route::get('orders/data', 'Admin\OrderController@datatable');


        Route::post('orders/status', 'Admin\OrderController@status');

        Route::post('orders/eta', 'Admin\OrderController@eta');


        Route::get('notifications/data', 'Admin\NotificationController@datatable');
    });
});

Route::group(['prefix' => 'api/V1'], function () {

    Route::post('login', 'Api\AuthController@login');

    Route::post('admin-login', 'Api\AuthController@admin_login');

    Route::post('logout', 'Api\AuthController@logout');



    Route::post('current-location', 'Api\CurrentLocationController@store');
});

Route::group(['prefix' => 'api/V1', 'middleware' => 'attendence'], function () {


    //temp
    Route::resource('notifications', 'Admin\NotificationController');


    Route::post('tasks/{id}', 'Api\TaskController@store');

    Route::get('tasks/{id}', 'Api\TaskController@show');

    Route::get('tasks', 'Api\TaskController@get');

    Route::get('attendence', 'Api\AttendenceController@get');

    Route::post('attendence/start-day', 'Api\AttendenceController@store');

    Route::post('attendence/end-day', 'Api\AttendenceController@store');

    Route::post('attendence/{id}/update', 'Api\AttendenceController@update');

    Route::get('products', 'Api\ProductController@get');

    //created by hms
    Route::get('products-list', 'Api\ProductController@getProductList');

    Route::get('products/{id}', 'Api\ProductController@show');

    Route::get('products-categories', 'Api\ProductController@categories');

    //created by hms
    Route::get('category-list', 'Api\ProductController@categoriesList');

    Route::get('specifications', 'Api\ProductController@specificationsList');

    Route::get('expance', 'Api\ExpanceController@index');

    Route::get('expance/{day}', 'Api\ExpanceController@getExpenseByDay');

    Route::get('create-expense', 'Api\ExpenseController@create');

    Route::post('expance', 'Api\ExpanceController@store');

    Route::post('companies', 'Api\CompanyController@store');

    Route::get('companies/create', 'Api\CompanyController@create');

    Route::get('companies/{id}', 'Api\CompanyController@show');

    Route::get('companies', 'Api\CompanyController@get');

    Route::resource('profile', 'Api\UserController');

    Route::post('users/change-password', 'Api\UserController@change_password');

    Route::resource('orders', 'Api\OrderController');

    Route::post('add-order', 'Api\OrderController@store');



///////////////////////////////////////////
/// TargetController not working in project thas why created new TargetsController and pls keep commented TargetController's routes
/// ///////////////////////////////////////////

    //Route::post('target-statistic', 'Api\TargetController@target_statistic');

    Route::post('daily-target', 'Api\TargetsController@target_statistic');

    //Route::post('target-monthly', 'Api\TargetController@m');

    Route::post('monthly-target', 'Api\TargetsController@monthly_target');



    Route::post('get-expenses', 'Api\ExpenseController@monthly_expenses');

    Route::get('calendar', 'Api\CalendarController@index');

    Route::get('target-report', 'Api\TargetController@index');

    Route::resource('notification', 'Api\NotificationController');


});
