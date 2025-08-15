<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteRetencionTalonario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteRetencionTalonario {

    public $CrtId;

    public $CrtNumero;
	public $CrtInicio;
    public $CrtTiempoCreacion;
    public $CrtTiempoModificacion;
    public $CrtEliminado;
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

	public function MtdGenerarComprobanteRetencionTalonarioId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(CrtId,5),unsigned)) AS "MAXIMO"
		FROM tblcrtcomprobanteretenciontalonario';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->CrtId = "CRT-10000";
		}else{
			$fila['MAXIMO']++;
			$this->CrtId = "CRT-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerComprobanteRetencionTalonario(){

        $sql = 'SELECT 
        CrtId,
	
        CrtNumero,
		CrtInicio,
		DATE_FORMAT(CrtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrtTiempoCreacion",
        DATE_FORMAT(CrtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrtTiempoModificacion"	
        FROM tblcrtcomprobanteretenciontalonario
        WHERE CrtId = "'.$this->CrtId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CrtId = $fila['CrtId'];
			
            $this->CrtNumero = $fila['CrtNumero'];
			$this->CrtInicio = $fila['CrtInicio'];
			$this->CrtTiempoCreacion = $fila['NCrtTiempoCreacion'];
			$this->CrtTiempoModificacion = $fila['NCrtTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerComprobanteRetencionTalonarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CrtId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				CrtId,
			
				CrtNumero,
				CrtInicio,
				DATE_FORMAT(CrtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrtTiempoCreacion",
                DATE_FORMAT(CrtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrtTiempoModificacion"				
				FROM tblcrtcomprobanteretenciontalonario
				WHERE  1 = 1 '.$filtrar.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsComprobanteRetencionTalonario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ComprobanteRetencionTalonario = new $InsComprobanteRetencionTalonario();
                    $ComprobanteRetencionTalonario->CrtId = $fila['CrtId'];
					
                    $ComprobanteRetencionTalonario->CrtNumero= $fila['CrtNumero'];
					$ComprobanteRetencionTalonario->CrtInicio= $fila['CrtInicio'];
					
                    $ComprobanteRetencionTalonario->CrtTiempoCreacion = $fila['NCrtTiempoCreacion'];
                    $ComprobanteRetencionTalonario->CrtTiempoModificacion = $fila['NCrtTiempoModificacion'];                   
                    $ComprobanteRetencionTalonario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ComprobanteRetencionTalonario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

	
	//Accion eliminar	 
	
	public function MtdEliminarComprobanteRetencionTalonario($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CrtId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CrtId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			
			$sql = 'DELETE FROM tblcrtcomprobanteretenciontalonario WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarComprobanteRetencionTalonario() {
	
			$this->MtdGenerarComprobanteRetencionTalonarioId();
		
			$sql = 'INSERT INTO tblcrtcomprobanteretenciontalonario (
			CrtId,
			
			CrtNumero,
		  	CrtInicio ,
			CrtTiempoCreacion,
			CrtTiempoModificacion
			) 
			VALUES (
			"'.($this->CrtId).'", 
				
			"'.($this->CrtNumero).'", 
			"'.($this->CrtInicio).'", 
			
			"'.($this->CrtTiempoCreacion).'", 
			"'.($this->CrtTiempoModificacion).'");';					

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
	
	public function MtdEditarComprobanteRetencionTalonario() {
		
			$sql = 'UPDATE tblcrtcomprobanteretenciontalonario SET 
			 CrtNumero = "'.($this->CrtNumero).'",
			 CrtInicio = "'.($this->CrtInicio).'",
			 CrtTiempoModificacion = "'.($this->CrtTiempoModificacion).'"
			 WHERE CrtId = "'.($this->CrtId).'";';
			
		
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