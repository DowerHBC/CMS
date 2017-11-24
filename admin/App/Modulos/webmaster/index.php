<?php 
############################################################################################################################################
# DEFINIMOS O ROOT DO SISTEMA
############################################################################################################################################
	if(!defined("ROOT_WEBSHEEP"))	{
	$path = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'admin'));
	$path = implode(array_filter(explode('/',$path)),"/");
	define('ROOT_WEBSHEEP',(($path=="") ? "/" : '/'.$path.'/'));
}

if(!defined("INCLUDE_PATH")) {$includePath 	= substr(str_replace("\\","/",getcwd()),0,strpos(str_replace("\\","/",getcwd()),'admin'));define("INCLUDE_PATH",$includePath);}
############################################################################
# IMPORTAMOS A CLASSE DO SISTEMA
############################################################################
include_once(INCLUDE_PATH.'admin/app/lib/class-ws-v1.php');
// _session(); 
$session = new session();

	$session->set('_PATCH_', 'app/modulos/webmaster'); 
	include("./autoComplete.php");

?>
<!-- 
	<script src="./app/templates/js/formatCode/javascriptobfuscator_unpacker.js"></script>
	<script src="./app/templates/js/formatCode/urlencode_unpacker.js"></script>
	<script src="./app/templates/js/formatCode/p_a_c_k_e_r_unpacker.js"></script>
	<script src="./app/templates/js/formatCode/myobfuscate_unpacker.js"></script>
 -->
<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">
<script type="text/javascript">
	include_css('./app/templates/css/websheep/modulos/webmaster/style.min.css?<?=md5(uniqid(rand(), true))?>',  	'css_mod', 'All');
