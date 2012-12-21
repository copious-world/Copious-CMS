<?php


	$name = $_GET['name'];

	$rolled_oats_source = apc_fetch("all_rolled_oats");


	$data = $rolled_oats_source->$name;


/// required_source_url (not incorporated)

$output =<<<EOFJS
set_form_values({ prefix: 'rolled_oat',
					 elements: [
							{id: 'name', value: '$data->name', type: 'checkbox' },
							{id: 'javascript', value: decodeURIComponent('$data->java_script'), type: 'textarea' },
							{id: 'codepart', value: decodeURIComponent('$data->element'), type: 'textarea' },
							{id: 'cloneable', value: '$data->cloneable', type: 'checkbox'  },
							{id: 'datasource', value: '$data->datasource', type: 'text' },
							{id: 'data_source_parameters', value: decodeURIComponent('$data->data_source_parameters'), type: 'textarea' },
							{id: 'remote', value: '$data->remote_validation', type: 'checkbox' },
							{id: 'valsource', value: '$data->validation_source', type: 'text' },
							{id: 'valparameters', value: decodeURIComponent('$data->validation_parameters'), type: 'text' },
							{id: 'author', value: '$data->author', type: 'text' },
							{id: 'author_email', value: '$data->author_email', type: 'text' }
						]
						});
EOFJS;


echo $output;
?>


