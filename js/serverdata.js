/////////////////===========================================================

var spanID;
var save_responder_element;

var server_locus;
var focus_locus;
var server_details_locus;
var admin_locus;
var manager_locus;

var tree_locus;
var taxonomy_locus;
var word_locus;
var taxonomy_ops;
var publication_locus;
var community_reports;

var form_locus;
var theme_locus;
var rolled_oats_locus;
var role_ops;
var usersown;


var locusfront = "http://localhost";

if ( homevars != null ) {
	locusfront = basiclocus.substring(basiclocus.lastIndexOf("//")+2);
	locusfront = "http://" + locusfront.substring(0,locusfront.indexOf("/"));
}

tree_locus = locusfront + "/hosted@appfetchmenu.php";
community_reports = locusfront + "/drupal/";
///

server_locus = "/docclassifiedserver/searcher.php?sectionNum=";
focus_locus = "/docclassifiedserver/focussearcher.php?sectionNum=";
server_details_locus = "/docclassifiedserver/details.php?entrynumber=";
admin_locus = "/docclassifiedserver/manager.php?classicommand=";
manager_locus = "/docclassifiedserver/manager/";
//
taxonomy_locus =	locusfront + "/hosted/taxonomy/fetchtaxonomy.php";
word_locus =		locusfront + "/hosted/taxonomy/fetchwords.php";
publication_locus =	locusfront + "/fetch.php";
//
taxonomy_ops =		locusfront + "/hosted/taxonomy/";
form_locus =		locusfront + "/hosted/contenttypes/";
theme_locus =		locusfront + "/hosted/themes/";
forum_locus =		locusfront + "/hosted/forums/";
poll_locus =		locusfront + "/hosted/polls/";
role_ops =			locusfront + "/hosted/accounttype/";
rolled_oats_locus =	locusfront + "/hosted/rolledoats/";
usersown =			locusfront + "/hosted/usersown/";
//
spanID = "docpages";
save_responder_element = "docpages";

/////////////////===========================================================
