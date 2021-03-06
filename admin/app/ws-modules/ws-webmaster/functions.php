<?

ob_start();
############################################################################################################################################
# DEFINIMOS O ROOT DO SISTEMA
############################################################################################################################################
	if(!defined("ROOT_WEBSHEEP"))	{
		$path = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'admin'));
		$path = implode(array_filter(explode('/',$path)),"/");
		define('ROOT_WEBSHEEP',(($path=="") ? "/" : '/'.$path.'/'));
	}

	if(!defined("INCLUDE_PATH")){define("INCLUDE_PATH",str_replace("\\","/",substr(realpath(__DIR__),0,strrpos(realpath(__DIR__),'admin'))));}

	include_once(INCLUDE_PATH.'admin/app/lib/class-ws-v1.php');
	$session = new session();
	ob_end_clean();

	$_SETUPDATA 	= new MySQL();
	$_SETUPDATA->set_table(PREFIX_TABLES.'setupdata');
	$_SETUPDATA->set_order('id','DESC');
	$_SETUPDATA->set_limit(1);
	$_SETUPDATA->debug(0);
	$_SETUPDATA->select();
	$_SETUPDATA 	= $_SETUPDATA->fetch_array[0];


function InsertPagination(){
	global $session;
	echo '
	<style>
	@media screen and (max-width: 1030px) {
		.comboShortCode label div{    
			width: calc(50% - 20px)!important;
			padding: 10px 0!important;
			margin: 10px 10px!important;
		}
		#shortcodes{
			position: relative;
			margin: 20px 0;
			width: 100%!important;
		}
	}
	@media screen and (min-width: 1031px) {
		.comboShortCode label div{    
			width: calc(33% - 20px)!important;
			padding: 10px 0!important;
			margin: 10px 10px!important;
		}
		#shortcodes{
			position: relative;
			margin: 20px 0;
			width: 100%!important;
		}
	}
	</style>
	<div class="comboShortCode" style="overflow: auto;height: 100%;">
		<form id="formTags" style="width: calc(100% - 10px);left: 0px;position: relative;">
			<div style="font-size: 30px;font-weight: bold;padding-bottom: 12px;">Adicionar paginação</div>
			<div class="descricao">Selecione o que você quer, e uma ferramenta:</div>
			<div class="c"></div>
			<div style="padding: 20px;margin-bottom: -24px;">
				<div style="position: relative;font-size: 20px;margin-top: 20px;font-weight: 700;float: left;text-align: center;width: 100%;" class="w1">Selecione uma ferramenta</div>
				<select id="shortcodes" name="id_toll" style="width:560px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;"><option value="">Selecione uma popção</option>';
						$ws_ferramentas 				= new MySQL();
						$ws_ferramentas->set_table(PREFIX_TABLES.'ws_ferramentas');
						$ws_ferramentas->set_where('App_Type="1"');
						$ws_ferramentas->select();
						foreach ($ws_ferramentas->fetch_array as $toll) {
							echo '<option value="'.$toll['id'].'">'.$toll['_tit_menu_'].'</option>';
						}

				echo '</select>
			</div>
		<div style="padding: 0 20px;margin-bottom: -24px;width: calc(100% - 40px);">
			<div style="position: relative;font-size: 20px;font-weight: 700;" class="w1">O que você quer paginar?</div>
			<div class="c"></div>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 70px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Item: 
					<input name="type" value="item" type="radio"/>
				</div>
			</label>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 50px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Galerias: 
					<input name="type" value="gal" type="radio"/>
				</div>
			</label>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 30px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Img. de galerias: 
					<input name="type" value="img_gal" type="radio"/>
				</div>
			</label>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 57px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Imagens: 
					<input name="type" value="img" type="radio"/>
				</div>
			</label>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 41px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Categorias: 
					<input name="type" value="cat" type="radio"/>
				</div>
			</label>
			<label>
				<div style="margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 52px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Arquivos: 
					<input name="type" value="file" type="radio"/>
				</div>
			</label>
		</div>
			<div class="c"></div>
			<div style="position: relative;font-size: 20px;margin-top: 20px;font-weight: 700;" class="w1">Corpo HTML</div>
			<div id="editorHTML" style="text-align:left;margin-top: 20px;font-size: 15px;text-shadow: none;height: 280px;"></div>
			<textarea name="editorHTML" id="textarea_html" style="display:none">'.rawurlencode("<div class='combo' >
	<div class='primeira'>
		<a href='/?page={{first}}'>Primeira</a>
	</div>
	<div class='anterior'>
		<a href='/?page={{prev}}'>Anterior</a>
	</div>
	{{pages}}
	<div class='primeira'>
		<a href='/?page={{next}}'>Próxima</a>
	</div>
	<div class='anterior'>
		<a href='/?page={{last}}'>Último</a>
	</div>
	</div>").'</textarea>


		<div style="position: relative;font-size: 20px;margin-top: 20px;font-weight: 700;" class="w1">Contador</div>
		<div id="editorCOUNT" style="text-align:left;margin-top: 20px;font-size: 15px;text-shadow: none;height: 180px;"> </div>
		<textarea name="editorCOUNT" style="display:none">'.rawurlencode("<li>
		<a href='/blog/{{i}}'>
			{{i}}
		</a>
	</li>").'</textarea>


		<div style="position: relative;font-size: 20px;margin-top: 20px;font-weight: 700;" class="w1">Contador Ativo (pag. atual)</div>
		<div id="editorCOUNTactive" style="text-align:left;margin-top: 20px;font-size: 15px;text-shadow: none;height: 180px;"></div>
		<textarea name="editorCOUNTactive" style="display:none">'.rawurlencode("<li>
		<div class='active'>
			{{i}}
		</div>
	</li>").'</textarea>
			</form>
		</div>';
	exit;
}

