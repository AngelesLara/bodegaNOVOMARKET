<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompaniaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CreditoventaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\FormaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('productos', ProductoController::class)->except('show');
    Route::resource('categorias', CategoriaController::class)->except('show');
    Route::resource('formas', FormaController::class)->except('show');
    Route::resource('proveedores', ProveedorController::class)->except('show');
    Route::resource('clientes', ClienteController::class)->except('show');
    Route::resource('usuarios', UsuarioController::class)->except('show');
    Route::resource('gastos', GastoController::class)->except('show');

    Route::get('/listarProductos', [DatatableController::class, 'products'])->middleware('can:productos.index')->name('products.list');
    Route::get('/listarClientes', [DatatableController::class, 'clients'])->middleware('can:clientes.index')->name('clients.list');
    Route::get('/listarProveedores', [DatatableController::class, 'proveedors'])->middleware('can:proveedores.index')->name('proveedors.list');
    Route::get('/listarCotizaciones', [DatatableController::class, 'cotizaciones'])->middleware('can:cotizacion.index')->name('cotizaciones.list');
    Route::get('/listarCompras', [DatatableController::class, 'compras'])->middleware('can:compra.index')->name('compras.list');
    Route::get('/listarCajas', [DatatableController::class, 'cajas'])->middleware('can:cajas.index')->name('cajas.list');
    Route::get('/listarUsuarios', [DatatableController::class, 'users'])->middleware('can:usuarios.index')->name('users.list');
    Route::get('/listarCategorias', [DatatableController::class, 'categories'])->middleware('can:categorias.index')->name('categories.list');
    Route::get('/listarGastos', [DatatableController::class, 'gastos'])->middleware('can:gastos.index')->name('gastos.list');
    Route::get('/listarVentas', [DatatableController::class, 'sales'])->middleware('can:venta.index')->name('sales.list');
    Route::get('/listarFormas', [DatatableController::class, 'formas'])->middleware('can:formas-pago.index')->name('formas.list');
    Route::get('/listarCreditoventas', [DatatableController::class, 'creditoventas'])->middleware('can:creditoventa.index')->name('creditoventas.list');

    Route::get('/compania', [CompaniaController::class, 'index'])->middleware('can:compania.update')->name('compania.index');
    Route::put('/compania/{compania}', [CompaniaController::class, 'update'])->middleware('can:compania.update')->name('compania.update');

    Route::get('/venta', [VentaController::class, 'index'])->middleware('can:venta.index')->name('venta.index');
    Route::get('/venta/show', [VentaController::class, 'show'])->middleware('can:venta.show')->name('venta.show');
    Route::get('/venta/cliente', [VentaController::class, 'cliente'])->middleware('can:venta.index')->name('venta.cliente');
    Route::post('/venta', [VentaController::class, 'store'])->middleware('can:venta.index')->name('venta.store');
    Route::put('/venta/{id}/anular', [VentaController::class, 'anular'])->middleware('can:venta.anular')->name('venta.anular');
    Route::get('/venta/{id}/ticket', [VentaController::class, 'ticket'])->name('venta.ticket');
    Route::get('/venta-report-excel', [VentaController::class, 'generateExcelReport'])->middleware('can:venta.reportes')->name('venta.reportExcel');
    Route::get('/venta-report-pdf', [VentaController::class, 'generatePdfReport'])->middleware('can:venta.reportes')->name('venta.reportPdf');

    Route::get('/creditolimite/{id}', [CreditoventaController::class, 'limitecliente'])->middleware('can:creditoventa.abonos')->name('creditoventa.limitecliente');
    Route::get('/creditoventa', [CreditoventaController::class, 'index'])->middleware('can:creditoventa.index')->name('creditoventa.index');
    Route::get('/creditoventa/{id}/ticket', [CreditoventaController::class, 'ticket'])->middleware('can:creditoventa.abonos')->name('creditoventa.ticket');
    Route::get('/creditoventa/{id}/abonos', [CreditoventaController::class, 'abonos'])->middleware('can:creditoventa.abonos')->name('creditoventa.abonos');
    Route::get('/creditoventa/{id}/detalle', [CreditoventaController::class, 'detalle'])->middleware('can:creditoventa.abonos')->name('creditoventa.detalle');
    Route::get('/creditoventa-report-excel', [CreditoventaController::class, 'generateExcelReport'])->middleware('can:creditoventa.reportes')->name('creditoventa.reportExcel');
    Route::get('/creditoventa-report-pdf', [CreditoventaController::class, 'generatePdfReport'])->middleware('can:creditoventa.reportes')->name('creditoventa.reportPdf');
    Route::post('/abonoventa', [CreditoventaController::class, 'registrarAbono'])->middleware('can:creditoventa.abonos')->name('creditoventa.registrarAbono');

    Route::get('/compra', [CompraController::class, 'index'])->middleware('can:compra.index')->name('compra.index');
    Route::get('/compra/show', [CompraController::class, 'show'])->middleware('can:compra.show')->name('compra.show');
    Route::get('/compra/proveedor', [CompraController::class, 'proveedor'])->middleware('can:compra.index')->name('compra.proveedor');
    Route::post('/compra', [CompraController::class, 'store'])->middleware('can:compra.index')->name('compra.store');
    Route::put('/compra/{id}/anular', [CompraController::class, 'anular'])->middleware('can:compra.anular')->name('compra.anular');
    Route::get('/compra/{id}/ticket', [CompraController::class, 'ticket'])->name('compra.ticket');
    Route::get('/compra-report-excel', [CompraController::class, 'generateExcelReport'])->middleware('can:compra.reportes')->name('compra.reportExcel');
    Route::get('/compra-report-pdf', [CompraController::class, 'generatePdfReport'])->middleware('can:compra.reportes')->name('compra.reportPdf');

    Route::get('/cotizacion', [CotizacionController::class, 'index'])->middleware('can:cotizacion.index')->name('cotizacion.index');
    Route::get('/cotizacion/show', [CotizacionController::class, 'show'])->middleware('can:cotizacion.show')->name('cotizacion.show');
    Route::get('/cotizacion/cliente', [CotizacionController::class, 'cliente'])->middleware('can:cotizacion.index')->name('cotizacion.cliente');
    Route::post('/cotizacion', [CotizacionController::class, 'store'])->middleware('can:cotizacion.index')->name('cotizacion.store');
    Route::put('/cotizacion/{id}/eliminar', [CotizacionController::class, 'eliminar'])->middleware('can:cotizacion.eliminar')->name('cotizacion.eliminar');
    Route::get('/cotizacion/{id}/ticket', [CotizacionController::class, 'ticket'])->name('cotizacion.ticket');

    Route::get('/cajas', [CajaController::class, 'index'])->middleware('can:cajas.index')->name('cajas.index');
    Route::get('/cajas/create', [CajaController::class, 'create'])->middleware('can:cajas.create')->name('cajas.create');
    Route::post('/cajas', [CajaController::class, 'store'])->middleware('can:cajas.create')->name('cajas.store');
    Route::put('/cajas', [CajaController::class, 'update'])->middleware('can:cajas.update')->name('cajas.update');

    Route::get('/movimientos', [MovimientoController::class, 'index'])->middleware('can:movimientos.index')->name('movimientos.index');
    
    Route::get('/rol/{id}/edit', [RolController::class, 'edit'])->middleware('can:roles.update')->name('rol.edit');
    Route::put('/rol/update/{user}', [RolController::class, 'update'])->middleware('can:roles.update')->name('rol.update');

    Route::get('/pdf/productos', [ReporteController::class, 'pdfProducto'])->middleware('can:productos.reportes')->name('productos.pdf');
    Route::get('/excel/productos', [ReporteController::class, 'excelProducto'])->middleware('can:productos.reportes')->name('productos.excel');
    Route::get('/barcode/productos', [ReporteController::class, 'barcodeProducto'])->middleware('can:productos.reportes')->name('productos.barcode');

    Route::get('/pdf/proveedores', [ReporteController::class, 'pdfProveedor'])->middleware('can:proveedores.reportes')->name('proveedores.pdf');
    Route::get('/excel/proveedores', [ReporteController::class, 'excelProveedor'])->middleware('can:proveedores.reportes')->name('proveedores.excel');

    Route::get('/pdf/clientes', [ReporteController::class, 'pdfCliente'])->middleware('can:clientes.reportes')->name('clientes.pdf');
    Route::get('/excel/clientes', [ReporteController::class, 'excelCliente'])->middleware('can:clientes.reportes')->name('clientes.excel');

    Route::get('/pdf/cotizaciones', [ReporteController::class, 'pdfCotizacion'])->middleware('can:cotizacion.reportes')->name('cotizaciones.pdf');
    Route::get('/excel/cotizaciones', [ReporteController::class, 'excelCotizacion'])->middleware('can:cotizacion.reportes')->name('cotizaciones.excel');

    Route::get('/pdf/cajas', [ReporteController::class, 'pdfCaja'])->middleware('can:cajas.reportes')->name('cajas.pdf');
    Route::get('/excel/cajas', [ReporteController::class, 'excelCaja'])->middleware('can:cajas.reportes')->name('cajas.excel');

    Route::get('/pdf/gastos', [ReporteController::class, 'pdfGasto'])->middleware('can:gastos.reportes')->name('gastos.pdf');
    Route::get('/excel/gastos', [ReporteController::class, 'excelGasto'])->middleware('can:gastos.reportes')->name('gastos.excel');
});

require __DIR__.'/auth.php';
