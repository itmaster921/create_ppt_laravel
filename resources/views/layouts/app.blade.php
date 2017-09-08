<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
  
    <style>
        body {
            font-family: 'Lato';
            background: silver;
        }

        .fa-btn {
            margin-right: 6px;
        }
        .chart{
          background: white;
             height: 640px;
        }
        .priorities{
               background: white;
              width: 249px;
             height: 581px;
              padding-top: 103px;
              font-size: 20px;
              padding-left: 21px;
        }
        .Monitor{
                   width: 288px;
              height: 252px;
              background: #fff;
              position: absolute;
              bottom: -161px;
              left: 347px;
        }
        .Monitor_finance{
             width: 177px;
              height: 257px;
              background: white;
              position: absolute;
              bottom: 120px;
              left: 471px;

        }
        #par_2_HR{
          position: absolute;
          top: 135px;
          left: 581px;
        }
        .Monitor_Sales{
                       width: 266px;
                      height: 235px;
                      background: white;
                      position: absolute;
                      bottom: 120px;
                      left: 473px;
        }
        .NewMonitor{
          width: 524px;
          height: 227px;
          background: white;
          position: absolute;
          bottom: 275px;
          left: 13px;
        }
        checkbox{
          padding-bottom: 10px;
        }
       hr { 
          display: block;
          margin-top: 0.5em;
          margin-bottom: 0.5em;
          margin-left: auto;
          margin-right: auto;
          border-style: inset;
          border-width: 1px;
      }
      /* hr.vertical
        {
            
                       height: 84%;
                        position: absolute;
                        background: silver;
                        bottom: 108px;
                        left: 468px;
                        border-color: silver;
                        border-width: 1px;

        } */
        .newVertical {
          height: 54%;
            /* color: silver; */
            position: absolute;
            background: silver;
            bottom: 287px;
            left: 544px;
            border-color: silver;
            border-width: 1px;
        }
        .newVertical_one{
              /* width: 2px; */
            height: 54%;
            /* color: silver; */
            position: absolute;
            background: silver;
            bottom: 288px;
            left: 544px;
            border-color: silver;
            border-width: 1px;
        }
     /*   hr.horizental{
                                  display: block;
                            margin-top: 0.5em;
                            margin-bottom: 0.5em;
                            margin-left: auto;
                            margin-right: auto;
                            border-style: inset;
                            border-width: 1px;
                            position: relative;
                            bottom: 371px;
                            border-color: silver;
                            width: 518px;
                            right: 182px;
        }*/
        .newHorizental{
                  display: block;
                  margin-top: 0.5em;
                  margin-bottom: 0.5em;
                  margin-left: auto;
                  margin-right: auto;
                  border-style: inset;
                  border-width: 1px;
                  position: relative;
                  bottom: 333px;
                  border-color: silver;
                  width: 929px;
                  /* right: 62px; */
                  position: relative;
                  left: 10px;
        }
        .HighPriority{
                  width: 285px;
                  height: 250px;
                  background: #fff;
                  position: absolute;
                  bottom: 96px;
                  left: 348px;
        }
        .HighPriority_finance{
                      width: 239px;
                    height: 207px;
                    background: white;
                    position: absolute;
                    bottom: 385px;
                    left: 471px;

        }
        .NewHighPriority{
          width: 427px;
          height: 200px;
          background: white;
          position: absolute;
          bottom: 499px;
          left: 534px;
        }
        .NewHighPriority_one{
          width: 428px;
            height: 213px;
            background: white;
            position: absolute;
            bottom: 486px;
            left: 533px;
        }
        hr.high_vertical
        {
            width: 0px;
            height: 213px;
            position: relative;
            right: 202px;
            border-width: 1px;
            border-color: silver;
            top: 24px;
        } 
        hr.high_horizontal {
                 display: block;
                  margin-top: 0.5em;
                  margin-bottom: 0.5em;
                  margin-left: auto;
                  margin-right: auto;
                  border-style: inset;
                  border-width: 1px;
                  position: relative;
                  bottom: 27px;
                  border-color: silver;
        }
        .Newhigh_horizontal{
          display: block;
          margin-top: 0.5em;
          margin-bottom: 0.5em;
          margin-left: auto;
          margin-right: auto;
          border-style: inset;
          border-width: 1px;
          position: relative;
          bottom: 40px;
          border-color: silver;
        }
        .Newhigh_horizontal_one{
          display: block;
          margin-top: 0.5em;
          margin-bottom: 0.5em;
          margin-left: auto;
          margin-right: auto;
          border-style: inset;
          border-width: 1px;
          position: relative;
          bottom: 27px;
          border-color: silver;
        }
        .PursueOpportunistically{
                   width: 286px;
              height: 250px;
              background: #fff;
              position: absolute;
              bottom: 96px;
              left: 56px;
        }
        hr.Monitor_vertical{
              width: 0px;
              height: 206px;
              position: relative;
              right: 202px;
              border-width: 1px;
              border-color: #f9f5f5;
              /* top: 24px; */
              bottom: 266px;
              right: 500px;

        }
        hr.Monitor_horizontal{
           display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
            position: relative;
            bottom: 275px;
            border-color: #f3f2f2;
            width: 555px;
            left: 19px;
        }
        .y-axis{
          padding-top: 15px;
        }
        .x-axis{
              position: relative;
              bottom: 55px;
        }
        .my_x{
          float: left;
        }
        .x_axis_ul{
          list-style: none;
        }
        .x_axis_ul li{
          width:95px;
        }
        .LongTerm{
                width: 287px;
            height: 251px;
            background: #fff;
            position: absolute;
            bottom: -161px;
            left: 55px;
        }
        #LongTerm_Sales{
                              width: 295px;
                        height: 253px;
                        background: white;
                        position: absolute;
                        bottom: 121px;
                        left: 165px;
          }
        .NewLongTerm{
                  width: 398px;
                  height: 196px;
                  background: white;
                  position: absolute;
                  bottom: 300px;
                  left: 553px;
        }
        .NewLongTerm_one{
          width: 398px;
          height: 196px;
          background: white;
          position: absolute;
          bottom: 299px;
          left: 553px;
        }
        .chart-legend {
          list-style: none;
          margin: 0;
          padding:20;
        }
        #bubbleChartTest{
              display: block;
            height: 542px;
            width: 1071px;
        }
        .description{
              width: 403px;
              position: relative;
              bottom: 519px;
              font-size: 12px;
              left: 818px;
              /* top: 12px; */
        }
        .opert{
          background: white;
            height: 50px;
            padding-top: 14px;
            font-size: 17px;
        }
        .chart{
          background: white;
        height: 581px;
        }
        #high{
                 position: absolute;
              top: 55px;
              left: 506px;
              bottom: 591px;
        }
        #Pursue{
                          position: absolute;
                      top: 57px;
                      left: 53px;
                      bottom: 593px;
        }
        #Long{
                         position: absolute;
            top: 317px;
            left: 65px;
        }
        #Long_sales{
                         position: absolute;
                        top: 219px;
                        left: 101px;
        }
       #Monitor_par{
                  position: absolute;
                top: 316px;
                left: 579px;
        }
        #Monitor_par_finance{
              position: absolute;
              top: 224px;
              left: 652px;
        }

        #point_chart{
          height: 600px;
        }
        #par_2{
                    position: absolute;
                top: 135px;
                left: 552px;

        }
        #par_2_one{
               position: absolute;
              top: 238px;
              left: 494px;
        }
        #par_2_two{
                        position: absolute;
                      top: 238px;
                      left: 608px;

        }
        #par_2_three{
                position: absolute;
                top: 395px;
                left: 494px;
        }
         #par_2_three_sales{
               position: absolute;
                top: 395px;
                left: 504px;
        }
        #par_2_four{
            position: absolute;
            top: 447px;
            left: 208px;
        }
        #par_2_five{
                   position: absolute;
                  top: 498px;
                  left: 138px;
                  background: white;
                  width: 40px;
                  height: 23px;
        }
         #par_2_five_finance{
                      position: absolute;
                      top: 498px;
                      left: 103px;
                      background: white;
                      width: 40px;
                      height: 23px;
        }
        #par_2_five_HR{
                     position: absolute;
                      top: 498px;
                      left: 103px;
                      background: white;
                      width: 40px;
                      height: 23px;
        }
        .navbar-nav li{
          width: 160px;
        }
        .row_header{
              height: 100px;
              background: white;
        }
        .highcharts-tooltip h3 {
    margin: 0.3em 0;
}

    </style>
 
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                   
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <input type="hidden" id="base_url" value="{{url('/')}}">

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script> 
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
  /**
  * Highcharts exportation functions
  * @author Our Code World
  */
 (function(window){
    
    function ExportInitializator(){
        var exp = {};
        
 
        var EXPORT_WIDTH = 1000;  // Exportation width
        
    
    /**
     * This method requires the highcharts_export.js file 
     */
        exp.highchartsSVGtoImage = function(chart,callback) {
            var svg = chart.highcharts().getSVG();
            var canvas = document.createElement('canvas');
            canvas.width = chart.width();
            canvas.height = chart.height();
            var ctx = canvas.getContext('2d');

            var img = document.createElement('img');

            img.onload = function() {
                ctx.drawImage(img, 0, 0);
                callback(canvas.toDataURL('image/png'));
            };

            img.setAttribute('src', 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg))));
        };
        
        /**
     * This method requires the highcharts_export.js file 
     */
        exp.highchartsCustomSVGtoImage = function(chart,callback){
            if(!chart){
                console.error("No chart given ");
            }
            var render_width = EXPORT_WIDTH;
            var render_height = render_width * chart.chartHeight / chart.chartWidth;

            var svg = chart.getSVG({
                exporting: {
                    sourceWidth: chart.chartWidth,
                    sourceHeight: chart.chartHeight
                }
            });
            
 
            
            var canvas = document.createElement('canvas');
            canvas.height = render_height;
            canvas.width = render_width;
            var image = new Image();
            image.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg)));
            console.log(image);
            image.addEventListener('load', function() {
                console.log(chart);
                canvas.getContext('2d').drawImage(this, 0, 0, render_width, render_height);
                callback(canvas.toDataURL('image/png'));
            }, false);

            image.src = 'data:image/svg+xml;base64,' + window.btoa(svg);
        };
         
    
    /**
     * This method requires the highcharts_export.js file 
     */
        exp.nativeSVGtoImage = function(DOMObject,callback,format){
            if(!DOMObject.nodeName){
                throw new error("Se requiere un objeto DOM de tipo SVG. Obtener con document.getElementById o un selector de jQuery $(contenedor).find('svg')[0]");
            }
                    
            var svgData = new XMLSerializer().serializeToString(DOMObject);
            var canvas = document.createElement("canvas");
            canvas.width = $(DOMObject).width();
            canvas.height = $(DOMObject).height();
            var ctx = canvas.getContext( "2d" );
            var img = document.createElement("img");
            img.setAttribute( "src", "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgData))) );
            img.onload = function() {
                ctx.drawImage( img, 0, 0 );
                
                if(format === "jpeg" || format === "jpg"){
                    callback(canvas.toDataURL("image/jpeg"));
                }else{
                    callback(canvas.toDataURL("image/png"));
                }
            }; 
            return true;
        };
        return exp;
    }
    
    if(typeof(highchartsExport) === 'undefined'){
        window.highchartsExport = new ExportInitializator();
    }
})(window);

