var input_file_fields = 1;

function add_file_input(e) {
	if(e.name == "file"+input_file_fields) {
		++input_file_fields;
		var newInput = document.createElement("input");
		newInput.type = "file";
		newInput.name = "file" + input_file_fields;
		newInput.setAttribute("onchange", "add_file_input(this)");
		var form = document.getElementsByTagName("form")[0];
		var sub = document.getElementById("sub");
		form.insertBefore(newInput, sub);
		form.insertBefore(document.createElement("br"), sub);
	}
}