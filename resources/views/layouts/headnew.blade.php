    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="description" content="PacketPrep is an online video learning preparation platform for quantitative aptitude, logical reasoning, mental ability, general english and interview skills.">
    <meta name="keywords" content="quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures">
    <meta name="author" content="Krishna Teja G S">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PacketPrep - Prepare for Campus Placements, Bank Exams and Government Jobs </title>

    <!-- Styles -->
   <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    </head>
    <body>
    
    @yield('content-main')
    
    <!-- Scripts -->

     @include('snippets.scripts')
    </body>
    </html>
