<?php
header("Content-Type: text/event-stream\n\n");

$url = $_GET['video'];

$cmd = "youtube-dl -f '(bestvideo[vcodec^=av01][height>=1080][fps>30]/bestvideo[vcodec=vp9.2][height>=1080][fps>30]/bestvideo[vcodec=vp9][height>=1080][fps>30]/bestvideo[vcodec^=av01][height>=1080]/bestvideo[vcodec=vp9.2][height>=1080]/bestvideo[vcodec=vp9][height>=1080]/bestvideo[height>=1080]/bestvideo[vcodec^=av01][height>=720][fps>30]/bestvideo[vcodec=vp9.2][height>=720][fps>30]/bestvideo[vcodec=vp9][height>=720][fps>30]/bestvideo[vcodec^=av01][height>=720]/bestvideo[vcodec=vp9.2][height>=720]/bestvideo[vcodec=vp9][height>=720]/bestvideo[height>=720]/bestvideo)+(bestaudio[acodec=opus]/bestaudio)/best' --merge-output-format mkv -o '/data/%(uploader)s/%(title)s.%(ext)s' " . $url;

echo "data: Command: " . $cmd . "\n\n";

$descriptorspec = array(
    0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
    1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
    2 => array("pipe", "w")    // stderr is a pipe that the child will write to
);
flush();
// $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

$process = popen($cmd . " 2>&1", "r");

while ($s = fgets($process)) {
    echo "data: " . $s . "\n\n";
    flush();
}
