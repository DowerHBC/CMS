<?
############################################################################################################################################
# DEFINIMOS O ROOT DO SISTEMA
############################################################################################################################################
	if(!defined("ROOT_WEBSHEEP"))	{
		$path = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'ws-branches'));
		$path = implode(array_filter(explode('/',$path)),"/");
		define('ROOT_WEBSHEEP',(($path=="") ? "/" : '/'.$path.'/'));
	}

	if(!defined("INCLUDE_PATH")){define("INCLUDE_PATH",str_replace("\\","/",substr(realpath(__DIR__),0,strrpos(realpath(__DIR__),'admin'))));}

#############################################################################
#	IMPORTAMOS A CLASSE PADRÃO DO SISTEMA
#############################################################################
	ob_start();
	include_once(INCLUDE_PATH.'admin/app/lib/class-ws-v1.php');
	ob_end_clean();
	$branches = ws::get_github_branches();
	if($branches==false){
		header("HTTP/1.0 501 Internal Server Error");
		die();	
	}else{
		#############################################################################
		#	SETAMOS O HEADER PARA JSON
		#############################################################################
		header("Content-type:application/json");
	}
#############################################################################
#	TRATAMOS O JSON DAS BRANCHES E RETORNAMOS
#############################################################################
	$json = json_decode();
	echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);