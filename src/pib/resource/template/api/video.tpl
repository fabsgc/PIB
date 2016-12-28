{
    "id" : {$video->id},
    "title" : "{$video->title}",
    "poster" : "{$video->poster}",
    "duration" : {$video->duration},
    "path" : "{$video->path}",
    "subtitles" : [
        {gc:foreach var="$video->subtitles" as="$key1 => $subtitle"}
            {
                "id" : "{$subtitle->id}",
                "title" : "{$subtitle->title}",
                "elements" : [
                    {gc:foreach var="$subtitle->subElements" as="$key2 => $subelement"}
                        {
                            "id" : {$subelement->id},
                            "time" : {$subelement->time},
                            "duration" : {$subelement->duration},
                            "content" : "{$subelement->content}"
                        }{gc:if condition="$key2 != $subtitle->subElements->count() - 1"},{/gc:if}
                    {/gc:foreach}
                ]
            }{gc:if condition="$key1 != $video->subtitles->count() - 1"},{/gc:if}
        {/gc:foreach}
    ]
}