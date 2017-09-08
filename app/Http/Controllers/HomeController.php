<?php

namespace App\Http\Controllers;
use App\SimpleController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\User;
use GuzzleHttp\Client;
use Validator;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use \PhpOffice\PhpPresentation\Shape\Chart\Gridlines;
//set_time_limit(10);
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Shape\RichText;
use App\Http\Controllers\PhpPptTree;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=0)
    {
       // dd($id);
           $client = new Client();
           //this is api 
           $res = $client->get('https://sap-bi-strategy-assessment.com/playbook_ws4/disp?req=get_pains&email=ryan%40centigonsolutions.com&passcode=abc123');
        
                 $jsondata=$res->getBody();
                 $myjson=json_decode($jsondata);
                 $mylabal=$myjson[0];
                 $Description=[];
                 $mydata=array_shift($myjson);                 
                 $Finance_PainValue=[];
                 $Finance_ImpactValue=[];
                 $Finance_Description;
                 $HR_PainValue=[];
                 $HR_ImpactValue=[];
                 $HR_Description;
                 $IT_PainValue=[];
                 $IT_ImpactValue=[];
                 $IT_Description;
                 $Marketing_PainValue=[];
                 $Marketing_ImpactValue=[];
                 $Marketing_Description;
                 $Operations_PainValue=[];
                 $Operations_ImpactValue=[];
                 $Operations_Description;
                 $Sales_PainValue=[];
                 $Sales_ImpactValue=[];
                 $Sales_Description;
                 $SupplyChain_PainValue=[];
                 $SupplyChain_ImpactValue=[];
                 $SupplyChain_Description;
                 $total_painvalue=[];
         //radar chart data
          $client = new Client();
           $radarres = $client->get('https://sap-bi-strategy-assessment.com/playbook_ws/disp?req=get_strategies&email=ryan%40centigonsolutions.com&passcode=abc123');  
           $radardata=$radarres->getBody();
           $radarjson=json_decode($radardata);
           $radarlabal=$radarjson[0];
           $radarData=array_shift($radarjson);
           $Objectives_ImpactValue=[];
           $BINeeds_ImpactValue=[];
           $BusinessCase_ImpactValue=[];
           $Information_ImpactValue=[];
           $Organization_ImpactValue=[];
           $total_number=[];
           $LevelofExistence=[]; 
           $LevelofExecution=[]; 
           $Impact=[]; 
           $radar_value=[];
           //dd($radarjson);
          foreach ($radarjson as $data) {
              foreach ($data as $key => $value) {
                if($key==3){
                    array_push($radar_value,$value);
                }
                if($key==5)
                {
                    array_push($LevelofExistence,$value);
                      
                    
                } 
                 if($key==6)
                {
                    array_push($LevelofExecution,$value);
                      
                   
                } 
                  if($key==7)
                {
                    array_push($Impact,$value);
                      
                   
                } 

             
              }
          }
        // dd($radar_value);
        //data for point chart  
          $LOB_arr=[];
          $LOB_arr_uniq=[];
          $LOB_arr_uniq_len = "";
          $pain = [];
          $impact = [];
          $description = [];
          $similar_values = "";
          $similar_values_arr = [];
          $newsimilar_values_arr = [];
          $pos_similar_arr = [];
          foreach($myjson as $data)
         {
            foreach ($data as $key => $value) {
                if($key==5)
                {
                    array_push($LOB_arr, $value);
                }                
            }
            if(!empty($data[8]) && !empty($data[9]))
            {
                $similar_values = array('word'=>$data[9]."$".$data[8]);
                array_push($similar_values_arr, $similar_values);
            }            
        }
        $pos_similar_arr_final = [];
        $pos_similar_arr = (array_count_values(array_column($similar_values_arr, 'word')));
        foreach ($pos_similar_arr as $key => $value)
            {
                if ($value > 1)
                   array_push($pos_similar_arr_final, $key."@".$value);
            }

        $LOB_arr_uniq = array_unique($LOB_arr);
        $LOB_arr_uniq = array_values($LOB_arr_uniq);
        $LOB_arr_uniq_len = count($LOB_arr_uniq);
        for($i=0;$i<$LOB_arr_uniq_len;$i++)
            {
                $pain[$LOB_arr_uniq[$i]]=[];
                $impact[$LOB_arr_uniq[$i]]=[];
                $description[$LOB_arr_uniq[$i]] = [];

            }
         foreach($myjson as $data)
         {
            foreach ($data as $key => $value) {
                if($key==8)
                {
                    if(empty($data[8])){
                         $value=0;
                    }
                    array_push($total_painvalue,$value);
                }

                if($key==5)
                {
                    for($i=0;$i<$LOB_arr_uniq_len;$i++)
                    {
                        if($value==$LOB_arr_uniq[$i])
                        {
                            if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }

                            //$Finance_Description=$data[2];  
                           array_push($pain[$LOB_arr_uniq[$i]],$data[8]);
                           array_push($impact[$LOB_arr_uniq[$i]],$data[9]); 
                        }    
                    }
                }        
            }
        } 
       /* $description = compact("Finance_Description", "HR_Description","IT_Description","Marketing_Description","Operations_Description","Sales_Description","SupplyChain_Description");
       */
           $min=min($total_painvalue);
           $max=max($total_painvalue);
      

         $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('radar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($radar_value)
        ->datasets([
            [
                "label" => ["Level of Existence"],
                'backgroundColor' => "rgba(22, 107, 177,0.4)",
                'borderColor' => "rgba(22, 107, 177,0.4)",
                "pointBorderColor" => "rgba(22, 107, 177,0.7)",
                "pointBackgroundColor" => "rgba(22, 107, 177,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$LevelofExistence
            ], 
            [
                "label" => ["Level of Execution"],
                'backgroundColor' => "rgba(225, 140, 38,0.4)",
                'borderColor' => "rgba(225, 140, 38,0.4)",
                "pointBorderColor" => "rgba(225, 140, 38,0.7)",
                "pointBackgroundColor" => "rgba(225, 140, 38,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$LevelofExecution
            ],  
            [
                "label" => ["Impact"],
                'backgroundColor' => "rgba(0, 208, 210,0.4)",
                'borderColor' => "rgba(0, 208, 210,0.4)",
                "pointBorderColor" => "rgba(0, 208, 210,0.7)",
                "pointBackgroundColor" => "rgba(0, 208, 210,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$Impact
            ],
          
         

          
          
        ])->optionsRaw("{
            scales: {
                 yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero: true,
                                steps:2,
                                stepValue:2,
                                max:20
                            }
                        }]
            }
         
        }");
        // dd($HR_ydata);
           $data_count = "";
           $xy_array=[];
           $dataset="";
           $dataset_arr=[];
           $datacolor_main=array("rgba(22, 107, 177,0.4)",
                                "rgba(225, 140, 38,0.4)",
                                "rgba(0, 208, 210,0.4)",
                                "rgba(188, 77, 31,0.4)",
                                "rgba(181, 201, 70,0.4)",
                                "rgba(19, 127, 56,0.4)",
                                "rgba(171, 42, 146,0.4)",
                                "rgba(255, 231, 255, 0.9)",
                                "rgba(187, 0, 55, 0.9)",
                                "rgba(255, 93, 135, 0.9)",
                                "rgba(0, 0, 135, 0.9)",
                                "rgba(110, 58, 0, 0.8)",
                                "rgba(255, 213, 0, 0.8)");
            $datacolor_border=array("rgba(22, 107, 177,0.7)",
                                "rgba(225, 140, 38,0.7)",
                                "rgba(0, 208, 210,0.7)",
                                "rgba(188, 77, 31,0.7)",
                                "rgba(181, 201, 70,0.7)",
                                "rgba(19, 127, 56,0.7)",
                                "rgba(171, 42, 146,0.7)",
                                "rgba(255, 231, 255, 0.9)",
                                "rgba(187, 0, 55, 0.9)",
                                "rgba(255, 93, 135, 0.9)",
                                "rgba(0, 0, 135, 0.9)",
                                "rgba(110, 58, 0, 0.8)",
                                "rgba(255, 213, 0, 0.8)");
        



        //getting all data for chart   
            
          
             $con =0;   //demo
    $tipu=0;
            $comp_array=[];
            foreach($pos_similar_arr_final as $key=>$data)
            {

                $exp_x= explode('$', $data);
                $exp_y= explode('@', $exp_x[1]);
                $x = $exp_x[0];
                $y = $exp_y[0];
                $val = $exp_y[1];
                $comp_array[$key]=array('x'=>$x,'y'=>$y,'val'=>$val);                
            }
          


    if($id=='All'){      
         foreach($pain as $key=>$data)
           {
            $data_count = count($data);
            foreach($impact as $key1=>$data1)
            {

                if($key==$key1)
                {
                   //if($key=="Sales")
                    //dd($data);
                        for($i=0;$i<$data_count;$i++)
                        {
                            foreach ($comp_array as $data2) {
                                if($data2['x'] == $data1[$i] && $data2['y']==$data[$i])
                                {
                                    $xy_str=array("x"=>$data1[$i],"y"=>$data[$i],"name"=>$data2['val'],"country"=>$key);   
                                        break 1;
                                }
                                else
                                {
                                    $xy_str=array("x"=>$data1[$i],"y"=>$data[$i],"name"=>'',"country"=>$key);  
                                    continue;
                                }
                               
                            }
                          array_push($xy_array, $xy_str);   
                          $xy_str=[];                             
                        }    
                       
                }
                else
                {
                    continue;
                }
                continue;

            }
                        $dataset = array("name"=>$key,'color'=>$datacolor_main[$tipu]
                        ,"data" =>$xy_array
                        );
                        array_push($dataset_arr, $dataset);
                        $xy_array=[];
                        $dataset=[];
                        $tipu++;
                     
                
           }
        }
        else
        {

         foreach($pain as $key=>$data)
           {
            if($key==$id)
            {
                $data_count = count($data);
            foreach($impact as $key1=>$data1)
            {

                if($key==$key1)
                {
                   //if($key=="Sales")
                    //dd($data);
                        for($i=0;$i<$data_count;$i++)
                        {
                            foreach ($comp_array as $data2) {
                                if($data2['x'] == $data1[$i] && $data2['y']==$data[$i])
                                {
                                    $xy_str=array("x"=>$data1[$i],"y"=>$data[$i],"name"=>$data2['val'],"country"=>$key);   
                                        break 1;
                                }
                                else
                                {
                                    $xy_str=array("x"=>$data1[$i],"y"=>$data[$i],"name"=>'',"country"=>$key);  
                                    continue;
                                }
                               
                            }
                          array_push($xy_array, $xy_str);   
                          $xy_str=[];                             
                        }    
                       
                }
                else
                {
                    continue;
                }
                continue;

            }
                        $dataset = array("name"=>$key,'color'=>$datacolor_main[$tipu]
                        ,"data" =>$xy_array
                        );
                        array_push($dataset_arr, $dataset);
                        $xy_array=[];
                        $dataset=[];
                        $tipu++;
                     
                    }            
                
           }
        }
      
      return view('item', compact('chartjs','dataset_arr','description','LOB_arr_uniq'));
    }
    public function logout(){
        Auth::logout();
         return redirect()->intended('/');
    }
    public function SaveImage(Request $request){
           //dd($request);
//            $data = explode(',',$request);
//            print_r($request->get('radar'));exit;
            $data1 = $request->get('radar');
            $data2 = $request->get('bubble');
            
            $data1 = explode(",", $data1)[1];
            $data2 = explode(",", $data2)[1];

         
             $slide_no_22 = '21.jpg';
             $slide_no_21 = '22.jpg';
        
            file_put_contents($slide_no_21,base64_decode( $data1));
            file_put_contents($slide_no_22,base64_decode( $data2));
//            file_put_contents($slide_no_21,base64_decode( $data[5]));
//            file_put_contents($slide_no_22,base64_decode( $data[7]));
            // dd('abc');

            $dirname = __DIR__."/ppt/";
            
             $images = glob($dirname."*.jpg");
            // dd($images);
             
                 // $ppt_data=[];
                 // foreach ($images_arr as $key => $value) {
                 //        $myvalue=basename($value);
                 //        array_push($ppt_data, $myvalue);
                 // }
                 natsort($images);
                 function array_insert(&$array, $position, $insert)
                    {
                        if (is_int($position)) {
                            array_splice($array, $position, 0, $insert);
                        } else {
                            $pos   = array_search($position, array_keys($array));
                            $array = array_merge(
                                array_slice($array, 0, $pos),
                                $insert,
                                array_slice($array, $pos)
                            );
                        }
                    }
                   
                array_insert($images , 21,realpath(__DIR__ . '/../../../'.'/public/'.$slide_no_21));
                 array_insert($images , 22,realpath(__DIR__ . '/../../../'.'/public/'.$slide_no_22));
                // dd($images);
              

                   $objPHPPowerPoint = new PhpPresentation();
            // print_r($images_arr);die;  
          foreach ($images as $key => $value) {

                    //die();
                    // Create a shape (drawing)
                   $currentSlide = $objPHPPowerPoint->createSlide();
                        $shape = $currentSlide->createDrawingShape();

                        $shape->setName($key)
                              ->setDescription($value)
                              ->setPath($value)
                              ->setHeight(1500)
                              ->setWidth(900)
                              ->setOffsetX(20)
                              ->setOffsetY(30);
                       // $shape->getShadow()->setVisible(true)
                                          // ->setDirection(45)
                                        //   ->setDistance(10);
                  }                         
                  
                $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
                
                $filename = rand().".pptx";
                $oWriterPPTX->save(public_path() . "/finalppt/".$filename);
                
                return response()->json(array('url' => url("finalppt/".$filename)));
         

    }
    public function addProduct(){
        // $data = Auth::user()->name;
         //dd($data);
       // return view('profile')->with('name',$data);  
       return view('add');    
        
    }
    public function productSubmit(Request $request){
        $messages = array(
             'productName.required' => 'Product Name is required.',
             'description.required' =>'desciption is required'
            );
        $validator = Validator::make($request->all(), [
             'productName' => 'required|max:255',
             'description' =>'required',
        ],$messages);

            if ($validator->fails()) {
               return redirect('addProduct')
                 ->withInput()
                 ->withErrors($validator);
             }


                  $product = new Product;
                  $userId = Auth::id();
                  $user=User::find($userId)->getUsername;
                  dd($user);
                                   // $product->productName=$request->productName;
                  // $product->description=$request->description;
                  // $product->parent_Id=$request->productCategories;
                  // $product->save();

                  // return redirect()->intended('/productList');
    }
    public function productList(){
        $products = Product::all();
       return view('productList')->with('productList',$products); 
    }
    public function getProduct($id){
          $statusCode=200;
          $product = Product::where('id',$id)->first();
        // $id = Input::get('id');
         return response()->JSON($product,$statusCode,[],JSON_NUMERIC_CHECK);
    }
    public function formEdit(Request $request){
        $product = Product::where('id',$request->product_id)->first();
        $product->productName = $request->productName;
        $product->description = $request->description;
        $product->save();
        return redirect()->intended('/productList');

    }
    public function delproduct($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->intended('/productList');
    }
    public function getproducts(){
        $statusCode=200;
        $products = Product::all();
       // return view('add')->with('Products',$products); 
        return response()->JSON($products,$statusCode,[],JSON_NUMERIC_CHECK);
    }
    public function finance($id){
         $client = new Client();
           $res = $client->get('https://sap-bi-strategy-assessment.com/playbook_ws4/disp?req=get_pains&email=ryan%40centigonsolutions.com&passcode=abc123');
        
         $jsondata=$res->getBody();
         $myjson=json_decode($jsondata);
         $mylabal=$myjson[0];
         $Description=[];
         $mydata=array_shift($myjson);
         $Finance_PainValue=[];
         $Finance_ImpactValue=[];
         $Finance_Description;
         $HR_PainValue=[];
         $HR_ImpactValue=[];
         $HR_Description;
         $IT_PainValue=[];
         $IT_ImpactValue=[];
         $IT_Description;
         $Marketing_PainValue=[];
         $Marketing_ImpactValue=[];
         $Marketing_Description;
         $Operations_PainValue=[];
         $Operations_ImpactValue=[];
         $Operations_Description;
         $Sales_PainValue=[];
         $Sales_ImpactValue=[];
         $Sales_Description;
         $SupplyChain_PainValue=[];
         $SupplyChain_ImpactValue=[];
         $SupplyChain_Description;
         $total_painvalue=[];
         //radar chart data
          $client = new Client();
           $radarres = $client->get('https://sap-bi-strategy-assessment.com/playbook_ws/disp?req=get_strategies&email=ryan%40centigonsolutions.com&passcode=abc123');  
           $radardata=$radarres->getBody();
           $radarjson=json_decode($radardata);
           $radarlabal=$radarjson[0];
           $radarData=array_shift($radarjson);
           $Objectives_ImpactValue=[];
           $BINeeds_ImpactValue=[];
           $BusinessCase_ImpactValue=[];
           $Information_ImpactValue=[];
           $Organization_ImpactValue=[];
           $total_number=[];
           $LevelofExistence=[]; 
           $LevelofExecution=[]; 
           $Impact=[]; 
          

          foreach ($radarjson as $data) {
              foreach ($data as $key => $value) {
                if($key==5)
                {
                    array_push($LevelofExistence,$value);
                      
                    
                } 
                 if($key==6)
                {
                    array_push($LevelofExecution,$value);
                      
                   
                } 
                  if($key==7)
                {
                    array_push($Impact,$value);
                      
                   
                } 

             
              }
          }
       
         foreach($myjson as $data)
         {
            foreach ($data as $key => $value) {
                if($key==8)
                {
                    if(empty($data[8])){
                         $value=0;
                    }
                    array_push($total_painvalue,$value);
                }

                if($key==5 && $value=="Finance"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                            $Finance_Description=$data[2];  
                            array_push($Finance_PainValue,$data[8]);
                            array_push($Finance_ImpactValue,$data[9]);                    
                    

                    
                }
                 if($key==5 && $value=="HR"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                            $HR_Description=$data[2]; 
                            array_push($HR_PainValue,$data[8]);
                            array_push($HR_ImpactValue,$data[9]);                    
                    

                    
                }
                  if($key==5 && $value=="IT"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                            $IT_Description=$data[2]; 
                            array_push($IT_PainValue,$data[8]);
                            array_push($IT_ImpactValue,$data[9]);                    
                    

                    
                }
                 if($key==5 && $value=="Marketing"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                            $Marketing_Description=$data[2]; 
                            array_push($Marketing_PainValue,$data[8]);
                            array_push($Marketing_ImpactValue,$data[9]);                    
                    

                    
                }
                if($key==5 && $value=="Operations"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                             $Operations_Description=$data[2]; 
                            array_push($Operations_PainValue,$data[8]);
                            array_push($Operations_ImpactValue,$data[9]);                    
                    

                    
                }
                if($key==5 && $value=="Sales"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                          $Sales_Description=$data[2];     
                            array_push($Sales_PainValue,$data[8]);
                            array_push($Sales_ImpactValue,$data[9]);                    
                    

                    
                }
                 if($key==5 && $value=="Supply Chain"){
                        
                        if(empty($data[8])){
                            $data[8]=0;
                        }   
                        if(empty($data[9])){
                                 $data[9]=0;
                            }
                            $SupplyChain_Description=$data[2];  
                            array_push($SupplyChain_PainValue,$data[8]);
                            array_push($SupplyChain_ImpactValue,$data[9]);                    
                    

                    
                }
                
         }

        }
       
        $description = compact("Finance_Description", "HR_Description","IT_Description","Marketing_Description","Operations_Description","Sales_Description","SupplyChain_Description");
       
           $min=min($total_painvalue);
           $max=max($total_painvalue);
      

         $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('radar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(["Purpose and Goals","Current State and History","BI Objectives and Scope","Summary of BI Needs","Envisioned To-Be State","Priorities and Alignment","Value Proposition of BI","Expected Benefits- Future State KPI Levels","Payback","Information Categories","Architecture and Standards","BI Applications","Governance Structure","Program Management","Roadmap and Milestones","Measurement","Organization & Implementation","Organization & Implementation"])
        ->datasets([
            [
                "label" => ["Level of Existence"],
                'backgroundColor' => "rgba(22, 107, 177,0.4)",
                'borderColor' => "rgba(22, 107, 177,0.4)",
                "pointBorderColor" => "rgba(22, 107, 177,0.7)",
                "pointBackgroundColor" => "rgba(22, 107, 177,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$LevelofExistence
            ], 
            [
                "label" => ["Level of Execution"],
                'backgroundColor' => "rgba(225, 140, 38,0.4)",
                'borderColor' => "rgba(225, 140, 38,0.4)",
                "pointBorderColor" => "rgba(225, 140, 38,0.7)",
                "pointBackgroundColor" => "rgba(225, 140, 38,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$LevelofExecution
            ],  
            [
                "label" => ["Impact"],
                'backgroundColor' => "rgba(0, 208, 210,0.4)",
                'borderColor' => "rgba(0, 208, 210,0.4)",
                "pointBorderColor" => "rgba(0, 208, 210,0.7)",
                "pointBackgroundColor" => "rgba(0, 208, 210,0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" =>$Impact
            ],
          
         

          
          
        ])->optionsRaw("{
            scales: {
                 yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero: true,
                                steps:2,
                                stepValue:2,
                                max:20
                            }
                        }]
            }
         
        }");
         //bubble chart
        //data for Finance

    $finance_xdata=[];
    $finance_ydata=[];
       foreach ($Finance_ImpactValue as $key => $value) {
            array_push($finance_xdata,$value);
            foreach ($Finance_PainValue as $key => $value) {
                array_push($finance_ydata,$value);
            }
       }
       //dd($finance_ydata);
       //data for HR
        $HR_xdata=[];
        $HR_ydata=[];
           foreach ($HR_ImpactValue as $key => $value) {
                array_push($HR_xdata,$value);
                foreach ($HR_PainValue as $key => $value) {
                    array_push($HR_ydata,$value);
                }
           }
         //data for IT
        $IT_xdata=[];
        $IT_ydata=[];
           foreach ($IT_ImpactValue as $key => $value) {
                array_push($IT_xdata,$value);
                foreach ($IT_PainValue as $key => $value) {
                    array_push($IT_ydata,$value);
                }
           }
          // dd($IT_ydata);
        //data for Marketing
        $Marketing_xdata=[];
        $Marketing_ydata=[];
           foreach ($Marketing_ImpactValue as $key => $value) {
                array_push($Marketing_xdata,$value);
                foreach ($Marketing_PainValue as $key => $value) {
                    array_push($Marketing_ydata,$value);
                }
           }

        //data for Operations
        $Operations_xdata=[];
        $Operations_ydata=[];
           foreach ($Operations_ImpactValue as $key => $value) {
                array_push($Operations_xdata,$value);
                foreach ($Operations_PainValue as $key => $value) {
                    array_push($Operations_ydata,$value);
                }
           }
        //data for Sales
        $Sales_xdata=[];
        $Sales_ydata=[];
           foreach ($Sales_ImpactValue as $key => $value) {
                array_push($Sales_xdata,$value);
                foreach ($Sales_PainValue as $key => $value) {
                    array_push($Sales_ydata,$value);
                }
           }

        //data for Supply Chain 
        $SupplyChain_xdata=[];
        $SupplyChain_ydata=[];
           foreach ($SupplyChain_ImpactValue as $key => $value) {
                array_push($SupplyChain_xdata,$value);
                foreach ($SupplyChain_PainValue as $key => $value) {
                    array_push($SupplyChain_ydata,$value);
                }
           }
        // dd($HR_ydata);
    if($id==0){    
          $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
            [
                "label" => ["Finance"],
                'backgroundColor' => "rgba(22, 107, 177,0.4)",
                'borderColor' => "rgba(22, 107, 177,0.4)",
                "tooltip"=>[
                 "text"=>"%node-size-value bubble value,<br>with `min-size' and 'max-size' set to %t, respectively"
                ],
                   
                  
                "data" =>[["x"=>$finance_xdata[0],"y"=>$finance_ydata[0],"r"=>10,"label"=>"abdul"],["x"=>$finance_xdata[1],"y"=>$finance_ydata[1],"r"=>10 ],["x"=>$finance_xdata[2],"y"=>$finance_ydata[2],"r"=>10 ],["x"=>$finance_xdata[3],"y"=>$finance_ydata[3],"r"=>10 ],["x"=>$finance_xdata[4],"y"=>$finance_ydata[4],"r"=>10 ],["x"=>$finance_xdata[5],"y"=>$finance_ydata[5],"r"=>10 ],["x"=>$finance_xdata[6],"y"=>$finance_ydata[6],"r"=>10 ],["x"=>$finance_xdata[7],"y"=>$finance_ydata[7],"r"=>10 ],["x"=>$finance_xdata[8],"y"=>$finance_ydata[8],"r"=>10 ],["x"=>$finance_xdata[9],"y"=>$finance_ydata[9],"r"=>10 ]]
            ],
          
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
             
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                },
             

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));
            }
             if($id==1){
              $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
              [
                "label" => ["HR"],
                'backgroundColor' => "rgba(225, 140, 38,0.4)",
                'borderColor' => "rgba(225, 140, 38,0.4)",
            
                "data" =>[["name"=>"abdul","x"=>$HR_xdata[0],"y"=>$HR_ydata[0],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[1],"y"=>$HR_ydata[1],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[2],"y"=>$HR_ydata[2],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[3],"y"=>$HR_ydata[3],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[4],"y"=>$HR_ydata[4],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[5],"y"=>$HR_ydata[5],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[6],"y"=>$HR_ydata[6],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[7],"y"=>$HR_ydata[7],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[8],"y"=>$HR_ydata[8],"r"=>10],["name"=>"abdul","x"=>$HR_xdata[9],"y"=>$HR_ydata[9],"r"=>10]]
            ]
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
    
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                },
              

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));



             }
              if($id==2){
                 $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
               [
                "label" => ["IT"],
                'backgroundColor' => "rgba(0, 208, 210,0.4)",
                'borderColor' => "rgba(0, 208, 210,0.4)",
               
                "data" =>[[ "name"=>"abdul","x"=>$IT_xdata[0],"y"=>$IT_ydata[0],"r"=>10],["x"=>$IT_xdata[1],"y"=>$IT_ydata[1],"r"=>10],["x"=>$IT_xdata[2],"y"=>$IT_ydata[2],"r"=>10],["x"=>$IT_xdata[3],"y"=>$IT_ydata[3],"r"=>10],["x"=>$IT_xdata[4],"y"=>$IT_ydata[4],"r"=>10],["x"=>$IT_xdata[5],"y"=>$IT_ydata[5],"r"=>10]]
             ]
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
           
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                }
             

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));
             }
              if($id==3){
                     $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
               [
                "label" => ["Marketing"],
                'backgroundColor' => "rgba(188, 77, 31,0.4)",
                'borderColor' => "rgba(188, 77, 31,0.4)",
               
                "data" =>[["x"=>$Marketing_xdata[0],"y"=>$Marketing_ydata[0],"r"=>8],["x"=>$Marketing_xdata[1],"y"=>$Marketing_ydata[1],"r"=>10],["x"=>$Marketing_xdata[2],"y"=>$Marketing_ydata[2],"r"=>10],["x"=>$Marketing_xdata[3],"y"=>$Marketing_ydata[3],"r"=>10],["x"=>$Marketing_xdata[4],"y"=>$Marketing_ydata[4],"r"=>10],["x"=>$Marketing_xdata[5],"y"=>$Marketing_ydata[5],"r"=>10],["x"=>$Marketing_xdata[6],"y"=>$Marketing_ydata[6],"r"=>10],["x"=>$Marketing_xdata[7],"y"=>$Marketing_ydata[7],"r"=>10],["x"=>$Marketing_xdata[8],"y"=>$Marketing_ydata[8],"r"=>10],["x"=>$Marketing_xdata[9],"y"=>$Marketing_ydata[9],"r"=>10]]
            ]
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
             
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                }
              

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));
             }
              if($id==4){
               $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
               [
                "label" => ["Operations"],
                'backgroundColor' => "rgba(181, 201, 70,0.4)",
                'borderColor' => "rgba(181, 201, 70,0.4)",
               
                "data" =>[["x"=>$Operations_xdata[0],"y"=>$Operations_ydata[0],"r"=>10],["x"=>$Operations_xdata[1],"y"=>$Operations_ydata[1],"r"=>10],["x"=>$Operations_xdata[2],"y"=>$Operations_ydata[2],"r"=>10],["x"=>$Operations_xdata[3],"y"=>$Operations_ydata[3],"r"=>10],["x"=>$Operations_xdata[4],"y"=>$Operations_ydata[4],"r"=>10],["x"=>$Operations_xdata[5],"y"=>$Operations_ydata[5],"r"=>10],["x"=>$Operations_xdata[6],"y"=>$Operations_ydata[6],"r"=>10],["x"=>$Operations_xdata[7],"y"=>$Operations_ydata[7],"r"=>10],["x"=>$Operations_xdata[8],"y"=>$Operations_ydata[8],"r"=>10]]
            ]
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
            
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                }
              

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('Operations', compact('chartjs','bubblechartjs','description'));
             }
             if($id==5){
                  $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
             [
                "label" => ["Sales"],
                'backgroundColor' => "rgba(19, 127, 56,0.4)",
                'borderColor' => "rgba(19, 127, 56,0.4)",
                "text"=>"Stars",
                "marker"=>[
                        "type"=>"text",
                          "border-color"=>"#009999",
                          "border-width"=>1,
                          "alpha"=>0.3
                      
                    ],
                "data" =>[["x"=>$Sales_xdata[0],"y"=>$Sales_ydata[0],"r"=>10],["x"=>$Sales_xdata[1],"y"=>$Sales_ydata[1],"r"=>10],["x"=>$Sales_xdata[2],"y"=>$Sales_ydata[2],"r"=>10],["x"=>$Sales_xdata[3],"y"=>$Sales_ydata[3],"r"=>10],["x"=>$Sales_xdata[4],"y"=>$Sales_ydata[4],"r"=>10],["x"=>$Sales_xdata[5],"y"=>$Sales_ydata[5],"r"=>10],["x"=>$Sales_xdata[6],"y"=>$Sales_ydata[6],"r"=>10],["x"=>$Sales_xdata[7],"y"=>$Sales_ydata[7],"r"=>10],["x"=>$Sales_xdata[8],"y"=>$Sales_ydata[8],"r"=>10]]
            ],
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
           
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                }
             

            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));
             }
             if($id==6){
                 $bubblechartjs = app()->chartjs
        ->name('bubbleChartTest')
        ->type('bubble')
       // ->size(['width' =>2, 'height' => 2])
        //->labels($mylabal)
        ->datasets([
             [
                "label" => ["SupplyChain"],
                'backgroundColor' => "rgba(171, 42, 146,0.4)",
                'borderColor' => "rgba(171, 42, 146,0.4)",
                "data" =>[["x"=>$SupplyChain_xdata[0],"y"=>$SupplyChain_ydata[0],"r"=>10,],["x"=>$SupplyChain_xdata[1],"y"=>$SupplyChain_ydata[1],"r"=>10],["x"=>$SupplyChain_xdata[2],"y"=>$SupplyChain_ydata[2],"r"=>10],["x"=>$SupplyChain_xdata[3],"y"=>$SupplyChain_ydata[3],"r"=>10],["x"=>$SupplyChain_xdata[4],"y"=>$SupplyChain_ydata[4],"r"=>10],["x"=>$SupplyChain_xdata[5],"y"=>$SupplyChain_ydata[5],"r"=>10],["x"=>$SupplyChain_xdata[6],"y"=>$SupplyChain_ydata[6],"r"=>10],["x"=>$SupplyChain_xdata[7],"y"=>$SupplyChain_ydata[7],"r"=>10],["x"=>$SupplyChain_xdata[8],"y"=>$SupplyChain_ydata[8],"r"=>10]]
            ]
        ])->optionsRaw ("{
               responsive: true,
                legend: {
                        position: 'right',
                        display: true,
                        labels: {
                           padding:40,
                           fontSize:12
                        }

                },
              
                    tooltips: {
                        enabled: true,
                        mode: 'point',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.yLabel + '';
                            }
                        }
                      
                    },
                  
                 layout: {
                    padding: {
                        left:100,
                        right:400,
                        top:40,
                        bottom:100
                    },
                },
                scales: {
                     xAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }],
                    yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero:false,
                                min:0,
                                max:9
                            }
                        }]
                }
            
            
        }");

          $objPHPPowerPoint = new PhpPresentation();

        // Create slide
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        // Create a shape (text)
        $shape = $currentSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun(
                          'abdul'
                    );
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                               
            $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
            $oWriterPPTX->save(__DIR__ . "/sample.pptx");
            $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
            $oWriterODP->save(__DIR__ . "/sample.odp");
            
             return view('item', compact('chartjs','bubblechartjs','description'));
             }
           
           
    }
}
