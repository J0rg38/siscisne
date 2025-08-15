<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaDirecta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaDirecta {

    public $VdiId;
	public $CliId;
	public $VdiFecha;
	
	public $MonId;
	public $VdiTipoCambio;
	public $NpaId;
	
	public $CprId;
	public $TopId;
	public $EinId;
	
	public $FinId;
	public $PerId;

	public $VdiOrdenCompraNumero;
	public $VdiOrdenCompraFecha;
	
	public $VdiMarca;
	public $VdiModelo;
	public $VdiPlaca;
	public $VdiAnoModelo;
	public $VdiAnoFabricacion;
	
	public $VdiDireccion;
    public $VdiObservacion;	
	public $VdiObservacionImpresa;
	public $VdiResultado;
	
	public $VdiPorcentajeImpuestoVenta;
	public $VdiPorcentajeMargenUtilidad;	
	public $VdiPorcentajeOtroCosto;
	
		
	public $VdiManoObra;
	public $VdiPorcentajeDescuento;
	
	public $VdiPlanchadoTotal;
	public $VdiPintadoTotal;
	public $VdiCentradoTotal;
	public $VdiTareaTotal;
	
	public $VdiDescuento;
	public $VdiSubTotal;
	public $VdiImpuesto;
	public $VdiTotal;
	
	public $VdiTipoPedido;
	public $VdiCodigoExterno;
	public $VdiObservado;
	
	public $VdiOrigen;
	public $VdiIncluyeImpuesto;
	
	public $VdiNotificar;
	public $VdiArchivo;
	public $VdiArchivoEntrega;
	public $VdiArchivoEntrega2;
	
	public $VdiEstado;
	public $VdiTiempoCreacion;
	public $VdiTiempoModificacion;
    public $VdiEliminado;

	public $VdiTotalItems;
	
	public $VdiPedidoCompra;
	public $VdiVentaConcretada;
	
	public $VentaDirectaDetalle;
	public $VentaDirectaPlanchado;
	public $VentaDirectaPintado;
	public $VentaDirectaCentrado;
	public $VentaDirectaTarea;
	public $VentaDirectaFoto;
	
	public $CliNombre;
	public $TdoId;
	public $LtiId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliCelular;
	public $CliFax;
	
	public $TopNombre;
	public $TdoNombre;
	public $LtiNombre;

	public $MonNombre;
	public $MonSimbolo;
	
	public $CprModelo;
	public $CprAnoModelo;
	
    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	public function MtdGenerarVentaDirectaId() {

//$sql = 'SELECT	
//		MAX(CONVERT(SUBSTR(fin.FinId,10),unsigned)) AS "MAXIMO"
//		FROM tblfinfichaingreso fin
//			WHERE YEAR(fin.FinFecha) = '.$this->FinAno.';';
//
//		$resultado = $this->InsMysql->MtdConsultar($sql);                       
//		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//
//		if(empty($fila['MAXIMO'])){			
//			$this->FinId = "OT-".$this->FinAno."-00001";
//		}else{
//			$fila['MAXIMO']++;
//			$this->FinId = "OT-".$this->FinAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
//		}
//		
		
		
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(vdi.VdiId,10),unsigned)) AS "MAXIMO"
		FROM tblvdiventadirecta vdi
			LEFT JOIN tblsucsucursal suc
			ON vdi.SucId = suc.SucId
					
			WHERE YEAR(vdi.VdiFecha) = '.$this->VdiAno.'
			AND vdi.SucId = "'.$this->SucId.'"
			
			;';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->VdiId = "OV-".$this->VdiAno."-00001-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);;
		}else{
			$fila['MAXIMO']++;
			$this->VdiId = "OV-".$this->VdiAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT)."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);	
		}
		
//		
//		$sql = 'SELECT	
//		MAX(CONVERT(SUBSTR(vdi.VdiId,5),unsigned)) AS "MAXIMO"
//		FROM tblvdiventadirecta vdi	';
//		
//		$resultado = $this->InsMysql->MtdConsultar($sql);                       
//		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//		
//		if(empty($fila['MAXIMO'])){			
//			$this->VdiId = "VDI-10000";
//		}else{
//			$fila['MAXIMO']++;
//			$this->VdiId = "VDI-".$fila['MAXIMO'];					
//		}
	}

    public function MtdObtenerVentaDirecta($oCompleto=true){

		$sql = 'SELECT 
        vdi.VdiId, 
		vdi.SucId,
		 
		vdi.CliId,
		DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
		vdi.MonId,
		vdi.VdiTipoCambio,
		
		vdi.NpaId,
		
		vdi.CprId,
		vdi.TopId,
		vdi.EinId,
		
		vdi.FinId,
		vdi.PerId,
		
		vdi.VdiOrdenCompraNumero,
		DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
		
		vdi.VdiMarca,
		vdi.VdiModelo,
		vdi.VdiPlaca,
		vdi.VdiAnoModelo,
		vdi.VdiAnoFabricacion,
		
		vdi.VdiDireccion,
		vdi.VdiObservacion,
		vdi.VdiObservacionImpresa,
		vdi.VdiResultado,
		
		vdi.VdiPorcentajeImpuestoVenta,
		vdi.VdiPorcentajeMargenUtilidad,
		vdi.VdiPorcentajeOtroCosto,
		vdi.VdiPorcentajeManoObra,
		
		vdi.VdiManoObra,
		vdi.VdiPorcentajeDescuento,
		
		vdi.VdiPlanchadoTotal,
		vdi.VdiPintadoTotal,
		vdi.VdiCentradoTotal,
		vdi.VdiTareaTotal,
		
		vdi.VdiDescuento,
		vdi.VdiSubTotal,
		vdi.VdiImpuesto,
		vdi.VdiTotal,
		
		vdi.VdiOrigen,
		vdi.VdiIncluyeImpuesto,
		
		vdi.VdiNotificar,
		vdi.VdiArchivo,
		vdi.VdiArchivoEntrega,
		vdi.VdiArchivoEntrega2,
	
		vdi.VdiTipoPedido,
		vdi.VdiCodigoExterno,
		vdi.VdiObservado,
		vdi.VdiTipo,
vdi.VdiTipoFinal,
		
		vdi.VdiEstado,
		DATE_FORMAT(vdi.VdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoCreacion",
        DATE_FORMAT(vdi.VdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoModificacion",
		
		(SELECT 
		
		(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.VdiId = vdi.VdiId
					AND pag.PagEstado <> 6
			)
			
			ORDER BY pag.PagId ASC LIMIT 1

		) AS VdiAbono,

		@PagMonto:=(SELECT 

		SUM(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.VdiId = vdi.VdiId
					AND pag.PagEstado = 3
			)
			
		) AS VdiAbonado,
		
		(vdi.VdiTotal - IFNULL(@PagMonto,0)) AS VdiSaldo,
				
			
				
				



				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(vdd.VddCantidad,0) 
							
							- IFNULL(

								(
									SELECT 
									SUM(amd.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd
									
										LEFT JOIN tblamoalmacenmovimiento amo
										ON amd.AmoId = amo.AmoId
											
									WHERE amd.VddId = vdd.VddId
										AND amo.AmoEstado = 3
									LIMIT 1
								)
													
							,0)
							
							- IFNULL(
	
								(
									SELECT 
									SUM(pcd.PcdCantidad)
									FROM tblpcdpedidocompradetalle pcd
									
										LEFT JOIN tblpcopedidocompra pco
										ON pcd.PcoId = pco.PcoId
											
									WHERE pcd.VddId = vdd.VddId
										AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
									LIMIT 1
								)

							,0)
							
						)  AS VddCantidadPendiente

					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblamdalmacenmovimientodetalle amd
						ON amd.VddId = vdd.VddId
							LEFT JOIN tblproproducto pro
							ON vdd.ProId = pro.ProId

					WHERE vdd.VdiId = vdi.VdiId
						AND vdd.VddEstado = 1
						HAVING VddCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarVentaConcretada,
				
				
				
				
				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(vdd.VddCantidad,0) 
							
							
							- IFNULL(

								(
									SELECT 
									SUM(pcd.PcdCantidad)
									FROM tblpcdpedidocompradetalle pcd
									
										LEFT JOIN tblpcopedidocompra pco
										ON pcd.PcoId = pco.PcoId
											
									WHERE pcd.VddId = vdd.VddId
											AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
									LIMIT 1
								)

							,0)
							
							
							- IFNULL(

								(
									SELECT 
									SUM(amd.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd
									
										LEFT JOIN tblamoalmacenmovimiento amo
										ON amd.AmoId = amo.AmoId
											
									WHERE amd.VddId = vdd.VddId
										AND amo.AmoEstado = 3
									LIMIT 1
								)
													
							,0)
							
							
							
						)  AS VddCantidadPendiente

					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pcd.VddId = vdd.VddId

					WHERE vdd.VdiId = vdi.VdiId
						AND vdd.VddEstado = 1
						HAVING VddCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarPedidoCompra,
								
								
								
								
								








				CASE
				WHEN EXISTS (
					SELECT 
					pco.VdiId
					FROM tblpcopedidocompra pco
					WHERE pco.VdiId = vdi.VdiId
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPedidoCompra,
				
				CASE
				WHEN EXISTS (
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.VdiId = vdi.VdiId
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiVentaConcretada,
				
				
				
				


				CASE
				WHEN EXISTS (
					SELECT 
					vdd.CrdId 
					FROM tblvddventadirectadetalle vdd
					WHERE vdd.VdiId = vdi.VdiId 
					AND vdd.VddEstado = 1
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiRepuesto,

				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPlanchado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "N" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPintado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "E" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiCentrado,

				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiTarea,
				
				
		CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
		cli.CliAbreviatura,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.CliDireccion,
		cli.CliDepartamento,
		cli.CliProvincia,
		cli.CliDistrito,
		
		cli.TdoId,
		cli.LtiId,
		cli.CliNumeroDocumento,
		cli.CliTelefono,
		cli.CliEmail,
		cli.CliCelular,
		cli.CliFax,
	
		tdo.TdoNombre,
		lti.LtiNombre,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		ein.VmaId,
		vma.VmaNombre,

		ein.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,

		ein.VveId,		
		vve.VveNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		cpr.CprModelo,
		cpr.CprAnoModelo,
		
		per.PerAbreviatura,
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		per.PerTelefono,
		per.PerCelular,
		per.PerEmail,
		
		seg.CliNombre AS CliNombreSeguro,
		seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
		seg.CliApellidoMaterno AS CliApellidoMaternoSeguro		
						
        FROM tblvdiventadirecta vdi

			LEFT JOIN tblcprcotizacionproducto cpr
			ON vdi.CprId = cpr.CprId

				LEFT JOIN tblclicliente seg
				ON cpr.CliIdSeguro = seg.CliId

					LEFT JOIN tblclicliente cli
					ON vdi.Cliid = cli.CliId
					
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
					
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
					
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId
					
									LEFT JOIN tblmonmoneda mon
									ON vdi.MonId = mon.MonId
							
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
					
					LEFT JOIN tblperpersonal per
					ON vdi.PerId = per.PerId
					
		WHERE vdi.VdiId = "'.$this->VdiId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->VdiId = $fila['VdiId'];
			$this->SucId = $fila['SucId'];
			
			$this->CliId = $fila['CliId'];
			$this->VdiFecha = $fila['NVdiFecha'];
			$this->MonId = $fila['MonId'];
			$this->VdiTipoCambio = $fila['VdiTipoCambio'];
			
			$this->NpaId = $fila['NpaId'];
			
			$this->CprId = $fila['CprId'];
			$this->TopId = $fila['TopId'];
			$this->EinId = $fila['EinId'];

			$this->FinId = $fila['FinId'];
			$this->PerId = $fila['PerId'];

			$this->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$this->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
			
			$this->VdiMarca = $fila['VdiMarca'];
			$this->VdiModelo = $fila['VdiModelo'];
			$this->VdiPlaca = $fila['VdiPlaca'];
			$this->VdiAnoModelo = $fila['VdiAnoModelo'];
			$this->VdiAnoFabricacion = $fila['VdiAnoFabricacion'];

			$this->VdiDireccion = $fila['VdiDireccion'];
			$this->VdiObservacion = $fila['VdiObservacion'];
			$this->VdiObservacionImpresa = $fila['VdiObservacionImpresa'];
			$this->VdiResultado = $fila['VdiResultado'];


			$this->VdiPorcentajeImpuestoVenta = $fila['VdiPorcentajeImpuestoVenta'];
			$this->VdiPorcentajeMargenUtilidad = $fila['VdiPorcentajeMargenUtilidad'];
			$this->VdiPorcentajeOtroCosto = $fila['VdiPorcentajeOtroCosto'];
			$this->VdiPorcentajeManoObra = $fila['VdiPorcentajeManoObra'];

			$this->VdiManoObra = $fila['VdiManoObra'];
			$this->VdiPorcentajeDescuento = $fila['VdiPorcentajeDescuento'];
			
			$this->VdiPlanchadoTotal = $fila['VdiPlanchadoTotal'];
			$this->VdiPintadoTotal = $fila['VdiPintadoTotal'];
			$this->VdiCentradoTotal = $fila['VdiCentradoTotal'];
			$this->VdiTareaTotal = $fila['VdiTareaTotal'];
			
			$this->VdiDescuento = $fila['VdiDescuento'];
			$this->VdiSubTotal = $fila['VdiSubTotal'];
			$this->VdiImpuesto = $fila['VdiImpuesto'];
			$this->VdiTotal = $fila['VdiTotal'];
			
			$this->VdiAbonado = $fila['VdiAbonado'];
			$this->VdiSaldo = $fila['VdiSaldo'];

				
			$this->VdiOrigen = $fila['VdiOrigen'];
			
			
			$this->VdiIncluyeImpuesto = $fila['VdiIncluyeImpuesto'];
			
			
			$this->VdiNotificar = $fila['VdiNotificar'];
			
			
			$this->VdiArchivo = $fila['VdiArchivo'];
			$this->VdiArchivoEntrega = $fila['VdiArchivoEntrega'];
			$this->VdiArchivoEntrega2 = $fila['VdiArchivoEntrega2'];
	
			
			$this->VdiTipoPedido = $fila['VdiTipoPedido'];
			$this->VdiCodigoExterno = $fila['VdiCodigoExterno'];
			$this->VdiObservado = $fila['VdiObservado'];

			$this->VdiTipo = $fila['VdiTipo'];
			$this->VdiTipoFinal = $fila['VdiTipoFinal'];
			$this->VdiEstado = $fila['VdiEstado'];
			$this->VdiTiempoCreacion = $fila['NVdiTiempoCreacion']; 
			$this->VdiTiempoModificacion = $fila['NVdiTiempoModificacion'];
			
			$this->VdiAbono = $fila['VdiAbono'];
			
			$this->VdiGenerarVentaConcretada = $fila['VdiGenerarVentaConcretada'];
			$this->VdiGenerarPedidoCompra = $fila['VdiGenerarPedidoCompra'];
					
			
			$this->VdiPedidoCompra = $fila['VdiPedidoCompra'];
			$this->VdiVentaConcretada = $fila['VdiVentaConcretada'];
				
			$this->CliAbreviatura = $fila['CliAbreviatura']; 
			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			
			$this->CliDireccion = $fila['CliDireccion']; 
			$this->CliDepartamento = $fila['CliDepartamento']; 
			$this->CliProvincia = $fila['CliProvincia']; 
			$this->CliDistrito = $fila['CliDistrito']; 

			$this->TdoId = $fila['TdoId']; 
			$this->LtiId = $fila['LtiId']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$this->CliTelefono = $fila['CliTelefono'];
			$this->CliEmail = $fila['CliEmail'];
			$this->CliCelular = $fila['CliCelular'];
			$this->CliFax = $fila['CliFax'];	
			
			$this->TdoNombre = $fila['TdoNombre'];
			$this->LtiNombre = $fila['LtiNombre'];
			
			
			$this->EinVIN = $fila['EinVIN'];
			$this->EinPlaca = $fila['EinPlaca'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];
			
			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->VtiId = $fila['VtiId'];
			$this->VtiNombre = $fila['VtiNombre'];
			
			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->VdiRepuesto = $fila['VdiRepuesto'];
			$this->VdiPlanchado = $fila['VdiPlanchado'];
			$this->VdiPintado = $fila['VdiPintado'];
			$this->VdiCentrado = $fila['VdiCentrado'];
			$this->VdiTarea = $fila['VdiTarea'];
			
			$this->CprModelo = $fila['CprModelo'];
			$this->CprAnoModelo = $fila['CprAnoModelo'];
			
			$this->PerAbreviatura = $fila['PerAbreviatura'];
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			$this->PerTelefono = $fila['PerTelefono'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerEmail = $fila['PerEmail'];
	
			$this->CliNombreSeguro = $fila['CliNombreSeguro'];
			$this->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
			$this->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];
			
			switch($this->VdiEstado){
				
				case 1:
					$this->VdiEstadoDescripcion = "Pendiente";
				break;
				
				case 3:
					$this->VdiEstadoDescripcion = "Realizado";
				break;	
				
				case 6:
					$this->VdiEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->VdiEstadoDescripcion = "";
				break;
				
			}
			
			
			switch($this->VdiEstado){
				
				case 1:
					$this->VdiEstadoIcono = '<img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />';
				break;
				
				case 3:
					$this->VdiEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />';
				break;	

				default:
					$this->VdiEstadoIcono = "";
				break;
				
			}

			if($oCompleto){
	
	
				$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
						$ResVentaDirectaDetalle =  $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,NULL,NULL,NULL,$this->VdiId);
						$this->VentaDirectaDetalle = 	$ResVentaDirectaDetalle['Datos'];
						
			//MtdObtenerVentaDirectaTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL)
			
						$InsVentaDirectaTarea = new ClsVentaDirectaTarea();
						
						$ResVentaDirectaPlanchado =  $InsVentaDirectaTarea->MtdObtenerVentaDirectaTareas(NULL,NULL,NULL,NULL,NULL,$this->VdiId,NULL,"L");
						$this->VentaDirectaPlanchado = 	$ResVentaDirectaPlanchado['Datos'];
						
						$ResVentaDirectaPintado =  $InsVentaDirectaTarea->MtdObtenerVentaDirectaTareas(NULL,NULL,NULL,NULL,NULL,$this->VdiId,NULL,"N");
						$this->VentaDirectaPintado = 	$ResVentaDirectaPintado['Datos'];
						
						$ResVentaDirectaCentrado =  $InsVentaDirectaTarea->MtdObtenerVentaDirectaTareas(NULL,NULL,NULL,NULL,NULL,$this->VdiId,NULL,"E");
						$this->VentaDirectaCentrado = 	$ResVentaDirectaCentrado['Datos'];
						
						$ResVentaDirectaTarea =  $InsVentaDirectaTarea->MtdObtenerVentaDirectaTareas(NULL,NULL,NULL,NULL,NULL,$this->VdiId,NULL,"Z");
						$this->VentaDirectaTarea = 	$ResVentaDirectaTarea['Datos'];
						
						$InsVentaDirectaFoto = new ClsVentaDirectaFoto();
						//MtdObtenerVentaDirectaFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
						$ResVentaDirectaFoto =  $InsVentaDirectaFoto->MtdObtenerVentaDirectaFotos(NULL,NULL,NULL,NULL,NULL,$this->VdiId,NULL,NULL);
						$this->VentaDirectaFoto = 	$ResVentaDirectaFoto['Datos'];
						
			}
			
			

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


//MtdObtenerVentaDirectas
    public function MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false,$oPersonal=NULL,$oConCodigoExterno=0,$oSucursal=NULL,$oTipo=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$estado = '';
		$conCotizacionRepuesto = '';
		$cotizacionRepuestoEstado = '';
		$cotizacionRepuesto = '';
		$moneda = '';
		$cliente = '';
		$conOrdenCompraReferencia = '';
		$pedidoCompra = '';
		$ventaConcretada = '';
		$clienteClasificacion = '';
		$origen = '';
		$observado = '';
		$estricto = '';
		$ordenCompraReferencia = '';
		$productoCodigoOriginal = '';
		$ordenCompraTipo = '';
		$exonerar = '';
		$fichaIngreso = '';
		$tieneGenerarVentaConcretada = '';
		$personal = '';
		$conCodigoExterno = '';
		$sucursal = '';
		$tipo = '';

//$oOrdenCompraTipo

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}


	
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
					
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco

					WHERE 
						pco.VdiId = vdi.VdiId AND
						(
						pco.OcoId  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

		}


		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND vdi.VdiEstado = '.$oEstado;
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(($oConCotizacionRepuesto==1)){
			$concrepuesto = ' AND  vdi.CprId IS NOT NULL ';
		}elseif($oConCotizacionRepuesto==2){
			$concrepuesto = ' AND  vdi.CprId IS NULL ';
		}
		
		if(!empty($oCotizacionRepuestoEstado)){
			$crestado = ' AND cpr.CprEstado = '.$oCotizacionRepuestoEstado;
		}	
				
		if(!empty($oCotizacionRepuesto)){
			$crepuesto = ' AND vdi.CprId = "'.$oCotizacionRepuesto.'"';
		}		
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
			
//				CASE
//				WHEN EXISTS (
//					SELECT 
//					pco.VdiId
//					FROM tblpcopedidocompra pco
//					WHERE pco.VdiId = vdi.VdiId
//					LIMIT 1
//				) THEN "Si"
//				ELSE "No"
//				END AS VdiPedidoCompra,
				
		if(!empty($oPedidoCompra)){
			
			switch($oPedidoCompra){
				
				case "Si":

					$pcompra = ' AND 
						
						EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
			 
				break;
				
				case "No":

					$pcompra = ' AND 
						
						NOT EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
					
				break;
				
				default:
				
				break;
			}
			
		}	
		
		
		if(!empty($oVentaConcretada)){
			
			switch($oVentaConcretada){
				
				case "Si":

					$vconcretada = ' AND EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				case "No":

					$vconcretada = ' AND NOT EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				default:
				
				break;
			}
			
		}	
	
		
		if(!empty($oClienteClasificacion)){
			$clasificacion = ' AND cli.CliClasificacion = '.$oClienteClasificacion.' ';
		}
//		if(!empty($oVentaConcretada)){
//			$vconcretada = ' AND vdi.CliId = "'.$oVentaConcretada.'"';
//		}	
		if(!empty($oOrigen)){
			$origen = ' AND vdi.VdiOrigen = "'.$oOrigen.'"';
		}
		
		if(!empty($oObservado)){
			$observado = ' AND vdi.VdiObservado = '.$oObservado.'';
		}
		
		if(($oEstricto)){
			$estricto = ' AND 
			
				(
					EXISTS (
						SELECT 
						pco.VdiId
						FROM tblpcopedidocompra pco
						WHERE pco.VdiId = vdi.VdiId
						LIMIT 1
					)			
	
				OR
					EXISTS (
						SELECT 
						amo.AmoId
						FROM tblamoalmacenmovimiento amo
						WHERE amo.VdiId = vdi.VdiId
						LIMIT 1
					)
				)
			
			';
		}
		


		
		if(!empty($oOrdenCompraReferencia)){
			$ocreferencia = ' AND vdi.VdiOrdenCompraNumero LIKE "%'.$oOrdenCompraReferencia.'%"';
		}
		
		if(!empty($oProductoCodigoOriginal)){
			
			$pcoriginal = '
			
			AND EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProCodigoOriginal  LIKE "%'.$oProductoCodigoOriginal.'%" 
						)
						
					)
					
			';
		}
		
		
		if(!empty($oOrdenCompraTipo)){
			
			
			$octipo = ' AND 
						EXISTS (
							SELECT 
							pco.PcoId
							FROM tblpcopedidocompra pco
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
							WHERE pco.VdiId = vdi.VdiId
							AND oco.OcoTipo LIKE "%'.$oOrdenCompraTipo.'%"
							LIMIT 1
						)
					';
			 
			 
		}
		
		
		if(!empty($oExonerar)){

			$elementos = explode(",",$oExonerar);

			$i=1;
			$exonerar .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$exonerar .= '  (vdi.CliId <> "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$exonerar .= ' AND ';	
				}
			$i++;		
			}

			$exonerar .= ' ) 
			)
			';

		}
		
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND vdi.FinId = "'.$oFichaIngreso.'"';
		}
		
		
		if($oTieneGenerarVentaConcretada == true){


			$gvconcretada = ' AND 
			
			(
			
			IFNULL(
			
					(
					SELECT 
					SUM(vdd.VddCantidad)
					FROM tblvddventadirectadetalle vdd
					
					WHERE vdd.VdiId = vdi.VdiId
						AND vdd.VddEstado = 1
					LIMIT 1
					),0)
				
					-
					
					IFNULL((SELECT
						SUM(pcd.PcdCantidad)
						FROM tblvddventadirectadetalle vdd
						
							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON pcd.VddId = vdd.VddId
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
						
						WHERE vdd.VdiId = vdi.VdiId
							AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
						AND vdd.VddEstado = 1
						LIMIT 1
						),0)
				
			) > 0';
			
			
		}


		if(!empty($oPersonal)){
			$personal = ' AND vdi.PerId = "'.$oPersonal.'"';
		}
	
	
		if(!empty($oConCodigoExterno)){
			
			switch($oConCodigoExterno){
				case 1:
					$ccexterno = ' AND vdi.VdiCodigoExterno IS NOT NULL AND  vdi.VdiCodigoExterno != "" ';
				break;
				
				case 2:
					$ccexterno = ' AND vdi.VdiCodigoExterno IS NULL AND  vdi.VdiCodigoExterno = "" ';
				break;
			}
			
		}	
		
	 	if(!empty($oSucursal)){
			$sucursal = ' AND vdi.SucId = "'.$oSucursal.'"';
		}	
		
		if(!empty($oTipo)){
			$tipo = ' AND vdi.VdiTipo = "'.$oTipo.'"';
		}	
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vdi.VdiId,	
				vdi.SucId,
				
				vdi.CliId,			
				DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
				
				vdi.MonId,
				vdi.VdiTipoCambio,
				
				  vdi.NpaId,
				  
				vdi.CprId,
				vdi.TopId,
				vdi.EinId,
				
				vdi.FinId,
				
				vdi.VdiOrdenCompraNumero,
				DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
				vdi.VdiMarca,
				vdi.VdiModelo,
				vdi.VdiPlaca,
				vdi.VdiAnoModelo,
				vdi.VdiAnoFabricacion,
				
				vdi.VdiDireccion,
				vdi.VdiObservacion,
				vdi.VdiObservacionImpresa,
				vdi.VdiResultado,
				
				vdi.VdiPorcentajeImpuestoVenta,
				vdi.VdiPorcentajeMargenUtilidad,
				vdi.VdiPorcentajeOtroCosto,
				vdi.VdiPorcentajeManoObra,
				
				vdi.VdiManoObra,
				vdi.VdiPorcentajeDescuento,
				
				vdi.VdiPlanchadoTotal,
				vdi.VdiPintadoTotal,
				vdi.VdiCentradoTotal,
				vdi.VdiTareaTotal,
				
				vdi.VdiDescuento,
				vdi.VdiSubTotal,
				vdi.VdiImpuesto,
				vdi.VdiTotal,
								
				vdi.VdiOrigen,
				vdi.VdiIncluyeImpuesto,
				
				vdi.VdiNotificar,
				vdi.VdiArchivo,
				vdi.VdiArchivoEntrega,
				vdi.VdiArchivoEntrega2,
				
				vdi.VdiTipoPedido,
				vdi.VdiCodigoExterno,
				vdi.VdiObservado,
				
				vdi.VdiTipo,
