<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPedidoCompraDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPedidoCompraDetalle {

    public $PcdId;
	public $PcoId;
	public $ProId;
	public $UmeId;
	public $VddId;
	
	public $PcdCantidad;
	
	public $PcdAno;
	public $PcdModelo;
	public $PcdCodigo;
			
	public $PcdPrecio;
	public $PcdImporte;	
	
	public $PcdBOTiempoCarga;
	public $PcdBOFecha;
	public $PcdBOEstado;
	
	public $PcdAPTiempoCarga;
	public $PcdAPCantidad;

	public $PcdBSTiempoCarga;
	public $PcdBSCantidad;
	
	public $PcdEstado;

	public $PcdTiempoCreacion;
	public $PcdTiempoModificacion;
    public $PcdEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	
	public $UmeNombre;
	public $UmeIdOrigen;
	
	public $PcoTipoCambio;
	public $AmdCantidad;
	public $PcdCantidadPendiente;
	public $PcdCantidadPendienteLlegada;
	
	
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

	private function MtdGenerarPedidoCompraDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PcdId,5),unsigned)) AS "MAXIMO"
			FROM tblpcdpedidocompradetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PcdId = "PCD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PcdId = "PCD-".$fila['MAXIMO'];					
			}
				
	}
	
	
	  public function MtdObtenerPedidoCompraDetalle(){

        $sql = 'SELECT 
       pcd.PcdId,			
			pcd.PcoId,
			pcd.ProId,
			pcd.UmeId,
			pcd.VddId,
			
			pcd.PcdPrecio,
			pcd.PcdCantidad,
			
			pcd.PcdAno,
			pcd.PcdModelo,
			pcd.PcdCodigo,

			pcd.PcdImporte,
			pcd.PcdObservacion,
			
				pcd.PcdVIN,
			pcd.PcdPlaca,
			pcd.PcdOT,
			
			DATE_FORMAT(pcd.PcdBOTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBOTiempoCarga",
			DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y") AS "NPcdBOFecha",
			pcd.PcdBOEstado,
			
			DATE_FORMAT(pcd.PcdAPTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdAPTiempoCarga",
			pcd.PcdAPCantidad,
			
			DATE_FORMAT(pcd.PcdBSTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBSTiempoCarga",
			pcd.PcdBSCantidad,
			
			pcd.PcdEstado,
			DATE_FORMAT(pcd.PcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoCreacion",
	        DATE_FORMAT(pcd.PcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProRotacion,
			pro.ProPromedioDiario,
			pro.ProPromedioMensual,
			DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida",
			pro.ProDiasInmovilizado,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno
			
			FROM tblpcdpedidocompradetalle pcd
				LEFT JOIN tblproproducto pro
				ON pcd.ProId= pro.ProId
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
						
        WHERE pcd.PcdId = "'.$this->PcdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
			
				
			$this->PcdId = $fila['PcdId'];
			
			$this->PcoId = $fila['PcoId'];
			$this->ProId = $fila['ProId'];
			$this->UmeId = $fila['UmeId'];
			$this->VddId = $fila['VddId'];
			
			$this->PcdPrecio = $fila['PcdPrecio'];
			$this->PcdCantidad = $fila['PcdCantidad'];
			
			$this->PcdAno = $fila['PcdAno'];
			$this->PcdModelo = $fila['PcdModelo'];
			$this->PcdCodigo = $fila['PcdCodigo'];
			
			$this->PcdImporte = $fila['PcdImporte'];
			$this->PcdObservacion = $fila['PcdObservacion'];
			
			$this->PcdBOTiempoCarga = $fila['NPcdBOTiempoCarga'];
			$this->PcdBOFecha = $fila['NPcdBOFecha'];
			$this->PcdBOEstado = $fila['PcdBOEstado'];

			$this->PcdAPTiempoCarga = $fila['NPcdAPTiempoCarga'];
			$this->PcdAPCantidad = $fila['PcdAPCantidad'];

			$this->PcdBSTiempoCarga = $fila['NPcdBSTiempoCarga'];
			$this->PcdBSCantidad = $fila['PcdBSCantidad'];

			$this->PcdVIN = $fila['PcdVIN'];
			$this->PcdPlaca = $fila['PcdPlaca'];
			$this->PcdOT = $fila['PcdOT'];
			
	
			$this->PcdEstado = $fila['PcdEstado'];
			$this->PcdTiempoCreacion = $fila['NPcdTiempoCreacion'];
			$this->PcdTiempoModificacion = $fila['NPcdTiempoModificacion'];

			$this->ProNombre = $fila['ProNombre'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$this->ProRotacion = $fila['ProRotacion'];
			$this->ProPromedioDiario = $fila['ProPromedioDiario'];
			$this->ProPromedioMensual = $fila['ProPromedioMensual'];
			$this->ProFechaUltimaSalida = $fila['NProFechaUltimaSalida'];
			$this->ProDiasInmovilizado = $fila['ProDiasInmovilizado'];


			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

//MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
    public function MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL) {

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
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oPedidoCompra)){
			$amovimiento = ' AND pcd.PcoId = "'.$oPedidoCompra.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pcd.PcdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (pcd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'" AND DATE('.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}

		
		
		
		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		
				
			switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND pco.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND pco.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (pcd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}
		
		
		if(!empty($oPedidoCompraEstado)){
			$pcestado = ' AND (pco.PcoEstado = '.$oPedidoCompraEstado.') ';
		}
		
		
		if(($oValidarRecibido)){
			$recibida = ' AND ( 
			
				IFNULL(pcd.PcdCantidad,0) - IFNULL(
				
				
				(SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
					AND amd.AmdEstado = 3
				LIMIT 1),0
				
				) 
				
			)  > 0  ';
		}
			
			
		if(($oConFichaIngreso)){
			$fingreso = ' AND EXISTS(
			
			SELECT  

			cpr.FinId

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId AND cpr.FinId IS NOT NULL
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			
			) ';
		}
		
		
			if(!empty($oOrdenCompraEstado)){
			$ocestado = ' AND (oco.OcoEstado = '.$oOrdenCompraEstado.') ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pcd.PcdId,			
			pcd.PcoId,
			pcd.ProId,
			pcd.UmeId,
			pcd.VddId,
			
			pcd.PcdPrecio,
			pcd.PcdCantidad,
			
			pcd.PcdAno,
			pcd.PcdModelo,
			pcd.PcdCodigo,

			pcd.PcdImporte,
			pcd.PcdObservacion,
			
			DATE_FORMAT(pcd.PcdBOTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBOTiempoCarga",
			DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y") AS "NPcdBOFecha",
			pcd.PcdBOEstado,
			
			DATE_FORMAT(pcd.PcdAPTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdAPTiempoCarga",
			pcd.PcdAPCantidad,
			
			DATE_FORMAT(pcd.PcdBSTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBSTiempoCarga",
			pcd.PcdBSCantidad,
			
			pcd.PcdVIN,
			pcd.PcdPlaca,
			pcd.PcdOT,
			
			pcd.PcdEstado,
			DATE_FORMAT(pcd.PcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoCreacion",
	        DATE_FORMAT(pcd.PcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoModificacion",
			
			
			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			cli.CliNombreCompleto,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			pro.ProTieneDisponibilidadGM,
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProReferencia,
			
			pro.ProRotacion,
			
			pro.ProPromedioDiario,
			pro.ProPromedioMensual,
			pro.ProPromedioTrimestral,
			pro.ProPromedioSemestral,
			pro.ProPromedioAnual,
			
			pro.ProSalidaTotalAnual,
			pro.ProSalidaTotalTrimestral,
			pro.ProSalidaTotalSemestral,
			
			DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida",
			pro.ProDiasInmovilizado,
			
			pro.RtiId,
			ume.UmeNombre,
			pro.UmeId AS "UmeIdOrigen",

			@AmdCantidad:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amd.AmdEstado = 3
				LIMIT 1
			) AS AmdCantidad,
			

			@NodCantidad:=(
				SELECT 
				  SUM(nod.NodCantidad)
				  FROM tblnodnotacreditocompradetalle nod

					  LEFT JOIN tblamdalmacenmovimientodetalle amd
					  ON nod.AmdId = amd.AmdId

						  LEFT JOIN tblnccnotacreditocompra ncc
						  ON nod.NccId = ncc.NccId

				  WHERE amd.PcdId = pcd.PcdId
					  AND amd.AmdEstado = 3
					  AND nod.NodEstado = 3
				  LIMIT 1
			) AS NodCantidad,

						
			
			@PldCantidad:=(
				SELECT 
				SUM(pld.PldCantidad)
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1
			) AS PldCantidad,

			
			(SELECT 
				DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1				
			) AS PleFecha,
			
			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0)  + IFNULL(@NodCantidad,0)
			) AS PcdCantidadPendiente,

			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PldCantidad,0)
			) AS PcdCantidadPendienteLlegada,
			
			
			
			
			@AmdCantidadReal:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
					AND amd.AmdEstado = 3
				LIMIT 1
			),
			
			@PcdCantidadNoRecibida:=(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidadReal,0)
			) AS PcdCantidadNoRecibida,

			(
				SELECT 
				vdd.VddEstado
				FROM tblvddventadirectadetalle vdd
				WHERE pcd.VddId = vdd.VddId
				ORDER BY vdd.VddTiempoCreacion DESC
				LIMIT 1
			) AS VddEstado,
			
			pco.OcoId,
			DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
			DATEDIFF(DATE(NOW()),oco.OcoFecha) AS OcoDiaTranscurrido,
			
			DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
			
			pco.VdiId,
			pco.PcoTipoCambio,
		
			
			vdi.VdiOrdenCompraNumero,
			
			(
			SELECT  

			cpr.FinId

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinId,
			
			
			(
			SELECT  

			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y")

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinFecha,
			
			
			(
			SELECT  

			ein.EinVIN

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId
						LEFT JOIN tbleinvehiculoingreso ein
						ON fin.EinId = ein.EinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS EinVIN,
			
			(
			SELECT  

			ein.EinPlaca

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId
					LEFT JOIN tbleinvehiculoingreso ein
						ON fin.EinId = ein.EinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS EinPlaca
			
			FROM tblpcdpedidocompradetalle pcd
			
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					
				
						
						
					LEFT JOIN tblvdiventadirecta vdi
					ON pco.VdiId = vdi.VdiId
				
					LEFT JOIN tblocoordencompra oco
					ON pco.OcoId = oco.OcoId
					
					LEFT JOIN tblclicliente cli
					ON pco.CliId = cli.CliId
					
					LEFT JOIN tblproproducto pro
					ON pcd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON pcd.UmeId = ume.UmeId

			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$fingreso.$ocestado.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraDetalle = new $InsPedidoCompraDetalle();
                    $PedidoCompraDetalle->PcdId = $fila['PcdId'];
                    $PedidoCompraDetalle->PcoId = $fila['PcoId'];
					$PedidoCompraDetalle->ProId = $fila['ProId'];
					
					$PedidoCompraDetalle->UmeId = $fila['UmeId'];
					$PedidoCompraDetalle->VddId = $fila['VddId'];
					

					$PedidoCompraDetalle->PcdAno = $fila['PcdAno'];  
					$PedidoCompraDetalle->PcdModelo = $fila['PcdModelo'];  
					$PedidoCompraDetalle->PcdCodigo = $fila['PcdCodigo'];  
			
					$PedidoCompraDetalle->PcdPrecio = $fila['PcdPrecio'];  
			        $PedidoCompraDetalle->PcdCantidad = $fila['PcdCantidad'];  
					$PedidoCompraDetalle->PcdImporte = $fila['PcdImporte'];
					$PedidoCompraDetalle->PcdObservacion = $fila['PcdObservacion'];

					$PedidoCompraDetalle->PcdBOTiempoCarga = $fila['NPcdBOTiempoCarga'];
					$PedidoCompraDetalle->PcdBOFecha = $fila['NPcdBOFecha'];
					$PedidoCompraDetalle->PcdBOEstado = $fila['PcdBOEstado'];
					
					$PedidoCompraDetalle->PcdAPTiempoCarga = $fila['NPcdAPTiempoCarga'];
					$PedidoCompraDetalle->PcdAPCantidad = $fila['PcdAPCantidad'];
					
					
					$PedidoCompraDetalle->PcdBSTiempoCarga = $fila['NPcdBSTiempoCarga'];
					$PedidoCompraDetalle->PcdBSCantidad = $fila['PcdBSCantidad'];
					
					$PedidoCompraDetalle->PcdVIN = $fila['PcdVIN'];
					$PedidoCompraDetalle->PcdPlaca = $fila['PcdPlaca'];
					$PedidoCompraDetalle->PcdOT = $fila['PcdOT'];
				
					$PedidoCompraDetalle->EinVIN = $fila['EinVIN'];
					$PedidoCompraDetalle->EinPlaca = $fila['EinPlaca'];
					

					$PedidoCompraDetalle->PcdEstado = $fila['PcdEstado'];
														
					$PedidoCompraDetalle->PcdTiempoCreacion = $fila['NPcdTiempoCreacion'];  
					$PedidoCompraDetalle->PcdTiempoModificacion = $fila['NPcdTiempoModificacion']; 	
					
					$PedidoCompraDetalle->PcoFecha = $fila['NPcoFecha']; 
						
						
					$PedidoCompraDetalle->ProTieneDisponibilidadGM = $fila['ProTieneDisponibilidadGM']; 	
					$PedidoCompraDetalle->CliNombreCompleto = $fila['CliNombreCompleto']; 	
					
					$PedidoCompraDetalle->CliNombre = $fila['CliNombre']; 	
					$PedidoCompraDetalle->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
					$PedidoCompraDetalle->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
					
							
					$PedidoCompraDetalle->ProId = $fila['ProId'];	
                    $PedidoCompraDetalle->ProNombre = (($fila['ProNombre']));
					$PedidoCompraDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$PedidoCompraDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$PedidoCompraDetalle->ProReferencia = (($fila['ProReferencia']));
					
					$PedidoCompraDetalle->ProRotacion = (($fila['ProRotacion']));
					$PedidoCompraDetalle->ProPromedioDiario = (($fila['ProPromedioDiario']));
					$PedidoCompraDetalle->ProPromedioMensual = (($fila['ProPromedioMensual']));
					
					$PedidoCompraDetalle->ProPromedioTrimestral = (($fila['ProPromedioTrimestral']));
					$PedidoCompraDetalle->ProPromedioAnual = (($fila['ProPromedioAnual']));
					$PedidoCompraDetalle->ProPromedioSemestral = (($fila['ProPromedioSemestral']));
					
					
					$PedidoCompraDetalle->ProSalidaTotalAnual = (($fila['ProSalidaTotalAnual']));
					$PedidoCompraDetalle->ProSalidaTotalTrimestral = (($fila['ProSalidaTotalTrimestral']));
					$PedidoCompraDetalle->ProSalidaTotalSemestral = (($fila['ProSalidaTotalSemestral']));
						
			
					$PedidoCompraDetalle->ProFechaUltimaSalida = (($fila['NProFechaUltimaSalida']));
					$PedidoCompraDetalle->ProDiasInmovilizado = (($fila['ProDiasInmovilizado']));
	
					
					$PedidoCompraDetalle->RtiId = (($fila['RtiId']));
					
					$PedidoCompraDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$PedidoCompraDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					
					
					
					
					$PedidoCompraDetalle->PcoTipoCambio = $fila['PcoTipoCambio'];
					
					$PedidoCompraDetalle->AmdCantidad = (($fila['AmdCantidad']));
					$PedidoCompraDetalle->NodCantidad = (($fila['NodCantidad']));
					
					$PedidoCompraDetalle->PldCantidad = (($fila['PldCantidad']));
					$PedidoCompraDetalle->PleFecha = (($fila['PleFecha']));

					//$PedidoCompraDetalle->PcdCantidadPorLlegar = (($fila['PcdCantidadPorLlegar']));
					
					$PedidoCompraDetalle->PcdCantidadPendiente = (($fila['PcdCantidadPendiente']));
					
					$PedidoCompraDetalle->PcdCantidadPendienteLlegada = (($fila['PcdCantidadPendienteLlegada']));
					
					$PedidoCompraDetalle->PcdCantidadNoRecibida = (($fila['PcdCantidadNoRecibida']));
					
					$PedidoCompraDetalle->VddEstado = (($fila['VddEstado']));
					
					$PedidoCompraDetalle->OcoId = (($fila['OcoId']));
					$PedidoCompraDetalle->OcoFecha = (($fila['NOcoFecha']));
					
					$PedidoCompraDetalle->OcoDiaTranscurrido = (($fila['OcoDiaTranscurrido']));
					$PedidoCompraDetalle->OcoFechaLlegadaEstimada = (($fila['NOcoFechaLlegadaEstimada']));
					
					$PedidoCompraDetalle->VdiId = (($fila['VdiId']));
					$PedidoCompraDetalle->PcoTipoCambio = (($fila['PcoTipoCambio']));
					
					
					$PedidoCompraDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
					
					$PedidoCompraDetalle->FinId = (($fila['FinId']));
					$PedidoCompraDetalle->FinFecha = (($fila['FinFecha']));
				
				
				
				
				
				     $PedidoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
		
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarPedidoCompraDetalle($oElementos) {
		
//		$InsPedidoCompraDetalleOrigen = new ClsPedidoCompraDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (PcdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PcdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
		$sql = 'DELETE FROM tblpcdpedidocompradetalle 
		WHERE '.$eliminar;
					
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
	
	
	public function MtdRegistrarPedidoCompraDetalle() {
	
			$this->MtdGenerarPedidoCompraDetalleId();
			
			$sql = 'INSERT INTO tblpcdpedidocompradetalle (
			PcdId,
			PcoId,	
			ProId,
			
			UmeId,
			VddId,
				
			PcdAno,
			PcdModelo,
			PcdCodigo,
			
			PcdPrecio,
			PcdCantidad,
			PcdImporte,
			PcdObservacion,
			
			PcdBOTiempoCarga,
			PcdBOFecha,
			PcdBOEstado,
			
			PcdAPTiempoCarga,
			PcdAPCantidad,
			
			PcdBSTiempoCarga,
			PcdBSCantidad,
			
			PcdEstado,
			PcdTiempoCreacion,
			PcdTiempoModificacion) 
			VALUES (
			"'.($this->PcdId).'", 
			"'.($this->PcoId).'", 
			"'.($this->ProId).'", 
			
			"'.($this->UmeId).'", 
	
			'.(empty($this->VddId)?"NULL,":'"'.$this->VddId.'",').'
	
			"'.($this->PcdAno).'", 
			"'.($this->PcdModelo).'", 
			"'.($this->PcdCodigo).'", 
			
			'.($this->PcdPrecio).', 				
			'.($this->PcdCantidad).',
			'.($this->PcdImporte).', 
			"'.($this->PcdObservacion).'", 
			
			NULL,
			NULL,
			"",
			
			NULL,
			0,
			
			NULL,
			0,
							
			'.($this->PcdEstado).',
			"'.($this->PcdTiempoCreacion).'",
			"'.($this->PcdTiempoModificacion).'");';
		
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
	
	public function MtdEditarPedidoCompraDetalle() {

			$sql = 'UPDATE tblpcdpedidocompradetalle SET 
			ProId = "'.($this->ProId).'",
			UmeId = "'.($this->UmeId).'",

			PcdAno = "'.($this->PcdAno).'",
			PcdModelo = "'.($this->PcdModelo).'",
			PcdCodigo = "'.($this->PcdCodigo).'",

			PcdPrecio = '.($this->PcdPrecio).',
			PcdCantidad = '.($this->PcdCantidad).',
			PcdImporte = '.($this->PcdImporte).',
			PcdObservacion = "'.($this->PcdObservacion).'",
			
			PcdEstado = '.($this->PcdEstado).',
			
			PcdTiempoModificacion = "'.($this->PcdTiempoModificacion).'"
			WHERE PcdId = "'.($this->PcdId).'";';
				
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
		
		
		public function MtdEditarPedidoCompraDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblpcdpedidocompradetalle SET 
	
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			
			PcdTiempoModificacion = NOW()
			WHERE PcdId = "'.($oId).'";';
			
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
		
	
}
?>