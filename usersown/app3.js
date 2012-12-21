

g_tree_containers = {
		content_type_area1:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				g_tree_containers.content_type_area1.tree = tree;
				g_content_rw_state = "W";

				var accessor = g_ct_access_list["content_type_area1"];

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var node = element_list[i];
					var name = node.getLabel();

					if ( ( accessor == null ) || accessor.hasOwnProperty(name) ) {
						var fetch_fields = (function(term,taxo) {
									return(function(){ get_form(term,taxo,'content','formDepositorDiv'); });
								})(name,g_vocname);
						OAT.Dom.attach(node._div,"click",fetch_fields);
						/// TURN THIS INTO A CLASS NAME
						node._label.style.cursor = "pointer";
						node._label.style.border = "1px solid navy";
						node._label.style.backgroundColor = "#EFFFEF";
						node._label.style.paddingLeft = "4px";
						node._label.style.paddingRight = "4px";
						node._label.style.color = "darkgreen";
					} else {
						node._label.style.backgroundColor = "lightgrey";
						node._label.style.color = "gray";
					} 
				}

				tree.walk("toggleSelect");
			}
		},
		content_type_area2:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				g_tree_containers.content_type_area2.tree = tree;
				g_content_rw_state = "R";

				var accessor = g_ct_access_list["content_type_area2"];

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var name = element_list[i]._label.innerHTML;
					var node = element_list[i];

					if ( ( accessor == null ) || accessor.hasOwnProperty(name) ) {
						parameters = "'" + name + "','" + g_vocname + "'";
						var newhtml = "<input type='submit' class='buttonLike' value='" + name + "' onclick=\"get_form(" + parameters + ",'search','formDepositorDiv');\">";
						element_list[i]._label.innerHTML = newhtml;
						element_list[i]._label.style.cursor = "pointer";
					} else {
						node._label.style.backgroundColor = "lightgrey";
						node._label.style.color = "gray";
					} 
				}
				tree.walk("toggleSelect");
			}
		},
		content_type_area3:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				g_tree_containers.content_type_area3.tree = tree;
				g_content_rw_state = "W";

				var accessor = g_ct_access_list["content_type_area3"];

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var name = element_list[i]._label.innerHTML;
					var node = element_list[i];
					if ( ( accessor == null ) || accessor.hasOwnProperty(name) ) {
						parameters = "'" + name + "','" + g_vocname + "'";
						var newhtml = "<input type='submit' class='buttonLike' value='" + name + "' onclick=\"get_publication_list(" + parameters + ",'Publication_SelectionList','formDepositorDiv');\">";
						element_list[i]._label.innerHTML = newhtml;
						element_list[i]._label.style.cursor = "pointer";
					} else {
						node._label.style.backgroundColor = "lightgrey";
						node._label.style.color = "gray";
					} 
				}
				tree.walk("toggleSelect");
			}
		}
	};



