
function open_cost_window(name,price)
{
	var book_url = name;

	var win = window.open(book_url, "Book", "width=400,height=400,scrollbars");
}

function book_approval(name,price)
{
	open_cost_window(name,price);
}



// g_product_list is defined in the page and not here.
// This uses it.


function updateproducts() {
/*
	var productSender = encodeURIComponent(g_product_list);
	makeDocEvalRequest(g_store_uri + "/productupdate.php?products=" + productSender + "&sess=" + g_user_sessionID );
*/
}


function updateproductsHandler(productlist) {

alert(productlist);

	for ( var prd in productlist ) {
		var pdata = productlist[prd];
		var dataContainer = "count_" + prd;
		$(dataContainer).innerHTML = pdata.count;
		dataContainer = "price_" + prd;
		$(dataContainer).innerHTML = pdata.count;
	}
}







// Sign up for a CartStart shopping cart...
function cartgrabbing() {
}


function cartSender(productName,price) {
	var where = document.location.toString();
	////
	where = where.substring(0,where.lastIndexOf("/")+1);

	where = encodeURIComponent(where);
	////
	var callpage = g_store_uri + "/productrequester.php?sess=" + g_user_sessionID + "&price=" + price + "&product=" + productName + "&page=" + where;

	makeDocEvalRequest(callpage);
}




