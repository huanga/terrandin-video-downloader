<?php
function isYouTube( $url ) {
    $pattern = '/^http(s)?\:\/\/(www\.)?(youtube\.|youtu.be\/)/';
    if (preg_match($pattern, $url) === 1) {
        return true;
    } else {
        return false;
    }
}

header("Content-Type: text/event-stream\n\n");

$url = $_GET['video'];
$referer = $_GET['referer'];

if (isYouTube($url)) {
    $format = " --format '(bestvideo[ext!=webm][vcodec=av01][height>=4320][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=4320][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=4320][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=4320]/bestvideo[ext!=webm][vcodec=vp9.2][height>=4320]/bestvideo[ext!=webm][vcodec=vp9][height>=4320]/bestvideo[ext!=webm][height>=4320]/bestvideo[ext!=webm][vcodec=av01][height>=2880][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=2880][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=2880][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=2880]/bestvideo[ext!=webm][vcodec=vp9.2][height>=2880]/bestvideo[ext!=webm][vcodec=vp9][height>=2880]/bestvideo[ext!=webm][height>=2880]/bestvideo[ext!=webm][vcodec=av01][height>=2160][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=2160][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=2160][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=2160]/bestvideo[ext!=webm][vcodec=vp9.2][height>=2160]/bestvideo[ext!=webm][vcodec=vp9][height>=2160]/bestvideo[ext!=webm][height>=2160]/bestvideo[ext!=webm][vcodec=av01][height>=1440][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=1440][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=1440][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=1440]/bestvideo[ext!=webm][vcodec=vp9.2][height>=1440]/bestvideo[ext!=webm][vcodec=vp9][height>=1440]/bestvideo[ext!=webm][height>=1440]/bestvideo[ext!=webm][vcodec=av01][height>=1080][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=1080][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=1080][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=1080]/bestvideo[ext!=webm][vcodec=vp9.2][height>=1080]/bestvideo[ext!=webm][vcodec=vp9][height>=1080]/bestvideo[ext!=webm][height>=1080]/bestvideo[ext!=webm][vcodec=av01][height>=720][fps>30]/bestvideo[ext!=webm][vcodec=vp9.2][height>=720][fps>30]/bestvideo[ext!=webm][vcodec=vp9][height>=720][fps>30]/bestvideo[ext!=webm][vcodec=av01][height>=720]/bestvideo[ext!=webm][vcodec=vp9.2][height>=720]/bestvideo[ext!=webm][vcodec=vp9][height>=720]/bestvideo[ext!=webm][height>=720]/bestvideo[ext!=webm])+(bestaudio[acodec=opus]/bestaudio)/best'";
} else {
    $format = "";
}

$cmd = "youtube-dl " .
$format .
" --add-metadata --write-thumbnail --merge-output-format mkv -o '/data/%(uploader)s/%(title)s.%(ext)s' " .
"-v '" . $url . "' ";

if(trim($referer) !== "") {
    $cmd .= "--referer '" . $referer . "'";
}

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
