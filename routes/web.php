<?php

use App\Http\Controllers\AporteController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EscanerController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\PadreFamiliaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecuperarClaveController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/* mis rutas */

#inicio

#estudiantes
Route::resource('estudiantes', EstudianteController::class)->middleware('verified');
Route::get('estudiantes-vacear', [EstudianteController::class, 'vacearRegistro'])->name('estudiantes.vacearRegistro')->middleware('verified');
Route::get("modelo-estudiante", [EstudianteController::class, "modeloEstudianteExcel"])->name("estudiantes.modeloEstudianteExcel")->middleware("verified");
Route::post("importar-estudiantes", [EstudianteController::class, "importarEstudiantes"])->name("estudiantes.importarEstudiantes")->middleware("verified");
Route::post("buscar-estudiante", [EstudianteController::class, "buscarEstudiante"])->name("estudiantes.buscarEstudiante")->middleware("verified");
Route::get("estudiantes-exportar", [EstudianteController::class, "exportarEstudiantes"])->name("estudiantes.exportarEstudiantes")->middleware("verified");


#padres de familia
Route::resource('padres-familia', PadreFamiliaController::class)->middleware('verified');
Route::get("padres-familia-tarjeta-{id_padre_familia}", [PadreFamiliaController::class, "tarjeta"])->name("padres-familia.tarjeta")->middleware("verified");
Route::get('padre-familia-vacear', [PadreFamiliaController::class, 'vacearRegistro'])->name('padres-familia.vacearRegistro')->middleware('verified');
Route::get("padres-descargarTarjeta-{pagina}", [PadreFamiliaController::class, "descargarTarjeta"])->name("padres-familia.descargarTarjeta")->middleware("verified");
Route::get("historial-padres-{id_padre_familia}", [PadreFamiliaController::class, "historialPadres"])->name("padres-familia.historialPadres")->middleware("verified");

// Route::get("padre-familia-QR", [PadreFamiliaController::class, "eliminar"])->name("padres-familia.eliminar")->middleware("verified");
// Route::get("modelo-padre-familia", [PadreFamiliaController::class, "modeloPadreFamiliaExcel"])->name("padres-familia.modeloPadreFamiliaExcel")->middleware("verified");
Route::post("importar-padres-familia", [PadreFamiliaController::class, "importarPadresFamilia"])->name("padres-familia.importarPadresFamilia")->middleware("verified");
Route::post("buscar-padre-familia", [PadreFamiliaController::class, "buscarPadreFamilia"])->name("padres-familia.buscarPadreFamilia")->middleware("verified");
Route::get("padres-familia-exportar", [PadreFamiliaController::class, "exportarPadresFamilia"])->name("padres-familia.exportarPadresFamilia")->middleware("verified");
Route::get("padres-familia-exportarModelo", [PadreFamiliaController::class, "exportarPadresFamiliaModelo"])->name("padres-familia.exportarPadresFamiliaModelo")->middleware("verified");


#cargos
Route::resource("cargos", CargoController::class)->middleware("verified");
Route::get("cargos-vacear", [CargoController::class, "vacearRegistro"])->name("cargos.vacearRegistro")->middleware("verified");

#asistencias
Route::get("asistencia-entrada-{id_reunion}-{dniPadreFamilia}", [AsistenciaController::class, "entrada"])->name("asistencia.entrada")->middleware("verified");
Route::get("asistencia-salida-{id_reunion}-{dniPadreFamilia}", [AsistenciaController::class, "salida"])->name("asistencia.salida")->middleware("verified");

#reuniones
Route::resource("reuniones", ReunionController::class)->middleware("verified");
Route::get("reuniones-vistaAgregarParticipante-{id_reunion}", [ReunionController::class, "vistaAgregarParticipante"])->name("reuniones.vistaAgregarParticipante")->middleware("verified");
Route::get("reuniones-eliminarParticipante-{id_reunion}", [ReunionController::class, "eliminarParticipante"])->name("reuniones.eliminarParticipante")->middleware("verified");
Route::post("reuniones-add", [ReunionController::class, "addParticipante"])->name("reuniones.addParticipante")->middleware("verified");