function InsertPaginationCampos(){
	global $session;
	parse_str($_POST['form'],$_FORM);
	$ws_ferramentas 				= new MySQL();
	$ws_ferramentas->set_table(PREFIX_TABLES.'ws_ferramentas');
	$ws_ferramentas->set_where('id="'.$_FORM['id_toll'].'"');
	$ws_ferramentas->select();
	$isso = array('"',"	",PHP_EOL,"\r","\n");
	$porisso = array("'","","","","");
	$output  =  '	<!--'."\n\n";
	$output .=  '		-------------------------------LEGENDA:--------------------------------------'."\n\n";
	$output .=  '		data-max: Quantos ítens listará por página	'."\n";
	$output .=  '		data-atual: Qual é a página atual, pode-se usar url:1,url:2,url:3 etc para setar uma variavel do topo ou utilizar a classe ws::urlPath(0)'."\n";
	$output .=  '		data-html: Código html da paginação'."\n";
	$output .=  '		data-number: <li> onde ficará o n° de cada pág'."\n";
	$output .=  '		data-active: Página atual'."\n\n";
	$output .=  '		------------------- OUTRAS TAGS DISPONÍIVEIS PARA SELECT:----------------------------'."\n\n";
	$output .=  '		data-distinct=""	'."\n";
	$output .=  '		data-category=""	'."\n";
	$output .=  '		data-galery=""	'."\n";
	$output .=  '		data-item="" 	'."\n";
	$output .=  '		data-where=""	'."\n";
	$output .=  '		data-innerItem="" '."\n\n";
	$output .= '	-->'."\n";
	$output .=   '<ws-paginate data-slug="'.$ws_ferramentas->fetch_array[0]['slug'].'" data-type="'.$_FORM['type'].'" data-max="5" data-atual="url:2" ';
	$output .=   'data-html="'.(str_replace($isso,$porisso,$_FORM['editorHTML'])).'" '; 
	$output .=   'data-number="'.(str_replace($isso,$porisso,$_FORM['editorCOUNT'])).'" ';
	$output .=   'data-active="'.(str_replace($isso,$porisso,$_FORM['editorCOUNTactive'])).'">';
	$output .=   '</ws-paginate>'."\n";
	echo ($output);
	exit;
}
function InsertCodeForm(){
	global $session;

	echo '<div class="comboShortCode">
		<form id="formTags" style="height: 200px;">
			<div style="font-size: 20px;font-weight: bold;padding-bottom: 12px;">Adicionar um formulário de cadastro</div>
			<div class="descricao">Selecione qual cadastro será esse formulário:</div>
			<div class="c"></div>
			<div style="padding: 20px;margin-top: 7px;">
				<select id="shortcodes" name="id_toll" style="width:450px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;"><option value="">Selecione uma popção</option>';
					$fullPages 				= new MySQL();
					$fullPages->set_table(PREFIX_TABLES.'ws_list_leads');
					$fullPages->select();
					foreach ($fullPages->fetch_array as $value) {echo '<option value="'.$value['token'].'">'.$value['title'].'</option>'; }
				echo '</select>
				</div>
			<div class="descricao" style="margin-bottom: -20px;">Como você prefere a forma de envio?</div>
			<label>
				<div style="width: 200px;margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 41px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					HTML Normal: <input name="typeCode" value="html" type="radio"/>
				</div>
			</label>
			<label>
				<div style="width: 170px;margin: 10px;cursor:pointer;position: relative;float: left;padding: 10px 52px;background: rgba(255, 255, 255, 0.58);top: 16px;left: 0px;">
					Jquery AJAX: <input name="typeCode" value="ajax" type="radio"/>
				</div>
			</label>


			</form>
		</div>';
	exit;
}
function InsertCodeFormCampos(){
	global $session;
	parse_str($_POST['form'],$_FORM);



	if($_FORM['typeCode']=='html'){
			echo '<form action="'.ws::rootPath.'ws-leads/'.strtolower($_FORM['id_toll']).'" method="post">'.PHP_EOL;
					$local = new MySQL();
					$local->set_table(PREFIX_TABLES.'wslead_'.strtolower($_FORM['id_toll']));
					$local->show_columns();
			echo '		<input type="hidden" name="typeSend" value="html">'.PHP_EOL;
					foreach($local->fetch_array as $coluna){
						if($coluna['Field']!="id"){
							echo '		<input type="text" name="'.$coluna['Field'].'" value="">'.PHP_EOL;
						}
					};
			echo '		<input type="submit" value="Submit">'.PHP_EOL;
			echo '</form>';
			exit;    	
	}elseif($_FORM['typeCode']=='ajax'){
			echo '<form id="ws_send">'.PHP_EOL;
					$local = new MySQL();
					$local->set_table(PREFIX_TABLES.'wslead_'.strtolower($_FORM['id_toll']));
					$local->show_columns();
					echo '		<input type="hidden" name="typeSend" value="ajax">'.PHP_EOL;
					foreach($local->fetch_array as $coluna){
						if($coluna['Field']!="id"){
							echo '		<input type="text" name="'.$coluna['Field'].'" value="">'.PHP_EOL;
						}
					};
			echo '		<input type="submit" value="Submit">'.PHP_EOL;
			echo '</form>'.PHP_EOL;
			echo '<div id="ws_response"></div>'.PHP_EOL.PHP_EOL;
			echo '<script>'.PHP_EOL;
				echo '	$("#ws_send").submit(function(e){
					e.preventDefault();
					$.ajax({
						type: "POST",
						url:"'.ws::rootPath.'ws-leads/'.strtolower($_FORM['id_toll']).'",
						data: {form:$("#ws_send").serialize()},
						async: true,
						beforeSend: function(data) {	console.log("beforeSend");	},
						ajaxSend: function(data) {		console.log("ajaxSend");	},
						success: function(data) {		console.log("success");		},
						error: function(data) {			console.log("error");		},
						complete: function(data) {		console.log("complete");	}
					}).done(function(data) {	
						console.log(data);
						$("#ws_response").prepend(data);	
					});
					return false;
				})
			</script>';

			exit;    	
	}
}
function InsertCode(){
	global $session;
	echo '<div class="comboShortCode">
		<form id="formTags">
			<div style="font-size: 20px;font-weight: bold;padding-bottom: 12px;">Adicionar ferramenta</div>

			<div class="descricao">Selecione a ferramenta:</div>
			<div style="padding: 10px 20px;">
				<select id="shortcodes" name="id_toll" style="width:450px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;">';
					$ws_ferramentas 				= new MySQL();
					$ws_ferramentas->set_table(PREFIX_TABLES.'ws_ferramentas');
					$ws_ferramentas->set_where('App_Type="1"');
					$ws_ferramentas->select();
					foreach ($ws_ferramentas->fetch_array as $toll) {
						echo '<option value="'.$toll['id'].'">'.$toll['_tit_menu_'].'</option>'; 
					}
					$fullPages 				= new MySQL();
					$fullPages->set_table(PREFIX_TABLES.'ws_ferramentas');
					$fullPages->set_where('_plugin_="1"');
					$fullPages->set_order('posicao','ASC');
					$fullPages->select();
					foreach ($fullPages->fetch_array as $value) {
						echo '<option value="'.$value['id'].'">Plugins -> '.$value['_tit_menu_'].'</option>'; 
					}
			echo '</select>
			</div>
			<div class="c"></div>
			<div class="descricao">O que você quer puxar?</div>
			<div class="c"></div>
			<div style="padding: 10px 20px;">
				<select name="type" style="width:450px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;">
					<option value="item">Item</option>
					<option value="img">Imagens</option>
					<option value="gal">Galerias</option>
					<option value="img_gal">Imagens das galerias</option>
					<option value="cat">Categorias</option>
					<option value="file">Arquivos</option>
				</select>
			</div>
			<div class="c"></div>

				<div class="descricao">Qual formato gostaria de importar?</div>

				<div style="padding: 10px 20px;">
					<select name="typeCode" style="width:450px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;">
						<option value="tag">TAG HTML5</option>
						<option value="classe">Classe PHP</option>
						<option value="restfull">JSON</option>
					</select>
				</div>
			</form>
		</div>';
	exit;
}

