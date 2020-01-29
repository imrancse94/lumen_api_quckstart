<?php

namespace App\Providers;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsergroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Repository\UsergroupRepository;
use App\Repository\ProductRepository;
use App\Repository\Repository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(ProductRepository::class);
       // $this->app->bind('App\Repositories\Usergroup\UsergroupInterface', 'App\Repositories\Usergroup\UsergroupRepo');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->when([UserController::class, ProductApiController::class])
            ->needs(Repository::class)->give(function($app){
                return $this->app->make(UserRepository::class);
            });

        $this->app->when([AuthController::class])
            ->needs(Repository::class)->give(function($app){
                return $this->app->make(UserRepository::class);
        });

        /*$this->app->when([UsergroupController::class])
            ->needs(Repository::class)->give(function($app){
                return $this->app->make(UsergroupRepository::class);
            });*/

        $this->app->when([UsergroupController::class])
            ->needs(Repository::class)->give(function(){
                return $this->app->make(UsergroupRepository::class);
            });
    }
}
