<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaConcretada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaConcretada {

    public $VcoId;
	public $CliId;
	
	public $AlmId;
	public $VcoFecha;
	
	public $MonId;
	public $VcoTipoCambio;

	public $CprId;
	public $VdiId;
	
	public $TopId;
	
	public $VcoDireccion;
    public $VcoObservacion;
	public $VcoPorcentajeImpuestoVenta;
	public $VcoMargenUtilidad;	
	
	public $VcoDescuento;
	public $VcoSubTotal;
	public $VcoImpuesto;
	public $VcoTotal;
	
	public $VcoFactura;
	public $VcoBoleta;
	public $VcoGuiaRemision;
	
	public $VcoEmpresaTransporte;
	public $VcoEmpresaTransporteDocumento;
	public $VcoEmpresaTransporteFecha;
	public $VcoEmpresaTransporteTipoEnvio;
	public $VcoEmpresaTransporteClave;
	public $VcoEmpresaTransporteDestino;
	
	
	public $VcoOrigen;
	public $VcoIncluyeImpuesto;
	public $VcoEstado;
	public $VcoTiempoCreacion;
	public $VcoTiempoModificacion;
    public $VcoEliminado;

	public $VcoTotalItems;
	public $VentaConcretadaDetalle;
	
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

	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
	public $MonSimbolo;
	public $MonNombre;
	
	public $VdiOrdenCompraNumero;
	
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVentaConcretadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(amo.AmoId,5),unsigned)) AS "MAXIMO"
		FROM tblamoalmacenmovimiento amo	';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->VcoId = "VCO-10000";
		}else{
			$fila['MAXIMO']++;
			$this->VcoId = "VCO-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerVentaConcretada(){

		$sql = 'SELECT 
        amo.AmoId,  
		amo.CliId,
		
		amo.AlmId,
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
		amo.MonId,
		amo.AmoTipoCambio,

		amo.VdiId,
		
		amo.TopId,

		amo.AmoDireccion,
		amo.AmoObservacion,
		amo.AmoPorcentajeImpuestoVenta,
		amo.AmoMargenUtilidad,
		
		amo.AmoEmpresaTransporte,
		amo.AmoEmpresaTransporteDocumento,
		amo.AmoEmpresaTransporteClave,
		amo.AmoEmpresaTransporteTipoEnvio,
		DATE_FORMAT(amo.AmoEmpresaTransporteFecha, "%d/%m/%Y") AS "NAmoEmpresaTransporteFecha",
		amo.AmoEmpresaTransporteDestino,
		
		amo.AmoManoObra,
		amo.AmoDescuento,
		amo.AmoSubTotal,
		amo.AmoImpuesto,
		amo.AmoTotal,
		
		
		
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
						
					WHERE fac.AmoId = amo.AmoId
					AND fac.FacEstado <> 6
					 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoFactura,
				
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
					WHERE bol.AmoId = amo.AmoId 
						AND bol.BolEstado <> 6 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoBoleta,
				
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
						LEFT JOIN tblgreguiaremision gre
						ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
							
					WHERE gam.AmoId = amo.AmoId 
						AND gre.GreEstado <> 6
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGuiaRemision,
				
				
		amo.AmoIncluyeImpuesto,	
		
		amo.AmoTipo,
		amo.AmoSubTipo,
		
		amo.AmoEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVcoTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVcoTiempoModificacion",

		CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.TdoId,
		cli.LtiId,
		cli.CliNumeroDocumento,
		cli.CliTelefono,
		cli.CliEmail,
		cli.CliCelular,
		cli.CliFax,
		
		cli.CliDireccion,
		cli.CliDepartamento,
		cli.CliProvincia,
		cli.CliDistrito,
	
		tdo.TdoNombre,
		lti.LtiNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		vdi.VdiOrdenCompraNumero,
		DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
		
		vdi.CprId,
		vdi.VdiMarca,
		vdi.VdiModelo,
		vdi.VdiPlaca,
		vdi.VdiAnoModelo,
		
		cpr.FinId,
		
		cpr.CliIdSeguro,
		seg.CliNombre AS CliNombreSeguro,
		seg.CliApellidoPaterno AS CliApellidoPaternoSeguro,
		seg.CliApellidoMaterno AS CliApellidoMaternoSeguro	,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail
						
        FROM tblamoalmacenmovimiento amo
			LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
						LEFT JOIN tblperpersonal per
						ON vdi.PerId = per.PerId
						
						
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					
					LEFT JOIN tblclicliente seg
					ON cpr.CliIdSeguro = seg.CliId
					
				LEFT JOIN tblclicliente cli
				ON amo.Cliid = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
						LEFT JOIN tbllticlientetipo lti
						ON cli.LtiId = lti.LtiId
							LEFT JOIN tblmonmoneda mon
							ON amo.MonId = mon.MonId
					
		WHERE amo.AmoId = "'.$this->VcoId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->VcoId = $fila['AmoId'];
			$this->CliId = $fila['CliId'];
			
			$this->AlmId = $fila['AlmId'];
			$this->VcoFecha = $fila['NAmoFecha'];
			$this->MonId = $fila['MonId'];
			$this->VcoTipoCambio = $fila['AmoTipoCambio'];

			$this->CprId = $fila['CprId'];
			$this->VdiId = $fila['VdiId'];
			
			$this->TopId = $fila['TopId'];

			$this->VcoDireccion = $fila['AmoDireccion'];
			$this->VcoObservacion = $fila['AmoObservacion'];

			$this->VcoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
			$this->VcoMargenUtilidad = $fila['AmoMargenUtilidad'];
			
		
		
			$this->VcoEmpresaTransporte = $fila['AmoEmpresaTransporte'];
			$this->VcoEmpresaTransporteDocumento = $fila['AmoEmpresaTransporteDocumento'];
			$this->VcoEmpresaTransporteClave = $fila['AmoEmpresaTransporteClave'];
			$this->VcoEmpresaTransporteTipoEnvio = $fila['AmoEmpresaTransporteTipoEnvio'];
			$this->VcoEmpresaTransporteFecha = $fila['NAmoEmpresaTransporteFecha'];
			$this->VcoEmpresaTransporteDestino = $fila['AmoEmpresaTransporteDestino'];
			
			$this->VcoManoObra = $fila['AmoManoObra'];
			$this->VcoDescuento = $fila['AmoDescuento'];
			$this->VcoSubTotal = $fila['AmoSubTotal'];
			$this->VcoImpuesto = $fila['AmoImpuesto'];
			$this->VcoTotal = $fila['AmoTotal'];

			$this->VcoFactura = $fila['AmoFactura'];
			$this->VcoBoleta = $fila['AmoBoleta'];
			$this->VcoGuiaRemision = $fila['AmoGuiaRemision'];
			
			$this->VcoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
			$this->VcoTipo = $fila['AmoTipo'];
			$this->VcoSubTipo = $fila['AmoSubTipo'];
		
			$this->VcoEstado = $fila['AmoEstado'];
			$this->VcoTiempoCreacion = $fila['NVcoTiempoCreacion']; 
			$this->VcoTiempoModificacion = $fila['NVcoTiempoModificacion']; 	
			
			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
		
			$this->TdoId = $fila['TdoId']; 
			$this->LtiId = $fila['LtiId']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$this->CliTelefono = $fila['CliTelefono'];
			$this->CliEmail = $fila['CliEmail'];
			$this->CliCelular = $fila['CliCelular'];
			$this->CliFax = $fila['CliFax'];	
			
			
			$this->CliDireccion = $fila['CliDireccion'];	
			$this->CliDepartamento = $fila['CliDepartamento'];	
			$this->CliProvincia = $fila['CliProvincia'];	
			$this->CliDistrito = $fila['CliDistrito'];	

			$this->TdoNombre = $fila['TdoNombre'];
			$this->LtiNombre = $fila['LtiNombre'];

			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$this->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];

			$this->FinId = $fila['FinId'];
			
			$this->VdiMarca = $fila['VdiMarca'];
			$this->VdiModelo = $fila['VdiModelo'];
			$this->VdiPlaca = $fila['VdiPlaca'];
			$this->VdiAnoModelo = $fila['VdiAnoModelo'];
			
			
			$this->CliIdSeguro = $fila['CliIdSeguro'];
			$this->CliNombreSeguro = $fila['CliNombreSeguro'];
			$this->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
			$this->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerEmail = $fila['PerEmail'];

			switch($this->VcoEstado){
				
				case 1:
					$this->VcoEstadoDescripcion = "Anulado";
				break;
				
				case 3:
					$this->VcoEstadoDescripcion = "Realizado";					
				break;
					
			}

			switch($this->VcoEstado){
				
				case 1:
					$this->VcoEstadoIcono = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
				
				case 3:
					$this->VcoEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.gif" />';					
				break;
				
			}
				
			$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
			$ResVentaConcretadaDetalle =  $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,NULL,NULL,NULL,$this->VcoId);
			$this->VentaConcretadaDetalle = 	$ResVentaConcretadaDetalle['Datos'];	
			

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL,$oSucursal=NULL) {

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
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId AND fac.FacEstado <> 6 LIMIT 1
			 )';
		}

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId AND bol.BolEstado <> 6 LIMIT 1
			 )';
		}
		
		if(($oConGuiaRemision==1)){
			$conguiaremision = ' AND  EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.AmoId = amo.AmoId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}elseif($oConGuiaRemision==2){
			$conguiaremision = ' AND  NOT EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremisionalmacenmovimiento gam 
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId
				WHERE gam.AmoId = amo.AmoId 
				AND gre.GreEstado <> 6
				LIMIT 1
			 )';
		}
		
		

		if(!empty($oVentaDirectaId)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirectaId.'"';
		}

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
				
		if(($oIgnorarTotalVacio)){
			$itvacio = ' AND amo.AmoTotal <> 0 ';
		}

		if($oGenerarFactura){
			
			$gfactura = '
			
			AND IF (

		( 
			
			
			IFNULL(( 
			SELECT 
				SUM((amd.AmdCantidad)) 
			FROM tblamdalmacenmovimientodetalle amd 
			WHERE amd.AmoId = amo.AmoId LIMIT 1 
			),0)

			- IFNULL((
					SELECT 
					SUM(bde.BdeCantidad) 
					FROM tblbdeboletadetalle bde
						LEFT JOIN tblbolboleta bol
						ON bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							LEFT JOIN tblamdalmacenmovimientodetalle amd 
							ON bde.AmdId = amd.AmdId

					WHERE amd.AmoId = amo.AmoId 
					AND bol.BolEstado <> 6
					
					  AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
														AND ncr.NcrEstado <> 6
														AND ncr.NcrMotivoCodigo<> "04"
														AND ncr.NcrMotivoCodigo<> "05"
														AND ncr.NcrMotivoCodigo<> "09"
														AND ncr.NcrMotivoCodigo<> "07"
													)
													
													
					LIMIT 1 
				),0)
		
				- IFNULL((
				SELECT 
				SUM(fde.FdeCantidad) 
				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						LEFT JOIN tblamdalmacenmovimientodetalle amd 
						ON fde.AmdId = amd.AmdId

				WHERE amd.AmoId = amo.AmoId 
				AND fac.FacEstado <> 6
				
				  AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
														AND ncr.NcrMotivoCodigo<> "04"
														AND ncr.NcrMotivoCodigo<> "05"
														AND ncr.NcrMotivoCodigo<> "09"
														AND ncr.NcrMotivoCodigo<> "07"
													)
													
				LIMIT 1 
			),0)

		)>0,"SI","NO"

) = "SI" 
				
			';
			
		}
			
	
		if(($oFacturable)){
			$facturable = ' AND amo.AmoFacturable =  '.$oFacturable;
		}
		
		if(($oSucursal)){
			$sucursal = ' AND amo.SucId = "'.$oSucursal.'"';
		}
		
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId,	
				amo.CliId,			
				
				amo.AlmId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				
				amo.MonId,
				amo.AmoTipoCambio,

			
				amo.VdiId,
				
				amo.TopId,
				
				amo.AmoDireccion,
				amo.AmoObservacion,
				amo.AmoPorcentajeImpuestoVenta,
				amo.AmoMargenUtilidad,
				
					amo.AmoEmpresaTransporte,
		amo.AmoEmpresaTransporteDocumento,
		amo.AmoEmpresaTransporteClave,
		amo.AmoEmpresaTransporteTipoEnvio,
		DATE_FORMAT(amo.AmoEmpresaTransporteFecha, "%d/%m/%Y") AS "NAmoEmpresaTransporteFecha",
		amo.AmoEmpresaTransporteDestino,
			
				amo.AmoManoObra,
				amo.AmoDescuento,
				amo.AmoSubTotal,
				amo.AmoImpuesto,
				amo.AmoTotal,
								

				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId 
					FROM tblfacfactura fac 
						
					WHERE fac.AmoId = amo.AmoId
					AND fac.FacEstado <> 6
						  AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
														AND ncr.NcrMotivoCodigo<> "04"
														AND ncr.NcrMotivoCodigo<> "05"
														AND ncr.NcrMotivoCodigo<> "09"
														AND ncr.NcrMotivoCodigo<> "07"
													)
					 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoFactura,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId 
					FROM tblbolboleta bol
					WHERE bol.AmoId = amo.AmoId 
						AND bol.BolEstado <> 6
						  AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
														AND ncr.NcrEstado <> 6
														AND ncr.NcrMotivoCodigo<> "04"
														AND ncr.NcrMotivoCodigo<> "05"
														AND ncr.NcrMotivoCodigo<> "09"
														AND ncr.NcrMotivoCodigo<> "07"
													)
													
													
													
													
						 LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoBoleta,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
						LEFT JOIN tblgreguiaremision gre
						ON (gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId)
							
					WHERE gam.AmoId = amo.AmoId 
						AND gre.GreEstado <> 6
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGuiaRemision,
				
				


	
				CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(amd.AmdCantidad,0) 
							
							- IFNULL(

								(
									SELECT 
									SUM(bde.BdeCantidad)
									FROM tblbdeboletadetalle bde
									
										LEFT JOIN tblbolboleta bol
										ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
											
									WHERE bde.AmdId = amd.AmdId
										AND bol.BolEstado <> 6
									LIMIT 1
								)
													
							,0)
							
							- IFNULL(
	
									(
										SELECT 
										SUM(fde.FdeCantidad)
										FROM tblfdefacturadetalle fde
										
											LEFT JOIN tblfacfactura fac
											ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
												
										WHERE fde.AmdId = amd.AmdId
											AND fac.FacEstado <> 6
										LIMIT 1
									)

							,0)
							
						)  AS AmdCantidadPendiente

					FROM tblamdalmacenmovimientodetalle amd
						
					WHERE amd.AmoId = amo.AmoId
						
						HAVING AmdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS AmoGenerarComprobante,
				
				
				
				
				
				amo.AmoIncluyeImpuesto,	
				amo.AmoCierre AS VcoCierre,		
				amo.AmoEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmoTiempoModificacion",
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "AmoTotalItems",
				
				CONCAT(IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")," ",IFNULL(cli.CliNombre,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.TdoId,
				cli.LtiId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				vdi.CprId,
				vdi.VdiOrdenCompraNumero,
				DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
				vdi.VdiArchivo,
			
				DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
	        	
				mon.MonSimbolo	,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
						LEFT JOIN tblperpersonal per
						ON vdi.PerId = per.PerId
			
					LEFT JOIN tblclicliente cli
					ON amo.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId	
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
								
				WHERE 
				amo.VdiId IS NOT NULL 
				AND amo.AmoTipo = 2 
				AND amo.AmoSubTipo = 3 '.$filtrar.$fecha.$tipo.$stipo.$estado.$sucursal.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$conguiaremision.$crestado.$vdirecta.$moneda.$dvencer.$pagado.$itvacio.$gfactura.$facturable.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaConcretada = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaConcretada = new $InsVentaConcretada();
                    $VentaConcretada->VcoId = $fila['AmoId'];
					$VentaConcretada->CliId = $fila['CliId'];
					
					$VentaConcretada->AlmId = $fila['AlmId'];
					$VentaConcretada->VcoFecha = $fila['NAmoFecha'];
					$VentaConcretada->MonId = $fila['MonId'];
					$VentaConcretada->VcoTipoCambio = $fila['AmoTipoCambio'];

					$VentaConcretada->CprId = $fila['CprId'];
					$VentaConcretada->VdiId = $fila['VdiId'];
					
					$VentaConcretada->TopId = $fila['TopId'];

					$VentaConcretada->VcoDireccion = $fila['AmoDireccion'];
					$VentaConcretada->VcoObservacion = $fila['AmoObservacion'];
					$VentaConcretada->VcoPorcentajeImpuestoVenta = $fila['AmoPorcentajeImpuestoVenta'];
					$VentaConcretada->VcoMargenUtilidad = $fila['AmoMargenUtilidad'];

					$VentaConcretada->VcoEmpresaTransporte = $fila['AmoEmpresaTransporte'];
					$VentaConcretada->VcoEmpresaTransporteDocumento = $fila['AmoEmpresaTransporteDocumento'];
					$VentaConcretada->VcoEmpresaTransporteClave = $fila['AmoEmpresaTransporteClave'];
					$VentaConcretada->VcoEmpresaTransporteTipoEnvio = $fila['AmoEmpresaTransporteTipoEnvio'];
					$VentaConcretada->VcoEmpresaTransporteFecha = $fila['NAmoEmpresaTransporteFecha'];
					$VentaConcretada->VcoEmpresaTransporteDestino = $fila['AmoEmpresaTransporteDestino'];
					
					$VentaConcretada->VcoManoObra = $fila['AmoManoObra'];
					$VentaConcretada->VcoDescuento = $fila['AmoDescuento'];
					$VentaConcretada->VcoSubTotal = $fila['AmoSubTotal'];
					$VentaConcretada->VcoImpuesto = $fila['AmoImpuesto'];
					$VentaConcretada->VcoTotal = $fila['AmoTotal'];
				
				
					$VentaConcretada->VcoFactura = $fila['AmoFactura'];
					$VentaConcretada->VcoBoleta = $fila['AmoBoleta'];
					$VentaConcretada->VcoGuiaRemision = $fila['AmoGuiaRemision'];
					
					$VentaConcretada->VcoGenerarComprobante = $fila['AmoGenerarComprobante'];
					
					
					$VentaConcretada->VcoIncluyeImpuesto = $fila['AmoIncluyeImpuesto'];
					$VentaConcretada->VcoCierre = $fila['VcoCierre'];
					$VentaConcretada->VcoEstado = $fila['AmoEstado'];
					$VentaConcretada->VcoTiempoCreacion = $fila['NAmoTiempoCreacion'];  
					$VentaConcretada->VcoTiempoModificacion = $fila['NAmoTiempoModificacion']; 

					$VentaConcretada->VcoTotalItems = $fila['AmoTotalItems']; 
					
					$VentaConcretada->CliNombreCompleto = $fila['CliNombreCompleto'];
					$VentaConcretada->CliNombre = $fila['CliNombre'];
					$VentaConcretada->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$VentaConcretada->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					
					$VentaConcretada->TdoId = $fila['TdoId'];
					$VentaConcretada->LtiId = $fila['LtiId'];
					$VentaConcretada->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$VentaConcretada->CliTelefono = $fila['CliTelefono'];
					$VentaConcretada->CliEmail = $fila['CliEmail'];
					$VentaConcretada->CliCelular = $fila['CliCelular'];
					$VentaConcretada->CliFax = $fila['CliFax'];
					$VentaConcretada->LtiAbreviatura = $fila['LtiAbreviatura'];
					
					$VentaConcretada->CliDireccion = $fila['CliDireccion'];
					$VentaConcretada->CliDepartamento = $fila['CliDepartamento'];
					$VentaConcretada->CliProvincia = $fila['CliProvincia'];
					$VentaConcretada->CliDistrito = $fila['CliDistrito'];
	
					
					$VentaConcretada->TdoNombre = $fila['TdoNombre'];
					$VentaConcretada->LtiNombre = $fila['LtiNombre'];
					
					$VentaConcretada->MonSimbolo = $fila['MonSimbolo'];
					
					$VentaConcretada->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$VentaConcretada->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
					
					
					$VentaConcretada->VdiArchivo = $fila['VdiArchivo'];
					$VentaConcretada->VdiFecha = $fila['NVdiFecha'];
					
					$VentaConcretada->PerNombre = $fila['PerNombre'];
					$VentaConcretada->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VentaConcretada->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$VentaConcretada->PerEmail = $fila['PerEmail'];
				
					switch($VentaConcretada->VcoEstado){
						case 1:
							$VentaConcretada->VcoEstadoDescripcion = "No Realizado";
						break;

						
						case 3:
							$VentaConcretada->VcoEstadoDescripcion = "Realizado";					
						break;
					}
					
					
								switch($VentaConcretada->VcoEstado){
					case 1:
						$VentaConcretada->VcoEstadoIcono = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
					break;

					
					case 3:
						$VentaConcretada->VcoEstadoIcono = '<img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.gif" />';					
					break;
			}
			
			
                    $VentaConcretada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaConcretada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
    public function MtdObtenerVentaConcretadasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL) {

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
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE 
						amd.AmoId = amo.AmoId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND amo.AmoEstado = '.$oEstado;
		}
		


		if(($oConFactura==1)){
			$confactura = ' AND  EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConFactura==2){
			$confactura = ' AND  NOT EXISTS ( 
				SELECT fac.FacId FROM tblfacfactura fac WHERE fac.AmoId = amo.AmoId LIMIT 1
			 )';
		}

		if(($oConBoleta==1)){
			$conboleta = ' AND  EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConBoleta==2){
			$conboleta = ' AND  NOT EXISTS ( 
				SELECT bol.BolId FROM tblbolboleta bol WHERE bol.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		if(($oConGuiaRemision==1)){
			$conguiaremision = ' AND  EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremision gam WHERE gam.AmoId = amo.AmoId LIMIT 1
			 )';
		}elseif($oConGuiaRemision==2){
			$conguiaremision = ' AND  NOT EXISTS ( 
				SELECT gam.GamId FROM tblgamguiaremision gam WHERE gam.AmoId = amo.AmoId LIMIT 1
			 )';
		}
		
		

		if(!empty($oVentaDirectaId)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirectaId.'"';
		}

		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
				
				
			
	
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
		
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
					
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
			
					LEFT JOIN tblclicliente cli
					ON amo.Cliid = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId	
								LEFT JOIN tblmonmoneda mon
								ON amo.MonId = mon.MonId
								
				WHERE 
				amo.VdiId IS NOT NULL 
				AND amo.AmoTipo = 2 
				AND amo.AmoSubTipo = 3 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$conguiaremision.$crestado.$vdirecta.$moneda.$dvencer.$pagado.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarVentaConcretada($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){

				$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,$elemento);
				$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];

				if(!empty($ArrVentaConcretadaDetalles)){
					$amdetalle = '';

					foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
						$amdetalle .= '#'.$DatVentaConcretadaDetalle->VcdId;
					}

					if(!$InsVentaConcretadaDetalle->MtdEliminarVentaConcretadaDetalle($amdetalle)){								
						$error = true;
					}
						
				}
				
				if(!$error) {		
					$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($elemento).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarVentaConcretada(3,"Se elimino la Venta Concretada",$elemento);		
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
	public function MtdActualizarEstadoVentaConcretada($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsVentaConcretada = new ClsVentaConcretada();
		$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	
					
					
					$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,$elemento);
					$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];
					
					if(!empty($ArrVentaConcretadaDetalles)){
						$amdetalle = '';
					
						foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
							$amdetalle .= '#'.$DatVentaConcretadaDetalle->VcdId;
						}
					
						if(!$InsVentaConcretadaDetalle->MtdActualizarEstadoVentaConcretadaDetalle($amdetalle,$oEstado)){								
							$error = true;
						}
							
					}

					if(!$error){

						$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarVentaConcretada(2,"Se actualizo el Estado de Venta Concretada",$elemento);
					
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
	public function MtdActualizarFacturableVentaConcretada($oElementos,$oFacturable) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsVentaConcretada = new ClsVentaConcretada();
	
			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblamoalmacenmovimiento SET AmoFacturable = '.$oFacturable.' WHERE AmoId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarVentaConcretada(2,"Se actualizo el Estado Facturable de Venta Concretada",$elemento);
					
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
	
	
	
	
	public function MtdRegistrarVentaConcretadaAux($oTrasaccion=true) {
	

			return true;
	
		
	}
	
	public function MtdRegistrarVentaConcretada($oTrasaccion=true) {

		global $Resultado;


		$error = false;
		
		if($oTrasaccion){
			$this->InsMysql->MtdTransaccionIniciar();			
		}

			$InsAlmacenStock = new ClsAlmacenStock();

			$this->MtdGenerarVentaConcretadaId();

			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,
			SucId,
			
			CliId,
			CprId,
			VdiId,
			TopId,
			
			NpaId,
			AmoCantidadDia,
			
			AmoDireccion,
			
			
			TalId,
			PprId,
			
			AlmId,
			AmoIdOrigen,
			LtiId,
			
			AmoFecha,
			MonId,
			AmoTipoCambio,
			AmoObservacion,
			AmoPorcentajeImpuestoVenta,
			
			AmoTipo,	
			AmoSubTipo,
			
			AmoMargenUtilidad,
			
		AmoEmpresaTransporte,
		AmoEmpresaTransporteDocumento,
		AmoEmpresaTransporteClave,
		AmoEmpresaTransporteTipoEnvio,
		AmoEmpresaTransporteFecha,
		AmoEmpresaTransporteDestino,
			
			
			AmoManoObra,
			AmoDescuento,
			AmoSubTotal,
			AmoImpuesto,
			AmoTotal,
			
			AmoCancelado,
			AmoRevisado,
			
			AmoIncluyeImpuesto,
			AmoFacturable,
			
			AmoCierre,
			AmoEstado,
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->VcoId).'",
			"'.($this->SucId).'",
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			'.(empty($this->CprId)?'NULL, ':'"'.$this->CprId.'",').'
			'.(empty($this->VdiId)?'NULL, ':'"'.$this->VdiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			
			NULL,
			0,
			
			"'.($this->VcoDireccion).'",
			
			NULL,
			NULL,
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			NULL,
			NULL,
			
			"'.($this->VcoFecha).'",
			"'.($this->MonId).'",
			'.(empty($this->VcoTipoCambio)?'NULL, ':'"'.$this->VcoTipoCambio.'",').'
			"'.($this->VcoObservacion).'",
			'.($this->VcoPorcentajeImpuestoVenta).',
			
			2,
			3,
			

			'.($this->VcoMargenUtilidad).',

			"'.($this->VcoEmpresaTransporte).'",
			"'.($this->VcoEmpresaTransporteDocumento).'",
			"'.($this->VcoEmpresaTransporteClave).'",
			"'.($this->VcoEmpresaTransporteTipoEnvio).'",
			'.(empty($this->VcoEmpresaTransporteFecha)?'NULL, ':'"'.$this->VcoEmpresaTransporteFecha.'",').'
			"'.($this->VcoEmpresaTransporteDestino).'",
		
			'.($this->VcoManoObra).',
			'.($this->VcoDescuento).',
			'.($this->VcoSubTotal).',
			'.($this->VcoImpuesto).',
			'.($this->VcoTotal).',

			2,
			0,

			'.($this->VcoIncluyeImpuesto).',
			1,
			2,		
			'.($this->VcoEstado).',			
			"'.($this->VcoTiempoCreacion).'", 				
			"'.($this->VcoTiempoModificacion).'");';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
