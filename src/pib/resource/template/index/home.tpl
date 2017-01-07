{gc:extends file="main"/}
<div id="main-home">
    <div id="video-home">
        <div class="content">
            <video id="video-home-video" class="video-js vjs-default-skin vjs-big-play-centered"
                   controls preload="auto"
                   poster="/{{path:IMAGE:pib}}static/video-poster.png"
                   data-setup=''>
                <source src="/{{path:FILE:pib}}video.mp4" type="video/mp4" />
            </video>
        </div>
        <script type="text/javascript" src="/{{path:JS:pib}}home.js"></script>
    </div>
    <div id="video-explication">
        <p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il te plaît.
            Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p><br>
        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au Christkindelsmärik
            en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa
            Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
    </div>
    <a href="{{url:editor-home}}" class="button-home">
        Créer ma vidéo !
    </a>
    <a href="{{url:index-top}}" class="button-home">
        Les meilleures vidéos
    </a>
    <a href="{{url:index-shop}}" class="button-home">
        La boutique
    </a>
</div>