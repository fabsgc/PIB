var videoData;
var subtitlesData;
var musicData;
var music;
var timeoutHandle;
var subTitleCustomCount;
var ready = false;

function resizeVideoJS(){
    videojs("video-editor").ready(function() {
        var myPlayer = this;
        var aspectRatio = 365/640;
        var width = document.getElementById("main").parentElement.offsetWidth - 20;

        if(width > 700){
            width = 700;
        }

        myPlayer.width(width).height( width * aspectRatio );
    })
}

function initVideoEditor(){
    loadVideoEditor(1);

    videojs("video-editor").ready(function(){
        window.onresize = function(){ resizeVideoJS(); };
        resizeVideoJS();
    });
}

function loadVideoEditor(id) {
    $.post( "/api/video/" + id, function( data ) {
        console.log(data);
        videoData = data;

        videojs("video-editor").ready(function() {
            var myPlayer = this;
            myPlayer.src('/web/pib/file/' + data.path);
            myPlayer.poster('/web/pib/file/' + data.poster);
            loadSubtitlesListBox(data);
        });
    });
}

function loadSubtitlesListBox(data){
    $('#video-editor-subtitles').find('option').each(function(){
        if($(this).val() != "" && $(this).val() != "0"){
            $(this).remove();
        }
    });

    $.each(data.subtitles, function (i, item) {
        if(i == 0){
            $('#video-editor-subtitles').append($('<option>', {
                value: item.id,
                text : item.title
            }).attr('selected', 'selected'));
        }
        else{
            $('#video-editor-subtitles').append($('<option>', {
                value: item.id,
                text : item.title
            }));
        }
    });

    loadSubtitles();
    loadMusic();
}

function loadSubtitles(){
    var id = $('#video-editor-subtitles').val();

    $('#video-editor-subtitles-block').find('.video-editor-subtitles-element-block').each(function(){
        $(this).remove();
    });

    if(id != "0"){
        $( document ).ready(function() {
            $.post("api/subtitle/" + id, function (data) {
                console.log(data);
                subtitlesData = data;
                ready = true;
            });
        });

        $('#video-editor-subtitles-block-add').css('display', 'none');
        $('#video-editor-subtitles-block-title').css('display', 'none');
        $('.subtitle-title').removeAttr('required');
    }
    else{
        subTitleCustomCount = 1;
        $('#video-editor-subtitles-block').append('<div class="video-editor-subtitles-element-block" id="subtitle-element-' + subTitleCustomCount + '">' +
            '<input type="text" placeholder="Texte à afficher" class="subtitle-element-content" name="subtitle-elements[' + subTitleCustomCount + '][content]"/> ' +
            '<input type="text" placeholder="Début (sec)" class="subtitle-element-begin" name="subtitle-elements[' + subTitleCustomCount + '][begin]" value="0"/> ' +
            '<input type="text" placeholder="Fin (sec)" class="subtitle-element-end" name="subtitle-elements[' + subTitleCustomCount + '][end]" value="0"/> ' +
            '<div class="subtitle-element-delete"><a onclik="deleteElement(' + subTitleCustomCount + ')"><span class="fa fa-close"></span></a></div>' +
            '</div>');

        $('#video-editor-subtitles-block-add').css('display', 'block');
        $('#video-editor-subtitles-block-title').css('display', 'block');
        $('.subtitle-title').attr('required', 'required');

        $('.subtitle-element-delete').on('click', function(){
            if($('.video-editor-subtitles-element-block').length > 1){
                $(this).parent().remove();
            }
        });
    }
}

function deleteElement(id){
    $( document ).ready(function() {
        $('#subtitle-element-' + id).remove();
    });
}

function addElement(){
    subTitleCustomCount++;
    $('#video-editor-subtitles-block').append('<div class="video-editor-subtitles-element-block" id="subtitle-element-' + subTitleCustomCount + '">' +
        '<input type="text" placeholder="Texte à afficher" class="subtitle-element-content" name="subtitle-elements[' + subTitleCustomCount + '][content]"/> ' +
        '<input type="text" placeholder="Début (sec)" class="subtitle-element-begin" name="subtitle-elements[' + subTitleCustomCount + '][begin]" value="0"/> ' +
        '<input type="text" placeholder="Fin (sec)" class="subtitle-element-end" name="subtitle-elements[' + subTitleCustomCount + '][end]" value="0"/> ' +
        '<div class="subtitle-element-delete"><a onclik="deleteElement(' + subTitleCustomCount + ')"><span class="fa fa-close"></span></a></div>' +
        '</div>');

    $('.subtitle-element-delete').on('click', function(){
        if($('.video-editor-subtitles-element-block').length > 1){
            $(this).parent().remove();
        }
    });
}

function loadMusic(){
    var id = $('#video-editor-musics').val();

    $( document ).ready(function() {
        $.post("api/music/" + id, function (data) {
            console.log(data);
            musicData = data;
        });
    });
}

function startVideo(){
    if(ready) {
        videojs("video-editor").ready(function () {
            var myPlayer = this;

            if (myPlayer.currentTime() < 1) {
                myPlayer.play();

                music = new Audio('/web/pib/file/' +musicData.path);
                music.volume = 1;
                music.play();

                $('#video-start').html("Stop");

                checkVideo();

                myPlayer.on('ended', function () {
                    music.pause();
                    myPlayer.pause();
                    myPlayer.currentTime(0);
                    window.clearTimeout(timeoutHandle);
                    $('#video-start').html("Lancer");
                    $('#video-editor-subtitle').html("");
                });
            }
            else {
                music.pause();
                myPlayer.pause();
                myPlayer.currentTime(0);
                window.clearTimeout(timeoutHandle);
                $('#video-start').html("Lancer");
                $('#video-editor-subtitle').html("");
            }
        });
    }
}

function checkVideo(){
    var subtitlesId = $('#video-editor-subtitles').val();

    videojs("video-editor").ready(function() {
        var myPlayer = this;
        timeoutHandle = window.setTimeout(checkVideo, 100);
        var currentTime = myPlayer.currentTime()*1000;
        var subtitleWritten = false;

        $('#video-editor-video-time').html(Math.round(myPlayer.currentTime()*10, 2));


        if(subtitlesId != "0"){
            $.each(subtitlesData.elements, function() {
                var duration = this.time + this.duration;

                /*console.log(this.time);
                console.log(duration);
                console.log(currentTime);
                console.log("###################");*/

                if(this.time <= currentTime && currentTime < duration){
                    $('#video-editor-subtitle').html(this.content);
                    subtitleWritten = true;
                }
            });
        }
        else{
            $('.video-editor-subtitles-element-block').each(function(){
                var contentCustom = $(this).find('.subtitle-element-content').val();
                var beginCustom = $(this).find('.subtitle-element-begin').val()*100;
                var endCustom = $(this).find('.subtitle-element-end').val()*100;

                //console.log(currentTime + "/" + beginCustom + "/" + endCustom);

                if(currentTime >= beginCustom && currentTime < endCustom){
                    $('#video-editor-subtitle').html(contentCustom);
                    subtitleWritten = true;
                }
            });
        }

        if(subtitleWritten == false){
            $('#video-editor-subtitle').html("");
        }
    });
}

$( document ).ready(function() {
    $("#video-editor-video").on('change', function () {
        loadVideoEditor($( this ).val());
    });

    $("#video-editor-subtitles").on('change', function () {
        loadSubtitles();
    });

    $("#video-editor-musics").on('change', function () {
        loadMusic();
    });
});