<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteTipo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteTipo {

    public $CtiId;
	public $CtiCodigo;
    public $CtiNombre;
	public $CtiDescripcion;
	public $CtiUso;	
	
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



    public function MtdObtenerComprobanteTipo(){

        $sql = 'SELECT 
        CtiId,
		CtiCodigo,
        CtiNombre,
		CtiDescripcion,
		CtiUso
        FROM tblcticomprobantetipo
        WHERE CtiId = "'.$this->CtiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CtiId = $fila['CtiId'];
			$this->CtiCodigo = $fila['CtiCodigo'];
            $this->CtiNombre = $fila['CtiNombre'];
            $this->CtiDescripcion = $fila['CtiDescripcion'];
            $this->CtiUso = $fila['CtiUso'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerComprobanteTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CtiId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oUso=NULL) {

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
						$uso .= '  (cti.CtiUso = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$uso .= ' OR ';	
						}
				$i++;		
				}
				
				$uso .= ' ) ';

		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 

				cti.CtiId,
				cti.CtiCodigo,
				cti.CtiNombre,
				cti.CtiDescripcion,
				cti.CtiUso
				FROM tblcticomprobantetipo cti 
				WHERE 1 = 1'.$filtrar.$uso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsComprobanteTipo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ComprobanteTipo = new $InsComprobanteTipo();
                    $ComprobanteTipo->CtiId = $fila['CtiId'];
					$ComprobanteTipo->CtiCodigo = $fila['CtiCodigo'];
                    $ComprobanteTipo->CtiNombre= $fila['CtiNombre'];
					$ComprobanteTipo->CtiDescripcion= $fila['CtiDescripcion'];
					$ComprobanteTipo->CtiUso= $fila['CtiUso'];
                    $ComprobanteTipo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ComprobanteTipo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
}
?>