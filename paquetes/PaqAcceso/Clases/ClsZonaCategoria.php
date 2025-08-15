<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsZonaCategoria
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsZonaCategoria
{

	public $ZcaId;
	public $ZcaNombre;
	public $ZcaAlias;

	public $InsMysql;

	public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}

	public function __destruct() {}

	private function MtdGenerarZonaCategoriaId()
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ZcaId,5),unsigned)) AS "MAXIMO"
		FROM tblzcazonacategoria';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->ZcaId = "ZCA-10000";
		} else {
			$fila['MAXIMO']++;
			$this->ZcaId = "ZCA-" . $fila['MAXIMO'];
		}
	}
		
	//    public function MtdObtenerZonaCategoria(){
	//
	//        $sql = 'SELECT 
	//        ZcaId,
	//		ZcaNombre,
	//		ZcaAlias
	//        FROM tblzcazonacategoria
	//        WHERE ZcaId = "'.$this->ZcaId.'";';
	//		
	//        $resultado = $this->InsMysql->MtdConsultar($sql);
	//
	//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
	//		
	//        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
	//        {
	//			$this->ZcaId = $fila['ZcaId'];
	//			$this->ZcaNombre = $fila['ZcaNombre'];
	//				$this->ZcaAlias = $fila['ZcaAlias'];
	//		}
	//        
	//			$Respuesta =  $this;
	//			
	//		}else{
	//			$Respuesta =   NULL;
	//		}
	//		
	//        
	//		return $Respuesta;
	//
	//    }

	public function MtdObtenerZonaCategorias($oCampo = NULL, $oFiltro = NULL, $oOrden = 'ZcaId', $oSentido = 'Desc', $oPaginacion = '0,10')
	{


		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace(" ", "%", $oFiltro);
			$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}


		$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			ZcaId,
			ZcaNombre,
			ZcaAlias					
			FROM tblzcazonacategoria
			WHERE 1 = 1 ' . $filtrar . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsZonaCategoria = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$ZonaCategoria = new $InsZonaCategoria();
			$ZonaCategoria->ZcaId = $fila['ZcaId'];
			$ZonaCategoria->ZcaNombre = $fila['ZcaNombre'];
			$ZonaCategoria->ZcaAlias = $fila['ZcaAlias'];

			$ZonaCategoria->InsMysql = NULL;
			$Respuesta['Datos'][] = $ZonaCategoria;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	//Accion eliminar	 

	//	public function MtdEliminarZonaCategoria($oElementos) {
	//		
	//		$elementos = explode("#",$oElementos);
	//		
	//		if(!count($elementos)){
	//			$eliminar .= ' ZcaId = "'.($oElementos).'"';
	//		}else{
	//			$i=1;
	//			foreach($elementos as $elemento){
	//				if(!empty($elemento)){
	//				
	//					if($i==count($elementos)){						
	//						$eliminar .= '  (ZcaId = "'.($elemento).'")';	
	//					}else{
	//						$eliminar .= '  (ZcaId = "'.($elemento).'")  OR';	
	//					}	
	//				}
	//			$i++;
	//	
	//			}
	//		}
	//		
	//			$sql = 'DELETE from tblzcazonacategoria WHERE '.$eliminar;
	//		
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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


	public function MtdRegistrarZonaCategoria()
	{


		$this->MtdGenerarZonaCategoriaId();

		$sql = 'INSERT INTO tblzcazonacategoria (
			ZcaId,			
			ZcaNombre,
			ZcaAlias) 

			VALUES (
			"' . ($this->ZcaId) . '", 
			"' . ($this->ZcaNombre) . '", 			
			"' . ($this->ZcaAlias) . '");';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}

	//public function MtdEditarZonaCategoria() {
	//
	//			$sql = 'UPDATE tblzcazonacategoria SET 			
	//			 ZcaNombre = "'.($this->ZcaNombre).'",	
	//			 ZcaAlias = "'.($this->ZcaAlias).'"			
	//			 WHERE ZcaId = "'.($this->ZcaId).'";';
	//			
	//
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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
	//		}	
	//		


}
?>