vdi.VdiTipoFinal,
				vdi.VdiEstado,
				DATE_FORMAT(vdi.VdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoCreacion",
	        	DATE_FORMAT(vdi.VdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoModificacion",
				(SELECT COUNT(vdd.VdiId) FROM tblvddventadirectadetalle vdd WHERE vdd.VdiId = vdi.VdiId ) AS "VdiTotalItems",

				
				@VddCantidad:=IFNULL((
				SELECT 
				SUM(vdd.VddCantidad)
				FROM tblvddventadirectadetalle vdd
				
				WHERE vdd.VdiId = vdi.VdiId
					AND vdd.VddEstado = 1
				LIMIT 1
				),0),


				@AmdCantidad:=IFNULL((
					SELECT 
					SUM(amd.AmdCantidad) 
					FROM tblvddventadirectadetalle vdd
					
						LEFT JOIN tblamdalmacenmovimientodetalle amd
						ON amd.VddId = vdd.VddId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
							
					WHERE vdd.VdiId = vdi.VdiId
					AND amo.AmoEstado = 3
					AND vdd.VddEstado = 1
					LIMIT 1
				),0),
							

				@PcdCantidad:=IFNULL((SELECT
					SUM(pcd.PcdCantidad)
					FROM tblvddventadirectadetalle vdd
					
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pcd.VddId = vdd.VddId
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
					
					WHERE vdd.VdiId = vdi.VdiId
					AND pco.PcOEstado = 3	
					AND vdd.VddEstado = 1
					LIMIT 1
					),0),
				
				IF(
					(
					@VddCantidad - @AmdCantidad
					)>0
				,"Si","No") AS VdiGenerarVentaConcretada,
				
				
				
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(vdd.VddCantidad,0) 
							
							
							- IFNULL(

								(
									SELECT 
									SUM(pcd.PcdCantidad)
									FROM tblpcdpedidocompradetalle pcd
									
										LEFT JOIN tblpcopedidocompra pco
										ON pcd.PcoId = pco.PcoId
											
									WHERE pcd.VddId = vdd.VddId
											AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
									LIMIT 1
								)

							,0)
							
							
							- IFNULL(

								(
									SELECT 
									SUM(amd.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd
									
										LEFT JOIN tblamoalmacenmovimiento amo
										ON amd.AmoId = amo.AmoId
											
									WHERE amd.VddId = vdd.VddId
										AND amo.AmoEstado = 3
									LIMIT 1
								)
													
							,0)
							
							
							
						)  AS VddCantidadPendiente

					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pcd.VddId = vdd.VddId
							LEFT JOIN tblproproducto pro
							ON vdd.ProId = pro.ProId

					WHERE vdd.VdiId = vdi.VdiId
						AND vdd.VddEstado = 1
						HAVING VddCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarPedidoCompra,
								
				
				
			
				
				
			







				CASE
				WHEN EXISTS (
					SELECT 
					pco.VdiId
					FROM tblpcopedidocompra pco
					WHERE pco.VdiId = vdi.VdiId
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPedidoCompra,

				CASE
				WHEN EXISTS (
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
					WHERE amo.VdiId = vdi.VdiId
					AND amo.AmoEstado = 3
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiVentaConcretada,

				CASE
				WHEN EXISTS (
					SELECT 
					amo.AmoId
					FROM tblamoalmacenmovimiento amo
						LEFT JOIN tblamdalmacenmovimientodetalle amd
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblvddventadirectadetalle vdd
							ON amd.VddId = vdd.VddId
								
					WHERE vdd.VdiId = vdi.VdiId
					AND amo.AmoEstado = 3
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiFichaIngreso,



				CASE
				WHEN EXISTS (
					SELECT 
					vdd.CrdId 
					FROM tblvddventadirectadetalle vdd
					WHERE vdd.VdiId = vdi.VdiId 
					AND vdd.VddEstado = 1
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiRepuesto,

				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "L" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPlanchado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "N" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiPintado,
				
				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "E" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiCentrado,

				CASE
				WHEN EXISTS (
					SELECT 
					vdt.VdiId 
					FROM tblvdtventadirectatarea vdt 
					WHERE vdt.VdiId = vdi.VdiId AND vdt.VdtTipo = "Z" LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiTarea,

				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.VdiId = vdi.VdiId 
					AND pag.PagEstado <> 6
					LIMIT 1
					
				) THEN "Si"
				ELSE "No"
				END AS VdiPago,
					
				
				CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
				
						
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
		
				
				cli.TdoId,
				cli.LtiId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
			
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",				

				ein.EinVIN,
				ein.EinPlaca,

				ein.VmaId,
				vma.VmaNombre,

				ein.VmoId,
				vmo.VmoNombre,

				vmo.VtiId,
				vti.VtiNombre,

				ein.VveId,		
				vve.VveNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				npa.NpaNombre
			

				FROM tblvdiventadirecta vdi
					LEFT JOIN tblclicliente cli
					ON vdi.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tblcprcotizacionproducto cpr
								ON vdi.CprId = cpr.CprId
								
							LEFT JOIN tblmonmoneda mon
							ON vdi.MonId = mon.MonId
							
							
						LEFT JOIN tbleinvehiculoingreso ein
						ON vdi.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
					
					LEFT JOIN tblperpersonal per
					ON vdi.PerId = per.PerId
						
						LEFT JOIN tblnpacondicionpago npa
						ON vdi.NpaId = npa.NpaId
						
							
				WHERE  1 = 1  '.$filtrar.$tipo.$fecha.$tipo.$stipo.$estado.$sucursal.$faccion.$fingreso.$ccexterno .$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$crepuesto.$moneda.$cliente.$coreferencia.$pcompra.$vconcretada.$clasificacion.$origen.$observado.$estricto.$pcoriginal.$ocreferencia.$octipo.$exonerar.$fingreso.$gvconcretada.$facturable.$personal.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirecta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirecta = new $InsVentaDirecta();
                    $VentaDirecta->VdiId = $fila['VdiId'];
					$VentaDirecta->CliId = $fila['CliId'];
					$VentaDirecta->VdiFecha = $fila['NVdiFecha'];
					$VentaDirecta->MonId = $fila['MonId'];
					$VentaDirecta->VdiTipoCambio = $fila['VdiTipoCambio'];
					
					$VentaDirecta->NpaId = $fila['NpaId'];
					
					$VentaDirecta->CprId = $fila['CprId'];
					$VentaDirecta->TopId = $fila['TopId'];
					$VentaDirecta->EinId = $fila['EinId'];
					
					$VentaDirecta->FinId = $fila['FinId'];					
					
					//VdiPago
					
					$VentaDirecta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$VentaDirecta->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					$VentaDirecta->VdiMarca = $fila['VdiMarca'];
					$VentaDirecta->VdiModelo = $fila['VdiModelo'];
					$VentaDirecta->VdiPlaca = $fila['VdiPlaca'];
					$VentaDirecta->VdiAnoModelo = $fila['VdiAnoModelo'];
					$VentaDirecta->VdiAnoFabricacion = $fila['VdiAnoFabricacion'];
					
					$VentaDirecta->VdiDireccion = $fila['VdiDireccion'];
					$VentaDirecta->VdiObservacion = $fila['VdiObservacion'];
					$VentaDirecta->VdiObservacionImpresa = $fila['VdiObservacionImpresa'];
					$VentaDirecta->VdiResultado = $fila['VdiResultado'];
					
					$VentaDirecta->VdiPorcentajeImpuestoVenta = $fila['VdiPorcentajeImpuestoVenta'];
					$VentaDirecta->VdiPorcentajeMargenUtilidad = $fila['VdiPorcentajeMargenUtilidad'];
					$VentaDirecta->VdiPorcentajeOtroCosto = $fila['VdiPorcentajeOtroCosto'];
					$VentaDirecta->VdiPorcentajeManoObra = $fila['VdiPorcentajeManoObra'];

					$VentaDirecta->VdiManoObra = $fila['VdiManoObra'];
					$VentaDirecta->VdiPorcentajeDescuento = $fila['VdiPorcentajeDescuento'];
					
					$VentaDirecta->VdiPlanchadoTotal = $fila['VdiPlanchadoTotal'];
					$VentaDirecta->VdiPintadoTotal = $fila['VdiPintadoTotal'];
					$VentaDirecta->VdiCentradoTotal = $fila['VdiCentradoTotal'];
					$VentaDirecta->VdiTareaTotal = $fila['VdiTareaTotal'];
					
					$VentaDirecta->VdiDescuento = $fila['VdiDescuento'];
					$VentaDirecta->VdiSubTotal = $fila['VdiSubTotal'];
					$VentaDirecta->VdiImpuesto = $fila['VdiImpuesto'];
					$VentaDirecta->VdiTotal = $fila['VdiTotal'];

					$VentaDirecta->VdiOrigen = $fila['VdiOrigen'];
					
					$VentaDirecta->VdiIncluyeImpuesto = $fila['VdiIncluyeImpuesto'];
					
					$VentaDirecta->VdiNotificar = $fila['VdiNotificar'];
					$VentaDirecta->VdiArchivo = $fila['VdiArchivo'];
					$VentaDirecta->VdiArchivoEntrega = $fila['VdiArchivoEntrega'];
					$VentaDirecta->VdiArchivoEntrega2 = $fila['VdiArchivoEntrega2'];

					$VentaDirecta->VdiTipoPedido = $fila['VdiTipoPedido'];
					$VentaDirecta->VdiCodigoExterno = $fila['VdiCodigoExterno'];
					$VentaDirecta->VdiObservado = $fila['VdiObservado'];
					$VentaDirecta->VdiTipo = $fila['VdiTipo'];
					$VentaDirecta->VdiTipoFinal = $fila['VdiTipoFinal'];
					
					$VentaDirecta->VdiEstado = $fila['VdiEstado'];
					$VentaDirecta->VdiTiempoCreacion = $fila['NVdiTiempoCreacion'];  
					$VentaDirecta->VdiTiempoModificacion = $fila['NVdiTiempoModificacion']; 

					$VentaDirecta->VdiTotalItems = $fila['VdiTotalItems'];
					
					$VentaDirecta->VdiGenerarVentaConcretada = $fila['VdiGenerarVentaConcretada'];
					$VentaDirecta->VdiGenerarPedidoCompra = $fila['VdiGenerarPedidoCompra'];
					
					$VentaDirecta->VdiPedidoCompra = $fila['VdiPedidoCompra'];
					$VentaDirecta->VdiVentaConcretada = $fila['VdiVentaConcretada'];
					$VentaDirecta->VdiFichaIngreso = $fila['VdiFichaIngreso'];
					
					
					
					$VentaDirecta->VdiPago = $fila['VdiPago'];

					$VentaDirecta->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VentaDirecta->CliNombre = $fila['CliNombre'];
					$VentaDirecta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VentaDirecta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$VentaDirecta->CliDireccion = $fila['CliDireccion'];
					$VentaDirecta->CliDepartamento = $fila['CliDepartamento'];
					$VentaDirecta->CliProvincia = $fila['CliProvincia'];
					$VentaDirecta->CliDistrito = $fila['CliDistrito'];
		
					$VentaDirecta->TdoId = $fila['TdoId'];
					$VentaDirecta->LtiId = $fila['LtiId'];
					$VentaDirecta->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VentaDirecta->CliTelefono = $fila['CliTelefono'];
					$VentaDirecta->CliEmail = $fila['CliEmail'];
					$VentaDirecta->CliCelular = $fila['CliCelular'];
					$VentaDirecta->CliFax = $fila['CliFax'];
					
					$VentaDirecta->TdoNombre = $fila['TdoNombre'];
					$VentaDirecta->LtiNombre = $fila['LtiNombre'];
					$VentaDirecta->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VentaDirecta->CprFecha = $fila['NCprFecha'];

					$VentaDirecta->EinVIN = $fila['EinVIN'];
					$VentaDirecta->EinPlaca = $fila['EinPlaca'];

					$VentaDirecta->VmaId = $fila['VmaId'];
					$VentaDirecta->VmaNombre = $fila['VmaNombre'];

					$VentaDirecta->VmoId = $fila['VmoId'];
					$VentaDirecta->VmoNombre = $fila['VmoNombre'];

					$VentaDirecta->VtiId = $fila['VtiId'];
					$VentaDirecta->VtiNombre = $fila['VtiNombre'];

					$VentaDirecta->VveId = $fila['VveId'];
					$VentaDirecta->VveNombre = $fila['VveNombre'];
					
					$VentaDirecta->MonNombre = $fila['MonNombre'];
					$VentaDirecta->MonSimbolo = $fila['MonSimbolo'];
					
					$VentaDirecta->VdiRepuesto = $fila['VdiRepuesto'];
					$VentaDirecta->VdiPlanchado = $fila['VdiPlanchado'];
					$VentaDirecta->VdiPintado = $fila['VdiPintado'];
					$VentaDirecta->VdiCentrado = $fila['VdiCentrado'];
					$VentaDirecta->VdiTarea = $fila['VdiTarea'];
					
					$VentaDirecta->PerNombre = $fila['PerNombre'];
					$VentaDirecta->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VentaDirecta->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$VentaDirecta->NpaNombre = $fila['NpaNombre'];
					$VentaDirecta->OcoProcesadoProveedor = $fila['OcoProcesadoProveedor'];

			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoDescripcion = "Pendiente";
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoDescripcion = "Realizado";
						break;	
						
						case 6:
							$VentaDirecta->VdiEstadoDescripcion = "Anulado";
						break;	
		
						default:
							$VentaDirecta->VdiEstadoDescripcion = "";
						break;
						
					}
			
			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />';
						break;
						
						case 6:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/anulado.gif" />';
						break;	
		
						default:
							$VentaDirecta->VdiEstadoIcono = "";
						break;
						
					}

                    $VentaDirecta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirecta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	public function MtdObtenerVentaDirectasValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oExonerar=NULL,$oPersonal=NULL) {
	
	if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}


	
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
					
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco

					WHERE 
						pco.VdiId = vdi.VdiId AND
						(
						pco.OcoId  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

			
	

					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND vdi.VdiEstado = '.$oEstado;
		}
		


		

		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}
		
	


		if(($oConCotizacionRepuesto==1)){
			$concrepuesto = ' AND  vdi.CprId IS NOT NULL ';
		}elseif($oConCotizacionRepuesto==2){
			$concrepuesto = ' AND  vdi.CprId IS NULL ';
		}
		
		if(!empty($oCotizacionRepuestoEstado)){
			$crestado = ' AND cpr.CprEstado = '.$oCotizacionRepuestoEstado;
		}	
				
		if(!empty($oCotizacionRepuesto)){
			$crepuesto = ' AND vdi.CprId = "'.$oCotizacionRepuesto.'"';
		}		
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
			
//				CASE
//				WHEN EXISTS (
//					SELECT 
//					pco.VdiId
//					FROM tblpcopedidocompra pco
//					WHERE pco.VdiId = vdi.VdiId
//					LIMIT 1
//				) THEN "Si"
//				ELSE "No"
//				END AS VdiPedidoCompra,
				
		if(!empty($oPedidoCompra)){
			
			switch($oPedidoCompra){
				
				case "Si":

					$pcompra = ' AND 
						
						EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
			 
				break;
				
				case "No":

					$pcompra = ' AND 
						
						NOT EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
					
				break;
				
				default:
				
				break;
			}
			
		}	
		
		
		if(!empty($oVentaConcretada)){
			
			switch($oVentaConcretada){
				
				case "Si":

					$vconcretada = ' AND EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				case "No":

					$vconcretada = ' AND NOT EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				default:
				
				break;
			}
			
		}	

		if(!empty($oClienteClasificacion)){
			$clasificacion = ' AND cli.CliClasificacion = '.$oClienteClasificacion.' ';
		}

		//if(!empty($oExonerar)){
//			$exonerar = ' AND vdi.CliId <> "'.$oExonerar.'"';
//		}

		if(!empty($oExonerar)){

			$elementos = explode(",",$oExonerar);

			$i=1;
			$exonerar .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$exonerar .= '  (vdi.CliId <> "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$exonerar .= ' AND ';	
				}
			$i++;		
			}

			$exonerar .= ' ) 
			)
			';

		}
		
		if(!empty($oPersonal)){
			$personal = ' AND vdi.PerId = "'.$oPersonal.'"';
		}
		
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vdi.VdiFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vdi.VdiFecha) ="'.($oAno).'"';
		}
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"

				FROM tblvdiventadirecta vdi
					LEFT JOIN tblclicliente cli
					ON vdi.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tblcprcotizacionproducto cpr
								ON vdi.CprId = cpr.CprId
								
							LEFT JOIN tblmonmoneda mon
							ON vdi.MonId = mon.MonId
							
							
						LEFT JOIN tbleinvehiculoingreso ein
						ON vdi.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
					
					LEFT JOIN tblperpersonal per
					ON vdi.PerId = per.PerId
						
						LEFT JOIN tblnpacondicionpago npa
						ON vdi.NpaId = npa.NpaId
					
				WHERE  1 = 1  '.$mes.$ano.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$crepuesto.$personal.$moneda.$cliente.$coreferencia.$pcompra.$vconcretada.$clasificacion.$exonerar.$orden.$paginacion;
				
				
				$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
	
	}	
	
	//Accion eliminar	 
	public function MtdEliminarVentaDirecta($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
		$InsVentaDirectaTarea = new ClsVentaDirectaTarea();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VdiId','Desc',NULL,$elemento);
				$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

				if(!empty($ArrVentaDirectaDetalles)){

					$detalle = '';
					foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
						$detalle .= '#'.$DatVentaDirectaDetalle->VddId;
					}

					if(!$InsVentaDirectaDetalle->MtdEliminarVentaDirectaDetalle($detalle)){								
						$error = true;
					}
						
				}
				
				
				$ResVentaDirectaTarea = $InsVentaDirectaTarea->MtdObtenerVentaDirectaTareas(NULL,NULL,'VdtId','Desc',NULL,$elemento);
				$ArrVentaDirectaTareas = $ResVentaDirectaTarea['Datos'];

				if(!empty($ArrVentaDirectaTareas)){

					$detalle = '';
					foreach($ArrVentaDirectaTareas as $DatVentaDirectaTarea){
						$detalle .= '#'.$DatVentaDirectaTarea->VdtId;
					}

					if(!$InsVentaDirectaTarea->MtdEliminarVentaDirectaTarea($detalle)){								
						$error = true;
					}

				}



				if(!$error) {
					
					$this->VdiId = $elemento;
					$this->MtdObtenerVentaDirecta();
					
					$sql = 'DELETE FROM tblvdiventadirecta WHERE  (VdiId = "'.($elemento).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{

						if(!empty($this->CprId)){
							$InsCotizacionProducto = new ClsCotizacionProducto();
							$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($this->CprId,1,false);
						}

						$this->MtdAuditarVentaDirecta(3,"Se elimino la Orden de Venta",$elemento);		
					}
				}
				
			}
		$i++;

		}

		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();			
			return true;
		}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoVentaDirecta($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsVentaDirecta = new ClsVentaDirecta();
		$InsVentaDirectaDetalles = new ClsVentaDirectaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblvdiventadirecta SET VdiEstado = '.$oEstado.' WHERE VdiId = "'.$aux[0].'"';

					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarVentaDirecta(2,"Se actualizo el Estado de Venta Directa",$aux);
					}

				}
			$i++;
	
			}
	
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				
						
				return true;
			}									
	}
	
	
	public function MtdRegistrarVentaDirecta() {

		global $Resultado;

		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$this->MtdGenerarVentaDirectaId();


			if(empty($this->CliId)){
/*
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->VdiDireccion;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
				if(!empty($InsCliente->CliNombre)){

					if(!$InsCliente->MtdRegistrarClienteDeVentaDirecta()){
						$error = true;
						$Resultado.='#ERR_VDI_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
				}
*/
			}else{
				
				if(!empty($this->VdiDireccion)){
					
					//$InsCliente = new ClsCliente($this->InsMysql);
//					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->VdiDireccion,$this->CliId);
//	
				}
				
			}
			
			
			if(empty($this->EinId)){
				
				if(!empty($this->EinVIN)){
			
					$InsVehiculoIngreso = new ClsVehiculoIngreso();

					$InsVehiculoIngreso->EinId = $this->EinId;
					$InsVehiculoIngreso->SucId = $this->SucId;
					$InsVehiculoIngreso->EinVIN = $this->EinVIN;
					$InsVehiculoIngreso->EinPlaca = $this->VdiPlaca;
					$InsVehiculoIngreso->EinAnoModelo = $this->VdiAnoModelo;
					$InsVehiculoIngreso->EinAnoFabricacion = $this->VdiAnoFabricacion;
					$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
					$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");		

					if(!$InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeCotizacionProducto()){
						$error = true;
						$Resultado.='#ERR_VDI_502';
					}else{
						$this->EinId = $InsVehiculoIngreso->EinId;
					}					

				}

			}else{
				
				if(!empty($this->VdiAnoModelo)){

					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo",$this->VdiAnoModelo,$this->EinId);

				}
				
				
				if(!empty($this->VdiPlaca)){

					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca",$this->VdiPlaca,$this->EinId);

				}

			}
			
			
			$sql = 'INSERT INTO tblvdiventadirecta (
			VdiId,
			SucId,
			
			CliId,
			CprId,
			TopId,
			EinId,
			
			NpaId,
			PerId,
			FinId,
			
			VdiOrdenCompraNumero,
			VdiOrdenCompraFecha,
			
			VdiMarca,
			vdiModelo,
			VdiPlaca,
			VdiAnoModelo,
			VdiAnoFabricacion,
			
			VdiDireccion,
			VdiFecha,
			MonId,
			VdiTipoCambio,
			VdiObservacion,
			VdiObservacionImpresa,
			VdiResultado,
			
			VdiPorcentajeImpuestoVenta,
			VdiPorcentajeMargenUtilidad,
			VdiPorcentajeOtroCosto,
			VdiPorcentajeManoObra,
			
			
			VdiManoObra,
			VdiPorcentajeDescuento,
			
			VdiPlanchadoTotal,
			VdiPintadoTotal,
			VdiCentradoTotal,
			VdiTareaTotal,
			
			VdiDescuento,
			VdiSubTotal,
			VdiImpuesto,
			VdiTotal,
			VdiOrigen,
			
			VdiIncluyeImpuesto,
			VdiNotificar,
			
			VdiArchivo,
			VdiArchivoEntrega,
			VdiArchivoEntrega2,
			
			VdiTipoPedido,	
			VdiCodigoExterno,	
			VdiObservado,
					
			VdiTipo,
			VdiTipoFinal,
			
			VdiEstado,			
			VdiTiempoCreacion,
			VdiTiempoModificacion) 
			VALUES (
			"'.($this->VdiId).'",
			"'.($this->SucId).'",
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			'.(empty($this->CprId)?'NULL, ':'"'.$this->CprId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			
			'.(empty($this->NpaId)?'NULL, ':'"'.$this->NpaId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->FinId)?'NULL, ':'"'.$this->FinId.'",').'
			
			"'.($this->VdiOrdenCompraNumero).'",
			'.(empty($this->VdiOrdenCompraFecha)?'NULL, ':'"'.$this->VdiOrdenCompraFecha.'",').'
					
			"'.($this->VdiMarca).'",		
			"'.($this->VdiModelo).'",		
			"'.($this->VdiPlaca).'",		
			"'.($this->VdiAnoModelo).'",		
			"'.($this->VdiAnoFabricacion).'",		
			
			"'.($this->VdiDireccion).'",
			"'.($this->VdiFecha).'",
			"'.($this->MonId).'",
			'.(empty($this->VdiTipoCambio)?'NULL, ':'"'.$this->VdiTipoCambio.'",').'
			"'.($this->VdiObservacion).'",
			"'.($this->VdiObservacionImpresa).'",
			"",
			
			
			'.($this->VdiPorcentajeImpuestoVenta).',
			'.($this->VdiPorcentajeMargenUtilidad).',
			'.($this->VdiPorcentajeOtroCosto).',
				'.($this->VdiPorcentajeManoObra).',

			'.($this->VdiManoObra).',
			'.($this->VdiPorcentajeDescuento).',
			
			'.($this->VdiPlanchadoTotal).',
			'.($this->VdiPintadoTotal).',
			'.($this->VdiCentradoTotal).',
			'.($this->VdiTareaTotal).',
			
			'.($this->VdiDescuento).',
			'.($this->VdiSubTotal).',
			'.($this->VdiImpuesto).',
			'.($this->VdiTotal).',
			"'.($this->VdiOrigen).'",
			'.($this->VdiIncluyeImpuesto).',
			
			'.($this->VdiNotificar).',
			
			
			"'.($this->VdiArchivo).'",
			"'.($this->VdiArchivoEntrega).'",
			"'.($this->VdiArchivoEntrega2).'",
			
			
			
			"'.($this->VdiTipoPedido).'",
			"'.($this->VdiCodigoExterno).'",
			'.($this->VdiObservado).',
			
			"'.($this->VdiTipo).'",
			"'.($this->VdiTipoFinal).'",
			
			
			'.($this->VdiEstado).',
			"'.($this->VdiTiempoCreacion).'", 				
			"'.($this->VdiTiempoModificacion).'");';			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if(!$error and !empty($this->EinId) and !empty($this->CliId)){
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
					$error = true;
				}
			}		



		if(!$error){

			if(!empty($this->CprId)){

				if(!empty($this->FinId)){
	
					$InsCotizacionProducto = new ClsCotizacionProducto();
					$InsCotizacionProducto->MtdEditarCotizacionProductoDato("FinId",$this->FinId,$this->CprId);
	
				}

			}
			
		}
		
		
					
			if(!$error){			

				if (!empty($this->VentaDirectaDetalle)){		
						
					$validar = 0;				
					$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();		
					
					foreach ($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
					
						$InsVentaDirectaDetalle->VdiId = $this->VdiId;
						$InsVentaDirectaDetalle->ProId = $DatVentaDirectaDetalle->ProId;
						$InsVentaDirectaDetalle->UmeId = $DatVentaDirectaDetalle->UmeId;
						$InsVentaDirectaDetalle->CrdId = $DatVentaDirectaDetalle->CrdId;

						$InsVentaDirectaDetalle->VddCantidad = $DatVentaDirectaDetalle->VddCantidad;

						$InsVentaDirectaDetalle->VddCosto = $DatVentaDirectaDetalle->VddCosto;
						$InsVentaDirectaDetalle->VddUtilidad = $DatVentaDirectaDetalle->VddUtilidad;						
						$InsVentaDirectaDetalle->VddValorTotal = $DatVentaDirectaDetalle->VddValorTotal;
						
						$InsVentaDirectaDetalle->VddPrecioBruto = $DatVentaDirectaDetalle->VddPrecioBruto;
						$InsVentaDirectaDetalle->VddDescuento = $DatVentaDirectaDetalle->VddDescuento;
						$InsVentaDirectaDetalle->VddPrecioVenta = $DatVentaDirectaDetalle->VddPrecioVenta;

						$InsVentaDirectaDetalle->VddCantidadPedir = $DatVentaDirectaDetalle->VddCantidadPedir;
						$InsVentaDirectaDetalle->VddCantidadPedirFecha = $DatVentaDirectaDetalle->VddCantidadPedirFecha;
						
						$InsVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddImporte;
						$InsVentaDirectaDetalle->VddCodigoExterno = $DatVentaDirectaDetalle->VddCodigoExterno;
						
						$InsVentaDirectaDetalle->VddPorcentajeUtilidad = $DatVentaDirectaDetalle->VddPorcentajeUtilidad;
						$InsVentaDirectaDetalle->VddPorcentajeOtroCosto = $DatVentaDirectaDetalle->VddPorcentajeOtroCosto;
						$InsVentaDirectaDetalle->VddPorcentajeManoObra = $DatVentaDirectaDetalle->VddPorcentajeManoObra;
						$InsVentaDirectaDetalle->VddPorcentajePedido = $DatVentaDirectaDetalle->VddPorcentajePedido;
						
						$InsVentaDirectaDetalle->VddPorcentajeAdicional = $DatVentaDirectaDetalle->VddPorcentajeAdicional;
						$InsVentaDirectaDetalle->VddPorcentajeDescuento = $DatVentaDirectaDetalle->VddPorcentajeDescuento;
						$InsVentaDirectaDetalle->VddAdicional = $DatVentaDirectaDetalle->VddAdicional;
						
						
						$InsVentaDirectaDetalle->VddEntregado = $DatVentaDirectaDetalle->VddEntregado;
						$InsVentaDirectaDetalle->VddTipoPedido = $DatVentaDirectaDetalle->VddTipoPedido;
						$InsVentaDirectaDetalle->VddEstado = $DatVentaDirectaDetalle->VddEstado;						
						$InsVentaDirectaDetalle->VddTiempoCreacion = $DatVentaDirectaDetalle->VddTiempoCreacion;
						$InsVentaDirectaDetalle->VddTiempoModificacion = $DatVentaDirectaDetalle->VddTiempoModificacion;						
						$InsVentaDirectaDetalle->VddEliminado = $DatVentaDirectaDetalle->VddEliminado;
						
						if($InsVentaDirectaDetalle->MtdRegistrarVentaDirectaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VentaDirectaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
			
			if(!$error){			
			
				if (!empty($this->VentaDirectaPlanchado)){		
						
					$validar = 0;				
					

					$InsVentaDirectaPlanchado = new ClsVentaDirectaTarea();		
											
					foreach ($this->VentaDirectaPlanchado as $DatVentaDirectaPlanchado){

						$InsVentaDirectaPlanchado->VdiId = $this->VdiId;
						$InsVentaDirectaPlanchado->VdtDescripcion = $DatVentaDirectaPlanchado->VdtDescripcion;
						$InsVentaDirectaPlanchado->VdtPrecio = 0;
						$InsVentaDirectaPlanchado->VdtCantidad = 1;
						$InsVentaDirectaPlanchado->VdtImporte = $DatVentaDirectaPlanchado->VdtImporte;
						$InsVentaDirectaPlanchado->VdtTipo = "L";
						$InsVentaDirectaPlanchado->VdtEstado = $DatVentaDirectaPlanchado->VdtEstado;							
						$InsVentaDirectaPlanchado->VdtTiempoCreacion = $DatVentaDirectaPlanchado->VdtTiempoCreacion;
						$InsVentaDirectaPlanchado->VdtTiempoModificacion = $DatVentaDirectaPlanchado->VdtTiempoModificacion;						
						$InsVentaDirectaPlanchado->VdtEliminado = $DatVentaDirectaPlanchado->VdtEliminado;
						
						if($InsVentaDirectaPlanchado->MtdRegistrarVentaDirectaTarea()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VentaDirectaPlanchado) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
				if (!empty($this->VentaDirectaPintado)){		
						
					$validar = 0;				
						

						$InsVentaDirectaPintado = new ClsVentaDirectaTarea();	
											
					foreach ($this->VentaDirectaPintado as $DatVentaDirectaPintado){
					
						$DatVentaDirectaPintado->VdiId = $this->VdiId;
						$DatVentaDirectaPintado->VdtDescripcion = $DatVentaDirectaPintado->VdtDescripcion;
						$DatVentaDirectaPintado->VdtPrecio = 0;
						$DatVentaDirectaPintado->VdtCantidad = 1;
						$DatVentaDirectaPintado->VdtImporte = $DatVentaDirectaPintado->VdtImporte;
						$DatVentaDirectaPintado->VdtTipo = "N";
						$DatVentaDirectaPintado->VdtEstado = $DatVentaDirectaPintado->VdtEstado;							
						$DatVentaDirectaPintado->VdtTiempoCreacion = $DatVentaDirectaPintado->VdtTiempoCreacion;
						$DatVentaDirectaPintado->VdtTiempoModificacion = $DatVentaDirectaPintado->VdtTiempoModificacion;						
						$DatVentaDirectaPintado->VdtEliminado = $DatVentaDirectaPlanchado->VdtEliminado;

						if($DatVentaDirectaPintado->MtdRegistrarVentaDirectaTarea()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_401';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->VentaDirectaPintado) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			



			if(!$error){			
			
				if (!empty($this->VentaDirectaCentrado)){		
						
					$validar = 0;				
						
					$InsVentaDirectaCentrado = new ClsVentaDirectaTarea();	
											
					foreach ($this->VentaDirectaCentrado as $DatVentaDirectaCentrado){

						$DatVentaDirectaCentrado->VdiId = $this->VdiId;
						$DatVentaDirectaCentrado->VdtDescripcion = $DatVentaDirectaCentrado->VdtDescripcion;
						$DatVentaDirectaCentrado->VdtPrecio = 0;
						$DatVentaDirectaCentrado->VdtCantidad = 1;
						$DatVentaDirectaCentrado->VdtImporte = $DatVentaDirectaCentrado->VdtImporte;
						$DatVentaDirectaCentrado->VdtTipo = "E";
						$DatVentaDirectaCentrado->VdtEstado = $DatVentaDirectaCentrado->VdtEstado;							
						$DatVentaDirectaCentrado->VdtTiempoCreacion = $DatVentaDirectaCentrado->VdtTiempoCreacion;
						$DatVentaDirectaCentrado->VdtTiempoModificacion = $DatVentaDirectaCentrado->VdtTiempoModificacion;						
						$DatVentaDirectaCentrado->VdtEliminado = $DatVentaDirectaPlanchado->VdtEliminado;

						if($DatVentaDirectaCentrado->MtdRegistrarVentaDirectaTarea()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_501';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->VentaDirectaCentrado) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			


			if(!$error){			
			
				if (!empty($this->VentaDirectaTarea)){		
						
					$validar = 0;				
						
					$InsVentaDirectaTarea = new ClsVentaDirectaTarea();	
											
					foreach ($this->VentaDirectaTarea as $DatVentaDirectaTarea){

						$DatVentaDirectaTarea->VdiId = $this->VdiId;
						$DatVentaDirectaTarea->VdtDescripcion = $DatVentaDirectaTarea->VdtDescripcion;
						$DatVentaDirectaTarea->VdtPrecio = 0;
						$DatVentaDirectaTarea->VdtCantidad = 1;
						$DatVentaDirectaTarea->VdtImporte = $DatVentaDirectaTarea->VdtImporte;
						$DatVentaDirectaTarea->VdtTipo = "Z";
						$DatVentaDirectaTarea->VdtEstado = $DatVentaDirectaTarea->VdtEstado;							
						$DatVentaDirectaTarea->VdtTiempoCreacion = $DatVentaDirectaTarea->VdtTiempoCreacion;
						$DatVentaDirectaTarea->VdtTiempoModificacion = $DatVentaDirectaTarea->VdtTiempoModificacion;						
						$DatVentaDirectaTarea->VdtEliminado = $DatVentaDirectaPlanchado->VdtEliminado;

						if($DatVentaDirectaTarea->MtdRegistrarVentaDirectaTarea()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_601';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->VentaDirectaTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
				if(!$error){			
			
				if (!empty($this->VentaDirectaFoto)){		
						
					$validar = 0;			
					
					foreach ($this->VentaDirectaFoto as $DatVentaDirectaFoto){
						
						$InsVentaDirectaFoto = new ClsVentaDirectaFoto();		
						$InsVentaDirectaFoto->VdiId = $this->VdiId;
						$InsVentaDirectaFoto->VdfArchivo = $DatVentaDirectaFoto->VdfArchivo;
						$InsVentaDirectaFoto->VdfTipo = $DatVentaDirectaFoto->VdfTipo;				
						$InsVentaDirectaFoto->VdfCodigoExterno = $DatVentaDirectaFoto->VdfCodigoExterno;					
						$InsVentaDirectaFoto->VdfEstado = $DatVentaDirectaFoto->VdfEstado;								
						$InsVentaDirectaFoto->VdfTiempoCreacion = $DatVentaDirectaFoto->VdfTiempoCreacion;
						$InsVentaDirectaFoto->VdfTiempoModificacion = $DatVentaDirectaFoto->VdfTiempoModificacion;						
						$InsVentaDirectaFoto->VdfEliminado = $DatVentaDirectaFoto->VdfEliminado;
						
						if($InsVentaDirectaFoto->MtdRegistrarVehiculoIngresoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_701';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VentaDirectaFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
		
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarVentaDirecta(1,"Se registro la Orden de Venta",$this);			
				return true;
			}			
					
	}
	
	
	
	
	
	
	
	public function MtdGenerarVentaConcretadas($oElementos,$oEstricto=false){

		$this->InsMysql->MtdTransaccionIniciar();
	
		$elementos = explode("#",$oElementos);

		$i=0;
		$validar = 0;
		foreach($elementos as $elemento){

			if(!empty($elemento)){
			
				$this->VdiId = $elemento;
				$this->MtdObtenerVentaDirecta();

				$InsVentaConcretada = new ClsVentaConcretada();
				
				$InsVentaConcretada->VdiId = $this->VdiId;
				$InsVentaConcretada->CprId = $this->CprId;
				
				$InsVentaConcretada->VcoFecha = date("Y-m-d");
				$InsVentaConcretada->TopId = "TOP-10000";
				
				$InsVentaConcretada->CliId = $this->CliId;
				$InsVentaConcretada->CliNombre = $this->CliNombre;
				$InsVentaConcretada->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsVentaConcretada->TdoId = $this->TdoId;
				$InsVentaConcretada->LtiId = $this->LtiId;
				$InsVentaConcretada->VcoMargenUtilidad = $this->VdiPorcentajeMargenUtilidad;
				$InsVentaConcretada->VcoOrigen = "VDI";
				$InsVentaConcretada->VcoDescuento = $this->VdiDescuento;
				
				$InsVentaConcretada->VcoDireccion = $this->VdiDireccion;
				$InsVentaConcretada->VcoObservacion = $this->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Venta Concretada Generada de Ord. Ven.:".$this->VdiId;

				$InsVentaConcretada->VcoIncluyeImpuesto = $this->VdiIncluyeImpuesto;
				$InsVentaConcretada->VcoPorcentajeImpuestoVenta = $this->VdiPorcentajeImpuestoVenta;
				
				$InsVentaConcretada->MonId = $this->MonId;
				$InsVentaConcretada->VcoTipoCambio = $this->VdiTipoCambio;

				$InsVentaConcretada->CprId = $this->CprId;
				$InsVentaConcretada->VcoEstado = 3;
				$InsVentaConcretada->VcoTiempoCreacion = date("Y-m-d H:i:s");
				$InsVentaConcretada->VcoTiempoModificacion = date("Y-m-d H:i:s");

				$InsProducto = new ClsProducto();
				$InsUnidadMedida = new ClsUnidadMedida();
				
				$VentaDirectaDetalleCantidad = 0;
				$VentaDirectaDetalleProductoId = "";
				
				$PedidoCompraDetalleCantidad = 0;
				$PedidoCompraDetalleProductoId = "";
				
				$AlmacenMovimientoEntradaDetalleCantidad = 0;
				$AlmacenMovimientoEntradaDetalleProductoId = "";
				
				$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
				$InsUnidadMedida = new ClsUnidadMedida();

				$TieneObservacion = false;

				if(!empty($this->VentaDirectaDetalle)){
					foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){

						if($DatVentaDirectaDetalle->VddEstado == 1 and $DatVentaDirectaDetalle->VddCantidadPendiente2>0){
							
							$GuardarDetalle = true;

							if($DatVentaDirectaDetalle->VddReemplazo == "Si"){							
								$VentaDirectaDetalleProductoId = $DatVentaDirectaDetalle->ProIdPedido;													
							}else{							
								$VentaDirectaDetalleProductoId = $DatVentaDirectaDetalle->ProId;								
							}

							$ProductoCosto = 0;
							$VentaConcretadaDetalleCantidad = 0;
							$VentaConcretadaDetalleImporte = 0;
							$VentaConcretadaDetalleCantidadReal = 0;
							//if( ( $PedidoCompraLlegadaDetalleCantidad - $DatVentaDirectaDetalle->AmdCantidad) > 0){
							//if( ( $DatVentaDirectaDetalle->VddCantidadPorLlegarReal - $DatVentaDirectaDetalle->AmdCantidad) > 0){
								if( ($DatVentaDirectaDetalle->AmdCantidadEntrada - $DatVentaDirectaDetalle->AmdCantidad) > 0){

									//$VentaConcretadaDetalleCantidad =  $DatVentaDirectaDetalle->VddCantidadPorLlegarReal - $DatVentaDirectaDetalle->AmdCantidad;
									$VentaConcretadaDetalleCantidad =  $DatVentaDirectaDetalle->AmdCantidadEntrada - $DatVentaDirectaDetalle->AmdCantidad;
									$VentaConcretadaDetalleImporte = $DatVentaDirectaDetalle->VddPrecioVenta * $VentaConcretadaDetalleCantidad;
									
									$InsProducto->ProId = $VentaDirectaDetalleProductoId;						
									$InsProducto->MtdObtenerProducto(false);
			
									if(!empty($DatVentaDirectaDetalle->UmeId)){
				
										$InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
										$InsUnidadMedida->MtdObtenerUnidadMedida();
	
										if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
											$InsUnidadMedidaConversion->UmcEquivalente = 1;
										}else{
											$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
											$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
											  
											foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
												$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
											}
										}
	
										if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
											
											$VentaConcretadaDetalleCantidadReal = round($VentaConcretadaDetalleCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
										
										}else{
											
											$GuardarDetalle = false;
											$VentaConcretadaDetalleCantidadReal = 0;
											
										}
		
									}else{
										
										$GuardarDetalle = false;
										$VentaConcretadaDetalleCantidadReal = 0;
										
									}
									
									$ProductoCosto = $InsProducto->ProCosto;
								
								}else{
									
									$GuardarDetalle = false;	
									
								}
	
							
								if($GuardarDetalle){
		
									$InsVentaConcretadaDetalle1 = new ClsVentaConcretadaDetalle();
		
									$InsVentaConcretadaDetalle1->ProId = $VentaDirectaDetalleProductoId;
									
									$InsVentaConcretadaDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
									$InsVentaConcretadaDetalle1->VddId = $DatVentaDirectaDetalle->VddId;
			
									$InsVentaConcretadaDetalle1->VcdCostoExtraTotal = 0;
		
									$InsVentaConcretadaDetalle1->VcdCosto = $ProductoCosto;
									$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DatVentaDirectaDetalle->VddPrecioVenta;
						
									$InsVentaConcretadaDetalle1->VcdCantidad = $VentaConcretadaDetalleCantidad;
									$InsVentaConcretadaDetalle1->VcdCantidadReal = $VentaConcretadaDetalleCantidadReal;
									$InsVentaConcretadaDetalle1->VcdImporte = $VentaConcretadaDetalleImporte;
		
									$InsVentaConcretadaDetalle1->VcdTiempoCreacion = date("Y-m-d H:i:s");
									$InsVentaConcretadaDetalle1->VcdTiempoModificacion = date("Y-m-d H:i:s");
						
									$InsVentaConcretadaDetalle1->VcdValorTotal = 0;
									$InsVentaConcretadaDetalle1->VcdUtilidad = 0;
									$InsVentaConcretadaDetalle1->VcdEliminado = 1;				
									$InsVentaConcretadaDetalle1->InsMysql = NULL;
		
									$InsVentaConcretada->VentaConcretadaDetalle[] = $InsVentaConcretadaDetalle1;	
									$InsVentaConcretada->VcoTotalBruto += $InsVentaConcretadaDetalle1->VcdImporte;
	
								}
														
						}else{
							
							$TieneObservacion = true;
							
						}

					}
				}


			
				if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
					
					$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
					$InsVentaConcretada->VcoImpuesto = ($InsVentaConcretada->VcoSubTotal  * ($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100) );
					$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoSubTotal + $InsVentaConcretada->VcoImpuesto;
				
					
				}else{
					
					$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
					$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
					$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;
				
				}
	
				//$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
//				$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
//				$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;
				
				if(!empty($InsVentaConcretada->VentaConcretadaDetalle) and $TieneObservacion == false){
					
					if($InsVentaConcretada->MtdRegistrarVentaConcretada(false)){
						$validar++;
					}
					
				}else{
					$validar++;	
				}
				
				
				$i++;
			}

			
	
		}
		
		//deb($validar." - ".$i);
			
		if($validar<>$i){
			$error = true;
		}	
				
		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}		
		
	}
	
	
	
	
	
	public function MtdGenerarVentaConcretada($oVentaDirectaId){

	global $Resultado;
	
		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		if(!empty($oVentaDirectaId)){
			
			$this->VdiId = $oVentaDirectaId;
			$this->MtdObtenerVentaDirecta();
			
			$InsVentaConcretada = new ClsVentaConcretada();
			
			$InsVentaConcretada->VdiId = $this->VdiId;
			$InsVentaConcretada->CprId = $this->CprId;
			
			$InsVentaConcretada->VcoFecha = date("Y-m-d");
			$InsVentaConcretada->TopId = "TOP-10000";
			
			$InsVentaConcretada->CliId = $this->CliId;
			$InsVentaConcretada->CliNombre = $this->CliNombre;
			$InsVentaConcretada->CliNumeroDocumento = $this->CliNumeroDocumento;
			$InsVentaConcretada->TdoId = $this->TdoId;
			$InsVentaConcretada->LtiId = $this->LtiId;
			$InsVentaConcretada->VcoMargenUtilidad = $this->VdiPorcentajeMargenUtilidad;
			$InsVentaConcretada->VcoOrigen = "VDI";
			$InsVentaConcretada->VcoDescuento = $this->VdiDescuento;
			
			$InsVentaConcretada->VcoDireccion = $this->VdiDireccion;
			$InsVentaConcretada->VcoObservacion = $this->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Venta Concretada Generada de Ord. Ven.:".$this->VdiId;
			
			$InsVentaConcretada->VcoIncluyeImpuesto = $this->VdiIncluyeImpuesto;
			$InsVentaConcretada->VcoPorcentajeImpuestoVenta = $this->VdiPorcentajeImpuestoVenta;
			
			$InsVentaConcretada->MonId = $this->MonId;
			$InsVentaConcretada->VcoTipoCambio = $this->VdiTipoCambio;
			
			$InsVentaConcretada->CprId = $this->CprId;
			$InsVentaConcretada->VcoEstado = 3;
			$InsVentaConcretada->VcoTiempoCreacion = date("Y-m-d H:i:s");
			$InsVentaConcretada->VcoTiempoModificacion = date("Y-m-d H:i:s");
			
			$InsProducto = new ClsProducto();
			$InsUnidadMedida = new ClsUnidadMedida();
			
			$VentaDirectaDetalleCantidad = 0;
			$VentaDirectaDetalleProductoId = "";
			
			$PedidoCompraDetalleCantidad = 0;
			$PedidoCompraDetalleProductoId = "";
			
			$AlmacenMovimientoEntradaDetalleCantidad = 0;
			$AlmacenMovimientoEntradaDetalleProductoId = "";
			
			$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
			$InsUnidadMedida = new ClsUnidadMedida();

			$TieneObservacion = false;
			$GuardarDetalle = false;
			
			if(!empty($this->VentaDirectaDetalle)){
				foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
			
					if($DatVentaDirectaDetalle->VddCantidadPendiente2>0){
							
						if( $DatVentaDirectaDetalle->VddEstado == 1){
							
							//$GuardarDetalle = true;
			
							if($DatVentaDirectaDetalle->VddReemplazo == "Si"){							
								$VentaDirectaDetalleProductoId = $DatVentaDirectaDetalle->ProIdPedido;													
							}else{							
								$VentaDirectaDetalleProductoId = $DatVentaDirectaDetalle->ProId;								
							}
			
							$ProductoCosto = 0;
							$VentaConcretadaDetalleCantidad = 0;
							$VentaConcretadaDetalleImporte = 0;
							$VentaConcretadaDetalleCantidadReal = 0;
						//if( ( $PedidoCompraLlegadaDetalleCantidad - $DatVentaDirectaDetalle->AmdCantidad) > 0){
						//if( ( $DatVentaDirectaDetalle->VddCantidadPorLlegarReal - $DatVentaDirectaDetalle->AmdCantidad) > 0){
							if( ($DatVentaDirectaDetalle->AmdCantidadEntrada - $DatVentaDirectaDetalle->AmdCantidad) > 0){

								//$VentaConcretadaDetalleCantidad =  $DatVentaDirectaDetalle->VddCantidadPorLlegarReal - $DatVentaDirectaDetalle->AmdCantidad;
								$VentaConcretadaDetalleCantidad =  $DatVentaDirectaDetalle->AmdCantidadEntrada - $DatVentaDirectaDetalle->AmdCantidad;
								$VentaConcretadaDetalleImporte = $DatVentaDirectaDetalle->VddPrecioVenta * $VentaConcretadaDetalleCantidad;

								$InsProducto->ProId = $VentaDirectaDetalleProductoId;						
								$InsProducto->MtdObtenerProducto(false);
			
								if(!empty($DatVentaDirectaDetalle->UmeId)){
			
									$InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
									$InsUnidadMedida->MtdObtenerUnidadMedida();
			
									if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
										$InsUnidadMedidaConversion->UmcEquivalente = 1;
									}else{
										$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
										$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
										  
										foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
											$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
										}
									}
			
									if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
										
										$VentaConcretadaDetalleCantidadReal = round($VentaConcretadaDetalleCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);

									}else{
										
										$GuardarDetalle = false;
										$VentaConcretadaDetalleCantidadReal = 0;
										
									}
			
								}else{
									$GuardarDetalle = false;
									$VentaConcretadaDetalleCantidadReal = 0;
								}
								
								$ProductoCosto = $InsProducto->ProCosto;
							
							}else{
								
								$GuardarDetalle = false;	
								
							}
			
						
							if($GuardarDetalle){
								
								$InsVentaConcretadaDetalle1 = new ClsVentaConcretadaDetalle();
			
								$InsVentaConcretadaDetalle1->ProId = $VentaDirectaDetalleProductoId;
								
								$InsVentaConcretadaDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
								$InsVentaConcretadaDetalle1->VddId = $DatVentaDirectaDetalle->VddId;
			
								$InsVentaConcretadaDetalle1->VcdCostoExtraTotal = 0;
			
								$InsVentaConcretadaDetalle1->VcdCosto = $ProductoCosto;
								$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DatVentaDirectaDetalle->VddPrecioVenta;
					
								$InsVentaConcretadaDetalle1->VcdCantidad = $VentaConcretadaDetalleCantidad;
								$InsVentaConcretadaDetalle1->VcdCantidadReal = $VentaConcretadaDetalleCantidadReal;
								$InsVentaConcretadaDetalle1->VcdImporte = $VentaConcretadaDetalleImporte;
			
								$InsVentaConcretadaDetalle1->VcdTiempoCreacion = date("Y-m-d H:i:s");
								$InsVentaConcretadaDetalle1->VcdTiempoModificacion = date("Y-m-d H:i:s");
					
								$InsVentaConcretadaDetalle1->VcdValorTotal = 0;
								$InsVentaConcretadaDetalle1->VcdUtilidad = 0;
								$InsVentaConcretadaDetalle1->VcdEliminado = 1;				
								$InsVentaConcretadaDetalle1->InsMysql = NULL;
			
								$InsVentaConcretada->VentaConcretadaDetalle[] = $InsVentaConcretadaDetalle1;	
								$InsVentaConcretada->VcoTotalBruto += $InsVentaConcretadaDetalle1->VcdImporte;
			
							}
						
						}else{
							$TieneObservacion = true;
							break;
						}
						
					}
			
				}
			}

			
			if($InsVentaConcretada->VcoIncluyeImpuesto == 2){

				$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
				$InsVentaConcretada->VcoImpuesto = ($InsVentaConcretada->VcoSubTotal  * ($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100) );
				$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoSubTotal + $InsVentaConcretada->VcoImpuesto;

			}else{
				
				$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
				$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
				$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;
			
			}
			
			//if(!empty($InsVentaConcretada->VentaConcretadaDetalle) and $TieneObservacion == false){
			if(!empty($InsVentaConcretada->VentaConcretadaDetalle) ){
				
				if($TieneObservacion == false){

					if(!$InsVentaConcretada->MtdRegistrarVentaConcretadaAux(false)){
						$Resultado.='#ERR_VDI_1001';
						$error = true;
					}	

				}else{
					$Resultado.='#ERR_VDI_1004';
					$error = true;
				}

			}else{
				
				$Resultado.='#ERR_VDI_1002';
				$error = true;
			
			}	
				
		}else{
			
			$Resultado.='#ERR_VDI_1003';
			$error = true;
			
		}
		
		if($error) {	
		
//			$Resultado.='#ERR_VDI_1001';
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {
			$Resultado.='#SAS_VDI_1001';				
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}		
		
	}
	
	
	public function MtdEditarVentaDirecta() {

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

			if(empty($this->CliId)){
/*
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->VdiDireccion;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
				if(!empty($InsCliente->CliNombre)){

					if(!$InsCliente->MtdRegistrarClienteDeVentaDirecta()){
						$error = true;
						$Resultado.='#ERR_VDI_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
				}
*/
			}else{
				if(!empty($this->VdiDireccion)){
					
					//$InsCliente = new ClsCliente($this->InsMysql);
//					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->VdiDireccion,$this->CliId);
//	
				}
			}
			
			
			
			if(empty($this->EinId)){
				
				if(!empty($this->EinVIN)){
			
					$InsVehiculoIngreso = new ClsVehiculoIngreso();

					$InsVehiculoIngreso->EinId = $this->EinId;
					$InsVehiculoIngreso->EinVIN = $this->EinVIN;
					$InsVehiculoIngreso->EinPlaca = $this->VdiPlaca;
					$InsVehiculoIngreso->EinAnoModelo = $this->VdiAnoModelo;
					$InsVehiculoIngreso->EinAnoFabricacion = $this->VdiAnoFabricacion;
					$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
					$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");		

					if(!$InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeCotizacionProducto()){
						$error = true;
						$Resultado.='#ERR_VDI_502';
					}else{
						$this->EinId = $InsVehiculoIngreso->EinId;
					}					

				}

			}else{
				
				if(!empty($this->VdiAnoModelo)){

					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo",$this->VdiAnoModelo,$this->EinId);

				}
				
				
				if(!empty($this->VdiPlaca)){

					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca",$this->VdiPlaca,$this->EinId);

				}

			}
			
			
			
			
		$sql = 'UPDATE tblvdiventadirecta SET
		'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
		'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
		'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
		'.(empty($this->NpaId)?'NpaId = NULL, ':'NpaId = "'.$this->NpaId.'",').'
		
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		'.(empty($this->FinId)?'FinId = NULL, ':'FinId = "'.$this->FinId.'",').'
		
		VdiOrdenCompraNumero = "'.($this->VdiOrdenCompraNumero).'",
		
		'.(empty($this->VdiOrdenCompraFecha)?'VdiOrdenCompraFecha = NULL, ':'VdiOrdenCompraFecha = "'.$this->VdiOrdenCompraFecha.'",').'
		
		VdiMarca = "'.($this->VdiMarca).'",
		VdiModelo = "'.($this->VdiModelo).'",
		VdiPlaca = "'.($this->VdiPlaca).'",
		VdiAnoModelo = "'.($this->VdiAnoModelo).'",
		VdiAnoFabricacion = "'.($this->VdiAnoFabricacion).'",
		
		VdiFecha = "'.($this->VdiFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->VdiTipoCambio)?'VdiTipoCambio = NULL, ':'VdiTipoCambio = "'.$this->VdiTipoCambio.'",').'
		VdiDireccion = "'.($this->VdiDireccion).'",
		VdiObservacion = "'.($this->VdiObservacion).'",
		VdiObservacionImpresa = "'.($this->VdiObservacionImpresa).'",

		VdiPorcentajeImpuestoVenta = '.($this->VdiPorcentajeImpuestoVenta).',
		VdiPorcentajeMargenUtilidad = '.($this->VdiPorcentajeMargenUtilidad).',
		VdiPorcentajeOtroCosto = '.($this->VdiPorcentajeOtroCosto).',
		VdiPorcentajeManoObra = '.($this->VdiPorcentajeManoObra).',
		
		VdiManoObra = '.($this->VdiManoObra).',
		VdiPorcentajeDescuento = '.($this->VdiPorcentajeDescuento).',
		
		VdiPlanchadoTotal = '.($this->VdiPlanchadoTotal).',
		VdiPintadoTotal = '.($this->VdiPintadoTotal).',
		VdiCentradoTotal = '.($this->VdiCentradoTotal).',
		VdiTareaTotal = '.($this->VdiTareaTotal).',
		
		VdiDescuento = '.($this->VdiDescuento).',
		VdiSubTotal = '.($this->VdiSubTotal).',
		VdiImpuesto = '.($this->VdiImpuesto).',
		VdiTotal = '.($this->VdiTotal).',
		
		VdiIncluyeImpuesto = '.($this->VdiIncluyeImpuesto).',
		
		VdiNotificar = '.($this->VdiNotificar).',
		
		VdiArchivo = "'.($this->VdiArchivo).'",
		VdiArchivoEntrega = "'.($this->VdiArchivoEntrega).'",
		VdiArchivoEntrega2 = "'.($this->VdiArchivoEntrega2).'",
		
		VdiTipo = "'.($this->VdiTipo).'",
		VdiTipoFinal = "'.($this->VdiTipoFinal).'",
		VdiEstado = '.($this->VdiEstado).'
		WHERE VdiId = "'.($this->VdiId).'";';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 	
		
		if(!$error and !empty($this->EinId) and !empty($this->CliId)){
			$InsVehiculoIngreso = new ClsVehiculoIngreso();
			if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
				$error = true;
			}
		}		
		


		if(!$error){

			if(!empty($this->CprId)){

				if(!empty($this->FinId)){
	
					$InsCotizacionProducto = new ClsCotizacionProducto();
					$InsCotizacionProducto->MtdEditarCotizacionProductoDato("FinId",$this->FinId,$this->CprId);
	
				}

			}
			
		}
		
		

		if(!$error){
			
				if (!empty($this->VentaDirectaDetalle)){		

					$validar = 0;				
					$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
							
					foreach ($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
										
						$InsVentaDirectaDetalle->VddId = $DatVentaDirectaDetalle->VddId;
						$InsVentaDirectaDetalle->VdiId = $this->VdiId;
						$InsVentaDirectaDetalle->ProId = $DatVentaDirectaDetalle->ProId;
						$InsVentaDirectaDetalle->UmeId = $DatVentaDirectaDetalle->UmeId;
						$InsVentaDirectaDetalle->CrdId = $DatVentaDirectaDetalle->CrdId;

						$InsVentaDirectaDetalle->VddCantidad = $DatVentaDirectaDetalle->VddCantidad;

						$InsVentaDirectaDetalle->VddCosto = $DatVentaDirectaDetalle->VddCosto;
						$InsVentaDirectaDetalle->VddUtilidad = $DatVentaDirectaDetalle->VddUtilidad;
						$InsVentaDirectaDetalle->VddValorTotal = $DatVentaDirectaDetalle->VddValorTotal;
						
						$InsVentaDirectaDetalle->VddPrecioBruto = $DatVentaDirectaDetalle->VddPrecioBruto;
						$InsVentaDirectaDetalle->VddDescuento = $DatVentaDirectaDetalle->VddDescuento;
						$InsVentaDirectaDetalle->VddPrecioVenta = $DatVentaDirectaDetalle->VddPrecioVenta;
						
						$InsVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddImporte;
						$InsVentaDirectaDetalle->VddCodigoExterno = $DatVentaDirectaDetalle->VddCodigoExterno;
						
						$InsVentaDirectaDetalle->VddCantidadPedir = $DatVentaDirectaDetalle->VddCantidadPedir;
						$InsVentaDirectaDetalle->VddCantidadPedirFecha = $DatVentaDirectaDetalle->VddCantidadPedirFecha;
						
						$InsVentaDirectaDetalle->VddPorcentajeUtilidad = $DatVentaDirectaDetalle->VddPorcentajeUtilidad;
						$InsVentaDirectaDetalle->VddPorcentajeOtroCosto = $DatVentaDirectaDetalle->VddPorcentajeOtroCosto;
						$InsVentaDirectaDetalle->VddPorcentajeManoObra = $DatVentaDirectaDetalle->VddPorcentajeManoObra;
						$InsVentaDirectaDetalle->VddPorcentajePedido = $DatVentaDirectaDetalle->VddPorcentajePedido;
						
						$InsVentaDirectaDetalle->VddPorcentajeAdicional = $DatVentaDirectaDetalle->VddPorcentajeAdicional;
						$InsVentaDirectaDetalle->VddPorcentajeDescuento = $DatVentaDirectaDetalle->VddPorcentajeDescuento;
						$InsVentaDirectaDetalle->VddAdicional = $DatVentaDirectaDetalle->VddAdicional;
						

						$InsVentaDirectaDetalle->VddEntregado = $DatVentaDirectaDetalle->VddEntregado;
						$InsVentaDirectaDetalle->VddTipoPedido = $DatVentaDirectaDetalle->VddTipoPedido;
						$InsVentaDirectaDetalle->VddEstado = $DatVentaDirectaDetalle->VddEstado;
						$InsVentaDirectaDetalle->VddTiempoCreacion = $DatVentaDirectaDetalle->VddTiempoCreacion;
						$InsVentaDirectaDetalle->VddTiempoModificacion = $DatVentaDirectaDetalle->VddTiempoModificacion;
						$InsVentaDirectaDetalle->VddEliminado = $DatVentaDirectaDetalle->VddEliminado;
						
						if(empty($InsVentaDirectaDetalle->VddId)){
							if($InsVentaDirectaDetalle->VddEliminado<>2){
								if($InsVentaDirectaDetalle->MtdRegistrarVentaDirectaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaDetalle->VddEliminado==2){
								if($InsVentaDirectaDetalle->MtdEliminarVentaDirectaDetalle($InsVentaDirectaDetalle->VddId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaDetalle->MtdEditarVentaDirectaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			
			
	
			if(!$error){

				if (!empty($this->VentaDirectaPlanchado)){		
						
					$validar = 0;
					$InsVentaDirectaPlanchado = new ClsVentaDirectaTarea();

					foreach ($this->VentaDirectaPlanchado as $DatVentaDirectaPlanchado){

						
						$InsVentaDirectaPlanchado->VdtId = $DatVentaDirectaPlanchado->VdtId;
						$InsVentaDirectaPlanchado->VdiId = $this->VdiId;
						$InsVentaDirectaPlanchado->VdtDescripcion = $DatVentaDirectaPlanchado->VdtDescripcion;						
						$InsVentaDirectaPlanchado->VdtPrecio = 0;
						$InsVentaDirectaPlanchado->VdtCantidad = 1;
						$InsVentaDirectaPlanchado->VdtImporte = $DatVentaDirectaPlanchado->VdtImporte;
						$InsVentaDirectaPlanchado->VdtTipo = "L";
						$InsVentaDirectaPlanchado->VdtEstado = $DatVentaDirectaPlanchado->VdtEstado;
						$InsVentaDirectaPlanchado->VdtTiempoCreacion = $DatVentaDirectaPlanchado->VdtTiempoCreacion;
						$InsVentaDirectaPlanchado->VdtTiempoModificacion = $DatVentaDirectaPlanchado->VdtTiempoModificacion;
						$InsVentaDirectaPlanchado->VdtEliminado = $DatVentaDirectaPlanchado->VdtEliminado;
						
						if(empty($InsVentaDirectaPlanchado->VdtId)){
							if($InsVentaDirectaPlanchado->VdtEliminado<>2){
								if($InsVentaDirectaPlanchado->MtdRegistrarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaPlanchado->VdtEliminado==2){
								if($InsVentaDirectaPlanchado->MtdEliminarVentaDirectaTarea($InsVentaDirectaPlanchado->VdtId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaPlanchado->MtdEditarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaPlanchado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
				
		if(!$error){

				if (!empty($this->VentaDirectaPintado)){		
						
					$validar = 0;				
					$InsVentaDirectaPintado = new ClsVentaDirectaTarea();

					foreach ($this->VentaDirectaPintado as $DatVentaDirectaPintado){

						$InsVentaDirectaPintado->VdtId = $DatVentaDirectaPintado->VdtId;
						$InsVentaDirectaPintado->VdiId = $this->VdiId;
						$InsVentaDirectaPintado->VdtDescripcion = $DatVentaDirectaPintado->VdtDescripcion;						
						$InsVentaDirectaPintado->VdtPrecio = 0;
						$InsVentaDirectaPintado->VdtCantidad = 1;
						$InsVentaDirectaPintado->VdtImporte = $DatVentaDirectaPintado->VdtImporte;
						$InsVentaDirectaPintado->VdtTipo = "N";
						$InsVentaDirectaPintado->VdtEstado = $DatVentaDirectaPintado->VdtEstado;
						$InsVentaDirectaPintado->VdtTiempoCreacion = $DatVentaDirectaPintado->VdtTiempoCreacion;
						$InsVentaDirectaPintado->VdtTiempoModificacion = $DatVentaDirectaPintado->VdtTiempoModificacion;
						$InsVentaDirectaPintado->VdtEliminado = $DatVentaDirectaPintado->VdtEliminado;
						
						if(empty($InsVentaDirectaPintado->VdtId)){
							if($InsVentaDirectaPintado->VdtEliminado<>2){
								if($InsVentaDirectaPintado->MtdRegistrarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_401';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaPintado->VdtEliminado==2){
								if($InsVentaDirectaPintado->MtdEliminarVentaDirectaTarea($InsVentaDirectaPintado->VdtId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_403';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaPintado->MtdEditarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_402';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaPintado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){

				if (!empty($this->VentaDirectaCentrado)){		
						
					$validar = 0;				
					$InsVentaDirectaCentrado = new ClsVentaDirectaTarea();

					foreach ($this->VentaDirectaCentrado as $DatVentaDirectaCentrado){

						$InsVentaDirectaCentrado->VdtId = $DatVentaDirectaCentrado->VdtId;
						$InsVentaDirectaCentrado->VdiId = $this->VdiId;
						$InsVentaDirectaCentrado->VdtDescripcion = $DatVentaDirectaCentrado->VdtDescripcion;						
						$InsVentaDirectaCentrado->VdtPrecio = 0;
						$InsVentaDirectaCentrado->VdtCantidad = 1;
						$InsVentaDirectaCentrado->VdtImporte = $DatVentaDirectaCentrado->VdtImporte;
						$InsVentaDirectaCentrado->VdtTipo = "E";
						$InsVentaDirectaCentrado->VdtEstado = $DatVentaDirectaCentrado->VdtEstado;
						$InsVentaDirectaCentrado->VdtTiempoCreacion = $DatVentaDirectaCentrado->VdtTiempoCreacion;
						$InsVentaDirectaCentrado->VdtTiempoModificacion = $DatVentaDirectaCentrado->VdtTiempoModificacion;
						$InsVentaDirectaCentrado->VdtEliminado = $DatVentaDirectaCentrado->VdtEliminado;
						
						if(empty($InsVentaDirectaCentrado->VdtId)){
							if($InsVentaDirectaCentrado->VdtEliminado<>2){
								if($InsVentaDirectaCentrado->MtdRegistrarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_501';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaCentrado->VdtEliminado==2){
								if($InsVentaDirectaCentrado->MtdEliminarVentaDirectaTarea($InsVentaDirectaCentrado->VdtId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_503';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaCentrado->MtdEditarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_502';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaCentrado) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){

				if (!empty($this->VentaDirectaTarea)){		
						
					$validar = 0;				
					$InsVentaDirectaTarea = new ClsVentaDirectaTarea();

					foreach ($this->VentaDirectaTarea as $DatVentaDirectaTarea){

						$InsVentaDirectaTarea->VdtId = $DatVentaDirectaTarea->VdtId;
						$InsVentaDirectaTarea->VdiId = $this->VdiId;
						$InsVentaDirectaTarea->VdtDescripcion = $DatVentaDirectaTarea->VdtDescripcion;						
						$InsVentaDirectaTarea->VdtPrecio = 0;
						$InsVentaDirectaTarea->VdtCantidad = 1;
						$InsVentaDirectaTarea->VdtImporte = $DatVentaDirectaTarea->VdtImporte;
						$InsVentaDirectaTarea->VdtTipo = "Z";
						$InsVentaDirectaTarea->VdtEstado = $DatVentaDirectaTarea->VdtEstado;
						$InsVentaDirectaTarea->VdtTiempoCreacion = $DatVentaDirectaTarea->VdtTiempoCreacion;
						$InsVentaDirectaTarea->VdtTiempoModificacion = $DatVentaDirectaTarea->VdtTiempoModificacion;
						$InsVentaDirectaTarea->VdtEliminado = $DatVentaDirectaTarea->VdtEliminado;
						
						if(empty($InsVentaDirectaTarea->VdtId)){
							if($InsVentaDirectaTarea->VdtEliminado<>2){
								if($InsVentaDirectaTarea->MtdRegistrarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_601';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaTarea->VdtEliminado==2){
								if($InsVentaDirectaTarea->MtdEliminarVentaDirectaTarea($InsVentaDirectaTarea->VdtId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_603';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaTarea->MtdEditarVentaDirectaTarea()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_602';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			if(!$error){

				if (!empty($this->VentaDirectaFoto)){		

					$validar = 0;	
					foreach ($this->VentaDirectaFoto as $DatVentaDirectaFoto){

						$InsVentaDirectaFoto = new ClsVentaDirectaFoto();
						$InsVentaDirectaFoto->VdfId = $DatVentaDirectaFoto->VdfId;
						$InsVentaDirectaFoto->VdiId = $this->VdiId;
						$InsVentaDirectaFoto->VdfArchivo = $DatVentaDirectaFoto->VdfArchivo;
						$InsVentaDirectaFoto->VdfTipo = $DatVentaDirectaFoto->VdfTipo;
						$InsVentaDirectaFoto->VdfCodigoExterno = $DatVentaDirectaFoto->VdfCodigoExterno;
						$InsVentaDirectaFoto->VdfEstado = $DatVentaDirectaFoto->VdfEstado;
						$InsVentaDirectaFoto->VdfTiempoCreacion = $DatVentaDirectaFoto->VdfTiempoCreacion;
						$InsVentaDirectaFoto->VdfTiempoModificacion = $DatVentaDirectaFoto->VdfTiempoModificacion;
						$InsVentaDirectaFoto->VdfEliminado = $DatVentaDirectaFoto->VdfEliminado;
						
						if(empty($InsVentaDirectaFoto->VdfId)){
							if($InsVentaDirectaFoto->VdfEliminado<>2){
								if($InsVentaDirectaFoto->MtdRegistrarVentaDirectaFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_701';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaFoto->VdfEliminado==2){
								if($InsVentaDirectaFoto->MtdEliminarVentaDirectaFoto($InsVentaDirectaFoto->VdfId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_703';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaFoto->MtdEditarVentaDirectaFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_702';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVentaDirecta(2,"Se edito la Orden de Venta",$this);		
				return true;
			}	
				
		}	




/*
*
*/

	public function MtdConfirmarVentaDirecta() {

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblvdiventadirecta SET
		VdiEstado = '.($this->VdiEstado).'
		WHERE VdiId = "'.($this->VdiId).'";';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 	
		
		if(!$error){
			
				if (!empty($this->VentaDirectaDetalle)){		

					$validar = 0;				
					$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
							
					foreach ($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
										
						$InsVentaDirectaDetalle->VddId = $DatVentaDirectaDetalle->VddId;
						$InsVentaDirectaDetalle->VddEstado = $DatVentaDirectaDetalle->VddEstado;
						$InsVentaDirectaDetalle->VddEntregado = $DatVentaDirectaDetalle->VddEntregado;
						$InsVentaDirectaDetalle->VddTiempoModificacion = $DatVentaDirectaDetalle->VddTiempoModificacion;
							
						if($InsVentaDirectaDetalle->MtdConfirmarVentaDirectaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VDI_202';
							$Resultado.='#Item Numero: '.($validar+1);
						}
															
					}
					
					if(count($this->VentaDirectaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			if(!$error){

				if (!empty($this->VentaDirectaFoto)){		

					$validar = 0;	
					foreach ($this->VentaDirectaFoto as $DatVentaDirectaFoto){

						$InsVentaDirectaFoto = new ClsVentaDirectaFoto();
						$InsVentaDirectaFoto->VdfId = $DatVentaDirectaFoto->VdfId;
						$InsVentaDirectaFoto->VdiId = $this->VdiId;
						$InsVentaDirectaFoto->VdfArchivo = $DatVentaDirectaFoto->VdfArchivo;
						$InsVentaDirectaFoto->VdfTipo = $DatVentaDirectaFoto->VdfTipo;
						$InsVentaDirectaFoto->VdfCodigoExterno = $DatVentaDirectaFoto->VdfCodigoExterno;
						$InsVentaDirectaFoto->VdfEstado = $DatVentaDirectaFoto->VdfEstado;
						$InsVentaDirectaFoto->VdfTiempoCreacion = $DatVentaDirectaFoto->VdfTiempoCreacion;
						$InsVentaDirectaFoto->VdfTiempoModificacion = $DatVentaDirectaFoto->VdfTiempoModificacion;
						$InsVentaDirectaFoto->VdfEliminado = $DatVentaDirectaFoto->VdfEliminado;
						
						if(empty($InsVentaDirectaFoto->VdfId)){
							if($InsVentaDirectaFoto->VdfEliminado<>2){
								if($InsVentaDirectaFoto->MtdRegistrarVentaDirectaFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_701';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaDirectaFoto->VdfEliminado==2){
								if($InsVentaDirectaFoto->MtdEliminarVentaDirectaFoto($InsVentaDirectaFoto->VdfId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VDI_703';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVentaDirectaFoto->MtdEditarVentaDirectaFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VDI_702';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VentaDirectaFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVentaDirecta(2,"Se edito la Orden de Venta",$this);		
				return true;
			}	
				
		}	







		private function MtdAuditarVentaDirecta($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->VdiId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
	



		public function MtdEditarVentaDirectaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblvdiventadirecta SET 
			'.$oCampo.' = "'.($oDato).'",
			VdiTiempoModificacion = NOW()
			WHERE VdiId = "'.($oId).'";';

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}
		
		
		public function MtdVerificarExisteVentaDirectaDato($oCampo,$oDato,$oCliente=NULL) {
			
			$Existe = false;
			
			if(!empty($oCliente)){
				$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
			}	
			
			$sql = '
			SELECT 
			COUNT(vdi.VdiId) AS "EXISTE"
			FROM tblvdiventadirecta vdi
			WHERE '.$oCampo.' = "'.$oDato.'"
			'.$cliente;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

			if($fila['EXISTE']>0){
				$Existe = true;
			}

			return $Existe;		
				
		}
		
		public function MtdVentaDirectaActualizarProductoUso($oVentaDirectaId) {
			
			if(!empty($oVentaDirectaId)){
				
				$this->VdiId  = $oVentaDirectaId;
				$this->MtdObtenerVentaDirecta(true);
	
				if(!empty($this->EinId)){
					
					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->EinId = $this->EinId;
					$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
					
					
					if(!empty($this->VentaDirectaDetalle) and !empty($InsVehiculoIngreso->VveId)){
						foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
	
							$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
							$ResProductoVehiculoVersion = $InsProductoVehiculoVersion->MtdObtenerProductoVehiculoVersiones(NULL,NULL,"PvvId","ASC",NULL,$DatVentaDirectaDetalle->ProId,$InsVehiculoIngreso->VveId);
							$ArrProductoVersiones = $ResProductoVehiculoVersion['Datos'];
							
							if(empty($ArrProductoVersiones)){
								
								
								$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
								$InsProductoVehiculoVersion->ProId = $DatVentaDirectaDetalle->ProId;
								$InsProductoVehiculoVersion->VveId = $InsVehiculoIngreso->VveId;
								$InsProductoVehiculoVersion->PvvTiempoCreacion = date("Y-m-d H:i:s");
								$InsProductoVehiculoVersion->PvvTiempoModificacion = date("Y-m-d H:i:s");
								$InsProductoVehiculoVersion->PvvEliminado = 1;
								
								if($InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion()){
							
								}
								
							}

			
							
							
							
						}
				
					}	
						
				}

			}
		
		}
		
		
	public function MtdVentaDirectaGenerarPedidoCompras($oElementos,$oGenerarOrdenCompra=false,$oUsuario=NULL,$oEnviarNotificacion=false,$oDestinatariosNotificar=NULL,$oEnviarAdjunto=false,$oRuta="../../",$oDestinatariosEnvio=NULL,$IgnorarStock=true){

		$this->InsMysql->MtdTransaccionIniciar();
	
		$elementos = explode("#",$oElementos);

		$i=0;
		$validar = 0;
		foreach($elementos as $elemento){

			if(!empty($elemento)){

				$this->VdiId = $elemento;
				$this->MtdObtenerVentaDirecta();

				$InsPedidoCompra = new ClsPedidoCompra();
				$InsPedidoCompra->UsuId = $oUsuario;	
	
				$InsPedidoCompra->PcoId = NULL;
				$InsPedidoCompra->CliId = $this->CliId;
				
				$InsPedidoCompra->PcoFecha = date("Y-m-d");
				list($InsPedidoCompra->PcoAno,$Mes,$Dia) = explode("-",$InsPedidoCompra->PcoFecha);
			
				$InsPedidoCompra->MonId = $this->MonId;
				$InsPedidoCompra->PcoTipoCambio = $this->VdiTipoCambio;
			
				$InsPedidoCompra->PcoObservacion = $this->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Ped. Compra Generada de Ord. Ven.:".$this->VdiId;
				$InsPedidoCompra->PcoOrigen =  "VDI";
				$InsPedidoCompra->PcoAprobado = 2;
				$InsPedidoCompra->PcoEstado = 3;
				$InsPedidoCompra->PcoTiempoCreacion = date("Y-m-d H:i:s");
				$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");
			
				$InsPedidoCompra->PcoPorcentajeImpuestoVenta = $this->VdiPorcentajeImpuestoVenta;
				$InsPedidoCompra->PcoMargenUtilidad = 0;
				$InsPedidoCompra->PcoIncluyeImpuesto = 0;		
				
				$InsPedidoCompra->VdiId = $this->VdiId;
				$InsPedidoCompra->OcoId = NULL;
			
				$InsPedidoCompra->PcoSubTotal = 0;
				$InsPedidoCompra->PcoImpuesto = 0;
				$InsPedidoCompra->PcoTotal = 0;
				
					if(!empty($this->VentaDirectaDetalle)){
						foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
		
							$GuardarDetalle = true;
							$ProductoListaPrecio = 0;
							
							if(!empty($DatVentaDirectaDetalle->ProCodigoOriginal)){
								
								$InsProductoListaPrecio = new ClsProductoListaPrecio();
								$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal,'PlpId','ASC',"1",NULL);
								$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
								
								if(!empty($ArrProductoListaPrecios)){
									foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){

										if($InsPedidoCompra->MonId <> $EmpresaMonedaId){

											if($DatProductoListaPrecio->MonId == $InsPedidoCompra->MonId){
												$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
											}else{
												$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$DatProductoListaPrecio->PlpTipoCambio);
											}

										}else{
											$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
										}
										
									}
								}
		
							}
							
							$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
							$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PdiId","ASC","1",1);
							$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			
							$Disponibilidad = "NO";
							
							if(!empty($ArrProductoDisponibilidades)){
								foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
									$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
								}
							}

							$Reemplazo = "NO";
							$InsProductoReemplazo = new ClsProductoReemplazo();
							 $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PreId","ASC",NULL,1);
							$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
							if(!empty($ArrProductoReemplazos)){
								  $Reemplazo= "SI";
							}

							$DatVentaDirectaDetalle->VddPrecioVenta = $ProductoListaPrecio;
							$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddCantidadPendiente * $DatVentaDirectaDetalle->VddPrecioVenta;
							
							if($DatVentaDirectaDetalle->VddCantidadPendiente<=0){
								$GuardarDetalle = false;
							}
							
							if($IgnorarStock == false){
																
								$InsProducto = new ClsProducto();
								$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
								$InsProducto->MtdObtenerProducto(false);
								/*$InsUnidadMedida = new ClsUnidadMedida();
								$InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
								$InsUnidadMedida->MtdObtenerUnidadMedida();*/
								
								//$VerificarStock = 2;								
								/*if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
									
									$InsUnidadMedidaConversion->UmcEquivalente = 1;

								}else{
									
									$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
									$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
									$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
								
									foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
										$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
									}

								}*/
								//$CantidadReal = round($DatVentaDirectaDetalle->VddCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
								//if($InsProducto->ProStockReal > $CantidadReal){		
								if($InsProducto->ProStockReal > 0){		
									$GuardarDetalle = false;
//								if($InsProducto->ProStockReal > 0){	
									//$CantidadPedir = $CantidadReal - $InsProducto->ProStockReal;
									//$VerificarStock = 1;
								}								
								
							}//else{
								//$CantidadPedir = $CantidadReal - $InsProducto->ProStockReal;
							//}
							
							if($GuardarDetalle){
								
								$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
								$InsPedidoCompraDetalle1->ProId = $DatVentaDirectaDetalle->ProId;
								$InsPedidoCompraDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
								$InsPedidoCompraDetalle1->VddId = $DatVentaDirectaDetalle->VddId;
								
								$InsPedidoCompraDetalle1->PcdCantidad = $DatVentaDirectaDetalle->VddCantidadPendiente;				
								
								$InsPedidoCompraDetalle1->PcdAno =  $this->VdiAnoModelo;
								$InsPedidoCompraDetalle1->PcdModelo =  $this->VdiModelo;
								$InsPedidoCompraDetalle1->PcdCodigo =  $DatVentaDirectaDetalle->ProCodigoOriginal;
								
								if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
								  $InsPedidoCompraDetalle1->PcdPrecio = $DatVentaDirectaDetalle->VddPrecioVenta * $InsPedidoCompra->PcoTipoCambio;
								}else{
								  $InsPedidoCompraDetalle1->PcdPrecio = $DatVentaDirectaDetalle->VddPrecioVenta;
								}
								
								if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
								  $InsPedidoCompraDetalle1->PcdImporte = $DatVentaDirectaDetalle->VddImporte * $InsPedidoCompra->PcoTipoCambio;
								}else{
								  $InsPedidoCompraDetalle1->PcdImporte = $DatVentaDirectaDetalle->VddImporte;
								}
								
								$InsPedidoCompraDetalle1->PcdEstado = 3;
								$InsPedidoCompraDetalle1->PcdTiempoCreacion = date("Y-m-d H:i:s");
								$InsPedidoCompraDetalle1->PcdTiempoModificacion = date("Y-m-d H:i:s");
								
								$InsPedidoCompraDetalle1->PcdEliminado = 1;				
								$InsPedidoCompraDetalle1->InsMysql = NULL;
								
								$InsPedidoCompra->PedidoCompraDetalle[] = $InsPedidoCompraDetalle1;		
								
								if($InsPedidoCompraDetalle1->PcdEliminado==1){					
									$InsPedidoCompra->PcoTotal += $InsPedidoCompraDetalle1->PcdImporte;	
								}
		
							}
		
						}
					}

					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						
						if($InsPedidoCompra->MtdRegistrarPedidoCompra(false)){
							
								if($oGenerarOrdenCompra){
									
									$GuardarOrdenCompra = true;
									
									if(!empty($this->VdiTipoPedido)){

										$InsOrdenCompra = new ClsOrdenCompra();
										$InsOrdenCompra->UsuId = $oUsuario;	
										
										switch($this->VdiTipoPedido){
											
											case "NORMAL":
												$this->VdiTipoPedido = "STK";
											break;
											
											case "URGENTE":
												$this->VdiTipoPedido = "YRUSH";
											break;
											
											case "IMPORTACION":
												$this->VdiTipoPedido = "ZVOR";
											break;
											
											case "ALMACEN":
												$this->VdiTipoPedido = "ALM";
											break;
											
											default:
												$this->VdiTipoPedido = "ALM";
											break;
											
										}

										$InsOrdenCompra->OcoId = NULL;
										$InsOrdenCompra->OcoTipo = $this->VdiTipoPedido;
										$InsOrdenCompra->OcoCodigoDealer = "8001200006";
									
										$InsProveedor = new ClsProveedor();
										$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
										$ArrProveedores = $ResProveedor['Datos'];
											
										if(!empty($ArrProveedores)){
											foreach($ArrProveedores as $DatProveedor){
												$InsOrdenCompra->PrvId = $DatProveedor->PrvId;
											}
										}
	
										$InsTipoCambio = new ClsTipoCambio();
										$InsTipoCambio->MonId = "MON-10001";
										$InsTipoCambio->TcaFecha = date("Y-m-d");
											
										$InsTipoCambio->MtdObtenerTipoCambioActual();
										
										if(empty($InsTipoCambio->TcaId)){
											$InsTipoCambio->MtdObtenerTipoCambioUltimo();
										}
	
										$InsOrdenCompra->OcoTipoCambio = $InsTipoCambio->TcaMontoComercial;
										$InsOrdenCompra->MonId = "MON-10001";
	
										$InsOrdenCompra->OcoFecha = date("Y-m-d");
										//$InsOrdenCompra->OcoFechaEstimadaLlegada = NULL;
										
										
										if(empty($InsOrdenCompra->OcoFechaLlegadaEstimada)){
												
										//		deb($InsOrdenCompra->OcoTipo);
												switch($InsOrdenCompra->OcoTipo){
													
													case "YRUSH":
										
														$FechaEstimadaLlegada = strtotime ( '+2 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
														$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
														$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
										
													break;
													
													case "ZVOR":
													
														$FechaEstimadaLlegada = strtotime ( '+60 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
														$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
														$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
													
													break;
													
													case "STK":
														
														$FechaEstimadaLlegada = strtotime ( '+4 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
														$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
														$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
										
													break;
													
													default:
													
													break;
																	
												}
												
												
												
										}
										
	
	
										list($InsOrdenCompra->OcoAno,$InsOrdenCompra->OcoMes,$Dia) = explode("-",$InsOrdenCompra->OcoFecha);
									
										$InsOrdenCompra->OcoHora = (date("H:i:s"));
										$InsOrdenCompra->OcoObservacion = "Pedido generado automaticamente por sistema el ".date("d/m/Y H:i:s");
									
										$InsOrdenCompra->OcoEstado = 3;
										$InsOrdenCompra->OcoTiempoCreacion = date("Y-m-d H:i:s");
										$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
										$InsOrdenCompra->OcoEliminado = 1;
										
									
										$InsOrdenCompra->OrdenCompraDetalle = array();
										$InsOrdenCompra->OrdenCompraPedido = array();
									
										if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
											if(empty($InsOrdenCompra->OcoTipoCambio)){
												$GuardarOrdenCompra = false;
											}
										}
									
										$InsOrdenCompra->OcoTotal = 0;
									
										if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
											foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
									
												$InsOrdenCompra->OcoTotal += $DatPedidoCompraDetalle->PcdImporte;
									
											}
										}
												
										$InsOrdenCompra->OrdenCompraPedido[] = $InsPedidoCompra;
										
									  if($GuardarOrdenCompra){
										  
										  if($InsOrdenCompra->MtdRegistrarOrdenCompra()){
											  
											  

											  if($oEnviarNotificacion){
								
												  $InsOrdenCompra->MtdNotificarOrdenCompraRegistro($InsOrdenCompra->OcoId,$oDestinatariosNotificar);
												    
											  }
											  
											  if($oEnviarAdjunto){
												  
												  
												  if($InsOrdenCompra->MtdGenerarExcelOrdenCompra($InsOrdenCompra->OcoId,$oRuta)){
													
													$InsOrdenCompra->MtdEnviarCorreoPedidoOrdenCompra($InsOrdenCompra->OcoId,$oDestinatariosEnvio,$oRuta);  
													
													/***/
													if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCompra->OcoId,31)){
													}										
													/***/
													
													
													
												  }
												  
												  
											  }
											  
										  }
											  
									  }
										
								
									}
									
								}
								
							$validar++;
				
						}		
				
					}else{
						$validar++;
					}							


				
				
				
				$i++;
			}

		}
		
		//deb($validar." - ".$i);
			
		if($validar<>$i){
			$error = true;
		}	
				
		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}		
		
	}
	
	
	
	
//	public function MtdVentaDirectaGenerarPedidoComprav2($oElementos,$oGenerarOrdenCompra=false,$oEnviarNotificacion=false,$oDestinatariosNotificar=NULL){
	public function MtdVentaDirectaGenerarPedidoCompra($oVentaDirectaId,$oGenerarOrdenCompra=false,$oIgnorarStock=false,$oDetalleTipo=NULL){
		//


		global $EmpresaMonedaId;
		
		$this->InsMysql->MtdTransaccionIniciar();

		$error = true;
		
		//$elementos = explode("#",$oElementos);
//
//		$i=0;
//		$validar = 0;
//		foreach($elementos as $elemento){
//
//			if(!empty($elemento)){
				
				  $this->VdiId = $oVentaDirectaId;
				  $this->MtdObtenerVentaDirecta();
				  
				  
				  $TipoCambio = NULL;
		
					$InsTipoCambio = new ClsTipoCambio();
					$InsTipoCambio->MonId = "MON-10001";
					$InsTipoCambio->TcaFecha = date("Y-m-d");
					$InsTipoCambio->MtdObtenerTipoCambioActual();

					if(empty($InsTipoCambio->TcaId)){						
						$InsTipoCambio->MtdObtenerTipoCambioUltimo();
					}

					$TipoCambio  = $InsTipoCambio->TcaMontoCompra;
//deb("TC: ".$InsTipoCambio);
//deb("TCS: ".$TipoCambio);
				  $InsPedidoCompra = new ClsPedidoCompra();
				  $InsPedidoCompra->UsuId = NULL;	
				  $InsPedidoCompra->PcoId = NULL;
				  $InsPedidoCompra->CliId = $this->CliId;
				  
				  $InsPedidoCompra->PcoFecha = date("Y-m-d");
				  list($InsPedidoCompra->PcoAno,$Mes,$Dia) = explode("-",$InsPedidoCompra->PcoFecha);
				
				$InsPedidoCompra->MonId = "MON-10001";
				//$InsPedidoCompra->MonId = $this->MonId;
				//$InsPedidoCompra->PcoTipoCambio = $this->VdiTipoCambio;
				$InsPedidoCompra->PcoTipoCambio = $TipoCambio;
				
				$InsPedidoCompra->PcoObservacion = $this->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Ped. Compra Generada de Ord. Ven.:".$this->VdiId;
				$InsPedidoCompra->PcoOrigen =  "VDI";
				$InsPedidoCompra->PcoAprobado = 2;
				$InsPedidoCompra->PcoEstado = 3;
				$InsPedidoCompra->PcoTiempoCreacion = date("Y-m-d H:i:s");
				$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");
				
				  
				  $InsPedidoCompra->PcoPorcentajeImpuestoVenta = $this->VdiPorcentajeImpuestoVenta;
				  $InsPedidoCompra->PcoMargenUtilidad = 0;
				  $InsPedidoCompra->PcoIncluyeImpuesto = 2;		
				  
				  $InsPedidoCompra->PerId = $this->PerId;
				  $InsPedidoCompra->VdiId = $this->VdiId;
				  $InsPedidoCompra->OcoId = NULL;
			  
				  $InsPedidoCompra->PcoSubTotal = 0;
				  $InsPedidoCompra->PcoImpuesto = 0;
				  $InsPedidoCompra->PcoTotal = 0;
				  
					  if(!empty($this->VentaDirectaDetalle)){
						  foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
		  						
						
								
							  $GuardarDetalle = true;
							  $ProductoListaPrecio = 0;
							  
							  if(!empty($DatVentaDirectaDetalle->ProCodigoOriginal)){
		
								  $InsProductoListaPrecio = new ClsProductoListaPrecio();
								  $ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",NULL);
								  $ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
								  
								  if(!empty($ArrProductoListaPrecios)){
									  foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
		
										  if($InsPedidoCompra->MonId <> $EmpresaMonedaId){
											//	deb("A");
											  if($DatProductoListaPrecio->MonId == $InsPedidoCompra->MonId){
											//	  deb("B");
												  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
											  }else{
												//  deb("C");
												  $ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$DatProductoListaPrecio->PlpTipoCambio);
											  }
		
										  }else{
											  //deb("D");
											  $ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
										  }
										  
									  }
								  }
		
							  }
							  
					//("PRECIO: ".$ProductoListaPrecio);
							  $InsProductoDisponibilidad = new ClsProductoDisponibilidad();
							  $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PdiId","ASC","1",1);
							  $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			  
							  $Disponibilidad = "NO";
							  
							  if(!empty($ArrProductoDisponibilidades)){
								  foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
									  $Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
								  }
							  }
		
							  $Reemplazo = "NO";
							  $InsProductoReemplazo = new ClsProductoReemplazo();
							  $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PreId","ASC",NULL,1);
							  $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			  
							  if(!empty($ArrProductoReemplazos)){
									$Reemplazo= "SI";
							  }
								
								$ProductoListaPrecio = $ProductoListaPrecio * $InsPedidoCompra->PcoTipoCambio;
								//$DatVentaDirectaDetalle->VddPrecioVenta = $ProductoListaPrecio;
								//$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddCantidadPendiente * $DatVentaDirectaDetalle->VddPrecioVenta;
								$CostoTotal = $ProductoListaPrecio * $DatVentaDirectaDetalle->VddCantidadPendiente;
							  
							//  deb("PRECIO: ".$CostoTotal);
							  
							  if($DatVentaDirectaDetalle->VddCantidadPendiente<=0){
								  $GuardarDetalle = false;
							  }
								  
							  if($oIgnorarStock == false){
																  
								  $InsProducto = new ClsProducto();
								  $InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
								  $InsProducto->MtdObtenerProducto(false);
								  
								  if($InsProducto->ProStockReal > 0){		
									  $GuardarDetalle = false;
								  }								
								  
							  }
							  
							  	
								if(!empty($oDetalleTipo)){
									
									if($DatVentaDirectaDetalle->VddTipoPedido != $oDetalleTipo){
									
										 $GuardarDetalle = false;
										 
									}
									
								}
							
							  
								  if($GuardarDetalle){
									  
									  $InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
									  $InsPedidoCompraDetalle1->ProId = $DatVentaDirectaDetalle->ProId;
									  $InsPedidoCompraDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
									  $InsPedidoCompraDetalle1->VddId = $DatVentaDirectaDetalle->VddId;
									  
									  $InsPedidoCompraDetalle1->PcdCantidad = $DatVentaDirectaDetalle->VddCantidadPendiente;				
									  
									  $InsPedidoCompraDetalle1->PcdAno =  $this->VdiAnoModelo;
									  $InsPedidoCompraDetalle1->PcdModelo =  $this->VdiModelo;
									  $InsPedidoCompraDetalle1->PcdCodigo =  $DatVentaDirectaDetalle->ProCodigoOriginal;
									  
									  $InsPedidoCompraDetalle1->PcdPrecio = $ProductoListaPrecio;
									  $InsPedidoCompraDetalle1->PcdImporte = $CostoTotal;
									  
									  $InsPedidoCompraDetalle1->PcdEstado = 3;
									  $InsPedidoCompraDetalle1->PcdTiempoCreacion = date("Y-m-d H:i:s");
									  $InsPedidoCompraDetalle1->PcdTiempoModificacion = date("Y-m-d H:i:s");
									  
									  $InsPedidoCompraDetalle1->PcdEliminado = 1;				
									  $InsPedidoCompraDetalle1->InsMysql = NULL;
									  
									  $InsPedidoCompra->PedidoCompraDetalle[] = $InsPedidoCompraDetalle1;		
									  
									  if($InsPedidoCompraDetalle1->PcdEliminado==1){					
										  $InsPedidoCompra->PcoTotalBruto += $InsPedidoCompraDetalle1->PcdImporte;	
									  }
			  
								  }
		  
						  }
					  }


					if($InsPedidoCompra->PcoIncluyeImpuesto==2){
						$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotalBruto,6);
						$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoSubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)),6);
						$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoSubTotal + $InsPedidoCompra->PcoImpuesto,6);
					}else{
						$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoTotalBruto,6);	
						$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotal / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1),6);
						$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoTotal - $InsPedidoCompra->PcoSubTotal),6);
					}
									
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						
						if($InsPedidoCompra->MtdRegistrarPedidoCompra(false)){

							$error = false;
							//$validar++;
				
						}
				
					}	

//				$i++;
//			}
//
//		}
		
		//deb($validar." - ".$i);
			
		//if($validar<>$i){
		//	$error = true;
		//}	
				
		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}		
		
	}
	
	
	
		public function MtdNotificarVentaDirectaRegistro($oVentaDirecta,$oDestinatario,$oConCodigo=false){
		
			$this->VdiId = $oVentaDirecta;
			$this->MtdObtenerVentaDirecta();
			
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Orden de Venta.";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->VdiId."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Cliente:</b> ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha Registro: </b>".$this->VdiFecha."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>O.C. Ref.:</b> ".$this->VdiOrdenCompraNumero."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>O.C. Fecha Ref.:</b> ".$this->VdiOrdenCompraFecha."";	
			$mensaje .= "<br>";	
		
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
						
						//$mensaje .= "<td>";
//						$mensaje .= "Precio";
//						$mensaje .= "</td>";
//						
//						
//						$mensaje .= "<td>";
//						$mensaje .= "Importe";
//						$mensaje .= "</td>";
//						
//						
//						$mensaje .= "<td>";
//						$mensaje .= "Desc.";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td>";
//						$mensaje .= "Imp. Final";
//						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
				
				$TotalRepuesto = 0;	
				$i = 1;	
			if(!empty($this->VentaDirectaDetalle)){
				foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
					
					
						if($DatVentaDirectaDetalle->VddEstado == 1){
				
		
							if($this->MonId<>$EmpresaMonedaId ){
								
								$DatVentaDirectaDetalle->VddPrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto / $this->VdiTipoCambio);
								
								$DatVentaDirectaDetalle->VddPrecioVenta = ($DatVentaDirectaDetalle->VddPrecioVenta / $this->VdiTipoCambio);
								$DatVentaDirectaDetalle->VddImporte = ($DatVentaDirectaDetalle->VddImporte / $this->VdiTipoCambio);
								
							}
							
							
							
							if(!empty($this->VdiPorcentajeDescuento)){
								
								$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
								$DetallePrecio = $DetallePrecioBruto;
								$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->VddCantidad);
									
								$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($this->VdiPorcentajeDescuento/100));
								
								$DetalleDescuento = ($DetalleImporte * ($this->VdiPorcentajeDescuento/100));
								$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
							
							}else{
							
								$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
								$DetallePrecio = $DetallePrecioBruto;
								$DetalleImporte = ($DetallePrecio *  $DatVentaDirectaDetalle->VddCantidad);
								
								$DetallePrecioDescuento =  $DetallePrecio;
								
								$DetalleDescuento = 0;
								$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
							
							}
				
						}
					
							$mensaje .= "<tr>";
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";

								$mensaje .= "<td>";				
								if($oConCodigo){
									$mensaje .= $DatVentaDirectaDetalle->ProCodigoOriginal;									
								}else{
									$mensaje .= "-";
								}
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatVentaDirectaDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatVentaDirectaDetalle->VddCantidad,2);
								$mensaje .= "</td>";
								
//								$mensaje .= "<td>";
//								$mensaje .= number_format($DetallePrecio,2);
//								$mensaje .= "</td>";
//								
//								$mensaje .= "<td>";
//								$mensaje .= number_format($DetalleImporte,2);
//								$mensaje .= "</td>";
//								
//								$mensaje .= "<td>";
//								$mensaje .= number_format($DetalleDescuento,2);
//								$mensaje .= "</td>";
//								
//								$mensaje .= "<td>";
//								$mensaje .= number_format($DetalleImporteFinal,2);
//								$mensaje .= "</td>";
				
							$mensaje .= "</tr>";
							$i++;				
				   
				}
			}
			$mensaje .= "</table>";
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			//echo $mensaje;
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: ORD. VEN. Nro.: ".$this->VdiId.(!empty($this->VdiOrdenCompraNumero)?" - O.C. REF: ".$this->VdiOrdenCompraNumero." ":"")." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
				
				
		}
		
		
		
		public function MtdNotificarVentaDirectaStockAlmacen($oVentaDirecta,$oDestinatario){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VdiId = $oVentaDirecta;
			$this->MtdObtenerVentaDirecta();
			
			$mensaje .= "NOTIFICACION DE VERIFICACION:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Verificacion de Stock en Almacen de Orden de Venta.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->VdiId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->VdiFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "O.C. Ref.: <b>".$this->VdiOrdenCompraNumero."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "O.C. Fecha Ref.: <b>".$this->VdiOrdenCompraFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Tipo Pedido: <b>".$this->VdiTipoPedido."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Marca/Modelo/Año: <b>".$this->VdiMarca." ".$this->VdiModelo." ".$this->VdiAnoModelo."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Stock Almacen";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
			$i = 1;	
			$Enviar = false;
			if(!empty($this->VentaDirectaDetalle)){
				foreach($this->VentaDirectaDetalle as $DatVentaDirectaDetalle){
					
							$mensaje .= "<tr>";
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";

								$mensaje .= "<td>";				
								
								$mensaje .= $DatVentaDirectaDetalle->ProCodigoOriginal;									
								
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatVentaDirectaDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatVentaDirectaDetalle->VddCantidad,2);
								$mensaje .= "</td>";
								
								$InsProducto = new ClsProducto();
								$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
								$InsProducto->MtdObtenerProducto(false);
					
								$mensaje .= "<td>";
								if($InsProducto->ProStockReal>0){
									$Enviar = true;
									$mensaje .= "VERIFICAR STOCK (".number_format($InsProducto->ProStockReal,2).")";
								}else{
									$mensaje .= "-";
								}
								$mensaje .= "</td>";
				
							$mensaje .= "</tr>";
							$i++;				
							
					
				}
			}
			$mensaje .= "</table>";
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			//echo $mensaje;
			if($Enviar){
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"VERIFICAR STOCK: ORD. VEN. Nro.: ".$this->VdiId.(!empty($this->VdiOrdenCompraNumero)?" - O.C. REF: ".$this->VdiOrdenCompraNumero." ":"")." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
			}
		
				
				
		}
		
		
		
		public function MtdNotificarVentaDirectaMensaje($oVentaDirecta,$oDestinatario,$oTitulo,$oMensaje){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VdiId = $oVentaDirecta;
			$this->MtdObtenerVentaDirecta();
			
			$mensaje .= "NOTIFICACION DE ORDEN DE VENTA:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Datos de Orden de Venta.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->VdiId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->VdiFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "O.C.: Referencia: <b>".$this->VdiOrdenCompraNumero."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "O.C. Fecha Referencia: <b>".$this->VdiOrdenCompraFecha."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "<b>".$oMensaje."</b>";	//"Su pedido ha sido procesado correctamente."
			
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION ".$oTitulo.":  ORD. VEN. Nro.: ".$this->VdiId.(!empty($this->VdiOrdenCompraNumero)?" - O.C. REF: ".$this->VdiOrdenCompraNumero." ":"")." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
				
				
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL)
		public function MtdSeguimientoVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oSucursal=NULL) {


//$oOrdenCompraTipo


		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}


	
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
					
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco

					WHERE 
						pco.VdiId = vdi.VdiId AND
						(
						pco.OcoId  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

			
	

					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vdi.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vdi.VdiFecha)<="'.$oFechaFin.'"';		
			}			

		}


		if(!empty($oEstado)){
			$estado = ' AND vdi.VdiEstado = '.$oEstado;
		}
		


		

		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fim.FinId = "'.$oFichaIngreso.'"';
		}
		
	


		if(($oConCotizacionRepuesto==1)){
			$concrepuesto = ' AND  vdi.CprId IS NOT NULL ';
		}elseif($oConCotizacionRepuesto==2){
			$concrepuesto = ' AND  vdi.CprId IS NULL ';
		}
		
		if(!empty($oCotizacionRepuestoEstado)){
			$crestado = ' AND cpr.CprEstado = '.$oCotizacionRepuestoEstado;
		}	
				
		if(!empty($oCotizacionRepuesto)){
			$crepuesto = ' AND vdi.CprId = "'.$oCotizacionRepuesto.'"';
		}		
		
		if(!empty($oMoneda)){
			$moneda = ' AND vdi.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vdi.CliId = "'.$oCliente.'"';
		}
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
			
//				CASE
//				WHEN EXISTS (
//					SELECT 
//					pco.VdiId
//					FROM tblpcopedidocompra pco
//					WHERE pco.VdiId = vdi.VdiId
//					LIMIT 1
//				) THEN "Si"
//				ELSE "No"
//				END AS VdiPedidoCompra,
				
		if(!empty($oPedidoCompra)){
			
			switch($oPedidoCompra){
				
				case "Si":

					$pcompra = ' AND 
						
						EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
			 
				break;
				
				case "No":

					$pcompra = ' AND 
						
						NOT EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vdi.VdiId
							LIMIT 1
						)
					';
					
				break;
				
				default:
				
				break;
			}
			
		}	
		
		
		if(!empty($oVentaConcretada)){
			
			switch($oVentaConcretada){
				
				case "Si":

					$vconcretada = ' AND EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				case "No":

					$vconcretada = ' AND NOT EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vdi.VdiId
							LIMIT 1
						)
					';

				break;
				
				default:
				
				break;
			}
			
		}	
	
		
		if(!empty($oClienteClasificacion)){
			$clasificacion = ' AND cli.CliClasificacion = '.$oClienteClasificacion.' ';
		}
//		if(!empty($oVentaConcretada)){
//			$vconcretada = ' AND vdi.CliId = "'.$oVentaConcretada.'"';
//		}	
		if(!empty($oOrigen)){
			$origen = ' AND vdi.VdiOrigen = "'.$oOrigen.'"';
		}
		
		if(!empty($oObservado)){
			$observado = ' AND vdi.VdiObservado = '.$oObservado.'';
		}
		
		if(($oEstricto)){
			$estricto = ' AND 
			
				(
					EXISTS (
						SELECT 
						pco.VdiId
						FROM tblpcopedidocompra pco
						WHERE pco.VdiId = vdi.VdiId
						LIMIT 1
					)			
	
				OR
					EXISTS (
						SELECT 
						amo.AmoId
						FROM tblamoalmacenmovimiento amo
						WHERE amo.VdiId = vdi.VdiId
						LIMIT 1
					)
				)
			
			';
		}
		


		
		if(!empty($oOrdenCompraReferencia)){
			$ocreferencia = ' AND vdi.VdiOrdenCompraNumero LIKE "%'.$oOrdenCompraReferencia.'%"';
		}
		
		if(!empty($oProductoCodigoOriginal)){
			
			$pcoriginal = '
			
			AND EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProCodigoOriginal  LIKE "%'.$oProductoCodigoOriginal.'%" 
						)
						
					)
					
			';
		}
		
		
		if(!empty($oOrdenCompraTipo)){
			
			
			$octipo = ' AND 
						EXISTS (
							SELECT 
							pco.PcoId
							FROM tblpcopedidocompra pco
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
							WHERE pco.VdiId = vdi.VdiId
							AND oco.OcoTipo LIKE "%'.$oOrdenCompraTipo.'%"
							LIMIT 1
						)
					';
			 
			 
		}
		
		
		if(!empty($oExonerar)){
			$exonerar = ' AND vdi.CliId <> "'.$oExonerar.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND vdi.SucId = "'.$oSucursal.'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vdi.VdiId,	
				vdi.CliId,			
				DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
				
				vdi.MonId,
				vdi.VdiTipoCambio,
				
				  vdi.NpaId,
				  
				vdi.CprId,
				vdi.TopId,
				vdi.EinId,
				
				vdi.VdiOrdenCompraNumero,
				DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
				vdi.VdiMarca,
				vdi.VdiModelo,
				vdi.VdiPlaca,
				vdi.VdiAnoModelo,
				vdi.VdiAnoFabricacion,
				
				vdi.VdiDireccion,
				vdi.VdiObservacion,
				vdi.VdiObservacionImpresa,
				vdi.VdiResultado,
				
				vdi.VdiPorcentajeImpuestoVenta,
				vdi.VdiPorcentajeMargenUtilidad,
				vdi.VdiPorcentajeOtroCosto,
				vdi.VdiPorcentajeManoObra,
				
				vdi.VdiManoObra,
				vdi.VdiPorcentajeDescuento,
				
				vdi.VdiPlanchadoTotal,
				vdi.VdiPintadoTotal,
				vdi.VdiCentradoTotal,
				vdi.VdiTareaTotal,
				
				vdi.VdiDescuento,
				vdi.VdiSubTotal,
				vdi.VdiImpuesto,
				vdi.VdiTotal,
								
				vdi.VdiOrigen,
				vdi.VdiIncluyeImpuesto,
				
				vdi.VdiNotificar,
				vdi.VdiArchivo,
				vdi.VdiArchivoEntrega,
				vdi.VdiArchivoEntrega2,
				
				vdi.VdiTipoPedido,
				vdi.VdiCodigoExterno,
				vdi.VdiObservado,
				
				
				vdi.VdiEstado,
				DATE_FORMAT(vdi.VdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoCreacion",
	        	DATE_FORMAT(vdi.VdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoModificacion",
				(SELECT COUNT(vdd.VdiId) FROM tblvddventadirectadetalle vdd WHERE vdd.VdiId = vdi.VdiId ) AS "VdiTotalItems",


								
				CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
				
						
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.CliDireccion,
		cli.CliDepartamento,
		cli.CliProvincia,
		cli.CliDistrito,
		
				
				cli.TdoId,
				cli.LtiId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
			
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",				

				ein.EinVIN,
				ein.EinPlaca,

				ein.VmaId,
				vma.VmaNombre,

				ein.VmoId,
				vmo.VmoNombre,

				vmo.VtiId,
				vti.VtiNombre,

				ein.VveId,		
				vve.VveNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				npa.NpaNombre

				FROM tblvdiventadirecta vdi
				
					LEFT JOIN tblclicliente cli
					ON vdi.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tblcprcotizacionproducto cpr
								ON vdi.CprId = cpr.CprId
								
							LEFT JOIN tblmonmoneda mon
							ON vdi.MonId = mon.MonId

						LEFT JOIN tbleinvehiculoingreso ein
						ON vdi.EinId = ein.EinId
						
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON ein.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON ein.VmaId = vma.VmaId
					
					LEFT JOIN tblperpersonal per
					ON vdi.PerId = per.PerId
						
						LEFT JOIN tblnpacondicionpago npa
						ON vdi.NpaId = npa.NpaId
					
				WHERE  1 = 1  '.$filtrar.$fecha.$tipo.$stipo.$sucursal.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$crepuesto.$moneda.$cliente.$coreferencia.$pcompra.$vconcretada.$clasificacion.$origen.$observado.$estricto.$pcoriginal.$ocreferencia.$octipo.$exonerar.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirecta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirecta = new $InsVentaDirecta();
                    $VentaDirecta->VdiId = $fila['VdiId'];
					$VentaDirecta->CliId = $fila['CliId'];
					$VentaDirecta->VdiFecha = $fila['NVdiFecha'];
					$VentaDirecta->MonId = $fila['MonId'];
					$VentaDirecta->VdiTipoCambio = $fila['VdiTipoCambio'];
					
					$VentaDirecta->NpaId = $fila['NpaId'];
					
					$VentaDirecta->CprId = $fila['CprId'];
					$VentaDirecta->TopId = $fila['TopId'];
					$VentaDirecta->EinId = $fila['EinId'];
					
					$VentaDirecta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$VentaDirecta->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					$VentaDirecta->VdiMarca = $fila['VdiMarca'];
					$VentaDirecta->VdiModelo = $fila['VdiModelo'];
					$VentaDirecta->VdiPlaca = $fila['VdiPlaca'];
					$VentaDirecta->VdiAnoModelo = $fila['VdiAnoModelo'];
					$VentaDirecta->VdiAnoFabricacion = $fila['VdiAnoFabricacion'];
					
					
					$VentaDirecta->VdiDireccion = $fila['VdiDireccion'];
					$VentaDirecta->VdiObservacion = $fila['VdiObservacion'];
					$VentaDirecta->VdiObservacionImpresa = $fila['VdiObservacionImpresa'];
					$VentaDirecta->VdiResultado = $fila['VdiResultado'];
					
					$VentaDirecta->VdiPorcentajeImpuestoVenta = $fila['VdiPorcentajeImpuestoVenta'];
					$VentaDirecta->VdiPorcentajeMargenUtilidad = $fila['VdiPorcentajeMargenUtilidad'];
					$VentaDirecta->VdiPorcentajeOtroCosto = $fila['VdiPorcentajeOtroCosto'];
					$VentaDirecta->VdiPorcentajeManoObra = $fila['VdiPorcentajeManoObra'];

					$VentaDirecta->VdiManoObra = $fila['VdiManoObra'];
					$VentaDirecta->VdiPorcentajeDescuento = $fila['VdiPorcentajeDescuento'];
					
					$VentaDirecta->VdiPlanchadoTotal = $fila['VdiPlanchadoTotal'];
					$VentaDirecta->VdiPintadoTotal = $fila['VdiPintadoTotal'];
					$VentaDirecta->VdiCentradoTotal = $fila['VdiCentradoTotal'];
					$VentaDirecta->VdiTareaTotal = $fila['VdiTareaTotal'];
					
					$VentaDirecta->VdiDescuento = $fila['VdiDescuento'];
					$VentaDirecta->VdiSubTotal = $fila['VdiSubTotal'];
					$VentaDirecta->VdiImpuesto = $fila['VdiImpuesto'];
					$VentaDirecta->VdiTotal = $fila['VdiTotal'];

					$VentaDirecta->VdiOrigen = $fila['VdiOrigen'];
					
					$VentaDirecta->VdiIncluyeImpuesto = $fila['VdiIncluyeImpuesto'];
					
					
					$VentaDirecta->VdiNotificar = $fila['VdiNotificar'];
					$VentaDirecta->VdiArchivo = $fila['VdiArchivo'];
					
					$VentaDirecta->VdiArchivoEntrega = $fila['VdiArchivoEntrega'];
					$VentaDirecta->VdiArchivoEntrega2 = $fila['VdiArchivoEntrega2'];
		
					$VentaDirecta->VdiTipoPedido = $fila['VdiTipoPedido'];
					$VentaDirecta->VdiCodigoExterno = $fila['VdiCodigoExterno'];
					$VentaDirecta->VdiObservado = $fila['VdiObservado'];
				
					$VentaDirecta->VdiEstado = $fila['VdiEstado'];
					$VentaDirecta->VdiTiempoCreacion = $fila['NVdiTiempoCreacion'];  
					$VentaDirecta->VdiTiempoModificacion = $fila['NVdiTiempoModificacion']; 

					$VentaDirecta->VdiTotalItems = $fila['VdiTotalItems'];
					
					
					$VentaDirecta->VdiGenerarVentaConcretada = $fila['VdiGenerarVentaConcretada'];
					$VentaDirecta->VdiGenerarPedidoCompra = $fila['VdiGenerarPedidoCompra'];
					
					$VentaDirecta->VdiPedidoCompra = $fila['VdiPedidoCompra'];
					$VentaDirecta->VdiVentaConcretada = $fila['VdiVentaConcretada'];

					$VentaDirecta->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VentaDirecta->CliNombre = $fila['CliNombre'];
					$VentaDirecta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VentaDirecta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$VentaDirecta->CliDireccion = $fila['CliDireccion'];
					$VentaDirecta->CliDepartamento = $fila['CliDepartamento'];
					$VentaDirecta->CliProvincia = $fila['CliProvincia'];
					$VentaDirecta->CliDistrito = $fila['CliDistrito'];
		
					$VentaDirecta->TdoId = $fila['TdoId'];
					$VentaDirecta->LtiId = $fila['LtiId'];
					$VentaDirecta->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VentaDirecta->CliTelefono = $fila['CliTelefono'];
					$VentaDirecta->CliEmail = $fila['CliEmail'];
					$VentaDirecta->CliCelular = $fila['CliCelular'];
					$VentaDirecta->CliFax = $fila['CliFax'];
					
					$VentaDirecta->TdoNombre = $fila['TdoNombre'];
					$VentaDirecta->LtiNombre = $fila['LtiNombre'];
					$VentaDirecta->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VentaDirecta->CprFecha = $fila['NCprFecha'];


					$VentaDirecta->EinVIN = $fila['EinVIN'];
					$VentaDirecta->EinPlaca = $fila['EinPlaca'];

					$VentaDirecta->VmaId = $fila['VmaId'];
					$VentaDirecta->VmaNombre = $fila['VmaNombre'];

					$VentaDirecta->VmoId = $fila['VmoId'];
					$VentaDirecta->VmoNombre = $fila['VmoNombre'];

					$VentaDirecta->VtiId = $fila['VtiId'];
					$VentaDirecta->VtiNombre = $fila['VtiNombre'];

					$VentaDirecta->VveId = $fila['VveId'];
					$VentaDirecta->VveNombre = $fila['VveNombre'];
					
					$VentaDirecta->MonNombre = $fila['MonNombre'];
					$VentaDirecta->MonSimbolo = $fila['MonSimbolo'];
					
					$VentaDirecta->VdiRepuesto = $fila['VdiRepuesto'];
					$VentaDirecta->VdiPlanchado = $fila['VdiPlanchado'];
					$VentaDirecta->VdiPintado = $fila['VdiPintado'];
					$VentaDirecta->VdiCentrado = $fila['VdiCentrado'];
					$VentaDirecta->VdiTarea = $fila['VdiTarea'];
					
					$VentaDirecta->PerNombre = $fila['PerNombre'];
					$VentaDirecta->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VentaDirecta->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$VentaDirecta->NpaNombre = $fila['NpaNombre'];

			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoDescripcion = "Pendiente";
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoDescripcion = "Realizado";
						break;	
						
						case 6:
							$VentaDirecta->VdiEstadoDescripcion = "Anulado";
						break;	
		
						default:
							$VentaDirecta->VdiEstadoDescripcion = "";
						break;
						
					}
			
			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />';
						break;
						
						case 6:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/anulado.gif" />';
						break;	
		
						default:
							$VentaDirecta->VdiEstadoIcono = "";
						break;
						
					}

                    $VentaDirecta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirecta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
		
		public function MtdObtenerVentaDirectaExternas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL) {


//$oOrdenCompraTipo


		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}


	
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vdi.VdiId AND
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
					
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pco.PcoId
					FROM tblpcopedidocompra pco

					WHERE 
						pco.VdiId = vdi.VdiId AND
						(
						pco.OcoId  LIKE "%'.$oFiltro.'%" 
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

			
	

					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vde.VdiFecha)>="'.$oFechaInicio.'" AND DATE(vde.VdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vde.VdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vde.VdiFecha)<="'.$oFechaFin.'"';		
			}			

		}


		if(!empty($oEstado)){
			$estado = ' AND vde.VdiEstado = '.$oEstado;
		}
		


		

		if(!empty($oFichaIngreso)){
			$fingreso = ' AND vde.FinId = "'.$oFichaIngreso.'"';
		}
		
	


		if(($oConCotizacionRepuesto==1)){
			$concrepuesto = ' AND  vde.CprId IS NOT NULL ';
		}elseif($oConCotizacionRepuesto==2){
			$concrepuesto = ' AND  vde.CprId IS NULL ';
		}
		
		if(!empty($oCotizacionRepuestoEstado)){
			$crestado = ' AND vde.CprEstado = '.$oCotizacionRepuestoEstado;
		}	
				
		if(!empty($oCotizacionRepuesto)){
			$crepuesto = ' AND vde.CprId = "'.$oCotizacionRepuesto.'"';
		}		
		
		if(!empty($oMoneda)){
			$moneda = ' AND vde.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vde.CliId = "'.$oCliente.'"';
		}
		
		switch($oConOrdenCompraReferencia){
			
			case 1:
				$coreferencia = ' AND (vde.VdiOrdenCompraNumero IS NOT NULL AND vde.VdiOrdenCompraNumero <> "") ';
			break;
			
			case 2:
				$coreferencia = ' AND (vde.VdiOrdenCompraNumero IS NULL OR vde.VdiOrdenCompraNumero = "") ';
			break;
			
			default:
			
			break;
		}
			
//				CASE
//				WHEN EXISTS (
//					SELECT 
//					pco.VdiId
//					FROM tblpcopedidocompra pco
//					WHERE pco.VdiId = vdi.VdiId
//					LIMIT 1
//				) THEN "Si"
//				ELSE "No"
//				END AS VdiPedidoCompra,
				
		if(!empty($oPedidoCompra)){
			
			switch($oPedidoCompra){
				
				case "Si":

					$pcompra = ' AND 
						
						EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vde.VdiId
							LIMIT 1
						)
					';
			 
				break;
				
				case "No":

					$pcompra = ' AND 
						
						NOT EXISTS (
							SELECT 
							pco.VdiId
							FROM tblpcopedidocompra pco
							WHERE pco.VdiId = vde.VdiId
							LIMIT 1
						)
					';
					
				break;
				
				default:
				
				break;
			}
			
		}	
		
		
		if(!empty($oVentaConcretada)){
			
			switch($oVentaConcretada){
				
				case "Si":

					$vconcretada = ' AND EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vde.VdiId
							LIMIT 1
						)
					';

				break;
				
				case "No":

					$vconcretada = ' AND NOT EXISTS (
							SELECT 
							amo.AmoId
							FROM tblamoalmacenmovimiento amo
							WHERE amo.VdiId = vde.VdiId
							LIMIT 1
						)
					';

				break;
				
				default:
				
				break;
			}
			
		}	
	
		
		if(!empty($oClienteClasificacion)){
			$clasificacion = ' AND vde.CliClasificacion = '.$oClienteClasificacion.' ';
		}

		if(!empty($oObservado)){
			$observado = ' AND vde.VdiObservado = '.$oObservado.'';
		}
		
		if(($oEstricto)){
			$estricto = ' AND 
			
				(
					EXISTS (
						SELECT 
						pco.VdiId
						FROM tblpcopedidocompra pco
						WHERE pco.VdiId = vde.VdiId
						LIMIT 1
					)			
	
				OR
					EXISTS (
						SELECT 
						amo.AmoId
						FROM tblamoalmacenmovimiento amo
						WHERE amo.VdiId = vde.VdiId
						LIMIT 1
					)
				)
			
			';
		}
		


		
		if(!empty($oOrdenCompraReferencia)){
			$ocreferencia = ' AND vde.VdiOrdenCompraNumero LIKE "%'.$oOrdenCompraReferencia.'%"';
		}
		
		if(!empty($oProductoCodigoOriginal)){
			
			$pcoriginal = '
			
			AND EXISTS( 
					
					SELECT 
					vdd.VddId
					FROM tblvddventadirectadetalle vdd
						LEFT JOIN tblproproducto pro
						ON vdd.ProId = pro.ProId
						
					WHERE 
						vdd.VdiId = vde.VdiId AND
						(
						pro.ProCodigoOriginal  LIKE "%'.$oProductoCodigoOriginal.'%" 
						)
						
					)
					
			';
		}
		
		
		if(!empty($oOrdenCompraTipo)){
			
			
			$octipo = ' AND 
						EXISTS (
							SELECT 
							pco.PcoId
							FROM tblpcopedidocompra pco
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
							WHERE pco.VdiId = vde.VdiId
							AND oco.OcoTipo LIKE "%'.$oOrdenCompraTipo.'%"
							LIMIT 1
						)
					';
			 
			 
		}
		
		
		if(!empty($oExonerar)){
			$exonerar = ' AND vde.CliId <> "'.$oExonerar.'"';
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vde.VdiId,	
				vde.CliId,			
				DATE_FORMAT(vde.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
				
				vde.MonId,
				vde.VdiTipoCambio,
				
				  vde.NpaId,
				  
				vde.CprId,
				vde.TopId,
				vde.EinId,
				
				vde.VdiOrdenCompraNumero,
				DATE_FORMAT(vde.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
				vde.VdiMarca,
				vde.VdiModelo,
				vde.VdiPlaca,
				vde.VdiAnoModelo,
				vde.VdiAnoFabricacion,
				
				vde.VdiDireccion,
				vde.VdiObservacion,
				vde.VdiObservacionImpresa,
				vde.VdiResultado,
				
				vde.VdiPorcentajeImpuestoVenta,
				vde.VdiPorcentajeMargenUtilidad,
				vde.VdiPorcentajeOtroCosto,
				vde.VdiPorcentajeManoObra,
				
				vde.VdiManoObra,
				vde.VdiPorcentajeDescuento,
				
				vde.VdiPlanchadoTotal,
				vde.VdiPintadoTotal,
				vde.VdiCentradoTotal,
				vde.VdiTareaTotal,
				
				vde.VdiDescuento,
				vde.VdiSubTotal,
				vde.VdiImpuesto,
				vde.VdiTotal,
								
				vde.VdiOrigen,
				vde.VdiIncluyeImpuesto,
				
				vde.VdiNotificar,
				vde.VdiArchivo,
				vdi.VdiArchivoEntrega,
				vdi.VdiArchivoEntrega2,
				
				vde.VdiTipoPedido,
				vde.VdiCodigoExterno,
				vde.VdiObservado,
				
				
				vde.VdiEstado,
				DATE_FORMAT(vde.VdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoCreacion",
	        	DATE_FORMAT(vde.VdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdiTiempoModificacion",
				vde.VdiTotalItems,


								
				vde.CliNombreCompleto,
				
						
		vde.CliNombre,
		vde.CliApellidoPaterno,
		vde.CliApellidoMaterno,
		
		vde.CliDireccion,
		vde.CliDepartamento,
		vde.CliProvincia,
		vde.CliDistrito,
		
				
				vde.TdoId,
				vde.LtiId,
				vde.CliNumeroDocumento,
				vde.CliTelefono,
				vde.CliEmail,
				vde.CliCelular,
				vde.CliFax,
			
				vde.TdoNombre,
				vde.LtiNombre,
				vde.LtiAbreviatura,
				
				vde.CprFecha,			

				vde.EinVIN,
				vde.EinPlaca,

				vde.VmaId,
				vde.VmaNombre,

				vde.VmoId,
				vde.VmoNombre,

				vde.VtiId,
				vde.VtiNombre,

				vde.VveId,		
				vde.VveNombre,
				
				vde.MonNombre,
				vde.MonSimbolo,
				
				vde.PerNombre,
				vde.PerApellidoPaterno,
				vde.PerApellidoMaterno,
				
				vde.NpaNombre,
				
				vde.OcoProcesadoProveedor
			

				FROM visvdeventadirectaexterna vde
				
				WHERE  1 = 1  '.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$crepuesto.$moneda.$cliente.$coreferencia.$pcompra.$vconcretada.$clasificacion.$origen.$observado.$estricto.$pcoriginal.$ocreferencia.$octipo.$exonerar.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirecta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirecta = new $InsVentaDirecta();
                    $VentaDirecta->VdiId = $fila['VdiId'];
					$VentaDirecta->CliId = $fila['CliId'];
					$VentaDirecta->VdiFecha = $fila['NVdiFecha'];
					$VentaDirecta->MonId = $fila['MonId'];
					$VentaDirecta->VdiTipoCambio = $fila['VdiTipoCambio'];
					
					$VentaDirecta->NpaId = $fila['NpaId'];
					
					$VentaDirecta->CprId = $fila['CprId'];
					$VentaDirecta->TopId = $fila['TopId'];
					$VentaDirecta->EinId = $fila['EinId'];
					
					$VentaDirecta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$VentaDirecta->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					$VentaDirecta->VdiMarca = $fila['VdiMarca'];
					$VentaDirecta->VdiModelo = $fila['VdiModelo'];
					$VentaDirecta->VdiPlaca = $fila['VdiPlaca'];
					$VentaDirecta->VdiAnoModelo = $fila['VdiAnoModelo'];
					$VentaDirecta->VdiAnoFabricacion = $fila['VdiAnoFabricacion'];
					
					
					$VentaDirecta->VdiDireccion = $fila['VdiDireccion'];
					$VentaDirecta->VdiObservacion = $fila['VdiObservacion'];
					$VentaDirecta->VdiObservacionImpresa = $fila['VdiObservacionImpresa'];
					$VentaDirecta->VdiResultado = $fila['VdiResultado'];
					
					$VentaDirecta->VdiPorcentajeImpuestoVenta = $fila['VdiPorcentajeImpuestoVenta'];
					$VentaDirecta->VdiPorcentajeMargenUtilidad = $fila['VdiPorcentajeMargenUtilidad'];
					$VentaDirecta->VdiPorcentajeOtroCosto = $fila['VdiPorcentajeOtroCosto'];
					$VentaDirecta->VdiPorcentajeManoObra = $fila['VdiPorcentajeManoObra'];

					$VentaDirecta->VdiManoObra = $fila['VdiManoObra'];
					$VentaDirecta->VdiPorcentajeDescuento = $fila['VdiPorcentajeDescuento'];
									
					$VentaDirecta->VdiPlanchadoTotal = $fila['VdiPlanchadoTotal'];
					$VentaDirecta->VdiPintadoTotal = $fila['VdiPintadoTotal'];
					$VentaDirecta->VdiCentradoTotal = $fila['VdiCentradoTotal'];
					$VentaDirecta->VdiTareaTotal = $fila['VdiTareaTotal'];
					
					$VentaDirecta->VdiDescuento = $fila['VdiDescuento'];
					$VentaDirecta->VdiSubTotal = $fila['VdiSubTotal'];
					$VentaDirecta->VdiImpuesto = $fila['VdiImpuesto'];
					$VentaDirecta->VdiTotal = $fila['VdiTotal'];

					$VentaDirecta->VdiOrigen = $fila['VdiOrigen'];
					
					$VentaDirecta->VdiIncluyeImpuesto = $fila['VdiIncluyeImpuesto'];
					
					
					$VentaDirecta->VdiNotificar = $fila['VdiNotificar'];
					$VentaDirecta->VdiArchivo = $fila['VdiArchivo'];
					$VentaDirecta->VdiArchivoEntrega = $fila['VdiArchivoEntrega'];
					$VentaDirecta->VdiArchivoEntrega2 = $fila['VdiArchivoEntrega2'];
		
					$VentaDirecta->VdiTipoPedido = $fila['VdiTipoPedido'];
					$VentaDirecta->VdiCodigoExterno = $fila['VdiCodigoExterno'];
					$VentaDirecta->VdiObservado = $fila['VdiObservado'];
				
					$VentaDirecta->VdiEstado = $fila['VdiEstado'];
					$VentaDirecta->VdiTiempoCreacion = $fila['NVdiTiempoCreacion'];  
					$VentaDirecta->VdiTiempoModificacion = $fila['NVdiTiempoModificacion']; 

					$VentaDirecta->VdiTotalItems = $fila['VdiTotalItems'];
					
					
					$VentaDirecta->VdiGenerarVentaConcretada = $fila['VdiGenerarVentaConcretada'];
					$VentaDirecta->VdiGenerarPedidoCompra = $fila['VdiGenerarPedidoCompra'];
					
					$VentaDirecta->VdiPedidoCompra = $fila['VdiPedidoCompra'];
					$VentaDirecta->VdiVentaConcretada = $fila['VdiVentaConcretada'];

					$VentaDirecta->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VentaDirecta->CliNombre = $fila['CliNombre'];
					$VentaDirecta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VentaDirecta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$VentaDirecta->CliDireccion = $fila['CliDireccion'];
					$VentaDirecta->CliDepartamento = $fila['CliDepartamento'];
					$VentaDirecta->CliProvincia = $fila['CliProvincia'];
					$VentaDirecta->CliDistrito = $fila['CliDistrito'];
		
					$VentaDirecta->TdoId = $fila['TdoId'];
					$VentaDirecta->LtiId = $fila['LtiId'];
					$VentaDirecta->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VentaDirecta->CliTelefono = $fila['CliTelefono'];
					$VentaDirecta->CliEmail = $fila['CliEmail'];
					$VentaDirecta->CliCelular = $fila['CliCelular'];
					$VentaDirecta->CliFax = $fila['CliFax'];
					
					$VentaDirecta->TdoNombre = $fila['TdoNombre'];
					$VentaDirecta->LtiNombre = $fila['LtiNombre'];
					$VentaDirecta->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VentaDirecta->CprFecha = $fila['NCprFecha'];


					$VentaDirecta->EinVIN = $fila['EinVIN'];
					$VentaDirecta->EinPlaca = $fila['EinPlaca'];

					$VentaDirecta->VmaId = $fila['VmaId'];
					$VentaDirecta->VmaNombre = $fila['VmaNombre'];

					$VentaDirecta->VmoId = $fila['VmoId'];
					$VentaDirecta->VmoNombre = $fila['VmoNombre'];

					$VentaDirecta->VtiId = $fila['VtiId'];
					$VentaDirecta->VtiNombre = $fila['VtiNombre'];

					$VentaDirecta->VveId = $fila['VveId'];
					$VentaDirecta->VveNombre = $fila['VveNombre'];
					
					$VentaDirecta->MonNombre = $fila['MonNombre'];
					$VentaDirecta->MonSimbolo = $fila['MonSimbolo'];
					
					$VentaDirecta->VdiRepuesto = $fila['VdiRepuesto'];
					$VentaDirecta->VdiPlanchado = $fila['VdiPlanchado'];
					$VentaDirecta->VdiPintado = $fila['VdiPintado'];
					$VentaDirecta->VdiCentrado = $fila['VdiCentrado'];
					$VentaDirecta->VdiTarea = $fila['VdiTarea'];
					
					$VentaDirecta->PerNombre = $fila['PerNombre'];
					$VentaDirecta->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VentaDirecta->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$VentaDirecta->NpaNombre = $fila['NpaNombre'];
					
					$VentaDirecta->OcoProcesadoProveedor = $fila['OcoProcesadoProveedor'];

			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoDescripcion = "Pendiente";
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoDescripcion = "Realizado";
						break;	
						
						case 6:
							$VentaDirecta->VdiEstadoDescripcion = "Anulado";
						break;	
		
						default:
							$VentaDirecta->VdiEstadoDescripcion = "";
						break;
						
					}
			
			
					switch($VentaDirecta->VdiEstado){
						
						case 1:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
						break;
						
						case 3:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />';
						break;
						
						case 6:
							$VentaDirecta->VdiEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/anulado.gif" />';
						break;	
		
						default:
							$VentaDirecta->VdiEstadoIcono = "";
						break;
						
					}

                    $VentaDirecta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirecta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

		
}
?>