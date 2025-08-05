<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProducto {

    public $ProId;
	
	public $PcaId;
	
	public $RtiId;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
    public $ProNombre;
	public $VmaId;
	
	public $ProMarca;
	public $ProPeso;
	public $ProLargo;
	public $ProAncho;
	public $ProAlto;
	public $ProVolumen;
	
	public $ProReferencia;
	public $ProDimension;
	public $AmdId;
	
	public $ProValorVenta;	
	public $ProPrecio;
	
	public $ProPrecioMercado;
	public $ProCosto;
	public $ProCostoIngreso;
	public $ProCostoIngresoNeto;

	public $ProListaPrecioCostoReal;
	public $ProListaPromocionCostoReal;	
	public $ProListaPrecioCosto;
	public $ProListaPromocionCosto;
	public $MonIdListaPrecio;
	public $MonIdListaPromocion;
	public $ProTieneReemplazoGM;
	public $ProTieneDisponibilidadGM;
	
	public $UmeId;
	public $UmeIdIngreso;
	public $ProCodigoBarra;

	public $ProFoto;
	public $ProStock;
	public $ProStockReal;
	
	public $ProStockMinimo;
	public $ProValidarStock;
	public $ProValidarUso;
	public $ProRevisado;
	public $ProStockVerificado;
	
	public $ProProcedencia;
	public $ProRotacion;
	
	public $LtiId;
	public $ProCalcularPrecio;
	public $MonId;
	public $ProTipoCambio;
	public $ProPorcentajeDescuento;
	
	public $ProEstado;
    public $ProTiempoCreacion;
    public $ProTiempoModificacion;
    public $ProEliminado;
	
	public $RtiNombre;
	public $UmeNombre;
	public $UmeAbreviacion;
	
	
	public $ProductoVehiculoVersion;
	public $ProductoAno;
	public $ListaPrecio;
//	public $ProductoCosto;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(ProId,5),unsigned)) AS "MAXIMO"
			FROM tblproproducto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->ProId = "PRO-10000";

			}else{
				$fila['MAXIMO']++;
				$this->ProId = "PRO-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerProducto($oCompleto=true){

        $sql = 'SELECT 
		pro.ProId,
		pro.PcaId,
		pro.VmaId,
		
		pro.RtiId,
		pro.ProCodigoOriginal,
		pro.ProCodigoAlternativo,
		pro.ProNombre,
		pro.ProUbicacion,
		
		pro.ProMarca,
		
		pro.ProPeso,
		pro.ProLargo,
		pro.ProAncho,
		pro.ProAlto,
		pro.ProVolumen,
		
		pro.ProReferencia,
pro.ProNota,
		pro.ProDimension,
		pro.AmdId,
		pro.ProPrecio,
		pro.ProPrecioMercado,
		pro.ProCosto,
		pro.ProCostoIngreso,
		pro.ProCostoIngresoNeto,
		
		pro.ProListaPrecioCosto,
		pro.ProListaPromocionCosto,	
		pro.ProListaPrecioCostoReal,
		pro.ProListaPromocionCostoReal,		
		
		pro.MonIdListaPrecio,
		pro.MonIdListaPromocion,
		
		pro.ProTieneReemplazoGM,
		pro.ProTieneDisponibilidadGM,
		pro.ProDisponibilidadCantidadGM,
		
		pro.UmeId,
		pro.UmeIdIngreso,
		pro.ProCodigoBarra,
		pro.RtiId,
		pro.ProFoto,
		pro.ProStock,
		pro.ProStockReal,
		pro.ProStockMinimo,	
		pro.ProValidarStock,	
		pro.ProValidarUso,
		
		pro.ProRevisado,
		DATE_FORMAT(pro.ProRevisadoFecha, "%d/%m/%Y") AS "NProRevisadoFecha",
		pro.ProStockVerificado,
		
		(
		SELECT 
		lpr.LprPrecio
		FROM tbllprlistaprecio lpr
		WHERE lpr.ProId = pro.ProId
			AND lpr.LtiId = "LTI-10012"
		LIMIT 1
		) AS ProListaPrecioPrecio,
				
		(
		
		SELECT 
		ptu.UmeId
		FROM tblptuproductotipounidadmedida ptu
		WHERE pro.RtiId = ptu.RtiId
		AND ptu.PtuTipo = 2
		LIMIT 1		
		) AS UmeIdSalida,
				
			  
		pro.ProProcedencia,
		pro.ProRotacion,
		

		pro.LtiId,
		pro.ProCalcularPrecio,
		pro.ProTienePromocion,
		pro.ProPorcentajeAdicional,
		pro.ProPorcentajeDescuento,
		
		pro.MonId,
		pro.ProTipoCambio,
		
		pro.ProCritico,
pro.ProDescontinuado,
pro.ProEstado,
		DATE_FORMAT(pro.ProTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoCreacion",
        DATE_FORMAT(pro.ProTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoModificacion",
		
		
			pro.ProPromedioDiario,
			pro.ProPromedioMensual,
			pro.ProPromedioTrimestral,
			pro.ProPromedioSemestral,
			pro.ProPromedioAnual,
			
			pro.ProSalidaTotalAnual,
			pro.ProSalidaTotalTrimestral,
			pro.ProSalidaTotalSemestral,
			
			DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida",
			pro.ProDiasInmovilizado,
			
			
		rti.RtiNombre,
		ume.UmeNombre,
		ume.UmeAbreviacion
		
        FROM tblproproducto pro
			LEFT JOIN tblrtiproductotipo rti
			ON pro.RtiId = rti.RtiId
				LEFT JOIN tblumeunidadmedida ume
				ON	pro.UmeId = ume.UmeId
        WHERE  pro.ProId = "'.$this->ProId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->ProId = $fila['ProId'];
			$this->PcaId = $fila['PcaId'];
			$this->VmaId = $fila['VmaId'];
			
			$this->RtiId = $fila['RtiId']; 
			$this->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
            $this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];				
            $this->ProNombre = (($fila['ProNombre']));
			$this->ProUbicacion = (($fila['ProUbicacion']));
			
			
			$this->ProMarca = (($fila['ProMarca']));
			
			$this->ProPeso = (($fila['ProPeso']));
			$this->ProLargo = (($fila['ProLargo']));
			$this->ProAncho = (($fila['ProAncho']));
			$this->ProAlto = (($fila['ProAlto']));
			$this->ProVolumen = (($fila['ProVolumen']));
		
		
            $this->ProReferencia = htmlentities(utf8_decode($fila['ProReferencia']));
			$this->ProNota = $fila['ProNota'];
$this->ProDimension = $fila['ProDimension'];			
            $this->AmdId = $fila['AmdId'];			
            $this->ProPrecio = $fila['ProPrecio'];
			$this->ProPrecioMercado = $fila['ProPrecioMercado'];
			$this->ProCosto = $fila['ProCosto'];
			$this->ProCostoIngreso = $fila['ProCostoIngreso'];
			$this->ProCostoIngresoNeto = $fila['ProCostoIngresoNeto'];

			$this->ProListaPrecioCosto = $fila['ProListaPrecioCosto'];
			$this->ProListaPromocionCosto = $fila['ProListaPromocionCosto'];
			$this->ProListaPrecioCostoReal = $fila['ProListaPrecioCostoReal'];
			$this->ProListaPromocionCostoReal = $fila['ProListaPromocionCostoReal'];
			
			$this->MonIdListaPrecio = $fila['MonIdListaPrecio'];
			$this->MonIdListaPromocion = $fila['MonIdListaPromocion'];
			$this->ProTieneDisponibilidadGM = $fila['ProTieneDisponibilidadGM'];
			$this->ProTieneReemplazoGM = $fila['ProTieneReemplazoGM'];
			$this->ProDisponibilidadCantidadGM = $fila['ProDisponibilidadCantidadGM'];
			
			$this->UmeId = (($fila['UmeId']));
			$this->UmeIdIngreso = $fila['UmeIdIngreso'];
			$this->ProCodigoBarra = $fila['ProCodigoBarra'];
			$this->RtiId = $fila['RtiId'];
			$this->ProFoto = $fila['ProFoto'];
			$this->ProStock = $fila['ProStock'];
			$this->ProStockReal = $fila['ProStockReal'];
			$this->ProStockMinimo = $fila['ProStockMinimo'];
			$this->ProValidarStock = $fila['ProValidarStock'];
			$this->ProValidarUso = $fila['ProValidarUso'];
			
			$this->ProRevisado = $fila['ProRevisado'];	
			$this->ProRevisadoFecha = $fila['NProRevisadoFecha'];	
			
			$this->ProStockVerificado = $fila['ProStockVerificado'];	
			$this->ProListaPrecioPrecio = $fila['ProListaPrecioPrecio'];
			$this->ProTienePromocion = $fila['ProTienePromocion'];		
			
			$this->UmeIdSalida = $fila['UmeIdSalida'];
			
			$this->ProProcedencia = $fila['ProProcedencia'];	
			$this->ProRotacion = $fila['ProRotacion'];	
			
			$this->LtiId = $fila['LtiId'];	
			$this->ProCalcularPrecio = $fila['ProCalcularPrecio'];	
			$this->ProPorcentajeAdicional = $fila['ProPorcentajeAdicional'];
			$this->ProPorcentajeDescuento = $fila['ProPorcentajeDescuento'];		
			
			$this->MonId = $fila['MonId'];	
			$this->ProTipoCambio = $fila['ProTipoCambio'];	
			
			$this->ProCritico = $fila['ProCritico'];	
			$this->ProDescontinuado = $fila['ProDescontinuado'];	
			$this->ProEstado = $fila['ProEstado'];					
			$this->ProTiempoCreacion = $fila['NProTiempoCreacion'];
			$this->ProTiempoModificacion = $fila['NProTiempoModificacion']; 

			$this->ProPromedioDiario = $fila['ProPromedioDiario'];		
			$this->ProPromedioMensual = $fila['ProPromedioMensual'];		
			$this->ProPromedioTrimestral = $fila['ProPromedioTrimestral'];		
			$this->ProPromedioSemestral = $fila['ProPromedioSemestral'];		
			$this->ProPromedioAnual = $fila['ProPromedioAnual'];		
			
			$this->ProSalidaTotalAnual = $fila['ProSalidaTotalAnual'];		
			$this->ProSalidaTotalTrimestral = $fila['ProSalidaTotalTrimestral'];		
			$this->ProSalidaTotalSemestral = $fila['ProSalidaTotalSemestral'];	
			
			$this->ProFechaUltimaSalida = $fila['NProFechaUltimaSalida'];	
			$this->ProDiasInmovilizado = $fila['ProDiasInmovilizado'];		

			$this->RtiNombre = $fila['RtiNombre'];
			$this->UmeNombre = $fila['UmeNombre'];
			$this->UmeAbreviacion = $fila['UmeAbreviacion'];
			
			if($oCompleto){

				$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
				$ResProductoVehiculoVersion = $InsProductoVehiculoVersion->MtdObtenerProductoVehiculoVersiones(NULL,NULL,"PvvId","ASC",NULL,$this->ProId);
				$this->ProductoVehiculoVersion = $ResProductoVehiculoVersion['Datos'];
				
				$InsProductoAno = new ClsProductoAno();
				$ResProductoAno = $InsProductoAno->MtdObtenerProductoAnos(NULL,NULL,"PanId","ASC",NULL,$this->ProId);
				$this->ProductoAno = $ResProductoAno['Datos'];
				
				$InsListaPrecio = new ClsListaPrecio();
				$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',NULL,$this->ProId);
				$this->ListaPrecio = $ResListaPrecio['Datos'];
				
				$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
				
				//MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL)
				$ResProductoCodigoReemplazo = $InsProductoCodigoReemplazo->MtdObtenerProductoCodigoReemplazos(NULL,NULL,"PcrId","ASC",NULL,$this->ProId);
				$this->ProductoCodigoReemplazo = $ResProductoCodigoReemplazo['Datos'];
				
	//			$InsProductoCosto = new ClsProductoCosto();
	//			$ResProductoCosto = $InsProductoCosto->MtdObtenerProductoCostos(NULL,NULL,'RcoId','ASC',NULL,$this->ProId);
	//			$this->ProductoCosto = $ResProductoCosto['Datos'];
	
	
				$InsProductoFoto = new ClsProductoFoto();
				//MtdObtenerProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PfoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oEstado=NULL,$oTipo=NULL) {
				$ResProductoFoto = $InsProductoFoto->MtdObtenerProductoFotos(NULL,NULL,"PfoId","ASC",NULL,$this->ProId,3,NULL);
				$this->ProductoFoto = $ResProductoFoto['Datos'];
				
			}

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

   public function MtdVerificarExisteProducto($oCampo,$oDato){
		
		$ProductoId = "";
		
	//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL)
		$ResProducto = $this->MtdObtenerProductos($oCampo,"esigual",$oDato,"ProId,ProEstado","ASC","1",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
		$ArrProductos = $ResProducto['Datos'];
		
		if(!empty($ArrProductos)){
			foreach($ArrProductos as $DatProducto){
					
				$ProductoId = $DatProducto->ProId;
			}
		}
		
		return $ProductoId;
   }
   
   public function MtdIdentificarProductoCampo($oCampo,$oDato){
		
		$ProductoId = "";
		
		$ResProducto = $this->MtdObtenerProductos($oCampo,"esigual",$oDato,"ProId","DESC","1",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);   
		$ArrProductos = $ResProducto['Datos'];
		
		if(!$ArrProductos){
			foreach($ArrProductos as $DatProducto){
				$ProductoId = $DatProducto->ProId;
			}
		}
		
		return $ProductoId;
   }
   
    public function MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
							
						
							$filtrar .= ' ) OR';
							
						}
						
						
						
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		if(!empty($oEstado)){
			$estado = ' AND pro.ProEstado = '.$oEstado.' ';
		}
		
		if(!empty($oTipo)){
			$tipo = ' AND pro.RtiId = "'.$oTipo.'"';
		}
		
		if(!empty($oValidarStock)){
			$vstock = ' AND pro.ProValidarStock = '.$oValidarStock.' ';
		}


		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND (
			
				EXISTS (
					SELECT 
						pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND pvv.ProId = pro.ProId
				)
				'.(($oUsoEstricto)?'':'OR pro.ProValidarUso = 2').'
			) ';
			
		}
		
		if(!empty($oVehiculoModelo)){
			
			$vmodelo = ' AND 
			(
				EXISTS (
					SELECT 
						pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vve.VmoId = "'.$oVehiculoModelo.'"
					AND pvv.ProId = pro.ProId
				)  
				'.(($oUsoEstricto)?'':'OR pro.ProValidarUso = 2').'
			)
			';
			
		}	
		
		if(!empty($oVehiculoVersion)){
			
			$vversion = ' AND 
			(
				EXISTS (
					SELECT 
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vve.VveId = "'.$oVehiculoVersion.'"
						AND pvv.ProId = pro.ProId
				)
				'.(($oUsoEstricto)?'':'OR pro.ProValidarUso = 2').'
			)
			';
			
		}			

		
		if(!empty($oVehiculoAno)){
			
			$vano = ' AND 
				(
					EXISTS (
						SELECT 
						pan.PanId
						FROM tblpanproductoano pan
						WHERE pan.PanAno = "'.$oVehiculoAno.'"
							AND pan.ProId = pro.ProId
					)  
					
					'.(($oUsoEstricto)?'':'OR pro.ProValidarUso = 2').'
				)
			';
			
		}			


		if($oTieneIngreso){
			
			$tingreso = ' AND EXISTS (

				SELECT 
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
				WHERE amd.ProId = pro.ProId
				AND amd.AmdEstado = 3

			)  ';
			
		}			


		if(!empty($oReferencia)){
			$referencia = ' AND pro.ProReferencia LIKE "%'.$oReferencia.'%"';
		}


		if(!empty($oTieneSock)){
			
			switch($oTieneSock){
				case "1":
					$tstock = ' AND pro.ProStockReal > 0 ';
				break;
				
				case "2":
					$tstock = ' AND pro.ProStockReal <= 0 ';
				break;
				
				default:
					$tstock = '';
				break;
				
			}
			
		}


		if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId = "'.$oProductoCategoria.'"';
		}
		
		if(!empty($oVehiculoMarcaSolo)){
			$vmarcasolo = ' AND pro.VmaId = "'.$oVehiculoMarcaSolo.'"';
		}
		
		if(!empty($oCalcularPrecio)){
			$cprecio = ' AND pro.ProCalcularPrecio = "'.$oCalcularPrecio.'"';
		}
		
		if(($oTieneCodigoOriginal)){
			$tcoriginal = ' AND pro.ProCodigoOriginal != "" AND  pro.ProCodigoOriginal IS NOT NULL';
		}
		    
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pro.ProId,
				pro.PcaId,
				
				pro.RtiId,
				pro.ProCodigoAlternativo,
				pro.ProCodigoOriginal,
				pro.ProNombre,
				pro.ProUbicacion,
				
				pro.ProMarca,
		
				pro.ProPeso,
				pro.ProLargo,
				pro.ProAncho,
				pro.ProAlto,
				pro.ProVolumen,
				
				pro.ProReferencia,
