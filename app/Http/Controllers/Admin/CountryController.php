<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Address;
use App\Models\Admin\Blog;
use App\Models\Admin\Collection;
use App\Models\Admin\Countries;
use App\Models\Admin\Product;
//use App\Models\Brand;
use App\Models\Admin\CollectionCountries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        view()->share('menu', 'countries');
        return view('admin.countries.index');
    }

    public function getCountry(Request $request){
        $id = (int)$request['id'];
        
        if($id){
            $item = Countries::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Countries();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $path = public_path('assets/flags_svg');
        $flags = File::allFiles($path);
        $flagsArray = [];
        foreach ($flags as $key => $flag) {
            $flagname = $flag->getFilename();
            if (str_starts_with($flagname, '_')) {
                continue;
            }
            $flagsArray[$flagname] = asset('assets/flags_svg/' . $flagname);
        }
        $collections = DB::table('collections')->select('title_en','id')->get();
        $collection_countries = CollectionCountries::all();
        $data = json_encode(
            array('data' =>
                (String) view('admin.countries.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                    'flags' => $flagsArray,
                    'collection_countries' => $collection_countries,
                    'collections' => $collections,
                )),
                'status' => 1)
        );
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function saveCountry(Request $request){
        $validator  = \Validator::make($request->all(), [
            'title_am'         => 'required|string',
            'title_en'         => 'required|string',
            'title_ru'         => 'required|string',
            'icon'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }

        $id = $request->input('id');
        if (!$id) {
            $item = new Countries();
        } else {
            $item = Countries::find($id);

            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $validated = $validator->validated();
        $data = $request->all();

        $item->title_am = $request->title_am;
        $item->title_ru = $request->title_ru;
        $item->title_en = $request->title_en;
        $item->icon = $request->icon;
        $id = $item->id;
        $item->save();
        if ($request->collection) {
                foreach ($request->collection as $col) {
                    $newCollectionCountry = new CollectionCountries();
                    $newCollectionCountry->collection_id = $col;
                    $newCollectionCountry->country_id = $item->id;
                    $newCollectionCountry->save();
            }
        }
        if ($id) {
            if ($request->collection) {
                CollectionCountries::where('country_id', $item->id)->delete();
                foreach ($request->collection as $col) {
                    $newCollectionCountry = new CollectionCountries();
                    $newCollectionCountry->collection_id = $col;
                    $newCollectionCountry->country_id = $item->id;
                    $newCollectionCountry->save();
                }
            }
        }
        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function remove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Countries::find($id);
            $item->save();
            $item->delete();
            CollectionCountries::where('country_id', $id)->delete();
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }
    public function CountriesData(Request $request){
        $model = new Countries();
        $filter = array(
            'search' => $request->input('search'),
        );

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
