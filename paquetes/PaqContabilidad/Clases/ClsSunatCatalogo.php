<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSunatCatalogo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSunatCatalogo {

    public $ScaId;
    public $ScaCodigo;
	public $ScaNombre;
    public $ScaTiempoCreacion;
    public $ScaTiempoModificacion;
    public $ScaEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
    public function MtdObtenerSunatCatalogo(){

   $sql = 'SELECT 
		sca.ScaId,
		sca.ScaTipo,
		
		sca.ScaCodigo,
		sca.ScaNombre,
		DATE_FORMAT(sca.ScaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NScaTiempoCreacion",
		DATE_FORMAT(sca.ScaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NScaTiempoModificacion"			
		
       FROM  tblscasunatcatalogo sca
        WHERE sca.ScaId = "'.$this->ScaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->ScaId = $fila['ScaId'];
			$this->ScaTipo = $fila['ScaTipo'];			
			$this->ScaCodigo = $fila['ScaCodigo'];
			$this->ScaNombre = $fila['ScaNombre'];
			$this->ScaTiempoCreacion = $fila['NScaTiempoCreacion'];
			$this->ScaTiempoModificacion = $fila['NScaTiempoModificacion'];			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	

    public function MtdObtenerSunatCatalogos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ScaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTipo=NULL) {

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
		
		
		
		if(!empty($oTipo)){
			$tipo = ' AND sca.ScaTipo = "'.($oTipo).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sca.ScaId,
				sca.ScaTipo,

				sca.ScaCodigo,
				sca.ScaNombre,
				DATE_FORMAT(sca.ScaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NScaTiempoCreacion",
                DATE_FORMAT(sca.ScaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NScaTiempoModificacion"				
				FROM tblscasunatcatalogo sca
				
				WHERE 1 = 1 '.$filtrar.$tipo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSunatCatalogo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$SunatCatalogo = new $InsSunatCatalogo();
                    $SunatCatalogo->ScaId = $fila['ScaId'];
					$SunatCatalogo->ScaCodigo= $fila['ScaCodigo'];
					$SunatCatalogo->ScaNombre= $fila['ScaNombre'];
                    $SunatCatalogo->ScaTiempoCreacion = $fila['NScaTiempoCreacion'];
                    $SunatCatalogo->ScaTiempoModificacion = $fila['NScaTiempoModificacion'];                    
                    $SunatCatalogo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SunatCatalogo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		
		
	
}
?>