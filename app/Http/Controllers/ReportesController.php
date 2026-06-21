<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function ventasPorMes()
    {
        // Agrupar ventas por mes
        $ventas = Compra::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Formato para Google Charts
        $chartData[] = ['Mes', 'Total de Ventas'];

        foreach ($ventas as $v) {
            $chartData[] = [
                $this->nombreMes($v->mes),
                floatval($v->total)
            ];
        }

        return view('ventas_mes', [
            'chartData' => json_encode($chartData)
        ]);
    }

    private function nombreMes($num)
    {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        return $meses[$num] ?? 'N/A';
    }
}
