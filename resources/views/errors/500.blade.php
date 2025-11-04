<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>500 - Error</title>

    <style id="" media="all">
        /* vietnamese */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 400;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUAnx4RHw.woff2) format('woff2');
        }

        /* latin-ext */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 400;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUA3x4RHw.woff2) format('woff2');
        }

        /* latin */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 400;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUDXx4.woff2) format('woff2');
        }

        /* vietnamese */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 700;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUAnx4RHw.woff2) format('woff2');
        }

        /* latin-ext */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 700;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUA3x4RHw.woff2) format('woff2');
        }

        /* latin */
        @font-face {
            font-family: 'Josefin Sans';
            font-style: normal;
            font-weight: 700;
            src: url(/fonts.gstatic.com/s/josefinsans/v17/Qw3aZQNVED7rKGKxtqIqX5EUDXx4.woff2) format('woff2');
        }

    </style>

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        body {
            padding: 0;
            margin: 0
        }

        #notfound {
            position: relative;
            height: 100vh;
            background-color: #222
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%)
        }

        .notfound {
            max-width: 460px;
            width: 100%;
            text-align: center;
            line-height: 1.4
        }

        .notfound .notfound-404 {
            height: 158px;
            line-height: 153px
        }

        .notfound .notfound-404 h1 {
            font-family: josefin sans, sans-serif;
            color: #222;
            font-size: 220px;
            letter-spacing: 10px;
            margin: 0;
            font-weight: 700;
            text-shadow: 2px 2px 0 #0b577b, -2px -2px 0 #0b4c7b, 0 0 8px #0b467b;
        }

        .notfound .notfound-404 h1>span {
            text-shadow: 2px 2px 0 #f28633, -2px -2px 0 #f27c33, 0 0 8px #f27533
        }

        .notfound p {
            font-family: josefin sans, sans-serif;
            color: #c9c9c9;
            font-size: 16px;
            font-weight: 400;
            margin-top: 0;
            margin-bottom: 15px
        }

        .notfound a {
            font-family: josefin sans, sans-serif;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            background: 0 0;
            color: #c9c9c9;
            border: 2px solid #c9c9c9;
            display: inline-block;
            padding: 10px 25px;
            font-weight: 700;
            -webkit-transition: .2s all;
            transition: .2s all
        }

        .notfound a:hover {
            color: #f27533;
            border-color: #f27533
        }

        @media only screen and (max-width:480px) {
            .notfound .notfound-404 {
                height: 122px;
                line-height: 122px
            }

            .notfound .notfound-404 h1 {
                font-size: 122px
            }
        }

    </style>

    <meta name="robots" content="noindex, follow">
</head>

<body>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>5<span>0</span>0</h1>
            </div><br>
            <p>Ha ocurrido un error!</p>
            <a href="{{ asset('index') }}">Ir a la página de inicio</a>
        </div>
    </div>
</body>

</html>
