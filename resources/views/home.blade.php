@extends('layouts.app')
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
      <li class="active"><a href="{{url('home')}}">All</a></li>
      <li><a href="{{url('home',['id'=>0])}}">Finance</a></li>
      <li><a href="{{url('home', ['id' => 1])}}">HR</a></li>
      <li><a href="{{url('home', ['id' => 2])}}">IT</a></li>
      <li><a href="{{url('home', ['id' => 3])}}">Marketing</a></li>
      <li><a href="{{url('home', ['id' => 4])}}">Operations</a></li>
      <li><a href="{{url('home', ['id' => 5])}}">Sales</a></li>
      <li><a href="{{url('home', ['id' => 6])}}">Supply Chain</a></li>
    </ul>
  </div>
</nav>
        <div class="row_header">
          
        </div>  
        <div class="row">
                
                    <div class="col-md-2">
                     <div class="priorities" id="priorities">
                    
                        <p>Show Priorities</p>
                         <input type="checkbox" name="Priority" value="0" checked onchange="checking1()" id="high_par"> High Priority<br><br>
                         <input type="checkbox" name="Priority" value="1" checked onchange="checking2()" id="Purs_par"> Pursue Opportunistically<br><br>
                         <input type="checkbox" name="Priority" value="2" checked onchange="checking3()" id="mon_par"> Monitor<br><br>
                         <input type="checkbox" name="Priority" value="3" checked onchange="checking4()" id="Long_check"> Long Term<br><br> 
                     </div>
                    </div>
                    <div class="col-md-10">
                    {{-- <p class="opert">Opportunities: </p> --}}
                         <div id="point_chart">
                              <p id="high">High Priority</p> 
                              <p id="par_2">3</p>  
                              <p id="par_2_one">2</p>
                              <p id="par_2_two">2</p>
                              <p id="par_2_three">2</p>
                              <p id="par_2_four">2</p>
                               <p id="par_2_five"></p>
                              <p id="Pursue">Pursue Opportunistically</p> 
                              <p id="Monitor_par">Monitor</p> 
                              <p id="Long">Long Term</p>  

                              <div style="width:100%;" class="chart">
                                 

                                     {!! $bubblechartjs->render() !!} 
                              </div>
                             
                           <div id="img-out">
                             
                           </div>

                              <hr class="vertical" id="vertical"/>
                              <hr class="horizental" id="horizental"/>
                              <div class="HighPriority hidden" id="HighPriority">
                              
                              </div>
                              <div class="PursueOpportunistically hidden" id="PursueOpportunistically">
                                    
                              </div>
                              <div class="Monitor hidden" id="Monitor">
                              
                              </div>
                              <div class="LongTerm hidden" id="LongTerm">

                              </div>    
                              <div class="description">
                              <p> <?php $fin=explode(".",$description['Finance_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['HR_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['Marketing_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['Operations_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['Sales_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['Finance_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              <p> <?php $fin=explode(".",$description['SupplyChain_Description']);
                                        print_r($fin[0]);  
                                   ?>
                              </p>
                              </div>
                              </div>                 
                    </div>   
          </div> 
         
    </div>  
@endsection
