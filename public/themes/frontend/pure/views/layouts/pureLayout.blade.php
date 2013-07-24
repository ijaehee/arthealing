<!DOCTYPE html>
<html>
    <head> 
        <title>Read,Write,Share :: sageul </title>
        <?php
            Asset::queue('bootstrap','css/bootstrap.css'); 
            Asset::queue('reset','css/reset.css'); 
            $styles = Asset::getCompiledStyles() ; 
            $scripts = Asset::getCompiledScripts() ; 

        ?>
        @foreach($styles as $key => $style)
        <link type="text/css" rel="stylesheet" href="{{$style}}" />
        @endforeach

        @foreach($scripts as $key => $script)
        <script src="{{$script}}" ></script>
        @endforeach
    </head>
    <body> 
        @yield('content')
    </body>
</html>
