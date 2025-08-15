<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsBoletaTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsBoletaTalonario {

    public $BtaId;

    public $BtaNumero;
	public $BtaInicio;
    public $BtaTiempoCreacion;
    public $BtaTiempoModificacion;
    public $BtaEliminado;
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

	public function MtdGenerarBoletaTalonarioId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(BtaId,5),unsigned)) AS "MAXIMO"
			FROM tblbtaboletatalonario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->BtaId = "BTA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->BtaId = "BTA-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerBoletaTalonario(){

        $sql = 'SELECT 
        BtaId,
		SucId,
		
        BtaNumero,
		BtaInicio,
		BtaDescripcion,
		DATE_FORMAT(BtaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBtaTiempoCreacion",
        DATE_FORMAT(BtaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBtaTiempoModificacion"	
        FROM tblbtaboletatalonario
        WHERE BtaId = "'.$this->BtaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->BtaId = $fila['BtaId'];
			$this->SucId = $fila['SucId'];
			
            $this->BtaNumero = $fila['BtaNumero'];
			$this->BtaInicio = $fila['BtaInicio'];
			$this->BtaDescripcion = $fila['BtaDescripcion'];
			
			$this->BtaTiempoCreacion = $fila['NBtaTiempoCreacion'];
			$this->BtaTiempoModificacion = $fila['NBtaTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerBoletaTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BtaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false) {

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
				$sucursal = ' AND (bta.SucId = "'.$oSucursal.'" OR bta.SucId IS NULL)';				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				$sucursal = ' AND bta.SucId = "'.($oSucursal).'"';
			}
			
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bta.BtaId,
				bta.SucId,
				
				bta.BtaNumero,
				bta.BtaInicio,
				bta.BtaDescripcion,
				
				DATE_FORMAT(bta.BtaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBtaTiempoCreacion",
                DATE_FORMAT(bta.BtaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBtaTiempoModificacion",
				
				suc.SucNombre
				
				FROM tblbtaboletatalonario bta
					LEFT JOIN tblsucsucursal suc
					ON bta.SucId = suc.SucId
					
				WHERE  1 = 1 '.$filtrar.$sucursal.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBoletaTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$BoletaTalonario = new $InsBoletaTalonario();
                    $BoletaTalonario->BtaId = $fila['BtaId'];
					 $BoletaTalonario->SucId = $fila['SucId'];
					
                    $BoletaTalonario->BtaNumero= $fila['BtaNumero'];
					$BoletaTalonario->BtaInicio= $fila['BtaInicio'];
					$BoletaTalonario->BtaDescripcion= $fila['BtaDescripcion'];
					
                    $BoletaTalonario->BtaTiempoCreacion = $fila['NBtaTiempoCreacion'];
                    $BoletaTalonario->BtaTiempoModificacion = $fila['NBtaTiempoModificacion'];                   
					
					$BoletaTalonario->SucNombre = $fila['SucNombre'];                   
					
                    $BoletaTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $BoletaTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

	
	//Accion eliminar	 
	
	public function MtdEliminarBoletaTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (BtaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (BtaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			
			$sql = 'DELETE FROM tblbtaboletatalonario WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarBoletaTalonario() {
	
			$this->MtdGenerarBoletaTalonarioId();
		
			$sql = 'INSERT INTO tblbtaboletatalonario (
			BtaId,
			SucId,
			
			BtaNumero,
		  	BtaInicio ,
			BtaDescripcion,
			
			BtaTiempoCreacion,
			BtaTiempoModificacion
			) 
			VALUES (
			"'.($this->BtaId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			"'.($this->BtaNumero).'", 
			"'.($this->BtaInicio).'", 
			"'.($this->BtaDescripcion).'",
			
			"'.($this->BtaTiempoCreacion).'", 
			"'.($this->BtaTiempoModificacion).'");';					

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
	
	public function MtdEditarBoletaTalonario() {
		
			$sql = 'UPDATE tblbtaboletatalonario SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'
			
			 BtaNumero = "'.($this->BtaNumero).'",
			 BtaInicio = "'.($this->BtaInicio).'",
			  BtaDescripcion = "'.($this->BtaDescripcion).'",
			  
			 BtaTiempoModificacion = "'.($this->BtaTiempoModificacion).'"
			 WHERE BtaId = "'.($this->BtaId).'";';
			
		
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