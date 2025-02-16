<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandCnotroller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountCoupon;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcriberController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminInfoContoller;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


Route::get('/404', function () {
  return view('User.change-password');
});
Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::get('/change-password', [ProfileController::class, 'password'])->name('profile.change-password');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Profile Routes

Route::get('/Admin/profile', [AdminInfoContoller::class, 'edit'])->name('Admin.profile.edit');
Route::get('/Admin/change-password', [AdminInfoContoller::class, 'password'])->name('Admin.profile.change-password');
Route::patch('/Admin/profile', [AdminInfoContoller::class, 'update'])->name('Admin.profile.update');
Route::delete('/Admin/profile', [AdminInfoContoller::class, 'destroy'])->name('Admin.profile.destroy');





// Admin Routes




Route::middleware(['auth', 'admin'])->group(function () {
  Route::get('/Admin/Dashboard', [AdminController::class, 'dashboard'])->name('home');
  Route::get('/Admin/Category', [AdminController::class, 'category'])->name('category');
  Route::get('/Admin/Sub-Category', [AdminController::class, 'Subcategory'])->name('Subcategory');
  Route::get('/Admin/Brand', [AdminController::class, 'brand'])->name('brand');
  Route::get('/Admin/Product', [AdminController::class, 'product'])->name('product');
  Route::get('/Admin/Order', [AdminController::class, 'order'])->name('order');
  Route::get('/Admin/Order-Detail/{id}', [AdminController::class, 'OrderDetail'])->name('order-detail');
  Route::get('/Admin/Discount', [AdminController::class, 'discount'])->name('discount');
  Route::get('/Admin/User', [AdminController::class, 'user'])->name('user');
  Route::get('/Admin/News', [AdminController::class, 'news'])->name('news');
  Route::get('/Admin/Wishlists', [AdminController::class, 'wishlist'])->name('Admin-wishlist');
  Route::get('/Admin/Contact-Emails', [AdminController::class, 'contact'])->name('Admin-contact');
  Route::get('/Admin/Contact-Email-Detail/{id}', [AdminController::class, 'contactDetail'])->name('Admin-contact-detail');
  Route::delete('/Admin/Delete-Contact-Email/{id}', [AdminController::class, 'deleteContact'])->name('Delete-contact-Email');
  Route::get('/Admin/Service', [ServiceController::class, 'index'])->name('Admin-service');
  Route::get('/Admin/Team-Members', [TeamController::class, 'index'])->name('Admin-team');
  Route::post('/Admin/Change-Status/{id}', [OrderController::class, 'ChangrStatus'])->name('Change-Status');
  Route::post('/Admin/Send-Invioce-Email/{id}', [OrderController::class, 'SendInvioceEmail'])->name('Send-Invioce-Email');

  // User Delete Route
  Route::delete('/Admin/Delete-User/{id}', [AdminController::class, 'DeleteUser'])->name('Delete-User');


  // Category Routes
  Route::get('/Admin/Create-Category', [CategoryController::class, 'create'])->name('Create-Category');
  Route::post('/Admin/Store-Category', [CategoryController::class, 'store'])->name('Store-Category');
  Route::get('/Admin/Edit-Category/{id}', [CategoryController::class, 'edit'])->name('Edit-Category');
  Route::post('/Admin/Update-Category/{id}', [CategoryController::class, 'update'])->name('Update-Category');
  Route::delete('/Admin/Delete-Category/{id}', [CategoryController::class, 'destroy'])->name('Delete-Category');


  // Brand Routes
  Route::get('/Admin/Create-Brand', [BrandCnotroller::class, 'create'])->name('Create-Brand');
  Route::post('/Admin/Store-brand', [BrandCnotroller::class, 'store'])->name('Store-brand');
  Route::get('/Admin/Edit-Brand/{id}', [BrandCnotroller::class, 'edit'])->name('Edit-Brand');
  Route::post('/Admin/Update-brand/{id}', [BrandCnotroller::class, 'update'])->name('Update-brand');
  Route::delete('/Admin/Delete-Brand/{id}', [BrandCnotroller::class, 'destroy'])->name('Delete-Brand');


  // Product Routes
  Route::get('/Admin/Create-Product', [ProductController::class, 'create'])->name('Create-Product');
  Route::post('/Admin/Store-Product', [ProductController::class, 'store'])->name('Store-product');
  Route::get('/Admin/Edit-product/{id}', [ProductController::class, 'edit'])->name('Edit-product');
  Route::post('/Admin/Update-product/{id}', [ProductController::class, 'update'])->name('Update-product');
  Route::delete('/Admin/Delete-Product/{id}', [ProductController::class, 'destroy'])->name('Delete-product');
  Route::get('/Admin/Get-Product', [ProductController::class, 'getProduct'])->name('get-product');


  // News Routes
  Route::get('/Admin/Create-News', [NewsController::class, 'create'])->name('Create-News');
  Route::post('/Admin/Store-News', [NewsController::class, 'store'])->name('Store-News');
  Route::get('/Admin/Edit-News/{id}', [NewsController::class, 'edit'])->name('Edit-News');
  Route::post('/Admin/Update-News/{id}', [NewsController::class, 'update'])->name('Update-News');
  Route::delete('/Admin/Delete-News/{id}', [NewsController::class, 'destroy'])->name('Delete-News');


  // Service Routes
  Route::get('/Admin/Create-Service', [ServiceController::class, 'create'])->name('Create-Service');
  Route::post('/Admin/Store-Service', [ServiceController::class, 'store'])->name('Store-Service');
  Route::get('/Admin/Edit-Service/{id}', [ServiceController::class, 'edit'])->name('Edit-Service');
  Route::post('/Admin/Update-Service/{id}', [ServiceController::class, 'update'])->name('Update-Service');
  Route::delete('/Admin/Delete-Service/{id}', [ServiceController::class, 'destroy'])->name('Delete-Service');


  // Team Routes
  Route::get('/Admin/Create-Team-Member', [TeamController::class, 'create'])->name('Create-member');
  Route::post('/Admin/Store-Team-Member', [TeamController::class, 'store'])->name('Store-member');
  Route::get('/Admin/Edit-Team-Member/{id}', [TeamController::class, 'edit'])->name('Edit-member');
  Route::post('/Admin/Update-Team-Member/{id}', [TeamController::class, 'update'])->name('Update-member');
  Route::delete('/Admin/Delete-Team-Member/{id}', [TeamController::class, 'destroy'])->name('Delete-member');



  // Shipping Routes
  Route::get('/Admin/Shipping', [ShippingController::class, 'create'])->name('Shipping');
  Route::post('/Admin/Store-Shipping', [ShippingController::class, 'store'])->name('Store-shipping');
  Route::get('/Admin/Edit-Shipping/{id}', [ShippingController::class, 'edit'])->name('Edit-Shipping');
  Route::post('/Admin/Update-Shipping/{id}', [ShippingController::class, 'update'])->name('Update-Shipping');
  Route::delete('/Admin/Delete-Shipping/{id}', [ShippingController::class, 'destroy'])->name('Delete-Shipping');



  // Discount Coupons Routes
  Route::get('/Admin/Create-Discount-Coupon', [DiscountCoupon::class, 'create'])->name('Create-Discount-Coupon');
  Route::post('/Admin/Store-Dicount-Coupon', [DiscountCoupon::class, 'store'])->name('Store-Dicount-Coupon');
  Route::get('/Admin/Edit-Discount-Coupon/{id}', [DiscountCoupon::class, 'edit'])->name('Edit-Discount-Coupon');
  Route::post('/Admin/Update-Dicount-Coupon/{id}', [DiscountCoupon::class, 'update'])->name('Update-Dicount-Coupon');
  Route::delete('/Admin/Delete-Disount-Coupon/{id}', [DiscountCoupon::class, 'destroy'])->name('Delete-Disount-Coupon');


  //



  // Product image Routes
  Route::post('/Admin/product-Images/Updated', [ProductImageController::class, 'update'])->name('Update-product-image');
  Route::delete('/Admin/product-image/Deleted', [ProductImageController::class, 'destroy'])->name('Delete-product-image');



  // Excel Download Routes

  Route::get('Admin/User-Export', [ExcelController::class, 'userExcel'])->name('User-Export');
  Route::get('Admin/Order-Export', [ExcelController::class, 'OrderExcel'])->name('Order-Export');




  // Rating Routes
  Route::get('/Admin/Ratings/', [RatingController::class, 'index'])->name('Rating');
  Route::post('/Admin/Change-Rating-Status/{id}', [RatingController::class, 'ChangeStatus'])->name('Change-Rating-Status');
  Route::delete('/Admin/Delete-Rating/{id}', [RatingController::class, 'destroy'])->name('Delete-Rating');
  Route::get('/Admin/Rating-Detail/{id}', [RatingController::class, 'show'])->name('Show-Rating');


  // Feedback Routes

  Route::get('/Admin/Feedbacks/', [FeedbackController::class, 'index'])->name('feedback');
  Route::post('/Admin/Change-Feedback-Status/{id}', [FeedbackController::class, 'ChangeStatus'])->name('Change-Feedback-Status');
  Route::delete('/Admin/Delete-Feedback/{id}', [FeedbackController::class, 'destroy'])->name('Delete-Feedback');
  Route::get('/Admin/Feedback-Detail/{id}', [FeedbackController::class, 'show'])->name('Show-Feedback');

  // Subscriber Routes
  Route::get('/Admin/Subscribers/', [SubcriberController::class, 'index'])->name('Subscribers');
  Route::delete('/Admin/Delete-Subscriber/{id}', [SubcriberController::class, 'destroy'])->name('Delete-Subscriber');
  Route::get('/Admin/Subscriber-Detail/{id}', [SubcriberController::class, 'show'])->name('Show-Subscriber');
  Route::post('/Admin/Send-Subscription', [SubcriberController::class, 'send'])->name('Send-Subscriber');
});

