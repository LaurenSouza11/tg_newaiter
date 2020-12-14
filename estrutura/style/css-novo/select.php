<?

// ==========================================
//               FUNCTION SELECT
// ==========================================
// FONTE: https://adminlte.io/themes/dev/AdminLTE/pages/forms/general.html

function select($name, $labelIcon, $labelText, $valueId, $value, $opt_value, $opt, $title, $placeHolder, $validate, $required, $event) {

	// ***** ELEMENTOS DO SELECT
	
	// LABEL
	if ($labelText != '' and $labelIcon != '') {
		$label = "<label class='col-form-label' for='".$valueId."'><i class='".$labelIcon."'></i>&nbsp;".$labelText."</label>";	
	} else {
		$label = '';
	}

	// REQUIRED
	if ($required == 1) {
		$required = 'required';
	} else {
		$required = '';	
	}

	// VALIDATE
	if ($validate == 1) {
		if ($event != '') {
			$validate = " onChange=\"".$event."\";";
		} else {
			$validate = "onKeyUp='valida_".$name."();' onChange='valida_".$name."();'";
		}	
	} else {
		$validate = '';
	}	

	// OPÇÕES
	$count = 0;
	$lista_opcoes = '';

	foreach($opt as $lista_opt){
		$count = $count + 1;	
		$countS = $count - 1;
		$lista_opcoes = $lista_opcoes."<option id='".$name.$count."' value='".$opt_value[$countS]."'>".$lista_opt."</option>";		
	}

	$count = $count + 1;

	// ***** VALIDAÇÃO
	
	$javascript = "
	<script>

		function valida_".$name."() {

			var ".$name." = document.getElementById('".$name."').value;

			if (".$name.".length >='1') {
				document.getElementById('".$name."').className = 'form-control is-valid';
			} else {
				document.getElementById('".$name."').className = 'form-control is-invalid';
			}
			
		}	
	
	</script>";	
	
	// ***** RESUMO DOS ELEMENTOS DO SELECT + VALIDAÇÃO

	$select = "
	<div class='form-group'>
		<label class='col-form-label' for='".$valueId."'><i class='".$labelIcon."'></i>&nbsp;".$labelText."</label>
		<select class='form-control is-invalid' name='".$name."' id='".$name."' title='".$title."'".$validate." ".$required.">
			<option id='".$name.$count."' value='".$valueId."' SELECTED>".$value."</option>".
			$lista_opcoes.
		"</select>
	</div>".$javascript;

	return $select;						

}

?>