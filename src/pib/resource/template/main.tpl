<!DOCTYPE html>
<html lang="fr">
<head>
    <title>{$title}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="icon" type="image/png" href="/{{path:IMAGE:pib}}static/logo.png" />
    <script type="text/javascript" src="/{{path:JS:pib}}video.js"></script>
    <script type="text/javascript" src="/{{path:JS:pib}}jquery-3.1.1.min.js"></script>
    <link href="/{{path:CSS:pib}}video-js.css" rel="stylesheet" media="screen" type="text/css" />
    <link href="/{{path:FILE:pib}}font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen" type="text/css" />
    {gc:asset type="css" files="web/pib/css/default.css,web/pib/css/desktop.css,web/pib/css/mobile.css" cache="0"/}
</head>
<body>
    <div id="wrapper">
        <header>
            <div id="header-top">

            </div>
            {gc:if condition="\System\Request\Request::instance()->controller == 'index'"}
                <a href="{{url:index-home}}">
                    <div id="header-bottom">
                        <div class="content">
                            <h1>
                                Politically Incorrect<br /> Business
                            </h1>
                        </div>
                    </div>
                </a>
            {gc:else/}
                <a href="{{url:index-home}}">
                    <div id="header-bottom-small">
                        <div class="content">
                            <h1>
                                P.I.B
                            </h1>
                        </div>
                    </div>
                </a>
            {/gc:if}
        </header>
        {{php:
            $controller = \System\Request\Request::instance()->controller;
            $action = \System\Request\Request::instance()->action;
        }}
        <div id="main" {gc:if condition="$controller == 'index' && $action == 'home'"}class="main-index"{/gc:if}>
            {gc:child/}
        </div>
        <footer>
            <div id="footer-left">
                <a href="{{url:index-about}}">A propos</a>
                <a href="{{url:index-terms}}">Conditions d'utilisation</a>
                <a href="{{url:index-contact}}">Contactez-nous</a>
            </div>
            <div id="footer-right">
                <a href="">
                    <span class="fa fa-facebook-square"></span>
                </a>
                <a href="">
                    <span class="fa fa-twitter-square"></span>
                </a>
                <a href="">
                    <span class="fa fa-google-plus-square"></span>
                </a>
            </div>
        </footer>
    </div>
</body>
</html>