</script>
   
    <script type="text/javascript">
  
       function get_product(id){
        var id=id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
            $.ajax({
               type:'POST',
               url: "getproduct/"+id,
               data:id,
               success:function(data){
                console.log(data);
                  $(".description").val(data.description);
                  $(".productName").val(data.productName);
                  $("#product_id").val(data.id);
               }
            });
       } 
       function del_product(id){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
         var id=id;
          $.ajax({
               type:'POST',
               url: "delproduct/"+id,
               data:id,
               success:function(data){
                window.location.replace("productList");

               }
            });

       }
       function get_ppt(){
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
        var newWin = window.open('');        

          var canvas = document.getElementById("lineChartTest");
          var img    = canvas.toDataURL("image/jpg");
          var img_one;
          highchartsExport.nativeSVGtoImage($("#container").find("svg")[0],function(uri){
            saveimage(img,uri, newWin);
          },'png');     
       }
       function saveimage(img,img_one, newWin){
            console.log('abc');
            $.ajax({
                           type:'POST',
                           url: $("#base_url").val() + "/ImageSave",
//                           contentType: "application/json; charset=utf-8",
//                            data: "{'radar':'" + img + "', 'bubble':'" + img_one+ "'}",
                            data: {'radar':img , 'bubble':img_one},
                            success:function(data){
                                newWin.location = data.url;
                                window.setTimeout(function(){
                                    newWin.close();
                                }, 1500)

                           }
                        });
       }
       function checking1(){
    
        
        if(document.getElementById("high_par").checked){
         $("#HighPriority").addClass("hidden");

        }
        else{
           $("#HighPriority").removeClass("hidden");
           $("#vertical").addClass("vertical");
          
        }
       }
       function checking1_finance(){
         if(document.getElementById("high_par").checked){
           $("#HighPriority_finance").addClass("hidden");

        }
        else{
           $("#HighPriority_finance").removeClass("hidden");
           $("#vertical").addClass("vertical");
          
        }
       }
       function checking2(){ 
        if(document.getElementById("Purs_par").checked){
           $("#PursueOpportunistically").addClass("hidden");
          }
          else{
             $("#PursueOpportunistically").removeClass("hidden");
           
          }
    
       }
       function checking3(){
         if(document.getElementById("mon_par").checked){
            $("#Monitor").addClass("hidden");
         }
         else{
            $("#Monitor").removeClass("hidden");
            
          }
        
       }
       function checking3_sales(){

            if(document.getElementById("mon_par").checked){
            $("#Monitor_Sales").addClass("hidden");
         }
         else{
            $("#Monitor_Sales").removeClass("hidden");
            
          }
       }
       function checking4_sales(){


            if(document.getElementById("Long_check").checked){
            $("#LongTerm_Sales").addClass("hidden");
         }
         else{
            $("#LongTerm_Sales").removeClass("hidden");
            
          }
       }
       function checking4(){
        if(document.getElementById("Long_check").checked){
         
            $("#LongTerm").addClass("hidden");
         }
          else{
            $("#LongTerm").removeClass("hidden");
        
           
          }
       

       }
    </script>
    <script type="text/javascript">
      var customTooltips = function (tooltip) {
      $(this._chart.canvas).css("cursor", "pointer");
      var positionY = this._chart.canvas.offsetTop;
      var positionX = this._chart.canvas.offsetLeft;
      $(".chartjs-tooltip").css({
        opacity: 0,
      });
      if (!tooltip || !tooltip.opacity) {
        return;
      }
      if (tooltip.dataPoints.length > 0) {
        tooltip.dataPoints.forEach(function (dataPoint) {
          var content = [dataPoint.xLabel, dataPoint.yLabel].join(": ");
          var $tooltip = $("#tooltip-" + dataPoint.datasetIndex);
          $tooltip.html(content);
          $tooltip.css({
            opacity: 1,
            top: positionY + dataPoint.y + "px",
            left: positionX + dataPoint.x + "px",
          });
        });
      }
    };
 
    </script>
</body>
</html>