</script>
<style type="text/css">
	#container {
		z-indexms-touch-action: none;
		overflow: inherit!important;;
	}
	#divEditor{
		font-family: 'Source Code Pro', monospace;
		font-size: 15px;
	}
	.nave_folders{overflow: hidden!important;}
	.palco_02 .ps-container.ps-active-x>.ps-scrollbar-x-rail,
	.palco_02 .ps-container.ps-active-y>.ps-scrollbar-y-rail {display: block;}
	.palco_02 .ps-container>.ps-scrollbar-x-rail {
		display: none;
		position: absolute;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		border-radius: 4px;
		opacity: 1;
		bottom: 3px;
		height: 8px;
	}

	#mode_chosen .chosen-single {
		display: none;
	}
	#bkpsFile_chosen .chosen-single {
		display: none;
	}
	.palco_02 .ps-container>.ps-scrollbar-x-rail>.ps-scrollbar-x {
		background-color: #aaa;
	}
	.palco_02 .ps-container>.ps-scrollbar-y-rail {
		opacity: 1;
	}
	.palco_02 .ps-container:hover>.ps-scrollbar-x-rail,
	.palco_02 .ps-container:hover>.ps-scrollbar-y-rail {
		background-color: rgba(255, 255, 255, 0.15)!important;
		opacity: 1;
	}
	.palco_02 .ps-container.ps-in-scrolling.ps-x>.ps-scrollbar-x-rail,
	.palco_02 .ps-container.ps-in-scrolling.ps-y>.ps-scrollbar-y-rail,
	.palco_02 .ps-container:hover.ps-in-scrolling.ps-x>.ps-scrollbar-x-rail,
	.palco_02 .ps-container:hover.ps-in-scrolling.ps-y>.ps-scrollbar-y-rail,
	.palco_02 .ps-container:hover>.ps-scrollbar-x-rail:hover,
	.palco_02 .ps-container:hover>.ps-scrollbar-y-rail:hover {
		background-color: transparent!important;
		opacity: 1;
	}
	.chosen-container .chosen-results li.highlighted {
		background: none;
		background-color: rgba(255, 255, 255, 0.07);
		text-shadow: none;
	}
	.chosen-container-active.chosen-with-drop .chosen-single {
		background: none;
		border: 0;
		box-shadow: none;
		height: 33px;
	}
	.chosen-container .chosen-drop {
		background: none;
		border: 0;
		box-shadow: inset 0 0 1px rgba(255, 255, 255, 0.3);
		text-shadow: 0 0 0 #000;
		background-color: rgb(36, 36, 36);
		border: solid 1px #1B1919;
	}
	.chosen-container .ace_string {
		color: #ceb56c!important;
	}
	.chosen-container-single .chosen-single {
		background: none;
		border: 0;
		box-shadow: none;
		text-shadow: 0 0 0 #000;
		color: #CCC;
	}
	.ace_print-margin {display: none;}
	.ace-websheep .ace_marker-layer .ace_selection {
	    background: rgba(0, 0, 0, 0.31);
	}
	.ace-websheep {
		color: #dcd6e8!important;
    	background-color: #211e25!important;
	}
	 .ace_editor.ace_autocomplete.ace-websheep.ace_dark  .ace_layer.ace_text-layer{
		background-color: #FFF!important;
		color: #7f5c88!important;
	}

	 .ace_editor.ace_autocomplete.ace_dark.ace-websheep  .ace_editor.ace_autocomplete .ace_completion-highlight{
		color: #211e25!important;
		text-shadow: none;
		font-weight: bold;

	}
	.ace-websheep .ace_keyword { color: #8c7496!important;}
	.ace-websheep .ace_string {
	    color: #9683c1!important;
	}
	.ace-websheep .ace_comment {
		color: #ffdf65!important;
		background-color: rgba(159, 84, 218, 0.19)!important;
    }

	.ace-websheep .ace_layer.ace_text-layer .ace_line.ace_selected{
		background-color: rgba(159, 84, 218, 0.19)!important;
		text-shadow: none;

	}
</style>
<div class="c"></div>
<div class="nave_menu recolhido bg02 w1" style="z-index: 2;">
	<div class="ul_icons">
		<div id="" class="optEditor">
			File
			<div class="ul">
					<div id="novoArquivo">New</div>
					<div id="loadfile">Load 			<span>Ctrl+o</span></div>
					<div id="salvarArquivo">Save 	 	<span>Ctrl+s</span></div>
					<div id="exclFile">Delete this file</div>
			</div>
		</div>
		<div id="" class="optEditor">
			Folder
			<div class="ul">
					<div id="novodir">New folder</div>
					<div id="exclFolder">Delete folder</div>
			</div>
		</div>
		<div id="" class="optEditor">
			Insert
			<div class="ul">
					<div id="addToll"  			style="display:block">Adicionar uma Ferramenta <span>Ctrl+'</span> </div>
					<div id="plugin" 			style="display:block">Adicionar um Plugin <span>Ctrl+1</span> </div>
					<div id="addPagination"  	style="display:block">Inserir Paginação </div>
					<div id="addSendForm"		style="display:block">Adicionar formulário/cadastro</div>
					<div id="templateBootstrap"	style="display:block">Adicionar template Bootstrap</div>
			</div>
		</div>
		<div id="formatHTML" class="optEditor">
			Format HTML 
			<span style="color:#60ff00;font-size:10px;margin-top:-15px;position:absolute;float:right;right:-30px;letter-spacing:2px;">New!</span>
		</div>
	 </div>
	<form>
		<select id="bkpsFile" style="width:310px;">
			<option>Controle de versão</option>
		</select>
		<select id="mode" style="width:130px;">
		<? 
			$dh=opendir( './src-min-noconflict'); 
			while($arquivo=readdir($dh)){ 
				$nameFile=strpos($arquivo, 'mode-'); 
				if($nameFile>-1){ 
					echo PHP_EOL.'<option value="'.str_replace(array('.js','mode-'),'',$arquivo).'">'.str_replace(array('.js','mode-'),'',$arquivo).'</option>'; 
				} 
			}
		?> 
		</select>
	</form>
</div>
<div class="nave_menu fileTabContainer recolhido bg02 w1">
	<div class="container">
		<div class="new"></div>
	</div>
</div>
<div id="nave_folders" class="nave_folders recolhido">
<?php
	function CriaPastas($dir,$oq=0){
		if (is_dir($dir)) {
			$dh = opendir($dir);
			while($diretorio = readdir($dh)){
				if($diretorio != '..' && $diretorio != '.' && is_dir($dir.'/'.$diretorio)){
					if(!file_exists($dir.'/'.$diretorio.'/.htaccess')){ file_put_contents($dir.'/'.$diretorio.'/.htaccess',"#".PHP_EOL."#".PHP_EOL."#Exclua apenas se souber o que está fazendo.".PHP_EOL."#".PHP_EOL."#".PHP_EOL."RewriteEngine off");}
					echo '<div class="w1 folder_alert folder" data-folder="'.str_replace(INCLUDE_PATH.'website',"",$dir.'/'.$diretorio).'">'.$diretorio."</div>".PHP_EOL;
					echo "<div class='w1 container'>".PHP_EOL;
					CriaPastas($dir.'/'.$diretorio."/",$oq);
					if($oq==1 || $oq==true) MostraFiles($dir.'/'.$diretorio."/");
					echo "</div>".PHP_EOL;
				};
			};
		};
	};
	function MostraFiles($dir){
		$dh = opendir($dir);
		while($arquivo = readdir($dh)){
			if($arquivo != '..' && $arquivo != '.' && !is_dir($dir.$arquivo)){
				$ext = explode('.',$arquivo);
				$ext = @$ext[1];
				if(	isset($ext)		&&($ext=="txt" 	||$ext=="htm" 	||$ext=="html" 	||$ext=="xhtml" 	||$ext=="xml" 	||$ext=="js"	 	||$ext=="json" 	||$ext=="php" 	||$ext=="css" 	||$ext=="less" 	||$ext=="sass" 	||$ext=="htaccess"||$ext=="key" 	||$ext=="asp" 	||$ext=="aspx" 	||$ext=="net" 	||$ext=="conf" 	||$ext=="ini" 	||$ext=="sql" 	||$ext=="as" 		||$ext=="htc" 	|| $ext=="--")){
					
					if(substr($dir,-1)!="/"){$dir=$dir.'/';}

					echo '	<div class="w1 file '.$ext.' multiplos" data-id="null" data-file="'.$dir.$arquivo.'"  >'.$arquivo."</div>".PHP_EOL;
				
				};
			};
		};
	};
	CriaPastas(INCLUDE_PATH.'website',true);
	MostraFiles(INCLUDE_PATH.'website');
?>
</div>
<div id="palco" class="palco_02 recolhido">
<div id="divEditor" class="recolhido">&lt;? ?&gt;</div>
<script type="text/javascript">
	$(window).unbind('keydown').bind('keydown', function(event) {
		if (event.ctrlKey || event.metaKey) {
			switch (String.fromCharCode(event.which).toLowerCase()) {
				case 'à':
					event.preventDefault();
					$("#addToll").click();
					break;
				case '1':
					event.preventDefault();
					$("#plugin").click();
					break;
				case 's':
					event.preventDefault();
					$("#salvarArquivo").click();
					break;
				case 'o':
					event.preventDefault();
					$("#loadfile").click();
					break;
			}
		}
	});
$(document).ready(function() {
	confirma({width: "auto",conteudo: "  Carregando API...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>", drag: false, bot1: 0, bot2: 0 })

	$.getScript('./app/vendor/ace/src-min-noconflict/ace.js', function() {
		$.getScript('./app/vendor/ace/src-min-noconflict/ext-language_tools.js', function() {
				$("#ws_confirm").remove();
				$("#body").removeClass("scrollhidden");
				$("*").removeClass("blur");
				window.funcTabs = function() {
					$(".fileTabContainer .fileTab").unbind("tap click").bind("tap click", function() {
						$(".fileTab").removeClass("active");
						$(this).addClass("active");
						window.pathFile = $(this).attr("data-pathFile");
						window.loadFile = $(this).attr("data-loadFile");
						window.htmEditor.setSession(window.listFilesWebmaster[$(this).attr("data-token")].session);
					})
					$(".fileTabContainer .fileTab .close").unbind("tap click").bind("tap click", function() {
						var aba = $(this);
						if ($(aba).parent().hasClass("unsave")) {
							confirma({
								conteudo: "Houve alterações neste arquivo, gostaria de salvar antes de fechar?",
								width: 500,
								posFn: function() {},
								Init: function() {},
								posClose: function() {},
								bot1: "Salvar e fechar",
								bot2: "Apenas fechar",
								drag: false,
								botclose: 1,
								newFun: function() {
									window.closeToSave = true;
									setTimeout(function() {
										$("#salvarArquivo").click();
									}, 1000)
								},
								onCancel: function() {
									if (window.pathFile == $(aba).parent().attr("data-pathFile") && window.loadFile == $(aba).parent().attr("data-loadFile")) {
										delete window.listFilesWebmaster[$(aba).parent().attr("data-token")];
										$(aba).parent().remove();
										window.resizeTab()
										if ($(".fileTabContainer .fileTab").length) {
											$(".fileTabContainer .fileTab:last-child").click();
										} else {
											window.pathFile = null;
											window.loadFile = null;
											window.htmEditor.setValue("");
										}
										window.resizeDesktop()
									} else {
										delete window.listFilesWebmaster[$(aba).parent().attr("data-token")];
										$(aba).parent().remove();
										window.resizeTab()
										if (!$(".fileTabContainer .fileTab").length) {
											window.pathFile = null;
											window.loadFile = null;
											window.htmEditor.setValue("");
										}
										window.resizeDesktop();
									}
								},
								onClose: function() {},
								Callback: function() {},
								ErrorCheck: function() {},
								Check: function() {
									return true
								}
							})
						} else {
							if (window.pathFile == $(aba).parent().attr("data-pathFile") && window.loadFile == $(aba).parent().attr("data-loadFile")) {
								delete window.listFilesWebmaster[$(aba).parent().attr("data-token")];
								$(aba).parent().remove();
								window.resizeTab()
								if ($(".fileTabContainer .fileTab").length) {
									$(".fileTabContainer .fileTab:last-child").click();
								} else {
									window.pathFile = null;
									window.loadFile = null;
									window.htmEditor.setValue("");
								}
								window.resizeDesktop();
							} else {
								delete window.listFilesWebmaster[$(aba).parent().attr("data-token")];
								$(aba).parent().remove();
								window.resizeTab()
								if (!$(".fileTabContainer .fileTab").length) {
									window.pathFile = null;
									window.loadFile = null;
									window.htmEditor.setValue("");
								}
								window.resizeDesktop();
							}
						}
					})
				};
				window.addTab = function($newTokenFile, $pathFile, $loadFile, $saved) {

					if (!$('.fileTabContainer .fileTab[data-pathFile="' + $pathFile + '"][data-loadFile="' + $loadFile + '"]').length) {
						$(".tabSortable.fileTab.loader").remove();
						$(".fileTab").removeClass("active");

						$(".fileTabContainer .container").prepend('<div '+
							'legenda="' +$pathFile.replace("<?=str_replace("\\","/",INCLUDE_PATH.'website')?>", "")+'" '+ 
							'class="tabSortable fileTab active ' + $saved + '" '+
							'data-token="' + $newTokenFile + '" '+
							'data-saved="true" '+
							'data-pathFile="' + $pathFile.replace($loadFile,"") + '" '+
							'data-loadFile="' + $loadFile + '"> '+
							'<div class="str">' + 
							$pathFile.replace("<?=str_replace("\\","/",INCLUDE_PATH.'website')?>", "")+'</div>'+
							'<div class="close"></div><div class="tab_shadow"></div><textarea style="display:none"></textarea> </div>');

						if ($(".fileTabContainer .container.ui-sortable").length) {
							$(".fileTabContainer .container").sortable("destroy");
						}
						$(".fileTabContainer .container").sortable({
							axis: "x",
							start: function(e, ui) {
							//	out($(ui.placeholder))
							},
							beforeStop: function(e, ui) {
							//	out($(ui.placeholder))
							}
						});
						$(".fileTabContainer .container").disableSelection();
					};
					window.funcTabs();
					window.resizeTab();
				}
				window.resizeTab = function() {
					var qtdd = $(".fileTabContainer .container .fileTab").length;
					var W_Aba = $(".fileTabContainer .fileTab").outerWidth();
					var W_Container = $(".fileTabContainer").width();
					var total_W_Abas = W_Aba * qtdd;
					$('.fileTabContainer .fileTab').attr("style", "width:calc((100% / " + qtdd + ") - " + (47) + "px)");
					$("*[legenda]").LegendaOver();
				}
				window.resizeDesktop = function() {
					window.htmEditor.resize();
					//	$(".ace_scrollbar").animate({scrollTop: 0}, 200);
				}
				ace.config.set('basePath', './app/vendor/ace/src-min-noconflict');// SETA LOCAL DOS ARQUIVOS DO EDITOR
				window.htmEditor = ace.edit("divEditor");
				window.htmEditor.setTheme("ace/theme/monokai");
				// window.htmEditor.setTheme("ace/theme/websheep.0.3");
				window.htmEditor.getSession().setMode("ace/mode/php");

				window.htmEditor.setShowPrintMargin(true); // mostra linha ativa atual
				window.htmEditor.setHighlightActiveLine(true); // mostra linha ativa atual
				window.htmEditor.setShowInvisibles(0); // frufru de tabulações
				window.htmEditor.getSession().setUseSoftTabs(false); // usar tabs ao invez de espaço
				//	window.htmEditor.setOptions({maxLines: Infinity,minLines: 1});
				window.htmEditor.setDisplayIndentGuides(true);
				window.htmEditor.getSession().setUseWrapMode(true);
				setTimeout(function() {
					var wsCompleter = {
						getCompletions: function(editor, session, pos, prefix, callback) {
							if (prefix.length === 0) {
								callback(null, []);
								return
							}
							$.getJSON("./app/modulos/webmaster/autoComplete.json", function(wordList) {
								callback(null, wordList.map(function(ea) {
									return {
										name: ea.value,
										value: ea.value,
										meta: ea.meta
									}
								}));
							})
						}
					}
					var langTools = ace.require("ace/ext/language_tools");
					langTools.setCompleters([langTools.snippetCompleter, langTools.textCompleter, wsCompleter])
					window.htmEditor.setOptions({
						enableBasicAutocompletion: false,
						enableSnippets: true,
						enableLiveAutocompletion: true
					});
					$('.chosen-results,.nave_folders').perfectScrollbar({suppressScrollX: true});
					//window.htmEditor.setReadOnly(true); sem editar
					// var UndoManager = require(["admin/app/modulos/webmaster/src-min-noconflict/ace"]).UndoManager
					window.htmEditor.getSession().getUndoManager().reset();
					window.htmEditor.on('change', function() {
						window.htmEditor.resize();
						$("#Balao_TollType").remove();
						if ($(document.activeElement).closest("div").attr("id") == "divEditor") {
							if (Object.keys(window.listFilesWebmaster).length) {
								window.listFilesWebmaster[window.newTokenFile].saved = 'unsave';
							}
							$('.fileTabContainer .fileTab[data-pathFile="' + window.pathFile + '"][data-loadFile="' + window.loadFile + '"]').removeClass('saved').addClass('unsave');
						}
					})

					if (!window.listFilesWebmaster) {
						window.listFilesWebmaster = Object();
					} else {
						$.each(window.listFilesWebmaster, function(index) {
							window.addTab(window.listFilesWebmaster[index].newTokenFile, window.listFilesWebmaster[index].pathFile, window.listFilesWebmaster[index].file, window.listFilesWebmaster[index].saved)
						});
						$('.fileTabContainer .fileTab.active').click();
					}
					<?
					// CASO TENHA ALGUM PATH DE ARQUIVO PARA ABRIR "LOAD" 
					if (isset($_GET['get_file']) && $_GET['get_file'] != ""): ?> setTimeout(function() {
						$(".file[data-file='<?=$_GET['get_file']?>']").click();
					}, 500); <? endif; ?>
				}, 1000);
				$("#Balao_TollType").remove();
				sanfona('.folder');
				$('.folder').click(function() {
					setTimeout(function() {
						$('.nave_folders,.chosen-results').perfectScrollbar('update');
					}, 500)
				})
				$("*[legenda]").LegendaOver();
				$("#bkpsFile").chosen({
					disable_search_threshold: 0
				}).change(function(e) {
					var token = $('#bkpsFile').chosen().val();
					if (token != "") {
						functions({
							funcao: "loadFileBKP",
							vars: "token=" + token + "&pathFile=" + window.pathFile.replace(window.loadFile, "/") + "&filename=" + window.loadFile,
							patch: "<? echo $session->get('_PATCH_');?>",
							Sucess: function(e) {
								eval(e);
							}
						});
					}
				});
				//####################################################################################  ALTERANDO O MODO E O ESTILO DO EDITOR
				$('#mode').chosen({
					disable_search_threshold: 5
				}).change(function(e) {
					e.preventDefault();
					var theme = $('#mode').chosen().val();
					window.htmEditor.setMode("ace/mode/" + theme);
				}).find("option[value='php']").attr("selected", "true").trigger("chosen:updated");
				setTimeout(function() {
						$('#sintaxy').unbind('tap click hover').bind('tap click', function() {
							$("#mode_chosen").addClass('chosen-container-active').addClass('chosen-with-drop');
							setTimeout(function() {$("#mode_chosen").find('.chosen-drop').mousedown();}, 500);
						})
						$('#version').unbind('tap click hover').bind('tap click', function() {
							$("#bkpsFile_chosen").addClass('chosen-container-active').addClass('chosen-with-drop');
							setTimeout(function() {
								$("#bkpsFile_chosen").find('.chosen-drop').mousedown();
							}, 500);
						})
					}, 1000)
					//####################################################################################  se alterar, precisa mudar no functiuons tb na função de checkin
				window.refreshClick = function() {
					$("#Balao_TollType").remove();
					$('.nave_folders,.chosen-results').perfectScrollbar('update');
					$(".container .new").unbind('tap press click').bind('tap press click', function() {
						$('#novoArquivo').click();
					})
					$('#addPagination').unbind('tap press click').bind('tap press click', function() {
						functions({
							funcao: "InsertPagination",
							vars: "",
							patch: "<?=$session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 700,
									height: 500,
									bot1: 'Inserir Código',
									bot2: 'Cancelar',
									drag: 0,
									botclose: 0,
									Check: function() {
										if (!$("#formTags input[type='radio']:checked") || $("#shortcodes").val() == "") {
											return false;
										} else {
											return true;
										}
									},
									ErrorCheck: function() {
										alert("Preencha tipo e ferramenta desejados");
									},
									posFn: function() {
										window.htmEditorPagination = ace.edit("editorHTML");
										window.htmEditorPagination.setTheme("ace/theme/websheep.0.3");
										window.htmEditorPagination.getSession().setMode("ace/mode/php");
										window.htmEditorPagination.setHighlightActiveLine(true);
										window.htmEditorPagination.setShowInvisibles(0);
										window.htmEditorPagination.getSession().setUseSoftTabs(false);
										window.htmEditorPagination.getSession().setUseWrapMode(true);
										window.htmEditorPagination.setOptions({maxLines: Infinity,minLines: 1});
										$(".chosen-results,.nave_folders").perfectScrollbar({suppressScrollX: true });
										window.htmEditorPagination.getSession().on('change', function(e) {
											$("textarea[name='editorHTML']").val(window.htmEditorPagination.getSession().getValue())
										})
										window.htmEditorPagination.getSession().setValue(decodeURIComponent($("textarea[name='editorHTML']").val()))
										window.htmEditorCountPage = ace.edit("editorCOUNT");
										window.htmEditorCountPage.setTheme("ace/theme/websheep.0.3");
										window.htmEditorCountPage.getSession().setMode("ace/mode/php");
										window.htmEditorCountPage.setHighlightActiveLine(true);
										window.htmEditorCountPage.setShowInvisibles(0);
										window.htmEditorCountPage.getSession().setUseWrapMode(true);
										window.htmEditorCountPage.getSession().setUseSoftTabs(false);
										$(".chosen-results,.nave_folders").perfectScrollbar({suppressScrollX: true });
										window.htmEditorCountPage.getSession().on('change', function(e) {
											$("textarea[name='editorCOUNT']").val(window.htmEditorCountPage.getSession().getValue())
										})
										window.htmEditorCountPage.getSession().setValue(decodeURIComponent($("textarea[name='editorCOUNT']").val()))
										window.htmEditorCountPage.setOptions({minLines:1});
										window.htmEditorCountPageActive = ace.edit("editorCOUNTactive");
										window.htmEditorCountPageActive.setTheme("ace/theme/websheep.0.3");
										window.htmEditorCountPageActive.getSession().setMode("ace/mode/php");
										window.htmEditorCountPageActive.setHighlightActiveLine(true);
										window.htmEditorCountPageActive.setShowInvisibles(0);
										window.htmEditorCountPageActive.getSession().setUseWrapMode(true);
										window.htmEditorCountPageActive.getSession().setUseSoftTabs(false);
										$(".chosen-results,.nave_folders").perfectScrollbar({suppressScrollX: true });
										window.htmEditorCountPageActive.getSession().on('change', function(e) {
											$("textarea[name='editorCOUNTactive']").val(window.htmEditorCountPageActive.getSession().getValue())
										})
										window.htmEditorCountPageActive.getSession().setValue(decodeURIComponent($("textarea[name='editorCOUNTactive']").val()))
										window.htmEditorCountPageActive.setOptions({
											maxLines: Infinity,
											minLines: 1
										});
									},
									newFun: function() {
										functions({
											funcao: "InsertPaginationCampos",
											vars: $("#formTags").serialize(),
											patch: "<?=$session->get('_PATCH_');?>",
											Sucess: function(e) {
												window.htmEditor.insert(e)
											}
										})
									}
								})
							}
						})
					})

					$('#formatHTML').unbind('tap press click').bind('tap press click', function() {
						confirma({
							conteudo: '<iframe id="bootstrap" src="./app/modulos/webmaster/formatter/index.php" width="100%" height="100%" scrolling="no"></iframe>',
							width: 600,
							height:370,
							bot1: 'Formatar',
							bot2: 'Cancelar',
							drag: 0,
							botclose: 0,
							posFn: function() {},
							newFun: function() {
									$('#bootstrap')[0].contentWindow.beautify();
							}
						})



						//window.htmEditor.setValue(ws.string.formatHTML(window.htmEditor.getValue()));
					})
					$('#templateBootstrap').unbind('tap press click').bind('tap press click', function() {
						confirma({
							conteudo: '<iframe id="bootstrap" src="./app/modulos/webmaster/templateBootstrap/index.php" width="100%" height="100%"></iframe>',
							width: 'calc(100% - 100px)',
							height: 'calc(100% - 100px)',
							bot1: 'Inserir',
							bot2: 'Cancelar',
							drag: 0,
							botclose: 0,
							posFn: function() {},
							newFun: function() {
								var $less = $("#bootstrap").contents().find(".html .output_container pre.mixins").text();
								var $code = $("#bootstrap").contents().find(".html .output_container pre.markup").text();
								var $insert = "<!--  LESS MIXINS --> \n " + $less + " \n <!--  END LESS MIXINS --> \n " + $code
								if ($less != "") {
									window.htmEditor.insert($insert);
								} else {
									window.htmEditor.insert($code);
								}
							}
						})
					})
					$('#addSendForm').unbind('tap press click').bind('tap press click', function() {
						functions({
							funcao: "InsertCodeForm",
							vars: "",
							patch: "<?=$session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 600,
									bot1: 'Inserir formulário',
									bot2: 'Cancelar',
									drag: 0,
									botclose: 0,
									Check: function() {
										if (!$("#formTags input[type='radio']:checked").val() || $("#shortcodes").val() == "") {
											return false;
										} else {
											return true;
										}
									},
									ErrorCheck: function() {
										TopAlert({
											mensagem: "Preencha tipo de envio desejado",
											type: 2
										});
									},
									posFn: function() {},
									newFun: function() {
										functions({
											funcao: "InsertCodeFormCampos",
											vars: $("#formTags").serialize(),
											patch: "<?=$session->get('_PATCH_');?>",
											Sucess: function(e) {
												window.htmEditor.insert(e)
											}
										})
									}
								})
							}
						})
					})


					$('#addToll').unbind('tap press click').bind('tap press click', function() {
						functions({
							funcao: "InsertCode",
							vars: "",
							patch: "<?=$session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 600,
									bot1: 'Inserir Código',
									bot2: 'Cancelar',
									drag: 0,
									botclose: 0,
									Check: function() {
										if (!$("#formTags input[type='radio']:checked") || $("#shortcodes").val() == "") {
											return false;
										} else {
											return true;
										}
									},
									ErrorCheck: function() {
										alert("Preencha tipo e ferramenta desejados");
									},
									posFn: function() {},
									newFun: function() {
										functions({
											funcao: "InsertCodeCampos",
											vars: $("#formTags").serialize(),
											patch: "<?=$session->get('_PATCH_');?>",
											Sucess: function(e) {
												window.htmEditor.insert(e)
											}
										})
									}
								})
							}
						})
					})
					$('#plugin').unbind('tap press click').bind('tap press click', function() {
						functions({
							funcao: "loadShortCodes",
							vars: "",
							patch: "<?=$session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 600,
									bot1: 'Inserir shortcode',
									bot2: 'Cancelar',
									drag: 0,
									botclose: 0,
									posFn: function() {

									},
									newFun: function() {
										var pathPlug = $("#shortcodes").val();
										$.ajax({
											type: "POST",
											url: "./app/modulos/webmaster/functions.php",
											data: {
												'function': 'getShortCodesPlugin',
												'path': pathPlug
											}
										}).done(function(data) {
											window.htmEditor.insert(data)
										});
									}
								})
							}
						})
					})

					$('#loadfile').unbind('tap click').bind('tap click', function() {
						if (!$("#palco").hasClass('recolhido')) {
							$("#palco, #divEditor").addClass("recolhido")
						} else {
							$("#palco, #divEditor").removeClass("recolhido")
						}
						if (!$(".nave_folders").hasClass('recolhido')) {
							$(".nave_folders").addClass("recolhido")
						} else {
							$(".nave_folders").removeClass("recolhido")
						}
						if (!$(".nave_menu").hasClass('recolhido')) {
							$(".nave_menu").addClass("recolhido")
						} else {
							$(".nave_menu").removeClass("recolhido")
						}
					})
					$('#novoArquivo').unbind('tap click').bind('tap click', function() {
						confirma({
							width: "auto",
							conteudo: "  Aguarde...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>",
							drag: false,
							bot1: 0,
							bot2: 0
						})
						window.pathFile = $(this).data("file");
						window.id_file_open = $(this).data("id");
						functions({
							funcao: "ListFolderNewFile",
							vars: "pathFile=0",
							patch: "<? echo $session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 500,
									bot1: "Criar arquivo",
									bot2: "Cancelar",
									drag: false,
									newFun: function() {
										var newFile = $("input.path").val();
										functions({
											funcao: "createFile",
											vars: "newFile=" + newFile,
											patch: "<? echo $session->get('_PATCH_');?>",
											Sucess: function(e) {
												if (e != "falha") {
													eval(e)
													functions({
														funcao: "refreshFolders",
														vars: "folders=1",
														patch: "<? echo $session->get('_PATCH_');?>",
														Sucess: function(e) {
															$("#nave_folders").html(e)
															window.refreshClick();
														}
													})
												}
											}
										});
									},
									posFn:function(){
										sanfona('.folder_alert');
										$(".nave_folders .folder_alert").bind("click tap press",function(){
											$(".nave_folders .folder_alert").css({"background-color":"transparent",color:"#9e9e9e","font-weight":500}).removeClass("selectExclude");
											$(this).css({"background-color":"#d4e1f4",color:"#497bbe","font-weight":600}).addClass("selectExclude")
											$(".ws_confirm_conteudo .inputText.path").val($(this).data("folder"))
										})
									}
								})
							}
						});
					});
					$('#novodir').unbind('tap click').bind('tap click', function() {
						confirma({
							width: "auto",
							conteudo: "  Aguarde...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>",
							drag: false,
							bot1: 0,
							bot2: 0
						})
						window.pathFile = $(this).data("file");
						window.id_file_open = $(this).data("id");
						functions({
							funcao: "ListFolderNewFolder",
							vars: "pathFile=0",
							patch: "<? echo $session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 500,
									bot1: "Criar arquivo",
									bot2: "Cancelar",
									drag: false,
									posFn:function() {
											$(".nave_folders .folder").click(function(){
												$(".ws_confirm_conteudo.w1 .inputText.path").val($(this).data("folder"))
											})
									},
									newFun: function() {
										var newFile = $("input.path").val();
										functions({
											funcao: "createFolder",
											vars: "newFile=" + newFile,
											patch: "<? echo $session->get('_PATCH_');?>",
											Sucess: function(e) {
												out(e)
												if (e == "sucesso") {
													TopAlert({
														mensagem: "Diretório criado com sucesso!",
														type: 3
													});
													functions({
														funcao: "refreshFolders",
														vars: "folders=1",
														patch: "<? echo $session->get('_PATCH_');?>",
														Sucess: function(e) {
															$("#nave_folders").html(e)
															window.refreshClick();
														}
													})
												}
											}
										});
									},
									onCancel: function() {}
								})
							}
						});
					});

					$('#exclFile').unbind('tap click').bind('tap click', function() {
						confirma({
							conteudo: "Você tem <b>CERTEZA</b> de que gostaria de excluir esse arquivo?<br><div class='bg08' style='position: relative;margin: 10px;padding: 20px;color: #F00;'>1 • Todos os BKPs deste arquivo também serão apagados.<br>2 • E lembre-se, esta ação <b>NÃO</b> terá mais volta.</div>",
							width: 500,
							bot1: "Sim tenho certeza",
							bot2: "Cancelar",
							drag: false,
							newFun: function() {
								functions({
									funcao: "exclui_file",
									vars: "&pathFile=" + window.pathFile + "&loadFile=" + window.loadFile,
									patch: "<? echo $session->get('_PATCH_');?>",
									beforeSend: function() {
										confirma({
											width: "auto",
											conteudo: "  Excluindo...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>",
											drag: false,
											bot1: 0,
											bot2: 0
										})
									},
									Sucess: function(e) {
										out(e)
										eval(e);
										functions({
											funcao: "refreshFolders",
											vars: "folders=1",
											patch: "<? echo $session->get('_PATCH_');?>",
											Sucess: function(e) {
												$("#nave_folders").html(e)
												window.refreshClick();
											}
										})
//										$(".ferramenta_especial[data-path='<?=ROOT_WEBSHEEP?>admin/app/modulos/webmaster/index.php']").click();
									}
								});
							}
						})
					});
					$('#exclFolder').unbind('tap click').bind('tap click', function() {
						confirma({
							width: "auto",
							conteudo: "  Aguarde...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>",
							drag: false,
							bot1: 0,
							bot2: 0
						})
						window.pathFile = $(this).data("file");
						window.id_file_open = $(this).data("id");
						functions({
							funcao: "ListFolderExclFolder",
							vars: "_excl_dir_=0",
							patch: "<? echo $session->get('_PATCH_');?>",
							Sucess: function(e) {
								confirma({
									conteudo: e,
									width: 500,
									bot1: "Excluir folder",
									bot2: "Cancelar",
									drag: false,
									newFun: function() {
										var excluiFolder = $('.selectExclude').data('folder');
										setTimeout(function() {
											confirma({
												conteudo: "Você tem <b>CERTEZA</b> de que quer excluir o diretório: <br> <b>"+excluiFolder+"?<br><div class=\"bg08\" style=\"padding: 10px 60px; margin: 10px; color: #D80000;\">Lembre-se, esta ação <b>NÃO</b> terá mais volta.</div>",
												width: 500,
												bot1: "Sim tenho certeza",
												bot2: "Cancelar",
												drag: false,
												newFun: function() {
													functions({
														funcao: "_excl_dir_",
														vars: "exclFolder=" + excluiFolder,
														patch: "<? echo $session->get('_PATCH_');?>",
														beforeSend: function() {
															confirma({
																width: "auto",
																conteudo: "  Excluindo...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>",
																drag: false,
																bot1: 0,
																bot2: 0
															})
														},
														Sucess: function(e) {
															if(e==1){
																functions({
																	funcao: "refreshFolders",
																	vars: "var=0",
																	patch: "<? echo $session->get('_PATCH_');?>",
																	Sucess: function(e) {
																		$("#nave_folders").html(e)
																		window.refreshClick();
																		$("#ws_confirm").remove();
																		$("#body").removeClass("scrollhidden");
																		$("*").removeClass("blur");
																	}
																})
																TopAlert({mensagem: "Diretório excluído com sucesso!",type:3});
															}else{
																TopAlert({mensagem:e,type:2});
															}
														}
													});
												},
												posFn:function() {}
											})
										}, 500)
									},
									posFn:function(){
										sanfona('.folder_alert');
										$(".nave_folders .folder_alert").bind("click tap press",function(){
											$(".nave_folders .folder_alert").css({"background-color":"transparent",color:"#9e9e9e","font-weight":500}).removeClass("selectExclude");
											$(this).css({"background-color":"#d4e1f4",color:"#497bbe","font-weight":600}).addClass("selectExclude")
											$(".nave_folders .container").css({"background-color":"transparent",color:"#9e9e9e","font-weight":500});
											$(this).next().css({"background-color":"#d4e1f4",color:"#497bbe","font-weight":600})												
										})
									}
								})
							}
						});
					});
					$('.nave_folders .file').unbind('tap click').bind('tap click', function() {
						window.pathFile = $(this).data("file").split("\\").join("/");
						$("#exclFile").show();
						$("#palco, #divEditor ,.nave_folders,.nave_menu").addClass("recolhido")

						if (!$('.fileTabContainer .fileTab[data-pathFile="' + window.pathFile + '"][data-loadFile="' + window.loadFile + '"]').length) {
							functions({
								funcao: "loadFile",
								vars: "pathFile=" + window.pathFile,
								patch: "<? echo $session->get('_PATCH_');?>",
								beforeSend: function() {
									$(".fileTabContainer").prepend('<div class="tabSortable fileTab loader"></div>');
								},
								Sucess: function(e) {
									eval(e);
									$(".tabSortable.fileTab.loader").remove();
									functions({
										funcao: "returnBKP",
										vars: "pathFile=" + window.pathFile.replace(window.loadFile, "/") + "&filename=" + window.loadFile,
										patch: "<? echo $session->get('_PATCH_');?>",
										Sucess: function(e) {
											$("#bkpsFile").html(e).trigger("chosen:updated");
											$("#ws_confirm").remove();
											$("#body").removeClass("scrollhidden");
											$("*").removeClass("blur");
										}
									})
								}
							});
						} else {
							$('.fileTabContainer .fileTab[data-pathFile="' + window.pathFile + '"][data-loadFile="' + window.loadFile + '"]').click();
						}
					});
					$('#salvarArquivo').unbind('tap click').bind('tap click', function() {
						//window.newTokenFile	
						//window.loadFile
						//window.typeLoaded
						var ConteudoDoc = encodeURIComponent(window.htmEditor.getValue())
						//out(ConteudoDoc)
						//out(window.pathFile)
						//out(window.loadFile)
						var GET = "pathFile=" + window.pathFile.replace(window.loadFile,"") + "&filename=" + window.loadFile + "&token=" + window.newTokenFile + "&ConteudoDoc=" + ConteudoDoc;
						$.ajax({
							type: "POST",
							url: "./app/modulos/webmaster/functions.php",
							beforeSend:function(){
									confirma({width: "auto", conteudo: "  Salvando...<div class=\'preloaderupdate\' style=\'left: 50%;margin-left: -15px; position: absolute;width: 30px;height: 18px;top: 53px;background-image:url(\"<?=ws::rootPath?>admin/app/templates/img/websheep/loader_thumb.gif\");background-repeat:no-repeat;background-position: top center;\'></div>", drag: false, bot1: 0, bot2: 0 })
							},
							data: {
								'function'	: 'geraBKPeAplica',
								'bkp'		: 'false',
								'GET'		:  GET,
							}
						}).done(function(e) {
								out(e);
								if (e == "sucesso") {
									$("#ws_confirm").remove();
									$("#body").removeClass("scrollhidden");
									$("*").removeClass("blur");
									window.listFilesWebmaster[window.newTokenFile].saved = 'saved';
									$('.fileTab[data-pathFile="' + window.pathFile + '"][data-loadFile="' + window.loadFile + '"]').removeClass('unsave').addClass('saved')
									if (window.closeToSave == true) {
										window.closeToSave = false;
										$('.fileTab[data-pathFile="' + window.pathFile + '"][data-loadFile="' + window.loadFile + '"] .close').click();
									}
									TopAlert({
										mensagem: "Arquivo atualizado com sucesso!",
										type: 3
									});
								};
						});
					});
					$(window).resize(function() {
						window.htmEditor.resize();
						$('.nave_folders,.chosen-results').perfectScrollbar('update');
					});
					$('#container').perfectScrollbar("destroy");
				}
				window.refreshClick();
				//#################################################################################################################################################
		});
	});
})
</script>
</div>
<div class="c"></div>
</div>
