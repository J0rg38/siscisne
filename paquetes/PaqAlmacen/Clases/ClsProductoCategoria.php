<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoCategoria
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoCategoria {

    public $PcaId;
	public $PcaEstado;
    public $PcaNombre;
    public $PcaTiempoCreacion;
    public $PcaTiempoModificacion;
    public $PcaEliminado;

    public $InsMysql;
	
	public $ProductoSubCategoria;
	public $ProductoPadreCategoria;
	
	public $PcaSubNombre;	

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

	public function MtdGenerarProductoCategoriaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PcaId,5),unsigned)) AS "MAXIMO"
			FROM tblpcaproductocategoria';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PcaId = "PCA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PcaId = "PCA-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerProductoCategoria(){

        $sql = 'SELECT 
        pca.PcaId,
		pca.PcaNombre,
		pca.PcaEstado,        
		DATE_FORMAT(pca.PcaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcaTiempoCreacion",
        DATE_FORMAT(pca.PcaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcaTiempoModificacion"
        FROM tblpcaproductocategoria pca
		
        WHERE pca.PcaId = "'.$this->PcaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PcaId = $fila['PcaId'];
            $this->PcaNombre = $fila['PcaNombre'];
			$this->PcaEstado = $fila['PcaEstado'];
			$this->PcaTiempoCreacion = $fila['NPcaTiempoCreacion'];
			$this->PcaTiempoModificacion = $fila['NPcaTiempoModificacion']; 
						
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProductoCategorias($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';

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
		
		if(!empty($oEstado)){
			$estado = ' AND PcaEstado = '.($oEstado);
		}

			$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			PcaId,
			PcaNombre,
			PcaEstado,
			DATE_FORMAT(PcaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcaTiempoCreacion",
			DATE_FORMAT(PcaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcaTiempoModificacion"				
			FROM tblpcaproductocategoria
			WHERE 1 = 1 '.$filtrar.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoCategoria = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$ProductoCategoria = new $InsProductoCategoria();
                    $ProductoCategoria->PcaId = $fila['PcaId'];
                    $ProductoCategoria->PcaNombre= $fila['PcaNombre'];
					$ProductoCategoria->PcaEstado = $fila['PcaEstado'];
                    $ProductoCategoria->PcaTiempoCreacion = $fila['NPcaTiempoCreacion'];
                    $ProductoCategoria->PcaTiempoModificacion = $fila['NPcaTiempoModificacion'];    
					
					$ProductoCategoria->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$ProductoCategoria;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarProductoCategoria($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' PcaId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PcaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PcaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
			
			$sql = 'DELETE FROM tblpcaproductocategoria WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarProductoCategoria() {
	
			$this->MtdGenerarProductoCategoriaId();
			
			
			$sql = 'INSERT INTO tblpcaproductocategoria (
			PcaId,
			PcaNombre, 
			PcaEstado,
			PcaTiempoCreacion,
			PcaTiempoModificacion
			) 
			VALUES (
			"'.($this->PcaId).'", 
			"'.htmlentities($this->PcaNombre).'", 
			'.($this->PcaEstado).', 
			"'.($this->PcaTiempoCreacion).'", 
			"'.($this->PcaTiempoModificacion).'");';					

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
	
	public function MtdEditarProductoCategoria() {
		
			
			$sql = 'UPDATE tblpcaproductocategoria SET 
			
			 PcaNombre = "'.($this->PcaNombre).'",
			 PcaEstado = '.($this->PcaEstado).',
			 PcaTiempoModificacion = "'.($this->PcaTiempoModificacion).'"
			 WHERE PcaId = "'.($this->PcaId).'";';
			
		
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