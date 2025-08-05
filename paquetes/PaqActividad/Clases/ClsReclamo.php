<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReclamo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReclamo {

    public $RecId;
	public $RecAno;
	
	public $PerId;
	public $PrvId;
	public $AmoId;
	
	public $RecCodigoReclamo;
	public $RecFechaEmision;
	
	public $RecCliente;
	public $RecPais;
	public $RecSucursal;
	
	public $MonId;
	public $RecTipoCambio;

	public $RecTotal;
	
	public $RecObservacion;
	public $RecObservacionImpresa;

	public $RecRespuestaNumero;
	public $RecRespuestaFecha;
	public $RecEstado;
	public $RecTiempoCreacion;
	public $RecTiempoModificacion;
    public $RecEliminado;
	
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $TdoId;
	
	public $OcoId;
	public $AmoComprobanteNumero;
	public $AmoFoto;
	
	public $ReclamoDetalle;
	public $ReclamoFoto;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarReclamoId() {

	

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(rec.RecId,5),unsigned)) AS "MAXIMO"
			FROM tblrecreclamo rec';
				
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RecId ="REC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RecId = "REC-".$fila['MAXIMO'];					
			}		
		}
		
    public function MtdObtenerReclamo($oCompleto=true){

        $sql = 'SELECT 
        rec.RecId,
		rec.RecAno,
		
		rec.PerId,
		rec.PrvId,
		rec.AmoId,
		
		rec.RecCodigoReclamo,
		DATE_FORMAT(rec.RecFechaEmision, "%d/%m/%Y") AS "NRecFechaEmision",
	
		rec.RecCliente,
		rec.RecPais,
		rec.RecSucursal,
		
		rec.MonId,
		rec.RecTipoCambio,

		
		
		rec.RecTotal,
	
		rec.RecObservacion,
		rec.RecObservacionImpresa,
		
		rec.RecRespuestaNumero,
		DATE_FORMAT(rec.RecRespuestaFecha, "%d/%m/%Y") AS "NRecRespuestaFecha",
		
		rec.RecEstado,
		DATE_FORMAT(rec.RecTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRecTiempoCreacion",
        DATE_FORMAT(rec.RecTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRecTiempoModificacion",
		
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId,
			
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				amo.AmoComprobanteNumero,
				amo.OcoId,
				amo.AmoFoto

				FROM tblrecreclamo rec
					LEFT JOIN tblprvproveedor prv
					ON rec.PrvId = prv.PrvId
						LEFT JOIN tblperpersonal per
						ON rec.PerId = per.PerId
							LEFT JOIN tblmonmoneda mon
							ON rec.MonId = mon.MonId
								LEFT JOIN tblamoalmacenmovimiento amo
								ON rec.AmoId = amo.AmoId
			
        WHERE rec.RecId = "'.$this->RecId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->RecId = $fila['RecId'];
			$this->RecAno = $fila['RecAno'];
			
			$this->PerId = $fila['PerId'];
			$this->PrvId = $fila['PrvId'];
			$this->AmoId = $fila['AmoId'];
			
			$this->RecCodigoReclamo = $fila['RecCodigoReclamo'];
			$this->RecFechaEmision = $fila['NRecFechaEmision'];
			
			$this->RecCliente = $fila['RecCliente'];
			$this->RecPais = $fila['RecPais'];
			$this->RecSucursal = $fila['RecSucursal'];
			
			$this->MonId = $fila['MonId'];
			$this->RecTipoCambio = $fila['RecTipoCambio'];

			$this->RecTotal = $fila['RecTotal'];
			
			$this->RecObservacion = $fila['RecObservacion'];
			$this->RecObservacionImpresa = $fila['RecObservacionImpresa'];
			
	
		$this->RecRespuestaNumero = $fila['RecRespuestaNumero'];
		$this->RecRespuestaFecha = $fila['NRecRespuestaFecha'];
		
			$this->RecEstado = $fila['RecEstado'];
			$this->RecTiempoCreacion = $fila['NRecTiempoCreacion']; 
			$this->RecTiempoModificacion = $fila['NRecTiempoModificacion'];
			
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
		
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
			$this->OcoId = $fila['OcoId'];
			$this->AmoFoto = $fila['AmoFoto'];
			
			switch($this->RecEstado){
				
				case 1:
							$this->RecEstadoDescripcion =  "Pendiente";
						break;
						
						case 5:
							$this->RecEstadoDescripcion =  "Enviado";
						break;
						
						case 6:
							$this->RecEstadoDescripcion =  "Anulado";
						break;
						
						case 7:
							$this->RecEstadoDescripcion =  "Recepcionado";
						break;
						
						case 8:
							$this->RecEstadoDescripcion =  "Atendido";
						break;
						
						case 9:
							$this->RecEstadoDescripcion =  "C/ Nota Credito";
						break;
			}
                    
			if($oCompleto){
				
				
				$InsReclamoDetalle = new ClsReclamoDetalle();
				$ResReclamoDetalle = $InsReclamoDetalle->MtdObtenerReclamoDetalles(NULL,NULL,"RdeId","ASC",NULL,$this->RecId,NULL);
				$this->ReclamoDetalle = $ResReclamoDetalle['Datos'];	
	
	
				$InsReclamoFoto = new ClsReclamoFoto();
				$ResReclamoFoto =  $InsReclamoFoto->MtdObtenerReclamoFotos(NULL,NULL,"RfoId","ASC",NULL,$this->RecId,NULL);
				$this->ReclamoFoto = 	$ResReclamoFoto['Datos'];	
				
				
				
			}
                                      
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerReclamos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RecId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCodigoReclamo=NULL) {

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
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(rec.RecFechaEmision)>="'.$oFechaInicio.'" AND DATE(rec.RecFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(rec.RecFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(rec.RecFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (rec.RecEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}
			
			$estado .= ' ) 
			)
			';

		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND rec.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCodigoReclamo)){
			$creclamo = ' AND rec.RecCodigoReclamo = "'.$oCodigoReclamo.'"';
		}	

			$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					rec.RecId,
					rec.RecAno,
					
					rec.PerId,
					rec.PrvId,
					rec.AmoId,
					
					rec.RecCodigoReclamo,
					DATE_FORMAT(rec.RecFechaEmision, "%d/%m/%Y") AS "NRecFechaEmision",
				
					rec.RecCliente,
					rec.RecPais,
					rec.RecSucursal,

					rec.MonId,
					rec.RecTipoCambio,
					
					rec.RecTotal,
					
					rec.RecObservacion,
					rec.RecObservacionImpresa,
					
					rec.RecRespuestaNumero,
					DATE_FORMAT(rec.RecRespuestaFecha, "%d/%m/%Y") AS "NRecRespuestaFecha",
		
					rec.RecEstado,
					DATE_FORMAT(rec.RecTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRecTiempoCreacion",
					DATE_FORMAT(rec.RecTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRecTiempoModificacion",
					
					prv.PrvNombre,
					prv.PrvApellidoPaterno,
					prv.PrvApellidoMaterno,
					prv.PrvNumeroDocumento,
					prv.TdoId,
					
					amo.AmoComprobanteNumero,
					amo.OcoId
			
				FROM tblrecreclamo rec
					LEFT JOIN tblprvproveedor prv
					ON rec.PrvId = prv.PrvId
						LEFT JOIN tblamoalmacenmovimiento amo
						ON rec.AmoId = amo.AmoId

				WHERE 1 = 1 '.$filtrar.$fecha.$estado.$moneda.$creclamo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReclamo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Reclamo = new $InsReclamo();
                    $Reclamo->RecId = $fila['RecId'];
					$Reclamo->RecAno = $fila['RecAno'];
					
					$Reclamo->PerId = $fila['PerId'];
					$Reclamo->PrvId = $fila['PrvId'];
					$Reclamo->AmoId = $fila['AmoId'];
					
					$Reclamo->RecCodigoReclamo = $fila['RecCodigoReclamo'];
					$Reclamo->RecFechaEmision = $fila['NRecFechaEmision'];
					
					$Reclamo->RecCliente = $fila['RecCliente'];
					$Reclamo->RecPais = $fila['RecPais'];
					$Reclamo->RecSucursal = $fila['RecSucursal'];
					
					$Reclamo->MonId = $fila['MonId'];
					$Reclamo->RecTipoCambio = $fila['RecTipoCambio'];
					
					$Reclamo->RecTotal = $fila['RecTotal'];
			
					$Reclamo->RecObservacion = $fila['RecObservacion'];
					$Reclamo->RecObservacionImpresa = $fila['RecObservacionImpresa'];
					
					
		
					
					$Reclamo->RecRespuestaNumero = $fila['RecRespuestaNumero'];
					$Reclamo->RecRespuestaFecha = $fila['NRecRespuestaFecha'];
					
					$Reclamo->RecEstado = $fila['RecEstado'];
					$Reclamo->RecTiempoCreacion = $fila['NRecTiempoCreacion'];  
					$Reclamo->RecTiempoModificacion = $fila['NRecTiempoModificacion']; 
							
					$Reclamo->PrvNombre = $fila['PrvNombre'];
					$Reclamo->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Reclamo->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$Reclamo->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$Reclamo->TdoId = $fila['TdoId'];
					
					$Reclamo->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					$Reclamo->OcoId = $fila['OcoId'];
			
					switch($Reclamo->RecEstado){
						
						case 1:
							$Reclamo->RecEstadoDescripcion =  "Pendiente";
						break;
						
						case 5:
							$Reclamo->RecEstadoDescripcion =  "Enviado";
						break;
						
						case 6:
							$Reclamo->RecEstadoDescripcion =  "Anulado";
						break;
						
						case 7:
							$Reclamo->RecEstadoDescripcion =  "Recepcionado";
						break;
						
						case 8:
							$Reclamo->RecEstadoDescripcion =  "Atendido";
						break;
						
						case 9:
							$Reclamo->RecEstadoDescripcion =  "C/ Nota Credito";
						break;
						
					}
					


                    $Reclamo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Reclamo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarReclamo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsReclamoDetalle = new ClsReclamoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
					
					$ResReclamoDetalle = $InsReclamoDetalle->MtdObtenerReclamoDetalles(NULL,NULL,'RdeId','Desc',NULL,$elemento);
					$ArrReclamoDetalles = $ResReclamoDetalle['Datos'];

					if(!empty($ArrReclamoDetalles)){
						$amdetalle = '';

						foreach($ArrReclamoDetalles as $DatReclamoDetalle){
							$amdetalle .= '#'.$DatReclamoDetalle->RdeId;
						}

						if(!$InsReclamoDetalle->MtdEliminarReclamoDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblrecreclamo WHERE  (RecId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarReclamo(3,"Se elimino el Reclamo",$aux);		
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
	public function MtdActualizarEstadoReclamo($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tblrecreclamo SET RecEstado = '.$oEstado.' WHERE RecId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de el Reclamo";
						
						$this->RecId = $elemento;						
						$this->MtdAuditarReclamo(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}
	
	
	
	public function MtdGenerarReclamo($oElementos,$oTransaccion = true,$oCambiarEstado = true) {
		
										
	}
	
	
	public function MtdRegistrarReclamo($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarReclamoId();
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
		

			$sql = 'INSERT INTO tblrecreclamo (
			RecId,
			RecAno,
			
			PerId,
			PrvId,
			AmoId,
			
			RecCodigoReclamo,
			RecFechaEmision,
			
			RecCliente,
			RecPais,
			RecSucursal,
			
			MonId,
			RecTipoCambio,
		
			RecTotal,
			
			RecObservacion,
			RecObservacionImpresa,
			
			RecRespuestaNumero,
			RecRespuestaFecha,
					
			RecEstado,			
			RecTiempoCreacion,
			RecTiempoModificacion) 
			VALUES (
			"'.($this->RecId).'", 
			"'.($this->RecAno).'", 
			
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->PrvId)?"NULL,":'"'.$this->PrvId.'",').'
			'.(empty($this->AmoId)?"NULL,":'"'.$this->AmoId.'",').'
			
			"'.($this->RecCodigoReclamo).'", 
			"'.($this->RecFechaEmision).'", 
			
			"'.($this->RecCliente).'",
			"'.($this->RecPais).'",
			"'.($this->RecSucursal).'",
			
			"'.($this->MonId).'",
			'.(empty($this->RecTipoCambio)?"NULL,":'"'.$this->RecTipoCambio.'",').'

			'.($this->RecTotal).',

			"'.($this->RecObservacion).'",
			"'.($this->RecObservacionImpresa).'",
			
			"'.($this->RecRespuestaNumero).'",
			'.(empty($this->RecRespuestaFecha)?"NULL,":'"'.$this->RecRespuestaFecha.'",').'
			
			'.($this->RecEstado).',
			"'.($this->RecTiempoCreacion).'",
			"'.($this->RecTiempoModificacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

			if(!$error){			
			
				if (!empty($this->ReclamoDetalle)){		
						
					$validar = 0;
					$item = 1;

					foreach ($this->ReclamoDetalle as $DatReclamoDetalle){
						
						$InsReclamoDetalle = new ClsReclamoDetalle();
						$InsReclamoDetalle->RecId = $this->RecId;
						$InsReclamoDetalle->AmdId = $DatReclamoDetalle->AmdId;
						$InsReclamoDetalle->RdeObservacion = $DatReclamoDetalle->RdeObservacion;
						
						$InsReclamoDetalle->RdeCantidad = $DatReclamoDetalle->RdeCantidad;
						$InsReclamoDetalle->RdePrecioUnitario = $DatReclamoDetalle->RdePrecioUnitario;
						$InsReclamoDetalle->RdeMonto = $DatReclamoDetalle->RdeMonto;
						
						$InsReclamoDetalle->RdeEstado = $DatReclamoDetalle->RdeEstado;
						$InsReclamoDetalle->RdeTiempoCreacion = $DatReclamoDetalle->RdeTiempoCreacion;
						$InsReclamoDetalle->RdeTiempoModificacion = $DatReclamoDetalle->RdeTiempoModificacion;						
						$InsReclamoDetalle->RdeEliminado = $DatReclamoDetalle->RdeEliminado;

						if($InsReclamoDetalle->MtdRegistrarReclamoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_REC_201';
							$Resultado.='#Item Numero: '.($item);
						}
						
						$item++;
					}					
					
					if(count($this->ReclamoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			if(!$error){			

				if (!empty($this->ReclamoFoto)){		

					$validar = 0;		
					$item = 1;			
					$InsReclamoFoto = new ClsReclamoFoto();		
											
					foreach ($this->ReclamoFoto as $DatReclamoFoto){

						$InsReclamoFoto->RecId = $this->RecId;
						$InsReclamoFoto->RfoArchivo = $DatReclamoFoto->RfoArchivo;
						$InsReclamoFoto->RfoComentario = $DatReclamoFoto->RfoComentario;
					
						$InsReclamoFoto->RfoEstado = $DatReclamoFoto->RfoEstado;							
						$InsReclamoFoto->RfoTiempoCreacion = $DatReclamoFoto->RfoTiempoCreacion;
						$InsReclamoFoto->RfoTiempoModificacion = $DatReclamoFoto->RfoTiempoModificacion;						
						$InsReclamoFoto->RfoEliminado = $DatReclamoFoto->RfoEliminado;
						
						if($InsReclamoFoto->MtdRegistrarReclamoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_REC_301';
							$Resultado.='#Item Numero: '.($item);
						}
						
						$item++;
						
					}					
					
					if(count($this->ReclamoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
				
		if($error) {	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		} else {				
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionHacer();		
			}
			$this->MtdAuditarReclamo(1,"Se registro el Reclamo",$this);			
			return true;
		}
					
	}
	
	public function MtdEditarReclamo($oTransaccion=true) {

		global $Resultado;
		$error = false;
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
			
			$sql = 'UPDATE tblrecreclamo SET
			RecCodigoReclamo = "'.($this->RecCodigoReclamo).'",				
			RecFechaEmision = "'.($this->RecFechaEmision).'",
	
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			
			RecCliente = "'.($this->RecCliente).'",
			RecPais = "'.($this->RecPais).'",
			RecSucursal = "'.($this->RecSucursal).'",
			
			MonId = "'.($this->MonId).'",			
			'.(empty($this->RecTipoCambio)?'RecTipoCambio = NULL, ':'RecTipoCambio = '.$this->RecTipoCambio.',').'
			
			RecObservacion = "'.($this->RecObservacion).'",
			RecObservacionImpresa = "'.($this->RecObservacionImpresa).'",

			RecTotal = '.($this->RecTotal).',	
		
			RecRespuestaNumero = "'.($this->RecRespuestaNumero).'",			
			'.(empty($this->RecRespuestaFecha)?'RecRespuestaFecha = NULL, ':'RecRespuestaFecha = "'.$this->RecRespuestaFecha.'",').'
			
			RecEstado = '.($this->RecEstado).',
			RecTiempoModificacion = "'.($this->RecTiempoModificacion).'"

			WHERE RecId = "'.($this->RecId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if(!$error){

				if (!empty($this->ReclamoDetalle)){		
						
					$validar = 0;
					
					foreach ($this->ReclamoDetalle as $DatReclamoDetalle){
	
						$InsReclamoDetalle = new ClsReclamoDetalle();
						$InsReclamoDetalle->RdeId = $DatReclamoDetalle->RdeId;
						$InsReclamoDetalle->RecId = $this->RecId;
						$InsReclamoDetalle->AmdId = $DatReclamoDetalle->AmdId;
						$InsReclamoDetalle->RdeObservacion = $DatReclamoDetalle->RdeObservacion;
						
						$InsReclamoDetalle->RdeCantidad = $DatReclamoDetalle->RdeCantidad;
						$InsReclamoDetalle->RdePrecioUnitario = $DatReclamoDetalle->RdePrecioUnitario;
						$InsReclamoDetalle->RdeMonto = $DatReclamoDetalle->RdeMonto;
						
						$InsReclamoDetalle->RdeEstado = $DatReclamoDetalle->RdeEstado;
						$InsReclamoDetalle->RdeTiempoCreacion = $DatReclamoDetalle->RdeTiempoCreacion;
						$InsReclamoDetalle->RdeTiempoModificacion = $DatReclamoDetalle->RdeTiempoModificacion;
						$InsReclamoDetalle->RdeEliminado = $DatReclamoDetalle->RdeEliminado;

						if(empty($InsReclamoDetalle->RdeId)){
							if($InsReclamoDetalle->RdeEliminado<>2){
								if($InsReclamoDetalle->MtdRegistrarReclamoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_REC_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
			 				}else{
								$validar++;
							}
						}else{						
							if($InsReclamoDetalle->RdeEliminado==2){
								if($InsReclamoDetalle->MtdEliminarReclamoDetalle($InsReclamoDetalle->RdeId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_REC_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsReclamoDetalle->MtdEditarReclamoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_REC_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->ReclamoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){

				if (!empty($this->ReclamoFoto)){		
						
					$validar = 0;				
					
					$InsReclamoFoto = new ClsReclamoFoto();

					foreach ($this->ReclamoFoto as $DatReclamoFoto){


						$InsReclamoFoto->RfoId = $DatReclamoFoto->RfoId;
						$InsReclamoFoto->RecId = $this->RecId;
						$InsReclamoFoto->RfoArchivo = $DatReclamoFoto->RfoArchivo;
						$InsReclamoFoto->RfoComentario = $DatReclamoFoto->RfoComentario;
						$InsReclamoFoto->RfoEstado = $DatReclamoFoto->RfoEstado;
						$InsReclamoFoto->RfoTiempoCreacion = $DatReclamoFoto->RfoTiempoCreacion;
						$InsReclamoFoto->RfoTiempoModificacion = $DatReclamoFoto->RfoTiempoModificacion;
						$InsReclamoFoto->RfoEliminado = $DatReclamoFoto->RfoEliminado;
						
						if(empty($InsReclamoFoto->RfoId)){
							if($InsReclamoFoto->RfoEliminado<>2){
								if($InsReclamoFoto->MtdRegistrarReclamoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_REC_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsReclamoFoto->RfoEliminado==2){
								if($InsReclamoFoto->MtdEliminarReclamoFoto($InsReclamoFoto->RfoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_REC_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsReclamoFoto->MtdEditarReclamoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_REC_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->ReclamoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
					
				
			if($error) {		
			
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
			
				return false;
			} else {			

				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();
				}

				$this->MtdAuditarReclamo(2,"Se edito el Reclamo",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarReclamo($oAccion,$oDescripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->RecId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		public function MtdVerificarExisteReclamo($oCampo,$oDato){

		$Respuesta =   NULL;
			
		$sql = 'SELECT 
        RecId
        FROM tblrecreclamo rec
        WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['RecId'])){
				$Respuesta = $fila['RecId'];
			}

		}
        
		return $Respuesta;

    }			
	
	


}
?>