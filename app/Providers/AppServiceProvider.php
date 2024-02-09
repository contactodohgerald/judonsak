<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Task;
use App\Models\Instruction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $tasks = Task::orderBy('tasks.id', 'desc')->get();
        $tasks->load('instruction.contract.client', 'status', 'executor');

        View::share('tasks', $tasks);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