function InsertCodeCampos(){
	global $session;
	parse_str($_POST['form'],$_FORM);

	$ws_ferramentas 				= new MySQL();
	$ws_ferramentas->set_table(PREFIX_TABLES.'ws_ferramentas');
	$ws_ferramentas->set_where('id="'.$_FORM['id_toll'].'"');
	$ws_ferramentas->select();


	$Ferramenta = $ws_ferramentas->fetch_array[0];
	$prefix 	= $Ferramenta['_prefix_'];

	if(isset($_FORM['typeCode']) && $_FORM['typeCode']=="classe"){
		$output="\n";
		$output.= '################################### CLASSE PHP ###################################'."\n";
		$output.= '	//Caso utilize template, utilize as variáveis da mesma forma que as tag HTML5;'."\n";
		$output.= '	$template="<div>{{coluna}}</div>";'."\n\n";
		$output.= '	// Chamamos a classe WS'."\n";
		$output.= '	$Tool= new WS();'."\n";
		$output.= '	$pesquisa = $Tool->slug("'.$ws_ferramentas->fetch_array[0]['slug'].'")->type("'.$_FORM['type'].'")'."\n\n";
		$output.= '##############################################################################'."\n";
		$output.= '//	Aqui são outras variáveis de pesquisa, para utilizar basta descomentar'."\n";
		$output.= '##############################################################################'."\n";
		$output.= '	//->limit()'."\n";
		$output.= '	//->innerCategory(2)'."\n";
		$output.= '	//->innerItem(1)'."\n";
		$output.= '	//->item(1)'."\n";
		$output.= '	//Apenas se tiver um template'."\n";
		$output.= '	//->setTemplate($template)'."\n";
		$output.= '	//->innerGalery()'."\n";
		$output.= '	//->where("")'."\n";
		$output.= '	->go();'."\n";
		$output.= "\n";
		$output.= '################################### RESULTADO ###################################'."\n";
		$output.= '	//A classe retorna um array com todos os dados da pesquisa'."\n";
		$output.= '	//Caso tenha um template cadastrado, não retornará um array, e sim a saída formatada já.'."\n";
		$output.= '	print_r($pesquisa->result);'."\n";
		$output.= '	//Retorno em objeto.'."\n";
		$output.= '	print_r($pesquisa->obj);'."\n";
		$output.= '	//Também a quantidade de resultados'."\n";
		$output.= '	print_r($pesquisa->_num_rows);'."\n";
		$output.= '	//Se qusier, também pode consultar diretamente a base, consultado a saída '."\n";
		$output.= '	print_r($pesquisa->sql);'."\n";
		$output.= '	//Listando os resultados '."\n";
		$output.= '	foreach($pesquisa->obj as $data){'."\n";

		$fullPages 				= new MySQL();
		$fullPages->set_table(PREFIX_TABLES.'_model_campos');
		$fullPages->set_where('ws_id_ferramenta="'.$_FORM['id_toll'].'"');
		$fullPages->set_where('AND coluna_mysql<>""');
		$fullPages->select();


		if(isset($_FORM['type']) && $_FORM['type']=='item'){
			if($fullPages->_num_rows==0){$output .= '	//Nenhum campos específico adicionado'."\n";}
			foreach ($fullPages->fetch_array as $toll) {

				if($prefix!="" && substr($toll['coluna_mysql'],0,strlen($prefix))==$prefix) {$toll['coluna_mysql'] = substr($toll['coluna_mysql'],strlen($prefix));}

				if( $toll['type']=="playerVideo"){
					$output .=	"		//Function:  url=null,type=player,w=null,h=null\n";
					$output .= '		//Retorno: site,url,title,description,image ou player'."\n";
					$output .= '		//Default: div ou mensagem que retornará caso não tenha URL especificada'."\n";
					$output .= '		//AutoPlay: Habilita o AutoPlay no vídeo. Valores 1 - 0 '."\n";
					$output .= '		echo "<div>".ws::videoData($data->'.$toll['coluna_mysql'].',"Retorno","200","200","Default","AutoPlay")."</div>";'."\n\n\n";
				
					$output .= '		//Caso queira a URL do MP4 diretamente'."\n";
					$output .= '		//Secury=true retorna um link seguro, impossível de salvar '."\n";
					$output .= '		//Secury=false retorna o link do arquivo do MP4 diretamente do youtube ou Vimeo '."\n";
					$output .= '		echo \'<video width="200" height="200" preload="auto" type="video/mp4" src="\'.ws::getVimeoYoutubeDirectLink($data->'.$toll['coluna_mysql'].',Secury).\'" controls="true" poster=""></video>\';'."\n\n";


				}elseif( $toll['type']=="playerMP3"){
					$output .=	"		// Function:  url=null,type=player,w=null,h=null,size,theme \n";
					$output .=	"		// Retorno: 	player, site, title, description, height, width, image \n";
					$output .=	"		// Size: 		widget,classic,minimo,list \n";
					$output .=	"		// Theme: 	light, dark \n";
					$output .=	"		// Auto_play: 	true, false \n";
					$output .=	"		// Default: 	div ou mensagem que retornará caso não tenha URL especificada \n";
					$output .= '		echo "<div>".ws::audioData('.$toll['coluna_mysql'].',"Retorno","w","h","Size","Theme","Auto_play","Default")."</div>";'."\n";

				}elseif( $toll['type']=="thumbmail"){
					$output.= '		//retorno da imagem:  ( path/largura/altura/imagem ) '."\n";


 					$output.= '		echo \'<picture>'."\n";
                    $output.= '		    	<source media="(max-width: 992px)" 	srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->'.$toll['coluna_mysql'].'.\'">'."\n";
                    $output.= '		    	<source media="(max-width: 1382px)" 	srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->'.$toll['coluna_mysql'].'.\'">'."\n";
                    $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/\'.$data->'.$toll['coluna_mysql'].'.\'">'."\n";
                    $output.= '			</picture>\';'."\n";


				}else{
					$output .= '		echo \'<div>\'.$data->'.$toll['coluna_mysql'].'.\'</div>\';'."\n";
				}
			}
		}

		if(isset($_FORM['type']) && $_FORM['type']=='gal'){
			$output .= '		echo \'<div>\'.$data->img_count.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->titulo.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->texto.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->url.\'</div>\';'."\n";
			$output.= '			echo \'<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)" 	srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->avatar.\'">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)" 	srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->avatar.\'">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/\'.$data->avatar.\'">'."\n";
	        $output.= '			</picture>\';'."\n";


		}

		if(isset($_FORM['type']) && $_FORM['type']=='img_gal'){
			$output .= '		echo \'<div>\'.$data->titulo.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->texto.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->url.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->token.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->filename.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->posicao.\'</div>\';'."\n";
			$output.= '			echo \'<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->file.\'">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->file.\'">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/\'.$data->file.\'">'."\n";
	        $output.= '			</picture>\';'."\n";


		}
		if(isset($_FORM['type']) && $_FORM['type']=='img'){
			$output .= '		echo \'<div>\'.$data->titulo.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->texto.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->url.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->filename.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->token.\'</div>\';'."\n";
			$output.= '			echo \'<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->imagem.\'">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->imagem.\'">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/\'.$data->imagem.\'">'."\n";
	        $output.= '			</picture>\';'."\n";



		}
		if(isset($_FORM['type']) && $_FORM['type']=='cat'){
			$output .= '		echo \'<div>\'.$data->titulo.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->texto.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->avatar.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->token.\'</div>\';'."\n";
			$output.= '			echo \'<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->avatar.\'">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/\'.$data->avatar.\'">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/\'.$data->avatar.\'">'."\n";
	        $output.= '			</picture>\';'."\n";



		}
		if(isset($_FORM['type']) && $_FORM['type']=='file'){
			$output .= '		echo \'<div>\'.$data->posicao.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->uploaded.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->titulo.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->url.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->texto.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->file.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->filename.\'</div>\';'."\n";
			$output .= '		echo \'<div>\'.$data->token.\'</div>\';'."\n";
		}
	$output.= '	}'."\n";
	echo ($output);
	exit;
	}

	#####################################################################################################################
	# TEMPLATE PRÉ DEFINIDO
	#####################################################################################################################
	if($_FORM['typeCode']=="tag" && $Ferramenta['html_item']!=""){
		echo  "\n".'<!-- FERRAMENTA: '.$Ferramenta['_tit_topo_'].' -->'."\n";
		echo  '<!-- OUTRAS TAGS DISPONÍIVEIS (Consulte a documentação em http://docs.websheep.com.br): -->'."\n";
		echo  '<!--colum="" data-paginate="" linker="" linked="" distinct=""	utf8=""	url=""	order=""	category=""	 galery=""	 item="" 	 where=""	 innerItem=""  filter="" -->'."\n\n";
	
		echo 	'<ws-tool slug="'.$ws_ferramentas->fetch_array[0]['slug'].'" type="'.$_FORM['type'].'">'."\n";
		if((isset($_FORM['type']) && $_FORM['type']=='item')){		echo str_replace("{{{_}","{{",$Ferramenta['html_item']);}
		if((isset($_FORM['type']) && $_FORM['type']=='cat')){		echo str_replace("{{{_}","{{",$Ferramenta['html_cat']);}
		if((isset($_FORM['type']) && $_FORM['type']=='img')){		echo str_replace("{{{_}","{{",$Ferramenta['html_img']);}
		if((isset($_FORM['type']) && $_FORM['type']=='gal')){		echo str_replace("{{{_}","{{",$Ferramenta['html_gal']);}
		if((isset($_FORM['type']) && $_FORM['type']=='img_gal')){	echo str_replace("{{{_}","{{",$Ferramenta['html_img_gal']);}
		if((isset($_FORM['type']) && $_FORM['type']=='file')){		echo str_replace("{{{_}","{{",$Ferramenta['html_file']);}
		echo "\n".'</ws-tool>'."\n";
		exit;
	}
	#####################################################################################################################
	# TEMPLATE PADRÃO
	#####################################################################################################################
	if(isset($_FORM['typeCode']) && $_FORM['typeCode']=="tag"){
		$output =  "";
		$output .=  "\n".'<!-- FERRAMENTA: '.$Ferramenta['_tit_topo_'].' -->'."\n";
		$output .=  "\n".'<ws-tool slug="'.$ws_ferramentas->fetch_array[0]['slug'].'" type="'.$_FORM['type'].'">'."\n";
		$output .=  '	<!--'."\n";
		$output .=  '		OUTRAS TAGS DISPONÍIVEIS:'."\n";
		$output .=  '		colum=""	linker="" linked="" distinct=""	utf8=""	url=""	order=""	category=""	 galery=""	 item="" 	 where=""	 innerItem=""  filter=""'."\n";
		$output .=  "		\n";
		$output .=  '		Paginação:'."\n";
		$output .=  '		|	data-paginate="1,2"'."\n";
		$output .=  '		|	data-paginate="1,2"'."\n";
		$output .=  '		|	1:max por página, 2:página atual'."\n";
		$output .=  '		|	pode ser usado parâmetros da URL ex:  data-paginate="url:1,url:2"'."\n\n";
		$output .=  '	-->'."\n";

		$fullPages 				= new MySQL();
		$fullPages->set_table(PREFIX_TABLES.'_model_campos');
		$fullPages->set_where('ws_id_ferramenta="'.$_FORM['id_toll'].'"');
		$fullPages->set_where('AND coluna_mysql<>""');
		$fullPages->select();

		if(isset($_FORM['type']) && $_FORM['type']=='item'){
			if($fullPages->_num_rows==0){$output .= '	<!-- Nenhum campos específico adicionado -->'."\n";}
			foreach ($fullPages->fetch_array as $toll) {
				if($prefix!="" && substr($toll['coluna_mysql'],0,strlen($prefix))==$prefix) {$toll['coluna_mysql'] = substr($toll['coluna_mysql'],strlen($prefix));}
				if( $toll['type']=="playerVideo"){
					$output .=	"	<!-- Function:  url=null,type=player,w=null,h=null -->\n";
					$output .= '	<!-- Retorno: site,url,title,description,image ou player -->'."\n";
					$output .= '	{{'.$toll['coluna_mysql'].",ws::videoData,(this),Retorno,200,200}}"."\n";
				}elseif( $toll['type']=="playerMP3"){
					$output .=	"	<!-- Function:  url=null,type=player,w=null,h=null,size,theme -->\n";
					$output .=	"	<!-- Retorno: 	player, site, title, description, height, width, image -->\n";
					$output .=	"	<!-- Size: 		widget,classic,minimo,list -->\n";
					$output .=	"	<!-- Theme: 	light, dark -->\n";
					$output .= '	{{'.$toll['coluna_mysql'].',ws::audioData,(this),Retorno,w,h,Size,Theme}}'."\n";
				}elseif( $toll['type']=="thumbmail"){
					$output.= '			<picture>'."\n";
			        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{'.$toll['coluna_mysql'].'}}">'."\n";
			        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{'.$toll['coluna_mysql'].'}}">'."\n";
			        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/{{'.$toll['coluna_mysql'].'}}">'."\n";
			        $output.= '			</picture>'."\n";



				}else{
					$output .= '	{{'.$toll['coluna_mysql'].'}}'."\n";
				}
			}
		}
		if(isset($_FORM['type']) && $_FORM['type']=='gal'){
			$output .= '	{{img_count}}'."\n";
			$output .= '	{{titulo}}'."\n";
			$output .= '	{{texto}}'."\n";
			$output .= '	{{url}}'."\n";
			$output.= '		<picture>'."\n";
	        $output.= '		    <source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{avatar}}">'."\n";
	        $output.= '		    <source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{avatar}}">'."\n";
	        $output.= '		    <img src="'.ws::rootPath.'ws-img/0/0/{{avatar}}">'."\n";
	        $output.= '		</picture>'."\n";

		}
		if(isset($_FORM['type']) && $_FORM['type']=='img_gal'){
			$output .= '	{{titulo}}'."\n";
			$output .= '	{{texto}}'."\n";
			$output .= '	{{url}}'."\n";
			$output .= '	{{token}}'."\n";
			$output .= '	{{filename}}'."\n";
			$output .= '	{{posicao}}'."\n";
			$output .= '		<picture>'."\n";
	        $output .= '		    <source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{file}}">'."\n";
	        $output .= '		    <source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{file}}">'."\n";
	        $output .= '		    <img src="'.ws::rootPath.'ws-img/0/0/{{file}}">'."\n";
	        $output .= '		</picture>'."\n";

		}
		if(isset($_FORM['type']) && $_FORM['type']=='img'){
			$output .= '	{{titulo}}'."\n";
			$output .= '	{{texto}}'."\n";
			$output .= '	{{url}}'."\n";
			$output .= '	{{filename}}'."\n";
			$output .= '	{{token}}'."\n";
			$output.= '		<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{imagem}}">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{imagem}}">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/{{imagem}}">'."\n";
	        $output.= '			</picture>'."\n";

		}
		if(isset($_FORM['type']) && $_FORM['type']=='cat'){
			$output .= '	{{titulo}}'."\n";
			$output .= '	{{texto}}'."\n";
			$output .= '	{{avatar}}'."\n";
			$output .= '	{{token}}'."\n";
			$output.= '		<picture>'."\n";
	        $output.= '		    	<source media="(max-width: 992px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{avatar}}">'."\n";
	        $output.= '		    	<source media="(max-width: 1382px)"		srcset="'.ws::rootPath.'ws-img/586/350/{{avatar}}">'."\n";
	        $output.= '		    	<img src="'.ws::rootPath.'ws-img/0/0/{{avatar}}">'."\n";
	        $output.= '			</picture>'."\n";

		}	
		if(isset($_FORM['type']) && $_FORM['type']=='file'){
			$output .= '	{{posicao}}'."\n";
			$output .= '	{{uploaded}}'."\n";
			$output .= '	{{titulo}}'."\n";
			$output .= '	{{url}}'."\n";
			$output .= '	{{texto}}'."\n";
			$output .= '	{{file}}'."\n";
			$output .= '	{{filename}}'."\n";
			$output .= '	{{token}}'."\n";
		}
		$output .= "\n\n".'</ws-tool>';
	}


	if(isset($_FORM['typeCode']) && $_FORM['typeCode']=='restfull'){

		$camposTool 				= new MySQL();
		$camposTool->set_table(PREFIX_TABLES.'_model_campos');
		$camposTool->set_where('ws_id_ferramenta="'.$_FORM['id_toll'].'"');
		$camposTool->set_where('AND coluna_mysql<>""');
		$camposTool->select();


		$output = '	
	###################################################
	# DEFINIMOS AS VARIÁVEIS A SEREM ENVIADAS
	# Verifique todas as variáveis em doc.websheep.com.br
	###################################################
			$VARS = http_build_query(
				array(
					"type" 			=> "'.$_FORM['type'].'",
					"slug" 			=> "'.$ws_ferramentas->fetch_array[0]['slug'].'"
				)
			);

	###################################################
	# SETAMOS O HEADER DE ENVIO COM O TOKEN DE ACESSO
	###################################################
		$HEADER = stream_context_create(array(
				"http" => array(
					"method" => "GET",
					"header" => "Content-Type: application/x-www-form-urlencoded\r\n"
								."token:" . ws::setTokenRest()."\r\n"
				)
			)
		);

	###########################################
	# CAPTAMOS O JSON E GUARDAMOS NA VARIÁVEL
	###########################################
		$obj_tool = json_decode(file_get_contents(ws::protocolURL().ws::domain.ws::rootPath."ws-rest/?".$VARS, false,$HEADER));'.PHP_EOL.PHP_EOL;

			if($camposTool->_num_rows<1){
				$output .= '	#######################################'.PHP_EOL;
				$output .= '	# Nenhum campo adicionado a ferramenta'.PHP_EOL;
				$output .= '	#######################################'.PHP_EOL.PHP_EOL;
			}else{
				$output .= '	#######################################'.PHP_EOL;
				$output .= '	# Campos cadastrados desta ferramenta'.PHP_EOL;				
				$output .= '	#######################################'.PHP_EOL;
			}


			$output .= '		foreach ($obj_tool as $toll) {'.PHP_EOL;
			foreach ($camposTool->fetch_array as $toll) {
				if($prefix!="" && substr($toll['coluna_mysql'],0,strlen($prefix))==$prefix) {
					$output .= '			// $toll->'.substr($toll['coluna_mysql'],strlen($prefix)).';'.PHP_EOL;
				}
			}
			$output .= '		}'.PHP_EOL;
	}



	echo ($output);
	exit;
}

