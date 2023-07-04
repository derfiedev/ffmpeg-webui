<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Converter</title>
    <link rel="stylesheet" href="includes/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="page">
        <h1>ffmpeg</h1>
        <div class="main-panel">
            <div class="sub-header sub-selected">
                    conversion
            </div>

            <div class="sub-panel">
            
                <form action="includes/process.php" method="post" enctype="multipart/form-data" id="uploadForm">
                    <div class="setting">
                        <label for="input" class="m">Input file:</label>
                        <input type="file" name="input" id="input">
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Bitrate (k):</label>
                        <input type="range" name="bitrate" id="bitrate" min="100" max="50000" step="100" value="10000">
                        <input type="number" name="" id="bitrate_field" min="100" max="50000" step="100" value="10000">
                        <div>
                            <input type="checkbox" value="true" name="bitrate_keep" id="bitrate_keep">
                            <label for="bitrate_keep">Keep bitrate</label>
                        </div>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Resolution (pixels):</label>
                        <input type="number" name="horizontal_resolution" id="horizontal_resolution" min="50" max="5000" value="1920">
                        <input type="number" name="vertical_resolution" id="vertical_resolution" min="50" max="5000" value="1080">
                        <div class="">
                            <input type="checkbox" value="true" name="resolution_keep" id="resolution_keep">
                            <label for="resolution_keep">Keep resolution</label>
                        </div>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Frame rate (fps):</label>
                        <input type="range" name="frame_rate" id="frame_rate" min="1" max="240" value="60">
                        <input type="number" name="frame_rate_field" id="frame_rate_field" min="1" max="240" value="60">
                        <div class="">
                            <input type="checkbox" value="true" name="frame_rate_keep" id="frame_rate_keep">
                            <label for="frame_rate_keep">Keep frame rate</label>
                        </div>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Video codec:</label>
                        <select name="video_codec" id="video_codec">
                            <option value="auto">auto</option>
                            <option value="h264">h264</option>
                            <option value="h265">h265</option>
                            <option value="vp8">vp8</option>
                            <option value="vp9">vp9</option>
                        </select>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Audio bitrate (k):</label>
                        <input type="range" name="audio_bitrate" id="audio_bitrate" min="8" max="320" step="1" value="128">
                        <input type="number" name="audio_bitrate_field" id="audio_bitrate_field" min="8" max="320" step="1" value="128">
                        <div class="">
                            <input type="checkbox" value="true" name="audio_bitrate_keep" id="audio_bitrate_keep">
                            <label for="audio_bitrate_keep">Keep audio bitrate</label>
                        </div>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Audio codec:</label>
                        <select name="audio_codec" id="audio_codec">
                            <option value="auto">auto</option>
                            <option value="aac">aac</option>
                            <option value="mp3">mp3</option>
                            <option value="opus">opus</option>
                            <option value="vorbis">vorbis</option>
                        </select>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Audio sample rate (Hz):</label>
                        <input type="range" name="audio_sample_rate" id="audio_sample_rate" min="8000" max="96000" step="1000" value="48000">
                        <input type="number" name="audio_sample_rate_field" id="audio_sample_rate_field" min="8000" max="96000" step="1000" value="48000">
                        <div class="">
                            <input type="checkbox" value="true" name="audio_sample_rate_keep" id="audio_sample_rate_keep">
                            <label for="audio_sample_rate_keep">Keep audio sample rate</label>
                        </div>
                    </div>
                    <div class="setting">
                        <label for="input" class="m">Output format:</label>
                        <select name="output_format" id="output_format">
                            <option value="mp4">mp4</option>
                            <option value="webm">webm</option>
                            <option value="mkv">mkv</option>
                        </select>
                    </div>
                    <input type="submit" value="Convert" id="submit">
                    
                    
                </form>
                <div class="progress-bar">
                        <div class="progress-bar-fill" id="progressBarFill"><span>0%</span></div>
                </div>
                <div class="wait">
                    <span>
                        Converting...
                    </span>
                </div>
                <div id="out"></div>
            </div>
        </div>
    </div>