pro.ProNota,
				pro.ProDimension,
				pro.AmdId,
       			pro.ProPrecio,
				pro.ProPrecioMercado,
				pro.ProCosto,
				pro.ProCostoIngreso,
				pro.ProCostoIngresoNeto,
				
				pro.ProListaPrecioCosto,
				pro.ProListaPromocionCosto,
				pro.ProListaPrecioCostoReal,
				pro.ProListaPromocionCostoReal,
				
				pro.MonIdListaPrecio,
				pro.MonIdListaPromocion,
				pro.ProTieneReemplazoGM,
				pro.ProTieneDisponibilidadGM,
				pro.ProDisponibilidadCantidadGM,
				
				pro.UmeId,
				pro.UmeIdIngreso,
				pro.ProCodigoBarra,

				pro.RtiId,
				pro.ProFoto,
				pro.ProStock,
				pro.ProStockReal,
				pro.ProStockMinimo,
				pro.ProValidarStock,
				pro.ProValidarUso,
				
				pro.ProRevisado,
				DATE_FORMAT(pro.ProRevisadoFecha, "%d/%m/%Y") AS "NProRevisadoFecha",
				pro.ProStockVerificado,
				
				( 
				SELECT 
				lpr.LprPrecio
				FROM tbllprlistaprecio lpr
					WHERE lpr.ProId = pro.ProId
					AND lpr.LtiId = "LTI-10012"
					LIMIT 1
				) AS ProListaPrecioPrecio,
				
					pro.ProProcedencia,
	pro.ProRotacion,
				
					
		pro.LtiId,
		pro.ProCalcularPrecio,
		pro.ProPorcentajeAdicional,
		pro.ProPorcentajeDescuento,
		
		pro.MonId,
		pro.ProTipoCambio,
		
				pro.ProDiasInmovilizado,
				pro.ProPromedioMensual,
				pro.ProPromedioDiario,
				
						pro.ProPromedioTrimestral,
						pro.ProPromedioSemestral,
						pro.ProPromedioAnual,
						
						pro.ProSalidaTotalAnual,
						pro.ProSalidaTotalTrimestral,
						pro.ProSalidaTotalSemestral,
						
						DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida",
						
						
			
				pro.ProABCInterno,
				pro.ProCritico,
