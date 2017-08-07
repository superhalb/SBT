function removeFile( id ) {
	var _filedisplay = document.getElementById("id-"+id);
	_filedisplay.parentNode.removeChild(_filedisplay);
	var _fileinput = document.getElementById("file-"+id);
	_fileinput.parentNode.removeChild(_fileinput);
}

function addFile( input ) {
	var _files = document.getElementsByClassName('attachbutton');
	for ( var i = 0; i < _files.length; ++i ) {
		if ( _files[i].getAttribute("class") !== "hide" ) {
			var _id = (new Date()).getTime();
			_files[i].setAttribute("id","file-"+_id);
			_files[i].setAttribute("class","hide");
			var filename = input.value.replace(/^.*[\\\/]/, '');
			var _attachs = document.getElementById('attachs');
			var _div = document.createElement('div');
			_div.setAttribute("class","fileattached");
			_div.setAttribute("id", "id-" + _id);
			var _text = document.createTextNode( filename + " - ");
			_div.appendChild(_text);
			var _remover = document.createElement('a');
			_remover.setAttribute( "class" , "attachremover" );
			_remover.setAttribute( "href" ,"javascript:removeFile('" + _id + "')");
			_text = document.createTextNode( 'remove' )
			_remover.appendChild(_text);
			_div.appendChild(_remover);
			_attachs.appendChild(_div);
		}
	}
	var _label = document.createElement('label');
	_label.setAttribute("class","attachbutton");
	var _input = document.createElement('input');
	_input.setAttribute("type","file");
	_input.setAttribute("name","attach[]");
	_input.setAttribute("onchange","javascript:addFile(this)");
	_label.appendChild(_input);
	_text = document.createTextNode( 'attach other file' )
	_label.appendChild(_text);
	_attachs.appendChild(_label);
}