</body>
<script>
    const bitrate = document.getElementById('bitrate');
    bitrate.addEventListener('change', function() {
        console.log(bitrate.value);

        //set the value of the bitrate field to the value of the slider
        document.getElementById('bitrate_field').value = bitrate.value;
    });

    const bitrate_keep = document.getElementById('bitrate_keep');
    bitrate_keep.addEventListener('change', function() {
        console.log(bitrate_keep.checked);
        //if the checkbox is checked, disable the bitrate slider and field
        if (bitrate_keep.checked) {
            bitrate.disabled = true;
            bitrate_field.disabled = true;
        } else {
            bitrate.disabled = false;
            bitrate_field.disabled = false;
        }
    });

    const bitrate_field = document.getElementById('bitrate_field');
    bitrate_field.addEventListener('change', function() {
        console.log(bitrate_field.value);

        //set the value of the bitrate slider to the value of the field
        document.getElementById('bitrate').value = bitrate_field.value;
    });

    const resolution_keep = document.getElementById('resolution_keep');
    resolution_keep.addEventListener('change', function() {
        console.log(resolution_keep.checked);
        //if the checkbox is checked, disable the bitrate slider and field
        if (resolution_keep.checked) {
            horizontal_resolution.disabled = true;
            vertical_resolution.disabled = true;
        } else {
            horizontal_resolution.disabled = false;
            vertical_resolution.disabled = false;
        }
    });

    const frame_rate = document.getElementById('frame_rate');
    frame_rate.addEventListener('change', function() {
        console.log(frame_rate.value);

        //set the value of the bitrate field to the value of the slider
        document.getElementById('frame_rate_field').value = frame_rate.value;
    });

    const frame_rate_field = document.getElementById('frame_rate_field');
    frame_rate_field.addEventListener('change', function() {
        console.log(frame_rate_field.value);

        //set the value of the bitrate slider to the value of the field
        document.getElementById('frame_rate').value = frame_rate_field.value;
    });

    const frame_rate_keep = document.getElementById('frame_rate_keep');
    frame_rate_keep.addEventListener('change', function() {
        console.log(frame_rate_keep.checked);
        //if the checkbox is checked, disable the bitrate slider and field
        if (frame_rate_keep.checked) {
            frame_rate.disabled = true;
            frame_rate_field.disabled = true;
        } else {
            frame_rate.disabled = false;
            frame_rate_field.disabled = false;
        }
    });
    
    const audio_bitrate = document.getElementById('audio_bitrate');
    audio_bitrate.addEventListener('change', function() {
        console.log(audio_bitrate.value);

        //set the value of the bitrate field to the value of the slider
        document.getElementById('audio_bitrate_field').value = audio_bitrate.value;
    });

    const audio_bitrate_field = document.getElementById('audio_bitrate_field');
    audio_bitrate_field.addEventListener('change', function() {
        console.log(audio_bitrate_field.value);

        //set the value of the bitrate slider to the value of the field
        document.getElementById('audio_bitrate').value = audio_bitrate_field.value;
    });

    const audio_bitrate_keep = document.getElementById('audio_bitrate_keep');
    audio_bitrate_keep.addEventListener('change', function() {
        console.log(audio_bitrate_keep.checked);
        //if the checkbox is checked, disable the bitrate slider and field
        if (audio_bitrate_keep.checked) {
            audio_bitrate.disabled = true;
            audio_bitrate_field.disabled = true;
        } else {
            audio_bitrate.disabled = false;
            audio_bitrate_field.disabled = false;
        }
    });

    const audio_sample_rate = document.getElementById('audio_sample_rate');
    audio_sample_rate.addEventListener('change', function() {
        console.log(audio_sample_rate.value);

        //set the value of the bitrate field to the value of the slider
        document.getElementById('audio_sample_rate_field').value = audio_sample_rate.value;
    });

    const audio_sample_rate_field = document.getElementById('audio_sample_rate_field');
    audio_sample_rate_field.addEventListener('change', function() {
        console.log(audio_sample_rate_field.value);

        //set the value of the bitrate slider to the value of the field
        document.getElementById('audio_sample_rate').value = audio_sample_rate_field.value;
    });

    const audio_sample_rate_keep = document.getElementById('audio_sample_rate_keep');
    audio_sample_rate_keep.addEventListener('change', function() {
        console.log(audio_sample_rate_keep.checked);
        //if the checkbox is checked, disable the bitrate slider and field
        if (audio_sample_rate_keep.checked) {
            audio_sample_rate.disabled = true;
            audio_sample_rate_field.disabled = true;
        } else {
            audio_sample_rate.disabled = false;
            audio_sample_rate_field.disabled = false;
        }
    });

    const testprogress = document.getElementById('test-progress');
    testprogress.addEventListener('change', function() {
        console.log(testprogress.value);
        $('#uploadForm').css('display', 'none');
        $('#progressBarFill').css('display', 'block');
        $('#progressBarFill').css('width', testprogress.value + '%').attr('aria-valuenow', testprogress.value);
        $('#progressBarFill span').text(testprogress.value + '%');
    });
</script>
<script>
    $(document).ready(function() {
    $('#uploadForm').submit(function(e) {
    e.preventDefault();

    $('#submit').attr('disabled', 'disabled');
    
    var formData = new FormData(this);
    var progressBar = $('.progress-bar');
    var progressBarFill = progressBar.find('.progress-bar-fill');
    var progressBarSpan = progressBarFill.find('span');
    
    $.ajax({
      url: 'includes/process.php',
      type: 'POST',
      data: formData,
      dataType: 'json',
      contentType: false,
      processData: false,
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        
        xhr.upload.addEventListener('progress', function(e) {
          if (e.lengthComputable) {
            var percentage = Math.round((e.loaded / e.total) * 100);
            progressBarFill.css('width', percentage + '%');
            progressBarSpan.text(percentage + '%');
            if (percentage >= 100) {
              $('#progressBarFill').css('display', 'none');
              $('.wait').css('display', 'block');
            }
          }
        });
        
        return xhr;
      },
      beforeSend: function() {
        progressBar.show();
      },
      success: function(response) {
        $('#submit').attr('disabled', false);
        if (response.code == 200) {
            console.log("here")
            var downloadLink = $('<a>').attr('href', 'output/' + response.filename).text('Download File');
            $('#out').empty().append(downloadLink);
        } else {
            $('#out').text(response.message);
        }
        
        progressBar.hide();
        $('.wait').css('display', 'none');
      },
      error: function(xhr, status, error) {
        $('#submit').attr('disabled', false);
        $('#out').text('An error occurred: ' + error);
        progressBar.hide();
        $('.wait').css('display', 'none');
      }
    });
  });
});
</script>
</html>