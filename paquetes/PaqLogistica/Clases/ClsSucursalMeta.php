<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSucursalMeta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSucursalMeta {

    public $SmeId;
	public $SucId;
	public $SmeActividad;
    public $SmeAno;
	public $SmeMes;
	public $SmeCantidad;
	public $SmeCantidadMinima;

	public $SmeEstado;	
    public $SmeTiempoCreacion;
    public $SmeTiempoModificacion;
    public $SmeEliminado;

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
		
	public function MtdGenerarSucursalMetaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SmeId,5),unsigned)) AS "MAXIMO"
			FROM tblsmesucursalmeta';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SmeId = "SME-10000";

			}else{
				$fila['MAXIMO']++;
				$this->SmeId = "SME-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerSucursalMeta(){

        $sql = 'SELECT 
        sme.SmeId,
		sme.SucId,
		sme.SmeActividad,
		sme.SmeAno,
		sme.SmeMes,
		sme.SmeCantidad,
		sme.SmeCantidadMinima,
	
		sme.SmeEstado,	
		DATE_FORMAT(sme.SmeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSmeTiempoCreacion",
        DATE_FORMAT(sme.SmeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSmeTiempoModificacion",
		suc.SucNombre
        FROM tblsmesucursalmeta sme
			LEFT JOIN tblsucsucursal suc
			ON sme.SucId = suc.SucId
        WHERE SmeId = "'.$this->SmeId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SmeId = $fila['SmeId'];
			$this->SucId = $fila['SucId'];
			$this->SmeActividad = $fila['SmeActividad'];			
            $this->SmeAno = $fila['SmeAno'];
			$this->SmeMes = $fila['SmeMes'];
			$this->SmeCantidad = $fila['SmeCantidad'];
			$this->SmeCantidadMinima = $fila['SmeCantidadMinima'];
			
			$this->SmeEstado = $fila['SmeEstado'];
			$this->SmeTiempoCreacion = $fila['NSmeTiempoCreacion'];
			$this->SmeTiempoModificacion = $fila['NSmeTiempoModificacion'];

			$this->SucNombre = $fila['SucNombre'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerSucursalMetas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oActividad=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND sme.SmeEstado = '.$oEstado;
		}	
		
		if(!empty($oAno)){
			$ano = ' AND sme.SmeAno = "'.$oAno.'"';
		}	
		
		if(!empty($oMes)){
			$mes = ' AND sme.SmeMes = "'.$oMes.'"';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND sme.SucId = "'.$oSucursal.'"';
		}	
		
			if(!empty($oActividad)){
			$actividad = ' AND sme.SmeActividad = "'.$oActividad.'"';
		}	
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sme.SmeId,
				sme.SucId,
				sme.SmeActividad,		
				sme.SmeAno,
				sme.SmeMes,
				sme.SmeCantidad,
				sme.SmeCantidadMinima,
				
				sme.SmeEstado,
				DATE_FORMAT(sme.SmeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSmeTiempoCreacion",
                DATE_FORMAT(sme.SmeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSmeTiempoModificacion",
				suc.SucNombre
				FROM tblsmesucursalmeta sme	
					LEFT JOIN tblsucsucursal suc
					ON sme.SucId = suc.SucId
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$ano.$mes.$actividad.$sucursal.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSucursalMeta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$SucursalMeta = new $InsSucursalMeta();				
					
                    $SucursalMeta->SmeId = $fila['SmeId'];
					$SucursalMeta->SucId = $fila['SucId'];
					$SucursalMeta->SmeActividad= $fila['SmeActividad'];
                    $SucursalMeta->SmeAno= $fila['SmeAno'];
					$SucursalMeta->SmeMes = $fila['SmeMes'];
					$SucursalMeta->SmeCantidad= $fila['SmeCantidad'];
					$SucursalMeta->SmeCantidadMinima = $fila['SmeCantidadMinima'];
					
					$SucursalMeta->SmeEstado = $fila['SmeEstado'];					
                    $SucursalMeta->SmeTiempoCreacion = $fila['NSmeTiempoCreacion'];
                    $SucursalMeta->SmeTiempoModificacion = $fila['NSmeTiempoModificacion'];    

					$SucursalMeta->SucNombre = $fila['SucNombre'];    
					
                    $SucursalMeta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SucursalMeta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarSucursalMeta($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SmeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SmeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblsmesucursalmeta WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarSucursalMeta() {

			$this->MtdGenerarSucursalMetaId();
		
			$sql = 'INSERT INTO tblsmesucursalmeta (
			SmeId,
			SucId,
			SmeAno,
			SmeMes,
			SmeCantidad,
			SmeActividad,
			SmeCantidadMinima,
			
			SmeEstado,
			SmeTiempoCreacion,
			SmeTiempoModificacion
			) 
			VALUES (
			"'.($this->SmeId).'", 
			"'.($this->SucId).'",
			"'.($this->SmeAno).'",
			"'.($this->SmeMes).'",
			"'.($this->SmeCantidad).'",			
			"'.($this->SmeActividad).'",
			"'.($this->SmeCantidadMinima).'",
			
			'.($this->SmeEstado).', 
			"'.($this->SmeTiempoCreacion).'", 
			"'.($this->SmeTiempoModificacion).'");';

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
	

	public function MtdEditarSucursalMeta() {
		

			$sql = 'UPDATE tblsmesucursalmeta SET 
			SucId = "'.($this->SucId).'",
			SmeAno = "'.($this->SmeAno).'",
			SmeMes = "'.($this->SmeMes).'",
			SmeCantidad = "'.($this->SmeCantidad).'",
			SmeActividad = "'.($this->SmeActividad).'",
			
			SmeCantidadMinima = "'.($this->SmeCantidadMinima).'",
			
			SmeEstado = '.($this->SmeEstado).',
			SmeTiempoModificacion = "'.($this->SmeTiempoModificacion).'"
			WHERE SmeId = "'.($this->SmeId).'";';
			
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