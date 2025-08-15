<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoRecepcionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoRecepcionDetalle {

    public $VrdId;
	public $VreId;
	
	public $VrdZonaComprometida;
	public $VrdRepuestoDetalle;
    public $VrdSolucion;
	public $VrdObservacion;
	
	public $VrdEstado;
    public $VrdTiempoCreacion;
    public $VrdTiempoModificacion;
    public $VrdEliminado;
	
	
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

	public function MtdGenerarVehiculoRecepcionDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VrdId,5),unsigned)) AS "MAXIMO"
			FROM tblvrdvehiculorecepciondetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VrdId = "VRD-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VrdId = "VRD-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculoRecepcionDetalle($oCompleto=true){

        $sql = 'SELECT 
		vrd.VrdId,
		vrd.VreId,
		
		vrd.VrdZonaComprometida,
		vrd.VrdRepuestoDetalle,
		vrd.VrdSolucion,
		vrd.VrdObservacion,
		
		vrd.VrdEstado,
		DATE_FORMAT(vrd.VrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVrdTiempoCreacion",
        DATE_FORMAT(vrd.VrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVrdTiempoModificacion"
	
        FROM tblvrdvehiculorecepciondetalle vrd
			
        WHERE  vrd.VrdId = "'.$this->VrdId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->VrdId = $fila['VrdId'];
			$this->VreId = $fila['VreId']; 
			
			$this->VrdZonaComprometida = (($fila['VrdZonaComprometida']));
            $this->VrdRepuestoDetalle = $fila['VrdRepuestoDetalle'];				
            $this->VrdSolucion = (($fila['VrdSolucion']));
			$this->VrdObservacion = (($fila['VrdObservacion']));
			
			$this->VrdEstado = $fila['VrdEstado'];					
			$this->VrdTiempoCreacion = $fila['NVrdTiempoCreacion'];
			$this->VrdTiempoModificacion = $fila['NVrdTiempoModificacion']; 

			
			if($oCompleto){

				$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();
				$ResVehiculoRecepcionDetalleFoto = $InsVehiculoRecepcionDetalleFoto->MtdObtenerVehiculoRecepcionDetalleFotos(NULL,NULL,"VrfId","ASC",NULL,$this->VrdId);
				$this->VehiculoRecepcionDetalleFoto = $ResVehiculoRecepcionDetalleFoto['Datos'];
				
				
			}

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

   
    public function MtdObtenerVehiculoRecepcionDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoRecepcion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oVehiculoRecepcionEstado=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
				
				
					
				
/*
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
					WHERE 
						pvv.VrdId = vrd.VrdId

						
						
						
						
						AND (
						
						(vve.VveNombre LIKE "%'.$elemento.'%" 
									OR vmo.VmoNombre LIKE "%'.$elemento.'%" 
									OR vma.VmaNombre LIKE "%'.$elemento.'%" )
					';

				

							$filtrar .='	

						)
						
						
						
					) ';*/






				$filtrar .= '  ) ';
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		if(!empty($oEstado)){
			$estado = ' AND vrd.VrdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculoRecepcion)){
			$vrecepcion = ' AND vrd.VreId = "'.$oVehiculoRecepcion.'" ';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vre.VreFecha)>="'.$oFechaInicio.'" AND DATE(vre.VreFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vre.VreFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vre.VreFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		
		if(!empty($oVehiculoRecepcionEstado)){
			$vrestado = ' AND vre.VreEstado = '.$oVehiculoRecepcionEstado.' ';
		}
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vrd.VrdId,
				vrd.VreId,
				
				vrd.VrdRepuestoDetalle,
				vrd.VrdZonaComprometida,
				vrd.VrdSolucion,
				vrd.VrdObservacion,
		
				vrd.VrdEstado,
				DATE_FORMAT(vrd.VrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVrdTiempoCreacion",
                DATE_FORMAT(vrd.VrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVrdTiempoModificacion",
				
				DATE_FORMAT(vre.VreFecha, "%d/%m/%Y") AS "NVreFecha",
				vre.VreTieneGuia,				
				vre.VreGuiaRemisionNumero,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				
				ein.EinVIN,
				ein.EinColor

			
				FROM tblvrdvehiculorecepciondetalle vrd		
					LEFT JOIN tblvrevehiculorecepcion vre
					ON vrd.VreId = vre.VreId
						LEFT JOIN tbleinvehiculoingreso ein
						ON vre.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
										
				WHERE  1 = 1  '.$filtrar.$estado.$vrecepcion.$vmarca.$vrestado.$fecha.$orden.$paginacion;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoRecepcionDetalle = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					
					$VehiculoRecepcionDetalle = new $InsVehiculoRecepcionDetalle();
                    $VehiculoRecepcionDetalle->VrdId = $fila['VrdId'];
					$VehiculoRecepcionDetalle->VreId = $fila['VreId']; 
					
					$VehiculoRecepcionDetalle->VrdZonaComprometida = ($fila['VrdZonaComprometida']);
					$VehiculoRecepcionDetalle->VrdRepuestoDetalle = $fila['VrdRepuestoDetalle'];
                    $VehiculoRecepcionDetalle->VrdSolucion= ($fila['VrdSolucion']);
					$VehiculoRecepcionDetalle->VrdObservacion= ($fila['VrdObservacion']);
					
					$VehiculoRecepcionDetalle->VrdEstado = $fila['VrdEstado'];	
                    $VehiculoRecepcionDetalle->VrdTiempoCreacion = $fila['NVrdTiempoCreacion'];
                    $VehiculoRecepcionDetalle->VrdTiempoModificacion = $fila['NVrdTiempoModificacion'];
					
			
					$VehiculoRecepcionDetalle->VreFecha = $fila['NVreFecha'];					 
					$VehiculoRecepcionDetalle->VreTieneGuia = $fila['VreTieneGuia'];					
					$VehiculoRecepcionDetalle->VreGuiaRemisionNumero = $fila['VreGuiaRemisionNumero'];
					
					$VehiculoRecepcionDetalle->VmaNombre = $fila['VmaNombre'];
					$VehiculoRecepcionDetalle->VmoNombre = $fila['VmoNombre'];
					$VehiculoRecepcionDetalle->EinVIN = $fila['EinVIN'];
					$VehiculoRecepcionDetalle->EinColor = $fila['EinColor'];
					


					$VehiculoRecepcionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoRecepcionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoRecepcionDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VrdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VrdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvrdvehiculorecepciondetalle WHERE '.$eliminar;			
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	
	
	
	
	
	
	public function MtdRegistrarVehiculoRecepcionDetalle() {
		
		global $Resultado;
		
			$this->MtdGenerarVehiculoRecepcionDetalleId();
			
			$sql = 'INSERT INTO tblvrdvehiculorecepciondetalle (
			VrdId,
			VreId,

			VrdZonaComprometida,
			VrdRepuestoDetalle,
			VrdSolucion, 
			VrdObservacion,
			
			VrdEstado,
			VrdTiempoCreacion,
			VrdTiempoModificacion
			) 
			VALUES (
			"'.($this->VrdId).'", 
			"'.($this->VreId).'", 

			"'.($this->VrdZonaComprometida).'", 
			"'.($this->VrdRepuestoDetalle).'", 
			"'.($this->VrdSolucion).'", 
			"'.($this->VrdObservacion).'",
			
			'.($this->VrdEstado).',
			"'.($this->VrdTiempoCreacion).'", 
			"'.($this->VrdTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
			if(!$error){		
			
				if (!empty($this->VehiculoRecepcionDetalleFoto)){		
				
					$validar = 0;				
					$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();		
							
					foreach ($this->VehiculoRecepcionDetalleFoto as $DatVehiculoRecepcionDetalleFoto){
						
						$InsVehiculoRecepcionDetalleFoto->VrdId = $this->VrdId;
						$InsVehiculoRecepcionDetalleFoto->VrfArchivo = $DatVehiculoRecepcionDetalleFoto->VrfArchivo;
						$InsVehiculoRecepcionDetalleFoto->VrfEstado = $DatVehiculoRecepcionDetalleFoto->VrfEstado;
						$InsVehiculoRecepcionDetalleFoto->VrfTiempoCreacion = $DatVehiculoRecepcionDetalleFoto->VrfTiempoCreacion;
						$InsVehiculoRecepcionDetalleFoto->VrfTiempoModificacion = $DatVehiculoRecepcionDetalleFoto->VrfTiempoModificacion;
												
						if($InsVehiculoRecepcionDetalleFoto->MtdRegistrarVehiculoRecepcionDetalleFoto()){
							$validar++;					
						}else{
							$Resultado.='#ERR_VRD_211';
							$Resultado.='#Item Numero: '.($validar+1);	
						}
										
					}					
					
					if(count($this->VehiculoRecepcionDetalleFoto) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
			
			
		
			
			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarVehiculoRecepcionDetalle() {
	
		global $Resultado;
		
		/*	VrdPrecio = '.($this->VrdPrecio).',
		VrdCosto = '.($this->VrdCosto).',		*/
	
		$sql = 'UPDATE tblvrdvehiculorecepciondetalle SET 
		VrdZonaComprometida = "'.($this->VrdZonaComprometida).'",			
		VrdRepuestoDetalle = "'.($this->VrdRepuestoDetalle).'",
		VrdSolucion = "'.($this->VrdSolucion).'",
		VrdObservacion = "'.($this->VrdObservacion).'",
		
		VrdEstado = '.($this->VrdEstado).',
		VrdTiempoModificacion = "'.($this->VrdTiempoModificacion).'"		
		WHERE VrdId = "'.($this->VrdId).'";';
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
			
			if(!$error){
				if (!empty($this->VehiculoRecepcionDetalleFoto)){		

					$validar = 0;				
					$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();		

					foreach ($this->VehiculoRecepcionDetalleFoto as $DatVehiculoRecepcionDetalleFoto){

						$InsVehiculoRecepcionDetalleFoto->VrfId = $DatVehiculoRecepcionDetalleFoto->VrfId;
						$InsVehiculoRecepcionDetalleFoto->VrdId = $this->VrdId;
						$InsVehiculoRecepcionDetalleFoto->VrfArchivo = $DatVehiculoRecepcionDetalleFoto->VrfArchivo;
						$InsVehiculoRecepcionDetalleFoto->VrfEstado = $DatVehiculoRecepcionDetalleFoto->VrfEstado;
						$InsVehiculoRecepcionDetalleFoto->VrfTiempoCreacion = $DatVehiculoRecepcionDetalleFoto->VrfTiempoCreacion;
						$InsVehiculoRecepcionDetalleFoto->VrfTiempoModificacion = $DatVehiculoRecepcionDetalleFoto->VrfTiempoModificacion;
						$InsVehiculoRecepcionDetalleFoto->VrfEliminado = $DatVehiculoRecepcionDetalleFoto->VrfEliminado;

						if(empty($InsVehiculoRecepcionDetalleFoto->VrfId)){
							if($InsVehiculoRecepcionDetalleFoto->VrfEliminado<>2){
								if($InsVehiculoRecepcionDetalleFoto->MtdRegistrarVehiculoRecepcionDetalleFoto()){
									$validar++;					
								}else{
									$Resultado.='#ERR_VRD_211';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsVehiculoRecepcionDetalleFoto->VrfEliminado==2){
								if($InsVehiculoRecepcionDetalleFoto->MtdEliminarVehiculoRecepcionDetalleFoto($InsVehiculoRecepcionDetalleFoto->VrfId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VRD_213';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsVehiculoRecepcionDetalleFoto->MtdEditarVehiculoRecepcionDetalleFoto()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_VRD_232';
								//	$Resultado.='#Item Numero: '.($validar+1);	
								//}
							}
						}	
								
					}					
					
					if(count($this->VehiculoRecepcionDetalleFoto) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
	
			
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}	
		
		
		
		
	


	public function MtdEditarVehiculoRecepcionDetalleDato($oCampo,$oDato,$oVehiculoRecepcionId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblvrdvehiculorecepciondetalle SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE VrdId = "'.($oVehiculoRecepcionId).'";';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
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
	
	
		
					
	
}
?>