function getShortCodesPlugin (){
	global $session;
	global $_SETUPDATA;

	$phpConfig 	= $_REQUEST['path'].'/plugin.config.php';
	$path 		= implode(_array_filter(explode('/',$_REQUEST['path'])),'/');
	if(file_exists($phpConfig)){
			ob_start(); @include($phpConfig); $jsonRanderizado=ob_get_clean();
			$contents 		=	$plugin;
	}
	if(empty($contents->shortcode) || $contents->shortcode==1 ){

			###########################################################################
			# RETORNA OS ARQUIVOS CSS
			###########################################################################
			echo  getListStylePlugin($contents->style);

			$arrReq   = array();
			if(isset($contents->requiredData) && is_array($contents->requiredData) && $contents->requiredData!="" && count($contents->requiredData)>1){
				###########################################################################
				# RETORNA A TAG HTML DO PLUGIN
				###########################################################################
				echo returnTagHTMLPlugin(basename($path),$contents->requiredData);
			}
			###########################################################################
			# RETORNA OS JAVASCRIPTS
			###########################################################################
				echo getListScriptPlugin($contents->script);

		#############################################################################################################################################################
		#############################################################################################################################################################
	}elseif($contents->shortcode==2){
			###########################################################################
			# RETORNA O ARQUIVO PHP CRU
			###########################################################################


			###########################################################################
			# RETORNA O PHP PROCESSADO
			###########################################################################
			if(isset($contents->requiredData) && is_array($contents->requiredData) && $contents->requiredData!="" && count($contents->requiredData)>1){
				$shortCode = str_replace(array('<','>'),array('&lt;','&gt;'),returnTagHTMLPlugin(basename($path),$contents->requiredData));
			}else{
				$shortCode = str_replace(array('<','>'),array('&lt;','&gt;'),returnTagHTMLPlugin(basename($path)));
			}

			echo '<?'.PHP_EOL;
			echo '####################################################################################################'.PHP_EOL;
			echo '# importamos a configuração do plugin'.PHP_EOL;
			echo '####################################################################################################'.PHP_EOL;
			echo '	include(ws::includePath."'.str_replace(INCLUDE_PATH,"", $phpConfig).'");'.PHP_EOL;
			echo '	$ws =  (object) array('.PHP_EOL;
			echo '					 "pathPlugin"		=>	"'.str_replace(INCLUDE_PATH."website/","",$path).'"'.PHP_EOL;
			echo '					,"rootPath"			=>	ws::rootPath'.PHP_EOL;
			echo '					,"includePath"		=>	ws::includePath'.PHP_EOL;
			echo '					,"shortcode"		=>	\''.str_replace("'","\'",$shortCode).'\''.PHP_EOL;
			echo '					,"vars" 			=>	(object)$plugin->requiredData'.PHP_EOL;
			echo '					,"innertext"		=>	null'.PHP_EOL;
			echo '					,"outertext"		=>	null'.PHP_EOL;
			echo '					,"json" 			=> 	$plugin'.PHP_EOL;
			echo '				);'.PHP_EOL.PHP_EOL;
			echo '####################################################################################################'.PHP_EOL;
			echo '?>'.PHP_EOL.PHP_EOL;

			###########################################################################
			# RETORNA OS ARQUIVOS CSS
			###########################################################################
			echo  getListStylePlugin($contents->style);

			###########################################################################
			# IMPORTA O ARQUIVO DO PLUGIN
			###########################################################################
			$pathFile = $path.'/'.$contents->plugin;
			if(!file_exists($pathFile) && file_exists('/'.$pathFile)){$pathFile = '/'.$pathFile;}
			echo file_get_contents($pathFile);

			###########################################################################
			# RETORNA OS JAVASCRIPTS
			###########################################################################
				echo getListScriptPlugin($contents->script);

	}elseif($contents->shortcode==3){

			###########################################################################
			# RETORNA O PHP PROCESSADO
			###########################################################################
			if(isset($contents->requiredData) && is_array($contents->requiredData) && $contents->requiredData!="" && count($contents->requiredData)>1){
				$shortCode = returnTagHTMLPlugin(basename($path),$contents->requiredData);
			}else{
				$shortCode = returnTagHTMLPlugin(basename($path));
			}
			$ws =  (object) array(
								'pathPlugin'		=>	str_replace(INCLUDE_PATH.'website/',"",$path)
								,'rootPath'			=>	ws::rootPath
								,'includePath'		=>	ws::includePath
								,'shortcode'		=>	$shortCode
								,'outertext'		=>	null
								,'innertext'		=>	null
								,'vars' 			=>	(object)$contents->requiredData
								,'json' 			=> 	$contents
							);
			ob_start(); 
				###########################################################################
				# RETORNA OS ARQUIVOS CSS
				###########################################################################
				echo  getListStylePlugin($contents->style);

				if(file_exists($path.'/'.$contents->plugin)){
					include($path.'/'.$contents->plugin); 
				}elseif(file_exists('/'.$path.'/'.$contents->plugin)){
					include('/'.$path.'/'.$contents->plugin); 
				}else{
					echo "Arquivo não encontrado: ".$path.'/'.$contents->plugin;
				}
				
				###########################################################################
				# RETORNA OS JAVASCRIPTS
				###########################################################################
				echo getListScriptPlugin($contents->script);


			echo ob_get_clean();
	}
	exit;
}

