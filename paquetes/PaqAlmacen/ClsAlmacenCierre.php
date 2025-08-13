<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenCierre
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenCierre {

    public $AciId;
    public $AciFechaInicio;
    public $AciFechaFin;
    public $PerId;
	
	public $AciEntradasTotalCompras;
	public $AciEntradasTotalOtrasFichas;
	public $AciEntradasTotalTransferencias;
	public $AciEntradasTotalConversiones;
	
	public $AciSalidasTotalFichaIngresos;
	public $AciSalidasTotalVentaConcretadas;
	public $AciSalidasTotalOtrasFichas;
	public $AciSalidasTotalTransferencias;
	public $AciSalidasTotalConversiones;
		
	public $AciObservacion;
	public $AciEstado;	
    public $AciTiempoCreacion;
    public $AciTiempoModificacion;
    public $AciEliminado;

	public $InsMysql;


    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarAlmacenCierreId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AciId,5),unsigned)) AS "MAXIMO"
			FROM tblacialmacencierre';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AciId = "ACI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->AciId = "ACI-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerAlmacenCierre(){

        $sql = 'SELECT 
        AciId,
		
		DATE_FORMAT(AciFechaInicio, "%d/%m/%Y") AS "NAciFechaInicio",
		DATE_FORMAT(AciFechaFin, "%d/%m/%Y") AS "NAciFechaFin",
		
		PerId,
		
		
		AciEntradasTotalCompras,
		AciEntradasTotalOtrasFichas,
		AciEntradasTotalTransferencias,
		AciEntradasTotalConversiones,
		
		AciSalidasTotalFichaIngresos,
		AciSalidasTotalVentaConcretadas,
		AciSalidasTotalOtrasFichas,
		AciSalidasTotalTransferencias,
		AciSalidasTotalConversiones,
	
		AciObservacion,
		AciEstado,	
		DATE_FORMAT(AciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAciTiempoCreacion",
        DATE_FORMAT(AciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAciTiempoModificacion"
        FROM tblacialmacencierre
        WHERE AciId = "'.$this->AciId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->AciId = $fila['AciId'];
            $this->AciFechaInicio = $fila['NAciFechaInicio'];
			$this->AciFechaFin = $fila['NAciFechaFin'];
			$this->PerId = $fila['PerId'];
		
			$this->AciEntradasTotalCompras = $fila['AciEntradasTotalCompras'];										
			$this->AciEntradasTotalOtrasFichas = $fila['AciEntradasTotalOtrasFichas'];										
			$this->AciEntradasTotalTransferencias = $fila['AciEntradasTotalTransferencias'];										
			$this->AciEntradasTotalConversiones = $fila['AciEntradasTotalConversiones'];										
			
			$this->AciSalidasTotalFichaIngresos = $fila['AciSalidasTotalFichaIngresos'];										
			$this->AciSalidasTotalVentaConcretadas = $fila['AciSalidasTotalVentaConcretadas'];										
			$this->AciSalidasTotalOtrasFichas = $fila['AciSalidasTotalOtrasFichas'];										
			$this->AciSalidasTotalTransferencias = $fila['AciSalidasTotalTransferencias'];										
			$this->AciSalidasTotalConversiones = $fila['AciSalidasTotalConversiones'];										
			
			$this->AciObservacion = $fila['AciObservacion'];										
			$this->AciEstado = $fila['AciEstado'];
			$this->AciTiempoCreacion = $fila['NAciTiempoCreacion'];
			$this->AciTiempoModificacion = $fila['NAciTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAlmacenCierres($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';
		$moneda = '';
		$tipo = '';
		$banco = '';
		$tarjeta = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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

		if(!empty($oEstado)){
			$estado = ' AND aci.AciEstado = '.$oEstado;
		}	
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				aci.AciId,
				DATE_FORMAT(AciFechaInicio, "%d/%m/%Y") AS "NAciFechaInicio",
				DATE_FORMAT(AciFechaFin, "%d/%m/%Y") AS "NAciFechaFin",
		
				aci.PerId,
				
				aci.AciEntradasTotalCompras,
				aci.AciEntradasTotalOtrasFichas,
				aci.AciEntradasTotalTransferencias,
				aci.AciEntradasTotalConversiones,
		
				aci.AciSalidasTotalFichaIngresos,
				aci.AciSalidasTotalVentaConcretadas,
				aci.AciSalidasTotalOtrasFichas,
				aci.AciSalidasTotalTransferencias,
				aci.AciSalidasTotalConversiones,
				
				aci.AciObservacion,
				aci.AciEstado,
				DATE_FORMAT(aci.AciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAciTiempoCreacion",
                DATE_FORMAT(aci.AciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAciTiempoModificacion",
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
			
				FROM tblacialmacencierre aci
					LEFT JOIN tblperpersonal per
					ON aci.PerId = per.PerId
							
				WHERE 1 = 1 '.$filtrar.$moneda.$tipo.$estado.$banco.$tarjeta.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenCierre = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenCierre = new $InsAlmacenCierre();				
					
                    $AlmacenCierre->AciId = $fila['AciId'];
                    $AlmacenCierre->AciFechaInicio= $fila['NAciFechaInicio'];
					$AlmacenCierre->AciFechaFin = $fila['NAciFechaFin'];
					$AlmacenCierre->PerId= $fila['PerId'];
					
					
					
						$AlmacenCierre->AciEntradasTotalCompras = $fila['AciEntradasTotalCompras'];										
					$AlmacenCierre->AciEntradasTotalOtrasFichas = $fila['AciEntradasTotalOtrasFichas'];										
					$AlmacenCierre->AciEntradasTotalTransferencias = $fila['AciEntradasTotalTransferencias'];										
					$AlmacenCierre->AciEntradasTotalConversiones = $fila['AciEntradasTotalConversiones'];										
					
					$AlmacenCierre->AciSalidasTotalFichaIngresos = $fila['AciSalidasTotalFichaIngresos'];										
					$AlmacenCierre->AciSalidasTotalVentaConcretadas = $fila['AciSalidasTotalVentaConcretadas'];										
					$AlmacenCierre->AciSalidasTotalOtrasFichas = $fila['AciSalidasTotalOtrasFichas'];										
					$AlmacenCierre->AciSalidasTotalTransferencias = $fila['AciSalidasTotalTransferencias'];										
					$AlmacenCierre->AciSalidasTotalConversiones = $fila['AciSalidasTotalConversiones'];		
					
			
			
					$AlmacenCierre->AciObservacion = $fila['AciObservacion'];
					$AlmacenCierre->AciEstado = $fila['AciEstado'];
                    $AlmacenCierre->AciTiempoCreacion = $fila['NAciTiempoCreacion'];
					$AlmacenCierre->AciTiempoModificacion = $fila['NAciTiempoModificacion'];
					
					$AlmacenCierre->PerNombre = $fila['PerNombre'];
					$AlmacenCierre->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$AlmacenCierre->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
							
                    $AlmacenCierre->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenCierre;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarAlmacenCierre($oElementos) {
		
		// Inicializar variable
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AciId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AciId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblacialmacencierre WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarAlmacenCierre() {
	
			$this->MtdGenerarAlmacenCierreId();
		
			$sql = 'INSERT INTO tblacialmacencierre (
			AciId,
			AciFechaInicio,
			AciFechaFin,
			PerId,
			
			AciEntradasTotalCompras,
			AciEntradasTotalOtrasFichas,
			AciEntradasTotalTransferencias,
			AciEntradasTotalConversiones,
		
			AciSalidasTotalFichaIngresos,
			AciSalidasTotalVentaConcretadas,
			AciSalidasTotalOtrasFichas,
			AciSalidasTotalTransferencias,
			AciSalidasTotalConversiones,
			
			AciObservacion,
			AciEstado,
			AciTiempoCreacion,
			AciTiempoModificacion
			) 
			VALUES (
			"'.($this->AciId).'", 
			"'.($this->AciFechaInicio).'",
			"'.($this->AciFechaFin).'",
			
			"'.($this->PerId).'",
			
			'.($this->AciEntradasTotalCompras).', 
			'.($this->AciEntradasTotalOtrasFichas).', 
			'.($this->AciEntradasTotalTransferencias).', 
			'.($this->AciEntradasTotalConversiones).', 
			
			'.($this->AciSalidasTotalFichaIngresos).', 
			'.($this->AciSalidasTotalVentaConcretadas).', 
			'.($this->AciSalidasTotalOtrasFichas).', 
			'.($this->AciSalidasTotalTransferencias).', 
			'.($this->AciSalidasTotalConversiones).', 
			
			"'.($this->AciObservacion).'", 
			'.($this->AciEstado).', 
			"'.($this->AciTiempoCreacion).'", 
			"'.($this->AciTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarAlmacenCierre() {
		

			$sql = 'UPDATE tblacialmacencierre SET 
			AciFechaInicio = "'.($this->AciFechaInicio).'",
			AciFechaFin = "'.($this->AciFechaFin).'",
			PerId = "'.($this->PerId ).'",
			
			AciEntradasTotalCompras = '.($this->AciEntradasTotalCompras ).',
			AciEntradasTotalOtrasFichas = '.($this->AciEntradasTotalOtrasFichas ).',
			AciEntradasTotalTransferencias = '.($this->AciEntradasTotalTransferencias ).',
			AciEntradasTotalConversiones = '.($this->AciEntradasTotalConversiones ).',
			
			AciSalidasTotalFichaIngresos = '.($this->AciSalidasTotalFichaIngresos ).',
			AciSalidasTotalVentaConcretadas = '.($this->AciSalidasTotalVentaConcretadas ).',
			AciSalidasTotalOtrasFichas = '.($this->AciSalidasTotalOtrasFichas ).',
			AciSalidasTotalTransferencias = '.($this->AciSalidasTotalTransferencias ).',
			AciSalidasTotalConversiones = '.($this->AciSalidasTotalConversiones ).',
			
			 AciObservacion = "'.($this->AciObservacion).'",
			 AciEstado = '.($this->AciEstado).',
			 AciTiempoModificacion = "'.($this->AciTiempoModificacion).'"
			 WHERE AciId = "'.($this->AciId).'";';
			
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
		
		
		
		
	
}
?>