function resizeVideoJS(id){
    videojs(id).ready(function() {
        var myPlayer = this;
        var aspectRatio = 365/640;
        var width = document.getElementById("main").parentElement.offsetWidth - 20;

        if(width > 700){
            width = 700;
        }

        myPlayer.width(width).height( width * aspectRatio );
    })
}

function initVideoTop(id){
    videojs(id).ready(function(){
        window.onresize = function(){ resizeVideoJS(id); };
        resizeVideoJS(id);
    });
}

function vote(div, id, e) {
    var object = $('#' + div);
    var width = 190;
    var mouseX = e.clientX - $(object).offset().left;
    var score = (mouseX/width) * 5;
    var scoreIntPart = parseInt(score);

    if(score - scoreIntPart <= 0.5)
        score = scoreIntPart + 0.5;
    else if(score - scoreIntPart <= 1)
        score = scoreIntPart + 1;

    if(score < 1) score = 1;

    $('#' + div + " .stars-value").css("width", width*score/5 + "px");

    window.location.href = '/PIB/vote/' + id + '/' + score;
}

function setStarsTo(div, value) {
    var width = 190;
    $('#' + div + " .stars-value").css("width", width*value/5 + "px");
}