//		if(!$error){
//e
//			if(!empty($this->CprId)){
//
//				if(!empty($this->FinId)){
//	
//					$InsCotizacionProducto = new ClsCotizacionProducto();
//					$InsCotizacionProducto->MtdEditarCotizacionProductoDato("FinId",$this->FinId,$this->CprId);
//	
//				}
//
//			}
//			
//		}
					
			if(!$error){			

				if (!empty($this->VentaConcretadaDetalle)){		
						
					$validar = 0;				
					$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();		

					foreach ($this->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
					
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatVentaConcretadaDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsVentaConcretadaDetalle->VcdId = $DatVentaConcretadaDetalle->VcdId;				
						$InsVentaConcretadaDetalle->VcoId = $this->VcoId;
						$InsVentaConcretadaDetalle->ProId = $DatVentaConcretadaDetalle->ProId;
						$InsVentaConcretadaDetalle->UmeId = $DatVentaConcretadaDetalle->UmeId;
						$InsVentaConcretadaDetalle->VddId = $DatVentaConcretadaDetalle->VddId;

						$InsVentaConcretadaDetalle->VcdCantidad = $DatVentaConcretadaDetalle->VcdCantidad;
						$InsVentaConcretadaDetalle->VcdCantidadReal = $DatVentaConcretadaDetalle->VcdCantidadReal;
						$InsVentaConcretadaDetalle->VcdCantidadRealAnterior = $DatVentaConcretadaDetalle->VcdCantidadRealAnterior;
						
						$InsVentaConcretadaDetalle->VcdCosto = $DatVentaConcretadaDetalle->VcdCosto;
						$InsVentaConcretadaDetalle->VcdCostoExtraTotal = $DatVentaConcretadaDetalle->VcdCostoExtraTotal;
						$InsVentaConcretadaDetalle->VcdUtilidad = $DatVentaConcretadaDetalle->VcdUtilidad;						
						$InsVentaConcretadaDetalle->VcdValorTotal = $DatVentaConcretadaDetalle->VcdValorTotal;
						$InsVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
						
						$InsVentaConcretadaDetalle->VcdImporte = $DatVentaConcretadaDetalle->VcdImporte;
						$InsVentaConcretadaDetalle->VcdReingreso = $DatVentaConcretadaDetalle->VcdReingreso;
						$InsVentaConcretadaDetalle->VcdCompraOrigen = $DatVentaConcretadaDetalle->VcdCompraOrigen;
						//$InsVentaConcretadaDetalle->VcdEstado = $this->VcoEstado;									
						$InsVentaConcretadaDetalle->VcdEstado = $DatVentaConcretadaDetalle->VcdEstado;
						$InsVentaConcretadaDetalle->VcdTiempoCreacion = $DatVentaConcretadaDetalle->VcdTiempoCreacion;
						$InsVentaConcretadaDetalle->VcdTiempoModificacion = $DatVentaConcretadaDetalle->VcdTiempoModificacion;						
						$InsVentaConcretadaDetalle->VcdEliminado = $DatVentaConcretadaDetalle->VcdEliminado;
						
						$InsVentaConcretadaDetalle->AlmId = $this->AlmId;
						$InsVentaConcretadaDetalle->VcdFecha = $this->VcoFecha;
						//if($InsVentaConcretadaDetalle->VcdEstado == 3){
								
						$StockReal = 0;
						$Fecha = explode("/",$this->VcoFecha);
						$Ano = $Fecha[2];
						
						//$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsVentaConcretadaDetalle->ProId,$this->AlmId,$Ano,$this->SucId);
						$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsVentaConcretadaDetalle->ProId);
	$StockReal = 10000;
						//if( ($StockReal + $InsVentaConcretadaDetalle->VcdCantidadRealAnterior) < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){
						if( $StockReal < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){
							
							$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
							$Resultado.='#ERR_VCO_208';												 
							
						}else{
							
							if($InsVentaConcretadaDetalle->MtdRegistrarVentaConcretadaDetalle()){
								
								$validar++;	
								
							}else{
								
								//$Resultado.='#Item Numero: '.($validar+1);
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_VCO_201';
								
							}
							
						}
					  
						
					}					
					
					if(count($this->VentaConcretadaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if($error) {	
				if($oTrasaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
		
				return false;
			} else {			
				if($oTrasaccion){	
					$this->InsMysql->MtdTransaccionHacer();		
				}
				$this->MtdAuditarVentaConcretada(1,"Se registro la Venta Concretada",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarVentaConcretada() {

		global $Resultado;

		$error = false;
		
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$InsAlmacenStock = new ClsAlmacenStock();
		

		$sql = 'UPDATE tblamoalmacenmovimiento SET
		'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
		
		'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		AmoFecha = "'.($this->VcoFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->VcoTipoCambio)?'AmoTipoCambio = NULL, ':'AmoTipoCambio = "'.$this->VcoTipoCambio.'",').'
		AmoDireccion = "'.($this->VcoDireccion).'",
		AmoObservacion = "'.($this->VcoObservacion).'",
		AmoPorcentajeImpuestoVenta = '.($this->VcoPorcentajeImpuestoVenta).',
		AmoMargenUtilidad = '.($this->VcoMargenUtilidad).',
	
		AmoEmpresaTransporte = "'.($this->VcoEmpresaTransporte).'",
		AmoEmpresaTransporteDocumento = "'.($this->VcoEmpresaTransporteDocumento).'",
		AmoEmpresaTransporteClave = "'.($this->VcoEmpresaTransporteClave).'",
		AmoEmpresaTransporteTipoEnvio = "'.($this->VcoEmpresaTransporteTipoEnvio).'",
		'.(empty($this->VcoEmpresaTransporteFecha)?'AmoEmpresaTransporteFecha = NULL, ':'AmoEmpresaTransporteFecha = "'.$this->VcoEmpresaTransporteFecha.'",').'
		AmoEmpresaTransporteDestino = "'.($this->VcoEmpresaTransporteDestino).'",
		
		AmoManoObra = '.($this->VcoManoObra).',
		AmoDescuento = '.($this->VcoDescuento).',
		AmoSubTotal = '.($this->VcoSubTotal).',
		AmoImpuesto = '.($this->VcoImpuesto).',
		AmoTotal = '.($this->VcoTotal).',

		AmoIncluyeImpuesto = '.($this->VcoIncluyeImpuesto).',
		AmoEstado = '.($this->VcoEstado).',

		AmoTiempoModificacion = "'.($this->VcoTiempoModificacion).'"
		WHERE AmoId = "'.($this->VcoId).'";';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			

//		if(!$error){
//			if(!empty($this->CprId)){
//
//				if(!empty($this->FinId)){
//	
//					$InsCotizacionProducto = new ClsCotizacionProducto();
//					$InsCotizacionProducto->MtdEditarCotizacionProductoDato("FinId",$this->FinId,$this->CprId);
//	
//				}
//
//			}
//		}
		
		if(!$error){
			
				if (!empty($this->VentaConcretadaDetalle)){		

					$validar = 0;				
					$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
							
					foreach ($this->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){

						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatVentaConcretadaDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsVentaConcretadaDetalle->VcdId = $DatVentaConcretadaDetalle->VcdId;				
						$InsVentaConcretadaDetalle->VcoId = $this->VcoId;
						$InsVentaConcretadaDetalle->ProId = $DatVentaConcretadaDetalle->ProId;
						$InsVentaConcretadaDetalle->UmeId = $DatVentaConcretadaDetalle->UmeId;
						$InsVentaConcretadaDetalle->VddId = $DatVentaConcretadaDetalle->VddId;

						$InsVentaConcretadaDetalle->VcdCantidad = $DatVentaConcretadaDetalle->VcdCantidad;
						$InsVentaConcretadaDetalle->VcdCantidadReal = $DatVentaConcretadaDetalle->VcdCantidadReal;
						$InsVentaConcretadaDetalle->VcdCantidadRealAnterior = $DatVentaConcretadaDetalle->VcdCantidadRealAnterior;
						
						$InsVentaConcretadaDetalle->VcdCosto = $DatVentaConcretadaDetalle->VcdCosto;
						$InsVentaConcretadaDetalle->VcdCostoExtraTotal = $DatVentaConcretadaDetalle->VcdCostoExtraTotal;
						$InsVentaConcretadaDetalle->VcdUtilidad = $DatVentaConcretadaDetalle->VcdUtilidad;						
						$InsVentaConcretadaDetalle->VcdValorTotal = $DatVentaConcretadaDetalle->VcdValorTotal;
						$InsVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
						$InsVentaConcretadaDetalle->VcdImporte = $DatVentaConcretadaDetalle->VcdImporte;
						$InsVentaConcretadaDetalle->VcdReingreso = $DatVentaConcretadaDetalle->VcdReingreso;
						$InsVentaConcretadaDetalle->VcdCompraOrigen = $DatVentaConcretadaDetalle->VcdCompraOrigen;
						//$InsVentaConcretadaDetalle->VcdEstado = $this->VcoEstado;									
						$InsVentaConcretadaDetalle->VcdEstado = $DatVentaConcretadaDetalle->VcdEstado;					
						$InsVentaConcretadaDetalle->VcdTiempoCreacion = $DatVentaConcretadaDetalle->VcdTiempoCreacion;
						$InsVentaConcretadaDetalle->VcdTiempoModificacion = $DatVentaConcretadaDetalle->VcdTiempoModificacion;						
						$InsVentaConcretadaDetalle->VcdEliminado = $DatVentaConcretadaDetalle->VcdEliminado;

						$InsVentaConcretadaDetalle->AlmId = $this->AlmId;
						$InsVentaConcretadaDetalle->VcdFecha = $this->VcoFecha;


						if(empty($InsVentaConcretadaDetalle->VcdId)){
							if($InsVentaConcretadaDetalle->VcdEliminado<>2){
								
								
								//if($InsVentaConcretadaDetalle->VcdEstado == 3){
								
									$StockReal = 0;
									$Fecha = explode("/",$this->VcoFecha);
									$Ano = $Fecha[2];
									
									//$InsAlmacenProducto = new ClsAlmacenProducto();
									//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
									//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsVentaConcretadaDetalle->ProId,$this->AlmId,$Ano,$this->SucId);
									$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsVentaConcretadaDetalle->ProId);
	$StockReal = 10000;
	
									//if( ($StockReal + $InsVentaConcretadaDetalle->VcdCantidadRealAnterior) < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){
									if( $StockReal < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){
										
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_VCO_208';												 
										
									}else{
										
										if($InsVentaConcretadaDetalle->MtdRegistrarVentaConcretadaDetalle()){
											
											$validar++;	
											
										}else{
											
											//$Resultado.='#Item Numero: '.($validar+1);
											$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
											$Resultado.='#ERR_VCO_201';
											
										}
										
									}
								
								
								
							}else{
								$validar++;
							}
						}else{						
							if($InsVentaConcretadaDetalle->VcdEliminado==2){
								if($InsVentaConcretadaDetalle->MtdEliminarVentaConcretadaDetalle($InsVentaConcretadaDetalle->VcdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_VCO_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								//if($InsVentaConcretadaDetalle->VcdEstado == 3){
								
									$StockReal = 0;
									$Fecha = explode("/",$this->VcoFecha);
									$Ano = $Fecha[2];
									
									$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,$this->AlmId,$Ano,$InsVentaConcretadaDetalle->ProId);

									//$InsAlmacenProducto = new ClsAlmacenProducto();
									//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
									//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsVentaConcretadaDetalle->ProId,$this->AlmId,$Ano);
									
									//if( ($StockReal + $InsVentaConcretadaDetalle->VcdCantidadRealAnterior) < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){
									
									if( ($StockReal + $InsVentaConcretadaDetalle->VcdCantidadRealAnterior) < $InsVentaConcretadaDetalle->VcdCantidadReal and $InsVentaConcretadaDetalle->VcdEliminado == 1 and $InsVentaConcretadaDetalle->VcdEstado == 3){										
																
										$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
										$Resultado.='#ERR_VCO_208';												 
										
									}else{
										
										if($InsVentaConcretadaDetalle->MtdEditarVentaConcretadaDetalle()){
											$validar++;	
										}else{
											 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
											$Resultado.='#ERR_VCO_202';
											//$Resultado.='#Item Numero: '.($validar+1);
										}
										
									}
								
								//}
								
								
								
								
								
								
							}
						}									
					}
					
					if(count($this->VentaConcretadaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVentaConcretada(2,"Se edito la Venta Concretada",$this);		
				return true;
			}	
				
		}	
		
		
		
		
		
	public function MtdEditarVentaConcretadaDespacho() {

		global $Resultado;

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblamoalmacenmovimiento SET
		AmoEmpresaTransporte = "'.($this->VcoEmpresaTransporte).'",
		AmoEmpresaTransporteDocumento = "'.($this->VcoEmpresaTransporteDocumento).'",
		AmoEmpresaTransporteClave = "'.($this->VcoEmpresaTransporteClave).'",
		AmoEmpresaTransporteTipoEnvio = "'.($this->VcoEmpresaTransporteTipoEnvio).'",
		'.(empty($this->VcoEmpresaTransporteFecha)?'AmoEmpresaTransporteFecha = NULL, ':'AmoEmpresaTransporteFecha = "'.$this->VcoEmpresaTransporteFecha.'",').'
		AmoEmpresaTransporteDestino = "'.($this->VcoEmpresaTransporteDestino).'",
		
		AmoTiempoModificacion = "'.($this->VcoTiempoModificacion).'"
		WHERE AmoId = "'.($this->VcoId).'";';			

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVentaConcretada(2,"Se edito la Venta Concretada / Despacho",$this);		
				return true;
			}	
				
		}	
		
		
		
		
		
		public function MtdEditarVentaConcretadaDato($oCampo,$oDato,$oId) {

		global $Resultado;
		$error = false;


		$sql = 'UPDATE tblamoalmacenmovimiento SET
		'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'

		AmoTiempoModificacion = NOW()
		WHERE AmoId = "'.($oId).'";';			

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
		
	
//	public function MtdEditarVentaConcretadaGuiaRemision() {
//
//		global $Resultado;
//		$error = false;
//		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
//		
//		$sql = 'UPDATE tblamoalmacenmovimiento SET
//		'.(empty($this->GreId)?'GreId = NULL, ':'GreId = "'.$this->GreId.'",').'
//		'.(empty($this->GrtId)?'GrtId = NULL ':'GrtId = "'.$this->GrtId.'"').'
//		WHERE AmoId = "'.($this->VcoId).'";';	
//		
//		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//
//		if(!$resultado) {							
//			$error = true;
//		} 			
//
//		if(!$error){
//			
//				if (!empty($this->VentaConcretadaDetalle)){		
//
//					$validar = 0;				
//					$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
//							
//					foreach ($this->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
//						
//						$InsVentaConcretadaDetalle->VcdId = $DatVentaConcretadaDetalle->VcdId;				
//						$InsVentaConcretadaDetalle->VcoId = $this->VcoId;
//						$InsVentaConcretadaDetalle->ProId = $DatVentaConcretadaDetalle->ProId;
//						$InsVentaConcretadaDetalle->UmeId = $DatVentaConcretadaDetalle->UmeId;
//						$InsVentaConcretadaDetalle->VddId = $DatVentaConcretadaDetalle->VddId;
//
//						$InsVentaConcretadaDetalle->VcdCantidad = $DatVentaConcretadaDetalle->VcdCantidad;
//						$InsVentaConcretadaDetalle->VcdCantidadReal = $DatVentaConcretadaDetalle->VcdCantidadReal;
//						
//						$InsVentaConcretadaDetalle->VcdCosto = $DatVentaConcretadaDetalle->VcdCosto;
//						$InsVentaConcretadaDetalle->VcdCostoExtraTotal = $DatVentaConcretadaDetalle->VcdCostoExtraTotal;
//						$InsVentaConcretadaDetalle->VcdUtilidad = $DatVentaConcretadaDetalle->VcdUtilidad;						
//						$InsVentaConcretadaDetalle->VcdValorTotal = $DatVentaConcretadaDetalle->VcdValorTotal;
//						$InsVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
//						
//						$InsVentaConcretadaDetalle->VcdImporte = $DatVentaConcretadaDetalle->VcdImporte;
//						$InsVentaConcretadaDetalle->VcdEstado = $this->VcoEstado;									
//						$InsVentaConcretadaDetalle->VcdTiempoCreacion = $DatVentaConcretadaDetalle->VcdTiempoCreacion;
//						$InsVentaConcretadaDetalle->VcdTiempoModificacion = $DatVentaConcretadaDetalle->VcdTiempoModificacion;						
//						$InsVentaConcretadaDetalle->VcdEliminado = $DatVentaConcretadaDetalle->VcdEliminado;
//						
//						if(empty($InsVentaConcretadaDetalle->VcdId)){
//							if($InsVentaConcretadaDetalle->VcdEliminado<>2){
//								if($InsVentaConcretadaDetalle->MtdRegistrarVentaConcretadaDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_VCO_201';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsVentaConcretadaDetalle->VcdEliminado==2){
//								if($InsVentaConcretadaDetalle->MtdEliminarVentaConcretadaDetalle($InsVentaConcretadaDetalle->VcdId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_VCO_203';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsVentaConcretadaDetalle->MtdEditarVentaConcretadaDetalle()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_VCO_202';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->VentaConcretadaDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}	
//			
//			if($error){
//				if($this->Transaccion){		
//					$this->InsMysql->MtdTransaccionDeshacer();					
//				}
//				return false;
//			}else {			
//				if($this->Transaccion){
//					$this->InsMysql->MtdTransaccionHacer();				
//				}
//				$this->MtdAuditarVentaConcretada(2,"Se edito la Venta Concretada",$this);		
//				return true;
//			}	
//				
//		}	
			
		private function MtdAuditarVentaConcretada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->VcoId;

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
		
		
	//public function MtdEnviarContabilidadVentaConcretada($oElementos) {
//
//		$error = false;
//
//		$this->InsMysql->MtdTransaccionIniciar();
//		
//		$InsCotizacionProducto = new ClsCotizacionProducto();
//		
//		$elementos = explode("#",$oElementos);
//
//			$i=1;
//			foreach($elementos as $elemento){
//
//				
//				if(!empty($elemento)){
//					$aux = explode("%",$elemento);	
//
//					if(!$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($aux[1],4,false)) {						
//						$error = true;
//					}else{
//						$this->MtdAuditarVentaConcretada(2,"Se actualizo el Estado de Venta Concretada/Cotizacion de Repuesto",$aux);
//				
//					}
//					
//				}
//			$i++;
//	
//			}
//	
//			if($error) {	
//				$this->InsMysql->MtdTransaccionDeshacer();			
//				return false;
//			} else {				
//				$this->InsMysql->MtdTransaccionHacer();			
//				return true;
//			}									
//	}

	
		public function MtdNotificarVentaConcretadaSinFacturar($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL){
		
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$Enviar = false;
			
			$mensaje .= "NOTIFICACION DE ESTADO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

		
			$mensaje .= "Fecha de notificacion: <b>".date("d/m/Y")."</b>";	
			//$mensaje .= "Facturas por Vencer";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
			$InsMoneda = new ClsMoneda();
			

			$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","DESC",NULL);
			$ArrMonedas = $ResMoneda['Datos'];

			foreach($ArrMonedas as $DatMoneda){
			
				$mensaje .= "<br>";
				
				//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL)
				$ResVentaConcretada = $this->MtdObtenerVentaConcretadas(NULL,NULL,NULL,"AmoFecha","DESC",NULL,($POST_finicio),($POST_ffin),NULL,2,2,0,NULL,$DatMoneda->MonId);
				$ArrVentaConcretadas = $ResVentaConcretada['Datos'];

				if(!empty($ArrVentaConcretadas)){
				
					$mensaje .= $DatMoneda->MonNombre." (".$DatMoneda->MonSimbolo.")" ;
					$mensaje .= "<br>";
					
					
					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>Ven. Concretada</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>Fecha</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "<b>Cliente</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>Cot.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>Ord. Ven.</b>";
						$mensaje .= "</td>";


						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>O.C. Ref.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>Total</b>";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
							
				$i = 1;	
				
				foreach($ArrVentaConcretadas as $DatVentaConcretada){

	
					if($DatVentaConcretada->MonId<>$EmpresaMonedaId){
						$DatVentaConcretada->VcoTotal = round($DatVentaConcretada->VcoTotal / $DatVentaConcretada->VcoTipoCambio,2);
					}
				
						
						$mensaje .= "<tr>";
									
									
							$mensaje .= "<td>";
							$mensaje .= $i;
							$mensaje .= "</td>";
			
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->VcoId;
							$mensaje .= "</td>";
			
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->VcoFecha;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->CliNombre." ".$DatVentaConcretada->CliApellidoPaterno." ".$DatVentaConcretada->CliApellidoMaterno;
							$mensaje .= "</td>";
	
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->CprId;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->VdiId;
							$mensaje .= "</td>";
	
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->VdiOrdenCompraNumero;
							$mensaje .= "</td>";
	
							$mensaje .= "<td>";
							$mensaje .= $DatVentaConcretada->VcoTotal;
							$mensaje .= "</td>";

							
						$mensaje .= "</tr>";
						$i++;				
					
						$Enviar = true;
									
				}
				

					
						
					$mensaje .= "</table>";
					
					
				}
				
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;
			
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: VEN. CONCRETADAS S/ FACTURAR ",$mensaje);
				
			}
			
			
			
			
		}
			
			
			
			
			
	public function MtdEnviarCorreoSolicitudFacturacion($oDestinatario,$oVentaConcretadaId,$oSolicitante){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			global $EmpresaMonedaId;
			
			$this->VcoId = $oVentaConcretadaId;
			$this->MtdObtenerVentaConcretada();
			
			$Enviar = false;
			
			$mensaje .= "SOLICITUD DE FACTURACION:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "Fecha de solicitud: <b>".date("d/m/Y")."</b>";	
			//$mensaje .= "Facturas por Vencer";	
			$mensaje .= "<br>";		
			$mensaje .= "<br>";		
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			$mensaje .= "<br>";				
			$mensaje .= "Se solicita facturacion de la siguiente ficha.";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha: <b>".$this->VcoFecha."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Ord. Ven.: <b>".$this->VdiId."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Ref: <b>".$this->VdiOrdenCompraNumero."</b>";	
			$mensaje .= "<br>";
			
			
			$mensaje .= "<br>";
			
				if(!empty($this->VentaConcretadaDetalle)){
				
					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>CANT.</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>UND MED.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>CODIGO</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='45%'>";
						$mensaje .= "<b>DESCRIPCION</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>P.U.</b>";
						$mensaje .= "</td>";


						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>TOTAL</b>";
						$mensaje .= "</td>";

					$mensaje .= "</tr>";
					
					$ArrSuministros = array();
					
					$i = 1;
					if (!empty($this->VentaConcretadaDetalle)) {
						foreach ($this->VentaConcretadaDetalle as $DatVentaConcretadaDetalle) {
						
						
							if($this->MonId<>$EmpresaMonedaId ){
					
								$DatVentaConcretadaDetalle->VcdCosto = round($DatVentaConcretadaDetalle->VcdCosto / $this->VcoTipoCambio,2);
								$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $this->VcoTipoCambio,2);
								$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte / $this->VcoTipoCambio,2);
								
								
							}
				
						 if ($DatVentaConcretadaDetalle->RtiId <> "RTI-10003") {
									
									
										$mensaje .= "<tr>";
												
										$mensaje .= "<td>";
										$mensaje .= $i;
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= number_format($DatVentaConcretadaDetalle->VcdCantidad,2);
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= $DatVentaConcretadaDetalle->UmeNombre;
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= $DatVentaConcretadaDetalle->ProCodigoOriginal;
										if($DatVentaConcretadaDetalle->AmdReemplazo == "Si"){
										
											$mensaje .= "(". $DatVentaConcretadaDetalle->ProCodigoOriginalReemplazo.")";
										}								
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= $DatVentaConcretadaDetalle->ProNombre;
										$mensaje .= "</td>";
										
										$mensaje .= "<td>";
										$mensaje .= number_format($DatVentaConcretadaDetalle->VcdPrecioVenta,2);
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= number_format($DatVentaConcretadaDetalle->VcdImporte,2);
										$mensaje .= "</td>";
				
									$mensaje .= "</tr>";
									
									 $i++;
            						$TotalBruto += $DatVentaConcretadaDetalle->VcdImporte;
						 }
						 
						 
					
						$Enviar = true;
									
						}
					}




					if (!empty($ArrSuministros)) {
						
									$mensaje .= "<tr>";
												
												
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= "";						
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= "MATERIALES:";
										$mensaje .= "</td>";
										
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
				
									$mensaje .= "</tr>";
									
									foreach ($ArrSuministros as $DatSuministro) {
										
										$mensaje .= "<tr>";
												
												
										$mensaje .= "<td>";
										$mensaje .= $i;
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= number_format($DatSuministro->VcdCantidad,2);
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= $DatSuministro->UmeNombre;
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= $DatSuministro->ProCodigoOriginal;
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= $DatSuministro->ProNombre;
										$mensaje .= "</td>";
										
										$mensaje .= "<td>";
										$mensaje .= number_format($DatSuministro->VcdPrecioVenta,2);
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= number_format($DatSuministro->VcdImporte,2);
										$mensaje .= "</td>";
				
										$mensaje .= "</tr>";
										
										$TotalBruto += $DatSuministro->VcdImporte;
									}

                       
                    
                    }
					
						
					$mensaje .= "</table>";
				}
				
			$Total = $TotalBruto - $this->VcoDescuento;
			
			
			if($this->VcoIncluyeImpuesto == 2){
				$mensaje .= "Los Precios NO incluyen IGV";
				$mensaje .= "<br>";
			}else{
				$mensaje .= "Los Precios incluyen IGV";
				$mensaje .= "<br>";
			}
			
			if (!empty($this->VcoDescuento) and $this->VcoDescuento <> "0.00") {
				
				$mensaje .= "<br>";
				$mensaje .= "Descuento: <b>".$this->MonSimbolo." ".$this->VcoDescuento."</b>";
				$mensaje .= "<br>";
			}
			
			$mensaje .= "Total: <b>".$this->MonSimbolo." ".number_format($Total, 2)."</b>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br><br>";
			$mensaje .= "Atte.";
			
			$mensaje .= "<br><br>";
			$mensaje .= $oSolicitante;
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD: FACTURACION FICHA ".$this->VcoId." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
			}
				
	}
	
	
	
	
			
	public function MtdEnviarCorreoInformarDespacho($oDestinatario,$oVentaConcretadaId){
		
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VcoId = $oVentaConcretadaId;
			$this->MtdObtenerVentaConcretada();
			
			$Enviar = false;
			
			$mensaje .= "INFORME DE DESPACHO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "Fecha de informe: <b>".date("d/m/Y")."</b>";	
			
			$mensaje .= "<br>";		
			$mensaje .= "<br>";		
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			$mensaje .= "<br>";				
			$mensaje .= "Se informa que se realizo el despacho de repuestos con la siguiente informacion:";
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			$mensaje .= "Destino: <b>".$this->VcoEmpresaTransporteDestino."</b>";
			$mensaje .= "<br>";
			$mensaje .= "Empresa de Transportes: <b>".$this->VcoEmpresaTransporte."</b>";
			$mensaje .= "<br>";	
			$mensaje .= "Doc. Transporte: <b>".$this->VcoEmpresaTransporteDocumento."</b>";
			$mensaje .= "<br>";	
			$mensaje .= "Fecha de Despacho: <b>".$this->VcoEmpresaTransporteFecha."</b>";
			$mensaje .= "<br>";	
			$mensaje .= "Tipo de Envio: <b>".$this->VcoEmpresaTransporteTipoEnvio."</b>";
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha: <b>".$this->VcoFecha."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Ord. Ven.: <b>".$this->VdiId."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Ref: <b>".$this->VdiOrdenCompraNumero."</b>";	
			$mensaje .= "<br>";
			
			
			$mensaje .= "<br>";
			
				if(!empty($this->VentaConcretadaDetalle)){
				
					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>CANT.</b>";
						$mensaje .= "</td>";
		
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>UND MED.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>CODIGO</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='45%'>";
						$mensaje .= "<b>DESCRIPCION</b>";
						$mensaje .= "</td>";
						
					$mensaje .= "</tr>";
					
					$ArrSuministros = array();
					
					$i = 1;
					if (!empty($this->VentaConcretadaDetalle)) {
						foreach ($this->VentaConcretadaDetalle as $DatVentaConcretadaDetalle) {
						
						
							if($this->MonId<>$EmpresaMonedaId ){
					
								$DatVentaConcretadaDetalle->VcdCosto = round($DatVentaConcretadaDetalle->VcdCosto / $this->VcoTipoCambio,2);
								$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $this->VcoTipoCambio,2);
								$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte / $this->VcoTipoCambio,2);
								
								
							}
				
						 if ($DatVentaConcretadaDetalle->RtiId <> "RTI-10003") {
									
									
										$mensaje .= "<tr>";
												
										$mensaje .= "<td>";
										$mensaje .= $i;
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= number_format($DatVentaConcretadaDetalle->VcdCantidad,2);
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= $DatVentaConcretadaDetalle->UmeNombre;
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= $DatVentaConcretadaDetalle->ProCodigoOriginal;
										if($DatVentaConcretadaDetalle->AmdReemplazo == "Si"){
										
											$mensaje .= "(". $DatVentaConcretadaDetalle->ProCodigoOriginalReemplazo.")";
										}								
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= $DatVentaConcretadaDetalle->ProNombre;
										$mensaje .= "</td>";
										
									$mensaje .= "</tr>";
									
									 $i++;
            						
						 }
						 
						 
					
						$Enviar = true;
									
						}
					}




					if (!empty($ArrSuministros)) {
						
									$mensaje .= "<tr>";
												
												
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= "";
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= "";						
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= "MATERIALES:";
										$mensaje .= "</td>";
										
									$mensaje .= "</tr>";
									
									foreach ($ArrSuministros as $DatSuministro) {
										
										$mensaje .= "<tr>";
												
												
										$mensaje .= "<td>";
										$mensaje .= $i;
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= number_format($DatSuministro->VcdCantidad,2);
										$mensaje .= "</td>";
						
										$mensaje .= "<td>";
										$mensaje .= $DatSuministro->UmeNombre;
										$mensaje .= "</td>";
										         
										$mensaje .= "<td>";										
										$mensaje .= $DatSuministro->ProCodigoOriginal;
										$mensaje .= "</td>";
				
										$mensaje .= "<td>";
										$mensaje .= $DatSuministro->ProNombre;
										$mensaje .= "</td>";
									
				
										$mensaje .= "</tr>";
										
									}

                       
                    
                    }
					
						
					$mensaje .= "</table>";
				}
		
			
			$mensaje .= "<br><br>";
			$mensaje .= "Atte.";
			
			$mensaje .= "<br><br>";
			$mensaje .= $this->PerNombreEnvio." ".$this->PerApellidoPaternoEnvio." ".$this->PerApellidoMaternoEnvio;
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"DESPACHO: PRODUCTOS ".$this->VcoId." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
			}
			
				
				
	}
	
	
	
	
	function MtdNotificarFacturarVentaConcretada($oVentaConcretadaId,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL){
	
		$InsVentaDirecta = new ClsVentaDirecta();
	
		$InsNotificacion = new ClsNotificacion();
		$InsNotificacion->UsuId = NULL;
		$InsNotificacion->UsuIdOrigen = $oUsuarioId;
		$InsNotificacion->NfnUsuario = $oUsuario;
									
		$InsNotificacion->NfnModulo = "ComprobanteVenta";
		$InsNotificacion->NfnFormulario = "MonitoreoVentaConcretada";
		$InsNotificacion->NfnDescripcion = "<b>".$oUsuario."</b> te ha enviado una venta concretada. - ".$oDescripcionAdicional;
		//$InsNotificacion->NfnEnlace = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/sistema/principal.phpMod=Pago&Form=Monitoreo&Area=ARE-10000&Moneda=MON-10000&Origen=REPUESTOS";
		//$InsNotificacion->NfnEnlace = $_SESSION['SesionUsuario']"principal.phpMod=Pago&Form=Monitoreo&Area=ARE-10000&Moneda=MON-10000&Origen=REPUESTOS";
		$InsNotificacion->NfnEnlace = "principal.php?Mod=ComprobanteVenta&Form=MonitoreoVentaConcretada&VcoId=".$oVentaConcretadaId."&Leido=1";
		$InsNotificacion->NfnEnlaceNombre = "Mostrar";
		
		$InsNotificacion->NfnTipo = 1;
		$InsNotificacion->NfnEstado = 1;
		$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
		$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
		
		$InsNotificacion->MtdRegistrarNotificacion();
								
	}
	
	
}
?>