function getListStylePlugin($style){
	global $_SETUPDATA;
	$stringStyle = '';
	if(isset($style) && count($style)>=1){
		$stringStyle .=  PHP_EOL.'<!-- '.PHP_EOL.PHP_EOL.'	Inclua esses styles entre as tags <head></head> :'.PHP_EOL;
		foreach ($style as $value) {
			if(is_array($value) && count($value)==1){
				$link = $value[0];
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.$link.'">'.PHP_EOL;
				}else{
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'">'.PHP_EOL;
				}
			}elseif(is_array($value) && count($value)==2){
				$link = $value[0];
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.$link.'" '.$value[1].'>'.PHP_EOL;
				}else{
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'" '.$value[1].'>'.PHP_EOL;
				}
			}else{
				$link = $value;
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.$link.'" >'.PHP_EOL;
				}else{
					$stringStyle .=  '	<link rel="stylesheet" type="text/css" href="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'" >'.PHP_EOL;
				}
			}
		}
		$stringStyle .= PHP_EOL.'-->'.PHP_EOL.PHP_EOL;
	}
	echo $stringStyle;
}


function  getListScriptPlugin($script){
	global $_SETUPDATA;
	$stringScript = '';
	if(isset($script) && count($script)>=1){
		$stringScript .=  PHP_EOL.'<!-- '.PHP_EOL.PHP_EOL.'	Para esse plugin funcionar corretamente, é necessário incluir esses arquivos ao final da página:'.PHP_EOL;
		foreach ($script as $value) {
			if(is_array($value) && count($value)==1){
				$link = $value[0];
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringScript .= '	<script 	type="text/javascript" src="'.$link.'"></script>'.PHP_EOL;
				}else{
					$stringScript .= '	<script 	type="text/javascript" src="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'"></script>'.PHP_EOL;
				}
			}elseif(is_array($value) && count($value)==2){
				$link = $value[0];
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringScript .= '	<script 	type="text/javascript" src="'.$link.'" id="'.$value[1].'"></script>'.PHP_EOL;
				}else{
					$stringScript .= '	<script 	type="text/javascript" src="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'"  id="'.$value[1].'"></script>'.PHP_EOL;
				}
			}else{
				$link = $value;
				$link = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($link, FILTER_VALIDATE_URL) === false){
					$stringScript .= '	<script 	type="text/javascript" src="'.$link.'"></script>'.PHP_EOL;
				}else{
					$stringScript .= '	<script 	type="text/javascript" src="'.ROOT_WEBSHEEP.$_SETUPDATA['url_plugin'].'/'.$link.'"></script>'.PHP_EOL;
				}
			}
		}
		$stringScript .= PHP_EOL.'-->';
	}
	return $stringScript;
}

