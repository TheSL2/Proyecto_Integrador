<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Auditoria;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('planificar-auditoria', function (User $user) {
            return in_array($user->rol, ['Administrador del Sistema', 'Consultor']);
        });

        Gate::define('ejecutar-auditoria', function (User $user, Auditoria $auditoria) {
            if (!in_array($user->rol, ['Auditor', 'Consultor', 'Administrador del Sistema'])) {
                return false;
            }

            if ($user->rol === 'Auditor') {
                return !$auditoria->areas->contains('responsable_id', $user->id);
            }

            return true;
        });

        Gate::define('subir-evidencias', function (User $user) {
            return in_array($user->rol, ['Auditado', 'Auditor', 'Consultor', 'Administrador del Sistema']);
        });

        Gate::define('gestionar-acciones-correctivas', function (User $user) {
            return in_array($user->rol, ['Auditado', 'Auditor', 'Consultor', 'Administrador del Sistema']);
        });

        Gate::define('ver-dashboard-ejecutivo', function (User $user) {
            return in_array($user->rol, ['Alta Dirección', 'Administrador del Sistema', 'Consultor']);
        });

        Gate::define('gestionar-usuarios', function (User $user) {
            return $user->rol === 'Administrador del Sistema';
        });
    }
}
