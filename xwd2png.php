<?php
    $fmt = @$_REQUEST["format"];
    $fn = @$_REQUEST["filename"];
    $xwd = $_FILES["xwd"];
    if (!$fn) {
	$fn = @$xwd["name"];
    }
    // convert to PNG
    $cmd = "/usr/bin/convert " . $xwd["tmp_name"] . " PNG:-";
    $cv = popen($cmd, "r");
    $png = stream_get_contents($cv);
    pclose($cv);

    // write down to file
    $fn = str_replace("/", "_", $fn);
    $fn = preg_replace('/\\.xwd$/', ".png", $fn);
    if (!preg_match('/\\.png$/', $fn)) {
	$fn .= ".png";
    }
    $path = dirname($_SERVER["SCRIPT_FILENAME"]) . "/output";
    if (!file_exists($path)) {
	mkdir($path);
    }
    $path .= "/" . $fn;
    file_put_contents($path, $png);
    error_log($path);

    // send response
    if ($fmt == "data") {
	header("Content-Type: text/plain");
	print "data:image/png;base64," . base64_encode($png);
    } else {
	header("Content-Type: image/png");
	print $png;
    }
?>
