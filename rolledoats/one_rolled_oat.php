<?php

include "../admin_header.php";


	$name = $_GET['name'];

/*
	$rolled_oats_source = apc_fetch("all_rolled_oats");
	$data = $rolled_oats_source->$name;
*/

$QQ = "SELECT * FROM rolled_oats WHERE name = '$name'";
$data = db_query_object($QQ);

$data->javascript_cb = str_replace("+"," ",$data->javascript_cb_);
$data->javascript_check_limits = str_replace("+"," ",$data->javascript_check_limits);
$data->javascript_data_rep = str_replace("+"," ",$data->javascript_data_rep);
$data->javascript_render_data = str_replace("+"," ",$data->javascript_render_data);
$data->javascript_searcher = str_replace("+"," ",$data->javascript_searcher);
$data->javascript_searcher_html = str_replace("+"," ",$data->javascript_searcher_html);
$data->required_source_url = str_replace("+"," ",$data->required_source_url);
$data->element = str_replace("+"," ",$data->element);
$data->data_source_parameters = str_replace("+"," ",$data->data_source_parameters);
$data->valparameters = str_replace("+"," ",$data->valparameters);
$data->presentation = str_replace("+"," ",$data->presentation);

/// required_source_url (not incorporated)

$output =<<<EOFJS
set_form_values({ prefix: 'rolled_oat',
					 elements: [
							{id: 'name', value: '$data->name', type: 'text' },
							{id: 'javascript_cb', value: decodeURIComponent('$data->javascript_cb'), type: 'textarea' },
							{id: 'javascript_check_limits', value: decodeURIComponent('$data->javascript_check_limits'), type: 'textarea' },
							{id: 'javascript_data_rep', value: decodeURIComponent('$data->javascript_data_rep'), type: 'textarea' },
							{id: 'javascript_render_data', value: decodeURIComponent('$data->javascript_render_data'), type: 'textarea' },
							{id: 'javascript_searcher', value: decodeURIComponent('$data->javascript_searcher'), type: 'textarea' },
							{id: 'javascript_searcher_html', value: decodeURIComponent('$data->javascript_searcher_html'), type: 'textarea' },
							{id: 'required_source_url', value: decodeURIComponent('$data->required_source_url'), type: 'textarea' },
							{id: 'element', value: decodeURIComponent('$data->element'), type: 'textarea' },
							{id: 'cloneable', value: '$data->cloneable', type: 'checkbox'  },
							{id: 'datasource', value: '$data->datasource', type: 'text' },
							{id: 'data_source_parameters', value: decodeURIComponent('$data->data_source_parameters'), type: 'textarea' },
							{id: 'remote', value: '$data->remote_validation', type: 'checkbox' },
							{id: 'valsource', value: '$data->validation_source', type: 'text' },
							{id: 'valparameters', value: decodeURIComponent('$data->validation_parameters'), type: 'text' },
							{id: 'author', value: '$data->author', type: 'text' },
							{id: 'author_email', value: '$data->author_email', type: 'text' },
							{id: 'presentation', value:  decodeURIComponent('$data->presentation'), type: 'text' }
						]
						});
EOFJS;

echo $output;
?>
