<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFormaPago
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFormaPago {

    public $FpaId;

    public $FpaNombre;
	public $FpaDescripcion;
	public $FpaUso;
	
    public $FpaTiempoCreacion;
    public $FpaTiempoModificacion;
    public $FpaEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
	
	public function MtdGenerarFormaPagoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FpaId,5),unsigned)) AS "MAXIMO"
			FROM tblfpaformapago';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FpaId = "FPA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->FpaId = "FPA-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerFormaPago(){

        $sql = 'SELECT 
        fpa.FpaId,
        fpa.FpaNombre,
		fpa.FpaDescripcion,
		fpa.FpaUso
		
        FROM tblfpaformapago fpa
        WHERE FpaId = "'.$this->FpaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->FpaId = $fila['FpaId'];
			$this->FpaNombre = $fila['FpaNombre'];
			$this->FpaDescripcion = $fila['FpaDescripcion'];
			$this->FpaUso = $fila['FpaUso'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerFormaPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

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
		
		if(!empty($oUso)){
			$uso = ' AND fpa.FpaUso = '.($oUso).'';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fpa.FpaId,
				fpa.FpaNombre,
				fpa.FpaDescripcion,
				fpa.FpaUso
				FROM tblfpaformapago fpa
				WHERE 1 = 1 '.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFormaPago = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$FormaPago = new $InsFormaPago();
                    $FormaPago->FpaId = $fila['FpaId'];
					$FormaPago->FpaNombre= $fila['FpaNombre'];
					$FormaPago->FpaDescripcion= $fila['FpaDescripcion'];
					$FormaPago->FpaUso= $fila['FpaUso'];
                                   
                    $FormaPago->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FormaPago;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarFormaPago($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FpaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FpaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblfpaformapago WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarFormaPago() {
	
			$this->MtdGenerarFormaPagoId();
		
			$sql = 'INSERT INTO tblfpaformapago (
			FpaId,
			FpaNombre, 
			FpaDescripcion,
			FpaUso
			) 
			VALUES (
			"'.($this->FpaId).'", 
			"'.($this->FpaNombre).'", 
			"'.($this->FpaDescripcion).'", 
			'.($this->FpaUso).');';					

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
	
	public function MtdEditarFormaPago() {
		
			$sql = 'UPDATE tblfpaformapago SET 
			 FpaNombre = "'.($this->FpaNombre).'",
			 FpaDescripcion = "'.($this->FpaDescripcion).'",
			 FpaUso = '.($this->FpaUso).'
			 WHERE FpaId = "'.($this->FpaId).'";';
			
		
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