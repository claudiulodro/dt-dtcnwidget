var dtcn = {

	data: [],

	itemStyle: "width:33%;float:left;",
	divStyle: "width:100%;border:1px solid black;",

	init: function( elId ){
		var self = this;

		if( typeof( elId ) === 'undefined' )
			return;

		xmlhttp=new XMLHttpRequest();
		xmlhttp.open("GET","http://local.dtcnwidget.com/out/rss.php?v=2",true);

		xmlhttp.onload = function(evt){
			if( xmlhttp.readyState == 4 ){
				self.data = xmlhttp.responseXML.getElementsByTagName('item');
				self.render( elId );
			}
			else {
				console.log( xmlhttp.statusText );
			}
		};

		xmlhttp.onerror = function(evt){
			console.log( xmlhttp.statusText );
		};

		xmlhttp.send();

	},

	render: function( elId ){

		var el = document.getElementById( elId );
		if( !el )
			return;

		if( !this.data.length )
			el.parentNode.removeChild( el );

		var items = this.getItems( 3 );
console.log(items);

		el.innerHTML = "<div style=" + this.divStyle + ">";
		for( var i = 0; i < items.length; ++i ){
			el.innerHTML += "<div style=" + this.itemStyle + "><a href='"+items[i].url+"'>"+items[i].name+"</a></div>";
		}
		el.innerHTML += "<div>";

	},

	getItems: function( num ){

		var numToGet = Math.min( num, this.data.length );
		var items = [];

		for( var i = 0; i < numToGet; ++i ){
			var current_item = this.data[i];

			items.push({
				'name': current_item.getElementsByTagName("title")[0].innerHTML,
				'url': current_item.getElementsByTagName("link")[0].innerHTML
			});
		}

		return items;
	}

}

