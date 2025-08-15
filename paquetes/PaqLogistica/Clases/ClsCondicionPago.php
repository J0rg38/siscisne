<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCondicionPago
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCondicionPago {

    public $NpaId;
    public $NpaNombre;
	public $NpaDescripcion;
	public $NpaUso;

	public $NpaExtra;
	
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


		
    public function MtdObtenerCondicionPago(){

        $sql = 'SELECT 
        NpaId,
        NpaNombre,
		NpaDescripcion
        FROM tblnpacondicionpago
        WHERE NpaId = "'.$this->NpaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->NpaId = $fila['NpaId'];
            $this->NpaNombre = $fila['NpaNombre'];
			$this->NpaDescripcion = $fila['NpaDescripcion'];
			$this->NpaUso = $fila['NpaUso'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$uso = '';

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
						$uso .= '  (npa.NpaUso = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$uso .= ' OR ';	
						}
				$i++;		
				}
				
				$uso .= ' ) ';

		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				npa.NpaId,
				npa.NpaNombre,
				npa.NpaDescripcion,
				npa.NpaUso
				FROM tblnpacondicionpago npa
				WHERE 1 = 1'.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCondicionPago = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$CondicionPago = new $InsCondicionPago();
                    $CondicionPago->NpaId = $fila['NpaId'];
                    $CondicionPago->NpaNombre= $fila['NpaNombre'];
					$CondicionPago->NpaDescripcion= $fila['NpaDescripcion'];
					$CondicionPago->NpaUso= $fila['NpaUso'];
                    $CondicionPago->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CondicionPago;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal ? $filaTotal['TOTAL'] : 0;
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
}
?>