pro.ProDescontinuado,
pro.ProEstado,
				DATE_FORMAT(pro.ProTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoCreacion",
                DATE_FORMAT(pro.ProTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NProTiempoModificacion",
				rti.RtiNombre,
				ume.UmeNombre,
				ume.UmeAbreviacion,
				
				pca.PcaNombre,
				
				 @ProductoPedido:=(
						SELECT 
						SUM( pcd.PcdCantidad )
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha > CONCAT( YEAR( '.(!empty($oFecha)?'"'.$oFecha.'"':'NOW()').' ),"-01-01")
					
					) AS ProPedidoCantidad,
					
					@ProductoLlego:=(
					
						SELECT 
						SUM( amd.AmdCantidad )
						FROM  tblamdalmacenmovimientodetalle amd
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
					
							LEFT JOIN  tblpcdpedidocompradetalle pcd
							ON amd.PcdId = pcd.PcdId
					
						WHERE pcd.ProId = pro.ProId
						
						AND amd.AmdEstado = 3
						AND amo.AmoTipo =1
						AND amo.AmoFecha > CONCAT( YEAR( '.(!empty($oFecha)?'"'.$oFecha.'"':'NOW()').' ),"-01-01")
					
					) AS ProPedidoLLegoCantidad,
					
					
					(
						SELECT 
						DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y")
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha > CONCAT( YEAR( '.(!empty($oFecha)?'"'.$oFecha.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS ProPedidoUltimaFecha,
					
					(
						SELECT 
					
						oco.OcoTipo
					
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha > CONCAT( YEAR( '.(!empty($oFecha)?'"'.$oFecha.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS ProPedidoTipo,
					
					(
						SELECT 
					
						
						DATE_FORMAT(DATE_ADD(oco.OcoFechaLlegadaEstimada, INTERVAL 4 DAY), "%d/%m/%Y")
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha >  CONCAT( YEAR( '.(!empty($oFecha)?'"'.$oFecha.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS ProPedidoLlegadaEstimada,
					
					
					(
					
					IFNULL(@ProductoPedido,0) - IFNULL(@ProductoLlego,0)
					
					) AS ProPedidoPorLLegar

				FROM tblproproducto pro		
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
				WHERE  1 = 1  '.$filtrar.$categoria.$vmarcasolo.$tcoriginal .$cprecio.$referencia.$estado.$tipo.$vstock.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria.$orden.$paginacion;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
                    $Producto->ProId = $fila['ProId'];
					$Producto->RtiId = $fila['RtiId']; 
					$Producto->VmaId = $fila['VmaId']; 
					
					$Producto->ProCodigoOriginal = ($fila['ProCodigoOriginal']);
					$Producto->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $Producto->ProNombre= ($fila['ProNombre']);
                    $Producto->ProUbicacion= ($fila['ProUbicacion']);
					
					
					$Producto->ProMarca= ($fila['ProMarca']);
					
					$Producto->ProPeso= ($fila['ProPeso']);
					$Producto->ProLargo= ($fila['ProLargo']);
					$Producto->ProAncho= ($fila['ProAncho']);
					$Producto->ProAlto= ($fila['ProAlto']);
					$Producto->ProVolumen= ($fila['ProVolumen']);
					
					$Producto->ProReferencia= ($fila['ProReferencia']);
					$Producto->ProNota = ($fila['ProNota']);
					$Producto->ProDimension= ($fila['ProDimension']);
					$Producto->AmdId= $fila['AmdId'];
					$Producto->ProPrecio= $fila['ProPrecio'];
					$Producto->ProPrecioMercado= $fila['ProPrecioMercado'];
					$Producto->ProCosto = $fila['ProCosto'];
					$Producto->ProCostoIngreso = $fila['ProCostoIngreso'];
					$Producto->ProCostoIngresoNeto = $fila['ProCostoIngresoNeto'];
					
					$Producto->ProListaPrecioCosto = $fila['ProListaPrecioCosto'];
					$Producto->ProListaPromocionCosto = $fila['ProListaPromocionCosto'];	
					$Producto->ProListaPrecioCostoReal = $fila['ProListaPrecioCostoReal'];
					$Producto->ProListaPromocionCostoReal = $fila['ProListaPromocionCostoReal'];	
									
					$Producto->MonIdListaPrecio = ($fila['MonIdListaPrecio']);
					$Producto->MonIdListaPromocion = ($fila['MonIdListaPromocion']);
					$Producto->ProTieneDisponibilidadGM = ($fila['ProTieneDisponibilidadGM']);
					$Producto->ProTieneReemplazoGM = ($fila['ProTieneReemplazoGM']);
					$Producto->ProDisponibilidadCantidadGM = ($fila['ProDisponibilidadCantidadGM']);
					
					$Producto->UmeId= ($fila['UmeId']);
					$Producto->UmeIdIngreso= ($fila['UmeIdIngreso']);
					
					$Producto->PcaNombre= ($fila['PcaNombre']);
					
					$Producto->ProCodigoBarra= $fila['ProCodigoBarra'];	

					$Producto->RtiId= $fila['RtiId'];
					$Producto->ProFoto = $fila['ProFoto'];
					$Producto->ProStock = $fila['ProStock'];
					$Producto->ProStockReal = $fila['ProStockReal'];

					$Producto->ProStockMinimo = $fila['ProStockMinimo'];
					$Producto->ProValidarStock = $fila['ProValidarStock'];
					$Producto->ProValidarUso = $fila['ProValidarUso'];
					
					
					$Producto->ProRevisado = $fila['ProRevisado'];	
					$Producto->ProRevisadoFecha = $fila['NProRevisadoFecha'];	
					
					$Producto->ProStockVerificado = $fila['ProStockVerificado'];
					
					
					$Producto->ProListaPrecioPrecio = $fila['ProListaPrecioPrecio'];	
		
	
					$Producto->ProProcedencia = $fila['ProProcedencia'];	
					$Producto->ProRotacion = $fila['ProRotacion'];	
					
		
					$Producto->LtiId = $fila['LtiId'];	
					$Producto->ProCalcularPrecio = $fila['ProCalcularPrecio'];	
					$Producto->ProPorcentajeAdicional = $fila['ProPorcentajeAdicional'];
					$Producto->ProPorcentajeDescuento = $fila['ProPorcentajeDescuento'];		
					
					
					$Producto->MonId = $fila['MonId'];	
					$Producto->ProTipoCambio = $fila['ProTipoCambio'];	
					
					$Producto->ProDiasInmovilizado = $fila['ProDiasInmovilizado'];
					$Producto->ProPromedioMensual = $fila['ProPromedioMensual'];
					$Producto->ProPromedioDiario = $fila['ProPromedioDiario'];
					
					$Producto->ProPromedioTrimestral = $fila['ProPromedioTrimestral'];
					$Producto->ProPromedioSemestral = $fila['ProPromedioSemestral'];
					$Producto->ProPromedioAnual = $fila['ProPromedioAnual'];
					
					$Producto->ProSalidaTotalAnual = $fila['ProSalidaTotalAnual'];
					$Producto->ProSalidaTotalTrimestral = $fila['ProSalidaTotalTrimestral'];
					$Producto->ProSalidaTotalSemestral = $fila['ProSalidaTotalSemestral'];
					
					$Producto->ProFechaUltimaSalida = $fila['NProFechaUltimaSalida'];
					
						
					$Producto->ProABCInterno = $fila['ProABCInterno'];	
					
						$Producto->ProCritico = $fila['ProCritico'];	
			$Producto->ProDescontinuado = $fila['ProDescontinuado'];	
			
			
					$Producto->ProEstado = $fila['ProEstado'];	
                    $Producto->ProTiempoCreacion = $fila['NProTiempoCreacion'];
                    $Producto->ProTiempoModificacion = $fila['NProTiempoModificacion'];
					
					$Producto->RtiNombre = $fila['RtiNombre'];
					$Producto->UmeNombre = $fila['UmeNombre'];
					$Producto->UmeAbreviacion = $fila['UmeAbreviacion'];
					
					$Producto->ProPedidoCantidad = $fila['ProPedidoCantidad'];
					$Producto->ProPedidoLLegoCantidad = $fila['ProPedidoLLegoCantidad'];
					$Producto->ProPedidoUltimaFecha = $fila['ProPedidoUltimaFecha'];
					$Producto->ProPedidoTipo = $fila['ProPedidoTipo'];
					$Producto->ProPedidoLlegadaEstimada = $fila['ProPedidoLlegadaEstimada'];
					$Producto->ProPedidoPorLLegar = $fila['ProPedidoPorLLegar'];
					
					
					$Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarProducto($oElementos) {
		
		
			
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'DELETE FROM tblproproducto WHERE ( ProId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProducto(3,"Se elimino el Producto",$aux);		
						}
									
					}

				}
			$i++;
	
			}
		
	
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}	
			
			
			/*
			
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (ProId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (ProId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblproproducto WHERE '.$eliminar;			
		
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
			*/
			
			
			
			//$this->MtdAuditarProducto(1,"Se registro el Producto.",$this);					
	}
	
	
	
	public function MtdActualizarProductoEstado($oElementos,$oEstado) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblproproducto SET ProEstado = '.$oEstado.' WHERE ( ProId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProducto(2,"Se actualizo el estado del producto",$aux);		
						}
									
					}

				}
			$i++;
	
			}
		
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}	
			
							
	}
	
	
	
	
	
	public function MtdActualizarProductoCritico($oElementos,$oCritico) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblproproducto SET ProCritico = '.$oCritico.' WHERE ( ProId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProducto(2,"Se actualizo el estado critico del producto",$aux);		
						}
									
					}

				}
			$i++;
	
			}
		
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}	
			
							
	}
	
	
	public function MtdActualizarProductoDescontinuado($oElementos,$oDescontinuado) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblproproducto SET ProDescontinuado = '.$oDescontinuado.' WHERE ( ProId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProducto(2,"Se actualizo el estado descontinuado del producto",$aux);		
						}
									
					}

				}
			$i++;
	
			}
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}	
			
							
	}
	
	

	public function MtdActualizarProductoCalcularPrecio($oElementos,$oCalculoPrecio) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblproproducto SET ProCalcularPrecio = '.$oCalculoPrecio.' WHERE ( ProId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarProducto(2,"Se actualizo el estado de calculo de precio del producto",$aux);		
						}
									
					}

				}
			$i++;
	
			}
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}	
			
							
	}	
	public function MtdRegistrarProducto() {
		
		global $Resultado;
		
			$this->MtdGenerarProductoId();
			
			$sql = 'INSERT INTO tblproproducto (
			ProId,
			PcaId,
			
			ProCodigoOriginal,
			ProCodigoAlternativo,
			ProNombre, 
			
			ProMarca,
			
			ProPeso,
			ProLargo,
			ProAncho,
			ProAlto,
			ProVolumen,
			
			ProReferencia,
			ProNota,
			
			ProDimension,
			AmdId,
			ProPrecio,
			ProPrecioMercado,
			ProCosto,
			ProCostoIngreso,
			ProCostoIngresoNeto,
			
			ProListaPrecioCosto,
			ProListaPromocionCosto,	
			ProListaPrecioCostoReal,
			ProListaPromocionCostoReal,	
					
			MonIdListaPrecio,
			MonIdListaPromocion,
			ProTieneReemplazoGM,
			ProTieneDisponibilidadGM,
			ProDisponibilidadCantidadGM,
			
			UmeId,
			UmeIdIngreso,
			ProCodigoBarra,
			RtiId,
			ProFoto,
			ProStock,
			ProStockReal,
			ProStockMinimo,
			ProValidarStock,
			ProValidarUso,
			ProRevisado,
			ProRevisadoFecha,
			ProStockVerificado,
			
						
			ProProcedencia,
			ProRotacion,
			ProPromedioMensual,
			ProPromedioDiario,
			ProFechaUltimaSalida,
			ProDiasInmovilizado,
	
		LtiId,
		ProCalcularPrecio,
		ProTienePromocion,
		ProPorcentajeAdicional,
		ProPorcentajeDescuento,
		
		MonId,
		ProTipoCambio,
		
			ProCritico,
			ProDescontinuado,
			ProEstado,
			ProTiempoCreacion,
			ProTiempoModificacion
			) 
			VALUES (
			"'.($this->ProId).'", 
			'.(empty($this->PcaId)?'NULL, ':'"'.$this->PcaId.'",').'
			
			"'.($this->ProCodigoOriginal).'", 
			"'.($this->ProCodigoAlternativo).'", 
			"'.($this->ProNombre).'", 
			
			"'.($this->ProMarca).'",
			
			'.($this->ProPeso).',
			'.($this->ProLargo).',
			'.($this->ProAncho).',
			'.($this->ProAlto).',
			'.($this->ProVolumen).',
			 
			"'.($this->ProReferencia).'", 
			"'.($this->ProNota).'", 
			"'.($this->ProDimension).'", 
			NULL, 
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			
			0,
			NULL,
			NULL,
			
			"'.($this->ProTieneReemplazoGM).'",
			"'.($this->ProTieneDisponibilidadGM).'",
			'.($this->ProDisponibilidadCantidadGM).',
			
			"'.($this->UmeId).'",
			"'.($this->UmeIdIngreso).'",
			"'.($this->ProCodigoBarra).'",		
			"'.$this->RtiId.'",
			"'.($this->ProFoto).'",
			0,
			0,
			'.($this->ProStockMinimo).',
			'.($this->ProValidarStock).',
			'.($this->ProValidarUso).',	
			2,		
			NULL,
			2,
			
			
			"'.($this->ProProcedencia).'", 
			"'.($this->ProRotacion).'", 
			0,
			0,
			NULL,
			-1,
			
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			'.($this->ProCalcularPrecio).',	
			'.($this->ProTienePromocion).',	
			'.($this->ProPorcentajeAdicional).',	
			'.($this->ProPorcentajeDescuento).',	
			
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			'.(empty($this->ProTipoCambio)?'NULL, ':'"'.$this->ProTipoCambio.'",').'
				
			'.($this->ProCritico).',
			'.($this->ProDescontinuado).',
			'.($this->ProEstado).',
			"'.($this->ProTiempoCreacion).'", 
			"'.($this->ProTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if(!$error){		
			
				if (!empty($this->ProductoVehiculoVersion)){		
				
					$validar = 0;				
					$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();		
							
					foreach ($this->ProductoVehiculoVersion as $DatProductoVehiculoVersion){
						$InsProductoVehiculoVersion->ProId = $this->ProId;
						$InsProductoVehiculoVersion->VveId = $DatProductoVehiculoVersion->VveId;
						$InsProductoVehiculoVersion->PvvTiempoCreacion = $DatProductoVehiculoVersion->PvvTiempoCreacion;
						$InsProductoVehiculoVersion->PvvTiempoModificacion = $DatProductoVehiculoVersion->PvvTiempoModificacion;
						
						if($InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion()){
							$validar++;					
						}else{
							$Resultado.='#ERR_PRO_201';
							$Resultado.='#Item Numero: '.($validar+1);	
						}
								
										
					}					
					
					if(count($this->ProductoVehiculoVersion) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
			
			
			
			
			if(!$error){		
			
				if (!empty($this->ProductoAno)){		
				
					$validar = 0;				
					$InsProductoAno = new ClsProductoAno();		
							
					foreach ($this->ProductoAno as $DatProductoAno){
						$InsProductoAno->ProId = $this->ProId;
						$InsProductoAno->PanAno = $DatProductoAno->PanAno;
						$InsProductoAno->PanTiempoCreacion = $DatProductoAno->PanTiempoCreacion;
						$InsProductoAno->PanTiempoModificacion = $DatProductoAno->PanTiempoModificacion;
						

						
						if($InsProductoAno->MtdRegistrarProductoAno()){
							$validar++;					
						}else{
							$Resultado.='#ERR_PRO_211';
							$Resultado.='#Item Numero: '.($validar+1);	
						}
								
										
					}					
					
					if(count($this->ProductoAno) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
			
			
			
			if(!$error){		
			
				if (!empty($this->ProductoCodigoReemplazo)){		
				
					$validar = 0;				
					$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();		
							
					foreach ($this->ProductoCodigoReemplazo as $DatProductoCodigoReemplazo){
						$InsProductoCodigoReemplazo->ProId = $this->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoCodigoReemplazo->PcrNumero;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = $DatProductoCodigoReemplazo->PcrTiempoCreacion;
						$InsProductoCodigoReemplazo->PcrTiempoModificacion = $DatProductoCodigoReemplazo->PcrTiempoModificacion;
						
						if($InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo()){
							$validar++;					
						}else{
							$Resultado.='#ERR_PRO_241';
							$Resultado.='#Item Numero: '.($validar+1);	
						}	
										
					}					
					
					if(count($this->ProductoCodigoReemplazo) <> $validar ){
						$error = true;
					}	
					
				}
				
			}
			
			
			if(!$error){			
			
				if (!empty($this->ProductoFoto)){		
						
					$validar = 0;			
					
					foreach ($this->ProductoFoto as $DatProductoFoto){
						
						$InsProductoFoto = new ClsProductoFoto();		
						$InsProductoFoto->ProId = $this->ProId;
						$InsProductoFoto->PfoArchivo = $DatProductoFoto->PfoArchivo;
						$InsProductoFoto->PfoTipo = $DatProductoFoto->PfoTipo;				
						$InsProductoFoto->PfoCodigoExterno = $DatProductoFoto->PfoCodigoExterno;					
						$InsProductoFoto->PfoEstado = $DatProductoFoto->PfoEstado;								
						$InsProductoFoto->PfoTiempoCreacion = $DatProductoFoto->PfoTiempoCreacion;
						$InsProductoFoto->PfoTiempoModificacion = $DatProductoFoto->PfoTiempoModificacion;						
						$InsProductoFoto->PfoEliminado = $DatProductoFoto->PfoEliminado;
						
						if($InsProductoFoto->MtdRegistrarVehiculoIngresoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_PRO_701';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->ProductoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->MtdAuditarProducto(1,"Se registro el Producto.",$this);	
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarProducto() {
	
		global $Resultado;
		
		/*	ProPrecio = '.($this->ProPrecio).',
		ProCosto = '.($this->ProCosto).',		*/
		$sql = 'UPDATE tblproproducto SET 
		'.(empty($this->PcaId)?'PcaId = NULL, ':'PcaId = "'.$this->PcaId.'",').'
		
		ProCodigoOriginal = "'.($this->ProCodigoOriginal).'",			
		ProCodigoAlternativo = "'.($this->ProCodigoAlternativo).'",
		ProNombre = "'.($this->ProNombre).'",
		ProUbicacion = "'.($this->ProUbicacion).'",

		ProMarca = "'.($this->ProMarca).'",
		
		ProPeso = '.($this->ProPeso).',
		ProLargo = '.($this->ProLargo).',
		ProAncho = '.($this->ProAncho).',
		ProAlto = '.($this->ProAlto).',
		ProVolumen = '.($this->ProVolumen).',
		
		ProReferencia = "'.($this->ProReferencia).'",
		ProNota = "'.($this->ProNota).'",
		ProDimension = "'.($this->ProDimension).'",
		UmeId = "'.($this->UmeId).'",
		UmeIdIngreso = "'.($this->UmeIdIngreso).'",
		ProCodigoBarra = "'.($this->ProCodigoBarra).'",
		RtiId = "'.$this->RtiId.'",
		ProFoto = "'.($this->ProFoto).'",
		ProStockMinimo = '.($this->ProStockMinimo).',
		
		ProValidarUso = '.($this->ProValidarUso).',
		
		ProStockVerificado = '.($this->ProStockVerificado).',
		
		
		ProProcedencia = "'.($this->ProProcedencia).'",
		ProRotacion = "'.($this->ProRotacion).'",
		
		'.(empty($this->LtiId)?'LtiId = NULL, ':'LtiId = "'.$this->LtiId.'",').'
		ProCalcularPrecio = '.($this->ProCalcularPrecio).',
		ProTienePromocion = '.($this->ProTienePromocion).',
		
		ProPorcentajeAdicional = '.($this->ProPorcentajeAdicional).',
		ProPorcentajeDescuento = '.($this->ProPorcentajeDescuento).',
	
		ProCritico = '.($this->ProCritico).',
		ProDescontinuado = '.($this->ProDescontinuado).',
		ProEstado = '.($this->ProEstado).',
		ProTiempoModificacion = "'.($this->ProTiempoModificacion).'"		
		WHERE ProId = "'.($this->ProId).'";';
		
		/*
		'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
		'.(empty($this->ProTipoCambio)?'ProTipoCambio = NULL, ':'ProTipoCambio = "'.$this->ProTipoCambio.'",').'
		*/
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		
			if(!$error){
				if (!empty($this->ProductoVehiculoVersion)){		

					$validar = 0;				
					$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();		

					foreach ($this->ProductoVehiculoVersion as $DatProductoVehiculoVersion){

						$InsProductoVehiculoVersion->PvvId = $DatProductoVehiculoVersion->PvvId;
						$InsProductoVehiculoVersion->ProId = $this->ProId;
						$InsProductoVehiculoVersion->VveId = $DatProductoVehiculoVersion->VveId;
						$InsProductoVehiculoVersion->PvvTiempoCreacion = $DatProductoVehiculoVersion->PvvTiempoCreacion;
						$InsProductoVehiculoVersion->PvvTiempoModificacion = $DatProductoVehiculoVersion->PvvTiempoModificacion;
						$InsProductoVehiculoVersion->PvvEliminado = $DatProductoVehiculoVersion->PvvEliminado;

						if(empty($InsProductoVehiculoVersion->PvvId)){
							if($InsProductoVehiculoVersion->PvvEliminado<>2){
								if($InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_201';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsProductoVehiculoVersion->PvvEliminado==2){
								if($InsProductoVehiculoVersion->MtdEliminarProductoVehiculoVersion($InsProductoVehiculoVersion->PvvId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_203';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsProductoVehiculoVersion->MtdEditarProductoVehiculoVersion()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_PRO_232';
								//	$Resultado.='#Item Numero: '.($validar+1);	
								//}
							}
						}	
								
					}					
					
					if(count($this->ProductoVehiculoVersion) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
			
			
			
			if(!$error){
				if (!empty($this->ProductoAno)){		

					$validar = 0;				
					$InsProductoAno = new ClsProductoAno();		

					foreach ($this->ProductoAno as $DatProductoAno){

						$InsProductoAno->PanId = $DatProductoAno->PanId;
						$InsProductoAno->ProId = $this->ProId;
						$InsProductoAno->PanAno = $DatProductoAno->PanAno;
						$InsProductoAno->PanTiempoCreacion = $DatProductoAno->PanTiempoCreacion;
						$InsProductoAno->PanTiempoModificacion = $DatProductoAno->PanTiempoModificacion;
						$InsProductoAno->PanEliminado = $DatProductoAno->PanEliminado;

						if(empty($InsProductoAno->PanId)){
							if($InsProductoAno->PanEliminado<>2){
								if($InsProductoAno->MtdRegistrarProductoAno()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_211';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsProductoAno->PanEliminado==2){
								if($InsProductoAno->MtdEliminarProductoAno($InsProductoAno->PanId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_213';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsProductoAno->MtdEditarProductoAno()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_PRO_232';
								//	$Resultado.='#Item Numero: '.($validar+1);	
								//}
							}
						}	
								
					}					
					
					if(count($this->ProductoAno) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
			
			
			if(!$error){
				if (!empty($this->ProductoCodigoReemplazo)){		

					$validar = 0;				
					$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();		

					foreach ($this->ProductoCodigoReemplazo as $DatProductoCodigoReemplazo){

						$InsProductoCodigoReemplazo->PcrId = $DatProductoCodigoReemplazo->PcrId;
						$InsProductoCodigoReemplazo->ProId = $this->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoCodigoReemplazo->PcrNumero;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = $DatProductoCodigoReemplazo->PcrTiempoCreacion;
						$InsProductoCodigoReemplazo->PcrTiempoModificacion = $DatProductoCodigoReemplazo->PcrTiempoModificacion;
						$InsProductoCodigoReemplazo->PcrEliminado = $DatProductoCodigoReemplazo->PcrEliminado;

						if(empty($InsProductoCodigoReemplazo->PcrId)){
							if($InsProductoCodigoReemplazo->PcrEliminado<>2){
								if($InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_241';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsProductoCodigoReemplazo->PcrEliminado==2){
								if($InsProductoCodigoReemplazo->MtdEliminarProductoCodigoReemplazo($InsProductoCodigoReemplazo->PcrId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_243';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								if($InsProductoCodigoReemplazo->MtdEditarProductoCodigoReemplazo()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_242';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}
						}	
								
					}					
					
					if(count($this->ProductoCodigoReemplazo) <> $validar ){
						$error = true;
					}	
					
				}
			}
			



			if(!$error){

				if (!empty($this->ProductoFoto)){		

					$validar = 0;	
					foreach ($this->ProductoFoto as $DatProductoFoto){

						$InsProductoFoto = new ClsProductoFoto();
						$InsProductoFoto->PfoId = $DatProductoFoto->PfoId;
						$InsProductoFoto->ProId = $this->ProId;
						$InsProductoFoto->PfoArchivo = $DatProductoFoto->PfoArchivo;
						$InsProductoFoto->PfoTipo = $DatProductoFoto->PfoTipo;
						$InsProductoFoto->PfoCodigoExterno = $DatProductoFoto->PfoCodigoExterno;
						$InsProductoFoto->PfoEstado = $DatProductoFoto->PfoEstado;
						$InsProductoFoto->PfoTiempoCreacion = $DatProductoFoto->PfoTiempoCreacion;
						$InsProductoFoto->PfoTiempoModificacion = $DatProductoFoto->PfoTiempoModificacion;
						$InsProductoFoto->PfoEliminado = $DatProductoFoto->PfoEliminado;
						
						if(empty($InsProductoFoto->PfoId)){
							if($InsProductoFoto->PfoEliminado<>2){
								if($InsProductoFoto->MtdRegistrarProductoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PRO_701';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsProductoFoto->PfoEliminado==2){
								if($InsProductoFoto->MtdEliminarProductoFoto($InsProductoFoto->PfoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_703';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsProductoFoto->MtdEditarProductoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PRO_702';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->ProductoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
		
			$this->MtdAuditarProducto(2,"Se edito el Producto.",$this);	
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}	
		
		
		
		
		public function MtdEditarProductoUso() {
	
		global $Resultado;
		
		/*	ProPrecio = '.($this->ProPrecio).',
		ProCosto = '.($this->ProCosto).',		*/
	
		$sql = 'UPDATE tblproproducto SET 
		ProValidarUso = '.($this->ProValidarUso).',
		ProTiempoModificacion = "'.($this->ProTiempoModificacion).'"		
		WHERE ProId = "'.($this->ProId).'";';
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		
			if(!$error){
				if (!empty($this->ProductoVehiculoVersion)){		

					$validar = 0;				
					$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();		

					foreach ($this->ProductoVehiculoVersion as $DatProductoVehiculoVersion){

						$InsProductoVehiculoVersion->PvvId = $DatProductoVehiculoVersion->PvvId;
						$InsProductoVehiculoVersion->ProId = $this->ProId;
						$InsProductoVehiculoVersion->VveId = $DatProductoVehiculoVersion->VveId;
						$InsProductoVehiculoVersion->PvvTiempoCreacion = $DatProductoVehiculoVersion->PvvTiempoCreacion;
						$InsProductoVehiculoVersion->PvvTiempoModificacion = $DatProductoVehiculoVersion->PvvTiempoModificacion;
						$InsProductoVehiculoVersion->PvvEliminado = $DatProductoVehiculoVersion->PvvEliminado;

						if(empty($InsProductoVehiculoVersion->PvvId)){
							if($InsProductoVehiculoVersion->PvvEliminado<>2){
								if($InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_201';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsProductoVehiculoVersion->PvvEliminado==2){
								if($InsProductoVehiculoVersion->MtdEliminarProductoVehiculoVersion($InsProductoVehiculoVersion->PvvId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_203';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsProductoVehiculoVersion->MtdEditarProductoVehiculoVersion()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_PRO_232';
								//	$Resultado.='#Item Numero: '.($validar+1);	
								//}
							}
						}	
								
					}					
					
					if(count($this->ProductoVehiculoVersion) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
			
			
			
			if(!$error){
				if (!empty($this->ProductoAno)){		

					$validar = 0;				
					$InsProductoAno = new ClsProductoAno();		

					foreach ($this->ProductoAno as $DatProductoAno){

						$InsProductoAno->PanId = $DatProductoAno->PanId;
						$InsProductoAno->ProId = $this->ProId;
						$InsProductoAno->PanAno = $DatProductoAno->PanAno;
						$InsProductoAno->PanTiempoCreacion = $DatProductoAno->PanTiempoCreacion;
						$InsProductoAno->PanTiempoModificacion = $DatProductoAno->PanTiempoModificacion;
						$InsProductoAno->PanEliminado = $DatProductoAno->PanEliminado;

						if(empty($InsProductoAno->PanId)){
							if($InsProductoAno->PanEliminado<>2){
								if($InsProductoAno->MtdRegistrarProductoAno()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_211';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsProductoAno->PanEliminado==2){
								if($InsProductoAno->MtdEliminarProductoAno($InsProductoAno->PanId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_213';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsProductoAno->MtdEditarProductoAno()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_PRO_232';
								//	$Resultado.='#Item Numero: '.($validar+1);	
								//}
							}
						}	
								
					}					
					
					if(count($this->ProductoAno) <> $validar ){
						$error = true;
					}	
					
				}
			}
			
			
			
			
			
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
		
			$this->MtdAuditarProducto(2,"Se edito el Uso del producto.",$this);	
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}	
	
	public function MtdEditarProductoCodigoOriginal($oProductoId,$oProductoCodigoOriginal) {
	
		global $Resultado;
		
		/*	ProPrecio = '.($this->ProPrecio).',
		ProCosto = '.($this->ProCosto).',		*/
	
		$sql = 'UPDATE tblproproducto SET 
		ProCodigoOriginal = "'.($oProductoCodigoOriginal).'",
		ProTiempoModificacion = NOW()	
		WHERE ProId = "'.($oProductoId).'";';
		
		$error = false;
		
//		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 

		if($error) {							
			return false;
		} else {	
			$this->MtdAuditarProducto(2,"Se edito el Codigo Original del producto.",$this);							
			return true;
		}						
			
	}	
	
	 public function MtdVerificarStockProducto(){

        $sql = 'SELECT 
		pro.ProId,
		pro.ProStock
        FROM tblproproducto pro
        WHERE  pro.ProId = "'.$this->ProId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->ProId = $fila['ProId'];
			$this->ProStock = $fila['ProStock']; 
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }	




	public function MtdActualizarListaPrecioMercado() {
	
		global $Resultado;
	
		$this->InsMysql->MtdTransaccionIniciar();
	
		$sql = 'UPDATE tblproproducto SET 
		ProCosto = '.($this->ProCosto).',
		ProCostoIngreso = '.($this->ProCostoIngreso).',
		ProPrecioMercado = '.($this->ProPrecioMercado).',
		ProTiempoModificacion = "'.($this->ProTiempoModificacion).'"		
		WHERE ProId = "'.($this->ProId).'";';
		
		$error = false;
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
		
		if(!$resultado) {							
			$error = true;
		} 


		
		
			if(!$error){
				if (!empty($this->ListaPrecio)){		

					$validar = 0;				
					$InsListaPrecio = new ClsListaPrecio();		

					//deb($this->ListaPrecio);
					foreach ($this->ListaPrecio as $DatListaPrecio){

						$InsListaPrecio->LprId = $DatListaPrecio->LprId;
						$InsListaPrecio->ProId = $this->ProId;
						$InsListaPrecio->LtiId = $DatListaPrecio->LtiId;
						$InsListaPrecio->UmeId = $DatListaPrecio->UmeId;

						$InsListaPrecio->LprCosto = $DatListaPrecio->LprCosto;

						$InsListaPrecio->LprPorcentajeOtroCosto = $DatListaPrecio->LprPorcentajeOtroCosto;
						$InsListaPrecio->LprPorcentajeUtilidad = $DatListaPrecio->LprPorcentajeUtilidad;
						$InsListaPrecio->LprPorcentajeManoObra = $DatListaPrecio->LprPorcentajeManoObra;

						$InsListaPrecio->LprPorcentajeAdicional = $DatListaPrecio->LprPorcentajeUtilidad;
						$InsListaPrecio->LprPorcentajeDescuento = $DatListaPrecio->LprPorcentajeDescuento;

						$InsListaPrecio->LprOtroCosto = $DatListaPrecio->LprOtroCosto;
						$InsListaPrecio->LprUtilidad = $DatListaPrecio->LprUtilidad;
						$InsListaPrecio->LprManoObra = $DatListaPrecio->LprManoObra;
						
						$InsListaPrecio->LprAdicional = $DatListaPrecio->LprAdicional;
						$InsListaPrecio->LprDescuento = $DatListaPrecio->LprDescuento;
						
						$InsListaPrecio->LprValorVenta = $DatListaPrecio->LprValorVenta;
						$InsListaPrecio->LprImpuesto = $DatListaPrecio->LprImpuesto;
						$InsListaPrecio->LprPrecio = $DatListaPrecio->LprPrecio;

						$InsListaPrecio->LprTiempoCreacion = $DatListaPrecio->LprTiempoCreacion;
						$InsListaPrecio->LprTiempoModificacion = $DatListaPrecio->LprTiempoModificacion;
						$InsListaPrecio->LprEliminado = $DatListaPrecio->LprEliminado;

						if(empty($InsListaPrecio->LprId)){
						
							if($InsListaPrecio->LprEliminado<>2){
								if($InsListaPrecio->MtdRegistrarListaPrecio()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_221';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsListaPrecio->LprEliminado==2){
								if($InsListaPrecio->MtdEliminarListaPrecio($InsListaPrecio->LprId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_223';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								if($InsListaPrecio->MtdEditarListaPrecio()){
									$validar++;					
								}else{
									$Resultado.='#ERR_PRO_222';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}
						}	
								
					}					
					
					if(count($this->ListaPrecio) <> $validar ){
						$error = true;
					}	
					
				}
			}
			

		
			//if(!$error){
//				if (!empty($this->ProductoCosto)){		
//
//					$validar = 0;				
//					$InsProductoCosto = new ClsProductoCosto();		
//
//					foreach ($this->ProductoCosto as $DatProductoCosto){
//
//						$InsProductoCosto->RcoId = $DatProductoCosto->RcoId;
//						$InsProductoCosto->ProId = $this->ProId;
//						$InsProductoCosto->UmeId = $DatProductoCosto->UmeId;
//						$InsProductoCosto->UmeIdIngreso = $DatProductoCosto->UmeIdIngreso;						
//						$InsProductoCosto->RcoCosto = $DatProductoCosto->RcoCosto;
//						$InsProductoCosto->RcoTiempoCreacion = $DatProductoCosto->RcoTiempoCreacion;
//						$InsProductoCosto->RcoTiempoModificacion = $DatProductoCosto->RcoTiempoModificacion;
//						$InsProductoCosto->RcoEliminado = $DatProductoCosto->RcoEliminado;
//
//						if(empty($InsProductoCosto->RcoId)){
//						
//							if($InsProductoCosto->RcoEliminado<>2){
//								if($InsProductoCosto->MtdRegistrarProductoCosto()){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_PRO_231';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}else{
//								$validar++;	
//							}
//							
//						}else{						
//							if($InsProductoCosto->RcoEliminado==2){
//								if($InsProductoCosto->MtdEliminarProductoCosto($InsProductoCosto->RcoId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_PRO_233';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}else{
//								if($InsProductoCosto->MtdEditarProductoCosto()){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_PRO_232';
//									$Resultado.='#Item Numero: '.($validar+1);	
//								}
//							}
//						}	
//								
//					}					
//					
//					if(count($this->ProductoCosto) <> $validar ){
//						$error = true;
//					}	
//					
//				}
//			}		
			
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
		
			$this->MtdAuditarProducto(2,"Se edito el Precio Lista del producto.",$this);	
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}	
	
	
	

	public function MtdActualizarProductoCosto() {
	
		global $Resultado;
	
		$this->InsMysql->MtdTransaccionIniciar();
	
		$sql = 'UPDATE tblproproducto SET 
		ProCosto = '.($this->ProCosto).',
		ProTiempoModificacion = "'.($this->ProTiempoModificacion).'"		
		WHERE ProId = "'.($this->ProId).'";';
		
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
	
	public function MtdActualizarPrductoABC() {
		
			$sql = 'UPDATE tblproproducto SET 
			ProProcedencia = "'.($this->ProProcedencia).'",
			ProRotacion = "'.($this->ProRotacion).'",
			
			ProTiempoModificacion = "'.($this->ProTiempoModificacion).'"		
			WHERE ProId = "'.($this->ProId).'";';
			
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if($error) {		
				
				//$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {		
			
				$this->MtdAuditarProducto(2,"Se actualizo informacion ABC del producto.",$this);		
//				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	



	public function MtdVerificarExisteProductoCodigoOriginal($oProCodigoOriginal,$oProId=NULL){

		$ProId = "";
		
		if(!empty($oProId)){
			$producto = ' AND pro.ProId <> "'.$oProId.'"';
		}
		
        $sql = 'SELECT 
		pro.ProId
        FROM tblproproducto pro
        WHERE  pro.ProCodigoOriginal = "'.trim($oProCodigoOriginal).'" '.$producto.'LIMIT 1;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				$ProId  = $fila['ProId'];
			}
		}
		return $ProId ;

	}
		
		

	public function MtdEditarProductoDato($oCampo,$oDato,$oProductoId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblproproducto SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE ProId = "'.($oProductoId).'";';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 

		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						

	}	
	
	
	public function MtdEditarProductoStock($oProductoId,$oProductoStock) {
	
		global $Resultado;
	
	
		$sql = 'UPDATE tblproproducto SET 
		ProStock = '.($oProductoStock).'
		WHERE ProId = "'.($oProductoId).'";';
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}
	
	
		
		private function MtdAuditarProducto($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->ProId;
			$InsAuditoria->AudCodigoExtra = NULL;
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = NULL;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar("v2")){
				return true;
			}else{
				return false;	
			}
			
		}
		
	
		public function MtdNotificarProductoSinStock($oProductoId,$oDestinatario,$oUsuario=NULL){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->ProId = $oProductoId;
			$this->MtdObtenerProducto(false);
			
			if(!empty($oUsuario)){
				
				$InsUsuario = new ClsUsuario();
				$InsUsuario->UsuId = $oUsuario;
				$InsUsuario->MtdObtenerUsuario(false);
				$Usuario = $InsUsuario->UsuUsuario;
				
			}
			
			$mensaje .= "NOTIFICACION DE PRODUCTO POR REVISAR STOCK:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de notificacion de producto por revisar stock.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->ProId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Codigo Original: <b>".$this->ProCodigoOriginal."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Fecha de notificacion: <b>".$this->ProRevisadoFecha."</b>";	
			$mensaje .= "<br>";	

			$mensaje .= "Stock actual: <b>".$this->ProStockReal."</b>";	
			$mensaje .= "<br>";

			$mensaje .= "Notificado por: <b>".$Usuario."</b>";	
			$mensaje .= "<br>";
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema SISCYC a las ".date('d/m/Y H:i:s');
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REVISAR PRODUCTO STOCK. Cod.: ".$this->ProId." - ".$this->ProCodigoOriginal." - ".$this->ProNombre,$mensaje);
//				
		}
		
					
	
}
?>