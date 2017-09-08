@extends('layouts.app')
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
  <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><p style="text-align: center;">Radar Chart</p></div>
                  <button class="btn btn-info btn-md" onclick="get_ppt()">get ppt</button>
                <div class="panel-body">
                    <div style="width:100%;">
                          {!! $chartjs->render() !!}
                        
                    </div>
                     <div id="image">
                           
                     </div>
                    
                </div>

            </div>
        </div>
</div>      
  
</div>

<div class="container-fluid" style="background: white;" id="point_image">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"></a>
            </div>
            <ul class="nav navbar-nav">
            <li class="active"><a href="{{url('home',['id'=>'All'])}}">All</a></li>
           
             @foreach ($LOB_arr_uniq as $item)
              <li><a href="{{url('home',['id'=>$item])}}">{{$item}}</a></li>
              @endforeach
            </ul>
          </div>
        </nav>
        <div class="row_header">
          
        </div>  
        <div class="row" id="point_chart">
                
                    <div class="col-md-2">
                     <!--div class="priorities" id="priorities">
                    
                        <p>Show Priorities</p>
                         <input type="checkbox" name="Priority" value="0" checked onchange="checking1()" id="high_par"> High Priority<br><br>
                         <input type="checkbox" name="Priority" value="1" checked onchange="checking2()" id="Purs_par"> Pursue Opportunistically<br><br>
                         <input type="checkbox" name="Priority" value="2" checked onchange="checking3()" id="mon_par"> Monitor<br><br>
                         <input type="checkbox" name="Priority" value="3" checked onchange="checking4()" id="Long_check"> Long Term<br><br> 
                     </div-->
                    </div>
                    <div class="col-md-10">
                   

                             <div id="container" style="height:100%; min-width: 310px; max-width:100%; margin: 0 auto">

                             </div>
                             
                               <div class="HighPriority hidden" id="HighPriority">
                              
                              </div>
                               <div class="PursueOpportunistically hidden" id="PursueOpportunistically">
                                    
                              </div>
                               <p id="high">High Priority</p> 
                              <p id="Pursue">Pursue Opportunistically</p> 
                              <p id="Monitor_par">Monitor</p> 
                              <p id="Long">Long Term</p> 
                               <div class="Monitor hidden" id="Monitor">
                              
                              </div>
                              <div class="LongTerm hidden" id="LongTerm">

                              </div> 

                              </div>                 
                    </div>   
          </div> 
         
    </div>  
   <script type="text/javascript">
      $(document).ready(function(){
 
        var bubbledata = {!! str_replace("'", "\'", json_encode($dataset_arr)) !!};
         //console.log(data)

  Highcharts.chart('container', {

    chart: {
            type: 'bubble',
            width: 800,
            height:600

        },
  
    legend: {
        enabled: true,
        align: 'right',
        verticalAlign: 'top',
        padding: 3,
        itemMarginBottom: 25,
        labelFormatter: function() {
                        return  this.name ;
        },
        itemStyle: {
                 fontSize:'20px',
              },
        layout: 'vertical',
        x: 0,
        y: 100
    },
    title: {
        text: 'Analytics Strategy Assessment'  },

   xAxis: {
            gridLineWidth: 0,
            min: 0,
            max: 11,
            tickInterval:1,
            labels:{enabled: false},
            title: {
                text: 'Degree of Business Impact'

            },
            plotLines: [{
              color: 'red', // Color value
              dashStyle: 'line', // Style of the plot line. Default to solid
              value: 5.5, // Value of where the line will appear
              width: 2, // Width of the line
              label: [{
                text: 'Monitor',
                align: 'right',
                verticalAlign: 'bottom'
              }]          
            }]
      },

     yAxis: {
             gridLineWidth: 0,
            min: 0,
            max: 11,
            tickInterval:1,
            labels:{enabled: false},
            title: {
                text: 'Degree of Business Pain'

            },
           plotLines: [{
              color: 'red', // Color value
              dashStyle: 'line', // Style of the plot line. Default to solid
              value: 5.5, // Value of where the line will appear
              width: 2, // Width of the line
              label: {
                 verticalAlign: 'middle',
                 textAlign: 'center'
              }    
            }]
        
        },

     tooltip: {
            formatter: function () {
                var s;
                if (this.point.name) { // the pie chart
                    s = 'Degree of Business Pain : ' + this.y + '<br>Degree of Business Impact : ' + this.x;
                } else {
                    s = 'Degree of Business Pain : ' + this.y + '<br>Degree of Business Impact : ' + this.x;
                }
                return s;
            }
        },
    plotOptions: {
        bubble: {
            minSize:10,
            maxSize:30
        },
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },

    series: bubbledata

});
         
    });

   </script>
@endsection
