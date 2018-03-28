<?php 

//functions
/**
 * utility to make a select option stick after submitting a form
 * $field = string. The name of the field in question
 */
function select_it($field, $value){
	if($field == $value){
		echo 'selected';
	}
}

/**
 * utility to style a field that is causing an error
 * $field = string. name of field
 * $array = array. a list of fields with errors
 */

function inline_error($field, $array){
	if(isset($array)){
		if(array_key_exists($field, $array)){
			echo 'class="error"';
		}
	}
}


//no close php