<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$controllers = array(
//AQUI SE ESTABLACE LAS FUNCIONES QUE VA A TENER CADA MODULO
//OJO, CADA OPCION DEBE ESTAR EN EL ARCHIVO NombreModuloController.php dentro del directorio controladores

	// Reporte Material en Obra 
	'agregadosobra' => ['agregados','guardar','eliminar','editar','actualizar','porfecha'],

	// Reporte Avances 
	'avances' => ['todosporobra','todosporcapitulo','todosporfrente','todosporactividad','todosporusuario','guardar','eliminar','editar','actualizar','porfecha'],

	// Módulo cajas menores
	'cajas' => ['editar','guardar','actualizar','todos','nuevo','vista','grafica','eliminar', 'detalles','micaja'],


	// Módulo Campamentos
	'campamento' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Cargos
	'cargos' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	// Categorias de Insumos
	'categoriainsumos' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	// Categorias de Insumos
	'clientes' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Funcionalidad compras
	'compras' => ['todos','formulario','guardar','eliminar','editar','actualizar','porfecha','verdetalle','cambiarestado','actualizarpago','cambiarestadocreditos','pagotemporal','deletepagotemporal','actualizarpagocredito','recibiroc','todospormes','cxpusuario','actualizardetallecot','editardetallecot','todosrecibirinsumos','porfechainsumos','cargarinventario','retornar','todosproveedorpagos','cargarfactura','ivamultiple','descartar','descartarinversa','guardarfacturacompras','detallefacturacompra','facturascompraspormes','cargarfacturacp','todosporproveedorespera','pagofacturacompra','editarfacturacompra','actualizarfacturacompras','editarfacturacompracp','guardarpagoanticipo','guardarpagofactura'],

	// Reporte Concreto
    'concreto' => ['todos','formularioconcreto','guardar','eliminar','editar','actualizar','despachosporfecha','detallepuntos'],

    // Funcionalidad Consolidados
    'consolidados' => ['editar','guardar','actualizar','todos','nuevo','eliminar','documentoscuentas','documentosequipos','totalreporteseq'],

	// Cotizaciones
	'cotizaciones' => ['todos','editar','actualizar','porfecha','todosporinsumo'],

	// Reporte Cuentas 
     'cuentas' => ['editar','guardar','actualizar','todos','nuevo','eliminar','reporteporfecha','crucecuentas','detallecruce'],

     // Egresos Cuentas
     'egresoscuenta' => ['editar','guardar','actualizarcm','actualizarcu','actualizarot','todos','nuevo','eliminar','egresos','editarcm','editarcu','editarot','eliminarcm','eliminarmvs','eliminarot','egresosporfecha'],

	// Estaciones de Servicio
     'estaciones' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

    // Estados Requisiciones
	'estadosreq' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	'estadisticavolqueta' => ['todos','buscarReporteVolquetas'],

	'equipos' => ['editar','guardar','actualizar','todos','todosmantenimiento','nuevo','eliminar','editarvol','guardarvol','actualizarvol','volquetas','nuevovol','eliminarvol','reporte','guardareporte','reportediario','eliminareporte','editareporte','actualizareporte','formreportedia','reportedia','reporteporfecha','gastosmantenimientoporfecha','cambiarvisualizacion','estado','guardarestado','actualizarestado','todosestados','eliminarestado','timelineestados'],

	// Equipos Temporales
	'equipostemporales' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	// Módulo de Dashboard 
	'dashboards' =>['dashboardcompras'],

	// Módulo de Destinos 
	'destinos' => ['editar','guardar','actualizar','todos','nuevo','eliminar','destinoextra'],

	// Funcionalidad Documentos 
	'documentos' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Módulo Folder
	'folders' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Funcionalidad Frentes 
	'frentes' => ['nuevo','actualizar','guardar','eliminar','todosobra','todos'],

	// Funcionalidad Empleados
	'funcionarios' => ['editar','guardar','actualizar','todos','todosinactivos','nuevo','eliminar','reportarnovedad','eliminarnovedad','reportarsoporte','eliminarsoporte','activarempleadoPor','desactivarempleadoPor'],

	// Gastos cajas menores
	'gastos' => ['editar','guardar','actualizarex','todos','nuevo','eliminar','egresos','totalegresos','totalegresoslegal','eliminarcajasistema','porfecha','porfechalegal','eliminargastopor','eliminarcajasistemapor','cambiarestado','actualizarestado'],

	// Gestión Documental 
	'gestiondocumental' => ['editar','guardar','actualizar','todos','nuevo','eliminar','listacuentas','configuracion','cargartodos','desactivarDocumento','varios','guardarvarios','eliminarvarios','editarvarios','actualizarvarios','activar','carpetaextra'],

	// Gestión Documental Equipos 
	'gestiondocumentaleq' => ['editar','guardar','actualizar','todos','nuevo','eliminar','listaequipos','configuracion','cargartodos','desactivarDocumento','varios','guardarvarios','eliminarvarios','editarvarios','actualizarvarios','activar'],

	// Gestión Documenta Empleados
	'gestiondocumentalemp' => ['editar','guardar','actualizar','todos','nuevo','eliminar','listaequipos','configuracion','cargartodos','desactivarDocumento','varios','guardarvarios','eliminarvarios','editarvarios','actualizarvarios','activar','carpetaextra'],

	// Gestión Documental Proveedores
	'gestiondocumentalprov' => ['editar','guardar','actualizar','todos','nuevo','eliminar','listaequipos','configuracion','cargartodos','desactivarDocumento','varios','guardarvarios','eliminarvarios','editarvarios','actualizarvarios','activar'],

	// Reporte Horas Máquinaria 
	'horasmq' => ['horas','guardarhoras','eliminarhoras','editarhoras','actualizarhoras','horasporfecha'],

	// Reporte Inconvenientes 
	'inconvenientes' => ['todos','guardar','eliminar','editar','actualizar','porfecha'],

	// Funcionalidad Index 
	'index' => ['index','informe1','informegerencia','informeclientes','informedetalleclientes','informeventaclientes','informedetalleclientesventas','micajamenor','dashboardalmacen','vistarqusuariosdashboard','aprobarRq','obras'],

	'informes' =>['cuentas','movimientoscuentas','subrubrosegresos','cajas','movimientoscaja','subrubrosegresoscaja','ventas','detallelineanegocio','clientes','compras','totalrq','rqporfecha'],

	// Cuentas por Pagar
	'informecuentasporcobrar' => ['cuentasxcobrarconsolidado','cuentasxcobrarporfechaconsolidado','cuentasxcobrardetalle','cuentasxcobrarporfechadetalle'],

	// Ingresos caja menor
	'ingresos' => ['editar','guardar','actualizarex','todos','nuevo','eliminar','ingresos'],

	// Ingresos Cuenas
	'ingresoscuenta' => ['editar','guardar','actualizarex','todos','nuevo','eliminar','ingresos','ingresosporfecha'],

	// Reporte Inventarios
	'inventario' => ['cargarentradaoc','guardarentradadetalletem','guardarsalidadetalletem','deletedellentradatemp','deletedellsalidatemp','actualizarentradaoc','actualizarsalidarq','totalentradas','totalsalidas','entradasporfecha','salidasporfecha','entradasdetalle','salidasdetalle','entradasdetalletotal','salidasdetalletotal','cargarsalidasrq','verinventario','kardexporinsumo','despachosporfecha','entregaspendientesusuario','recibirdespacho','entregasrecibidasusuario'],

	// Funcionalidad Insumos 
	'insumos' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Reporte Listado de Máquinas y equipos
	'listame' => ['todos','guardar','eliminar','editar','actualizar'],

	// Reporte Listado de Mano de Obra
	'listamo' => ['todos','guardar','eliminar','editar','actualizar'],

	// Documentos
	'misdocumentos' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Movimientos Item 
	'movimientositem' => ['todospor','guardar','eliminar'],

	// Funcionalidad Módulos 
	'modulos' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Novedades
	'novedades' => ['editar','guardar','actualizar','todos','nuevo','eliminar','novedadesporfecha'],

	// Funcionalidad Obras
	'obras' => ['dashboard','detalle_obra','nueva_obra','eliminarobra','guardarobra','actualizarobra','guardarcapitulo','guardaractividad','eliminarcapitulo','eliminaractividad','actualizarcapitulo','actualizaractividad','guardarcantmayores','eliminarcantidades','modificaciones','avance_obra','guardaravance','proyecciones','guardarcantidadesproyectadas','eliminarcantidadesproyectadas','proyeccionesrango'],

	// Reporte Listado de Máquinas y equipos
	'personalextra' => ['todos','guardar','eliminar','editar','actualizar'],

	// Funcionalidad Personal Obras
	'personalobras' => ['nuevo','actualizar','guardar','eliminar','todosobranomina','todosobraextra','todos'],

	// Funcionalidad Proyecciones L-ME (Máquinaría y Equipos) 
	'proyeccioneslme' => ['nuevo','actualizar','guardar','eliminarango','eliminaequipo','todosobra','todos','proyeccionesrango','ejecutadorango'],

	// Funcionalidad Proyecciones L-MO (Mano de Obra) 
	'proyeccioneslmo' => ['nuevo','actualizar','guardar','eliminarango','eliminaequipo','todosobra','todos','proyeccionesrango'],

	// Funcionalidad Proyecciones (Administración) 
	'proyeccionesadm' => ['nuevo','actualizar','guardar','eliminarango','eliminafila','todosobra','todos','proyeccionesrango'],

	// Funcionalidad Proyecciones (Insumos)
	'proyeccionesins' => ['nuevo','actualizar','guardar','eliminarango','eliminaequipo','todosobra','todos','proyeccionesrango'],

	// Funcionalidad Productos
	'productos' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Funcionalidad Proveedores
	'proveedores' => ['editar','guardar','actualizar','todos','nuevo','eliminar','cxpproveedor','estadocuenta','listadoproveedorespago','proyecciontemporal','deleteproyecciontemporal','actualizarrelacionpagos','showrelacionpagos','eliminarrelacion'],

	// Funcionalidad Proyectos
	'proyectos' => ['editar','guardar','actualizar','todos','nuevo','eliminar','proyectoextra'],

	// Funcionalidad Rangos 
	'rangos' => ['nuevo','actualizar','guardar','eliminar','todosobra','todos'],


	// Funcionalidad Reportes
	'reportes' => ['ventas','clienteextra','productoextra','guardarventa','eliminarventa','cambiarestadoventa','editarventa','actualizarventa','ventasporfecha','compras','insumoextra','guardarcompra','eliminarcompra','editarcompra','actualizarcompra','comprasporfecha','despachos','guardardespacho','eliminardespacho','editardespacho','actualizardespacho','despachosporfecha','despachosclientes','despachosclientesf','despachosclientesunico','despachosproveedorunico','despachospropietario','guardardespachoclientes','eliminardespachoclientes','editardespachoclientes','actualizardespachoclientes','despachosporfechaclientes','despachosporfechaclientesunico','despachosporfechaproveedorunico','despachosporfechapropietario','facturas','guardarfactura','eliminarfactura','editarfactura','actualizarfactura','facturasporfecha','guardarabono','eliminarabono','cuentasxpagar','cuentasxpagarconsolidado','cuentasxpagardetalle','guardarcuentaxpagar','eliminarcuentaxpagar','cancelarcuentaxpagar','editarcuentaxpagar','actualizarcuentaxpagar','cuentasxpagarporfecha','cuentasxpagarporfechaconsolidado','cuentasxpagarporfechadetalle','prestamos','guardarprestamo','eliminarprestamo','cambiarestadoprestamo','editarprestamo','actualizarprestamo','prestamosporfecha','combustibles','combustiblescisterna','combustiblesporfechacisterna','mescombustibleseq','mesfletes','meshorasmq','infovolqueta','guardarcombustible','eliminarcombustible','editarcombustible','actualizarcombustible','combustiblesporfecha','proveedorextra','horas','guardarhoras','eliminarhoras','editarhoras','actualizarhoras','horasporfecha','despachostrituradora','guardardespachotrituradora','eliminardespachotrituradora','editardespachotrituradora','actualizardespachotrituradora','despachosporfechatrituradora','insumosxpagar','guardarinsumoxpagar','eliminarinsumoxpagar','cancelarinsumoxpagar','editarinsumoxpagar','actualizarinsumoxpagar','insumosxpagarporfecha'],

	'reportesproduccion' => ['reportesproduccion','guardarreporteproduccion','eliminarreporteproduccion','editarreporteproduccion','actualizarreporteproduccion','reportesporfechaproduccion'],

	// Funcionalidad Requisiciones 
	'requisiciones' => ['todosporusuario','todosalmacen','todosmiusuario','todos','guardar','eliminar','editar','actualizar','porfecha','todosporusuarioestado','reqalmacenestado','todosporusuarioadmin','todosporusuarioestadoadmin','cotizaciones','vercotizacion','eliminaritemcot','reqparaentrega'],

	
	

	// Funcionalidad Requisiciones Items
	'requisicionesitems' => ['todosporreq','todos','guardar','eliminar','editar','actualizar','porfecha','cambiarestado','guardarestado','actualizarestado','trazabilidad','agregarvalores','guardarcotizacion','cambiarestadoadmin','actualizarestadoadmin','trazabilidadadmin','guardarocompra','actualizaritem','actualizarcantidadcot','gestionarvalores','guardarcotizacionmultiple','eliminarcotizacion','finalizarrq','aprobarrq','guardarsoportecotizacionmultiple'],

	// Funcionalidad Retefuente
	'retefuente' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Rubros
	'rubros' => ['editar','guardar','actualizar','todos','nuevo','eliminar'],

	// Servicios
	'servicios' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	// Funcionalidad Subrubros
	'subrubros' => ['editar','guardar','actualizar','todos','nuevo','eliminar','desactivarcxp','activarcxp'],


// Funcionalidad Mantenimientos
	'tipomantenimiento' => ['todos','nuevo','editar','guardar','actualizar','eliminar'],

	// Unidades de Medidas
	'unidadesmed' => ['todos','nuevo','guardar','eliminar','editar','actualizar'],

	// Funcionalidad Gestión Usuarios
	'usuarios' => ['editar','guardar','actualizar','todos','nuevo','eliminar','editarpermisos','activarmenuPor','desactivarmenuPor','activartodo','desactivartodo','activarrubros','notificacionleida','notificaciones','notificacionleidatodas'],

	// Funcionalidad Activar Rubros por Usuario
	'usuariosrubros' => ['todospor','activarrubroPor','desactivarrubroPor','activartodo','activarporRol'],



	'visorgraficas' => ['todos'],
	
	
	'plantilla' => ['index'],
	//Estadisticas
	
	'insumoscampamento' => ['todos','nuevo','guardar'],
	'ventasdespachos' => ['todos','nuevo','guardar','eliminar'],
	'productosinsumos' => ['todos','nuevo','guardar','eliminar'],
	

);

