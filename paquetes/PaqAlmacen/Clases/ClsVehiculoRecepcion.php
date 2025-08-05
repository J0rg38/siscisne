<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoRecepcion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoRecepcion {

    public $VreId;
	public $PerId;
	public $EinId;
	
	public $VreFecha;
	public $VreTieneGuia;
    public $VreGuiaRemisionNumero;
	public $VreObservacion;
	
	public $VreEstado;
    public $VreTiempoCreacion;
    public $VreTiempoModificacion;
    public $VreEliminado;
	
	public $VehiculoRecepcionDetalle;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVehiculoRecepcionId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VreId,5),unsigned)) AS "MAXIMO"
			FROM tblvrevehiculorecepcion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VreId = "VRE-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VreId = "VRE-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculoRecepcion($oCompleto=true){

        $sql = 'SELECT 
		vre.VreId,
		vre.PerId,
		vre.EinId,
		
		DATE_FORMAT(vre.VreFecha, "%d/%m/%Y") AS "NVreFecha",
		
		vre.VreTieneGuia,
		vre.VreGuiaRemisionNumero,
		vre.VreObservacion,
		
		vre.VreEstado,
		DATE_FORMAT(vre.VreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVreTiempoCreacion",
        DATE_FORMAT(vre.VreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVreTiempoModificacion",
		
						
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				ein.EinVIN,
				ein.EinColor,
				
				vma.VmaNombre,
				vmo.VmoNombre
				
	
        FROM tblvrevehiculorecepcion vre
			
			LEFT JOIN tblperpersonal per
					ON vre.PerId = per.PerId
						LEFT JOIN tbleinvehiculoingreso ein
						ON vre.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
        WHERE  vre.VreId = "'.$this->VreId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->VreId = $fila['VreId'];
			$this->PerId = $fila['PerId']; 
			$this->EinId = $fila['EinId']; 
			
			$this->VreFecha = (($fila['NVreFecha']));
            $this->VreTieneGuia = $fila['VreTieneGuia'];				
            $this->VreGuiaRemisionNumero = (($fila['VreGuiaRemisionNumero']));
			$this->VreObservacion = (($fila['VreObservacion']));
			
			$this->VreEstado = $fila['VreEstado'];					
			$this->VreTiempoCreacion = $fila['NVreTiempoCreacion'];
			$this->VreTiempoModificacion = $fila['NVreTiempoModificacion']; 
			
			
			$this->PerNombre = $fila['PerNombre']; 
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno']; 
			
			$this->EinVIN = $fila['EinVIN']; 
			$this->EinColor = $fila['EinColor']; 
			
			$this->VmaNombre = $fila['VmaNombre']; 
			$this->VmoNombre = $fila['VmoNombre']; 

			$this->VehiculoRecepcionDetalle = array();
			
			
				
			switch($this->VreEstado){
					
					  case 1:
						  $this->VreEstadoDescripcion = "Sin Reclamo";
					  break;
					
					  case 3:
						 $this->VreEstadoDescripcion = "Con Reclamo";
					  break;	
					
					  case 6:
						  $this->VreEstadoDescripcion = "Anulado";
					  break;
					
					  default:
						 $this->VreEstadoDescripcion = "";
					  break;					
					
			}
					
					
			if($oCompleto){


//MtdObtenerVehiculoRecepcionDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoRecepcion=NULL)
				$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();
				$ResVehiculoRecepcionDetalle = $InsVehiculoRecepcionDetalle->MtdObtenerVehiculoRecepcionDetalles(NULL,NULL,NULL,"VrdId","ASC",NULL,NULL,$this->VreId);
				$VehiculoRecepcionDetalle = $ResVehiculoRecepcionDetalle['Datos'];
				
				if(!empty($ResVehiculoRecepcionDetalle['Datos'])){
					foreach($ResVehiculoRecepcionDetalle['Datos'] as $DatVehiculoRecepcionDetalle){
						
						//MtdObtenerVehiculoRecepcionDetalleFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoRecepcionDetalle=NULL)
						$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();
						$ResVehiculoRecepcionDetalleFoto = $InsVehiculoRecepcionDetalleFoto->MtdObtenerVehiculoRecepcionDetalleFotos(NULL,NULL,'VrfId','ASC',NULL,$DatVehiculoRecepcionDetalle->VrdId);
						
						$DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto = $ResVehiculoRecepcionDetalleFoto['Datos'];
						
						$this->VehiculoRecepcionDetalle[] = $DatVehiculoRecepcionDetalle;
					}
				}
				
				
			}

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

   
    public function MtdObtenerVehiculoRecepciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoIngreso=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oPersonal=NULL) {

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
						pvv.VreId = vre.VreId

						
						
						
						
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
			$estado = ' AND vre.VreEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND vre.EinId = "'.$oVehiculoIngreso.'" ';
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
		
		if(!empty($oPersonal)){
			$personak = ' AND vre.PerId = "'.$oPersonal.'" ';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vre.VreId,
				vre.PerId,
				
				vre.EinId,
				
				DATE_FORMAT(vre.VreFecha, "%d/%m/%Y") AS "NVreFecha",
				vre.VreTieneGuia,
				vre.VreGuiaRemisionNumero,
				vre.VreObservacion,
		
				vre.VreEstado,
				DATE_FORMAT(vre.VreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVreTiempoCreacion",
                DATE_FORMAT(vre.VreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVreTiempoModificacion",
				
				(
				SELECT 
				COUNT(vrd.VrdId) 
				FROM tblvrdvehiculorecepciondetalle vrd				
				WHERE vrd.VreId = vre.VreId) AS VreTotalItems,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				
				ein.EinVIN,
				ein.EinColor
				
				FROM tblvrevehiculorecepcion vre		
					LEFT JOIN tblperpersonal per
					ON vre.PerId = per.PerId
						LEFT JOIN tbleinvehiculoingreso ein
						ON vre.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
										
					
				WHERE  1 = 1  '.$filtrar.$estado.$vingreso.$orden.$paginacion;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoRecepcion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoRecepcion = new $InsVehiculoRecepcion();
                    $VehiculoRecepcion->VreId = $fila['VreId'];
					$VehiculoRecepcion->PerId = $fila['PerId']; 
					$VehiculoRecepcion->EinId = $fila['EinId']; 
					
					$VehiculoRecepcion->VreFecha = ($fila['NVreFecha']);
					$VehiculoRecepcion->VreTieneGuia = $fila['VreTieneGuia'];
                    $VehiculoRecepcion->VreGuiaRemisionNumero= ($fila['VreGuiaRemisionNumero']);                
					$VehiculoRecepcion->VreObservacion= ($fila['VreObservacion']);
					
					$VehiculoRecepcion->VreEstado = $fila['VreEstado'];	
                    $VehiculoRecepcion->VreTiempoCreacion = $fila['NVreTiempoCreacion'];
                    $VehiculoRecepcion->VreTiempoModificacion = $fila['NVreTiempoModificacion'];
					
					 $VehiculoRecepcion->VreTotalItems = $fila['VreTotalItems'];
					
					$VehiculoRecepcion->PerNombre = $fila['PerNombre'];
					$VehiculoRecepcion->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$VehiculoRecepcion->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$VehiculoRecepcion->VmaNombre = $fila['VmaNombre'];
					$VehiculoRecepcion->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoRecepcion->EinVIN = $fila['EinVIN'];
					$VehiculoRecepcion->EinColor = $fila['EinColor'];
					
					switch($VehiculoRecepcion->VreEstado){
					
					  case 1:
						  $VehiculoRecepcion->VreEstadoDescripcion = "Sin Reclamo";
					  break;
					
					  case 3:
						 $VehiculoRecepcion->VreEstadoDescripcion = "Con Reclamo";
					  break;	
					
					  case 6:
						  $VehiculoRecepcion->VreEstadoDescripcion = "Anulado";
					  break;
					
					  default:
						  $Estado = "";
					  break;					
					
					}
				
					$VehiculoRecepcion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoRecepcion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoRecepcion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VreId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VreId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvrevehiculorecepcion WHERE '.$eliminar;			
		
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
	
	
	
	
	
	
	
	
	public function MtdRegistrarVehiculoRecepcion() {
		
		global $Resultado;
		
			$this->MtdGenerarVehiculoRecepcionId();
			
			$sql = 'INSERT INTO tblvrevehiculorecepcion (
			VreId,
			
			PerId,
			EinId,
			
			VreFecha,
			VreTieneGuia,
			VreGuiaRemisionNumero, 
			
			VreObservacion,
			
			VreEstado,
			VreTiempoCreacion,
			VreTiempoModificacion
			) 
			VALUES (
			"'.($this->VreId).'", 
			
			"'.($this->PerId).'", 
			"'.($this->EinId).'", 

			"'.($this->VreFecha).'", 
			"'.($this->VreTieneGuia).'", 
			"'.($this->VreGuiaRemisionNumero).'", 
			
			"'.($this->VreObservacion).'",
			
			'.($this->VreEstado).',
			"'.($this->VreTiempoCreacion).'", 
			"'.($this->VreTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
		
			
			
			
			if(!$error){		
			
			
			
				if (!empty($this->VehiculoRecepcionDetalle)){		
				
					$validar = 0;				
					$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();		
							
					foreach ($this->VehiculoRecepcionDetalle as $DatVehiculoRecepcionDetalle){
						
						$InsVehiculoRecepcionDetalle->VreId = $this->VreId;
						
						$InsVehiculoRecepcionDetalle->VrdZonaComprometida = $DatVehiculoRecepcionDetalle->VrdZonaComprometida;
						$InsVehiculoRecepcionDetalle->VrdRepuestoDetalle = $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle;
						$InsVehiculoRecepcionDetalle->VrdSolucion = $DatVehiculoRecepcionDetalle->VrdSolucion;
						$InsVehiculoRecepcionDetalle->VrdObservacion = $DatVehiculoRecepcionDetalle->VrdObservacion;
						$InsVehiculoRecepcionDetalle->VrdEstado = $DatVehiculoRecepcionDetalle->VrdEstado;

						$InsVehiculoRecepcionDetalle->VrdTiempoCreacion = $DatVehiculoRecepcionDetalle->VrdTiempoCreacion;
						$InsVehiculoRecepcionDetalle->VrdTiempoModificacion = $DatVehiculoRecepcionDetalle->VrdTiempoModificacion;
						
						$InsVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto = $DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto;
						
						if($InsVehiculoRecepcionDetalle->MtdRegistrarVehiculoRecepcionDetalle()){
							$validar++;					
						}else{
							$Resultado.='#ERR_VRE_211';
							$Resultado.='#Item Numero: '.($validar+1);	
						}
								
										
					}					
					
					if(count($this->VehiculoRecepcionDetalle) <> $validar ){
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
	
	public function MtdEditarVehiculoRecepcion() {
	
		global $Resultado;
		
		/*	VrePrecio = '.($this->VrePrecio).',
		VreCosto = '.($this->VreCosto).',		*/
	
		$sql = 'UPDATE tblvrevehiculorecepcion SET 
		PerId = "'.($this->PerId).'",
		EinId = "'.($this->EinId).'",			
		
		VreFecha = "'.($this->VreFecha).'",			
		VreTieneGuia = "'.($this->VreTieneGuia).'",
		VreGuiaRemisionNumero = "'.($this->VreGuiaRemisionNumero).'",
	
		VreObservacion = "'.($this->VreObservacion).'",
	
		VreEstado = '.($this->VreEstado).',
		VreTiempoModificacion = "'.($this->VreTiempoModificacion).'"		
		WHERE VreId = "'.($this->VreId).'";';
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		
			
			if(!$error){
				if (!empty($this->VehiculoRecepcionDetalle)){		

					$validar = 0;				
					$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();		

					foreach ($this->VehiculoRecepcionDetalle as $DatVehiculoRecepcionDetalle){

						$InsVehiculoRecepcionDetalle->VrdId = $DatVehiculoRecepcionDetalle->VrdId;
						$InsVehiculoRecepcionDetalle->VreId = $this->VreId;
						
						$InsVehiculoRecepcionDetalle->VrdZonaComprometida = $DatVehiculoRecepcionDetalle->VrdZonaComprometida;
						$InsVehiculoRecepcionDetalle->VrdRepuestoDetalle = $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle;
						$InsVehiculoRecepcionDetalle->VrdSolucion = $DatVehiculoRecepcionDetalle->VrdSolucion;
						$InsVehiculoRecepcionDetalle->VrdObservacion = $DatVehiculoRecepcionDetalle->VrdObservacion;
						$InsVehiculoRecepcionDetalle->VrdEstado = $DatVehiculoRecepcionDetalle->VrdEstado;
						
						$InsVehiculoRecepcionDetalle->VrdTiempoCreacion = $DatVehiculoRecepcionDetalle->VrdTiempoCreacion;
						$InsVehiculoRecepcionDetalle->VrdTiempoModificacion = $DatVehiculoRecepcionDetalle->VrdTiempoModificacion;
						$InsVehiculoRecepcionDetalle->VrdEliminado = $DatVehiculoRecepcionDetalle->VrdEliminado;
						
						$InsVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto = $DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto;

						if(empty($InsVehiculoRecepcionDetalle->VrdId)){
							if($InsVehiculoRecepcionDetalle->VrdEliminado<>2){
								if($InsVehiculoRecepcionDetalle->MtdRegistrarVehiculoRecepcionDetalle()){
									$validar++;					
								}else{
									$Resultado.='#ERR_VRE_211';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsVehiculoRecepcionDetalle->VrdEliminado==2){
								if($InsVehiculoRecepcionDetalle->MtdEliminarVehiculoRecepcionDetalle($InsVehiculoRecepcionDetalle->VrdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VRE_213';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								if($InsVehiculoRecepcionDetalle->MtdEditarVehiculoRecepcionDetalle()){
									$validar++;					
								}else{
									$Resultado.='#ERR_VRE_232';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}
						}	
								
					}					
					
					if(count($this->VehiculoRecepcionDetalle) <> $validar ){
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
		
		
		

	public function MtdEditarVehiculoRecepcionDato($oCampo,$oDato,$oVehiculoRecepcionId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblvrevehiculorecepcion SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE VreId = "'.($oVehiculoRecepcionId).'";';
		
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
	
	
	
	public function MtdNotificarVehiculoRecepcion($oVehiculoRecepcion,$oDestinatario){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VreId = $oVehiculoRecepcion;
			$this->MtdObtenerVehiculoRecepcion();
			
			$mensaje .= "<b>NOTIFICACION DE RECEPCION VEHICULAR</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Datos de la recepcion del vehiculo.";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->VreId."";
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Recepcion:</b> ".$this->VreFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Responsable:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>¿Tiene Guia Remision?:</b> ".$this->VreTieneGuia."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Num. Guia Remision:</b> ".$this->VreGuiaRemisionNumero."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>VIN:</b> ".$this->EinVIN."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Marca/Modelo/Color:</b> ".$this->VmaNombre." ".$this->VmoNombre." ".$this->EinColor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Estado:</b> ".strtoupper($this->VreEstadoDescripcion);	
			$mensaje .= "<br>";	
			
			
			$mensaje .= "<b>Observaciones:</b> ".stripslashes($this->VreObservacion);	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<th>";
						$mensaje .= "#";
						$mensaje .= "</th>";
		
						$mensaje .= "<th>";
						$mensaje .= "ZONA COMPROMETIDA";
						$mensaje .= "</th>";
		
						$mensaje .= "<th>";
						$mensaje .= "DETALLE DEL REPUESTO";
						$mensaje .= "</th>";
						
						$mensaje .= "<th>";
						$mensaje .= "SOLUCION";
						$mensaje .= "</th>";
						
						$mensaje .= "<th>";
						$mensaje .= "OBSERVACION";
						$mensaje .= "</th>";
		
					$mensaje .= "</tr>";
					
			$i = 1;	
			$Enviar = false;
			if(!empty($this->VehiculoRecepcionDetalle)){
				foreach($this->VehiculoRecepcionDetalle as $DatVehiculoRecepcionDetalle){
					
							$mensaje .= "<tr>";
								
							  $mensaje .= "<td>";
							  $mensaje .= $i;
							  $mensaje .= "</td>";

							  $mensaje .= "<td>";				
							  
							  $mensaje .= $DatVehiculoRecepcionDetalle->VrdZonaComprometida;									
							  
							  $mensaje .= "</td>";
			  
							  $mensaje .= "<td>";
							  $mensaje .= $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle;
							  $mensaje .= "</td>";
							  
							  $mensaje .= "<td>";
							  $mensaje .= ($DatVehiculoRecepcionDetalle->VrdSolucion);
							  $mensaje .= "</td>";
							  
							  $mensaje .= "<td>";
							  $mensaje .= ($DatVehiculoRecepcionDetalle->VrdObservacion);
							  $mensaje .= "</td>";
				
							$mensaje .= "</tr>";
							$i++;				
							$Enviar = true;

				}
			}
			$mensaje .= "</table>";

			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//deb($mensaje);
			//echo $mensaje;
			if($Enviar){

				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"RECEPCION DE VEHICULO: Nro.: ".$this->VreId." - ".$this->EinVIN." ".$this->VmaNombre." ".$this->VmoNombre." ".$this->EinColor,$mensaje);

			}
		
				
				
		}
		
		
}
?>