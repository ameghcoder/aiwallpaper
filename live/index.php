<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Cache-Control" content="no-cache">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">

        <title>WebGL Fluid Simulation</title>
        <!-- <script type="text/javascript" src="js/dat.gui.min.js"></script> -->
        <style>
            * {
                user-select: none;
            }

            html, body {
                overflow: hidden;
                background-color: #000;
            }

            body {
                margin: 0;
                position: fixed;
                width: 100%;
                height: 100%;
                background-size: 100% 100%;
            }

            canvas {
                width: 100%;
                height: 100%;
            }

            .dg {
                opacity: 0.9;
            }

            .dg .property-name {
                overflow: visible;
            }

            @font-face {
                font-family: 'iconfont';
                src: url('iconfont.ttf') format('truetype');
            }

            .bigFont {
                font-size: 150%;
                color: #8C8C8C;
            }

            .cr.function.appBigFont {
                font-size: 150%;
                line-height: 27px;
                color: #A5F8D3;
                background-color: #023C40;
            }

            .cr.function.appBigFont .property-name {
                float: none;
            }

            .cr.function.appBigFont .icon {
                position: sticky;
                bottom: 27px;
            }

            .icon {
                font-family: 'iconfont';
                font-size: 130%;
                float: right;
            }

            .twitter:before {
                content: 'a';
            }

            .github:before {
                content: 'b';
            }

            .app:before {
                content: 'c';
            }

            .discord:before {
                content: 'd';
            }
            #canvas{
                width: 400px;
                height: 400px;
            }
        </style>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/component/'.'h_links.html'); ?>
    <title>Live Wallpaper || Android wallpapers || iPhone wallpapers</title>
</head>
<body>
    <div class="ai-container">
        <?php include($_SERVER['DOCUMENT_ROOT'].'/component/header.html'); ?>
        <canvas></canvas>
        <script src="js/script.js"></script>
        
    </div>
</body>
</html>