Route::middleware(["MustEmailVerify"])->group(function(){
// User  Routes
  Route::get('/{category?}', [UserController::class, 'home'])->name('index');
  Route::get('/Creto/Service', [UserController::class, 'service'])->name('service');
  Route::get('/Creto/Shop/{category?}/{male?}', [UserController::class, 'shop'])->name('shop');
  Route::get('/Creto/Gallery', [UserController::class, 'gallery'])->name('gallery');
  Route::get('/Creto/About-Us', [UserController::class, 'about'])->name('about');
  Route::get('/Creto/Contact-Us', [UserController::class, 'contact'])->name('contact');
  Route::get('/Creto/Product-Detail/{slug}', [UserController::class, 'Product'])->name('Product');
  Route::get('/Creto/My-Cart', [UserController::class, 'Cart'])->name('Cart');
  Route::get('/Creto/My-Wishlist', [UserController::class, 'Wishlist'])->middleware('auth')->name('Wishlist');
  Route::get('/Creto/Checkout', [UserController::class, 'Checkout'])->middleware('auth')->name('Checkout');
  Route::get('/Creto/My-Orders', [UserController::class, 'Order'])->middleware('auth')->name('Order');
  Route::get('/Creto/Order-Detail/{id}', [UserController::class, 'OrderDetail'])->middleware('auth')->name('Order-Detail');
  Route::get('/Creto/News-Detail/{id}', [UserController::class, 'BlogDetail'])->name('Blog-Detail');
  Route::get('/Creto/News-detail/{slug}', [UserController::class, 'serviceDetail'])->name('Service-Detail');
  Route::get('/Creto/News', [UserController::class, 'News'])->name('News');
  Route::get('/Creto/404', [UserController::class, 'PageError'])->name('Page-Error');
  Route::get('/Creto/Thanks/{id}', [UserController::class, 'Thanks'])->middleware('auth')->name('Thanks-Page');
  Route::post('/Creto/Send-Contact-Email', [UserController::class, 'SendContactEmal'])->name('Send-Contact-Email');
  Route::post('/Creto/Send-Feedback', [FeedbackController::class, 'store'])->name('Send-Feedback');
  Route::post('/Creto/Store-Subcriber', [SubcriberController::class, 'store'])->name('Store-Subscriber');
  Route::post('/Creto/Store-Rating/{id}', [RatingController::class, 'store'])->name('Store-Rating');
  Route::get('/Creto/Download-Order-PDF/{id}', [UserController::class, 'DownloadPDF'])->middleware('auth')->name('Download-Order-PDF');
  Route::get('/Creto/Cancel-Order/{id}', [UserController::class, 'OrderCancel'])->middleware('auth')->name('order-cancel');





  // Cart Route

  Route::post('/Creto/Add-To-Cart', [CartController::class, "AddtoCart"])->name("Add-to-Cart");
  Route::post('/Creto/Update-Cart', [CartController::class, "UpdateCart"])->name("Update-Cart");
  Route::post('/Creto/Check-Cart', [CartController::class, "CheckCart"])->name("Check-Cart");
  Route::post('/Creto/Delete-Cart', [CartController::class, "DeleteCart"])->name("Delete-Cart");
  Route::post('/Creto/Proceed', [CartController::class, "proceed"])->name("Proceed");
  Route::post('/Creto/Get-Order-Summary', [CartController::class, "getOrderSummary"])->name("getOrderSummary");
  Route::post('/Creto/Get-Discount-Summary', [CartController::class, "GetDiscountSummary"])->name("Get-Discount-Summary");
  Route::post('/Creto/Remove-Coupon', [CartController::class, "RemoveCoupon"])->name("Remove-Coupon");



  // Wishlist Routes
  Route::post('/Creto/Store-Wishlist', [WishlistController::class, 'store'])->name('Store-Wishlist');
  Route::delete('/Creto/Remove-Wishlist/{id}', [WishlistController::class, 'destroy'])->name('Remove-Wishlist');

});


// GetSlug Route
Route::get('Admin/getSlug', function (Request $request) {

  $slug = '';
  if (!empty($request->input('title'))) {
    $slug = Str::slug($request->input('title'));
  }
  return response()->json([
    'status' => true,
    'slug' => $slug,
  ]);
})->name('GetSlug');



Route::post('/Temp-Images', [TempImageController::class, 'create'])->name('Temp-image');

Route::get('Creto/verify-email', [RegisteredUserController::class, 'email'])
->name('EmailVerify');

require __DIR__ . '/auth.php';
