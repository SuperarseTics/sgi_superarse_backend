<?php

use App\Http\Controllers\AcademicPeriodController;
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
use App\Http\Controllers\CriterioController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\SubCriterioController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\ElementosFundamentalesController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\EtapaClicloDemingController;
use App\Http\Controllers\GestorDocumentalController;
use App\Http\Controllers\EvaluadorController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\BuscadorDocumentalController;
use App\Http\Controllers\TestController;

Route::get('test', [TestController::class, "index"]);

Route::get('/', [LogInController::class, "index"]);
Route::get('cerrar-sesion', [LogInController::class, "cerrarSesion"]);
Route::post('verificar-login', [LogInController::class, "verificarLogIn"]);

Route::get('dash', [DashController::class, "index"]);

//Criterio
Route::get('criterio', [CriterioController::class, "index"]);
Route::post('criterio/ingresar', [CriterioController::class, "ingresar"]);
Route::get('criterio/editar/{id}', [CriterioController::class, "editar"]);
Route::get('criterio/get-subcriterio', [CriterioController::class, "getSubCriterio"]);
// CR
Route::get('criterio/subcriterions', [CriterioController::class, "subcriterionByCriterion"]);

//subcriterio
Route::get('subcriterio', [SubCriterioController::class, "index"]);
Route::post('subcriterio/ingresar', [SubCriterioController::class, "ingresar"]);
Route::get('subcriterio/editar/{id}', [SubCriterioController::class, "editar"]);
Route::get('subcriterio/get-indicador', [SubCriterioController::class, "getIndicadores"]);

//tipo-documento
Route::get('tipo-documento', [TipoDocumentoController::class, "index"]);
Route::post('tipo-documento/ingresar', [TipoDocumentoController::class, "ingresar"]);
Route::get('tipo-documento/editar/{id}', [TipoDocumentoController::class, "editar"]);

//cargo
Route::get('cargo', [CargoController::class, "index"]);
Route::post('cargo/ingresar', [CargoController::class, "ingresar"]);
Route::get('cargo/editar/{id}', [CargoController::class, "editar"]);

//etapa Cliclo Deming
Route::get('etapa', [EtapaClicloDemingController::class, "index"]);
Route::post('etapa/ingresar', [EtapaClicloDemingController::class, "ingresar"]);
Route::get('etapa/editar/{id}', [EtapaClicloDemingController::class, "editar"]);

//valoracion
Route::get('valoracion', [ValoracionController::class, "index"]);
Route::post('valoracion/ingresar', [ValoracionController::class, "ingresar"]);
Route::get('valoracion/editar/{id}', [ValoracionController::class, "editar"]);

//elementos-fundamentales
Route::get('elementos-fundamentales', [ElementosFundamentalesController::class, "index"]);
Route::post('elementos-fundamentales/ingresar', [ElementosFundamentalesController::class, "ingresar"]);
Route::get('elementos-fundamentales/editar/{id}', [ElementosFundamentalesController::class, "editar"]);

//Roles
Route::get('rol', [RolController::class, "index"]);
Route::get('rol/nuevo', [RolController::class, "nuevo"]);
Route::post('rol/ingresar', [RolController::class, "ingresar"]);
Route::get('rol/editar/{id}', [RolController::class, "editar"]);
Route::post('rol/actualizar', [RolController::class, "actualizar"]);

//Usuario
Route::get('usuario', [UsuarioController::class, "index"]);
Route::post('usuario/ingresar', [UsuarioController::class, "ingresar"]);
Route::get('usuario/editar/{id}', [UsuarioController::class, "editar"]);

//responsable
Route::get('responsable', [ResponsableController::class, "index"]);
Route::post('responsable/ingresar', [ResponsableController::class, "ingresar"]);
Route::get('responsable/editar/{id}', [ResponsableController::class, "editar"]);

//indicador
Route::get('indicador', [IndicadorController::class, "index"]);
Route::post('indicador/ingresar', [IndicadorController::class, "ingresar"]);
Route::get('indicador/editar/{id}', [IndicadorController::class, "editar"]);
Route::get('indicador/evaluar/{id}', [IndicadorController::class, "evaluar"]);
Route::post('indicador/ingresar-evaluacion', [IndicadorController::class, "ingresarEvaluacion"]);

//gestor documental
Route::get('indicador/gestor-documental/{id}', [GestorDocumentalController::class, "index"])->name('indicator.document.index');
Route::get('indicador/gestor-documental/{indicatorId}/{documentId}', [GestorDocumentalController::class, 'show'])->name('indicator.document.show');
Route::post('indicador/gestor-documental/ingresar', [GestorDocumentalController::class, "ingresar"]);
Route::post('indicador/gestor-documental/{id}', [GestorDocumentalController::class, "update"])->name('indicator.document.update');
Route::delete('indicador/gestor-documental/eliminar/{id}', [GestorDocumentalController::class, "eliminar"])->name('indicator.document.delete');

//evaluador
Route::get('evaluador', [EvaluadorController::class, "index"]);
Route::post('evaluador/ingresar', [EvaluadorController::class, "ingresar"]);
Route::get('evaluador/editar/{id}', [EvaluadorController::class, "editar"]);

//Evaluacion
Route::get('evaluacion/{id}', [EvaluacionController::class, "index"]);
Route::post('evaluacion/ingresar-autoevaluacion', [EvaluacionController::class, "ingresarAutoevaluacion"]);
Route::post('evaluacion/ingresar-resultados', [EvaluacionController::class, "ingresarResultados"]);
Route::post('evaluacion/ingresar-acciones-correctivas', [EvaluacionController::class, "ingresarAccionesCorrectivas"]);
Route::get('evaluacion/acciones-correctivas/editar/{id}', [EvaluacionController::class, "editarAccionesCorrectivas"]);
Route::post('evaluacion/ingresar-acciones-preventivas', [EvaluacionController::class, "ingresarAccionesPreventivas"]);
Route::get('evaluacion/acciones-preventivas/editar/{id}', [EvaluacionController::class, "editarAccionesPreventivas"]);
Route::post('evaluacion/ingresar-evaluar', [EvaluacionController::class, "ingresarEvaluar"]);
Route::get('calcular-cuantitativo', [EvaluacionController::class, "calcularCuantitativo"]);

//Buscador
Route::get('buscador-documental', [BuscadorDocumentalController::class, "index"]);

//Informe
Route::get('informe-resultados/{id}', [IndicadorController::class, "informe"]);

// Periodos academicos
Route::get('academic-periods', [AcademicPeriodController::class, "index"])->name('academic-periods.index');
Route::get('academic-periods/{id}', [AcademicPeriodController::class, "show"])->name('academic-periods.show');
Route::post('academic-periods', [AcademicPeriodController::class, "store"])->name('academic-periods.store');
Route::post('academic-periods/{id}', [AcademicPeriodController::class, "update"])->name('academic-periods.update');

Route::post('excel', [IndicadorController::class, "downloadPdfZip"])->name('excel.download');