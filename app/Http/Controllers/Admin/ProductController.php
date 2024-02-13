<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Validation\Rule;
use Validator;
use DB;
use Auth,Hash;
use Illuminate\Support\Facades\Artisan;

class ProductController extends Controller
{ 

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){   
        $page_title = 'Products';
        return view('admin.products.index',compact('page_title'));
    }
    
    public function index_ajax(Request $request){   
        $query = Product::query();

        $totalRecords = $query->count();
        $request         =    $request->all();
        $draw            =    $request['draw'];
        $row             =    $request['start'];
        $length = ($request['length'] == -1) ? $totalRecords : $request['length']; 
        $rowperpage      =    $length; // Rows display per page
        $columnIndex     =    $request['order'][0]['column']; // Column index
        $columnName      =    $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder =    $request['order'][0]['dir']; // asc or desc
        $searchValue     =    $request['search']['value']; // Search value

        ## Total number of record with filtering
        $filter= $query;

        if($searchValue != ''){
            $filter  = $filter->where(function($q)use ($searchValue) {
                                $q->where('id','like','%'.$searchValue.'%')
                                ->orWhere('name','like','%'.$searchValue.'%')
                                ->orWhere('SKU','like','%'.$searchValue.'%')
                                ->orWhere('status','like','%'.$searchValue.'%');
            });
        }

        $filter_data           = $filter->count();
        $totalRecordwithFilter = $filter_data;

        ## Fetch records
        $empQuery = $filter;
        $empQuery = $empQuery->orderBy($columnName, $columnSortOrder)->offset($row)->limit($rowperpage)->get();
        $data = array();

        $i = 1;
        foreach ($empQuery as $emp) {
            $emp['edit']    = route("products.edit",$emp["id"]);
            $emp['show']    = route("products.show",$emp["id"]);
            $emp['delete'] = route("products.destroy",$emp["id"]);
            $data[] = $emp;
            $i++;
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
        );
        echo json_encode($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $page_title = 'Add New Product';
        return view('admin.products.create', compact('page_title'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3, max:100|unique:products,name',
            'sku' => 'required|string|min:3, max:100|unique:products,sku',
        ]); 
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $request_data = $request->all();        
            $request_data['status'] = 'active';

            $input_data = [
                'name' => $request_data['name'],
                'sku' => $request_data['sku'],
            ];
            
            $data = new Product();
            $data->fill($input_data);
            $data->save();

            /* ############ LOT ITEMS ############ */
            $groupedData = [];
            foreach ($request_data as $fieldName => $value) {
                // Extract the numeric index from the field name
                preg_match('/(\d+)$/', $fieldName, $matches);
                $index = isset($matches[1]) ? $matches[1] : null;

                // If numeric index is found, organize the data
                if ($index !== null) {
                    $fieldNameWithoutIndex = preg_replace('/_\d+$/', '', $fieldName);
                    $groupedData[$index][$fieldNameWithoutIndex] = $value;
                }
            }

            //Validation 
            foreach ($groupedData as $gd_index => $gd_data) { 
                if(!isset($gd_data['lot_name']) || $gd_data['lot_name'] == '') {
                    return response()->json(['error' => 'Item '. $gd_index. ', Lot Name must required.']);
                }
                if(!isset($gd_data['quantity']) || $gd_data['quantity'] == '') {
                    return response()->json(['error' => 'Item '. $gd_index. ', Quantity must be required for selected item.']);
                }
                if(!isset($gd_data['expiry_date']) || $gd_data['expiry_date'] == '') {
                    return response()->json(['error' => 'Item '. $gd_index. ', Expiry Date must be required for selected item.']);
                }
            }

            
            // Saving Lot Data
            foreach ($groupedData as $gds_index => $gds_data) {
                
                $lot_name = $gds_data['lot_name'] ?? null;
                $quantity = $gds_data['quantity'] ?? null;
                $expiry_date = $gds_data['expiry_date'] ?? null;
                
                $lot_item = Inventory::create([
                    'product_id'=>$data->id, 
                    'lot_name'=>$lot_name,
                    'quantity' => $quantity,
                    'expiry_date'=>$expiry_date,
                ]);  
            }
            /* ############ Lot ITEMS ############ */

            if($data) {
                DB::commit();
                return response()->json(['success' => 'Product has been added  Successfully']);
            } else {
                DB::rollback();
                return response()->json(['error' => 'Error']);
            }

        }catch (\Exception $e) {
              DB::rollback();
              return response()->json(['error' => $e->getMessage()]);
        } 
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){   
        $page_title = 'Update Product';
        $data      = Product::find($id);
        $lots = $data->product_inventory;
        return view('admin.products.edit',compact('page_title','data','lots'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3, max:100|unique:products,name,'.$id,
            'sku' => 'required|string|min:3, max:100|unique:products,sku,'.$id,
        ]); 
 
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $request_data = $request->all();        
            // Generate Product Data
            $input_data = [
                'name' => $request_data['name'],
                'sku' => $request_data['sku'],
            ];

            $data = Product::find($id);
            $data->fill($input_data);
            $data->save();
                   
            /* ############ Lot ITEMS ############ */
            // Separate the data based on the numeric index in the field names
            $groupedData = [];
            foreach ($request_data as $fieldName => $value) {
                // Extract the numeric index from the field name
                preg_match('/(\d+)$/', $fieldName, $matches);
                $index = isset($matches[1]) ? $matches[1] : null;

                // If numeric index is found, organize the data
                if ($index !== null) {
                    $fieldNameWithoutIndex = preg_replace('/_\d+$/', '', $fieldName);
                    $groupedData[$index][$fieldNameWithoutIndex] = $value;
                }
            }

            foreach ($groupedData as $gd_index => $gd_data) { 
                if(!isset($gd_data['lot_name']) || $gd_data['lot_name'] == '') {
                    return response()->json(['error' => 'Lot '. $gd_index. ', Lot Name must be required for selected item.']);
                }
                if(!isset($gd_data['quantity']) || $gd_data['quantity'] == '') {
                    return response()->json(['error' => 'Lot '. $gd_index. ', Quantity must be required for selected item.']);
                }

                if(!isset($gd_data['expiry_date']) || $gd_data['expiry_date'] == '') {
                    return response()->json(['error' => 'Lot '. $gd_index. ', Expiry Date must be required for selected item.']);
                }
            }

            // dd($groupedData);
            
            // Saving Product Items Data
            Inventory::where('product_id',$data->id)->delete();
            foreach ($groupedData as $gds_index => $gds_data) {
                $lot_name = $gds_data['lot_name'] ?? null;
                $quantity = $gds_data['quantity'] ?? null;
                $expiry_date = $gds_data['expiry_date'] ?? null;
                
                $deal_item = Inventory::create([
                    'product_id'=>$data->id, 
                    'lot_name'=>$lot_name,
                    'quantity'=>$quantity,
                    'expiry_date'=>$expiry_date,
                ]);  
            }
            /* ############ Lot ITEMS ############ */
            

            if($data) {
                DB::commit();
                return response()->json(['success' => 'Product has been updated Successfully']);
            } else {
                DB::rollback();
                return response()->json(['error' => 'Error']);
            }
  
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $data = Product::find($id);

        if(file_exists($data->image)){
              unlink($data->image);
        }

        if($data->delete()){

            return redirect()->route('products.index')->with('success','Product deleted Successfully');

        }else{

            return redirect()->route('products.index')->with('error',"Coudn't delete Product");
        }
    }
    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
    */
    public function status(Request $request){
        $item_data = Product::where('id',$request->id)
                  ->update(['status'=>$request->status]);
        if($item_data) {
            return response()->json(['success' => 'Status Updated Successfully']);
        } else {
            return response()->json(['error' => 'Error in Status Update']);
        }
    }

    public function sent_notification_manually() {
        // Run the low_stock_notification command
        Artisan::call('low_stock_notification');

        // You can get the output of the command if needed
        $output = Artisan::output();

        return redirect()->route('home')->with('success','Low Stock Notification has been sent, You will receive mail if any product have low stock');


    }
}