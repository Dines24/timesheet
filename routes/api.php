<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::match(['post', 'options'], "foo", "MyController")->middleware("cors");

Route::group([
    'prefix' => 'auth'
], function () {
   // die('3');
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

    /******** Department Routes ********/ 
        Route::post('add-department', 'HomeController@addDepartment');
        Route::post('edit-department', 'HomeController@addDepartment');
        Route::get('departments', 'HomeController@showDepartments');
        Route::post('delete-department', 'HomeController@deleteDepartment');
    /******** End Department Routes ********/  

    /******** Designation Routes ********/ 
        Route::post('add-designation', 'HomeController@adddesignation');
        Route::post('edit-designation', 'HomeController@adddesignation');
        Route::get('designation', 'HomeController@showDesignations');
        Route::post('delete-designation', 'HomeController@deleteDesignation'); 
    /******** end Designation Routes ********/

    /******** Employee Routes ********/ 
        Route::post('add-employee', 'HomeController@addEmployee');
        Route::get('employees', 'HomeController@showEmployee');
        Route::post('edit-employee', 'HomeController@addEmployee');
        Route::post('delete-employee', 'HomeController@deleteEmployee');
    /******** Employee Routes ********/ 

    /******** Employee Routes ********/ 
        Route::post('addproject', 'HomeController@addProject');
        // Route::get('employees', 'HomeController@showEmployee');
        // Route::post('edit-employee', 'HomeController@addEmployee');
        // Route::post('delete-employee', 'HomeController@deleteEmployee');
    /******** Employee Routes ********/ 
    /******** Department Routes ********/ 
        Route::get('getprojectsstatus', 'HomeController@getProjectsStatus');
        Route::get('getuserpermission', 'HomeController@getUserPermission');
        Route::post('updatepermission', 'HomeController@updatePermission');
        Route::get('projectlist', 'HomeController@projectList');
        Route::post('deleteproject', 'HomeController@deleteProject');
        Route::post('addremoveprojectuser', 'HomeController@addremoveProjectUser');
        Route::get('getproject', 'HomeController@getProject');
        Route::post('completeproject', 'HomeController@completeProject');
    /******** End Department Routes ********/  


    /**************** tasks */
    Route::post('addtask', 'HomeController@addTask');
    Route::get('tasklist', 'HomeController@taskList');
    Route::post('deletetask', 'HomeController@deleteTask');
    Route::get('gettask', 'HomeController@getTask');
    Route::get('getprojectuser', 'HomeController@getProjectUser');
    Route::get('taskshistory', 'HomeController@tasksHistory');
    Route::post('completetask', 'HomeController@completeTask');
    Route::post('departmenttask', 'HomeController@departmentTask');
    /****************tasks */
    });
});



