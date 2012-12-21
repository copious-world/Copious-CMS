<?php

	include "../admin_header.php";

	$name = $_POST['name'];
	$has_value = $_POST['has_value'];

	function revision_history($name) {
		$QQ = "SELECT date FROM rolled_oats WHERE name ='$name'";
		$predate = db_query_value($QQ);
		$II = "insert into rolled_oats_history (name,date) VALUES ('$name','$predate')";
		db_query_exe($II);
	}


	$_POST['javascript_cb'] = majic_quotes($_POST['javascript_cb']);
	$_POST['javascript_check_limits'] = majic_quotes($_POST['javascript_check_limits']);
	$_POST['javascript_data_rep'] = majic_quotes($_POST['javascript_data_rep']);
	$_POST['javascript_render_data'] = majic_quotes( $_POST['javascript_render_data']);
	$_POST['javascript_searcher'] = majic_quotes($_POST['javascript_searcher']);
	$_POST['javascript_searcher_html'] = majic_quotes($_POST['javascript_searcher_html']);

	$_POST['element'] = majic_quotes($_POST['element']);
	$_POST['presentation'] = majic_quotes($_POST['presentation']);
	///
	$_POST['substitution_vars'] = majic_quotes($_POST['substitution_vars']);


	$javascript_cb = ($_POST['javascript_cb']);
	$javascript_check_limits = ($_POST['javascript_check_limits']);
	$javascript_data_rep = ($_POST['javascript_data_rep']);
	$javascript_render_data = ($_POST['javascript_render_data']);
	$javascript_searcher = ($_POST['javascript_searcher']);
	$javascript_searcher_html = ($_POST['javascript_searcher_html']);

	$element = ($_POST['element']);
	$presentation = ($_POST['presentation']);
	///
	$element_list = ($_POST['element_list']);
	$substitution_vars = ($_POST['substitution_vars']);
	///
	$required_source_url = $_POST['required_source_url'];
	$data_source_parameters = $_POST['data_source_parameters'];
	$remote = $_POST['remote'];
	$valsource = $_POST['valsource'];
	$valparameters = $_POST['valparameters'];
	$author = $_POST['author'];
	$author_email = $_POST['author_email'];

	$javascript_cb = urlencode($javascript_cb);
	$javascript_check_limits = urlencode($javascript_check_limits);
	$javascript_data_rep = urlencode($javascript_data_rep);
	$javascript_render_data = urlencode($javascript_render_data);
	$javascript_searcher = urlencode($javascript_searcher);
	$javascript_searcher_html = urlencode($javascript_searcher_html);

	$element = urlencode($element);
	$presentation = urlencode($presentation);

	$QQ = "SELECT count(*) FROM rolled_oats WHERE name = '$name'";
	$n = db_query_value($QQ);

	$now = datetime();

	if ( $n == 0 ) {
		$QQ = "insert into rolled_oats (name,classified,date, cloneable,javascript_cb,javascript_check_limits,javascript_data_rep,javascript_render_data,javascript_searcher, element, presentation, element_list, substitution_vars, data_source_parameters, datasource, author, author_email, required_source_url, remote_validation, validation_source, validation_parameters,search_html ) VALUES ('$name',0,'$now', '0','$javascript_cb','$javascript_check_limits','$javascript_data_rep','$javascript_render_data','$javascript_searcher','$element', '$presentation', '$element_list' '$data_source_parameters', '$datasource', '$author', '$author_email', '$required_source_url', '$remote_validation', '$validation_source', '$validation_parameters','$javascript_searcher_html')";
	} else {
		revision_history($name);

		$QQ = "update rolled_oats
					set javascript_cb = '$javascript_cb',
					date = '$now',
					javascript_check_limits = '$javascript_check_limits',
					javascript_data_rep = '$javascript_data_rep',
					javascript_render_data = '$javascript_render_data',
					javascript_searcher = '$javascript_searcher',
					element = '$element',
					presentation = '$presentation',
					element_list = '$element_list',
					substitution_vars = '$substitution_vars',
					data_source_parameters = '$data_source_parameters',
					datasource = '$datasource', author = '$author', author_email = '$author_email',
					required_source_url = '$required_source_url', remote_validation = '$remote_validation', validation_source = '$validation_source',
					validation_parameters = '$validation_parameters', search_html = '$javascript_searcher_html'  where name = '$name' ";
	}

	db_query_exe($QQ);

?>
Rolled Oat <?php echo $name . " save at " . $now; ?>