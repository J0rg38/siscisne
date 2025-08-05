<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPlanMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPlanMantenimiento {

    public $PmaId;
    public $PmaNombre;
	public $PmaDuracion;	
	
	public $VmaId;
	public $VmoId;
	public $VveId;
	
    public $PmaTiempoCreacion;
    public $PmaTiempoModificacion;
    public $PmaEliminado;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	
    public $InsMysql;
	
	public $PmaChevroletKilometrajes;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		

		/*
		* RESUMEN
		*/
		
		$this->PmaChevroletKilometrajesResumen = array(

		"1.5"=> array("km"=>1500,"eq"=>1500),
		"5"=> array("km"=>5000,"eq"=>5000),
		"10"=>array("km"=>10000,"eq"=>10000),
		"15"=>array("km"=>15000,"eq"=>15000),
		"20"=>array("km"=>20000,"eq"=>20000),
		"25"=>array("km"=>25000,"eq"=>25000),
		"30"=>array("km"=>30000,"eq"=>30000),
		"35"=>array("km"=>35000,"eq"=>35000),
		"40"=>array("km"=>40000,"eq"=>40000),
		"45"=>array("km"=>45000,"eq"=>45000),
		"50"=>array("km"=>50000,"eq"=>50000),
		"55"=>array("km"=>55000,"eq"=>55000),
		"60"=>array("km"=>60000,"eq"=>60000),
		"65"=>array("km"=>65000,"eq"=>65000),
		"70"=>array("km"=>70000,"eq"=>70000),
		"75"=>array("km"=>75000,"eq"=>75000),
		"80"=>array("km"=>80000,"eq"=>80000)
		
		);
		
				$this->PmaIsuzuKilometrajesResumen = array(
		"1"=> array("km"=>1000,"eq"=>1000),
		"5"=> array("km"=>5000,"eq"=>5000),
		"10"=>array("km"=>10000,"eq"=>10000),
		"15"=>array("km"=>15000,"eq"=>15000),
		"20"=>array("km"=>20000,"eq"=>20000),
		"25"=>array("km"=>25000,"eq"=>25000),
		"30"=>array("km"=>30000,"eq"=>30000),
		"35"=>array("km"=>35000,"eq"=>35000),
		
		"40"=>array("km"=>40000,"eq"=>40000),
		"45"=>array("km"=>45000,"eq"=>45000),
		"50"=>array("km"=>50000,"eq"=>50000),
		"55"=>array("km"=>55000,"eq"=>55000),
		"60"=>array("km"=>60000,"eq"=>60000),
		"65"=>array("km"=>65000,"eq"=>65000),
		"70"=>array("km"=>70000,"eq"=>70000),
		"75"=>array("km"=>75000,"eq"=>75000)
		);
		
		
		/*
		* NORMALES
		*/
		
		$this->PmaChevroletKilometrajes = array(

		"1.5"=> array("km"=>1500,"eq"=>1500),
		"5"=> array("km"=>5000,"eq"=>5000),
		"10"=>array("km"=>10000,"eq"=>10000),
		"15"=>array("km"=>15000,"eq"=>15000),
		"20"=>array("km"=>20000,"eq"=>20000),
		"25"=>array("km"=>25000,"eq"=>25000),
		"30"=>array("km"=>30000,"eq"=>30000),
		"35"=>array("km"=>35000,"eq"=>35000),
		"40"=>array("km"=>40000,"eq"=>40000),
		"45"=>array("km"=>45000,"eq"=>45000),
		"50"=>array("km"=>50000,"eq"=>50000),
		"55"=>array("km"=>55000,"eq"=>55000),
		"60"=>array("km"=>60000,"eq"=>60000),
		"65"=>array("km"=>65000,"eq"=>65000),
		"70"=>array("km"=>70000,"eq"=>70000),
		"75"=>array("km"=>75000,"eq"=>75000),
		"80"=>array("km"=>80000,"eq"=>80000),
		
		"85"=>array("km"=>85000,"eq"=>5000),
		"90"=>array("km"=>90000,"eq"=>10000),
		"95"=>array("km"=>95000,"eq"=>15000),
		"100"=>array("km"=>100000,"eq"=>20000),
		"105"=>array("km"=>105000,"eq"=>25000),
		"110"=>array("km"=>110000,"eq"=>30000),
		"115"=>array("km"=>115000,"eq"=>35000),
		"120"=>array("km"=>120000,"eq"=>40000),
		"125"=>array("km"=>125000,"eq"=>45000),
		"130"=>array("km"=>130000,"eq"=>50000),
		"135"=>array("km"=>135000,"eq"=>55000),
		"140"=>array("km"=>140000,"eq"=>60000),
		"145"=>array("km"=>145000,"eq"=>65000),
		"150"=>array("km"=>150000,"eq"=>70000),
		"155"=>array("km"=>155000,"eq"=>75000),
		"160"=>array("km"=>160000,"eq"=>80000),
		
		"165"=>array("km"=>165000,"eq"=>5000),
		"170"=>array("km"=>170000,"eq"=>10000),
		"175"=>array("km"=>175000,"eq"=>15000),
		"180"=>array("km"=>180000,"eq"=>20000),
		"185"=>array("km"=>185000,"eq"=>25000),
		"190"=>array("km"=>190000,"eq"=>30000),
		"195"=>array("km"=>195000,"eq"=>35000),
		"200"=>array("km"=>200000,"eq"=>40000),
		
		"205"=>array("km"=>205000,"eq"=>40000),
		"210"=>array("km"=>210000,"eq"=>45000),
		"215"=>array("km"=>215000,"eq"=>50000),
		"220"=>array("km"=>220000,"eq"=>55000),
		"225"=>array("km"=>225000,"eq"=>60000),
		"230"=>array("km"=>230000,"eq"=>65000),
		"235"=>array("km"=>235000,"eq"=>70000),
		"240"=>array("km"=>240000,"eq"=>75000),
		"245"=>array("km"=>245000,"eq"=>40000),

		"250"=>array("km"=>250000,"eq"=>40000),
		"255"=>array("km"=>255000,"eq"=>45000),
		"260"=>array("km"=>260000,"eq"=>50000),
		"265"=>array("km"=>265000,"eq"=>55000),
		"270"=>array("km"=>270000,"eq"=>60000),
		"275"=>array("km"=>275000,"eq"=>65000),
		"280"=>array("km"=>280000,"eq"=>70000),
		"285"=>array("km"=>285000,"eq"=>75000),
		
		"290"=>array("km"=>290000,"eq"=>40000),
		"295"=>array("km"=>295000,"eq"=>45000),
		"300"=>array("km"=>300000,"eq"=>50000),
		"305"=>array("km"=>305000,"eq"=>55000),
		"310"=>array("km"=>310000,"eq"=>60000),
		"315"=>array("km"=>315000,"eq"=>65000),
		"320"=>array("km"=>320000,"eq"=>70000),
		"325"=>array("km"=>325000,"eq"=>75000),
		
		"330"=>array("km"=>330000,"eq"=>40000),
		"335"=>array("km"=>335000,"eq"=>45000),
		"340"=>array("km"=>340000,"eq"=>50000),
		"345"=>array("km"=>345000,"eq"=>55000),
		"350"=>array("km"=>350000,"eq"=>60000),
		"355"=>array("km"=>355000,"eq"=>65000),
		"360"=>array("km"=>360000,"eq"=>70000),
		"365"=>array("km"=>365000,"eq"=>75000),
		
		"370"=>array("km"=>370000,"eq"=>40000),
		"375"=>array("km"=>375000,"eq"=>45000),
		"380"=>array("km"=>380000,"eq"=>50000),
		"385"=>array("km"=>385000,"eq"=>55000),
		"390"=>array("km"=>390000,"eq"=>60000),
		"395"=>array("km"=>395000,"eq"=>65000),
		"400"=>array("km"=>400000,"eq"=>70000),
		"405"=>array("km"=>405000,"eq"=>75000),
		
		"410"=>array("km"=>410000,"eq"=>40000),
		"415"=>array("km"=>415000,"eq"=>45000),
		"420"=>array("km"=>420000,"eq"=>50000),
		"425"=>array("km"=>425000,"eq"=>55000),
		"430"=>array("km"=>430000,"eq"=>60000),
		"435"=>array("km"=>435000,"eq"=>65000),
		"440"=>array("km"=>440000,"eq"=>70000),
		"445"=>array("km"=>445000,"eq"=>75000),
		
		"450"=>array("km"=>450000,"eq"=>40000),
		"455"=>array("km"=>455000,"eq"=>45000),
		"460"=>array("km"=>460000,"eq"=>50000),
		"465"=>array("km"=>465000,"eq"=>55000),
		"470"=>array("km"=>470000,"eq"=>60000),
		"475"=>array("km"=>475000,"eq"=>65000),
		"480"=>array("km"=>480000,"eq"=>70000),
		"485"=>array("km"=>485000,"eq"=>75000),
		
		"490"=>array("km"=>490000,"eq"=>40000),
		"495"=>array("km"=>495000,"eq"=>45000),
		"500"=>array("km"=>500000,"eq"=>50000),
		"505"=>array("km"=>505000,"eq"=>55000),
		"510"=>array("km"=>510000,"eq"=>60000),
		"515"=>array("km"=>515000,"eq"=>65000),
		"520"=>array("km"=>520000,"eq"=>70000),
		"525"=>array("km"=>525000,"eq"=>75000),
		
		"530"=>array("km"=>530000,"eq"=>40000),
		"535"=>array("km"=>535000,"eq"=>45000),
		"540"=>array("km"=>540000,"eq"=>50000),
		"545"=>array("km"=>545000,"eq"=>55000),
		"550"=>array("km"=>550000,"eq"=>60000),
		"555"=>array("km"=>555000,"eq"=>65000),
		"560"=>array("km"=>560000,"eq"=>70000),
		"565"=>array("km"=>565000,"eq"=>75000),
		
		"570"=>array("km"=>570000,"eq"=>40000),
		"575"=>array("km"=>575000,"eq"=>45000),
		"580"=>array("km"=>580000,"eq"=>50000),
		"585"=>array("km"=>585000,"eq"=>55000),
		"590"=>array("km"=>590000,"eq"=>60000),
		"595"=>array("km"=>595000,"eq"=>65000),
		"600"=>array("km"=>600000,"eq"=>70000),
		"605"=>array("km"=>605000,"eq"=>75000)
		
		);
		
		
		
		
		
		
		$this->PmaIsuzuKilometrajes = array(
		"1"=> array("km"=>1000,"eq"=>1000),
		"5"=> array("km"=>5000,"eq"=>5000),
		"10"=>array("km"=>10000,"eq"=>10000),
		"15"=>array("km"=>15000,"eq"=>15000),
		"20"=>array("km"=>20000,"eq"=>20000),
		"25"=>array("km"=>25000,"eq"=>25000),
		"30"=>array("km"=>30000,"eq"=>30000),
		"35"=>array("km"=>35000,"eq"=>35000),
		
		"40"=>array("km"=>40000,"eq"=>40000),
		"45"=>array("km"=>45000,"eq"=>45000),
		"50"=>array("km"=>50000,"eq"=>50000),
		"55"=>array("km"=>55000,"eq"=>55000),
		"60"=>array("km"=>60000,"eq"=>60000),
		"65"=>array("km"=>65000,"eq"=>65000),
		"70"=>array("km"=>70000,"eq"=>70000),
		"75"=>array("km"=>75000,"eq"=>75000),
		
		"80"=>array("km"=>80000,"eq"=>40000),		
		"85"=>array("km"=>85000,"eq"=>45000),
		"90"=>array("km"=>90000,"eq"=>50000),
		"95"=>array("km"=>95000,"eq"=>55000),
		"100"=>array("km"=>100000,"eq"=>60000),
		"105"=>array("km"=>105000,"eq"=>65000),
		"110"=>array("km"=>110000,"eq"=>70000),
		"115"=>array("km"=>115000,"eq"=>75000),
		
		"120"=>array("km"=>120000,"eq"=>40000),
		"125"=>array("km"=>125000,"eq"=>45000),
		"130"=>array("km"=>130000,"eq"=>50000),
		"135"=>array("km"=>135000,"eq"=>55000),
		"140"=>array("km"=>140000,"eq"=>60000),
		"145"=>array("km"=>145000,"eq"=>65000),
		"150"=>array("km"=>150000,"eq"=>70000),
		"155"=>array("km"=>155000,"eq"=>75000),
		
		"160"=>array("km"=>160000,"eq"=>40000),
		"165"=>array("km"=>165000,"eq"=>45000),
		"170"=>array("km"=>170000,"eq"=>50000),
		"175"=>array("km"=>175000,"eq"=>55000),
		"180"=>array("km"=>180000,"eq"=>60000),
		"185"=>array("km"=>185000,"eq"=>65000),
		"190"=>array("km"=>190000,"eq"=>70000),
		"195"=>array("km"=>195000,"eq"=>75000),
		"200"=>array("km"=>200000,"eq"=>80000),
		
		"205"=>array("km"=>205000,"eq"=>40000),
		"210"=>array("km"=>210000,"eq"=>45000),
		"215"=>array("km"=>215000,"eq"=>50000),
		"220"=>array("km"=>220000,"eq"=>55000),
		"225"=>array("km"=>225000,"eq"=>60000),
		"230"=>array("km"=>230000,"eq"=>65000),
		"235"=>array("km"=>235000,"eq"=>70000),
		"240"=>array("km"=>240000,"eq"=>75000),
		"245"=>array("km"=>245000,"eq"=>40000),

		"250"=>array("km"=>250000,"eq"=>40000),
		"255"=>array("km"=>255000,"eq"=>45000),
		"260"=>array("km"=>260000,"eq"=>50000),
		"265"=>array("km"=>265000,"eq"=>55000),
		"270"=>array("km"=>270000,"eq"=>60000),
		"275"=>array("km"=>275000,"eq"=>65000),
		"280"=>array("km"=>280000,"eq"=>70000),
		"285"=>array("km"=>285000,"eq"=>75000),
		
		"290"=>array("km"=>290000,"eq"=>40000),
		"295"=>array("km"=>295000,"eq"=>45000),
		"300"=>array("km"=>300000,"eq"=>50000),
		"305"=>array("km"=>305000,"eq"=>55000),
		"310"=>array("km"=>310000,"eq"=>60000),
		"315"=>array("km"=>315000,"eq"=>65000),
		"320"=>array("km"=>320000,"eq"=>70000),
		"325"=>array("km"=>325000,"eq"=>75000),
		
		"330"=>array("km"=>330000,"eq"=>40000),
		"335"=>array("km"=>335000,"eq"=>45000),
		"340"=>array("km"=>340000,"eq"=>50000),
		"345"=>array("km"=>345000,"eq"=>55000),
		"350"=>array("km"=>350000,"eq"=>60000),
		"355"=>array("km"=>355000,"eq"=>65000),
		"360"=>array("km"=>360000,"eq"=>70000),
		"365"=>array("km"=>365000,"eq"=>75000),
		
		"370"=>array("km"=>370000,"eq"=>40000),
		"375"=>array("km"=>375000,"eq"=>45000),
		"380"=>array("km"=>380000,"eq"=>50000),
		"385"=>array("km"=>385000,"eq"=>55000),
		"390"=>array("km"=>390000,"eq"=>60000),
		"395"=>array("km"=>395000,"eq"=>65000),
		"400"=>array("km"=>400000,"eq"=>70000),
		"405"=>array("km"=>405000,"eq"=>75000),
		
		"410"=>array("km"=>410000,"eq"=>40000),
		"415"=>array("km"=>415000,"eq"=>45000),
		"420"=>array("km"=>420000,"eq"=>50000),
		"425"=>array("km"=>425000,"eq"=>55000),
		"430"=>array("km"=>430000,"eq"=>60000),
		"435"=>array("km"=>435000,"eq"=>65000),
		"440"=>array("km"=>440000,"eq"=>70000),
		"445"=>array("km"=>445000,"eq"=>75000),
		
		"450"=>array("km"=>450000,"eq"=>40000),
		"455"=>array("km"=>455000,"eq"=>45000),
		"460"=>array("km"=>460000,"eq"=>50000),
		"465"=>array("km"=>465000,"eq"=>55000),
		"470"=>array("km"=>470000,"eq"=>60000),
		"475"=>array("km"=>475000,"eq"=>65000),
		"480"=>array("km"=>480000,"eq"=>70000),
		"485"=>array("km"=>485000,"eq"=>75000),
		
		"490"=>array("km"=>490000,"eq"=>40000),
		"495"=>array("km"=>495000,"eq"=>45000),
		"500"=>array("km"=>500000,"eq"=>50000),
		"505"=>array("km"=>505000,"eq"=>55000),
		"510"=>array("km"=>510000,"eq"=>60000),
		"515"=>array("km"=>515000,"eq"=>65000),
		"520"=>array("km"=>520000,"eq"=>70000),
		"525"=>array("km"=>525000,"eq"=>75000),
		
		"530"=>array("km"=>530000,"eq"=>40000),
		"535"=>array("km"=>535000,"eq"=>45000),
		"540"=>array("km"=>540000,"eq"=>50000),
		"545"=>array("km"=>545000,"eq"=>55000),
		"550"=>array("km"=>550000,"eq"=>60000),
		"555"=>array("km"=>555000,"eq"=>65000),
		"560"=>array("km"=>560000,"eq"=>70000),
		"565"=>array("km"=>565000,"eq"=>75000),
		
		"570"=>array("km"=>570000,"eq"=>40000),
		"575"=>array("km"=>575000,"eq"=>45000),
		"580"=>array("km"=>580000,"eq"=>50000),
		"585"=>array("km"=>585000,"eq"=>55000),
		"590"=>array("km"=>590000,"eq"=>60000),
		"595"=>array("km"=>595000,"eq"=>65000),
		"600"=>array("km"=>600000,"eq"=>70000),
		"605"=>array("km"=>605000,"eq"=>75000)

		
		);
		
		
/*
* NUEVO
*/


		
		$this->PmaChevroletKilometrajesNuevo = array(

		"1500"=> array("cc"=>1.5,"km"=>1500,"eq"=>1500),
		"5000"=> array("cc"=>5,"km"=>5000,"eq"=>5000),
		"10000"=>array("cc"=>10,"km"=>10000,"eq"=>10000),
		"15000"=>array("cc"=>15,"km"=>15000,"eq"=>15000),
		"20000"=>array("cc"=>20,"km"=>20000,"eq"=>20000),
		"25000"=>array("cc"=>25,"km"=>25000,"eq"=>25000),
		"30000"=>array("cc"=>30,"km"=>30000,"eq"=>30000),
		"35000"=>array("cc"=>35,"km"=>35000,"eq"=>35000),
		"40000"=>array("cc"=>40,"km"=>40000,"eq"=>40000),
		"45000"=>array("cc"=>45,"km"=>45000,"eq"=>45000),
		"50000"=>array("cc"=>50,"km"=>50000,"eq"=>50000),
		"55000"=>array("cc"=>55,"km"=>55000,"eq"=>55000),
		"60000"=>array("cc"=>60,"km"=>60000,"eq"=>60000),
		"65000"=>array("cc"=>65,"km"=>65000,"eq"=>65000),
		"70000"=>array("cc"=>70,"km"=>70000,"eq"=>70000),
		"75000"=>array("cc"=>75,"km"=>75000,"eq"=>75000),
		"80000"=>array("cc"=>80,"km"=>80000,"eq"=>80000),
		
		"85000"=>array("cc"=>85,"km"=>85000,"eq"=>5000),
		"90000"=>array("cc"=>90,"km"=>90000,"eq"=>10000),
		"95000"=>array("cc"=>95,"km"=>95000,"eq"=>15000),
		"100000"=>array("cc"=>100,"km"=>100000,"eq"=>20000),
		"105000"=>array("cc"=>105,"km"=>105000,"eq"=>25000),
		"110000"=>array("cc"=>110,"km"=>110000,"eq"=>30000),
		"115000"=>array("cc"=>115,"km"=>115000,"eq"=>35000),
		"120000"=>array("cc"=>120,"km"=>120000,"eq"=>40000),
		"125000"=>array("cc"=>125,"km"=>125000,"eq"=>45000),
		"130000"=>array("cc"=>130,"km"=>130000,"eq"=>50000),
		"135000"=>array("cc"=>135,"km"=>135000,"eq"=>55000),
		"140000"=>array("cc"=>140,"km"=>140000,"eq"=>60000),
		"145000"=>array("cc"=>145,"km"=>145000,"eq"=>65000),
		"150000"=>array("cc"=>150,"km"=>150000,"eq"=>70000),
		"155000"=>array("cc"=>155,"km"=>155000,"eq"=>75000),
		"160000"=>array("cc"=>160,"km"=>160000,"eq"=>80000),
		
		"165000"=>array("cc"=>165,"km"=>165000,"eq"=>5000),
		"170000"=>array("cc"=>170,"km"=>170000,"eq"=>10000),
		"175000"=>array("cc"=>175,"km"=>175000,"eq"=>15000),
		"180000"=>array("cc"=>180,"km"=>180000,"eq"=>20000),
		"185000"=>array("cc"=>185,"km"=>185000,"eq"=>25000),
		"190000"=>array("cc"=>190,"km"=>190000,"eq"=>30000),
		"195000"=>array("cc"=>195,"km"=>195000,"eq"=>35000),
		"200000"=>array("cc"=>200,"km"=>200000,"eq"=>40000),
		
		"205000"=>array("cc"=>205,"km"=>205000,"eq"=>40000),
		"210000"=>array("cc"=>210,"km"=>210000,"eq"=>45000),
		"215000"=>array("cc"=>215,"km"=>215000,"eq"=>50000),
		"220000"=>array("cc"=>220,"km"=>220000,"eq"=>55000),
		"225000"=>array("cc"=>225,"km"=>225000,"eq"=>60000),
		"230000"=>array("cc"=>230,"km"=>230000,"eq"=>65000),
		"235000"=>array("cc"=>235,"km"=>235000,"eq"=>70000),
		"240000"=>array("cc"=>240,"km"=>240000,"eq"=>75000),
		"245000"=>array("cc"=>245,"km"=>245000,"eq"=>40000),

		"250000"=>array("cc"=>250,"km"=>250000,"eq"=>40000),
		"255000"=>array("cc"=>255,"km"=>255000,"eq"=>45000),
		"260000"=>array("cc"=>260,"km"=>260000,"eq"=>50000),
		"265000"=>array("cc"=>265,"km"=>265000,"eq"=>55000),
		"270000"=>array("cc"=>270,"km"=>270000,"eq"=>60000),
		"275000"=>array("cc"=>275,"km"=>275000,"eq"=>65000),
		"280000"=>array("cc"=>280,"km"=>280000,"eq"=>70000),
		"285000"=>array("cc"=>285,"km"=>285000,"eq"=>75000),
		
		"290000"=>array("cc"=>290,"km"=>290000,"eq"=>40000),
		"295000"=>array("cc"=>295,"km"=>295000,"eq"=>45000),
		"300000"=>array("cc"=>300,"km"=>300000,"eq"=>50000),
		"305000"=>array("cc"=>305,"km"=>305000,"eq"=>55000),
		"310000"=>array("cc"=>310,"km"=>310000,"eq"=>60000),
		"315000"=>array("cc"=>315,"km"=>315000,"eq"=>65000),
		"320000"=>array("cc"=>320,"km"=>320000,"eq"=>70000),
		"325000"=>array("cc"=>325,"km"=>325000,"eq"=>75000),
		
		"330000"=>array("cc"=>330,"km"=>330000,"eq"=>40000),
		"335000"=>array("cc"=>335,"km"=>335000,"eq"=>45000),
		"340000"=>array("cc"=>340,"km"=>340000,"eq"=>50000),
		"345000"=>array("cc"=>345,"km"=>345000,"eq"=>55000),
		"350000"=>array("cc"=>350,"km"=>350000,"eq"=>60000),
		"355000"=>array("cc"=>355,"km"=>355000,"eq"=>65000),
		"360000"=>array("cc"=>360,"km"=>360000,"eq"=>70000),
		"365000"=>array("cc"=>365,"km"=>365000,"eq"=>75000),
		
		"370000"=>array("cc"=>370,"km"=>370000,"eq"=>40000),
		"375000"=>array("cc"=>375,"km"=>375000,"eq"=>45000),
		"380000"=>array("cc"=>380,"km"=>380000,"eq"=>50000),
		"385000"=>array("cc"=>385,"km"=>385000,"eq"=>55000),
		"390000"=>array("cc"=>390,"km"=>390000,"eq"=>60000),
		"395000"=>array("cc"=>395,"km"=>395000,"eq"=>65000),
		"400000"=>array("cc"=>400,"km"=>400000,"eq"=>70000),
		"405000"=>array("cc"=>405,"km"=>405000,"eq"=>75000),
		
		"410000"=>array("cc"=>410,"km"=>410000,"eq"=>40000),
		"415000"=>array("cc"=>415,"km"=>415000,"eq"=>45000),
		"420000"=>array("cc"=>420,"km"=>420000,"eq"=>50000),
		"425000"=>array("cc"=>425,"km"=>425000,"eq"=>55000),
		"430000"=>array("cc"=>430,"km"=>430000,"eq"=>60000),
		"435000"=>array("cc"=>435,"km"=>435000,"eq"=>65000),
		"440000"=>array("cc"=>440,"km"=>440000,"eq"=>70000),
		"445000"=>array("cc"=>445,"km"=>445000,"eq"=>75000),
		
		"450000"=>array("cc"=>450,"km"=>450000,"eq"=>40000),
		"455000"=>array("cc"=>455,"km"=>455000,"eq"=>45000),
		"460000"=>array("cc"=>460,"km"=>460000,"eq"=>50000),
		"465000"=>array("cc"=>465,"km"=>465000,"eq"=>55000),
		"470000"=>array("cc"=>470,"km"=>470000,"eq"=>60000),
		"475000"=>array("cc"=>475,"km"=>475000,"eq"=>65000),
		"480000"=>array("cc"=>480,"km"=>480000,"eq"=>70000),
		"485000"=>array("cc"=>485,"km"=>485000,"eq"=>75000),
		
		"490000"=>array("cc"=>490,"km"=>490000,"eq"=>40000),
		"495000"=>array("cc"=>495,"km"=>495000,"eq"=>45000),
		"500000"=>array("cc"=>500,"km"=>500000,"eq"=>50000),
		"505000"=>array("cc"=>505,"km"=>505000,"eq"=>55000),
		"510000"=>array("cc"=>510,"km"=>510000,"eq"=>60000),
		"515000"=>array("cc"=>515,"km"=>515000,"eq"=>65000),
		"520000"=>array("cc"=>520,"km"=>520000,"eq"=>70000),
		"525000"=>array("cc"=>525,"km"=>525000,"eq"=>75000),
		
		"530000"=>array("cc"=>530,"km"=>530000,"eq"=>40000),
		"535000"=>array("cc"=>535,"km"=>535000,"eq"=>45000),
		"540000"=>array("cc"=>540,"km"=>540000,"eq"=>50000),
		"545000"=>array("cc"=>545,"km"=>545000,"eq"=>55000),
		"550000"=>array("cc"=>550,"km"=>550000,"eq"=>60000),
		"555000"=>array("cc"=>555,"km"=>555000,"eq"=>65000),
		"560000"=>array("cc"=>560,"km"=>560000,"eq"=>70000),
		"565000"=>array("cc"=>565,"km"=>565000,"eq"=>75000),
		
		"570000"=>array("cc"=>570,"km"=>570000,"eq"=>40000),
		"575000"=>array("cc"=>575,"km"=>575000,"eq"=>45000),
		"580000"=>array("cc"=>580,"km"=>580000,"eq"=>50000),
		"585000"=>array("cc"=>585,"km"=>585000,"eq"=>55000),
		"590000"=>array("cc"=>590,"km"=>590000,"eq"=>60000),
		"595000"=>array("cc"=>595,"km"=>595000,"eq"=>65000),
		"600000"=>array("cc"=>600,"km"=>600000,"eq"=>70000),
		"605000"=>array("cc"=>605,"km"=>605000,"eq"=>75000)
		);
		
		
		$this->PmaIsuzuKilometrajesNuevo = array(
		"1000"=> array("cc"=>1,"km"=>1000,"eq"=>1000),
		"5000"=> array("cc"=>5,"km"=>5000,"eq"=>5000),
		"10000"=>array("cc"=>10,"km"=>10000,"eq"=>10000),
		"15000"=>array("cc"=>15,"km"=>15000,"eq"=>15000),
		"20000"=>array("cc"=>20,"km"=>20000,"eq"=>20000),
		"25000"=>array("cc"=>25,"km"=>25000,"eq"=>25000),
		"30000"=>array("cc"=>30,"km"=>30000,"eq"=>30000),
		"35000"=>array("cc"=>35,"km"=>35000,"eq"=>35000),
		
		"40000"=>array("cc"=>40,"km"=>40000,"eq"=>40000),
		"45000"=>array("cc"=>45,"km"=>45000,"eq"=>45000),
		"50000"=>array("cc"=>50,"km"=>50000,"eq"=>50000),
		"55000"=>array("cc"=>55,"km"=>55000,"eq"=>55000),
		"60000"=>array("cc"=>60,"km"=>60000,"eq"=>60000),
		"65000"=>array("cc"=>65,"km"=>65000,"eq"=>65000),
		"70000"=>array("cc"=>70,"km"=>70000,"eq"=>70000),
		"75000"=>array("cc"=>75,"km"=>75000,"eq"=>75000),
		
		"80000"=>array("cc"=>80,"km"=>80000,"eq"=>40000),		
		"85000"=>array("cc"=>85,"km"=>85000,"eq"=>45000),
		"90000"=>array("cc"=>90,"km"=>90000,"eq"=>50000),
		"95000"=>array("cc"=>95,"km"=>95000,"eq"=>55000),
		"100000"=>array("cc"=>100,"km"=>100000,"eq"=>60000),
		"105000"=>array("cc"=>105,"km"=>105000,"eq"=>65000),
		"110000"=>array("cc"=>110,"km"=>110000,"eq"=>70000),
		"115000"=>array("cc"=>115,"km"=>115000,"eq"=>75000),
		
		"120000"=>array("cc"=>120,"km"=>120000,"eq"=>40000),
		"125000"=>array("cc"=>125,"km"=>125000,"eq"=>45000),
		"130000"=>array("cc"=>130,"km"=>130000,"eq"=>50000),
		"135000"=>array("cc"=>135,"km"=>135000,"eq"=>55000),
		"140000"=>array("cc"=>140,"km"=>140000,"eq"=>60000),
		"145000"=>array("cc"=>145,"km"=>145000,"eq"=>65000),
		"150000"=>array("cc"=>150,"km"=>150000,"eq"=>70000),
		"155000"=>array("cc"=>155,"km"=>155000,"eq"=>40000),
		
		"160000"=>array("cc"=>160,"km"=>160000,"eq"=>40000),
		"165000"=>array("cc"=>165,"km"=>165000,"eq"=>45000),
		"170000"=>array("cc"=>170,"km"=>170000,"eq"=>50000),
		"175000"=>array("cc"=>175,"km"=>175000,"eq"=>55000),
		"180000"=>array("cc"=>180,"km"=>180000,"eq"=>60000),
		"185000"=>array("cc"=>185,"km"=>185000,"eq"=>65000),
		"190000"=>array("cc"=>190,"km"=>190000,"eq"=>70000),
		"195000"=>array("cc"=>195,"km"=>195000,"eq"=>75000),
		"200000"=>array("cc"=>200,"km"=>200000,"eq"=>40000),	
		
		
		"205000"=>array("cc"=>205,"km"=>205000,"eq"=>40000),
		"210000"=>array("cc"=>210,"km"=>210000,"eq"=>45000),
		"215000"=>array("cc"=>215,"km"=>215000,"eq"=>50000),
		"220000"=>array("cc"=>220,"km"=>220000,"eq"=>55000),
		"225000"=>array("cc"=>225,"km"=>225000,"eq"=>60000),
		"230000"=>array("cc"=>230,"km"=>230000,"eq"=>65000),
		"235000"=>array("cc"=>235,"km"=>235000,"eq"=>70000),
		"240000"=>array("cc"=>240,"km"=>240000,"eq"=>75000),
		"245000"=>array("cc"=>245,"km"=>245000,"eq"=>40000),

		"250000"=>array("cc"=>250,"km"=>250000,"eq"=>40000),
		"255000"=>array("cc"=>255,"km"=>255000,"eq"=>45000),
		"260000"=>array("cc"=>260,"km"=>260000,"eq"=>50000),
		"265000"=>array("cc"=>265,"km"=>265000,"eq"=>55000),
		"270000"=>array("cc"=>270,"km"=>270000,"eq"=>60000),
		"275000"=>array("cc"=>275,"km"=>275000,"eq"=>65000),
		"280000"=>array("cc"=>280,"km"=>280000,"eq"=>70000),
		"285000"=>array("cc"=>285,"km"=>285000,"eq"=>75000),
		
		"290000"=>array("cc"=>290,"km"=>290000,"eq"=>40000),
		"295000"=>array("cc"=>295,"km"=>295000,"eq"=>45000),
		"300000"=>array("cc"=>300,"km"=>300000,"eq"=>50000),
		"305000"=>array("cc"=>305,"km"=>305000,"eq"=>55000),
		"310000"=>array("cc"=>310,"km"=>310000,"eq"=>60000),
		"315000"=>array("cc"=>315,"km"=>315000,"eq"=>65000),
		"320000"=>array("cc"=>320,"km"=>320000,"eq"=>70000),
		"325000"=>array("cc"=>325,"km"=>325000,"eq"=>75000),
		
		"330000"=>array("cc"=>330,"km"=>330000,"eq"=>40000),
		"335000"=>array("cc"=>335,"km"=>335000,"eq"=>45000),
		"340000"=>array("cc"=>340,"km"=>340000,"eq"=>50000),
		"345000"=>array("cc"=>345,"km"=>345000,"eq"=>55000),
		"350000"=>array("cc"=>350,"km"=>350000,"eq"=>60000),
		"355000"=>array("cc"=>355,"km"=>355000,"eq"=>65000),
		"360000"=>array("cc"=>360,"km"=>360000,"eq"=>70000),
		"365000"=>array("cc"=>365,"km"=>365000,"eq"=>75000),
		
		"370000"=>array("cc"=>370,"km"=>370000,"eq"=>40000),
		"375000"=>array("cc"=>375,"km"=>375000,"eq"=>45000),
		"380000"=>array("cc"=>380,"km"=>380000,"eq"=>50000),
		"385000"=>array("cc"=>385,"km"=>385000,"eq"=>55000),
		"390000"=>array("cc"=>390,"km"=>390000,"eq"=>60000),
		"395000"=>array("cc"=>395,"km"=>395000,"eq"=>65000),
		"400000"=>array("cc"=>400,"km"=>400000,"eq"=>70000),
		"405000"=>array("cc"=>405,"km"=>405000,"eq"=>75000),
		
		"410000"=>array("cc"=>410,"km"=>410000,"eq"=>40000),
		"415000"=>array("cc"=>415,"km"=>415000,"eq"=>45000),
		"420000"=>array("cc"=>420,"km"=>420000,"eq"=>50000),
		"425000"=>array("cc"=>425,"km"=>425000,"eq"=>55000),
		"430000"=>array("cc"=>430,"km"=>430000,"eq"=>60000),
		"435000"=>array("cc"=>435,"km"=>435000,"eq"=>65000),
		"440000"=>array("cc"=>440,"km"=>440000,"eq"=>70000),
		"445000"=>array("cc"=>445,"km"=>445000,"eq"=>75000),
		
		"450000"=>array("cc"=>450,"km"=>450000,"eq"=>40000),
		"455000"=>array("cc"=>455,"km"=>455000,"eq"=>45000),
		"460000"=>array("cc"=>460,"km"=>460000,"eq"=>50000),
		"465000"=>array("cc"=>465,"km"=>465000,"eq"=>55000),
		"470000"=>array("cc"=>470,"km"=>470000,"eq"=>60000),
		"475000"=>array("cc"=>475,"km"=>475000,"eq"=>65000),
		"480000"=>array("cc"=>480,"km"=>480000,"eq"=>70000),
		"485000"=>array("cc"=>485,"km"=>485000,"eq"=>75000),
		
		"490000"=>array("cc"=>490,"km"=>490000,"eq"=>40000),
		"495000"=>array("cc"=>495,"km"=>495000,"eq"=>45000),
		"500000"=>array("cc"=>500,"km"=>500000,"eq"=>50000),
		"505000"=>array("cc"=>505,"km"=>505000,"eq"=>55000),
		"510000"=>array("cc"=>510,"km"=>510000,"eq"=>60000),
		"515000"=>array("cc"=>515,"km"=>515000,"eq"=>65000),
		"520000"=>array("cc"=>520,"km"=>520000,"eq"=>70000),
		"525000"=>array("cc"=>525,"km"=>525000,"eq"=>75000),
		
		"530000"=>array("cc"=>530,"km"=>530000,"eq"=>40000),
		"535000"=>array("cc"=>535,"km"=>535000,"eq"=>45000),
		"540000"=>array("cc"=>540,"km"=>540000,"eq"=>50000),
		"545000"=>array("cc"=>545,"km"=>545000,"eq"=>55000),
		"550000"=>array("cc"=>550,"km"=>550000,"eq"=>60000),
		"555000"=>array("cc"=>555,"km"=>555000,"eq"=>65000),
		"560000"=>array("cc"=>560,"km"=>560000,"eq"=>70000),
		"565000"=>array("cc"=>565,"km"=>565000,"eq"=>75000),
		
		"570000"=>array("cc"=>570,"km"=>570000,"eq"=>40000),
		"575000"=>array("cc"=>575,"km"=>575000,"eq"=>45000),
		"580000"=>array("cc"=>580,"km"=>580000,"eq"=>50000),
		"585000"=>array("cc"=>585,"km"=>585000,"eq"=>55000),
		"590000"=>array("cc"=>590,"km"=>590000,"eq"=>60000),
		"595000"=>array("cc"=>595,"km"=>595000,"eq"=>65000),
		"600000"=>array("cc"=>600,"km"=>600000,"eq"=>70000),
		"605000"=>array("cc"=>605,"km"=>605000,"eq"=>75000)
		

		);
		
		
		
    }
	
	public function __destruct(){

	}

	public function MtdGenerarPlanMantenimientoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PmaId,5),unsigned)) AS "MAXIMO"
			FROM tblpmaplanmantenimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PmaId = "PMA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PmaId = "PMA-".$fila['MAXIMO'];					
			}		
			
					
		}
		
			
    public function MtdObtenerPlanMantenimiento(){

        $sql = 'SELECT 
        pma.PmaId,
        pma.PmaNombre,
		pma.PmaDuracion,

		vmo.VmaId,
		pma.VmoId,
		pma.VveId,

		DATE_FORMAT(pma.PmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoCreacion",
        DATE_FORMAT(pma.PmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoModificacion"	,
		vve.VveNombre,
		vmo.VmoNombre,
		vmo.VmoNombreComercial,
		
		vma.VmaNombre
		
        FROM tblpmaplanmantenimiento pma
			LEFT JOIN tblvvevehiculoversion vve
			ON pma.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
		WHERE pma.PmaId = "'.$this->PmaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PmaId = $fila['PmaId'];
            $this->PmaNombre = $fila['PmaNombre'];
			$this->PmaDuracion = $fila['PmaDuracion'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmoId = $fila['VmoId'];
			$this->VveId = $fila['VveId'];
			
			$this->PmaTiempoCreacion = $fila['NPmaTiempoCreacion'];
			$this->PmaTiempoModificacion = $fila['NPmaTiempoModificacion']; 
			
			$this->VveNombre = $fila['VveNombre']; 
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VmoNombreComercial = $fila['VmoNombreComercial']; 
			$this->VmaNombre = $fila['VmaNombre']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPlanMantenimientos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL) {

if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
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
	
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND pma.VveId = "'.$oVehiculoVersion.'"';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'"';
		}

	
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}


		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		pma.PmaId,
        pma.PmaNombre,
		pma.PmaDuracion,
		
		vmo.VmaId,
		pma.VmoId,
		pma.VveId,
		
		DATE_FORMAT(pma.PmaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoCreacion",
        DATE_FORMAT(pma.PmaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPmaTiempoModificacion"	,
		vve.VveNombre,
		vmo.VmoNombre,
		vma.VmaNombre,
		
		



				CASE
				WHEN EXISTS (
					
					SELECT 
					pmd.PmdId
					FROM tblpmdplanmantenimientodetalle pmd
					WHERE pmd.PmaId = pma.PmaId 
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS PmaPlanMantenimientoDetalle,
				
				
					CASE
				WHEN EXISTS (
					
					SELECT 
					tpr.TprId
					FROM tbltprtareaproducto tpr
					WHERE tpr.PmaId = pma.PmaId 
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS PmaTareaProducto
							
				
				
		
        FROM tblpmaplanmantenimiento pma
			LEFT JOIN tblvvevehiculoversion vve
			ON pma.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
				WHERE 1  = 1 '.$filtrar.$vversion.$vmarca.$vmodelo.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPlanMantenimiento = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$PlanMantenimiento = new $InsPlanMantenimiento();
                    $PlanMantenimiento->PmaId = $fila['PmaId'];
                    $PlanMantenimiento->PmaNombre= $fila['PmaNombre'];
					$PlanMantenimiento->PmaDuracion= $fila['PmaDuracion'];
					
					$PlanMantenimiento->VmaId = $fila['VmaId'];
					$PlanMantenimiento->VmoId = $fila['VmoId'];
					$PlanMantenimiento->VveId= $fila['VveId'];
					
                    $PlanMantenimiento->PmaTiempoCreacion = $fila['NPmaTiempoCreacion'];
                    $PlanMantenimiento->PmaTiempoModificacion = $fila['NPmaTiempoModificacion'];    

			$PlanMantenimiento->VveNombre = $fila['VveNombre']; 
			$PlanMantenimiento->VmoNombre = $fila['VmoNombre']; 
			$PlanMantenimiento->VmaNombre = $fila['VmaNombre']; 
			
			
			$PlanMantenimiento->PmaPlanMantenimientoDetalle = $fila['PmaPlanMantenimientoDetalle']; 
			$PlanMantenimiento->PmaTareaProducto = $fila['PmaTareaProducto']; 
			
			
			
			
					$PlanMantenimiento->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$PlanMantenimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	//public function MtdEliminarPlanMantenimiento($oElementos) {
//		
//		$elementos = explode("#",$oElementos);
//		
//
//			$i=1;
//			foreach($elementos as $elemento){
//				if(!empty($elemento)){
//				
//					if($i==count($elementos)){						
//						$eliminar .= '  (PmaId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (PmaId = "'.($elemento).'")  OR';	
//					}	
//				}
//			$i++;
//	
//			}
//	
//			$sql = 'DELETE FROM tblpmaplanmantenimiento WHERE '.$eliminar;
//		
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
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
	
	
	//public function MtdRegistrarPlanMantenimiento() {
//	
//			$this->MtdGenerarPlanMantenimientoId();
//			
//			$sql = 'INSERT INTO tblpmaplanmantenimiento (
//			PmaId,
//			PmaNombre, 
//			PmaDuracion,
//			VmoId,
//			VveId,
//			PmaTiempoCreacion,
//			PmaTiempoModificacion) 
//			VALUES (
//			"'.($this->PmaId).'", 
//			"'.htmlentities($this->PmaNombre).'", 
//			"'.($this->PmaDuracion).'", 
//			"'.($this->VmoId).'", 
//			"'.($this->VveId).'", 			
//			"'.($this->PmaTiempoCreacion).'", 
//			"'.($this->PmaTiempoModificacion).');';					
//
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
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
//	}
//	
//	public function MtdEditarPlanMantenimiento() {
//		
//		$sql = 'UPDATE tblpmaplanmantenimiento SET 
//		PmaNombre = "'.($this->PmaNombre).'",
//		PmaDuracion = "'.($this->PmaDuracion).'",
//		VmoId = "'.($this->VmoId).'",
//		VveId = "'.($this->VveId).'",
//		PmaTiempoModificacion = "'.($this->PmaTiempoModificacion).'"
//		WHERE PmaId = "'.($this->PmaId).'";';
//		
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
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
//	}	
		
		
		
		
	
}
?>