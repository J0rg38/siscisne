<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsRolZonaPrivilegio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsRolZonaPrivilegio {

    public $RzpId;
	public $RolId;
	public $ZprId;

	public $ZonNombre;
	public $PriNombre;
	public $PriAlias;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarRolZonaPrivilegioId() {

			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RzpId,5),unsigned)) AS "MAXIMO"
			FROM tblrzprolzonaprivilegio';
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RzpId = "RZP-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RzpId = "RZP-".$fila['MAXIMO'];					
			}
				
						
		}
		
//    public function MtdObtenerRolZonaPrivilegio(){
//
//        $sql = 'SELECT 
//        RzpId,
//		RolId,
//		ZprId
//        FROM tblrzprolzonaprivilegio
//        WHERE RzpId = '.$this->RzpId.';';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//        {
//			$this->RzpId = $fila['RzpId'];
//			$this->RolId = $fila['RolId'];	
//			$this->ZprId = $fila['ZprId'];	
//		}
//        
//		return $this;
//
//    }

    public function MtdObtenerRolZonaPrivilegios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RzpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oRol=NULL) {

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
				rzp.RzpId,
				rzp.RolId,
				rzp.ZprId,
				zon.ZonNombre,
				pri.PriNombre,
				pri.PriAlias
										
				FROM tblrzprolzonaprivilegio rzp

				LEFT JOIN tblzprzonaprivilegio zpr
				ON rzp.ZprId = zpr.ZprId

				LEFT JOIN tblzonzona zon
				ON zpr.ZonId = zon.ZonId
				
				LEFT JOIN tblpriprivilegio pri
				ON zpr.PriId = pri.PriId
				
				WHERE RolId = "'.$oRol.'" '.$filtrar.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			$Respuesta['Ids'] = '';
			
            $InsRolZonaPrivilegio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$RolZonaPrivilegio = new $InsRolZonaPrivilegio();
                    $RolZonaPrivilegio->RzpId = $fila['RzpId'];
                 	$RolZonaPrivilegio->RolId= $fila['RolId'];		
					$RolZonaPrivilegio->ZprId= $fila['ZprId'];
					
					$RolZonaPrivilegio->ZonNombre = $fila['ZonNombre'];
					$RolZonaPrivilegio->PriNombre= $fila['PriNombre'];
					
					$RolZonaPrivilegio->PriAlias= $fila['PriAlias'];
                   
                    $RolZonaPrivilegio->InsMysql = NULL;     
					   
					$Respuesta['Ids'].= "#".$RolZonaPrivilegio->RzpId;        
					$Respuesta['Datos'][]= $RolZonaPrivilegio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	//Accion eliminar	 
	
	public function MtdEliminarRolZonaPrivilegio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' RzpId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (RzpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RzpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE from tblrzprolzonaprivilegio WHERE '.$eliminar;
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);     //OJO transaccion false   
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarRolZonaPrivilegio() {
	
			$this->MtdGenerarRolZonaPrivilegioId();
		
			$sql = 'INSERT INTO tblrzprolzonaprivilegio (
			RzpId,			
			RolId,
			ZprId) 
			VALUES (
			"'.($this->RzpId).'", 
			"'.($this->RolId).'", 			
			"'.($this->ZprId).'");';					

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);   //OJO transaccion false     
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarRolZonaPrivilegio() {
		
			$sql = 'UPDATE tblrzprolzonaprivilegio SET 			
			 ZprId = '.($this->ZprId).'			
			 WHERE RzpId = '.($this->RzpId);
			
		
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
		

	
}
?>