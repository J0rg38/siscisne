<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPedidoCompraLlegada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPedidoCompraLlegada {

    public $PleId;
	public $PerId;
	public $PleFecha;
	
	public $PleComprobanteNumero;
	public $PleComprobanteNumeroSerie;
	public $PleComprobanteNumeroNumero;
	public $PleComprbanteFecha;

	public $PleGuiaRemisionNumero;
	public $PleGuiaRemisionNumeroSerie;
	public $PleGuiaRemisionNumeroNumero;
	public $PleGuiaRemisionFecha;
	
	public $PleEstado;
	public $PleTiempoCreacion;
	public $PleTiempoModificacion;
    public $PleEliminado;

	public $PedidoCompraLlegadaDetalle;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarPedidoCompraLlegadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ple.PleId,5),unsigned)) AS "MAXIMO"
		FROM tblplepedidocomprallegada ple
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->PleId = "PLE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->PleId = "PLE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerPedidoCompraLlegada(){

        $sql = 'SELECT 
        ple.PleId,  
		ple.PerId,
		DATE_FORMAT(ple.PleFecha, "%d/%m/%Y") AS "NPleFecha",
		
		ple.PleObservacion,
		ple.PleEstado,
		DATE_FORMAT(ple.PleTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPleTiempoCreacion",
        DATE_FORMAT(ple.PleTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPleTiempoModificacion",
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tblplepedidocomprallegada ple
			LEFT JOIN tblperpersonal per
			ON ple.PerId = per.PerId
		
        WHERE ple.PleId = "'.$this->PleId.'" ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
				
			$this->PleId = $fila['PleId'];
			$this->PerId = $fila['PerId'];		
			$this->PleFecha = $fila['NPleFecha'];
			
			$this->PleObservacion = $fila['PleObservacion'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			$this->PleEstado = $fila['PleEstado'];
			$this->PleTiempoCreacion = $fila['NPleTiempoCreacion']; 
			$this->PleTiempoModificacion = $fila['NPleTiempoModificacion']; 	

			$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
			$ResPedidoCompraLlegadaDetalle =  $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,NULL,NULL,1,NULL,$this->PleId);
			$this->PedidoCompraLlegadaDetalle = 	$ResPedidoCompraLlegadaDetalle['Datos'];	
			

			switch($this->PleEstado){
					
						case 1:
							$Estado = "Pendiente";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
						
						case 31:
							$Estado = "Correo Enviado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
				
			$this->PleEstadoDescripcion = $Estado;
			
			
			//switch($this->PleEstado){
//			
//				case 1:
//					$Estado = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
//				break;
//			
//				case 3:
//					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/realizado.gif" />';						
//				break;	
//				
//				default:
//					$Estado = "";
//				break;
//			
//			}
//				
//			$this->PleEstadoIcono = $Estado;




		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPedidoCompraLlegadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PleId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oOrdenCompra=NULL) {

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
					pld.PldId
					FROM tblpldpedidocomprallegadadetalle pld
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
							LEFT JOIN tblproproducto pro
							ON pcd.ProId = pro.ProId
					WHERE 
						pld.PleId = ple.PleId AND 
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
				$fecha = ' AND DATE(ple.PleFecha)>="'.$oFechaInicio.'" AND DATE(ple.PleFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ple.PleFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ple.PleFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND ple.PleEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND oco.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND ple.PerId = "'.$oOrdenCompra.'"';
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ple.PleId,				
				ple.PerId,

				DATE_FORMAT(ple.PleFecha, "%d/%m/%Y") AS "NPleFecha",
				
				ple.PleObservacion,
				ple.PleEstado,
				DATE_FORMAT(ple.PleTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPleTiempoCreacion",
	        	DATE_FORMAT(ple.PleTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPleTiempoModificacion",
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tblplepedidocomprallegada ple
					LEFT JOIN tblperpersonal per
					ON ple.PerId = per.PerId
					
				WHERE 1 = 1  '.$filtrar.$fecha.$estado.$moneda.$pcompra.$ocompra.$pcompradetalle.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraLlegada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraLlegada = new $InsPedidoCompraLlegada();
                    $PedidoCompraLlegada->PleId = $fila['PleId'];
					$PedidoCompraLlegada->PerId = $fila['PerId'];
					$PedidoCompraLlegada->PleFecha = $fila['NPleFecha'];
					
				
					$PedidoCompraLlegada->PleObservacion = $fila['PleObservacion'];
					$PedidoCompraLlegada->PleFecha = $fila['NPleFecha'];
					$PedidoCompraLlegada->PleEstado = $fila['PleEstado'];
					$PedidoCompraLlegada->PleTiempoCreacion = $fila['NPleTiempoCreacion'];  
					$PedidoCompraLlegada->PleTiempoModificacion = $fila['NPleTiempoModificacion'];
					
					$PedidoCompraLlegada->PerNombre = $fila['PerNombre'];
					$PedidoCompraLlegada->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$PedidoCompraLlegada->PerApellidoMaterno = $fila['PerApellidoMaterno']; 

					switch($PedidoCompraLlegada->PleEstado){
					
						case 1:
							$Estado = "Pendiente";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
						
						case 31:
							$Estado = "Correo Enviado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$PedidoCompraLlegada->PleEstadoDescripcion = $Estado;
					
//					switch($PedidoCompraLlegada->PleEstado){
//					
//						case 1:
//							$Estado = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/pendiente.gif" />';
//						break;
//					
//						case 3:
//							$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/realizado.gif" />';						
//						break;	
//						
//						case 31:
//							$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/realizado.gif" />';						
//						break;	
//						
//						
//						default:
//							$Estado = "";
//						break;
//					
//					}
//						
//					$PedidoCompraLlegada->PleEstadoIcono = $Estado;


                    $PedidoCompraLlegada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraLlegada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarPedidoCompraLlegada($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){

// MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL)


					$ResPedidoCompraLlegadaDetalle = $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,'PldId','DESC',1,NULL,$elemento);
					$ArrPedidoCompraLlegadaDetalles = $ResPedidoCompraLlegadaDetalle['Datos'];

					if(!empty($ArrPedidoCompraLlegadaDetalles)){
						$amdetalle = '';

						foreach($ArrPedidoCompraLlegadaDetalles as $DatPedidoCompraLlegadaDetalle){
							$amdetalle .= '#'.$DatPedidoCompraLlegadaDetalle->PldId;
						}

						if(!$InsPedidoCompraLlegadaDetalle->MtdEliminarPedidoCompraLlegadaDetalle($amdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
							//$this->PleId = $elemento;
							//$this->MtdObtenerPedidoCompraLlegada();


						$sql = 'DELETE FROM tblplepedidocomprallegada WHERE  (PleId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        


					
						if(!$resultado) {						
							$error = true;
						}else{
							
							
							//if(!empty($this->PerId)){
//								$InsOrdenCompra = new ClsOrdenCompra();
//								$InsOrdenCompra->MtdActualizarEstadoOrdenCompra($this->PerId,3);
//							}
							
							$this->MtdAuditarPedidoCompraLlegada(3,"Se elimino la Llegada de Pedido de Compra",$elemento);		
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
	public function MtdActualizarEstadoPedidoCompraLlegada($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
		//$InsPedidoCompraLlegadaDetalles = new ClsPedidoCompraLlegadaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblplepedidocomprallegada SET PleEstado = '.$oEstado.' WHERE PleId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarPedidoCompraLlegada(2,"Se actualizo el Estado de la Llegada de Pedido de Compra",$elemento);
				
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
	
	
	public function MtdRegistrarPedidoCompraLlegada() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarPedidoCompraLlegadaId();
			
			$sql = 'INSERT INTO tblplepedidocomprallegada (
			PleId,	
			PerId,
			PleFecha,
			
			PleObservacion,
			PleEstado,			
			PleTiempoCreacion,
			PleTiempoModificacion) 
			VALUES (
			"'.($this->PleId).'", 
			
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			
			"'.($this->PleFecha).'", 
			
		
			"'.($this->PleObservacion).'", 
			'.($this->PleEstado).',
			"'.($this->PleTiempoCreacion).'", 				
			"'.($this->PleTiempoModificacion).'");';			
		
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {							
				$error = true;
			} 

			if(!$error){			
			
				if (!empty($this->PedidoCompraLlegadaDetalle)){		
						
					$validar = 0;				
					$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();		
					
					foreach ($this->PedidoCompraLlegadaDetalle as $DatPedidoCompraLlegadaDetalle){
					
						$InsPedidoCompraLlegadaDetalle->PleId = $this->PleId;
						$InsPedidoCompraLlegadaDetalle->PcdId = $DatPedidoCompraLlegadaDetalle->PcdId;
						$InsPedidoCompraLlegadaDetalle->ProId = $DatPedidoCompraLlegadaDetalle->ProId;	
						
						$InsPedidoCompraLlegadaDetalle->PldOrdenCompraId = $DatPedidoCompraLlegadaDetalle->PldOrdenCompraId;						
						$InsPedidoCompraLlegadaDetalle->PldOrdenCompraFecha = $DatPedidoCompraLlegadaDetalle->PldOrdenCompraFecha;						
						
						$InsPedidoCompraLlegadaDetalle->PldCantidad = $DatPedidoCompraLlegadaDetalle->PldCantidad;						
						$InsPedidoCompraLlegadaDetalle->PldCantidadEntregada = $DatPedidoCompraLlegadaDetalle->PldCantidadEntregada;
						
						$InsPedidoCompraLlegadaDetalle->PldComprobanteNumero = $DatPedidoCompraLlegadaDetalle->PldComprobanteNumero;						
						$InsPedidoCompraLlegadaDetalle->PldComprobanteFecha = $DatPedidoCompraLlegadaDetalle->PldComprobanteFecha;						
						
						$InsPedidoCompraLlegadaDetalle->PldGuiaRemisionNumero = $DatPedidoCompraLlegadaDetalle->PldGuiaRemisionNumero;						
						$InsPedidoCompraLlegadaDetalle->PldGuiaRemisionFecha = $DatPedidoCompraLlegadaDetalle->PldGuiaRemisionFecha;			
						
						$InsPedidoCompraLlegadaDetalle->PldObservacion = $DatPedidoCompraLlegadaDetalle->PldObservacion;
						$InsPedidoCompraLlegadaDetalle->PldImporte = $DatPedidoCompraLlegadaDetalle->PldImporte;
						$InsPedidoCompraLlegadaDetalle->PldEstado = $DatPedidoCompraLlegadaDetalle->PldEstado;									
						$InsPedidoCompraLlegadaDetalle->PldTiempoCreacion = $DatPedidoCompraLlegadaDetalle->PldTiempoCreacion;
						$InsPedidoCompraLlegadaDetalle->PldTiempoModificacion = $DatPedidoCompraLlegadaDetalle->PldTiempoModificacion;						
						$InsPedidoCompraLlegadaDetalle->PldEliminado = $DatPedidoCompraLlegadaDetalle->PldEliminado;

						if($InsPedidoCompraLlegadaDetalle->MtdRegistrarPedidoCompraLlegadaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_PLE_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					
					
					if(count($this->PedidoCompraLlegadaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
										
		
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarPedidoCompraLlegada(1,"Se registro la Llegada de Pedido de Compra",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarPedidoCompraLlegada() {

			global $Resultado;
			$error = false;
			
			$sql = 'UPDATE tblplepedidocomprallegada SET
			PleFecha = "'.($this->PleFecha).'",
			
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'			
			PleObservacion = "'.($this->PleObservacion).'",
			PleEstado = '.($this->PleEstado).',
			PleTiempoModificacion = "'.($this->PleTiempoModificacion).'"
			WHERE PleId = "'.($this->PleId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		

			if(!$error){
			
				if (!empty($this->PedidoCompraLlegadaDetalle)){		
						
					$validar = 0;				
					$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
							
					foreach ($this->PedidoCompraLlegadaDetalle as $DatPedidoCompraLlegadaDetalle){
										
						$InsPedidoCompraLlegadaDetalle->PldId = $DatPedidoCompraLlegadaDetalle->PldId;
						$InsPedidoCompraLlegadaDetalle->PleId = $this->PleId;
						$InsPedidoCompraLlegadaDetalle->PcdId = $DatPedidoCompraLlegadaDetalle->PcdId;
						$InsPedidoCompraLlegadaDetalle->ProId = $DatPedidoCompraLlegadaDetalle->ProId;
						
						$InsPedidoCompraLlegadaDetalle->PldOrdenCompraId = $DatPedidoCompraLlegadaDetalle->PldOrdenCompraId;						
						$InsPedidoCompraLlegadaDetalle->PldOrdenCompraFecha = $DatPedidoCompraLlegadaDetalle->PldOrdenCompraFecha;	
						
						$InsPedidoCompraLlegadaDetalle->PldCantidad = $DatPedidoCompraLlegadaDetalle->PldCantidad;
						$InsPedidoCompraLlegadaDetalle->PldCantidadEntregada = $DatPedidoCompraLlegadaDetalle->PldCantidadEntregada;
						
						$InsPedidoCompraLlegadaDetalle->PldComprobanteNumero = $DatPedidoCompraLlegadaDetalle->PldComprobanteNumero;						
						$InsPedidoCompraLlegadaDetalle->PldComprobanteFecha = $DatPedidoCompraLlegadaDetalle->PldComprobanteFecha;			
						
						$InsPedidoCompraLlegadaDetalle->PldGuiaRemisionNumero = $DatPedidoCompraLlegadaDetalle->PldGuiaRemisionNumero;						
						$InsPedidoCompraLlegadaDetalle->PldGuiaRemisionFecha = $DatPedidoCompraLlegadaDetalle->PldGuiaRemisionFecha;			
						
						$InsPedidoCompraLlegadaDetalle->PldImporte = $DatPedidoCompraLlegadaDetalle->PldImporte;	
								
						$InsPedidoCompraLlegadaDetalle->PldObservacion = $DatPedidoCompraLlegadaDetalle->PldObservacion;
						$InsPedidoCompraLlegadaDetalle->PldEstado = $DatPedidoCompraLlegadaDetalle->PldEstado;
						$InsPedidoCompraLlegadaDetalle->PldTiempoCreacion = $DatPedidoCompraLlegadaDetalle->PldTiempoCreacion;
						$InsPedidoCompraLlegadaDetalle->PldTiempoModificacion = $DatPedidoCompraLlegadaDetalle->PldTiempoModificacion;
						$InsPedidoCompraLlegadaDetalle->PldEliminado = $DatPedidoCompraLlegadaDetalle->PldEliminado;
						
						if(empty($InsPedidoCompraLlegadaDetalle->PldId)){
							if($InsPedidoCompraLlegadaDetalle->PldEliminado<>2){
								if($InsPedidoCompraLlegadaDetalle->MtdRegistrarPedidoCompraLlegadaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PLE_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsPedidoCompraLlegadaDetalle->PldEliminado==2){
								if($InsPedidoCompraLlegadaDetalle->MtdEliminarPedidoCompraLlegadaDetalle($InsPedidoCompraLlegadaDetalle->PldId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PLE_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsPedidoCompraLlegadaDetalle->MtdEditarPedidoCompraLlegadaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PLE_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->PedidoCompraLlegadaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
				
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPedidoCompraLlegada(2,"Se edito la Llegada de Pedido de Compra",$this);		
				return true;
			}	
				
		}
		
		



	public function MtdObtenerPedidoCompraLlegadaNumeroComprobantes($oPedidoCompraLlegada=NULL,$oOrden=NULL,$oSentido=NULL) {

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		if(!empty($oPedidoCompraLlegada)){
			$pcllegada = ' AND pld.PleId = "'.$oPedidoCompraLlegada.'"';
		}
		
		$sql = 'SELECT
		SELECT 
		
		oco.PrvId,
		oco.MonId,
		oco.OcoTipoCambio,
		pld.PldComprobanteNumero 
		
		FROM tblpldpedidocomprallegadadetalle pld
			
			LEFT JOIN tblpcdpedidocompradetalle pcd
			ON pld.PcdId = pcd.PcdId
			
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					
					LEFT JOIN tblocoordencompra oco
					ON pco.PerId = oco.PerId
					
		WHERE 1 = 1 '.$pcllegada.$orden.' GROUP BY PldComprobanteNumero '.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraLlegada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraLlegada = new $InsPedidoCompraLlegada();

					$PedidoCompraLlegada->PrvId = $fila['PrvId'];
					$PedidoCompraLlegada->MonId = $fila['MonId'];
					$PedidoCompraLlegada->OcoTipoCambio = $fila['OcoTipoCambio'];
					$PedidoCompraLlegada->PleComprobanteNumero = $fila['PleComprobanteNumero'];

                    $PedidoCompraLlegada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraLlegada;
                }
			
			return $Respuesta;			
		}
		
		
		
		
		public function MtdGenerarMovimientoEntrada($oPedidoCompraLlegada){

			global $EmpresaImpuestoVenta;
			
			$this->PclId = $oPedidoCompraLlegada;
			$this->MtdObtenerPedidoCompraLlegada();
							
							
			$ResPedidoCompraLlegadaComprobante = $this->MtdObtenerPedidoCompraLlegadaNumeroComprobantes($oPedidoCompraLlegada,"PleComprobanteNumero","ASC");
			$ArrPedidoCompraLlegadaComprobantes = $ResPedidoCompraLlegadaComprobante['Datos'];
			
			if(!empty($ArrPedidoCompraLlegadaComprobantes)){
				foreach($ArrPedidoCompraLlegadaComprobantes as $DatPedidoCompraLlegadaComprobante){
				
					if(!empty($DatPedidoCompraLlegadaComprobante->PleComprobanteNumero)){
						
						$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();	
						$AlmacenMovimientoEntradaId = $InsAlmacenMovimientoEntrada->MtdVerificarExisteAlmacenMovimientoEntrada("AmoComprobanteNumero",$DatPedidoCompraLlegadaComprobante->PleComprobanteNumero,$DatPedidoCompraLlegadaComprobante->PrvId);
						
						if(empty($AlmacenMovimientoEntradaId)){

							$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
							
							$InsAlmacenMovimientoEntrada->PrvId = $DatPedidoCompraLlegadaComprobante->PrvId;
							$InsAlmacenMovimientoEntrada->CtiId = "CTI-10000";	
							$InsAlmacenMovimientoEntrada->TopId = "TOP-10001";	
							$InsAlmacenMovimientoEntrada->PerId = $DatPedidoCompraLlegadaComprobante->PerId;	

							$InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
							$InsAlmacenMovimientoEntrada->AmoFecha = date("Y-m-d");
							$InsAlmacenMovimientoEntrada->AmoObservacion = "Movimiento de Entrada registrado automaticamente";
							$InsAlmacenMovimientoEntrada->AmoDocumentoOrigen = 1;
							
							
							$InsAlmacenMovimientoEntrada->AmoComprobanteNumero = $DatPedidoCompraLlegadaComprobante->PleComprobanteNumero;
							$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaAMysql($DatPedidoCompraLlegadaComprobante->PleComprobanteFecha);	
						

						
							$InsAlmacenMovimientoEntrada->MonId = $DatPedidoCompraLlegadaComprobante->MonId;
							$InsAlmacenMovimientoEntrada->AmoTipoCambio = $DatPedidoCompraLlegadaComprobante->OcoTipoCambio;

							$InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto = 1;
						
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem =0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = 0;
							$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = 0;
						
							$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo =0;
							$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = 0;
							$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = 0;
									
							$InsAlmacenMovimientoEntrada->AmoTotalInternacional = 0;
							
							$InsAlmacenMovimientoEntrada->AmoTotalNacional = 0;
							
							$InsAlmacenMovimientoEntrada->AmoMargenUtilidad = 0.00;
							$InsAlmacenMovimientoEntrada->AmoTipo = 1;
							$InsAlmacenMovimientoEntrada->AmoSubTipo = 1;

							$InsAlmacenMovimientoEntrada->NpaId = "NPA-10002";
							$InsAlmacenMovimientoEntrada->AmoCantidadDia = 0;

							$InsAlmacenMovimientoEntrada->AmoEstado = 3;

							$InsAlmacenMovimientoEntrada->AmoTiempoCreacion = date("Y-m-d H:i:s");
							$InsAlmacenMovimientoEntrada->AmoTiempoModificacion = date("Y-m-d H:i:s");
							$InsAlmacenMovimientoEntrada->AmoEliminado = 1;

							$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle = array();

							$InsAlmacenMovimientoEntrada->AmoTotalBruto = 0;
							$InsAlmacenMovimientoEntrada->AmoSubTotal = 0;
							$InsAlmacenMovimientoEntrada->AmoImpuesto = 0;
							$InsAlmacenMovimientoEntrada->AmoTotal = 0;
							
							$InsAlmacenMovimientoEntrada->AmoValorTotal = 0;	
							

							if(!empty($this->PedidoCompraLlegadaDetalle)){
								foreach($this->PedidoCompraLlegadaDetalle as $DatPedidoCompraLlegadaDetalle){
									
									$InsAlmacenMovimientoEntradaDetalle1 = new ClsAlmacenMovimientoEntradaDetalle();
									$InsAlmacenMovimientoEntradaDetalle1->ProId = $DatPedidoCompraLlegadaDetalle->ProId;
									$InsAlmacenMovimientoEntradaDetalle1->UmeId = "UME-10007";
						
									$InsAlmacenMovimientoEntradaDetalle1->AmdIdAnterior = NULL;//$InsAlmacenMovimientoEntradaDetalle1->MtdObtenerUltimoAlmacenMovimientoEntradaDetalleId($InsAlmacenMovimientoEntradaDetalle1->ProId,$InsAlmacenMovimientoEntrada->AmoFecha);
										
									$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdCantidad = $DatPedidoCompraLlegadaDetalle->PldCantidad;
									$InsAlmacenMovimientoEntradaDetalle1->AmdCantidadReal = $DatPedidoCompraLlegadaDetalle->PldCantidad;
									$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidadPorcentaje = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = 0;
								
									$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatPedidoCompraLlegadaDetalle->PldImporte;
									
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduana = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalTransporte = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalDesestiba = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAlmacenaje =0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAdValorem =0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduanaNacional = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalGastoAdministrativo = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto1 =0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto2 =0;
									
									$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete =0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto =0;
						
									$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
									$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
									$InsAlmacenMovimientoEntradaDetalle1->AmdEliminado = 1;
									$InsAlmacenMovimientoEntradaDetalle1->InsMysql = NULL;
									
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraUnitario = 0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal =  0;
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoPromedio = 0;
									
									$InsAlmacenMovimientoEntradaDetalle1->PcdId =  $DatPedidoCompraLlegadaDetalle->PcdId;
									$InsAlmacenMovimientoEntradaDetalle1->PcoId =  $DatPedidoCompraLlegadaDetalle->PcoId;
									$InsAlmacenMovimientoEntradaDetalle1->PcoFecha =  $DatPedidoCompraLlegadaDetalle->PcoFecha;
									$InsAlmacenMovimientoEntradaDetalle1->CliNombreCompleto =  $DatPedidoCompraLlegadaDetalle->CliNombreCompleto;
									
												
									$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle[] = $InsAlmacenMovimientoEntradaDetalle1;	
										
									$InsAlmacenMovimientoEntrada->AmoSubTotal += $InsAlmacenMovimientoEntradaDetalle1->AmdImporte;			
																		
								}
							}
							
							$InsAlmacenMovimientoEntrada->AmoImpuesto = round( ($InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo) * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),3);
							$InsAlmacenMovimientoEntrada->AmoTotal = $InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + $InsAlmacenMovimientoEntrada->AmoImpuesto;
						
						
							
						}else{
							
						}
						
					}
					
				}					
			}
				
				
		}
		
		
		
		
		
	public function MtdEnviarDespachoPedidoCompraLlegada($oDestinatario,$oPedidoCompraLlegadaId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAtentamente=NULL){
		
		
		//echo "test";
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->PleId = $oPedidoCompraLlegadaId;
			$this->MtdObtenerPedidoCompraLlegada();
			
//			deb("test");
	//		deb($oPedidoCompraLlegadaId);
			
			$Enviar = false;
			$Respuesta = true;
			
			$mensaje .= "INFORME DE DESPACHO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Fecha de informe:</b> ".date("d/m/Y")."";	
			
			$mensaje .= "<br>";		
			$mensaje .= "<br>";		
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			$mensaje .= "<br>";				
			$mensaje .= "Se envia informe de despacho de los repuestos solicitados:";
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha de Despacho:</b> ".$this->PleFecha."";
			$mensaje .= "<br>";	
			$mensaje .= "<b>Observaciones:</b> ".$this->PleObservacion."";
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				if(!empty($this->PedidoCompraLlegadaDetalle)){
				
					$mensaje .= "<table cellpadding='4' cellspacing='0' width='100%' border='1'>";
					$mensaje .= "<tr>";

						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>ORD. COMPRA</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>FACT</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>GUIA REM.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>COD. ORIG.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>COD. REEMP.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>CANT</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>NOMBRE</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>AÑO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>MODELO</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>CIENTE</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>ORD. VEN.</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>REF.</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>OBS.</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>ESTADO O.V.</b>";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>SOLICITANTE</b>";
						$mensaje .= "</td>";	
											
					$mensaje .= "</tr>";
					
			//		deb($this->PedidoCompraLlegadaDetalle);
					
					$i = 1;
					if (!empty($this->PedidoCompraLlegadaDetalle)) {
						foreach ($this->PedidoCompraLlegadaDetalle as $DatPedidoCompraLlegadaDetalle) {
																
							$mensaje .= "<tr>";
									
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								if(empty($DatPedidoCompraLlegadaDetalle->PcdId)){
									$mensaje .= ($DatPedidoCompraLlegadaDetalle->PcdOrdenCompraId);
								}else{
									$mensaje .= ($DatPedidoCompraLlegadaDetalle->OcoId);
								}				
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->PldComprobanteNumero;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->PldGuiaRemisionNumero;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								if($DatPedidoCompraLlegadaDetalle->PldReemplazo == "Si"){
									$mensaje .= ($DatPedidoCompraLlegadaDetalle->ProCodigoReemplazado);
								}                
								$mensaje .= "</td>";						
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraLlegadaDetalle->PldCantidad,2);
								$mensaje .= "</td>";
								
								
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->ProNombre;
								$mensaje .= "</td>";
								
		
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->PcdAno;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraLlegadaDetalle->PcdModelo;
								$mensaje .= "</td>";
		
		
								$mensaje .= "<td>";
								$mensaje .= ($DatPedidoCompraLlegadaDetalle->CliNombre)." ".($DatPedidoCompraLlegadaDetalle->CliApellidoPaterno)." ".($DatPedidoCompraLlegadaDetalle->CliApellidoMaterno);
								$mensaje .= "</td>";
		
		
								$mensaje .= "<td>";
								$mensaje .= ($DatPedidoCompraLlegadaDetalle->VdiId);
								$mensaje .= "</td>";
		
		
								$mensaje .= "<td>";
								$mensaje .= ($DatPedidoCompraLlegadaDetalle->VdiOrdenCompraNumero);
								$mensaje .= "</td>";
		
								$mensaje .= "<td>";
								$mensaje .= ($DatPedidoCompraLlegadaDetalle->PldObservacion);
								$mensaje .= "</td>";
										
								$mensaje .= "<td>";
								switch($DatPedidoCompraLlegadaDetalle->VddEstado){
									case 1:
										$mensaje .= "CONSIDERAR";
									break;
									
									case 2:
											$mensaje .= "ANULADO";
									break;
								
									case 3:
											$mensaje .= "INTERNO";
									break;
									
									case 4:
											$mensaje .= "DEVOLUCION";
									break;
									
									case 5:
											$mensaje .= "DAÑADO";
									break;
									
									default:
											$mensaje .= "-";
									break;
								}
								$mensaje .= "</td>";
								
		
								$mensaje .= "<td>";
								$mensaje .= ($DatPedidoCompraLlegadaDetalle->PerNombre)." ".($DatPedidoCompraLlegadaDetalle->PerApellidoPaterno)." ".($DatPedidoCompraLlegadaDetalle->PerApellidoMaterno);
								$mensaje .= "</td>";
								
							$mensaje .= "</tr>";
					
									 $i++;
            			
							$Enviar = true;
										
						 }
					}


						
					$mensaje .= "</table>";
				}
		
			
			$mensaje .= "<br><br>";
			$mensaje .= "Atte.";
			
			$mensaje .= "<br><br>";
			$mensaje .= $oAtentamente;
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			
		//	deb($oDestinatario);
//			deb($Enviar);
//			
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"INFORME DESPACHO - ".$this->PleFecha,$mensaje);
				
			}
			
			
			return $Respuesta;
				
	}
	
	
	
		private function MtdAuditarPedidoCompraLlegada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->PleId;

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
		
		
		
		
		
		
}
?>