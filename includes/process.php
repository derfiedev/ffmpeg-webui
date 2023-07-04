<?php
require_once 'config.php';

function respondWithError($code, $message) {
    http_response_code($code);
    echo json_encode(["error" => $message]);
    exit();
}

if ($_FILES['input']['size'] == 0) {
    respondWithError(400, "FILE_NO_FILE");
}

if ($_FILES['input']['size'] > 524288000) {
    respondWithError(400, "FILE_TOO_LARGE");
}

if ($_FILES['input']['error'] !== 0) {
    respondWithError(400, "FILE_ERROR");
}

if (!in_array($_FILES['input']['type'], $accepted_formats)) {
    respondWithError(400, "FILE_FORMAT_NOT_SUPPORTED");
}


$flags = "";

if (!isset($_POST['bitrate_keep'])) $flags .= "-b:v " . $_POST['bitrate'] . "k ";
if (!isset($_POST['resolution_keep'])) $flags .= "-s " . $_POST['horizontal_resolution'] . "x" . $_POST['vertical_resolution'] . " ";
if (!isset($_POST['frame_rate_keep'])) $flags .= "-r " . $_POST['frame_rate'] . " ";
if (!isset($_POST['audio_bitrate_keep'])) $flags .= "-b:a " . $_POST['audio_bitrate'] . "k ";
if (!isset($_POST['audio_sample_rate_keep'])) $flags .= "-ar " . $_POST['audio_sample_rate'] . " ";
if ($_POST['video_codec'] !== "auto") $flags .= "-vcodec " . $_POST['video_codec'] . " ";
if ($_POST['audio_codec'] !== "auto") $flags .= "-acodec " . $_POST['audio_codec'] . " ";
$flags .= "-y ";

$new_name = uniqid() . "." . $_POST['output_format'];
$command = "ffmpeg -i " . $_FILES['input']['tmp_name'] . " " . $flags . " output/" . $new_name;
exec($command, $output, $return);

if ($return !== 0) {
    respondWithError(400, implode("\n", $output));
}

http_response_code(200);
echo json_encode(["filename" => $new_name]);
?>
