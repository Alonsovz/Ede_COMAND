<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\Permiso\PermisoRepository;
use PDF;
use DB;

class ImprimirPermiso implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    

    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $permiso = DB::table('permisos')
                            ->join('users as empleado','empleado.id','=','permisos.user_id')
                            ->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
                            ->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
                            ->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
                            ->select('permisos.*',
                                'empleado.nombre as nombreempleado',
                                'empleado.apellido as apellidoempleado',
                                'jefatura.nombre as nombrejefe',
                                'jefatura.apellido as apellidojefe',
                                'rh_estados.nombre as estado',
                                'tipos_permisos.tipo as tipopermiso')
                            ->where('permisos.user_id',1)
                            ->orderBy('permisos.id','desc')
                            ->get();

        $pdf = PDF::loadview('permisos.permisosPDF',$permiso);

        return $pdf->download('permiso.pdf');
    }
}
