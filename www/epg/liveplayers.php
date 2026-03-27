<!doctype html>
<html>
<head>
    <title>Live Streams</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f0f0f0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .player-box {
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
        }

        .label {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .videodiv {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
        }

        .videodiv > script {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<h1>Live Streams</h1>

<div class="row">
    <div class="player-box">
        <div class="label">RTV Utrecht</div>
        <div class="videodiv">
            <script type="text/javascript" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web/c/3742011.js?autoplay=true&muted=true" async="true"></script>
        </div>
    </div>

    <div class="player-box">
        <div class="label">UStad</div>
        <div class="videodiv">
            <script type="text/javascript" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web/c/3742012.js?autoplay=true&muted=true" async="true"></script>
        </div>
    </div>
</div>

<div class="row">
    <div class="player-box">
        <div class="label">Radio M Utrecht</div>
        <div class="videodiv">
            <script type="text/javascript" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web/c/3058844.js?autoplay=true&muted=true" async="true"></script>
        </div>
    </div>

    <div class="player-box">
        <div class="label">Bingo FM</div>
        <div class="videodiv">
            <script type="text/javascript" src="https://rtvutrecht.bbvms.com/p/rtv_utrecht_videoplayer_web/c/3058869.js?autoplay=true&muted=true" async="true"></script>
        </div>
    </div>
</div>

</body>
</html>