if (array_key_exists($controller, $controllers)) {
	if (in_array($action, $controllers[$controller])) {
		call($controller, $action);
	} else {
		call('index', 'error');
	}
} else {
	call('index', 'error');
}

//AQUI LLAMAMOS A LOS MODULOS A CARGAR
function call($controller, $action) {
	require_once 'controladores/' . $controller . 'Controller.php';

	switch ($controller) {
		
	case 'index':
		$controller = new UsuarioController();
		break;

	case 'obras':
	require_once 'modelos/obras.php';
		$controller = new ObrasController();
		break;

	case 'frentes':
	require_once 'modelos/frentes.php';
		$controller = new FrentesController();
		break;

	case 'proyeccioneslme':
	require_once 'modelos/proyeccioneslme.php';
		$controller = new ProyeccioneslmeController();
		break;

	case 'proyeccioneslmo':
	require_once 'modelos/proyeccioneslmo.php';
		$controller = new ProyeccioneslmoController();
		break;

	case 'proyeccionesadm':
	require_once 'modelos/proyeccionesadm.php';
		$controller = new ProyeccionesadmController();
		break;

	case 'proyeccionesins':
	require_once 'modelos/proyeccionesins.php';
		$controller = new ProyeccionesinsController();
		break;

	case 'rangos':
	require_once 'modelos/rangos.php';
		$controller = new RangosController();
		break;

	case 'personalobras':
	require_once 'modelos/personalobras.php';
		$controller = new PersonalobrasController();
		break;

	case 'informes':
		require_once 'modelos/informes.php';
		$controller = new InformesController();
		break;

	case 'inconvenientes':
		require_once 'modelos/inconvenientes.php';
		$controller = new InconvenientesController();
		break;


// MENÚ CONFIGURACIÓN HOME ADMIN

	case 'usuarios':
		require_once 'modelos/usuarios.php';
		$controller = new UsuariosController();
		break;

	case 'usuariosrubros':
		require_once 'modelos/usuariosrubros.php';
		$controller = new UsuariosrubrosController();
		break;
	
	case 'reportes':
		require_once 'modelos/reportes.php';
		$controller = new ReportesController();
		break;

	case 'horasmq':
		require_once 'modelos/horasmq.php';
		$controller = new HorasmqController();
		break;

	case 'agregadosobra':
		require_once 'modelos/agregadosobra.php';
		$controller = new AgregadosobraController();
		break;

	case 'avances':
		require_once 'modelos/avances.php';
		$controller = new AvancesController();
		break;

	case 'listame':
		require_once 'modelos/listame.php';
		$controller = new ListameController();
		break;

	case 'personalextra':
		require_once 'modelos/personalextra.php';
		$controller = new PersonalextraController();
		break;

	case 'listamo':
		require_once 'modelos/listamo.php';
		$controller = new ListamoController();
		break;

	case 'concreto':
		require_once 'modelos/concreto.php';
		$controller = new ConcretoController();
		break;

	case 'cargos':
		require_once 'modelos/cargos.php';
		$controller = new CargosController();
		break;

	case 'compras':
		require_once 'modelos/compras.php';
		$controller = new comprasController();
		break;

	case 'dashboards':
		require_once 'modelos/dashboards.php';
		$controller = new dashboardsController();
		break;

	case 'retefuente':
		require_once 'modelos/retefuente.php';
		$controller = new RetefuenteController();
		break;


	case 'cotizaciones':
		require_once 'modelos/cotizaciones.php';
		$controller = new cotizacionesController();
		break;

	case 'requisiciones':
		require_once 'modelos/requisiciones.php';
		$controller = new RequisicionesController();
		break;

	Case 'movimientositem':
		require_once 'modelos/movimientositem.php';
		$controller = new MovimientositemController();
		break;

	case 'servicios':
		require_once 'modelos/servicios.php';
		$controller = new ServiciosController();
		break;

	case 'equipostemporales':
		require_once 'modelos/equipostemporales.php';
		$controller = new EquipostemporalesController();
		break;

	case 'requisicionesitems':
		require_once 'modelos/requisicionesitems.php';
		$controller = new RequisicionesitemsController();
		break;

	case 'inventario':
		require_once 'modelos/inventario.php';
		$controller = new InventarioController();
		break;

	case 'estadosreq':
		require_once 'modelos/estadosreq.php';
		$controller = new EstadosReqController();
		break;

	case 'categoriainsumos':
		require_once 'modelos/categoriainsumos.php';
		$controller = new CategoriainsumosController();
		break;

	case 'unidadesmed':
		require_once 'modelos/unidadesmed.php';
		$controller = new UnidadesmedController();
		break;


	case 'informecuentasporcobrar':
		require_once 'modelos/informecuentasporcobrar.php';
		$controller = new InformecuentasporcobrarController();
		break;
	case 'reportesproduccion':
		require_once 'modelos/reportesproduccion.php';
		$controller = new ReportesproduccionController();
		break;
	case 'funcionarios':
		require_once 'modelos/funcionarios.php';
		$controller = new FuncionariosController();
		break;
	case 'novedades':
		require_once 'modelos/novedades.php';
		$controller = new NovedadesController();
		break;
	case 'cuentas':
		require_once 'modelos/cuentas.php';
		$controller = new CuentasController();
		break;
	case 'cajas':
		require_once 'modelos/cajas.php';
		$controller = new CajasController();
		break;
	case 'equipos':
		require_once 'modelos/equipos.php';
		$controller = new EquiposController();
		break;
	case 'gastos':
		require_once 'modelos/gastos.php';
		$controller = new gastosController();
		break;
	case 'ingresoscuenta':
		require_once 'modelos/ingresoscuenta.php';
		$controller = new ingresoscuentaController();
		break;
	case 'egresoscuenta':
		require_once 'modelos/egresoscuenta.php';
		$controller = new egresoscuentaController();
		break;
	case 'ingresos':
		require_once 'modelos/ingresos.php';
		$controller = new ingresosController();
		break;
	case 'rubros':
		require_once 'modelos/rubros.php';
		$controller = new rubrosController();
		break;
	case 'estaciones':
		require_once 'modelos/estaciones.php';
		$controller = new estacionesController();
		break;
	case 'clientes':
		require_once 'modelos/clientes.php';
		$controller = new ClientesController();
		break;
	case 'folders':
		require_once 'modelos/folders.php';
		$controller = new FoldersController();
		break;
	case 'productos':
		require_once 'modelos/productos.php';
		$controller = new productosController();
		break;
	case 'insumos':
		require_once 'modelos/insumos.php';
		$controller = new insumosController();
		break;
	case 'destinos':
		require_once 'modelos/destinos.php';
		$controller = new destinosController();
		break;
	case 'proyectos':
		require_once 'modelos/proyectos.php';
		$controller = new proyectosController();
		break;
	case 'proveedores':
		require_once 'modelos/proveedores.php';
		$controller = new proveedoresController();
		break;
	case 'subrubros':
		require_once 'modelos/subrubros.php';
		$controller = new subrubrosController();
		break;
	case 'modulos':
		require_once 'modelos/modulos.php';
		$controller = new modulosController();
		break;
	case 'documentos':
		require_once 'modelos/documentos.php';
		$controller = new documentosController();
		break;
	case 'consolidados':
		require_once 'modelos/consolidados.php';
		$controller = new consolidadosController();
		break;
	case 'gestiondocumental':
		require_once 'modelos/gestiondocumental.php';
		$controller = new gestiondocumentalController();
		break;
	case 'gestiondocumentalprov':
		require_once 'modelos/gestiondocumentalprov.php';
		$controller = new gestiondocumentalprovController();
		break;
	case 'gestiondocumentaleq':
		require_once 'modelos/gestiondocumentaleq.php';
		$controller = new gestiondocumentaleqController();
		break;
	case 'gestiondocumentalemp':
		require_once 'modelos/gestiondocumentalemp.php';
		$controller = new gestiondocumentalempController();
		break;
	case 'misdocumentos':
		require_once 'modelos/misdocumentos.php';
		$controller = new misdocumentosController();
		break;


	case 'configuracion':
		require_once 'modelos/configuracion.php';
		$controller = new ConfiguracionController();
		break;


	case 'plantilla':
		$controller = new UsuarioController();
		break;

	case 'usuarios':
		require_once 'modelos/usuarios.php';
		$controller = new UsuarioController();
		break;


	case 'estadisticavolqueta':
		require_once 'modelos/estadisticavolqueta.php';
		$controller = new estadisticavolquetaController();
		break;

	case 'visorgraficas':
		require_once 'modelos/visorgraficas.php';
		$controller = new visorgraficasController();
		break;

	case 'campamento':
		require_once 'modelos/campamento.php';
		$controller = new CampamentoController();
		break;

	case 'insumoscampamento':
		require_once 'modelos/insumoscampamento.php';
		$controller = new InsumoscampamentoController();
		break;

	case 'ventasdespachos':
		require_once 'modelos/ventasdespachos.php';
		$controller = new VentasdespachosController();
		break;

	case 'productosinsumos':
		require_once 'modelos/productosinsumos.php';
		$controller = new ProductosinsumosController();
		break;

	case 'tipomantenimiento':
		require_once 'modelos/tipomantenimiento.php';
		$controller = new TipoMantenimientoController();
		break;


	default:
		# code...
		break;
	}
	$controller->{$action}();
}
?>
