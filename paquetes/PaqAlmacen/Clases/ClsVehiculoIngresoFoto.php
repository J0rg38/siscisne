<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngresoFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngresoFoto {

    public $VifId;	
    public $EinId;
	public $VifArchivo;
	public $VifEstado;
    public $VifTiempoCreacion;
    public $VifTiempoModificacion;
    public $VifEliminado;

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

	public function MtdGenerarVehiculoIngresoFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VifId,5),unsigned)) AS "MAXIMO"
			FROM tblvifvehiculoingresofoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VifId ="VIF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VifId = "VIF-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoIngresoFoto(){

        $sql = 'SELECT 
        vif.VifId,
		vif.VifArchivo,
        vif.EinId,
		vif.VifEstado,
		DATE_FORMAT(vif.VifTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVifTiempoCreacion",
        DATE_FORMAT(vif.VifTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVifTiempoModificacion"
        FROM tblvifvehiculoingresofoto vif
        WHERE vif.VifId = "'.$this->VifId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VifId = $fila['VifId'];
			$this->VifArchivo = $fila['VifArchivo'];
			$this->EinId = $fila['EinId'];
			$this->VifEstado = $fila['VifEstado'];
			$this->VifTiempoCreacion = $fila['NVifTiempoCreacion'];
			$this->VifTiempoModificacion = $fila['NVifTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VifId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL) {

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
		
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND vif.EinId = "'.($oVehiculoIngreso).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vif.VifId,
				vif.VifArchivo,
				vif.EinId,
				vif.VifEstado,
				DATE_FORMAT(vif.VifTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVifTiempoCreacion",
                DATE_FORMAT(vif.VifTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVifTiempoModificacion"
				
				FROM tblvifvehiculoingresofoto vif
				
						
				WHERE  1 = 1 '.$filtrar.$vingreso.$cliente.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngresoFoto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoIngresoFoto = new $InsVehiculoIngresoFoto();
                    $VehiculoIngresoFoto->VifId = $fila['VifId'];
					$VehiculoIngresoFoto->VifArchivo = $fila['VifArchivo'];
                    $VehiculoIngresoFoto->EinId = $fila['EinId'];
					
					$VehiculoIngresoFoto->VifEstado = $fila['VifEstado'];
                    $VehiculoIngresoFoto->VifTiempoCreacion = $fila['NVifTiempoCreacion'];
					$VehiculoIngresoFoto->VifTiempoModificacion = $fila['NVifTiempoModificacion'];
					
					$VehiculoIngresoFoto->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoIngresoFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoIngresoFoto($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VifId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VifId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VifId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvifvehiculoingresofoto WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoIngresoFoto() {
	
		$this->MtdGenerarVehiculoIngresoFotoId();
			
			$sql = 'INSERT INTO tblvifvehiculoingresofoto (
				VifId,
				VifArchivo,
				EinId, 
				VifEstado,
				VifTiempoCreacion,
				VifTiempoModificacion) 
				VALUES (
				"'.($this->VifId).'", 
				"'.($this->VifArchivo).'", 
				"'.($this->EinId).'", 
				'.($this->VifEstado).', 
				"'.($this->VifTiempoCreacion).'", 
				"'.($this->VifTiempoModificacion).'");';	
				
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
		public function MtdEditarVehiculoIngresoFoto() {
		
			$sql = 'UPDATE tblvifvehiculoingresofoto SET 
				VifArchivo = "'.($this->VifArchivo).'",
				VifEstado = '.($this->VifEstado).',
				VifTiempoModificacion = "'.($this->VifTiempoModificacion).'"
				WHERE VifId = "'.($this->VifId).'";';
				 
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