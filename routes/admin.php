<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\SuperAdmin;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[AuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('adminLogout');


Route::group(['middleware' => ['adminauth', 'superAdmin']], function () {
    // Route::get('addCategoryList',[AdminController::class, 'addCategoryList'])->name('addCat');

    // Route::withoutMiddleware([SuperAdmin::class])->group(function () {
    Route::get('products',[ProductController::class, 'index'])->name('products');
    Route::get('products-data',[ProductController::class, 'data'])->name('productData');
    Route::get('products-get',[ProductController::class, 'get'])->name('productGet');
    Route::post('products-sort',[ProductController::class, 'sort'])->name('productsSort');
    // Route::post('products-sort',[ProductController::class, 'descriptionSort'])->name('descriptionSort');
    Route::post('product-save',[ProductController::class, 'save'])->name('productSave');
    Route::post('product-remove',[ProductController::class, 'remove'])->name('productRemove');
    Route::post('product-change-status',[ProductController::class, 'changeStatus'])->name('productChangeStatus');
    Route::get('reports',[ProductController::class, 'reportsIndex'])->name('reportsIndex');
    Route::get('reports-data',[ProductController::class, 'reports'])->name('reportsData');
    Route::get('get-report',[ProductController::class, 'report'])->name('getReport');
    Route::post('unAttachCover',[ProductController::class, 'unAttachCover'])->name('unAttachCover');
    Route::post('remove-varation',[ProductController::class, 'deleteVariation'])->name('deleteVariation');
    // Route::post('unAttachMap',[ProductController::class, 'unAttachMap'])->name('unAttachMap');
    
    // Route::get('descriptions',[ProductController::class, 'descriptions'])->name('productDescriptions');
    // Route::get('description-get',[ProductController::class, 'getDescription'])->name('aGetDescription');
    // Route::post('description-remove',[ProductController::class, 'removeDescription'])->name('aRemoveDescription');
    // Route::post('description-save',[ProductController::class, 'saveDescription'])->name('aSaveDescription');

    Route::get('orders',[OrderController::class, 'index'])->name('adminOrder');
    Route::get('order-data',[OrderController::class, 'data'])->name('orderData');
    Route::get('order',[OrderController::class, 'getOrder'])->name('aGetOrder');
    Route::post('order-save',[OrderController::class, 'saveOrder'])->name('saveOrder');
    Route::post('order-change-status',[OrderController::class, 'changeStatus'])->name('aOrderChangeStatus');
    // Route::post('save-review',[OrderController::class, 'saveReview'])->name('adminSaveReview');
    // Route::post('save-notes',[OrderController::class, 'saveNotes'])->name('adminSaveNotes');

    Route::get('import',[AdminController::class, 'importJson'])->name('adminImport');

    Route::get('profile',[AdminController::class, 'profile'])->name('adminProfile');
    Route::post('save-profile',[AuthController::class, 'saveProfile'])->name('adminSaveProfile');
    Route::post('change-password',[AuthController::class, 'changePassword'])->name('adminChangePassword');

    Route::post('upload-image',[ImageController::class, 'upload'])->name('aUpload');
    Route::post('change-image-color',[ImageController::class, 'changeImageColor'])->name('changeImageColor');
    Route::post('gallery-data',[ImageController::class, 'galleryData']);
    Route::post('gallery-sort',[ImageController::class, 'gallerySort']);
    Route::post('remove-image',[ImageController::class, 'remove'])->name('aRemoveImage');
    // });

	// Admin Dashboard
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('save-settings',[AdminController::class, 'saveSettings'])->name('saveAdminSettings');
    Route::post('save-contact',[AdminController::class, 'saveContact'])->name('saveAdminContact');

    //settings
    Route::get('settings',[SettingsController::class, 'settings'])->name('adminSettings');
    Route::post('settings',[SettingsController::class,'updateSettings'])->name('updateSettings');
    Route::post('update-settings-general',[SettingsController::class,'updateSettingsGeneral'])->name('updateSettingsGeneral');
    Route::post('update-settings-tax',[SettingsController::class,'updateSettingsTax'])->name('updateSettingsTax');
    // Route::post('update-img',[SettingsController::class,'updateimg'])->name('updateimg');

    //slider
    // Route::get('slider',[SliderController::class, 'slider'])->name('adminSlider');
    // Route::get('slider-data',[SliderController::class, 'sliderData'])->name('aSliderData');
    // Route::get('slider-get',[SliderController::class, 'getSlider'])->name('aGetSlider');
    // Route::post('slider-save',[SliderController::class, 'saveSlider'])->name('adminSliderSave');
    // Route::post('slider-remove',[SliderController::class, 'removeSlider'])->name('aRemoveSlider');
    // Route::post('slider-ordering',[SliderController::class, 'reorderingSlider'])->name('aSliderSort');

    //meta
    
    Route::get('meta',[MetaController::class, 'meta'])->name('adminMeta');
    Route::get('meta-data',[MetaController::class, 'metaData'])->name('aMetaData');
    Route::get('meta-get',[MetaController::class, 'getMeta'])->name('aGetMeta');
    Route::post('meta-save',[MetaController::class, 'saveMeta'])->name('adminMetaSave');

    //Categories
    Route::get('collections',[CollectionController::class, 'collections'])->name('adminCollections');
    Route::get('collections-data',[CollectionController::class, 'collectionsData'])->name('aCollectionsData');
    Route::get('collection-get',[CollectionController::class, 'getCollection'])->name('aGetCollection');
    Route::post('collection-save',[CollectionController::class, 'saveCollection'])->name('adminCollectionSave');
    Route::post('collection-remove',[CollectionController::class, 'removeCollection'])->name('aRemoveCollection');
    Route::post('collection-ordering',[CollectionController::class, 'reorderingCollection'])->name('aCollectionsSort');
    Route::post('collection-unAttachImage',[CollectionController::class, 'unAttachImage'])->name('aCollectionsUnAttachImage');

    // Route::get('attribute-get',[CollectionController::class, 'getAttribute'])->name('aGetAttribute');
    // Route::post('attribute-save',[CollectionController::class, 'saveAttribute'])->name('aSaveAttribute');

    //Dictionary
    Route::get('dictionary',[DictionaryController::class, 'index'])->name('adminDictionary');
    Route::get('dictionary-data',[DictionaryController::class, 'data'])->name('aDictionaryData');
    Route::get('dictionary-get',[DictionaryController::class, 'get'])->name('aGetDictionary');
    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDictionarySave');

    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDicionarySave');
    Route::post('dictionary-sync',[DictionaryController::class, 'sync'])->name('aSyncDictionary');

    //slider
    Route::get('slider',[SliderController::class,'index'])->name('adminSlider');
    Route::get('slider-get',[SliderController::class, 'get'])->name('sliderGet');
    Route::get('slider-data',[SliderController::class, 'sliderData'])->name('aSliderData');
    Route::post('slider-sort',[SliderController::class, 'sort'])->name('sliderSort');
    Route::get('slider-data',[SliderController::class, 'sliderData'])->name('aSliderData');
    Route::post('slider-save',[SliderController::class, 'saveSlider'])->name('adminSliderSave');
    Route::post('slider-remove',[SliderController::class, 'remove'])->name('sliderRemove');

    //Blog
    Route::get('blog',[BlogController::class,'blog'])->name('adminBlog');
    Route::get('blog-get',[BlogController::class, 'getBlog'])->name('aGetBlog');
    Route::get('blog-data',[BlogController::class, 'blogData'])->name('aBlogData');
    Route::post('blog-sort',[BlogController::class, 'sort'])->name('blogSort');
    Route::get('blog-data',[BlogController::class, 'blogData'])->name('aBlogData');
    Route::post('blog-save',[BlogController::class, 'saveBlog'])->name('adminBlogSave');
    Route::get('blog-remove',[BlogController::class, 'remove'])->name('blogRemove');

    //F.A.Q
    // Route::get('faq',[FaqController::class, 'faq'])->name('adminFaq');
    // Route::get('faq-data',[FaqController::class, 'faqData'])->name('aFaqData');
    // Route::get('faq-get',[FaqController::class, 'getFaq'])->name('aGetFaq');
    // Route::post('faq-save',[FaqController::class, 'saveFaq'])->name('adminFaqSave');
    // Route::post('faq-remove',[FaqController::class, 'removeFaq'])->name('aRemoveFaq');
    // Route::post('faq-ordering',[FaqController::class, 'reorderingFaq'])->name('aFaqSort');

    //Articles
    Route::get('articles',[ArticleController::class, 'index'])->name('adminArticles');
    Route::get('articles-data',[ArticleController::class, 'data'])->name('aArticlesData');
    Route::get('article-get',[ArticleController::class, 'get'])->name('aGetArticle');
    Route::post('article-save',[ArticleController::class, 'save'])->name('aArticleSave');

    // Route::get('migrate-attr',[AdminController::class, 'migratAttr'])->name('migratAttr');
    // Route::get('migrate-prod',[AdminController::class, 'migrateProducts'])->name('migrateProducts');
    // Route::get('migrate-rel',[AdminController::class, 'migrateRel'])->name('migrateRel');
    // Route::get('migrate-country',[AdminController::class, 'migrateCountries'])->name('migrateCountries');
    // Route::get('migrate-country-rel',[AdminController::class, 'migrateCountriesRel'])->name('migrateCountriesRel');
    // Route::get('migrate-brand',[AdminController::class, 'migrateBrend'])->name('migrateBrend');
    // Route::get('exportSubscription',[AdminController::class,'exportSubscription'])->name('exportSubscription');

    //
    // Route::get('address',[AddressController::class,'index'])->name('adminAddress');
    // Route::get('address-data',[AddressController::class, 'AddressData'])->name('aAddressData');
    // Route::get('address-get',[AddressController::class, 'getAddress'])->name('aAddressBlog');
    // Route::post('address-save',[AddressController::class, 'saveAddress'])->name('adminAddressSave');
    // Route::get('address-remove',[AddressController::class, 'remove'])->name('AddressRemove');
    // countries
    // Route::get('countries',[CountryController::class,'index'])->name('adminCountries');
    // Route::get('country-get',[CountryController::class, 'getCountry'])->name('aCountryGet');
    // Route::post('country-save',[CountryController::class, 'saveCountry'])->name('adminCountrySave');
    // Route::get('countries-remove',[CountryController::class, 'remove'])->name('CountriesRemove');
    // Route::get('Country-data',[CountryController::class, 'CountriesData'])->name('aCountriesData');
    // Brends
    
    Route::get('promos',[DealController::class,'promoIndex'])->name('adminPromos');
    Route::get('promo-data',[DealController::class,'promoData'])->name('aPromoData');
    Route::get('promo-get',[DealController::class, 'promoGet'])->name('aPromoGet');
    Route::get('promo-remove',[DealController::class, 'promoRemove'])->name('promoRemove');
    Route::post('promo-save',[DealController::class, 'promoSave'])->name('aPromoSave');

    Route::get('deals',[DealController::class,'dealIndex'])->name('adminDeals');
    Route::get('deal-data',[DealController::class,'dealData'])->name('aDealData');
    Route::get('deal-get',[DealController::class, 'dealGet'])->name('aDealGet');
    Route::get('deal-remove',[DealController::class, 'dealRemove'])->name('dealRemove');
    Route::post('deal-save',[DealController::class, 'dealSave'])->name('aDealSave');
    Route::post('unattach-deal-image',[DealController::class, 'unAttachDeal'])->name('adminDealUnAttach');
    // Route::get('brand-data',[BrandController::class, 'BrandData'])->name('aBrandData');
    // collection description
    
    // Route::get('desc-data',[CollectionController::class, 'AttrData'])->name('aCollectionAttributesData');
    // Route::get('Attr-get',[CollectionController::class, 'getAttr'])->name('aAttrGet');
    // Route::post('attributeAdd-save',[CollectionController::class, 'saveAttributeAdd'])->name('aSaveAttr');
    // Route::get('attribute-remove',[CollectionController::class, 'removeAttribute'])->name('AttrRemove');

    Route::get('user-data',[UserController::class, 'userData'])->name('aUserData');
    Route::get('users', [UserController::class, 'usersIndex'])->name('aUsers');
    Route::get('user-get',[UserController::class, 'get'])->name('userGet');
    Route::get('search-user',[UserController::class, 'searchUser'])->name('aGetUsers');
    
    // Route::post('user-upload-avatar',[ImageController::class, 'upload'])->name('uploadAvatar');
    //clear all cache
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
});
