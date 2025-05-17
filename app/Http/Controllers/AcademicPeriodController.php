<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicPeriodHelper;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use App\Http\Controllers\Controller;


class AcademicPeriodController extends Controller
{
    private $modulo;
    private $breadcume;
    private $id;
    private $permiso;

    public function __construct() {
        $this->id = 17;
        $this->permiso = 0;

        if (!isset($_SESSION['usuarioCalidad'])) {
            \Redirect::to(url('/'))->send();
        }

        if (isset($_SESSION['permisosCalidad'][$this->id])) {
            $this->permiso = $_SESSION['permisosCalidad'][$this->id];
        }

        $this->modulo = "Periodo Académico";
        $this->breadcume = array(
            array('url' => '', 'nombre' => $this->modulo)
        );
    }

    /**
     * Show all academic periods
     */
    public function index ()
    {
        $periods = AcademicPeriod::orderBy('start_year')
        ->orderBy('start_month')
        ->orderBy('end_year')
        ->orderBy('end_month')
        ->get();

        $data['periods'] = $periods->map(function ($periodData) {
            return [
                'id' => $periodData->id,
                'name' => AcademicPeriodHelper::formatName($periodData),
                'enabled' => $periodData->enabled ? 'ACTIVO' : 'INACTIVO'
            ];
        });

        $data['modulo'] = $this->modulo;
        $data['breadcume'] = $this->breadcume;
        $data['permiso'] = $this->permiso;

        return view('AcademicPeriod/index', $data);
    }

    /**
     * Show an specific academic period
     * @param int $id
     */
    public function show (int $id)
    {
        $data['academicPeriod'] = AcademicPeriod::find($id)->toArray();

        if (empty($data['academicPeriod'])) {
            return redirect()->route('academic-periods.index')
            ->with('error', 'El periodo académico no fue encontrado.');
        }

        $data['modulo'] = $this->modulo;
        $data['breadcume'] = $this->breadcume;
        $data['permiso'] = $this->permiso;

        return view('AcademicPeriod/edit', $data);
    }

    /**
     * Create academic period
     * @param Request $request
     */
    public function store (Request $request)
    {
        $period = AcademicPeriod::where('type', $request->type)
        ->where('start_month', $request->startMonth)
        ->where('start_year', $request->startYear)
        ->where('end_month', $request->endMonth)
        ->where('end_year', $request->endYear)
        ->first();

        // Stop execution
        if ($period) {
            return redirect()->route('academic-periods.index')
            ->with('error', 'El periodo académico ya existe.');
        }

        AcademicPeriod::create([
            'type' => $request->type,
            'start_month' => $request->startMonth,
            'start_year' => $request->startYear,
            'end_month' => $request->endMonth,
            'end_year' => $request->endYear
        ]);

        return redirect()->route('academic-periods.index')
        ->with('success', 'El periodo académico fue creado con exito.');
    }

    /**
     * Update academic period
     * @param Request $request
     */
    public function update (Request $request)
    {
        $period = AcademicPeriod::find($request->id);
        $period->type = $request->type;
        $period->start_month = $request->startMonth;
        $period->start_year = $request->startYear;
        $period->end_month = $request->endMonth;
        $period->end_year = $request->endYear;
        $period->enabled = $request->enabled;
        $period->save();

        return redirect()->route('academic-periods.index')
        ->with('success', 'El periodo académico fue actualizado con exito.');
    }
}
