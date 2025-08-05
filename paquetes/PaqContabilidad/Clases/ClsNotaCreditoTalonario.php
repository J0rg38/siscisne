<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCreditoTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCreditoTalonario {

    public $NctId;
    public $NctNumero;
	public $NctInicio;
    public $NctTiempoCreacion;
    public $NctTiempoModificacion;
    public $NctEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarNotaCreditoTalonarioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(NctId,5),unsigned)) AS "MAXIMO"
			FROM tblnctnotacreditotalonario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NctId = "NCT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->NctId = "NCT-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerNotaCreditoTalonario(){

        $sql = 'SELECT 
        NctId,
		SucId,
		
        NctNumero,
		NctInicio,
		NctDescripcion,
		
		DATE_FORMAT(NctTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNctTiempoCreacion",
        DATE_FORMAT(NctTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNctTiempoModificacion"	
        FROM tblnctnotacreditotalonario
        WHERE NctId = "'.$this->NctId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->NctId = $fila['NctId'];
			$this->SucId = $fila['SucId'];
			
            $this->NctNumero = $fila['NctNumero'];
			$this->NctInicio = $fila['NctInicio'];
			$this->NctDescripcion = $fila['NctDescripcion'];
			
			$this->NctTiempoCreacion = $fila['NNctTiempoCreacion'];
			$this->NctTiempoModificacion = $fila['NNctTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotaCreditoTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NctId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
	
		
			if($oMultisucursal){
			
			if(!empty($oSucursal)){				
				$sucursal = ' AND (nct.SucId = "'.$oSucursal.'" OR nct.SucId IS NULL)';				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				$sucursal = ' AND nct.SucId = "'.($oSucursal).'"';
			}
			
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				nct.NctId,
				nct.SucId,
				
				nct.NctNumero,
				nct.NctInicio,
				nct.NctDescripcion,
				
				DATE_FORMAT(nct.NctTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNctTiempoCreacion",
                DATE_FORMAT(nct.NctTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNctTiempoModificacion",
				
				suc.SucNombre
				
				FROM tblnctnotacreditotalonario nct
					LEFT JOIN tblsucsucursal suc
					ON nct.SucId = suc.SucId
					
				WHERE  1 = 1 '.$filtrar.$sucursal.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCreditoTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$NotaCreditoTalonario = new $InsNotaCreditoTalonario();
                    $NotaCreditoTalonario->NctId = $fila['NctId'];
					 $NotaCreditoTalonario->SucId = $fila['SucId'];
					 
                    $NotaCreditoTalonario->NctNumero= $fila['NctNumero'];
					$NotaCreditoTalonario->NctInicio= $fila['NctInicio'];
					$NotaCreditoTalonario->NctDescripcion= $fila['NctDescripcion'];
					
                    $NotaCreditoTalonario->NctTiempoCreacion = $fila['NNctTiempoCreacion'];
                    $NotaCreditoTalonario->NctTiempoModificacion = $fila['NNctTiempoModificacion'];   
					                
					$NotaCreditoTalonario->SucNombre = $fila['SucNombre'];   
					
					
                    $NotaCreditoTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $NotaCreditoTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	//Accion eliminar	 
	
	public function MtdEliminarNotaCreditoTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' NctId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (NctId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (NctId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
			
			$sql = 'DELETE FROM tblnctnotacreditotalonario WHERE '.$eliminar;
		
		
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
	
	
	public function MtdRegistrarNotaCreditoTalonario() {
	
			$this->MtdGenerarNotaCreditoTalonarioId();
		
			$sql = 'INSERT INTO tblnctnotacreditotalonario (
			NctId,
			SucId,
			
			NctNumero, 
			NctInicio,
			NctDescripcion,
			
			NctTiempoCreacion,
			NctTiempoModificacion
			) 
			VALUES (
			"'.($this->NctId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			"'.($this->NctNumero).'",
			"'.($this->NctInicio).'",
			"'.($this->NctDescripcion).'",
			 
			"'.($this->NctTiempoCreacion).'", 
			"'.($this->NctTiempoModificacion).'");';					

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
	
	public function MtdEditarNotaCreditoTalonario() {
		
			$sql = 'UPDATE tblnctnotacreditotalonario SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'
			
			 NctNumero = "'.($this->NctNumero).'",
			 NctInicio = "'.($this->NctInicio).'",
			 NctDescripcion = "'.($this->NctDescripcion).'",
			 NctTiempoModificacion = "'.($this->NctTiempoModificacion).'"
			 WHERE NctId = "'.($this->NctId).'";';
			
		
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