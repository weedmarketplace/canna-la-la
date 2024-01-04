<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Http;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Log;

class CDataManager extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sync_log';

    protected $C_HOST;
    protected $C_Username;
    protected $C_Password;
    protected $C_TOKEN;

    // public $timestamps  = false;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        
        $this->C_HOST = env('C_HOST');
        $this->C_Username = env('C_Username');
        $this->C_Password = env('C_Password');
        $this->C_TOKEN = base64_encode($this->C_Username . ":" . $this->C_Password);
    }

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS id'), 'id as DT_RowId', 'id', 'type', 'owner','status','data', 'created_at'));
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if(isset($filter['status'])){
			$query->where('status',$filter['status']);    
		}

		
		// $query->whereNull('deleted_at');
		// $query->whereNull('temp');

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();
		$expression = DB::raw("SELECT FOUND_ROWS() AS recordsTotal;");
        $string = $expression->getValue(DB::connection()->getQueryGrammar());
        $count = DB::select($string)[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
		return $return;
    }

    public function syncAll(){
        return $this->syncData('admin');
    }

    public function syncItem($product_id,$owner = 'admin'){
        $product = Product::findOrFail($product_id);

        $unixTime = time();
        $syncLog = Log::build(['driver' => 'single','path' => storage_path('logs/sync/'.'sync_'.$unixTime.'_.log')]);
        
        $logDb = new CDataManager();
        $logDb->file = 'sync_'.$unixTime.'_.log';
        $logDb->owner = $owner;
        $logDb->type = 'item';
        $logDb->data = $product->code;
        $logDb->status = 0;
        $logDb->save();

        $item = $this->getItem($product->code);
        if(!$item){
            Log::stack([$syncLog])->critical("Error while getting data from 1C");
            return false;
        }
        $product->price = $item['Price'];
        $product->c_name = $item['ProductName'];
        $product->count = (int)$item['Quantity'];
        $product->discount = (int)$item['Discount'];

        $stores = isset($item['stores']) ? $item['stores'] : null;
        if (is_array($stores)) {
            foreach ($stores as  $storeItem) {

                if($storeItem['Store'] === "The House Մոսկովյան 28"){
                    $product->store_1 = $storeItem['Quantity'];
                }
                else if($storeItem['Store'] === "The House Արշակունյաց 2"){
                    $product->store_2 = $storeItem['Quantity'];
                }
                else if($storeItem['Store'] === "The House Կոմիտաս 15"){
                    $product->store_3 = $storeItem['Quantity'];
                }
                else{
                    $product->store_4 = $storeItem['Quantity'];
                }
                
            }
        }
        
        if($product->isDirty()){
            $product->save();
            $updateString = "price: {$item['Price']}, c_name: {$item['ProductName']}, count: {$item['Quantity']}, discount: {$item['Discount']}";
            Log::stack([$syncLog])->info("Update item + {$item['ProductID']} + {$updateString}");
            $result = array('status' => 1, 'message' => 'Item updated', 'data' => $product);
        }else{
            Log::stack([$syncLog])->info("Item + {$item['ProductID']} + is up to date, nothing to update");
            $result =  array('status' => 2, 'message' => 'Is up to date');
        }
        $logDb->status = 1;
        $logDb->save();
        return $result;
    }

    public function getItem($code){
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->C_TOKEN,
        ])->get($this->C_HOST . '/hs/onlineshop/GETPRODUCTBYID?ProductID='.$code);
       
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }
    public function getAllItems(){
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->C_TOKEN,
        ])->get($this->C_HOST . '/hs/onlineshop/GETPRODUCTS');
        
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }

    public function removeDoubleItems($products,$syncLog){
        $uniqueProducts = [];
        foreach ($products as $product) {
            if (isset($uniqueProducts[$product['ProductID']])) {
                Log::stack([$syncLog])->error("Duplicate item found + {$product['ProductID']}");
                continue;
            }
            $uniqueProducts[$product['ProductID']] = $product;
        }
        $uniqueProducts = array_values($uniqueProducts);
        return $uniqueProducts;
    }
    public function syncData($owner) {
        $notTrackingCollection = array('Beer','Glasses and Accessories','Gift Baskets');

        $unixTime = time();
        $syncLog = Log::build(['driver' => 'single','path' => storage_path('logs/sync/'.'sync_'.$unixTime.'_.log')]);
        $logDb = new CDataManager();
        $logDb->file = 'sync_'.$unixTime.'_.log';
        $logDb->owner = $owner;
        $logDb->type = 'all';
        $logDb->status = 0;
        $logDb->save();

        $collecation_array = array(
            "Brandy / Armagnac" => "brandy",
            "Tequila / Mescal" => "tequila",
            "Gin / Genever" => "gin",
            "Rum / Cachaça" => "rum",
            "Liqueurs / Bitter" => "liqueur",
            "Champagne & Sparkling" => "champagne",
            "Other Spirits" => "other_spirits",
            "Beer & Soft Drinks" => "s_drinks",
            "Vermouth/ Aperitiv" => "vermouth",
            // "Glasses and Accessories" => "accessories",
            // "Gift Baskets" => "baskets",
        );
        
        
        $data = $this->getAllItems();
        if(!$data){
            Log::stack([$syncLog])->critical("Error while getting data from 1C");
            return false;
        }
        $data = $this->removeDoubleItems($data,$syncLog);
        
        $syncProcess = 0;
        try {
            // Begin transaction
            DB::beginTransaction();

            // Loop over each item from the external data
            $count = 0;
            $notTrackCollecation = 0;
            $new = 0;
            $update = 0;
            $error = 0;
            $cleanToChange = 0;
            foreach ($data as $item) {
                $count++;
                // Temporary removed some categories
                if (!isset($item['CatalogName']) || empty($item['CatalogName']) || in_array($item['CatalogName'],$notTrackingCollection)) {
                    $notTrackCollecation++;
                    $item['CatalogName'] = !isset($item['CatalogName']) || empty($item['CatalogName']) ? 'Empty' : $item['CatalogName'];
                    Log::stack([$syncLog])->warning("Not trackable or empty collecations {$item['ProductID']} - {$item['CatalogName']}");
                    continue;
                }
                
                $product = Product::where('code', $item['ProductID'])->first();
                // If product does not exist, create it
                if (!$product) {
                    if($item['CatalogName'] == "Չգնացող"){
                        $notTrackCollecation++;
                        Log::stack([$syncLog])->warning("New Not trackable collecations {$item['ProductID']} - Չգնացող");
                        continue;
                    }

                    $new++;
                    $collection_name = isset($collecation_array[$item['CatalogName']]) ? $collecation_array[$item['CatalogName']] : $item['CatalogName'];
                    $collection = Collection::where('title', $collection_name)->first();
                    if(!$collection){
                        $error++;
                        Log::stack([$syncLog])->error("DONT EXIST + {$item['ProductID']} + {$item['CatalogName']} - Collection NOT FOUND");
                        continue;
                    }
                    $product = new Product([
                        'code' => $item['ProductID'],
                        'c_name' => $item['ProductName'],
                        'product_name' => strtolower($collection_name),
                        'count' => $item['Quantity'],
                        'price' => $item['Price'],
                        'discount' => $item['Discount'],
                        'parent_id' => $collection->id,
                        'public' => 0,
                        'is_new' => 1
                    ]);
                    $stores = isset($item['stores']) ? $item['stores'] : null;

                    if (is_array($stores)) {
                        foreach ($stores as  $storeItem) {

                            if($storeItem['Store'] === "The House Մոսկովյան 28"){
                                $product->store_1 = $storeItem['Quantity'];
                            }
                            else if($storeItem['Store'] === "The House Արշակունյաց 2"){
                                $product->store_2 = $storeItem['Quantity'];
                            }
                            else if($storeItem['Store'] === "The House Կոմիտաս 15"){
                                $product->store_3 = $storeItem['Quantity'];
                            }
                            else{
                                $product->store_4 = $storeItem['Quantity'];
                            }
                            
                        }
                    }
                    $addingString = "code: {$item['ProductID']}, c_name: {$item['ProductName']}, product_name: {$collection_name}, count: {$item['Quantity']}, price: {$item['Price']}, discount: {$item['Discount']}, parent_id: {$collection->id}, public: 0, is_new: 1";
                    Log::stack([$syncLog])->info("New item + {$item['ProductID']} + {$addingString}");
                    $product->save();
                } else {
                    $product->price = $item['Price'];
                    $product->c_name = $item['ProductName'];
                    $product->count = (int)$item['Quantity'];
                    $product->discount = (int)$item['Discount'];
                    $stores = isset($item['stores']) ? $item['stores'] : null;


                    if (is_array($stores)) {
                        foreach ($stores as  $storeItem) {

                            if($storeItem['Store'] === "The House Մոսկովյան 28"){
                                $product->store_1 = $storeItem['Quantity'];
                            }
                            else if($storeItem['Store'] === "The House Արշակունյաց 2"){
                                $product->store_2 = $storeItem['Quantity'];
                            }
                            else if($storeItem['Store'] === "The House Կոմիտաս 15"){
                                $product->store_3 = $storeItem['Quantity'];
                            }
                            else{
                                $product->store_4 = $storeItem['Quantity'];
                            }
                            
                        }
                    }


                    if ($item['CatalogName'] === "Չգնացող") {
                        $product->public = 0;
                        $product->trash = 1;
                    }



                    if($product->isDirty()){
                        $update++;
                        $product->save();
                        $updateString = "price: {$item['Price']}, c_name: {$item['ProductName']}, count: {$item['Quantity']}, discount: {$item['Discount']}";
                        Log::stack([$syncLog])->info("Update item + {$item['ProductID']} + {$updateString}");
                    }else{
                        $cleanToChange++;
                    }
                }
            }

            $syncProcess = 1;
            DB::commit();
            Log::stack([$syncLog])->info("Task completed Total:{$count} - New:{$new} - Update:{$update} - Clean:{$cleanToChange} - NotTracking:{$notTrackCollecation} - Error:{$error}");
        } catch (\Exception $e) {
            // Rollback transaction on error
            $syncProcess = 0;
            DB::rollback();
            Log::stack([$syncLog])->critical("Error in syncData: {$e->getMessage()}");
        }

        $logDb->status = $syncProcess;
        $logDb->save();
        return $syncProcess;
    }

    public function reserveItems($itemsArray,$order){
        $payment_card = $order->payment_method == "card" ? $order->total : 0;
        $payment_cash = $order->payment_method == "cash" ? $order->total : 0;
        $payment_pos = $order->payment_method == "pos" ? $order->total : 0;
        $payment_idram = $order->payment_method == "idram" ? $order->total : 0;


        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->C_TOKEN,
            "Content-Type" => "application/json",
        ])->post($this->C_HOST . '/hs/onlineshop/RESERVE_ITEMS', [
            'TransactionDate' => $order->c_trdate,
            'ClientName' => $order->fullname,
            'ClientID' => '',
            'Address' => $order->address,
            'Tell' => $order->phone,
            'Email' => $order->email ? $order->email : '',
            'ItemsList' => $itemsArray,
            'Note' => '',
            'OrderId' => $order->sku,
            'AccumulativeCart' => '',
            'Payment' => ['card' => $payment_card, 'cash' => $payment_cash, 'idram' => $payment_idram, 'cardoffline' => $payment_pos, 'bonus' => '0'],
            // Add more key-value pairs as needed
        ]);
        
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }
    public function reserveAction($c_trid,$c_trdate,$action){
        if ($action == 'save') $url = 'CONFIRM_ORDER';
        if ($action == 'cancel') $url = 'RESERVE_CANCEL';

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->C_TOKEN,
            "Content-Type" => "application/json",
        ])->post($this->C_HOST . '/hs/onlineshop/'.$url, [
            'TransactionID' => $c_trid,
            'TransactionDate' => $c_trdate,
        ]);
        
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }
}