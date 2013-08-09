<!doctype html>
<html>
    <head> 
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="hello!" />
        <meta name="author" content="artgrafii" />
        <title>artgrafii </title>
        <?php 
            Asset::queue('bootstrap','css/bootstrap.css') ;
            Asset::queue('bootstrapDocs','css/docs.css') ;
            Asset::queue('style','css/style.css','bootstrapDocs') ; 
            Asset::queue('jquery','js/jquery.js') ; 
            $styles = Asset::getCompiledStyles() ; 
            $scripts = Asset::getCompiledScripts() ; 
        ?>
        @foreach($styles as $key => $style) 
        <link type="text/css" rel="stylesheet" href="{{$style}}" />
        @endforeach
        @foreach($scripts as $key => $script) 
        <script src="{{$script}}"> </script>
        @endforeach
        <style>
        .body-wrapper { padding-left : 240px;background:#fff;padding-right:25px;}
        .body-wrapper .top {z-index:300; position:fixed ; top:0 ;left:0;width:100%; ;height:55px;background:#fff; border-bottom:1px solid #ccc;  }
        .body-wrapper .sidebar .logo-wrapper { background:#f6f6f6;padding:0px;text-align:center;padding-top:22px;padding-bottom:22px;border-bottom:1px solid #eee;}
        .body-wrapper .sidebar .logo {}
        .body-wrapper .sidebar {z-index:100; width: 175px;position:fixed ; top:0px; left:0; background:#00b4d6 ;height:100%; } 
        .body-wrapper .sidebar ul { list-style:none ; }
        .body-wrapper .sidebar ul li { list-style:none ;margin-top:00px;margin-bottom:00px;text-align:left; }
        .body-wrapper .sidebar ul li a .nav-label {display:inline-block;vertical-align:middle;height:30px;font-size:1.0em;padding-left:10px; }
        .body-wrapper .sidebar ul li.active {  }
        .body-wrapper .sidebar ul li.active a {color:#000; background:#fff;}
        .body-wrapper .sidebar ul li a { display:block;color:#fafafa;padding-top:15px;padding-bottom:15px;padding-left:15px;font-family:"Helvetica Neue" ;font-size:1.2em; }
        .body-wrapper .sidebar ul li a:hover { display:block;color:#000;background:rgb(77,212,238);color:#fff; }
        .contents {  padding-left:0px; padding-right:0px;  }
        .section-title { font-size:2.5em; color:#888;margin-bottom:30px;margin-top:30px;}
        .control-group input { border:2px solid #afafaf;}
        .btn-primary { background : #00b4d6 ; border-color : #00b4d6 ;}
        .btn-primary:hover,.btn-primary:active,.btn-primary:focus { background :#0DA2BE  ; border-color : #0DA2BE ;}
        </style>    
    </head>
    <?php
        //$action = '' ; 
    ?>
    <body class="body-wrapper"> 
        <div class="sidebar">
            <div class="logo-wrapper">
                <a class="logo"><img src="/assets/img/artgrafii_logo.png" style="width:55%;" /></a>
            </div>
            <br/>
            <br/>
            <br/>
            <ul class="nav">
                <li @if($action=='member') class="active" @endif > <a href="/member/list"><i class="glyphicon glyphicon-user" style="font-size:22px;"></i>&nbsp;<span class="nav-label" >Member</span></a> </li>
                <li @if($action=='program') class="active" @endif ><a href="/program/list"><i class="glyphicon glyphicon-picture" style="font-size:22px;"></i>&nbsp;<span class="nav-label" >Program</span></a></li> 
                <li @if($action=='register') class="active" @endif ><a href="/register/list"><i class="glyphicon glyphicon-th-list" style="font-size:22px;"></i>&nbsp;<span class="nav-label" >Resiters</span></a></li>
                <li @if($action=='group') class="active" @endif ><a href="/group/list"><i class="glyphicon glyphicon-cog" style="font-size:22px;"></i>&nbsp;<span class="nav-label" >Group</span></a></li>
                <!--<li @if($action=='profile') class="active" @endif ><a href="#"><i class="glyphicon glyphicon-pencil" style="font-size:25px;"></i></a> </li>
                <li @if($action=='profile') class="active" @endif ><a href="#"><i class="glyphicon glyphicon-comment" style="font-size:25px;"></i></a> </li>-->
            </ul> 
            <div>
            </div>
        </div>
        <div class="contents">
            @yield('content')
        </div> 
    </body> 
</html>
