<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/get-products', [ProductController::class, 'getProducts']);
Route::post('/get-filter-list/{subcategory_id}', [FilterController::class, 'getFilterList']);
Route::get('/get-menu', MenuController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/permissions', [PermissionController::class, 'index'])
        ->middleware('permission:show permissions');
    Route::prefix('/permission')->group(function () {
        Route::post('/create', [PermissionController::class, 'create'])
            ->middleware('permission:create permissions');
        Route::get('/{id}', [PermissionController::class, 'show'])
            ->middleware('permission:show permissions');
        Route::post('/{id}/update', [PermissionController::class, 'update'])
            ->middleware('permission:update permissions');
        Route::post('/{id}/delete', [PermissionController::class, 'delete'])
            ->middleware('permission:delete permissions');
    });

    Route::get('/roles', [RoleController::class, 'index'])
        ->middleware('permission:show roles');
    Route::prefix('/role')->group(function () {
        Route::post('/create', [RoleController::class, 'create'])
            ->middleware('permission:create roles');
        Route::get('/{id}', [RoleController::class, 'show'])
            ->middleware('permission:show roles');
        Route::post('/{id}/update', [RoleController::class, 'update'])
            ->middleware('permission:update roles');
        Route::post('/{id}/delete', [RoleController::class, 'delete'])
            ->middleware('permission:delete roles');
        Route::post('/{id}/give-permissions', [RoleController::class, 'givePermissions'])
            ->middleware('permission:update roles');
    });

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:show users');
    Route::prefix('/user')->group(function () {
        Route::post('/create', [UserController::class, 'create'])
            ->middleware('permission:create users');
        Route::get('/{id}', [UserController::class, 'show'])
            ->middleware('permission:show users');
        Route::post('/{id}/update', [UserController::class, 'update']);
        Route::post('/{id}/delete', [UserController::class, 'delete'])
            ->middleware('permission:delete users');
        Route::post('/{id}/update-password', [UserController::class, 'updatePassword']);
    });

    Route::group(['middleware' => ['permission:show products and product features']], function () {
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/product/{id}', [ProductController::class, 'show']);

        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/category/{id}', [CategoryController::class, 'show']);
        Route::get('/category/{id}/subcategories', [CategoryController::class, 'getSubcategories']);
        Route::get('/category/{id}/sizes', [CategoryController::class, 'getSizes']);

        Route::get('/subcategories', [SubcategoryController::class, 'index']);
        Route::get('/subcategory/{id}', [SubcategoryController::class, 'show']);
        Route::get('/subcategory/{id}/types', [SubcategoryController::class, 'getTypes']);

        Route::get('/types', [TypeController::class, 'index']);
        Route::get('/type/{id}', [TypeController::class, 'show']);

        Route::get('/manufacturers', [ManufacturerController::class, 'index']);
        Route::get('/manufacturer/{id}', [ManufacturerController::class, 'show']);

        Route::get('/sizes', [SizeController::class, 'index']);
        Route::get('/size/{id}', [SizeController::class, 'show']);

        Route::get('/colors', [ColorController::class, 'index']);
        Route::get('/color/{id}', [ColorController::class, 'show']);

        Route::get('/materials', [MaterialController::class, 'index']);
        Route::get('/material/{id}', [MaterialController::class, 'show']);

        Route::get('/seasons', [SeasonController::class, 'index']);
        Route::get('/season/{id}', [SeasonController::class, 'show']);
    });

    Route::group(['middleware' => ['permission:create products and product features']], function () {
        Route::post('/product/create', [ProductController::class, 'create']);
        Route::post('/category/create', [CategoryController::class, 'create']);
        Route::post('/subcategory/create', [SubcategoryController::class, 'create']);
        Route::post('/type/create', [TypeController::class, 'create']);
        Route::post('/manufacturer/create', [ManufacturerController::class, 'create']);
        Route::post('/size/create', [SizeController::class, 'create']);
        Route::post('/color/create', [ColorController::class, 'create']);
        Route::post('/material/create', [MaterialController::class, 'create']);
        Route::post('/season/create', [SeasonController::class, 'create']);
    });

    Route::group(['middleware' => ['permission:update products and product features']], function () {
        Route::post('/product/{id}/update', [ProductController::class, 'update']);
        Route::post('/category/{id}/update', [CategoryController::class, 'update']);
        Route::post('/subcategory/{id}/update', [SubcategoryController::class, 'update']);
        Route::post('/type/{id}/update', [TypeController::class, 'update']);
        Route::post('/manufacturer/{id}/update', [ManufacturerController::class, 'update']);
        Route::post('/size/{id}/update', [SizeController::class, 'update']);
        Route::post('/color/{id}/update', [ColorController::class, 'update']);
        Route::post('/material/{id}/update', [MaterialController::class, 'update']);
        Route::post('/season/{id}/update', [SeasonController::class, 'update']);
    });

    Route::group(['middleware' => ['permission:delete products and product features']], function () {
        Route::post('/product/{id}/delete', [ProductController::class, 'delete']);
        Route::post('/category/{id}/delete', [CategoryController::class, 'delete']);
        Route::post('/subcategory/{id}/delete', [SubcategoryController::class, 'delete']);
        Route::post('/type/{id}/delete', [TypeController::class, 'delete']);
        Route::post('/manufacturer/{id}/delete', [ManufacturerController::class, 'delete']);
        Route::post('/size/{id}/delete', [SizeController::class, 'delete']);
        Route::post('/color/{id}/delete', [ColorController::class, 'delete']);
        Route::post('/material/{id}/delete', [MaterialController::class, 'delete']);
        Route::post('/season/{id}/delete', [SeasonController::class, 'delete']);
    });
});
