<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPedidoCompraLlegadaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPedidoCompraLlegadaDetalle {

	public $PldId;
	public $PleId;
	public $PcdId;
	
	public $ProId;
	
	public $PldOrdenCompraId;
	public $PldOrdenCompraFecha;
	
    public $PldCantidad;
	public $PldCantidadEntregada;
	public $PldComprobanteNumero;
	public $PldComprobanteFecha;
	public $PldImporte;
	public $PldObservacion;
	
	public $PldEstado;	
	public $PldTiempoCreacion;
	public $PldTiempoModificacion;
	public $PldEliminado;

	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;


    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarPedidoCompraLlegadaDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PldId,5),unsigned)) AS "MAXIMO"
			FROM tblpldpedidocomprallegadadetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PldId = "PLD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PldId = "PLD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=NULL,$oPedidoCompraLlegadaEstado =NULL) {

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
		
		if(!empty($oPedidoCompraLlegada)){
			$amovimiento = ' AND pld.PleId = "'.$oPedidoCompraLlegada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pld.PldEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (pcd.ProId = "'.$oProducto.'") ';
		}


		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ple.PleFecha)>="'.$oFechaInicio.'" AND DATE(ple.PleFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ple.PleFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ple.PleFecha)<="'.$oFechaFin.'"';		
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
		
		
		if(!empty($oPedidoCompraDetalle)){
			$pcdetalle = ' AND (pld.PcdId = "'.$oPedidoCompraDetalle.'") ';
		}
		
		if(!empty($oPedidoCompraLlegadaEstado)){
			$pclestado = ' AND (ple.PleEstado = '.$oPedidoCompraLlegadaEstado.') ';
		}
		
		
		
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pld.PldId,			
			pld.PleId,
			pld.PcdId,

			pld.ProId,

			pld.PldOrdenCompraId,
			DATE_FORMAT(pld.PldOrdenCompraFecha, "%d/%m/%Y") AS "NPldOrdenCompraFecha",

			pld.PldCantidad,
			pld.PldCantidadEntregada,
			
			pld.PldImporte,
			pld.PldObservacion,
			
			pld.PldComprobanteNumero,
			DATE_FORMAT(pld.PldComprobanteFecha, "%d/%m/%Y") AS "NPldComprobanteFecha",
			
			pld.PldGuiaRemisionNumero,
			DATE_FORMAT(pld.PldGuiaRemisionFecha, "%d/%m/%Y") AS "NPldGuiaRemisionFecha",
			
			pld.PldObservacion,
			pld.PldEstado,
			DATE_FORMAT(pld.PldTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPldTiempoCreacion",
	        DATE_FORMAT(pld.PldTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPldTiempoModificacion",
			
			IF(pld.ProId<>pcd.ProId,"Si","No") AS PldReemplazo,
			pro2.ProCodigoOriginal AS ProCodigoReemplazado,
			
			pcd.ProId,
			pcd.UmeId,
			pcd.PcdCantidad,
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.UmeId AS "UmeIdOrigen",
			pro.RtiId,
			
			ume.UmeNombre,
			
			pco.VdiId,
			vdi.VdiOrdenCompraNumero,

			cli.CliNumeroDocumento,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			pco.OcoId,

			pcd.PcdAno,
			pcd.PcdModelo,

			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y") AS "NPleFecha",

			oco.PrvId,
			oco.OcoTipoCambio,
			
			vdd.VddEstado,
			
			vdi.VdiArchivo,
			
			per.PerNombre,
			per.PerApellidoPaterno,
			per.PerApellidoMaterno
	
			FROM tblpldpedidocomprallegadadetalle pld

				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
	
						LEFT JOIN tblvddventadirectadetalle vdd
						ON pcd.VddId = vdd.VddId
						
						LEFT JOIN tblproproducto pro
						ON pld.ProId = pro.ProId
	
							LEFT JOIN tblproproducto pro2
							ON pcd.ProId = pro2.ProId
							
							LEFT JOIN tblumeunidadmedida ume
							ON pcd.UmeId = ume.UmeId
							
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
									
									LEFT JOIN tblocoordencompra oco
									ON pco.OcoId = oco.OcoId
										
										LEFT JOIN tblvdiventadirecta vdi
										ON pco.VdiId = vdi.VdiId
										
											LEFT JOIN tblclicliente cli
											ON pco.CliId = cli.CliId
													
													LEFT JOIN tblperpersonal per
													ON vdi.PerId = per.PerId

			WHERE 1 = 1  '.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cliente.$cocompra.$pcdetalle.$pclestado .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraLlegadaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraLlegadaDetalle = new $InsPedidoCompraLlegadaDetalle();
					
			
			
                    $PedidoCompraLlegadaDetalle->PldId = $fila['PldId'];
                    $PedidoCompraLlegadaDetalle->PleId = $fila['PleId'];
					$PedidoCompraLlegadaDetalle->PcdId = $fila['PcdId'];
					
					$PedidoCompraLlegadaDetalle->ProId = $fila['ProId'];
					
					$PedidoCompraLlegadaDetalle->PldOrdenCompraId = $fila['PldOrdenCompraId'];
					$PedidoCompraLlegadaDetalle->PldOrdenCompraFecha = $fila['NPldOrdenCompraFecha'];

					$PedidoCompraLlegadaDetalle->PldCantidad = $fila['PldCantidad'];
					$PedidoCompraLlegadaDetalle->PldCantidadEntregada = $fila['PldCantidadEntregada'];
					
					$PedidoCompraLlegadaDetalle->PldImporte = $fila['PldImporte'];
					$PedidoCompraLlegadaDetalle->PldObservacion = $fila['PldObservacion'];
					
					
					$PedidoCompraLlegadaDetalle->PldComprobanteNumero = $fila['PldComprobanteNumero'];
					$PedidoCompraLlegadaDetalle->PldComprobanteFecha = $fila['NPldComprobanteFecha'];
					
					$PedidoCompraLlegadaDetalle->PldGuiaRemisionNumero = $fila['PldGuiaRemisionNumero'];
					$PedidoCompraLlegadaDetalle->PldGuiaRemisionFecha = $fila['NPldGuiaRemisionFecha'];
					
					$PedidoCompraLlegadaDetalle->PldObservacion = $fila['PldObservacion'];

					$PedidoCompraLlegadaDetalle->PldEstado = $fila['PldEstado'];
					$PedidoCompraLlegadaDetalle->PldTiempoCreacion = $fila['NPldTiempoCreacion'];  
					$PedidoCompraLlegadaDetalle->PldTiempoModificacion = $fila['NPldTiempoModificacion']; 
					
					$PedidoCompraLlegadaDetalle->PldReemplazo = $fila['PldReemplazo']; 
					$PedidoCompraLlegadaDetalle->ProCodigoReemplazado = $fila['ProCodigoReemplazado']; 		
										
										
										
										
					$PedidoCompraLlegadaDetalle->ProId = $fila['ProId'];	
					$PedidoCompraLlegadaDetalle->UmeId = $fila['UmeId'];	
					$PedidoCompraLlegadaDetalle->PcdCantidad = $fila['PcdCantidad'];
					
					$PedidoCompraLlegadaDetalle->ProNombre = (($fila['ProNombre']));
					$PedidoCompraLlegadaDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$PedidoCompraLlegadaDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					
					$PedidoCompraLlegadaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$PedidoCompraLlegadaDetalle->RtiId = (($fila['RtiId']));
					
					$PedidoCompraLlegadaDetalle->UmeNombre = (($fila['UmeNombre']));
					
				
					
					$PedidoCompraLlegadaDetalle->VdiId = (($fila['VdiId']));
					$PedidoCompraLlegadaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
					$PedidoCompraLlegadaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					$PedidoCompraLlegadaDetalle->CliNombre = (($fila['CliNombre']));
					$PedidoCompraLlegadaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$PedidoCompraLlegadaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$PedidoCompraLlegadaDetalle->OcoId = (($fila['OcoId']));
					$PedidoCompraLlegadaDetalle->PcdAno = (($fila['PcdAno']));
					$PedidoCompraLlegadaDetalle->PcdModelo = (($fila['PcdModelo']));

					$PedidoCompraLlegadaDetalle->PleFecha = (($fila['NPleFecha']));
					
					$PedidoCompraLlegadaDetalle->PrvId = (($fila['PrvId']));
					$PedidoCompraLlegadaDetalle->OcoTipoCambio = (($fila['OcoTipoCambio']));
					$PedidoCompraLlegadaDetalle->VddEstado = (($fila['VddEstado']));
					
					$PedidoCompraLlegadaDetalle->VdiArchivo = (($fila['VdiArchivo']));
					
					$PedidoCompraLlegadaDetalle->PerNombre = (($fila['PerNombre']));
					$PedidoCompraLlegadaDetalle->PerApellidoPaterno = (($fila['PerApellidoPaterno']));
					$PedidoCompraLlegadaDetalle->PerApellidoMaterno = (($fila['PerApellidoMaterno']));
					
                    $PedidoCompraLlegadaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraLlegadaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarPedidoCompraLlegadaDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				

					if(!$error) {		
						$sql = 'DELETE FROM tblpldpedidocomprallegadadetalle WHERE  (PldId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		

			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	


	public function MtdRegistrarPedidoCompraLlegadaDetalle() {
	
			$this->MtdGenerarPedidoCompraLlegadaDetalleId();
			
			$sql = 'INSERT INTO tblpldpedidocomprallegadadetalle (
			PldId,
			PleId,	
			
			PcdId,
			ProId,
			
			PldOrdenCompraId,
			PldOrdenCompraFecha,
			
			PldCantidad,
			PldCantidadEntregada,
			
			PldImporte,
			PldComprobanteNumero,
			PldComprobanteFecha,

			PldGuiaRemisionNumero,
			PldGuiaRemisionFecha,

			PldObservacion,			
			PldEstado,
			PldTiempoCreacion,
			PldTiempoModificacion
			) 
			VALUES (
			"'.($this->PldId).'", 
			"'.($this->PleId).'", 

			'.(empty($this->PcdId)?'NULL, ':'"'.$this->PcdId.'",').'
			"'.($this->ProId).'",

			"'.($this->PldOrdenCompraId).'",
			'.(empty($this->PldOrdenCompraFecha)?'NULL, ':'"'.$this->PldOrdenCompraFecha.'",').'
			
			'.($this->PldCantidad).',
			'.($this->PldCantidadEntregada).',
			
			'.($this->PldImporte).',
			"'.($this->PldComprobanteNumero).'",
			'.(empty($this->PldComprobanteFecha)?'NULL, ':'"'.$this->PldComprobanteFecha.'",').'
			
			"'.($this->PldGuiaRemisionNumero).'",
			'.(empty($this->PldGuiaRemisionFecha)?'NULL, ':'"'.$this->PldGuiaRemisionFecha.'",').'
			
			"'.($this->PldObservacion).'",
			'.($this->PldEstado).',
			"'.($this->PldTiempoCreacion).'",
			"'.($this->PldTiempoModificacion).'");';					
		
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
	
	public function MtdEditarPedidoCompraLlegadaDetalle() {

			$sql = 'UPDATE tblpldpedidocomprallegadadetalle SET 	
			ProId = "'.($this->ProId).'",

			PldOrdenCompraId = "'.($this->PldOrdenCompraId).'",
			'.(empty($this->PldOrdenCompraFecha)?'PldOrdenCompraFecha = NULL, ':'PldOrdenCompraFecha = "'.$this->PldOrdenCompraFecha.'",').'

			PldCantidad = '.($this->PldCantidad).',
			PldImporte = '.($this->PldImporte).',

			PldComprobanteNumero = "'.($this->PldComprobanteNumero).'",
			'.(empty($this->PldComprobanteFecha)?'PldComprobanteFecha = NULL, ':'PldComprobanteFecha = "'.$this->PldComprobanteFecha.'",').'
			
			PldGuiaRemisionNumero = "'.($this->PldGuiaRemisionNumero).'",
			'.(empty($this->PldGuiaRemisionFecha)?'PldGuiaRemisionFecha = NULL, ':'PldGuiaRemisionFecha = "'.$this->PldGuiaRemisionFecha.'",').'
			
			PldObservacion = "'.($this->PldObservacion).'",
			PldEstado = '.($this->PldEstado).',
			PldTiempoModificacion = "'.($this->PldTiempoModificacion).'"
			WHERE PldId = "'.($this->PldId).'";';
					
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
		
		
	//public function MtdEditarProductoDato($oCampo,$oDato,$oProductoId) {


	public function MtdEditarPedidoCompraLlegadaDetalleDato($oCampo,$oDato,$oPedidoCompraLlegadaDetalleId) {

		$sql = 'UPDATE tblpldpedidocomprallegadadetalle SET 	
		'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
		 WHERE PldId = "'.($oPedidoCompraLlegadaDetalleId).'";';
		
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