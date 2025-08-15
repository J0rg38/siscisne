<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUbigeo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsUbigeo {

    public $UbiId;	
    public $UbiDepartamento;
	public $UbiProvincia;
	public $UbiDistrito;
	public $UbiEstado;
    public $UbiTiempoCreacion;
    public $UbiTiempoModificacion;
    public $UbiEliminado;
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
	
	
		
    public function MtdObtenerUbigeo(){

        $sql = 'SELECT 
        UbiId,
        UbiDepartamento,
		UbiProvincia,
		UbiDistrito,
		UbiCodigo
        FROM tblubiubigeo
        WHERE UbiId = "'.$this->UbiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->UbiId = $fila['UbiId'];
			$this->UbiDepartamento = $fila['UbiDepartamento'];
			$this->UbiProvincia = $fila['UbiProvincia'];
			$this->UbiDistrito = $fila['UbiDistrito'];
			$this->UbiCodigo = $fila['UbiCodigo'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerUbigeoDepartamentos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'UbiId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				DISTINCT ubi.UbiDepartamento
				
				FROM tblubiubigeo ubi
				WHERE ubi.UbiDepartamento != "" AND ubi.UbiDepartamento IS NOT NULL '.$filtrar.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsUbigeo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Ubigeo = new $InsUbigeo();
					$Ubigeo->UbiDepartamento= $fila['UbiDepartamento'];
				
                    $Ubigeo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Ubigeo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	 public function MtdObtenerUbigeoProvincias($oCampo=NULL,$oFiltro=NULL,$oOrden = 'UbiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oDepartamento=NULL) {

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
		
		if(!empty($oDepartamento)){
			$departamento = ' AND ubi.UbiDepartamento = "'.($oDepartamento).'" ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				DISTINCT ubi.UbiProvincia
				FROM tblubiubigeo ubi
				WHERE ubi.UbiProvincia !="" AND  ubi.UbiProvincia IS NOT NULL '.$filtrar.$departamento.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsUbigeo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Ubigeo = new $InsUbigeo();
					$Ubigeo->UbiProvincia= $fila['UbiProvincia'];
					
                    $Ubigeo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Ubigeo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}	
		
		
		public function MtdObtenerUbigeoDistritos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'UbiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProvincia=NULL) {

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
		
		if(!empty($oProvincia)){
			$provincia = ' AND ubi.UbiProvincia = "'.($oProvincia).'" ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				DISTINCT ubi.UbiDistrito,
				ubi.UbiId,
				ubi.UbiCodigo
				FROM tblubiubigeo ubi
				WHERE ubi.UbiDistrito != "" AND ubi.UbiDistrito IS NOT NULL '.$filtrar.$provincia.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsUbigeo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Ubigeo = new $InsUbigeo();
					$Ubigeo->UbiDistrito= $fila['UbiDistrito'];
					$Ubigeo->UbiId= $fila['UbiId'];
					$Ubigeo->UbiCodigo= $fila['UbiCodigo'];
					
                    $Ubigeo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Ubigeo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}		
		
	
}
?>