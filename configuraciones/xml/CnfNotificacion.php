<?php
$SucursalId = (empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal']);
/*
SUC-10000	AREQUIPA - PARQUE INDUSTRIAL
SUC-10001	AREQUIPA - PARRA
SUC-10002	AREQUIPA - EJERCITO
SUC-10003	AREQUIPA - MALL PORONGOCHE
SUC-10004	MADRE DE DIOS - PUERTO MALDONADO
SUC-10005	PUNO - JULIACA
SUC-10006	AREQUIPA - UMACOLLO
SUC-10007	AREQUIPA - LOPEZ ROMAÑA
SUC-10008	TACNA - TACNA
SUC-10009	CUSCO - CUSCO
SUC-10010	AREQUIPA - AVIACION
SUC-10011	AREQUIPA - ALM. QUIÑONEZ
SUC-9999	LIMA
*/

		/*
		* CONSULTAS GM
		*/
		$CorreosGMConsultaETA = "sandra.irey@gm.com,Willian.Pelaez@Cevalogistics.com,chevrolet.carperu@gm.com,bernardo.marcos@gm.com,richard.duenas@gm.com,d.vercelone@cisne.com.pe,a.liendo@cisne.com.pe,a.araujo@cisne.com.pe,jean.anca@gm.com,carlos.diaz@gm.com";
		$CorreosGMOrdenCodificacion = "julio.yaurilucana@gm.com,Richard.duenas@gm.com,chevrolet.carperu@gm.com,Willian.Pelaez@Cevalogistics.com,j.blanco@cisne.com.pe,l.quispe@cisne.com.pe";
		$CorreosNotificacionSolicitudCotizacion = "julio.yaurilucana@gm.com,Richard.duenas@gm.com,claudia.villanueva@gm.com,Liz.Sanchez@Cevalogistics.com,chevrolet.carperu@gm.com,j.blanco@cisne.com.pe";
		
		/*
		* CITAS GENERAL
		*/
		
		$CorreosNotificacionCitasGeneral = "p.regente@cisne.com.pe,j.blanco@cisne.com.pe,p.guerra@cisne.com.pe";

		
switch($SucursalId){
	

	
	case "SUC-10013"://SUC-10000	AREQUIPA - PARQUE INDUSTRIAL
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
		/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "l.quispe@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "l.quispe@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "p.guerra@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,p.guerra@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,l.quispe@cisne.com.pe,a.liendo@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "c.villaltao@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "z.delgado@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,z.delgado@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";	
	
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "j.vargas@cisne.com.pe,j.blanco@cisne.com.pe";
	break;
	
	
	case "SUC-10000"://SUC-10000	AREQUIPA - PARQUE INDUSTRIAL

		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
		/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "l.quispe@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "l.quispe@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "p.guerra@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,p.guerra@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,l.quispe@cisne.com.pe,a.liendo@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "c.villaltao@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "z.delgado@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "z.delgado@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,z.delgado@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";	
	
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "j.vargas@cisne.com.pe,j.blanco@cisne.com.pe";
		
	break;
	
	case "SUC-10001"://SUC-10001	AREQUIPA - PARRA
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
			/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "n.escalante@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,n.escalante@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "c.rivas@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "c.rivas@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "n.escalante@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "n.escalante@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,n.escalante@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "c.rivas@cisne.com.pe,j.blanco@cisne.com.pe";

	break;
	
	case "SUC-10004"://MADRE DE DIOS - PUERTO MALDONADO
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
			/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "j.valdivia@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "j.valdivia@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "j.valdivia.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "a.onofre@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,a.onofre@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,l.quispe@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "j.valdivia@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "a.onofre@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "a.onofre@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "j.valdivia@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "j.valdivia@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "j.valdivia@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "j.valdivia@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,j.valdivia@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
	
		
		
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "a.onofre@cisne.com.pe,j.blanco@cisne.com.pe";

		
		
		
		

	break;
	
	case "SUC-10005"://SUC-10005	PUNO - JULIACA
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
			/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "k.cornejo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,k.cornejo@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "w.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "w.quispe@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "k.cornejo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,k.cornejo@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
	
	
	/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "w.quispe@cisne.com.pe,j.blanco@cisne.com.pe";

	
	
	
	
	
		
		
		
		
		

	break;
	
	case "SUC-10008"://SUC-10008	TACNA - TACNA
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
			/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		
		
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,d.vercelone@cisne.com.pe,a.araujo@cisne.com.pe,l.quispe@cisne.com.pe,a.liendo@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "d.vercelone@cisne.com.pe,a.liendo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "a.liendo@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "a.araujo@cisne.com.pe,d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";
			$CorreosNotificacionFacturaRegistro = "a.araujo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "a.araujo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "a.araujo@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,d.vercelone@cisne.com.pe,a.araujo@cisne.com.pe,a.liendo@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
	
		
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "d.vercelone@cisne.com.pe,j.blanco@cisne.com.pe";


	break;
	
	case "SUC-10009"://SUC-10009	CUSCO - CUSCO
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
		/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		
			
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,f.ochoa@cisne.com.pe,l.quispe@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,f.ochoa@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
	
		
		/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "f.ochoa@cisne.com.pe,j.blanco@cisne.com.pe";


		
	break;
	
	case "SUC-10010"://SUC-10010	AREQUIPA - AVIACION
		
		
		/*
		* ALMACEN
		*/
		
		$CorreosIngresoAlmacen = "j.blanco@cisne.com.pe";
		
			/*
		* FACTURACION ELECTRONICA
		*/
		$CorreosEnvioComprobanteElectronico = "j.blanco@cisne.com.pe";
		
		
			/*
		* ENTREGA DE VEHICULOS
		*/
		$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo = "d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo = "c.villalta@cisne.com.pe,s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* APROBACIONES GENERALES
		*/
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "j.blanco@cisne.com.pe";
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "s.barreda@cisne.com.pe,d.flores@cisne.com.pe,k.gutierrez@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta = "j.blanco@cisne.com.pe";
		
		/*
		* VENTA VEHICULOS
		*/
		
		$CorreosNotificacionRegistroOrdenVentaVehiculo = "j.blanco@cisne.com.pe";
		$CorreosNotificacionCotizacionVehiculoPendientes = "j.blanco@cisne.com.pe,jba80@hotmail.com";
		
		/*
		* COMPRA VEHICUOS
		*/
		
		$CorreosNotificacionCompraVehiculoRegistro = "j.cordoba@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* VENTA REPUESTOS
		*/
		$CorreosNotificacionVentaDirectaRegistro = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudFacturacion = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* COMPRA REPUESTOS
		*/
		$CorreosNotificacionAlmacenMovimientoEntrada = "g.villanueva.com.pe,j.blanco@cisne.com.pe";
		
			
		/*
		* LOGISTICA REPUESTOS
		*/
		
		$CorreosNotificacionVentaConcretadaInformarDespacho = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudPedidoCompra = "p.regente@cisne.com.pe,g.villanueva@cisne.com.pe,j.perez@cisne.com.pe,alm.repuestos@cisne.com.pe,j.blanco@cisne.com.pe";

		/*
		* LOGISTICA VEHICULOS
		*/
		$CorreosNotificacionRecepcionVehicular = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* TALLER
		*/
		
		$CorreosNotificacionFichaAccionPedido = "r.gallegos@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFichaAccionMantenimiento = "r.gallegos@cisne.com.pe,j.blanco@cisne.com.pe";
		
		/*
		* CONTABILIDAD Y CAJA
		*/
		
		$CorreosNotificacionPagoProveedor = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionFacturaRegistro = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolso = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionDesembolsoCaja = "g.villanueva@cisne.com.pe,j.blanco@cisne.com.pe";
		$CorreosNotificacionSolicitudDesembolso = "p.regente@cisne.com.pe,g.villanueva@cisne.com.pe,c.arenas@cisne.com.pe,j.blanco@cisne.com.pe";
		
			/*
		* CITAS
		*/
		
		$CorreosNotificacionCitasSucursal = "r.gallegos@cisne.com.pe,j.blanco@cisne.com.pe";

	break;
	
	default://
	
	break;

}


?>
