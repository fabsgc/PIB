{gc:extends file="main"/}
<div class="content">
    <h1 class="h1-title">Meilleures vidéos</h1>
    <br>
    {gc:foreach var="$creations" as="$creation"}
        <div id="video-{$creation->id}" class="video-block">
            <script type="text/javascript" src="/web/pib/js/top.js"></script>
            <h2 class="h2-title-video">
                <a href="{{url:index-video:$creation->id}}">{$creation->title}</a>
            </h2>
            <video id="video-top-video-{$creation->id}" class="video-js vjs-default-skin vjs-big-play-centered"
                   controls preload="auto"
                   poster="{$creation->video->poster}"
                   data-setup=''>
                <source src="{$creation->path}" type="video/mp4" />
            </video>
            <div class="stars">
                <div id="stars-input-result-{$creation->id}" class="stars-input">
                    <div class="stars-input-content">
                        <div class="stars-value" style="width: 190px;"></div>
                    </div>
                </div>
                {gc:if condition="empty($_SESSION[\System\Request\Data::instance()->env('REMOTE_ADDR')][$creation->id])"}
                    <div id="stars-input-{$creation->id}" class="stars-input" onclick="vote('stars-input-{$creation->id}', {$creation->id}, event)">
                        <div class="stars-input-content">
                            <div class="stars-value" style="width: 190px;"></div>
                        </div>
                    </div>
                {/gc:if}
            </div>
            <script type="text/javascript">
                setStarsTo('stars-input-{$creation->id}', 1);
                setStarsTo('stars-input-result-{$creation->id}', {$creation->score});
                initVideoTop("video-top-video-{$creation->id}");
            </script>
        </div>
    {/gc:foreach}
</div>