#pagos
Route::post("pagos-multaReunion", [PagoController::class, "pagarMultaReunion"])->name("pagos.pagarMultaReunion")->middleware("verified");
Route::get("pagos-ticket-{id_pago}", [PagoController::class, "ticketPago"])->name("pagos.ticketPago")->middleware("verified");
Route::resource("pagos", PagoController::class)->middleware("verified");


#aportes
Route::get("aportes-vistaAgregarParticipante-{id_aporte}", [AporteController::class, "vistaAgregarParticipante"])->name("aportes.vistaAgregarParticipante")->middleware("verified");
Route::get("aportes-eliminarParticipante-{id_aporte}", [AporteController::class, "eliminarParticipante"])->name("aportes.eliminarParticipante")->middleware("verified");
Route::post("aportes-add", [AporteController::class, "addParticipante"])->name("aportes.addParticipante")->middleware("verified");
Route::resource("aportes", AporteController::class)->middleware("verified");


#deudas

#usuarios
Route::resource('usuarios', UsuarioController::class)->middleware('verified');

#escanear
Route::resource("escaner", EscanerController::class)->middleware("verified");
Route::get("escaner-escanear-{id_reunion}-{id_padre_familia}", [EscanerController::class, "escanear"])->name("escaner.escanear")->middleware("verified");

//empresa
Route::get('empresa-index', [EmpresaController::class, 'index'])->name('empresa.index')->middleware('verified');
Route::post('empresa-update-{id}', [EmpresaController::class, 'update'])->name('empresa.update')->middleware('verified');
Route::post("empresa-subir-logo-institucion", [EmpresaController::class, "subirImgInstitucion"])->name('empresa.subirImgInstitucion')->middleware('verified');
Route::get("empresa-eliminar-logo-institucion", [EmpresaController::class, "eliminarImgInstitucion"])->name('empresa.eliminarImgInstitucion')->middleware('verified');

Route::post("empresa-subir-logo-ugel", [EmpresaController::class, "subirImgUgel"])->name('empresa.subirImgUgel')->middleware('verified');
Route::get("empresa-eliminar-logo-ugel", [EmpresaController::class, "eliminarImgUgel"])->name('empresa.eliminarImgUgel')->middleware('verified');


#historial
Route::get("historial-descargarPDF-{dni_padre}", [HistorialController::class, "descargaPDF"])->name("historial.descargaPDF");
Route::get("historial-index", [HistorialController::class, "index"])->name("historial.index")->middleware("verified");
Route::get("historial-show", [HistorialController::class, "show"])->name("historial.show")->middleware("verified");


#aportes
Route::get("reportes-aporte-{id_aporte}", [AporteController::class, "aportesReporte"])->name("aportes.reporte")->middleware("verified");
Route::get("reportes-aportesExcel-{id_aporte}", [AporteController::class, "aportesReporteExcel"])->name("aportes.aportesReporteExcel")->middleware("verified");
Route::get("reportes-reunion-{id_reunion}", [ReunionController::class, "reunionesReporte"])->name("reuniones.reporte")->middleware("verified");
Route::get("reportes-reunionesExcel-{id_reunion}", [ReunionController::class, "reunionesReporteExcel"])->name("reuniones.reunionesReporteExcel")->middleware("verified");

#buscar-padres
Route::get("buscar-padres-{dni_padre}", [PadreFamiliaController::class, "buscarPadres"])->name("padres-familia.buscarPadres");

#mi perfil
Route::get('perfil-index', [UsuarioController::class, 'perfilIndex'])->name('perfil.index')->middleware('verified');
Route::post('perfil-update', [UsuarioController::class, 'perfilUpdate'])->name('perfil.update')->middleware('verified');
//cambiar contraseña
Route::get('clave-index', [UsuarioController::class, 'claveIndex'])->name('clave.index')->middleware('verified');
Route::post('clave-update', [UsuarioController::class, 'claveUpdate'])->name('clave.update')->middleware('verified');

//recuperar contraseña
Route::get("recuperar-clave", [RecuperarClaveController::class, "index"])->name("recuperar.index");
Route::post("recuperar-clave", [RecuperarClaveController::class, "enviarCorreo"])->name("recuperar.enviarCorreo");
Route::get("recuperar-clave-form-{id}-{codigo}", [RecuperarClaveController::class, "formulario"])->name("recuperar.form");
Route::post("recuperar-update", [RecuperarClaveController::class, "enviarUpdate"])->name("recuperar.update");
