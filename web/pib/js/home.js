videojs('video-home-video').ready(function(){
    var myPlayer = this, id = myPlayer.id();
    var aspectRatio = 365/640;

    function resizeVideoJS(){
        var width = document.getElementById(id).parentElement.offsetWidth;

        if(width > 680){
            width = 680;
        }

        width -= 40;
        myPlayer.width(width).height( width * aspectRatio );
    }

    resizeVideoJS();
    window.onresize = resizeVideoJS;
});