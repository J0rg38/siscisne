<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsModalidadPago
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsModalidadPago {

    public $MpaId;

    public $MpaNombre;
	public $MpaDescripcion;
	public $MpaUso;
	
    public $MpaTiempoCreacion;
    public $MpaTiempoModificacion;
    public $MpaEliminado;
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
	
	
	
	
	public function MtdGenerarModalidadPagoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MpaId,5),unsigned)) AS "MAXIMO"
			FROM tblmpamodalidadpago';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MpaId = "MPA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->MpaId = "MPA-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerModalidadPago(){

        $sql = 'SELECT 
        mpa.MpaId,
        mpa.MpaNombre,
		mpa.MpaDescripcion,
		mpa.MpaUso
		
        FROM tblmpamodalidadpago
        WHERE MpaId = "'.$this->MpaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->MpaId = $fila['MpaId'];
			$this->MpaNombre = $fila['MpaNombre'];
			$this->MpaDescripcion = $fila['MpaDescripcion'];
			$this->MpaUso = $fila['MpaUso'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    	public function MtdObtenerModalidadPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'MpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {
		
		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';

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
			$uso = ' AND mpa.MpaUso = '.($oUso).'';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				mpa.MpaId,
				mpa.MpaAbreviatura,
				mpa.MpaNombre,
				mpa.MpaDescripcion,
				mpa.MpaUso
				FROM tblmpamodalidadpago mpa
				WHERE 1 = 1 '.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsModalidadPago = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ModalidadPago = new $InsModalidadPago();
                    $ModalidadPago->MpaId = $fila['MpaId'];
					$ModalidadPago->MpaAbreviatura= $fila['MpaAbreviatura'];
					$ModalidadPago->MpaNombre= $fila['MpaNombre'];
					$ModalidadPago->MpaDescripcion= $fila['MpaDescripcion'];
					$ModalidadPago->MpaUso= $fila['MpaUso'];
                                   
                    $ModalidadPago->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ModalidadPago;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarModalidadPago($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MpaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MpaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblmpamodalidadpago WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarModalidadPago() {
	
			$this->MtdGenerarModalidadPagoId();
		
			$sql = 'INSERT INTO tblmpamodalidadpago (
			MpaId,
			MpaNombre, 
			MpaDescripcion,
			MpaUso
			) 
			VALUES (
			"'.($this->MpaId).'", 
			"'.($this->MpaNombre).'", 
			"'.($this->MpaDescripcion).'", 
			'.($this->MpaUso).');';					

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
	
	public function MtdEditarModalidadPago() {
		
			$sql = 'UPDATE tblmpamodalidadpago SET 
			 MpaNombre = "'.($this->MpaNombre).'",
			 MpaDescripcion = "'.($this->MpaDescripcion).'",
			 MpaUso = '.($this->MpaUso).'
			 WHERE MpaId = "'.($this->MpaId).'";';
			
		
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