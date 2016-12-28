{
    "id" : "{$subtitle->id}",
    "title" : "{$subtitle->title}",
    "elements" : [
        {gc:foreach var="$subtitle->subElements" as="$key => $subelement"}
            {
                "id" : {$subelement->id},
                "time" : {$subelement->time},
                "duration" : {$subelement->duration},
                "content" : "{$subelement->content}"
            }{gc:if condition="$key != $subtitle->subElements->count() - 1"},{/gc:if}
        {/gc:foreach}
    ]
}