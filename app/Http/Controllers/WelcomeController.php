<?php

namespace App\Http\Controllers;
use App\Events\SendNotification;

use App\Models\Admin\ImageDB;
use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Meta;
use App\Models\Blog;
use App\Models\Product;
// use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App;
class WelcomeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function homepage()
    {
        $productModel = new Product();
        $featuredProducts = $productModel->getProductList('featured',8);
        $popProducts = $productModel->getProductList('pop',8);
        
        $featuredBlog = Blog::select('slug','title','img','published_at')->where('featured',1)->whereNull('temp')->where('published',1)->where('featured',1)->limit(5)->get();
        

        $sliders = Slider::where('status', 1)->whereNull('temp')->orderBy('ordering', 'asc')->get();
        foreach ($sliders as $slider) {
            $img = ImageDB::find($slider->image_id);
            $slider->imagePath = asset('images/slider/' . $img->filename . '.' . $img->ext . '');
        }

        $productModel->getSidebar(true,true);

        $metaModel = new Meta();
        $meta = $metaModel->getMeta('home');
        view()->share('meta', $meta);

        view()->share('featuredBlog', $featuredBlog);
        view()->share('sliders', $sliders);
        view()->share('popProducts', $popProducts);
        view()->share('featuredProducts', $featuredProducts);

        view()->share('menu', 'home');
        return view('app.welcome');
    }

    public function blog()
    {
        $blogItems = DB::table('blog')->select('id','img','slug','title','description','published_at')
        ->whereNull('temp')
        ->where('published',1)
        ->paginate(8);

        $breadscrumbData['mainTitle'] = "Blog";
        $breadscrumbData['links'][] = ['title' => 'Blog', 'active' => true];

        $productModel = new Product();
        $productModel->getSidebar(true,true);

        $metaModel = new Meta();
        $meta = $metaModel->getMeta('blog');
        view()->share('meta', $meta);

        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('blogItems', $blogItems);
        return view('app.blog');
    }

    public function blogPage($id)
    {
        $id = (int)$id['id'];
        $blog = DB::table('blog')
            ->select('id','img','slug','title','published_at','description','body','meta_title','meta_description','inheritMeta')
            ->whereNull('temp')->where('id',$id)->where('published',1)->first();
        
        if(!$blog){
            return redirect('blog');
        }
        $breadscrumbData['mainTitle'] = "Blog";
        $breadscrumbData['links'][] = ['title' => 'Blog', 'active' => false, 'url' => route('blog')];
        // $breadscrumbData['links'][] = ['title' => $blog->title, 'active' => true];

        $recentBlogs = Blog::select('slug','title','img','published_at')->where('id','!=',$blog->id)->whereNull('temp')->where('published',1)->where('featured',1)->limit(5)->get();
        $productModel = new Product();
        $productModel->getSidebar(true,true);

        $metaModel = new Meta();
        $meta = $metaModel->getItemMeta($blog);
        view()->share('meta', $meta);

        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('blog', $blog);
        view()->share('recentBlogs', $recentBlogs);
        return view('app.blogItem');
    }

    public function wishlist() {    
        $products = [];
        $updatedWishlistItems = [];
        $wishlistChanged = false;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $wishlist = json_decode($user->wishlist, true);
        } else {
            $wishlist = \Session::get('wishlist');
        }
        if ($wishlist && count($wishlist['items']) > 0) {
            $productModel = new Product();
            foreach ($wishlist['items'] as $wl) {
                $product = $productModel->getProductShort($wl['id'], $wl['priceId'], true);
                if ($product) {
                    $product->cannabinoid = $productModel->getCannabinoidContent($product);
                    $products[] = $product;
                    $updatedWishlistItems[] = $wl;
                } else {
                    $wishlistChanged = true;
                }
            }
        }
        if ($wishlistChanged) {
            if (Auth::guard('web')->check()) {
                $user->wishlist = json_encode(['items' => $updatedWishlistItems]);
                $user->save();
            } else {
                \Session::put('wishlist', ['items' => $updatedWishlistItems]);
            }
        }
        $breadscrumbData['mainTitle'] = "Wishlist";
        $breadscrumbData['links'][] = ['title' => 'Wishlist', 'active' => true];

        $metaModel = new Meta();
        $meta = $metaModel->getMeta('wishlist');
        view()->share('meta', $meta);

        view()->share('menu', 'wishlist');
        view()->share('products', $products);
        view()->share('breadscrumbData', $breadscrumbData);

        return view('app.wishlist');
    }
    public function addToWishlist(Request $request) {
        $validator = Validator::make($request->all(),[
            'productId' => 'required|int',
            'priceId' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = (int)$request->productId;
        $priceId = (int)$request->priceId;
        $product = DB::table('product')->select('id')->whereNull('deleted_at')->where('public', 1)->where('id',$id)->first();
        $price = DB::table('pricing')->select('id')->where('product_id',$id)->where('id',$priceId)->first();

        if(!$product || !$price){
            return response()->json(['errors' => ["server"=>"Product not found"]], 422);
        }
        $maxCount = 20;
        $item = ['id' => $id, 'priceId' => $priceId];
        // $favoriteCount = 0;
        if (Auth::guard('web')->check()) {
            $userId = Auth::guard('web')->user()->id;
            $user = DB::table('users')->where('id', $userId)->first();
            $userWishlist = json_decode($user->wishlist, true) ?? ['items' => []];

            // Check if the item already exists in favorites.
            $exists = false;
            foreach ($userWishlist['items'] as $value) {
                if($value['id'] == $id && $value['priceId'] == $priceId){
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                array_push($userWishlist['items'], $item);
                if (count($userWishlist['items']) > $maxCount) {
                    array_shift($userWishlist['items']);
                }
                // $userWishlist['items'][] = $item;
                $newArrFav = json_encode($userWishlist);
                $user = DB::table('users')->where('id', $userId)->update([
                    "wishlist" => $newArrFav
                ]);
            }
          
        } else {
            $wishlist = \Session::get('wishlist', ['items' => []]);
            // $countFavorite = count($wishlist['items'] ?? []); 
            $exists = false;
            foreach ($wishlist['items'] as $value) {
                if($value['id'] == $id && $value['priceId'] == $priceId){
                    $exists = true;
                    break;
                }
            }
    
            if (!$exists) {
                array_push($wishlist['items'], $item);
                if (count($wishlist['items']) > $maxCount) {
                    array_shift($wishlist['items']);
                }
                // $wishlist['items'][] = $item;
                \Session::put('wishlist', $wishlist);
            }
        }
    
        // $wishlistCount = Auth::check() ? count($userWishlist['items'] ?? []) : $countFavorite;
        return json_encode(['status' => 1]);
    }
    public function removeFromWishlist(Request $request) {
        $validator = Validator::make($request->all(),[
            'productId' => 'required|int',
            'priceId' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = (int)$request->productId;
        $priceId = (int)$request->priceId;

        if (Auth::guard('web')->check()) {
            $userId = Auth::guard('web')->user()->id;
            $user = DB::table('users')->where('id', $userId)->first();
            $userWishlist = json_decode($user->wishlist, true) ?? ['items' => []];

            foreach ($userWishlist['items'] as $key => $value) {
                if ($value['id'] == $id && $value['priceId'] == $priceId) {
                    unset($userWishlist['items'][$key]);
                    $newArrFav = json_encode($userWishlist);
                    DB::table('users')->where('id', $userId)->update([
                        "wishlist" => $newArrFav
                    ]);
                    break;
                }
            }
        } else {
            $wishlist = \Session::get('wishlist', ['items' => []]);
        
            foreach ($wishlist['items'] as $key => $value) {
                if ($value['id'] == $id && $value['priceId'] == $priceId) {
                    unset($wishlist['items'][$key]);
                    \Session::put('wishlist', $wishlist);
                    break;
                }
            }
        }
        return json_encode(['status' => 1]);
    }
    
    public function signin()
    {
        $metaModel = new Meta();
        $meta = $metaModel->getMeta('sign-in');

        $breadscrumbData['mainTitle'] = "Sign in";
        $breadscrumbData['links'][] = ['title' => 'Sign in', 'active' => true];

        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('meta', $meta);
        return view('app.sign_in');
    }
    public function signup()
    {
        $metaModel = new Meta();
        $meta = $metaModel->getMeta('sign-up');

        $breadscrumbData['mainTitle'] = "Sign up";
        $breadscrumbData['links'][] = ['title' => 'Sign up', 'active' => true];
        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('meta', $meta);
        return view('app.sign_up');
    }

    public function terms()
    {
        $article = DB::table('articles')->select('body','title')->where('page_name','terms')->first();
        $breadscrumbData['mainTitle'] = "Terms and conditions";
        $breadscrumbData['links'][] = ['title' => 'Terms and conditions', 'active' => true];
        
        $metaModel = new Meta();
        $meta = $metaModel->getMeta('terms');
        view()->share('meta', $meta);

        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('article', $article);
        return view('app.article');
    }

    public function privacy()
    {
        $article = DB::table('articles')->select('body','title')->where('page_name','privacy')->first();
        $breadscrumbData['mainTitle'] = "Privacy policy";
        $breadscrumbData['links'][] = ['title' => 'Privacy policy', 'active' => true];
        
        $metaModel = new Meta();
        $meta = $metaModel->getMeta('privacy');
        view()->share('meta', $meta);

        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('article', $article);
        return view('app.article');
    }
    
    // public function privacy()
    // {
    //     $lang = App::getLocale();
    //     $article = DB::table('articles')
    //             ->select('body_'.$lang.' as body', 'title_'.$lang.' as title','updated_at')
    //             ->where('page_name','privacy-policy')->first();
    //     view()->share('article', $article);
    //     return view('app.article');
    // }

    // public function return()
    // {
    //     $lang = App::getLocale();
    //     $article = DB::table('articles')
    //             ->select('body_'.$lang.' as body', 'title_'.$lang.' as title','updated_at')
    //             ->where('page_name','return-policy')->first();
        
    //     view()->share('article', $article);
    //     return view('app.article');
    // }

    public function contact()
    {
        $breadscrumbData['mainTitle'] = "Contact Us";
        $breadscrumbData['links'][] = ['title' => 'Contact Us', 'active' => true];
        
        $metaModel = new Meta();
        $meta = $metaModel->getMeta('contact');
        view()->share('meta', $meta);

        view()->share('breadscrumbData', $breadscrumbData);
        return view('app.contact');
    }

    
    public function feedback(Request $request){

        $request->validate([
            'contact_first_name' => 'required|string|max:50',
            'contact_last_name' => 'required|string|max:50',
            'contact_phone' => ['required', 'regex:/^\+?[0-9]{6,}$/'],
            'contact_email' => 'required|email:rfc',
            'contact_message' => 'required|max:1000',
        ]);

        $firstName = $request->input('contact_first_name');
        $lastName = $request->input('contact_last_name');
        $phone = $request->input('contact_phone');
        $email = $request->input('contact_email');
        $message = $request->input('contact_message');
       
        $data = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
            'email' => $email,
            'userMessage' => $message,
            'subject_data' => 'Feedback'
        ];
        event(new SendNotification('feedback',$data));
        return true;
    }
}