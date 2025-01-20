<?php

namespace Innoboxrr\S3ResumableUploads\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public function map()
    {
        $this->mapRoutes();      
    }

    protected function mapRoutes()
    {

        Route::middleware('api')
            ->prefix('s3resumableuploads')
            ->as('s3resumableuploads.')
            ->middleware('web')
            ->namespace('Innoboxrr\S3ResumableUploads\Http\Controllers')
            ->group(__DIR__ . '/../../routes/web.php');

    }

}
