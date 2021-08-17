<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Auth::routes();
Route::post('post-login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'postLogin'])->name('login.post');
// Route::get('/', 'HomeController@index')->name('home');

// // Login
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // Register
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// // Reset Password
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// // Confirm Password
// Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
// Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => ['auth']], function () {

	Route::get('/', 'LandingController@index');

	Route::get('ckeditor-image/{folder}', 'LandingController@ckeditor')->name('ckeditor');
	Route::name('home.')->group(function () {
		Route::get('/change-multiple-status', 'LandingController@changeMultipleStatus')->name('change-multiple-status');
		Route::get('/delete-multiple', 'LandingController@deleteMultiple')->name('delete-multiple');
		Route::get('/discount-multiple', 'LandingController@discountMultiple')->name('discount-multiple');
		Route::post('/change-order', 'LandingController@changeOrder')->name('change-order');
	});


	Route::get('get-image', 'LandingController@getImage')->name('get-image');
	Route::post('add-images', 'LandingController@addImage')->name('add-images');
	Route::get('imagedelete/{table_name}/{folder_name}/{field}/{id}', 'LandingController@imageDelete')->name('imagedelete');

	Route::get('static-page/{type}', 'PageController@index')->name('static-page.index');
	Route::post('static-page/{type}', 'PageController@store')->name('static-page.store');
	Route::get('static-page/create/{type}', 'PageController@create')->name('static-page.create');
	// Route::get('static-page/{static-page}','PageController@show')->name('static-page.show');
	// Route::delete('static-page/{static-page}','PageController@destroy')->name('static-page.destroy');
	Route::any('static-page/{id}/{type}', 'PageController@update')->name('static-page.update');
	Route::get('static-page/{id}/edit/{type}', 'PageController@edit')->name('static-page.edit');

	Route::get('settings-type-list', 'SettingController@typeList')->name('settingstype.list');
	Route::get('settings/{type}', 'SettingController@index')->name('settings.index');
	Route::post('settings/{type}', 'SettingController@store')->name('settings.store');
	Route::get('settings/create/{type}', 'SettingController@create')->name('settings.create');
	// Route::get('settings/{settings}','SettingController@show')->name('settings.show');
	// Route::delete('settings/{settings}','SettingController@destroy')->name('settings.destroy');
	Route::any('settings/{id}/{type}', 'SettingController@update')->name('settings.update');
	Route::get('settings/{id}/edit/{type}', 'SettingController@edit')->name('settings.edit');


	Route::get('variables/{type}', 'VariableController@index')->name('variables.index');
	Route::post('variables/{type}', 'VariableController@store')->name('variables.store');
	Route::get('variables/create/{type}', 'VariableController@create')->name('variables.create');
	// Route::get('variables/{variable}','VariableController@show')->name('variables.show');
	// Route::delete('variables/{variable}','VariableController@destroy')->name('variables.destroy');
	Route::any('variables/{id}/{type}', 'VariableController@update')->name('variables.update');
	Route::get('variables/{id}/edit/{type}', 'VariableController@edit')->name('variables.edit');

	Route::post('variables-import', 'VariableController@import')->name('variables.import');
	Route::get('variables-export', 'VariableController@export')->name('variables.export');
	Route::get('generate-translation-file', 'VariableController@generateTranslationFile')->name('variables.generateTranslationFile');
	// Route::resource('settings','SettingController');

	Route::get('image-optimizes', 'ImageOptimizeController@index')->name('image-optimizes.index');
	Route::post('image-optimizes', 'ImageOptimizeController@store')->name('image-optimizes.store');
	Route::get('image-optimizes/create', 'ImageOptimizeController@create')->name('image-optimizes.create');
	// Route::get('image-optimizes/{variable}','ImageOptimizeController@show')->name('image-optimizes.show');
	Route::get('image-optimizes/delete/{id}', 'ImageOptimizeController@destroy')->name('image-optimizes.destroy');
	Route::any('image-optimizes/{id}', 'ImageOptimizeController@update')->name('image-optimizes.update');
	Route::get('image-optimizes/{id}/edit', 'ImageOptimizeController@edit')->name('image-optimizes.edit');

	// 2 days
	Route::get('category/manage-category', 'CategoryController@manageCategory')->name('category.manageCategory');
	Route::get('category', 'CategoryController@index')->name('category.index');
	Route::post('category', 'CategoryController@store')->name('category.store');
	Route::get('category/create', 'CategoryController@create')->name('category.create');
	Route::get('category/delete/{id}', 'CategoryController@destroy')->name('category.destroy');
	Route::any('category/{id}', 'CategoryController@update')->name('category.update');
	Route::get('category/{id}/edit', 'CategoryController@edit')->name('category.edit');

	// 2 days
	Route::get('colors', 'ColorController@index')->name('colors.index');
	Route::post('colors', 'ColorController@store')->name('colors.store');
	Route::get('colors/create', 'ColorController@create')->name('colors.create');
	Route::any('colors/{id}', 'ColorController@update')->name('colors.update');
	Route::get('colors/{id}/edit', 'ColorController@edit')->name('colors.edit');

	// 2 days
	Route::get('sizes', 'SizeController@index')->name('sizes.index');
	Route::post('sizes', 'SizeController@store')->name('sizes.store');
	Route::get('sizes/create', 'SizeController@create')->name('sizes.create');
	Route::any('sizes/{id}', 'SizeController@update')->name('sizes.update');
	Route::get('sizes/{id}/edit', 'SizeController@edit')->name('sizes.edit');

	Route::get('options', 'OptionController@index')->name('options.index');
	Route::post('options', 'OptionController@store')->name('options.store');
	Route::get('options/create', 'OptionController@create')->name('options.create');
	Route::any('options/{id}', 'OptionController@update')->name('options.update');
	Route::get('options/{id}/edit', 'OptionController@edit')->name('options.edit');

	// 21-07
	// here type = option_id
	Route::get('option-values/{type}', 'OptionValueController@index')->name('option-values.index');
	Route::post('option-values/{type}', 'OptionValueController@store')->name('option-values.store');
	Route::get('option-values/create/{type}', 'OptionValueController@create')->name('option-values.create');
	Route::any('option-values/{id}/{type}', 'OptionValueController@update')->name('option-values.update');
	Route::get('option-values/{id}/edit/{type}', 'OptionValueController@edit')->name('option-values.edit');

	Route::get('price-type', 'PriceTypeController@index')->name('price-type.index');
	Route::post('price-type', 'PriceTypeController@store')->name('price-type.store');
	Route::get('price-type/create', 'PriceTypeController@create')->name('price-type.create');
	Route::any('price-type/{id}', 'PriceTypeController@update')->name('price-type.update');
	Route::get('price-type/{id}/edit', 'PriceTypeController@edit')->name('price-type.edit');


	Route::get('products', 'ProductController@index')->name('products.index');
	Route::post('products', 'ProductController@store')->name('products.store');
	Route::get('products/create', 'ProductController@create')->name('products.create');
	Route::any('products/{id}', 'ProductController@update')->name('products.update');
	Route::get('products/{id}/edit', 'ProductController@edit')->name('products.edit');

	Route::match(array('GET', 'POST'), 'get-product-category-tab', 'ProductController@getCategoryTab')->name('products.getCategoryTab');
	Route::match(array('GET', 'POST'), 'get-product-color-tab', 'ProductController@getColorTab')->name('products.getColorTab');
	Route::match(array('GET', 'POST'), 'get-product-size-tab', 'ProductController@getSizeTab')->name('products.getSizeTab');
	Route::get('get-product-image-tab', 'ProductController@getImageTab')->name('products.getImageTab');
	Route::get('get-product-image-color-popup', 'ProductController@getColorPopUp')->name('products.getColorPopUp');
	Route::get('get-product-attribute-tab', 'ProductController@getAttributeTab')->name('products.getAttributeTab');
	Route::get('get-product-inventory-tab', 'ProductController@getInventoryTab')->name('products.getInventoryTab');
	Route::get('get-product-price-tab', 'ProductController@getPriceTab')->name('products.getPriceTab');
	Route::get('get-product-keyword-tab', 'ProductController@getProductKeywordTab')->name('products.getProductKeywordTab');
	Route::get('get-product-discount-tab', 'ProductController@getDiscountTab')->name('products.getDiscountTab');
	Route::get('get-product-banner-image', 'ProductController@getBannerImage')->name('products.getBannerImage');

	Route::get('find-product-color', 'ProductController@findProductColor')->name('products.findProductColor');
	Route::get('find-product-size', 'ProductController@findProductSize')->name('products.findProductSize');

	// Route::get('save-product-color','ProductController@saveProductColor')->name('products.saveProductColor');
	// Route::get('save-product-size','ProductController@saveProductSize')->name('products.saveProductSize');
	Route::match(array('GET', 'POST'), 'save-product-options', 'ProductController@saveProductOptions')->name('products.saveProductOptions');
	Route::get('save-product-quantity', 'ProductController@saveProductQuantity')->name('products.saveProductQuantity');
	Route::post('save-product-price', 'ProductController@saveProductPrice')->name('products.saveProductPrice');
	Route::post('save-all-product-price', 'ProductController@saveAllProductPrice')->name('products.saveAllProductPrice');
	Route::get('save-product-image-color', 'ProductController@saveImageColor')->name('products.saveImageColor');
	Route::post('add-product-images', 'ProductController@addImage')->name('products.add-product-images');
	Route::post('save-product-keywords', 'ProductController@saveProductKeywords')->name('products.saveProductKeywords');

	Route::get('delete-product-color', 'ProductController@deleteProductColor')->name('products.deleteProductColor');
	Route::get('delete-product-size', 'ProductController@deleteProductSize')->name('products.deleteProductSize');

	// here type is role id
	Route::get('users/{type}', 'UserController@index')->name('users.index');
	Route::post('users/{type}', 'UserController@store')->name('users.store');
	Route::get('users/create/{type}', 'UserController@create')->name('users.create');
	Route::any('users/{id}/{type}', 'UserController@update')->name('users.update');
	Route::get('users/{id}/edit/{type}', 'UserController@edit')->name('users.edit');

	Route::post('user-change-password', 'UserController@changePassword')->name('users.change-password');
	Route::match(array('GET', 'POST'), 'admin-change-password', 'UserController@adminChangePassword')->name('admins.change-password');


	// Route::resource('banner', 'BannerController');

	Route::get('banner/{type}', 'BannerController@index')->name('banner.index');
	Route::post('banner/{type}', 'BannerController@store')->name('banner.store');
	Route::get('banner/create/{type}', 'BannerController@create')->name('banner.create');
	Route::any('banner/{id}/{type}', 'BannerController@update')->name('banner.update');
	Route::get('banner/{id}/edit/{type}', 'BannerController@edit')->name('banner.edit');

	Route::get('countries', 'CountryController@index')->name('countries.index');
	Route::post('countries', 'CountryController@store')->name('countries.store');
	Route::get('countries/create', 'CountryController@create')->name('countries.create');
	Route::any('countries/{id}', 'CountryController@update')->name('countries.update');
	Route::get('countries/{id}/edit', 'CountryController@edit')->name('countries.edit');

	// here type is country_id
	Route::get('states/{type}', 'StateController@index')->name('states.index');
	Route::post('states/{type}', 'StateController@store')->name('states.store');
	Route::get('states/create/{type}', 'StateController@create')->name('states.create');
	Route::any('states/{id}/{type}', 'StateController@update')->name('states.update');
	Route::get('states/{id}/edit/{type}', 'StateController@edit')->name('states.edit');

	// here type is country_id and type2 is state_id
	Route::get('cities/{type}/{type2}', 'CityController@index')->name('cities.index');
	Route::post('cities/{type}', 'CityController@store')->name('cities.store');
	Route::get('cities/create/{type}/{type2}', 'CityController@create')->name('cities.create');
	Route::any('cities/{id}/{type}', 'CityController@update')->name('cities.update');
	Route::get('cities/{id}/edit/{type}/{type2}', 'CityController@edit')->name('cities.edit');

	Route::get('contacts', 'ContactController@index')->name('contacts.index');
	Route::post('contacts', 'ContactController@store')->name('contacts.store');
	Route::get('contacts/create', 'ContactController@create')->name('contacts.create');
	Route::any('contacts/{id}', 'ContactController@update')->name('contacts.update');
	Route::get('contacts/{id}/edit', 'ContactController@edit')->name('contacts.edit');

	Route::get('faq-categories', 'FaqCategoryController@index')->name('faq-categories.index');
	Route::post('faq-categories', 'FaqCategoryController@store')->name('faq-categories.store');
	Route::get('faq-categories/create', 'FaqCategoryController@create')->name('faq-categories.create');
	Route::any('faq-categories/{id}', 'FaqCategoryController@update')->name('faq-categories.update');
	Route::get('faq-categories/{id}/edit', 'FaqCategoryController@edit')->name('faq-categories.edit');
	// here type is faq category id
	Route::get('faqs/{type}', 'FaqController@index')->name('faqs.index');
	Route::post('faqs/{type}', 'FaqController@store')->name('faqs.store');
	Route::get('faqs/create/{type}', 'FaqController@create')->name('faqs.create');
	Route::any('faqs/{id}/{type}', 'FaqController@update')->name('faqs.update');
	Route::get('faqs/{id}/edit/{type}', 'FaqController@edit')->name('faqs.edit');

	Route::get('blog-categories', 'BlogCategoryController@index')->name('blog-categories.index');
	Route::post('blog-categories', 'BlogCategoryController@store')->name('blog-categories.store');
	Route::get('blog-categories/create', 'BlogCategoryController@create')->name('blog-categories.create');
	Route::any('blog-categories/{id}', 'BlogCategoryController@update')->name('blog-categories.update');
	Route::get('blog-categories/{id}/edit', 'BlogCategoryController@edit')->name('blog-categories.edit');

	// here type is blog category id
	Route::get('blogs/{type}', 'BlogController@index')->name('blogs.index');
	Route::post('blogs/{type}', 'BlogController@store')->name('blogs.store');
	Route::get('blogs/create/{type}', 'BlogController@create')->name('blogs.create');
	Route::any('blogs/{id}/{type}', 'BlogController@update')->name('blogs.update');
	Route::get('blogs/{id}/edit/{type}', 'BlogController@edit')->name('blogs.edit');

	Route::get('logos/{type}', 'ClientLogoController@index')->name('logos.index');
	Route::get('add-logos-name', 'ClientLogoController@addName')->name('logos.addName');
	Route::post('add-logo-images', 'ClientLogoController@addImage')->name('logos.add-logo-images');

	$array = [
		[
			'route' => 'languages',
			'controller' => 'LanguageController'
		],
		[
			'route' => 'newsletter-messages',
			'controller' => 'NewsletterMessageController'
		],	
		[
			'route' => 'newsletters',
			'controller' => 'NewsletterController'
		],
		[
			'route' => 'redirections',
			'controller' => 'RedirectionController'
		],
		[
			'route' => 'order-statuses',
			'controller' => 'OrderStatusController'
		],
		[
			'route' => 'discounts',
			'controller' => 'DiscountController',
			'pass_type' => 1
		],
	];
	foreach ($array as $a) {
		if(isset($a['pass_type'])) {
			Route::get($a['route'].'/{type}', $a['controller'] . '@index')->name($a['route'] . '.index');
			Route::post($a['route'].'/{type}', $a['controller'] . '@store')->name($a['route'] . '.store');
			Route::get($a['route'] . '/create/{type}', $a['controller'] . '@create')->name($a['route'] . '.create');
			Route::any($a['route'] . '/{id}/{type}', $a['controller'] . '@update')->name($a['route'] . '.update');
			Route::get($a['route'] . '/{id}/edit/{type}', $a['controller'] . '@edit')->name($a['route'] . '.edit');
		} else {
			Route::get($a['route'], $a['controller'] . '@index')->name($a['route'] . '.index');
			Route::post($a['route'], $a['controller'] . '@store')->name($a['route'] . '.store');
			Route::get($a['route'] . '/create', $a['controller'] . '@create')->name($a['route'] . '.create');
			Route::any($a['route'] . '/{id}', $a['controller'] . '@update')->name($a['route'] . '.update');
			Route::get($a['route'] . '/{id}/edit', $a['controller'] . '@edit')->name($a['route'] . '.edit');
		}		
	}

	Route::match(array('GET', 'POST'), 'newsletter-import', 'NewsletterController@import')->name('newsletters.import');
	Route::get('newsletter-export', 'NewsletterController@export')->name('newsletters.export');

	Route::get('newsletter-messages/{id}','NewsletterMessageController@show')->name('newsletter-messages.show');
	Route::post('newsletter-messages-send/{id}','NewsletterMessageController@send')->name('newsletter-messages.send');
	Route::post('add-newsletter-images', 'NewsletterMessageController@addImage')->name('newsletter-messages.add-images');
	Route::get('get-newsletter-images', 'NewsletterMessageController@getImage')->name('newsletter-messages.get-images');
	Route::get('save-newsletter-link', 'NewsletterMessageController@saveLink')->name('newsletter-messages.saveLink');
	Route::post('add-newsletter-attachment', 'NewsletterMessageController@addAttachment')->name('newsletter-messages.add-attachment');
	Route::get('get-newsletter-attachment', 'NewsletterMessageController@getAttachment')->name('newsletter-messages.get-attachment');
	
	Route::get('discount-find-user', 'DiscountController@findUser')->name('discounts.findUser');
	// Route::post('users/change-status','UserController@changeStatus');
	// Route::get('users/datatable','UserController@getDatatable');
	// Route::resource('users', 'UserController');

	// Route::get('roles/datatable','RoleController@getDatatable');
	// Route::resource('roles', 'RoleController');

	// Route::get('permissions/datatable','PermissionController@getDatatable');
	// Route::resource('permissions', 'PermissionController');

	// Route::get('user-roles/datatable','UserRoleController@getDatatable');
	// Route::resource('user-roles', 'UserRoleController');

	// Route::get('role-permissions/datatable','RolePermissionController@getDatatable');
	// Route::resource('role-permissions', 'RolePermissionController');

	// Route::group(['prefix' => 'translation-manager'], function () {
	// 	Route::get('view/{groupKey?}', 'TranslationManagerController@getView')->where('groupKey', '.*');
	//     Route::get('/{groupKey?}', 'TranslationManagerController@getIndex')->where('groupKey', '.*');
	//     Route::post('/add/{groupKey}', 'TranslationManagerController@postAdd')->where('groupKey', '.*');
	//     Route::post('/edit/{groupKey}', 'TranslationManagerController@postEdit')->where('groupKey', '.*');
	//     Route::post('/delete/{groupKey}/{translationKey}', 'TranslationManagerController@postDelete')->where('groupKey', '.*');
	//     Route::post('/import', 'TranslationManagerController@postImport');
	//     Route::post('/find', 'TranslationManagerController@postFind');
	//     Route::post('/publish/{groupKey}', 'TranslationManagerController@postPublish')->where('groupKey', '.*');
	// });

	//change password
	// Route::get('check-user-password', 'UserChangePasswordController@checkUserPassword');
	// Route::post('change-user-password', 'UserChangePasswordController@changeUserPassword');

});
