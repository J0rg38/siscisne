<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTipoOperacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoOperacion {

    public $TopId;
	public $TopCodigo;
    public $TopNombre;
	public $TopUso;	
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

    public function MtdObtenerTipoOperacion(){

        $sql = 'SELECT 
        TopId,
		TopCodigo,
        TopNombre,
		TopUso
        FROM tbltoptipooperacion
        WHERE TopId = "'.$this->TopId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TopId = $fila['TopId'];
			$this->TopCodigo = $fila['TopCodigo'];
            $this->TopNombre = $fila['TopNombre'];
            $this->TopUso = $fila['TopUso'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

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

			$elementos = explode(",",$oUso);

				$i=1;
				$uso .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$uso .= '  (cti.TopUso = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$uso .= ' OR ';	
						}
				$i++;		
				}
				
				$uso .= ' ) ';

		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 

				cti.TopId,
				cti.TopCodigo,
				cti.TopNombre,
				cti.TopUso
				FROM tbltoptipooperacion cti 
				WHERE 1 = 1'.$filtrar.$uso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoOperacion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$TipoOperacion = new $InsTipoOperacion();
                    $TipoOperacion->TopId = $fila['TopId'];
					$TipoOperacion->TopCodigo = $fila['TopCodigo'];
                    $TipoOperacion->TopNombre= $fila['TopNombre'];
					$TipoOperacion->TopUso= $fila['TopUso'];
                    $TipoOperacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TipoOperacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		

		
}
?>