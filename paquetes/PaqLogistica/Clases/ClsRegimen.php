<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsRegimen
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsRegimen {

    public $RegId;
	public $RegPorcentaje;
    public $RegNombre;
	public $RegDescripcion;
	public $RegUso;	
	public $RegAplicacion;
	
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


    public function MtdObtenerRegimen(){

        $sql = 'SELECT 
        RegId,
		RegPorcentaje,
        RegNombre,
		RegDescripcion,
		RegUso,
		RegAplicacion
        FROM tblregregimen
        WHERE RegId = "'.$this->RegId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->RegId = $fila['RegId'];
			$this->RegPorcentaje = $fila['RegPorcentaje'];
            $this->RegNombre = $fila['RegNombre'];
            $this->RegDescripcion = $fila['RegDescripcion'];
            $this->RegUso = $fila['RegUso'];
			$this->RegAplicacion = $fila['RegAplicacion'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerRegimenes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RegId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$uso = '';

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' = "'.($oFiltro).'"';	
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
						$uso .= '  (reg.RegUso = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$uso .= ' OR ';	
						}
				$i++;		
				}
				
				$uso .= ' ) ';

		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 

				reg.RegId,
				reg.RegPorcentaje,
				reg.RegNombre,
				reg.RegDescripcion,
				reg.RegUso,
				reg.RegAplicacion
				FROM tblregregimen reg 
				WHERE 1 = 1 '.$filtrar.$uso.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsRegimen = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Regimen = new $InsRegimen();
                    $Regimen->RegId = $fila['RegId'];
					$Regimen->RegPorcentaje = $fila['RegPorcentaje'];
                    $Regimen->RegNombre= $fila['RegNombre'];
					$Regimen->RegDescripcion= $fila['RegDescripcion'];
					$Regimen->RegUso= $fila['RegUso'];
					$Regimen->RegAplicacion= $fila['RegAplicacion'];

                    $Regimen->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Regimen;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
}
?>