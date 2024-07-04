<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImportProductController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=>['auth:admin'],
    'as'=>'dashboard.',
    'prefix'=>'admin/dashboard'
], function (){
    Route::get('/',[DashboardController::class,'index'])
        ->name('dashboard');
    Route::get('/categories/trash',[CategoryController::class,'trash'])
        ->name('categories.trash');
    Route::put('/categories/{category}/restore',[CategoryController::class,'restore'])
        ->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoryController::class,'forceDelete'])
        ->name('categories.force-delete');
    Route::get('/profile/edit',[ProfileController::class,'edit'])
        ->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])
        ->name('profile.update');
    Route::get('products/import', [ImportProductController::class, 'create'])
        ->name('products.import');
    Route::post('products/import',[ImportProductController::class,'store'])
        ->name('products.import');


    Route::resources([
        '/categories'=>CategoryController::class,
        '/products'=>ProductController::class,
        '/roles'=>RoleController::class,
        '/users'=>UserController::class,
        '/admins'=>AdminController::class,

    ]);

});
