<?php
header("Content-Type: text/event-stream\n\n");

$url = $_GET['video'];

$cmd = "youtube-dl --format '(bestvideo[vcodec=av01][height>=4320][fps>30]/bestvideo[vcodec=vp9.2][height>=4320][fps>30]/bestvideo[vcodec=vp9][height>=4320][fps>30]/bestvideo[vcodec=av01][height>=4320]/bestvideo[vcodec=vp9.2][height>=4320]/bestvideo[vcodec=vp9][height>=4320]/bestvideo[height>=4320]/bestvideo[vcodec=av01][height>=2880][fps>30]/bestvideo[vcodec=vp9.2][height>=2880][fps>30]/bestvideo[vcodec=vp9][height>=2880][fps>30]/bestvideo[vcodec=av01][height>=2880]/bestvideo[vcodec=vp9.2][height>=2880]/bestvideo[vcodec=vp9][height>=2880]/bestvideo[height>=2880]/bestvideo[vcodec=av01][height>=2160][fps>30]/bestvideo[vcodec=vp9.2][height>=2160][fps>30]/bestvideo[vcodec=vp9][height>=2160][fps>30]/bestvideo[vcodec=av01][height>=2160]/bestvideo[vcodec=vp9.2][height>=2160]/bestvideo[vcodec=vp9][height>=2160]/bestvideo[height>=2160]/bestvideo[vcodec=av01][height>=1440][fps>30]/bestvideo[vcodec=vp9.2][height>=1440][fps>30]/bestvideo[vcodec=vp9][height>=1440][fps>30]/bestvideo[vcodec=av01][height>=1440]/bestvideo[vcodec=vp9.2][height>=1440]/bestvideo[vcodec=vp9][height>=1440]/bestvideo[height>=1440]/bestvideo[vcodec=av01][height>=1080][fps>30]/bestvideo[vcodec=vp9.2][height>=1080][fps>30]/bestvideo[vcodec=vp9][height>=1080][fps>30]/bestvideo[vcodec=av01][height>=1080]/bestvideo[vcodec=vp9.2][height>=1080]/bestvideo[vcodec=vp9][height>=1080]/bestvideo[height>=1080]/bestvideo[vcodec=av01][height>=720][fps>30]/bestvideo[vcodec=vp9.2][height>=720][fps>30]/bestvideo[vcodec=vp9][height>=720][fps>30]/bestvideo[vcodec=av01][height>=720]/bestvideo[vcodec=vp9.2][height>=720]/bestvideo[vcodec=vp9][height>=720]/bestvideo[height>=720]/bestvideo)+(bestaudio[acodec=opus]/bestaudio)/best' --merge-output-format mkv -o '/data/%(uploader)s/%(title)s.%(ext)s' " . $url;

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
