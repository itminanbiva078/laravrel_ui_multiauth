<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->

    <style>
        *{padding: 0; margin: 0;}
        body {
            font-family: 'Nunito', sans-serif;
            background-image: linear-gradient(235deg,#002156,#091C3B 18%,#3B0320);
            height: 100vh;
        }
        .splash{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .splash h1{
            color: #fff;
            font-weight: 700;
            font-size: 50px;
        }
    </style>
</head>
<body>
<div class="splash">
    <h1>Welcome to Paynow</h1>

{{--    <a data-aos="zoom-in-up" data-aos-delay="50"--}}
{{--       data-aos-duration="1000" href="{{ route('consumer.login.show') }}">Consumer</a>--}}
</div>


</body>
</html>
