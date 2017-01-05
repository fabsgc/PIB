<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Créer ma vidéo</title>
        <link rel="icon" type="image/png" href="/{{path:IMAGE:pib}}static/logo.png" />
        <script type="text/javascript" src="/{{path:JS:pib}}jquery-3.1.1.min.js"></script>
        {gc:asset type="css" files="web/pib/css/default.css" cache="0"/}
        <style>
            a{
                color: #f8b323;
                text-decoration:none;
            }

            p{
                text-align: center !important;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <div id="header-top">

                </div>
            </header>
            <div id="main">
                <div class="content">
                    <h1 class="h1-title">Création de votre vidéo en cours</h1>
                    <p>Elle sera disponible <a href="{{url:index-video:$id}}">ici</a> dans quelques minutes</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $.post( "{{url:editor-encode-ajax:$id}}", function( data ) { });
        </script>
    </body>
</html>