function returnTagHTMLPlugin ($path=null,$requiredData=array()){
	if(is_array($requiredData)){
		foreach ($requiredData as $key => $value) {
			if(is_array($value)){
						if(count($value)>1){
							$arr = array();
							foreach ($value as $itensInnerArray) {
								if(is_numeric($itensInnerArray)){
									$arr[] = $itensInnerArray;
								}else{
									$arr[] ="'".$itensInnerArray."'";
								}
							}
							$value = 'array('.implode($arr,',').')';
						}else{
							$value = implode($value);
						}
				$arrReq[]= $key.'="'.$value.'"';
			}else{
				$arrReq[]= $key.'="'.$value.'"';
			}
		}
		return '<ws-plugin path="'.$path.'" '.@implode(@$arrReq," ").'></ws-plugin>';
	}else{
		return '<ws-plugin path="'.$path.'"></ws-plugin>';
	}
}


function loadShortCodes (){
	global $session;
	global $_SETUPDATA;

	$path = INCLUDE_PATH.'website/'.$_SETUPDATA['url_plugin'];
	echo '<div style="comboShortCode">
		<div style="font-size: 20px;font-weight: bold;padding-bottom: 12px;">Adicionar um plugin</div>
		<div class="descricao">Escolha um dos plugins instalados e adicione em seu conteudo</div>
		<div class="c"></div>
		<div style="padding: 20px;">
			<select id="shortcodes" style="width:450px;padding: 10px;border: none;color: #3A639A;-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px;">
				<option value="">Selecione uma popção</option>
			';
			$dh = opendir($path);


			while($diretorio = readdir($dh)){
				if($diretorio != '..' && $diretorio != '.' && $diretorio != '.htaccess'){
					if(file_exists($path.'/'.$diretorio.'/active')){
						$phpConfig 	= $path.'/'.$diretorio.'/plugin.config.php';
						if(file_exists($phpConfig)){
								ob_start(); @include($phpConfig); $jsonRanderizado=ob_get_clean();
								$contents 		=	$plugin;
						}

						if( (is_array($plugin->menu) && in_array('editor',$plugin->menu)) || $plugin->menu=='editor'){
							echo "<option value='".$path.'/'.$diretorio."'>".$contents->pluginName.'</option>';
						}

					}
				}
			}
			echo '</select>
			</div>
		</div>';
	exit;
}


function returnBKP (){
	global $session;
		$file_exists_dir 				= new MySQL();
		$file_exists_dir->set_table(PREFIX_TABLES.'ws_webmaster');
		$file_exists_dir->set_where('path="'.str_replace('./../../..', '',$_REQUEST['pathFile']).'"');
		$file_exists_dir->set_where('AND original="'.$_REQUEST['filename'].'"');
		$file_exists_dir->set_order('id','DESC');
		$file_exists_dir->select();
		if($file_exists_dir->_num_rows==0){
			echo '<option>Nenhum bkp gerado</option>'.PHP_EOL;
		}elseif($file_exists_dir->_num_rows<2){
			echo '<option>1 bkp gerado </option>'.PHP_EOL;
			echo '<option value="original">Arquivo oficial</option>'.PHP_EOL;
		}else{
			echo '<option>'.$file_exists_dir->_num_rows.' bkp gerados </option>'.PHP_EOL;
			echo '<option value="original">Arquivo oficial</option>'.PHP_EOL;
		}
		foreach($file_exists_dir->fetch_array as $opt){echo '<option value="'.$opt['token'].'">'.$opt['created'].'</option>'.PHP_EOL;};
}


function _excl_dir_(){
		global $session;
		$Dir = $_REQUEST['exclFolder'];
		_excluiDir(INCLUDE_PATH.'website/'.$Dir);
		echo true;
		exit;
}


function createFolder($NewPath=null,$return=true){
	global $session;
	if($NewPath==null && isset($_POST['newFile'])){ $NewPath=$_POST['newFile'];}

	$dir = implode(array_filter(explode("/",str_replace(array('..','.'),"",$NewPath))),"/");
	if(_mkdir('website/'.$dir,true)){
		if($return==true){
			echo "sucesso";exit;
		}
	}else{
		if($return==true){
			echo "falha";exit;
		}
	};
}

function CriaPastas($dir,$oq=0){
	global $session;
	if (is_dir($dir)) {
		$dh = opendir($dir);
		while($diretorio = readdir($dh)){
			if($diretorio != '..' && $diretorio != '.' && is_dir($dir.'/'.$diretorio)){
				$folder_tratado = implode(array_filter(explode("/",str_replace(array('..','.'),"",str_replace(INCLUDE_PATH.'website/',"",$dir.'/'.$diretorio)))),"/");
				echo '<div class="w1 folder_alert folder" data-folder="'.$folder_tratado.'">'.$diretorio."</div>".PHP_EOL;
				echo "<div class='w1 container'>".PHP_EOL;
				CriaPastas($dir.'/'.$diretorio,$oq);
				if($oq==1 || $oq==true) MostraFiles($dir.'/'.$diretorio);
				echo "</div>".PHP_EOL;
			};
		};
	};
};


