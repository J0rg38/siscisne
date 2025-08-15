<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGuiaRemisionTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGuiaRemisionTalonario {

    public $GrtId;
	
    public $GrtNumero;
	public $GrtInicio;
    public $GrtTiempoCreacion;
    public $GrtTiempoModificacion;
    public $GrtEliminado;
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

	public function MtdGenerarGuiaRemisionTalonarioId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(GrtId,5),unsigned)) AS "MAXIMO"
			FROM tblgrtguiaremisiontalonario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->GrtId = "GRT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->GrtId = "GRT-".$fila['MAXIMO'];					
			}
			
				
		}
		
    public function MtdObtenerGuiaRemisionTalonario(){

        $sql = 'SELECT 
        GrtId,
		SucId,
		
        GrtNumero,
		GrtInicio,
		DATE_FORMAT(GrtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGrtTiempoCreacion",
        DATE_FORMAT(GrtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGrtTiempoModificacion"	
        FROM tblgrtguiaremisiontalonario
        WHERE GrtId = "'.$this->GrtId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->GrtId = $fila['GrtId'];
			$this->SucId = $fila['SucId'];
			
            $this->GrtNumero = $fila['GrtNumero'];
			$this->GrtInicio = $fila['GrtInicio'];
			$this->GrtTiempoCreacion = $fila['NGrtTiempoCreacion'];
			$this->GrtTiempoModificacion = $fila['NGrtTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerGuiaRemisionTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GrtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oMultisucursal=false) {

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
				$sucursal = ' AND (grt.SucId = "'.$oSucursal.'" OR grt.SucId IS NULL)';				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				$sucursal = ' AND grt.SucId = "'.($oSucursal).'"';
			}
			
		}
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				grt.GrtId,
				grt.SucId,
			
				grt.GrtNumero,
				grt.GrtInicio,
				DATE_FORMAT(grt.GrtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGrtTiempoCreacion",
                DATE_FORMAT(grt.GrtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGrtTiempoModificacion"		,		
				
				suc.SucNombre
				
				FROM tblgrtguiaremisiontalonario grt
					LEFT JOIN tblsucsucursal suc
					ON grt.SucId = suc.SucId
					
				WHERE 1 = 1 '.$filtrar.$sucursal.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGuiaRemisionTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$GuiaRemisionTalonario = new $InsGuiaRemisionTalonario();
                    $GuiaRemisionTalonario->GrtId = $fila['GrtId'];
					$GuiaRemisionTalonario->SucId = $fila['SucId'];
					
                    $GuiaRemisionTalonario->GrtNumero= $fila['GrtNumero'];
                    $GuiaRemisionTalonario->GrtInicio= $fila['GrtInicio'];					
	                $GuiaRemisionTalonario->GrtTiempoCreacion = $fila['NGrtTiempoCreacion'];
                    $GuiaRemisionTalonario->GrtTiempoModificacion = $fila['NGrtTiempoModificacion'];                   
					
                    $GuiaRemisionTalonario->SucNombre = $fila['SucNombre'];                   
					
                    $GuiaRemisionTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GuiaRemisionTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	//Accion eliminar	 
	
	public function MtdEliminarGuiaRemisionTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (GrtId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GrtId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			
			$sql = 'DELETE FROM tblgrtguiaremisiontalonario WHERE '.$eliminar;
		
			
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
	
	
	public function MtdRegistrarGuiaRemisionTalonario() {
	
			$this->MtdGenerarGuiaRemisionTalonarioId();
		
			$sql = 'INSERT INTO tblgrtguiaremisiontalonario (
			GrtId,
			SucId,
			
			GrtNumero, 
			GrtInicio,
			GrtTiempoCreacion,
			GrtTiempoModificacion
			) 
			VALUES (
			"'.($this->GrtId).'", 
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
					
			"'.($this->GrtNumero).'", 
			"'.($this->GrtInicio).'", 
			"'.($this->GrtTiempoCreacion).'", 
			"'.($this->GrtTiempoModificacion).'");';					

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
	
	public function MtdEditarGuiaRemisionTalonario() {
		
			$sql = 'UPDATE tblgrtguiaremisiontalonario SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'
			
			 GrtNumero = "'.($this->GrtNumero).'",
			 GrtInicio = "'.($this->GrtInicio).'",
			 GrtTiempoModificacion = "'.($this->GrtTiempoModificacion).'"
			 WHERE GrtId = "'.($this->GrtId).'";';
			
		
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