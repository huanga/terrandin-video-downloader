$('#download').click(function (event) {
    event.preventDefault();
    console.log("Downloading triggred");
    var videoURL = $('#video_url').val();

    var evtSource = new EventSource('download.php?video=' + videoURL);
    evtSource.onmessage = function(evt) {
        $("#response-area").append(evt.data);
        $("#response-area").append('<br />');
        $("#response-area").scrollTop($("#response-area").height());
    }

    evtSource.onerror = function(evt) {
        // Close on error
        evtSource.close();
    }
});