function createFile (){
	global $session;
		$filename 	= 	basename($_POST['newFile']);
		$dirname 	=	implode(array_filter(explode("/",str_replace(".","-",dirname($_POST['newFile'])))),"/");


		if($dirname=='-'){
			$dirname 	= "";
			$fileCreate = INCLUDE_PATH.'website/'.$filename;
		}else{
			createFolder($dirname,false);
			$fileCreate = INCLUDE_PATH.'website/'.$dirname.'/'.$filename;
		}

		if(file_put_contents($fileCreate,$filename)){
			$fullPathFile = implode(array_filter(explode("/",INCLUDE_PATH.'website/'.$dirname.'/'.$filename)),"/");
			loadFile($fullPathFile);
		}else{
			echo "falha";
		};
	exit;
}
function ListFolderNewFile (){
	global $session;
	echo 'Criar um arquivo novo
	<div class="nave_folders">';
	CriaPastas(INCLUDE_PATH.'website');
	echo '</div>
	<div class="c"></div>
	<input class="inputText path" placeholder="Digite o path do seu diretório:">
	<div class="c"></div>';
}
function ListFolderExclFolder (){
	global $session;
	echo 'Selecione um diretório e complemente com o nome do novo folder <br>ou apenas escreva o nome do novo folder no campo a baixo:
	<div class="c"></div>
	<div class="bg08" style="padding: 10px 60px; margin: 10px; color: #D80000;">Atenção, ao apagar serão excluidos também os arquivos de BKP em seu sistema.<br>E isso não terá mais volta!</div>
	<div class="c"></div>

	<div class="nave_folders"><form>';
	CriaPastas(INCLUDE_PATH.'website');
	echo '</div></form>
	<div class="c"></div>
	<script>
		// var newFolder = null;
		// $(".folder_alert").unbind("click tap").bind("click tap",function(){
			// var getFolder = $(this).data("folder");
		// })
		// sanfona(\'.folder_alert\');
	</script>';}



function ListFolderNewFolder (){
	global $session;
	echo 'Selecione um diretório e complemente com o nome do novo folder <br>ou apenas escreva o nome do novo folder no campo a baixo:
	<div class="c"></div>

	<div class="nave_folders">';
	CriaPastas(INCLUDE_PATH.'website');
	echo '</div>
	<div class="c"></div>
	<input class="inputText path" placeholder="Digite o path do seu diretório:">
	<div class="c"></div>
	<script>
		var newFolder = null;
		$(".folder_alert").unbind("click tap").bind("click tap",function(){
			var getFolder = $(this).data("folder");
			$("input.path").val(getFolder.replace("./../../../website/","")+"/")
		})
		sanfona(\'.folder_alert\');
	</script>';}
	
function MostraFiles($dir){
	global $session;
	$dh = opendir($dir);
	while($arquivo = readdir($dh)){
		if($arquivo != '..' && $arquivo != '.' && !is_dir($dir.'/'.$arquivo)){
			$ext = explode('.',$arquivo);
			$ext = @$ext[1];
			if(	isset($ext)		&& (
				$ext=="txt" 	||
				$ext=="htm" 	||
				$ext=="html" 	||
				$ext=="xhtml" 	||
				$ext=="xml" 	||
				$ext=="js"	 	||
				$ext=="json" 	||
				$ext=="php" 	||
				$ext=="css" 	||
				$ext=="less" 	||
				$ext=="sass" 	||
				$ext=="htaccess"||
				$ext=="key" 	||
				$ext=="asp" 	||
				$ext=="aspx" 	||
				$ext=="net" 	||
				$ext=="conf" 	||
				$ext=="ini" 	||
				$ext=="sql" 	||
				$ext=="as" 		||
				$ext=="htc" 	||
				$ext=="--"
			)){
				echo '	<div class="w1 file '.$ext.' multiplos" data-id="null" data-file="'.$dir.'/'.$arquivo.'"  >'.$arquivo."</div>".PHP_EOL;
			};
		};
	};
};

function 	refreshFolders (){
	global $session;
	CriaPastas(INCLUDE_PATH.'website',true);
	MostraFiles(INCLUDE_PATH.'website');
	echo '<script>sanfona(\'.folder\');</script>';
}

function loadFile($pathFile=null){
		global $session;
		global $_conectMySQLi_;

		if(isset($_REQUEST['pathFile']) && $pathFile==null){
			$pathFile 	= $_REQUEST['pathFile'];
		}else{
			$_REQUEST['pathFile'] = $pathFile;
		}


		$path 							=	dirname(implode("/",array_filter(explode("/",$pathFile))));
		$file 							=	basename($pathFile);

		if(!file_exists($pathFile) && file_exists('/'.$pathFile)){$pathFile = '/'.$pathFile;}


		// $file_exists_dir 				= 	new MySQL();
		// $file_exists_dir->set_table(PREFIX_TABLES.'ws_webmaster');
		// $file_exists_dir->set_where('path="'.$pathFile.'"');
		// $file_exists_dir->set_where('AND original="'.$file.'"');
		// $file_exists_dir->set_order('id','DESC');
		// $file_exists_dir->select();
		// $count =$file_exists_dir->_num_rows;
		$ext = explode('.',$file);
		$ext = end($ext);
		$newTokenFile = createPass(rand(9,50), $maiusculas = true, $numeros = false, $simbolos = false);
		if($ext=="txt"){$ext="text";}
		if($ext=="js"){$ext="javascript";}
		$stringFile = mysqli_real_escape_string($_conectMySQLi_,file_get_contents($pathFile));

		echo 'if(!$(\'.fileTabContainer .fileTab[data-full-path-file="'.$pathFile.'"]\').length){';
		echo '$("#nameFile").html("<span class=\'b1 noSelect\'>Nome do arquivo:</span> /'.str_replace('./../../../','', $_REQUEST['pathFile']).'");';
		echo '$("#mode option[value 	=\''.$ext.'\']").attr("selected","true").trigger("chosen:updated");';
		echo 'window.typeLoaded			= "file";';
		echo 'window.pathFile 			= "/'.$path.'/'.$file.'";';
		echo 'window.loadFile 			= "'.$file.'";';
		echo 'window.newTokenFile 		= "'.$newTokenFile.'";';
		echo 'window.tokenFile 			= "'.$newTokenFile.'";';
		echo 'window.htmEditor.setReadOnly(false);';
		//MONTA O OBJETO COM OS ARQUIVOS E AS SESSÕES 
		echo 'window.listFilesWebmaster.'.$newTokenFile.' = Object();';
		echo 'window.listFilesWebmaster.'.$newTokenFile.' ={'.
															'session:		ace.createEditSession("'.$stringFile.'" ,"ace/mode/'.$ext.'")'.
															',file:			"'.$file.'"'.
															',pathFile:		"'.$pathFile.'"'.
															',newTokenFile: "'.$newTokenFile.'"'.
															',setReadOnly: 	false'.
															',saved: "saved"'.
															'};'.PHP_EOL.PHP_EOL;
		//APLICA AS SESSÕES AO EDITOR
		echo 'window.htmEditor.setSession(window.listFilesWebmaster.'.$newTokenFile.'.session);';
		echo 'window.addTab("'.$newTokenFile.'",window.pathFile,window.loadFile,"saved");';
		echo '}else{
				$(\'.fileTabContainer .fileTab[data-full-path-file="'.$pathFile.'"]\').click();
			};';

	}
	function loadFileBKP(){
		global $session;
		if($_REQUEST['token']=="original"){
			$_REQUEST['pathFile'] = $_REQUEST['pathFile'].'/'.$_REQUEST['filename'];
			loadFile();
			exit;
		}
		$file_exists_dir 				= new MySQL();
		$file_exists_dir->set_table(PREFIX_TABLES.'ws_webmaster');
		$file_exists_dir->set_where('token="'.$_REQUEST['token'].'"');
		$file_exists_dir->set_order('id','DESC');
		$file_exists_dir->select();
		$count =$file_exists_dir->fetch_array[0];
		$ext = explode('.',$count['bkpfile']);
		$ext = end($ext);
		if($ext=="txt")$ext="text";
		if($ext=="js")$ext="javascript";
		echo '$("#mode option[value 	=\''.$ext.'\']").attr("selected","true").trigger("chosen:updated");';
		echo 'window.typeLoaded			= "bkp";';
		echo 'window.htmEditor.setReadOnly(true);';
		echo 'window.htmEditor.getSession().setMode("ace/mode/'.$ext.'");';
		echo 'window.htmEditor.setValue("'.mysql_real_escape_string(file_get_contents('./versoes/'.$count['path'].'/'.$count['bkpfile'])).'");';
		echo 'setTimeout(function(){$(".ace_scrollbar").perfectScrollbar("update");},200);';}

function geraBKPeAplica(){
		global $session;
		parse_str($_POST['GET'], $POST);	
		$urlPath= implode(array_filter(explode('/',$POST['pathFile'])),"/").'/'.$POST['filename'];

		if(file_exists($urlPath)){
			$path = $urlPath;
		}elseif(file_exists('/'.$urlPath)){
			$path = '/'.$urlPath;
		}else{
			die("Arquivo não existe:".PHP_EOL.$urlPath);
		}

		if(file_put_contents($path, $POST['ConteudoDoc'])){ 
			echo "sucesso";
		}else{
			echo "fail";
		};
		exit;
	}
function getVersionsFile(){
	global $session;
	if(empty($session->get('id')) || $session->get('id')==""){echo "window.location.reload()";exit;}
	$pathFile 	= $_REQUEST['pathFile'];
	$pathFile 	= explode("/",$pathFile);
	$file 		= end($pathFile);
	$pathFile 	= array_slice($pathFile,0, -1);
	$pathFile	= implode($pathFile,'/'); 
	// verifica se existe registro
	$file_exists_dir 				= new MySQL();
	$file_exists_dir->set_table(PREFIX_TABLES.'ws_webmaster');
	$file_exists_dir->set_where('path="'.$pathFile.'"');
	$file_exists_dir->set_where('AND original="'.$file.'"');
	$file_exists_dir->set_order('id','DESC');
	$file_exists_dir->select();
	$count =$file_exists_dir->_num_rows;

	if($count==0){
	}elseif($count>1){
		//********************************************************************************************************************************************************************
		$resposta =  '<div style="margin-bottom:20px;font-weight:800;">Este arquivo tem versões disponíveis. Escolha uma delas: </div>';
		$resposta .=  '<div style="position: relative;overflow: auto;height: 230px;margin-right: 10px;margin-bottom: -40px;">';
		foreach($file_exists_dir->fetch_array as $file){
			if($file['checkin']=='1'){
					$resposta .=  '<div class=" bg06" style="padding: 10px;margin:0 9px;height: 28px;">';
					$resposta .=  '<div style="position: relative;float: left;margin-top: 5px;font-size: 12px;font-weight: 800;"><span style="color:#19AB00;font-size: 15px;">[ Chek-In ]</span> Salvo em: '.$file['updated'].'</div>';
					if($file['id_checkout']==$session->get('id')){
						$resposta .=  '<div data-id="'.$file['id'].'" class="botao botao_load_file" style="position: relative;float:right;padding: 6px 30px;">Abrir versão</div>';
					}else{
						if($file['id_checkout']!="0"){
							$ws_usuarios 				= new MySQL();
							$ws_usuarios->set_table(PREFIX_TABLES.'ws_usuarios');
							$ws_usuarios->set_where('id="'.$file['id_checkout'].'"');
							$ws_usuarios->select();
							$resposta .=  '<div style="position: absolute;right: 0;padding: 6px 30px;color: #A41500;">Sendo editado por '.$ws_usuarios->fetch_array[0]['nome'].'</div>';
						}else{
							$resposta .=  '<div style="position: absolute;right: 0;padding: 6px 30px;color: #A41500;">Já está sendo editado.</div>';
						}
					}
			}else{
				$resposta .=  '<div class=" bg02" style="padding: 10px;margin:0 9px;height: 28px;">';
				$resposta .=  '<div style="position: relative;float: left;margin-top: 6px;">Salvo em: '.$file['updated'].'</div>';
				$resposta .=  '<div data-id="'.$file['id'].'" class="botao botao_load_file" style="position: relative;float:right;padding: 6px 30px;">Abrir versão</div>';
			}
			$resposta .=  '</div>';
		};
		$resposta .=  '</div>';
		$resposta .=  '<script type="text/javascript">
				$(function(){
					$(".botao_load_file").click(function(){
						var id_file = $(this).data("id");
							functions({
								funcao:"loadFileVersion",
								vars:"id_file="+id_file,
								patch:"'.$session->get("_PATCH_").'",
								Sucess:function(a){eval(a);}
							});
						$("#close").click();
					});
				})
			</script>';
		echo 'confirma({conteudo:"'.str_replace(array(PHP_EOL,"	",'"','\n','\r'),array("","",'\"','',''),$resposta).'", bot1: 0,bot2: 0,drag:0,botclose:1});';
		//********************************************************************************************************************************************************************
	}else{
		//  se for apenas 1 arquivo
		// verifica se tem rascunho
			if($arrayMysql['rascunho']==""){
				$codigo = urldecode(stripslashes($arrayMysql['codigo']));
			}else{
				$codigo = urldecode(stripslashes($arrayMysql['rascunho']));
			};
		
		//  se foi vc que fez o checkin ele libera o checkout
		if($arrayMysql['checkin']=='1' && $arrayMysql['id_checkout']==$session->get('id')){
			checkinchekcout($arrayMysql['id'], $arrayMysql['checkin'],$codigo);
			echo "out('1');";
		}else{
				// se não ele deixa como aberto.
				echo 'window.id_file_open="'.$arrayMysql['id'].'";';
				echo '$("#aplicar").show();';
				echo '$("#voltar_original").hide();';
				echo '$("#check").show();';
				echo 'window.doc_version="'.urlencode(stripslashes($codigo)).'";';
				echo 'window.editor.getDoc().setValue("'.mysql_real_escape_string($codigo).'");';
				echo '$(".CodeMirror textarea").attr("readOnly","");';
				echo "out('2');";
				validaChekin();
		}
	}}
function loadFileVersion(){
	global $session;
	if($session->get('id')==""){echo "window.location.reload()";exit;}
	$id_file = $_REQUEST['id_file'];
	$load_version_file 				= new MySQL();
	$load_version_file->set_table(PREFIX_TABLES.'ws_webmaster');
	$load_version_file->set_where('id="'.$id_file.'"');
	$load_version_file->select();

	if($load_version_file->fetch_array[0]['rascunho']==""){
		$codigo = urldecode($load_version_file->fetch_array[0]['codigo']);
	}else{
		$codigo = urldecode($load_version_file->fetch_array[0]['rascunho']);
	};
	echo 'window.code_original="'.mysql_real_escape_string(file_get_contents($load_version_file->fetch_array[0]['path'])).'";';
	echo 'window.doc_version="'.urlencode($codigo).'";';
	checkinchekcout($load_version_file->fetch_array[0]['id'], $load_version_file->fetch_array[0]['checkin'],$codigo);}
function load_path(){
	global $session;
	if($session->get('id')==""){echo "window.location.reload()";exit;}
	$load_path_file 				= new MySQL();
	$load_path_file->set_table(PREFIX_TABLES.'ws_webmaster');
	$load_path_file->set_where('path="'.$_REQUEST['pathFile'].'"');
	$load_path_file->set_limit(1);
	$load_path_file->set_order('id','DESC');
	$load_path_file->select();
	if($load_path_file->fetch_array[0]['rascunho']==""){
		$codigo = urldecode($load_path_file->fetch_array[0]['codigo']);
	}else{
		$codigo = urldecode($load_path_file->fetch_array[0]['rascunho']);
	};

	echo 'window.code_original="'.mysql_real_escape_string(file_get_contents($load_path_file->fetch_array[0]['path'])).'";';
	echo 'window.doc_version="'.urlencode($codigo).'";';
	checkinchekcout($load_path_file->fetch_array[0]['id'], $load_path_file->fetch_array[0]['checkin'],$codigo);}
function exclui_file(){
		global $session;
		$FILE = $_POST['pathFile'].$_POST['loadFile'];
		@unlink($FILE);
		$aba =  '".fileTab[data-full-path-file=\''.$FILE.'\']"';
		echo 'var token = $('.$aba.').data("token");'.PHP_EOL;
		echo 'delete window.listFilesWebmaster[token];'.PHP_EOL;
		echo '$('.$aba.').remove();'.PHP_EOL;
		echo 'window.htmEditor.getSession().setMode("ace/mode/php");'.PHP_EOL;
		echo '$("#mode option[value 	=\'Ttext\']").attr("selected","true").trigger("chosen:updated");'.PHP_EOL;
		echo 'window.newTokenFile		= null;'.PHP_EOL;
		echo 'window.typeLoaded			= null;'.PHP_EOL;
		echo 'window.pathFile 			= null;'.PHP_EOL;
		echo 'window.loadFile 			= null;'.PHP_EOL;
		echo 'window.newTokenFile 		= null;'.PHP_EOL;
		echo '$("#bkpsFile").html("").trigger("chosen:updated");'.PHP_EOL;
		echo 'window.htmEditor.setValue("");'.PHP_EOL;
		echo '$(".fileTab:first-child").click();'.PHP_EOL;



	}
function saveFileBKP(){
	global $session;
			if($session->get('id')==""){echo "window.location.reload()";exit;}
			$U					= new MySQL();
			$U->set_where('id="'.$_REQUEST['id'].'"');
			$U->set_table(PREFIX_TABLES.'ws_webmaster');
			$U->set_update('rascunho',urlencode(stripslashes($_REQUEST['file_content'])));
			$U->set_update('responsavel_altera',$session->get('id'));
			if($U->salvar()){
				echo 'TopAlert({mensagem: "Salvo com sucesso!",type: 3});';
			}else{
				echo 'TopAlert({mensagem: "Ops, houve uma falha ao salvar",type: 2});';
			}}
function aplica_file(){
	global $session;
	if($session->get('id')==""){echo "window.location.reload()";exit;}
	$path 			=		$_REQUEST['path']; 
	$doc_version 	=		$_REQUEST['doc_version']; 
	if(file_put_contents($path, stripslashes($doc_version))){
			echo 'TopAlert({mensagem: "Sucesso em aplicar!",type: 3});';
	}else{
			echo 'TopAlert({mensagem: "Ops, houve uma falha ao aplicar",type: 2});';
	}}
/**/

//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
//####################################################################################################################
_session();
_exec($_REQUEST['function']);