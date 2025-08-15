<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEncuesta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEncuesta {

    public $EncId;
    public $EncFecha;
	public $FinId;
	
	public $EncVerbatin;
	public $EncObservacion;
	public $EncEstado;	
    public $EncTiempoCreacion;
    public $EncTiempoModificacion;
    public $EncEliminado;

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
		
	public function MtdGenerarEncuestaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(EncId,5),unsigned)) AS "MAXIMO"
		FROM tblencencuesta';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->EncId = "ENC-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->EncId = "ENC-".$fila['MAXIMO'];					
		}	
			
	}
		
    public function MtdObtenerEncuesta($oCompleto=true){

        $sql = 'SELECT 
        enc.EncId,
		enc.FinId,
		enc.OvvId,
		
		enc.SucId,
		enc.CliId,
		
		DATE_FORMAT(enc.EncFecha, "%d/%m/%Y") AS "NEncFecha",
		enc.EncVerbatin,
		enc.EncObservacion,
		enc.EncTipo,
		EncEstado,	
		DATE_FORMAT(enc.EncTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEncTiempoCreacion",
        DATE_FORMAT(enc.EncTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEncTiempoModificacion",
		
		IFNULL(ein.EinVIN,IFNULL(ein2.EinVIN,"")) AS EinVIN,
		IFNULL(ein.EinPlaca,IFNULL(ein2.EinPlaca,"")) AS EinPlaca,
		IFNULL(ein.EinColor,IFNULL(ein2.EinColor,"")) AS EinColor,
		
		IFNULL(vma.VmaNombre,IFNULL(vma2.VmaNombre,"")) AS VmaNombre,
		IFNULL(vmo.VmoNombre,IFNULL(vmo2.VmoNombre,"")) AS VmoNombre,
		IFNULL(vve.VveNombre,IFNULL(vve2.VveNombre,"")) AS VveNombre,
		
		IFNULL(cli.CliNombre,IFNULL(cli2.CliNombre,"")) AS CliNombre,
		IFNULL(cli.CliApellidoPaterno,IFNULL(cli2.CliApellidoPaterno,"")) AS CliApellidoPaterno,
		IFNULL(cli.CliApellidoMaterno,IFNULL(cli2.CliApellidoMaterno,"")) AS CliApellidoMaterno
		
        FROM tblencencuesta enc
		
			LEFT JOIN tblfinfichaingreso fin
			ON enc.FinId = fin.FinId
				LEFT JOIN tbleinvehiculoingreso ein
				ON fin.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblclicliente cli
								ON fin.CliId = cli.CliId		 
			
			LEFT JOIN tblovvordenventavehiculo ovv
			ON enc.OvvId = ovv.OvvId
				LEFT JOIN tbleinvehiculoingreso ein2
				ON ovv.EinId = ein2.EinId
					LEFT JOIN tblvvevehiculoversion vve2
					ON ein2.VveId = vve2.VveId
						LEFT JOIN tblvmovehiculomodelo vmo2
						ON vve2.VmoId = vmo2.VmoId
							LEFT JOIN tblvmavehiculomarca vma2
							ON vmo2.VmaId = vma2.VmaId
								LEFT JOIN tblclicliente cli2
								ON ovv.CliId = cli2.CliId	
			
        WHERE enc.EncId = "'.$this->EncId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EncId = $fila['EncId'];
			
			$this->SucId = $fila['SucId'];
			$this->CliId = $fila['CliId'];
			
			$this->FinId = $fila['FinId'];
			$this->OvvId = $fila['OvvId'];
													
            $this->EncFecha = $fila['NEncFecha'];	
			$this->EncTipo = $fila['EncTipo'];
			$this->EncVerbatin = $fila['EncVerbatin'];	
			$this->EncObservacion = $fila['EncObservacion'];									
			$this->EncEstado = $fila['EncEstado'];
			$this->EncTiempoCreacion = $fila['NEncTiempoCreacion'];
			$this->EncTiempoModificacion = $fila['NEncTiempoModificacion'];
			
			
			$this->EinVIN = $fila['EinVIN'];	
			$this->EinPlaca = $fila['EinPlaca'];	
			$this->EinColor = $fila['EinColor'];									
			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VveNombre = $fila['VveNombre'];
			
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			
			if($oCompleto){
					
				$InsEncuestaDetalle = new ClsEncuestaDetalle();
				//MtdObtenerEncuestaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL)
				$ResEncuestaDetalle = $InsEncuestaDetalle->MtdObtenerEncuestaDetalles(NULL,NULL,NULL,'EdeId','DESC',NULL,NULL,$fila['EncId']);
				$this->EncuestaDetalle = $ResEncuestaDetalle['Datos'];
			}
		
			
			
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerEncuestas(
		$oCampo=NULL,
		$oCondicion=NULL,
		$oFiltro=NULL,
		$oOrden = 'EncId',
		$oSentido = 'Desc',
		$oPaginacion = '0,10',
		$oEstado=NULL,
		$oFechaInicio=NULL,
		$oFechaFin=NULL,
		$oTipo=NULL,
		$oSucursal=NULL,
		$oPersonal=NULL,
		$oFichaIngreso=NULL,
		$oOrdenVentaVehiculo=NULL,
		$oTipoFecha="EncFecha"
	){

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
		if(!empty($oEstado)){
			$estado = ' AND enc.EncEstado = '.$oEstado;
		}	
		
		
				
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(enc.EncFecha)>="'.$oFechaInicio.'" AND DATE(enc.EncFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(enc.EncFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(enc.EncFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		if(!empty($oTipo)){
			$tipo = ' AND enc.EncTipo = "'.$oTipo.'" ';
		}	
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (fin.SucId = "'.$oSucursal.'" OR ovv.SucId = "'.$oSucursal.'")';
		}

		if(!empty($oPersonal)){
			$personal = ' AND (fin.PerId = "'.$oPersonal.'" OR ovv.PerId = "'.$oPersonal.'")';
		}	
	
	
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND enc.FinId = "'.$oFichaIngreso.'" ';
		}	
		
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovehiculo = ' AND enc.OvvId = "'.$oOrdenVentaVehiculo.'" ';
		}	
		
		
		
		if(!empty($oFechaInicio)){			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
			}			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				enc.EncId,
				
				enc.SucId,
				enc.CliId,
				
				enc.FinId,
					enc.OvvId,
					
				DATE_FORMAT(enc.EncFecha, "%d/%m/%Y") AS "NEncFecha",
				enc.EncVerbatin,
				enc.EncObservacion,
				enc.EncTipo,
				enc.EncEstado,
				DATE_FORMAT(enc.EncTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEncTiempoCreacion",
                DATE_FORMAT(enc.EncTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEncTiempoModificacion",
				
				IFNULL(ein.EinVIN,IFNULL(ein2.EinVIN,"")) AS EinVIN,
				IFNULL(ein.EinPlaca,IFNULL(ein2.EinPlaca,"")) AS EinPlaca,
				IFNULL(ein.EinColor,IFNULL(ein2.EinColor,"")) AS EinColor,
				
				IFNULL(vma.VmaNombre,IFNULL(vma2.VmaNombre,"")) AS VmaNombre,
				IFNULL(vmo.VmoNombre,IFNULL(vmo2.VmoNombre,"")) AS VmoNombre,
				IFNULL(vve.VveNombre,IFNULL(vve2.VveNombre,"")) AS VveNombre,
				
				
				IFNULL(cli.CliNombre,IFNULL(cli2.CliNombre,"")) AS CliNombre,
				IFNULL(cli.CliApellidoPaterno,IFNULL(cli2.CliApellidoPaterno,"")) AS CliApellidoPaterno,
				IFNULL(cli.CliApellidoMaterno,IFNULL(cli2.CliApellidoMaterno,"")) AS CliApellidoMaterno,
				IFNULL(cli.CliTelefono,IFNULL(cli2.CliTelefono,"")) AS CliTelefono,
				IFNULL(cli.CliCelular,IFNULL(cli2.CliCelular,"")) AS CliCelular,
				
				IFNULL(suc.SucNombre,IFNULL(suc2.SucNombre,"")) AS SucNombre,
				
				IFNULL(per.PerNombre,IFNULL(per2.PerNombre,"")) AS PerNombre,
				IFNULL(per.PerApellidoPaterno,IFNULL(per2.PerApellidoPaterno,"")) AS PerApellidoPaterno,
				IFNULL(per.PerApellidoMaterno,IFNULL(per2.PerApellidoMaterno,"")) AS PerApellidoMaterno,
				
				
				(
				SELECT 
				ede.EdeRespuesta
				FROM tbledeencuestadetalle ede
				LEFT JOIN tbleprencuestapregunta epr
				ON ede.EprId = epr.EprId
				WHERE epr.EprSubTipo = 1
				AND ede.EncId = enc.EncId
				) AS EncNivel,

				
				DATE_FORMAT(IFNULL(ovv.OvvActaEntregaFecha,IFNULL(ovv.OvvActaEntregaFechaPDS,fin.FinTiempoTrabajoTerminado)), "%d/%m/%Y")  AS EncFechaTermino
				
				FROM tblencencuesta enc	
					LEFT JOIN tblfinfichaingreso fin
					ON enc.FinId = fin.FinId
					
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tblvvevehiculoversion vve
								ON ein.VveId = vve.VveId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON vve.VmoId = vmo.VmoId	
										LEFT JOIN tblvmavehiculomarca vma
										ON vmo.VmaId = vma.VmaId
										
										
								LEFT JOIN tblclicliente cli
								ON fin.CliId = cli.CliId	
									
									LEFT JOIN tblperpersonal per
									ON fin.PerIdAsesor = per.PerId	 
								
								LEFT JOIN tblovvordenventavehiculo ovv
								ON enc.OvvId = ovv.OvvId
									LEFT JOIN tbleinvehiculoingreso ein2
									ON ovv.EinId = ein2.EinId
										
										LEFT JOIN tblvvevehiculoversion vve2
										ON ein2.VveId = vve2.VveId
											LEFT JOIN tblvmovehiculomodelo vmo2
											ON vve2.VmoId = vmo2.VmoId
												LEFT JOIN tblvmavehiculomarca vma2
												ON vmo2.VmaId = vma2.VmaId
												
													LEFT JOIN tblclicliente cli2
													ON ovv.CliId = cli2.CliId	
													
														LEFT JOIN tblperpersonal per2
									ON ovv.PerId = per2.PerId
			
					LEFT JOIN tblsucsucursal suc
					ON fin.SucId = suc.SucId 
					
						LEFT JOIN tblsucsucursal suc2
					ON ovv.SucId = suc2.SucId 
					
					
				WHERE 1 = 1 '.$filtrar.$tipo.$fecha.$ovehiculo.$fecha.$fingreso.$personal.$sucursal.$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEncuesta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Encuesta = new $InsEncuesta();				
					
                    $Encuesta->EncId = $fila['EncId'];
					
					$Encuesta->SucId = $fila['SucId'];
					$Encuesta->CliId = $fila['CliId'];
					
					$Encuesta->FinId= $fila['FinId'];
					$Encuesta->OvvId= $fila['OvvId'];
					
                    $Encuesta->EncFecha= $fila['NEncFecha'];
					$Encuesta->EncVerbatin = $fila['EncVerbatin'];
					$Encuesta->EncObservacion = $fila['EncObservacion'];		
					
					$Encuesta->EncTipo = $fila['EncTipo'];				
					$Encuesta->EncEstado = $fila['EncEstado'];					
                    $Encuesta->EncTiempoCreacion = $fila['NEncTiempoCreacion'];
                    $Encuesta->EncTiempoModificacion = $fila['NEncTiempoModificacion'];  
					
		
					$Encuesta->EinVIN = $fila['EinVIN'];  
					$Encuesta->EinPlaca = $fila['EinPlaca'];  
					$Encuesta->EinColor = $fila['EinColor'];  
					$Encuesta->VmaNombre = $fila['VmaNombre'];  
					$Encuesta->VmoNombre = $fila['VmoNombre'];  
					$Encuesta->VveNombre = $fila['VveNombre'];  
					
					
					
					$Encuesta->CliNombre = $fila['CliNombre'];  
					$Encuesta->CliApellidoPaterno = $fila['CliApellidoPaterno'];  
					$Encuesta->CliApellidoMaterno = $fila['CliApellidoMaterno'];  
					$Encuesta->CliTelefono = $fila['CliTelefono'];  
					$Encuesta->CliCelular = $fila['CliCelular'];  
					
					$Encuesta->PerNombre = $fila['PerNombre'];  
					$Encuesta->PerApellidoPaterno = $fila['PerApellidoPaterno'];  
					$Encuesta->PerApellidoMaterno = $fila['PerApellidoMaterno'];  
					
					
					
					$Encuesta->SucNombre = $fila['SucNombre']; 
					
					$Encuesta->EncNivel = $fila['EncNivel']; 
					
					$Encuesta->EncFechaTermino = $fila['EncFechaTermino']; 
					  
                    $Encuesta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Encuesta;
                } 
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarEncuesta($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (EncId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (EncId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblencencuesta WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarEncuesta($oTransaccion=true) {
	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			
			$this->MtdGenerarEncuestaId();
		
			$sql = 'INSERT INTO tblencencuesta (
			EncId,
			
			SucId,
			CliId,
			
			FinId,
			OvvId,
			
			EncFecha,
			EncTipo,
			EncVerbatin,
			EncObservacion,
			EncEstado,
			EncTiempoCreacion,
			EncTiempoModificacion
			) 
			VALUES (
			"'.($this->EncId).'", 
			
			"'.($this->SucId).'", 
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
			
			'.(empty($this->FinId)?"FinId,":'"'.$this->FinId.'",').'
			'.(empty($this->OvvId)?"OvvId,":'"'.$this->OvvId.'",').'
			
			"'.($this->EncFecha).'",
			"'.($this->EncTipo).'",
			"'.($this->EncVerbatin).'",
			"'.($this->EncObservacion).'",
			
			'.($this->EncEstado).', 
			"'.($this->EncTiempoCreacion).'", 
			"'.($this->EncTiempoModificacion).'");';					

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if(!$error){			
			
				if (!empty($this->EncuestaDetalle)){		
						
					$validar = 0;				
					$InsEncuestaDetalle = new ClsEncuestaDetalle();		
					
					foreach ($this->EncuestaDetalle as $DatEncuestaDetalle){
					
						$InsEncuestaDetalle->EncId = $this->EncId;
						$InsEncuestaDetalle->EprId = $DatEncuestaDetalle->EprId;
						$InsEncuestaDetalle->EdeRespuesta = $DatEncuestaDetalle->EdeRespuesta;
						
						$InsEncuestaDetalle->EdeEstado = $DatEncuestaDetalle->EdeEstado;									
						$InsEncuestaDetalle->EdeTiempoCreacion = $DatEncuestaDetalle->EdeTiempoCreacion;
						$InsEncuestaDetalle->EdeTiempoModificacion = $DatEncuestaDetalle->EdeTiempoModificacion;						
						$InsEncuestaDetalle->EdeEliminado = $DatEncuestaDetalle->EdeEliminado;
						
						if($InsEncuestaDetalle->MtdRegistrarEncuestaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_ENC_201';
							//$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->EncuestaDetalle) <> $validar ){
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
						
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarEncuesta($oTransaccion=true) {
		
						if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			$sql = 'UPDATE tblencencuesta SET 
		
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			
			'.(empty($this->FinId)?'FinId = NULL, ':'FinId = "'.$this->FinId.'",').'
			'.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
			
			EncFecha = "'.($this->EncFecha).'",
			EncTipo = "'.($this->EncTipo).'",
			
			EncVerbatin = "'.($this->EncVerbatin).'",
			EncObservacion = "'.($this->EncObservacion).'",
			EncEstado = "'.($this->EncEstado).'",
			EncTiempoModificacion = "'.($this->EncTiempoModificacion).'"
			WHERE EncId = "'.($this->EncId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if(!$error){
			
				if (!empty($this->EncuestaDetalle)){		
						
						
					$validar = 0;				
					$InsEncuestaDetalle = new ClsEncuestaDetalle();
							
					foreach ($this->EncuestaDetalle as $DatEncuestaDetalle){
										
						$InsEncuestaDetalle->EdeId = $DatEncuestaDetalle->EdeId;
						$InsEncuestaDetalle->EncId = $this->EncId;
						$InsEncuestaDetalle->EprId = $DatEncuestaDetalle->EprId;
						$InsEncuestaDetalle->EdeRespuesta = $DatEncuestaDetalle->EdeRespuesta;
						
						$InsEncuestaDetalle->EdeEstado = $DatEncuestaDetalle->EdeEstado;									
						$InsEncuestaDetalle->EdeTiempoCreacion = $DatEncuestaDetalle->EdeTiempoCreacion;
						$InsEncuestaDetalle->EdeTiempoModificacion = $DatEncuestaDetalle->EdeTiempoModificacion;						
						$InsEncuestaDetalle->EdeEliminado = $DatEncuestaDetalle->EdeEliminado;
						
						if(empty($InsEncuestaDetalle->EdeId)){
							if($InsEncuestaDetalle->EdeEliminado<>2){
								if($InsEncuestaDetalle->MtdRegistrarEncuestaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ENC_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsEncuestaDetalle->EdeEliminado==2){
								if($InsEncuestaDetalle->MtdEliminarEncuestaDetalle($InsEncuestaDetalle->EdeId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_ENC_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsEncuestaDetalle->MtdEditarEncuestaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ENC_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->EncuestaDetalle) <> $validar ){
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
						
				return true;
			}							
				
		}	
		
		
		
		
	
}
?>