<?php

class Vins_Faltantes extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	function index()
	{
		echo "hola";
	}
	
	
	/*
		pasa a vencida las unidades con mas de 3 años
		(este dato sale de la tarjeta de garantia)
	*/
	
    public function vins()
    {   
		
		$abuscar = array(
		'3HGRM4830CG600872',
		'3HGRM4830CG600868',
		'3HGRM4830CG600860',
		'3HGRM4830CG600867',
		'3HGRM4830CG600875',
		'3HGRM4830CG600874',
		'3HGRM4830CG600878',
		'3HGRM4830CG600877',
		'3HGRM4830CG600870',
		'3HGRM4830CG600869',
		'3HGRM4830CG600863',
		'3HGRM4830CG600862',
		'3HGRM4830CG600864',
		'3HGRM4830CG600876',
		'3HGRM4830CG600871',
		'3HGRM4830CG600866',
		'3HGRM4830CG600861',
		'3HGRM4830CG600873',
		'3HGRM4830CG600865',
		'3HGRM4830CG600887',
		'3HGRM4830CG600885',
		'3HGRM4830CG600880',
		'3HGRM4830CG600884',
		'3HGRM4830CG600883',
		'3HGRM4830CG600886',
		'3HGRM4830CG600888',
		'3HGRM4830CG600879',
		'3HGRM4830CG600881',
		'3HGRM4830CG600882',
		'3HGRM4830CG600904',
		'3HGRM4830CG600902',
		'3HGRM4830CG600895',
		'3HGRM4830CG600908',
		'3HGRM4830CG600897',
		'3HGRM4830CG600903',
		'3HGRM4830CG600906',
		'3HGRM4830CG600901',
		'3HGRM4830CG600907',
		'3HGRM4830CG600894',
		'3HGRM4830CG600898',
		'3HGRM4830CG600893',
		'3HGRM4830CG600905',
		'3HGRM4830CG600891',
		'3HGRM4830CG600890',
		'3HGRM4830CG600892',
		'3HGRM4830CG600900',
		'3HGRM4830CG600899',
		'3HGRM4830CG600896',
		'3HGRM4830CG600889',
		'3HGRM4830CG600909',
		'3HGRM4830CG600910',
		'3HGRM4830CG600916',
		'3HGRM4830CG600913',
		'3HGRM4830CG600912',
		'3HGRM4830CG600914',
		'3HGRM4830CG600917',
		'3HGRM4830CG600911',
		'3HGRM4830CG600915',
		'3HGRM4830CG600920',
		'3HGRM4830CG600919',
		'3HGRM4830CG600918',
		'3HGRM4830CG600925',
		'3HGRM4830CG600927',
		'3HGRM4830CG600923',
		'3HGRM4830CG600928',
		'3HGRM4830CG600921',
		'3HGRM4830CG600922',
		'3HGRM4830CG600924',
		'3HGRM4830CG600926',
		'3HGRM4830CG600931',
		'3HGRM4830CG600932',
		'3HGRM4830CG600929',
		'3HGRM4830CG600930',
		'3HGRM4830CG600940',
		'3HGRM4830CG600945',
		'3HGRM4830CG600936',
		'3HGRM4830CG600941',
		'3HGRM4830CG600944',
		'3HGRM4830CG600939',
		'3HGRM4830CG600938',
		'3HGRM4830CG600942',
		'3HGRM4830CG600948',
		'3HGRM4830CG600947',
		'3HGRM4830CG600935',
		'3HGRM4830CG600933',
		'3HGRM4830CG600943',
		'3HGRM4830CG600946',
		'3HGRM4830CG600934',
		'3HGRM4830CG600937',
		'3HGRM3830CG602522',
		'3HGRM3830CG602523',
		'3HGRM3830CG602518',
		'3HGRM3830CG602527',
		'3HGRM3830CG602517',
		'3HGRM3830CG602526',
		'3HGRM3830CG602515',
		'3HGRM3830CG602524',
		'3HGRM3830CG602519',
		'3HGRM3830CG602521',
		'3HGRM3830CG602516',
		'3HGRM3830CG602528',
		'3HGRM3830CG602520',
		'3HGRM3830CG602525',
		'3HGRM4850CG600620',
		'3HGRM4850CG600623',
		'3HGRM4850CG600617',
		'3HGRM4850CG600624',
		'3HGRM4850CG600627',
		'3HGRM4850CG600630',
		'3HGRM4850CG600625',
		'3HGRM4850CG600631',
		'3HGRM4850CG600628',
		'3HGRM4850CG600619',
		'3HGRM4850CG600635',
		'3HGRM4850CG600632',
		'3HGRM4850CG600637',
		'3HGRM4850CG600646',
		'3HGRM4850CG600645',
		'3HGRM4850CG600647',
		'3HGRM4850CG600622',
		'3HGRM4850CG600616',
		'3HGRM4850CG600629',
		'3HGRM4850CG600643',
		'3HGRM4850CG600639',
		'3HGRM4850CG600638',
		'3HGRM4850CG600618',
		'3HGRM4850CG600626',
		'3HGRM4850CG600634',
		'3HGRM4850CG600621',
		'3HGRM4850CG600633',
		'3HGRM4850CG600636',
		'3HGRM4850CG600644',
		'3HGRM4850CG600640',
		'3HGRM4850CG600642',
		'3HGRM4850CG600641',
		'3HGRM4850CG600664',
		'3HGRM4850CG600658',
		'3HGRM4850CG600671',
		'3HGRM4850CG600659',
		'3HGRM4850CG600661',
		'3HGRM4850CG600654',
		'3HGRM4850CG600662',
		'3HGRM4850CG600672',
		'3HGRM4850CG600648',
		'3HGRM4850CG600670',
		'3HGRM4850CG600653',
		'3HGRM4850CG600673',
		'3HGRM4850CG600656',
		'3HGRM4850CG600660',
		'3HGRM4850CG600651',
		'3HGRM4850CG600657',
		'3HGRM4850CG600665',
		'3HGRM4850CG600652',
		'3HGRM4850CG600669',
		'3HGRM4850CG600666',
		'3HGRM4850CG600668',
		'3HGRM4850CG600650',
		'3HGRM4850CG600649',
		'3HGRM4850CG600667',
		'3HGRM4850CG600663',
		'3HGRM4850CG600655',
		'3HGRM4850CG600683',
		'3HGRM4850CG600682',
		'3HGRM4850CG600675',
		'3HGRM4850CG600687',
		'3HGRM4850CG600690',
		'3HGRM4850CG600674',
		'3HGRM4850CG600680',
		'3HGRM4850CG600676',
		'3HGRM4850CG600681',
		'3HGRM4850CG600689',
		'3HGRM4850CG600684',
		'3HGRM4850CG600686',
		'3HGRM4850CG600679',
		'3HGRM4850CG600677',
		'3HGRM4850CG600685',
		'3HGRM4850CG600688',
		'3HGRM4850CG600678',
		'3HGRM4850CG600696',
		'3HGRM4850CG600695',
		'3HGRM4850CG600694',
		'3HGRM4850CG600691',
		'3HGRM4850CG600697',
		'3HGRM4850CG600693',
		'3HGRM4850CG600692',
		'3HGRM4850CG600698',
		'3HGRM4850CG600707',
		'3HGRM4850CG600715',
		'3HGRM4850CG600704',
		'3HGRM4850CG600703',
		'3HGRM4850CG600714',
		'3HGRM4850CG600713',
		'3HGRM4850CG600709',
		'3HGRM4850CG600711',
		'3HGRM4850CG600705',
		'3HGRM4850CG600701',
		'3HGRM4850CG600710',
		'3HGRM4850CG600716',
		'3HGRM4850CG600712',
		'3HGRM4850CG600700',
		'3HGRM4850CG600702',
		'3HGRM4850CG600706',
		'3HGRM4850CG600708',
		'3HGRM4850CG600699',
		'3HGRM4850CG600717',
		'3HGRM4850CG600730',
		'3HGRM4850CG600724',
		'3HGRM4850CG600728',
		'3HGRM4850CG600719',
		'3HGRM4850CG600723',
		'3HGRM4850CG600727',
		'3HGRM4850CG600722',
		'3HGRM4850CG600721',
		'3HGRM4850CG600731',
		'3HGRM4850CG600733',
		'3HGRM4850CG600729',
		'3HGRM4850CG600732',
		'3HGRM4850CG600718',
		'3HGRM4850CG600720',
		'3HGRM4850CG600726',
		'3HGRM4850CG600725',
		'3HGRM4850CG600736',
		'3HGRM4850CG600755',
		'3HGRM4850CG600742',
		'3HGRM4850CG600739',
		'3HGRM4850CG600757',
		'3HGRM4850CG600752',
		'3HGRM4850CG600745',
		'3HGRM4850CG600756',
		'3HGRM4850CG600744',
		'3HGRM4850CG600749',
		'3HGRM4850CG600738',
		'3HGRM4850CG600748',
		'3HGRM4850CG600750',
		'3HGRM4850CG600751',
		'3HGRM4850CG600754',
		'3HGRM4850CG600743',
		'3HGRM4850CG600746',
		'3HGRM4850CG600747',
		'3HGRM4850CG600741',
		'3HGRM4850CG600734',
		'3HGRM4850CG600753',
		'3HGRM4850CG600737',
		'3HGRM4850CG600735',
		'3HGRM4850CG600740',
		'3HGRM3830CG603131',
		'3HGRM3830CG603118',
		'3HGRM3830CG603127',
		'3HGRM3830CG603124',
		'3HGRM3830CG603116',
		'3HGRM3830CG603150',
		'3HGRM3830CG603144',
		'3HGRM3830CG603122',
		'3HGRM3830CG603113',
		'3HGRM3830CG603115',
		'3HGRM3830CG603129',
		'3HGRM3830CG603132',
		'3HGRM3830CG603142',
		'3HGRM3830CG603149',
		'3HGRM3830CG603146',
		'3HGRM3830CG603133',
		'3HGRM3830CG603117',
		'3HGRM3830CG603130',
		'3HGRM3830CG603114',
		'3HGRM3830CG603106',
		'3HGRM3830CG603119',
		'3HGRM3830CG603109',
		'3HGRM3830CG603141',
		'3HGRM3830CG603151',
		'3HGRM3830CG603148',
		'3HGRM3830CG603135',
		'3HGRM3830CG603105',
		'3HGRM3830CG603138',
		'3HGRM3830CG603110',
		'3HGRM3830CG603121',
		'3HGRM3830CG603134',
		'3HGRM3830CG603152',
		'3HGRM3830CG603108',
		'3HGRM3830CG603143',
		'3HGRM3830CG603145',
		'3HGRM3830CG603140',
		'3HGRM3830CG603125',
		'3HGRM3830CG603139',
		'3HGRM3830CG603147',
		'3HGRM3830CG603107',
		'3HGRM3830CG603136',
		'3HGRM3830CG603111',
		'3HGRM3830CG603137',
		'3HGRM3830CG603104',
		'3HGRM3830CG603128',
		'3HGRM3830CG603126',
		'3HGRM3830CG603120',
		'3HGRM3830CG603112',
		'3HGRM3830CG603123',
		'3HGRM3830CG603160',
		'3HGRM3830CG603161',
		'3HGRM3830CG603164',
		'3HGRM3830CG603163',
		'3HGRM3830CG603158',
		'3HGRM3830CG603155',
		'3HGRM3830CG603157',
		'3HGRM3830CG603154',
		'3HGRM3830CG603159',
		'3HGRM3830CG603153',
		'3HGRM3830CG603156',
		'3HGRM3830CG603162',
		'3HGRM3830CG603177',
		'3HGRM3830CG603193',
		'3HGRM3830CG603187',
		'3HGRM3830CG603171',
		'3HGRM3830CG603169',
		'3HGRM3830CG603178',
		'3HGRM3830CG603194',
		'3HGRM3830CG603189',
		'3HGRM3830CG603176',
		'3HGRM3830CG603185',
		'3HGRM3830CG603183',
		'3HGRM3830CG603186',
		'3HGRM3830CG603181',
		'3HGRM3830CG603170',
		'3HGRM3830CG603166',
		'3HGRM3830CG603173',
		'3HGRM3830CG603172',
		'3HGRM3830CG603179',
		'3HGRM3830CG603167',
		'3HGRM3830CG603168',
		'3HGRM3830CG603190',
		'3HGRM3830CG603188',
		'3HGRM3830CG603191',
		'3HGRM3830CG603175',
		'3HGRM3830CG603184',
		'3HGRM3830CG603180',
		'3HGRM3830CG603165',
		'3HGRM3830CG603192',
		'3HGRM3830CG603182',
		'3HGRM3830CG603174',
		'3HGRM3830CG603196',
		'3HGRM3830CG603202',
		'3HGRM3830CG603199',
		'3HGRM3830CG603203',
		'3HGRM3830CG603195',
		'3HGRM3830CG603198',
		'3HGRM3830CG603200',
		'3HGRM3830CG603201',
		'3HGRM3830CG603197',
		'3HGRM3830CG603212',
		'3HGRM3830CG603210',
		'3HGRM3830CG603207',
		'3HGRM3830CG603211',
		'3HGRM3830CG603205',
		'3HGRM3830CG603204',
		'3HGRM3830CG603206',
		'3HGRM3830CG603209',
		'3HGRM3830CG603208',
		'3HGRM3830CG603225',
		'3HGRM3830CG603216',
		'3HGRM3830CG603214',
		'3HGRM3830CG603217',
		'3HGRM3830CG603218',
		'3HGRM3830CG603215',
		'3HGRM3830CG603221',
		'3HGRM3830CG603226',
		'3HGRM3830CG603213',
		'3HGRM3830CG603224',
		'3HGRM3830CG603220',
		'3HGRM3830CG603222',
		'3HGRM3830CG603223',
		'3HGRM3830CG603219',
		'3HGRM3830CG603269',
		'3HGRM3830CG603270',
		'3HGRM3830CG603248',
		'3HGRM3830CG603243',
		'3HGRM3830CG603255',
		'3HGRM3830CG603234',
		'3HGRM3830CG603236',
		'3HGRM3830CG603266',
		'3HGRM3830CG603253',
		'3HGRM3830CG603271',
		'3HGRM3830CG603272',
		'3HGRM3830CG603238',
		'3HGRM3830CG603244',
		'3HGRM3830CG603267',
		'3HGRM3830CG603260',
		'3HGRM3830CG603258',
		'3HGRM3830CG603230',
		'3HGRM3830CG603245',
		'3HGRM3830CG603251',
		'3HGRM3830CG603232',
		'3HGRM3830CG603240',
		'3HGRM3830CG603249',
		'3HGRM3830CG603247',
		'3HGRM3830CG603263',
		'3HGRM3830CG603237',
		'3HGRM3830CG603246',
		'3HGRM3830CG603268',
		'3HGRM3830CG603261',
		'3HGRM3830CG603254',
		'3HGRM3830CG603239',
		'3HGRM3830CG603233',
		'3HGRM3830CG603241',
		'3HGRM3830CG603242',
		'3HGRM3830CG603250',
		'3HGRM3830CG603259',
		'3HGRM3830CG603257',
		'3HGRM3830CG603262',
		'3HGRM3830CG603264',
		'3HGRM3830CG603231',
		'3HGRM3830CG603235',
		'3HGRM3830CG603256',
		'3HGRM3830CG603265',
		'3HGRM3830CG603228',
		'3HGRM3830CG603229',
		'3HGRM3830CG603227',
		'3HGRM3830CG603252',
		'3HGRM3830CG603920',
		'3HGRM3830CG603927',
		'3HGRM3830CG603949',
		'3HGRM3830CG603947',
		'3HGRM3830CG603948',
		'3HGRM3830CG603921',
		'3HGRM3830CG603941',
		'3HGRM3830CG603931',
		'3HGRM3830CG603901',
		'3HGRM3830CG603914',
		'3HGRM3830CG603945',
		'3HGRM3830CG603897',
		'3HGRM3830CG603898',
		'3HGRM3830CG603946',
		'3HGRM3830CG603917',
		'3HGRM3830CG603894',
		'3HGRM3830CG603895',
		'3HGRM3830CG603932',
		'3HGRM3830CG603950',
		'3HGRM3830CG603944',
		'3HGRM3830CG603918',
		'3HGRM3830CG603911',
		'3HGRM3830CG603903',
		'3HGRM3830CG603925',
		'3HGRM3830CG603935',
		'3HGRM3830CG603909',
		'3HGRM3830CG603891',
		'3HGRM3830CG603939',
		'3HGRM3830CG603902',
		'3HGRM3830CG603937',
		'3HGRM3830CG603905',
		'3HGRM3830CG603943',
		'3HGRM3830CG603892',
		'3HGRM3830CG603934',
		'3HGRM3830CG603896',
		'3HGRM3830CG603916',
		'3HGRM3830CG603907',
		'3HGRM3830CG603923',
		'3HGRM3830CG603906',
		'3HGRM3830CG603928',
		'3HGRM3830CG603899',
		'3HGRM3830CG603922',
		'3HGRM3830CG603904',
		'3HGRM3830CG603919',
		'3HGRM3830CG603940',
		'3HGRM3830CG603900',
		'3HGRM3830CG603908',
		'3HGRM3830CG603926',
		'3HGRM3830CG603915',
		'3HGRM3830CG603893',
		'3HGRM3830CG603924',
		'3HGRM3830CG603912',
		'3HGRM3830CG603936',
		'3HGRM3830CG603913',
		'3HGRM3830CG603938',
		'3HGRM3830CG603929',
		'3HGRM3830CG603942',
		'3HGRM3830CG603930');
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
		$ar=file_get_contents( dirname(__FILE__) . "/EQ4W20130415200005.txt","r");
		
		
		
		foreach($abuscar as $vin)
		{
			$sql="SELECT id from unidad where unidad_field_vin='".$vin."'" ;
			$r = $statement->execute($sql);
			$cantidad = count($r->fetchAll());
			
			if($cantidad == 0)
			{
				echo "vin: " . $vin ." NO encontrado - ";
				if(stristr($vin, $ar) === FALSE)
				{
					echo " NO encontrado en intefaz <br />";
				}
				else
				{
					echo " SI encontrado en intefaz <br />";
				}
			}
			else if($cantidad == 1)
			{
				echo "vin: " . $vin . " SI encontrado <br />";
			}
			else
			{
				echo "vin: " . $vin . " DISTINTA cantidad : ".$cantidad ."<br />";
			}
			
			
			  
		}
		
		  
		  
		
		
	}
	
	
}
?>    