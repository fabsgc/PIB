{gc:extends file="main"/}
<div class="content">
    {gc:if condition="isset($_SESSION['flash']) && $_SESSION['flash'] != ''"}
        <div id="flash-message">
            <div class="alert alert-success">
                <div class="close" onclick="closeFlashMessage(this);"><span class="fa fa-times">&nbsp;</span></div>
                {$_SESSION['flash']}
                {{php: $_SESSION['flash'] = ''; }}
            </div>
        </div>
    {/gc:if}
    <script type="text/javascript">
        function closeFlashMessage(objet) {
            $(objet.parentNode).animate({
                    height: "0px",
                    opacity: "0",
                    margin: "0",
                    padding: "0"
                },
                250,
                function () {
                    $(objet.parentNode).remove();
                    height();
                }
            );
        }
    </script>

    <div id="video-editor-block">
        <script type="text/javascript" src="/{{path:JS:pib}}editor.js"></script>

        <form action="{{url:editor-save}}" method="post">
            <a onclick="startVideo()" class="button-home" id="video-start">
                Lancer
            </a>

            <input type="text" placeholder="Titre de la vidéo" class="video-title" name="video-title" required/>

            <select name="video-editor-video" id="video-editor-video" required>
                <option value="" disabled>Choisissez un discours</option>
                {gc:foreach var="$videos" as="$video"}
                    <option value="{$video->id}">{$video->title}</option>
                {/gc:foreach}
            </select>

            <video id="video-editor" class="video-js vjs-default-skin vjs-big-play-centered"
                   preload="auto"
                   poster="/{{path:FILE:pib}}{$videos->first()->poster}"
                   data-setup='{"sources": [{"type": "video/mp4", "src":"/{{path:FILE:pib}}{$videos->first()->path}"}] }'>
            </video>

            <div id="video-editor-subtitle">
            </div>

            <div id="video-editor-video-time">
                0
            </div>

            <select name="video-editor-subtitles" id="video-editor-subtitles" required>
                <option value="" disabled>Choisissez des sous-titres</option>
                <option value="0">Créer mes sous-titres</option>
            </select>

            <div id="video-editor-subtitles-block-title" style="display: none">
                <input type="text" placeholder="Titre des sous-titres" class="subtitle-title" name="subtitle-title"/>
            </div>

            <div id="video-editor-subtitles-block" >

            </div>

            <div id="video-editor-subtitles-block-add" style="display: none">
                <a onclick="addElement()" class="subtitle-element-add">Ajouter</a>
            </div>

            <select name="video-editor-musics" id="video-editor-musics" required>
                <option value="" disabled>Choisissez une musique</option>
                {gc:foreach var="$musics" as="$music"}
                    <option value="{$music->id}">{$music->title}</option>
                {/gc:foreach}
            </select>

            <input type="submit" value="Enregistrer"/>
        </form>
    </div>
</div>
<script type="text/javascript">
    initVideoEditor();
</script>
