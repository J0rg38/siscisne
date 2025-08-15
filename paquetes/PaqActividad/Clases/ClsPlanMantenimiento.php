<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPlanMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPlanMantenimiento {

    public $PmaId;
    public $PmaNombre;
	public $PmaDuracion;	
	
	public $VmaId;
	public $VmoId;
	public $VveId;
	
    public $PmaTiempoCreacion;
    public $PmaTiempoModificacion;
    public $PmaEliminado;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $VmoNombreComercial;
	
    public $InsMysql;
	
	public $PmaChevroletKilometrajes;
	public $PmaChevroletKilometrajesResumen;
	public $PmaIsuzuKilometrajes;
	public $PmaIsuzuKilometrajesResumen;
	public $PmaChevroletKilometrajesNuevo;
	public $PmaIsuzuKilometrajesNuevo;
	
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

	public function MtdGenerarPlanMantenimientoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PmaId,5),unsigned)) AS "MAXIMO"
			FROM tblpmaplanmantenimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PmaId = "PMA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PmaId = "PMA-".$fila['MAXIMO'];					
			}		
			
					
		}
		
			
    public function MtdObtenerPlanMantenimiento(){

        $sql = 'SELECT 
        pma.PmaId,
        pma.PmaNombre,
		pma.PmaDuracion,

		vmo.VmaId,
		pma.VmoId,
		pma.VveId,

		DATE_FORMAT(pma.PmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoCreacion",
        DATE_FORMAT(pma.PmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoModificacion"	,
		vve.VveNombre,
		vmo.VmoNombre,
		vmo.VmoNombreComercial,
		
		vma.VmaNombre
		
        FROM tblpmaplanmantenimiento pma
			LEFT JOIN tblvvevehiculoversion vve
			ON pma.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
		WHERE pma.PmaId = "'.$this->PmaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PmaId = $fila['PmaId'];
            $this->PmaNombre = $fila['PmaNombre'];
			$this->PmaDuracion = $fila['PmaDuracion'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmoId = $fila['VmoId'];
			$this->VveId = $fila['VveId'];
			
			$this->PmaTiempoCreacion = $fila['NPmaTiempoCreacion'];
			$this->PmaTiempoModificacion = $fila['NPmaTiempoModificacion']; 
			
			$this->VveNombre = $fila['VveNombre']; 
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VmoNombreComercial = $fila['VmoNombreComercial']; 
			$this->VmaNombre = $fila['VmaNombre']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPlanMantenimientos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$vversion = '';
		$vmodelo = '';
		$vmarca = '';

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
				
				$filtrar .= '  ) ';

			
	
		}


		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
	
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND pma.VveId = "'.$oVehiculoVersion.'"';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';
		}

	
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}


		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		pma.PmaId,
        pma.PmaNombre,
		pma.PmaDuracion,
		
		vmo.VmaId,
		pma.VmoId,
		pma.VveId,
		
		DATE_FORMAT(pma.PmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoCreacion",
        DATE_FORMAT(pma.PmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoModificacion"	,
		vve.VveNombre,
		vmo.VmoNombre,
		vma.VmaNombre,
		
		



				CASE
				WHEN EXISTS (
					
					SELECT 
					pmd.PmdId
					FROM tblpmdplanmantenimientodetalle pmd
					WHERE pmd.PmaId = pma.PmaId 
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS PmaPlanMantenimientoDetalle,
				
				
					CASE
				WHEN EXISTS (
					
					SELECT 
					tpr.TprId
					FROM tbltprtareaproducto tpr
					WHERE tpr.PmaId = pma.PmaId 
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS PmaTareaProducto
							
				
				
		
        FROM tblpmaplanmantenimiento pma
			LEFT JOIN tblvvevehiculoversion vve
			ON pma.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
				WHERE 1  = 1 '.$filtrar.$vversion.$vmarca.$vmodelo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPlanMantenimiento = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$PlanMantenimiento = new $InsPlanMantenimiento();
                    $PlanMantenimiento->PmaId = $fila['PmaId'];
                    $PlanMantenimiento->PmaNombre= $fila['PmaNombre'];
					$PlanMantenimiento->PmaDuracion= $fila['PmaDuracion'];
					
					$PlanMantenimiento->VmaId = $fila['VmaId'];
					$PlanMantenimiento->VmoId = $fila['VmoId'];
					$PlanMantenimiento->VveId= $fila['VveId'];
					
                    $PlanMantenimiento->PmaTiempoCreacion = $fila['NPmaTiempoCreacion'];
                    $PlanMantenimiento->PmaTiempoModificacion = $fila['NPmaTiempoModificacion'];    

			$PlanMantenimiento->VveNombre = $fila['VveNombre']; 
			$PlanMantenimiento->VmoNombre = $fila['VmoNombre']; 
			$PlanMantenimiento->VmaNombre = $fila['VmaNombre']; 
			
			
			$PlanMantenimiento->PmaPlanMantenimientoDetalle = $fila['PmaPlanMantenimientoDetalle']; 
			$PlanMantenimiento->PmaTareaProducto = $fila['PmaTareaProducto']; 
			
			
			
			
					$PlanMantenimiento->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$PlanMantenimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	//public function MtdEliminarPlanMantenimiento($oElementos) {
//		
//		$elementos = explode("#",$oElementos);
//		
//
//			$i=1;
//			foreach($elementos as $elemento){
//				if(!empty($elemento)){
//				
//					if($i==count($elementos)){						
//						$eliminar .= '  (PmaId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (PmaId = "'.($elemento).'")  OR';	
//					}	
//				}
//			$i++;
//	
//			}
//	
//			$sql = 'DELETE FROM tblpmaplanmantenimiento WHERE '.$eliminar;
//		
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}							
//	}
	
	
	//public function MtdRegistrarPlanMantenimiento() {
//	
//			$this->MtdGenerarPlanMantenimientoId();
//			
//			$sql = 'INSERT INTO tblpmaplanmantenimiento (
//			PmaId,
//			PmaNombre, 
//			PmaDuracion,
//			VmoId,
//			VveId,
//			PmaTiempoCreacion,
//			PmaTiempoModificacion) 
//			VALUES (
//			"'.($this->PmaId).'", 
//			"'.htmlentities($this->PmaNombre).'", 
//			"'.($this->PmaDuracion).'", 
//			"'.($this->VmoId).'", 
//			"'.($this->VveId).'", 			
//			"'.($this->PmaTiempoCreacion).'", 
//			"'.($this->PmaTiempoModificacion).');';					
//
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}			
//			
//	}
//	
//	public function MtdEditarPlanMantenimiento() {
//		
//		$sql = 'UPDATE tblpmaplanmantenimiento SET 
//		PmaNombre = "'.($this->PmaNombre).'",
//		PmaDuracion = "'.($this->PmaDuracion).'",
//		VmoId = "'.($this->VmoId).'",
//		VveId = "'.($this->VveId).'",
//		PmaTiempoModificacion = "'.($this->PmaTiempoModificacion).'"
//		WHERE PmaId = "'.($this->PmaId).'";';
//		
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}						
//				
//	}	
		
		
		
		
	
}
?>