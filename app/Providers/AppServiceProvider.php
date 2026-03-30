<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\EquipRepository;
use App\Repositories\EstadiRepository;
use App\Repositories\JugadoraRepository;
use App\Repositories\PartitRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepository::class, EquipRepository::class);
        $this->app->bind('App\Repositories\EstadiRepositoryInterface', EstadiRepository::class);
        $this->app->bind('App\Repositories\JugadoraRepositoryInterface', JugadoraRepository::class);
        $this->app->bind('App\Repositories\PartitRepositoryInterface', PartitRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
