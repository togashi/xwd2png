<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>xwd2png</title>

	<style>
	    #drop {
		height: 5em;
		text-align: center;
		line-height: 5em;
		cursor: default;
		border: 5px silver dotted;
		border-radius: 1em;
		font-size: 2em;
		font-weight: bolder;
		color: silver;
		margin-bottom: 1em;
	    }

	    #results {
		overflow: auto;
	    }

	    #results img {
		float: left;
		margin: 1em 2.4%;
		width: 20%;
		background-color: #ddd;
		border: transparent 1px solid;
		background-image: none;
	    }

	    #results img.processing {
		height: 10em;
		border-color: gray;
		background-image: url("data:image/gif;base64,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");
		background-position: center;
		background-repeat: no-repeat;
		background-size: 1em;
	    }
	</style>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	    function loadFile(f) {
		var def = $.Deferred();
		var reader = new FileReader();
		reader.onload = function(e) {
		    var blob = new Blob([e.target.result], { type: "application/octet-stream" });
		    def.resolve(blob);
		};
		reader.onerror = function(e) {
		    def.reject();
		};
		reader.readAsArrayBuffer(f);
		return def.promise();
	    }

	    function convert(bin, name) {
		var def = $.Deferred();

		var fd = new FormData();
		name && fd.append("filename", name);
		fd.append("format", "data");
		fd.append("xwd", bin);

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(e) {
		    if (xhr.readyState !== 4) return;
		    if (xhr.status && Math.floor(xhr.status / 100) === 2) {
			def.resolve(xhr.responseText);
		    } else {
			def.reject();
		    }
		};
		xhr.open("POST", "xwd2png.php", true);
		xhr.send(fd);
		return def.promise();
	    }

	    function processFile(file) {
		var name = file.name;
		var elm = $("<img>")
			.attr("alt", name)
			.attr("title", name)
			.addClass("processing")
			.appendTo("#results");
		$.when(loadFile(file)).then(function(bin) {
		    return convert(bin, name);
		}).done(function(d) {
		    elm.attr("src", d).removeClass("processing");
		});
	    }

	    function dragOver(e) {
		e.stopPropagation();
		e.preventDefault();
		e.originalEvent.dataTransfer.dropEffect = "copy";
	    }

	    function drop(e) {
		e.stopPropagation();
		e.preventDefault();

		var fs = e.originalEvent.dataTransfer.files;
		for (var i = 0, x = fs.length; i < x; i++) {
		    processFile(fs[i]);
		}
	    }

	    $(document).ready(function(e) {
		$("#drop").bind("dragover", dragOver).bind("drop", drop);
	    });
	</script>
    </head>
    <body>
	<div id="drop">
	    Drop .xwd file(s) to HERE.
	</div>
	<div id="results"></div>
    </body>
</html>
