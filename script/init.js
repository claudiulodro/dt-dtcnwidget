function edit_link_select(link) {
	var link_text = document.getElementById('link_text');
	if(link_text) {
	  link_text.value = link;
	}

	return true;
}

function edit_link_edit() {
	var link_text_radio = document.getElementById('link_text_radio');
	if(link_text_radio) {
	  link_text_radio.checked = true;
	}
	return false;
}




