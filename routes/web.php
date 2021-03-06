<?php

Route::get('/', function () {
    return redirect('/'. App\Http\Middleware\LocaleMiddleware::$mainLanguage);
});

Route::get('lang/{lang}', function ($lang) {
    $referer = Redirect::back()->getTargetUrl();
    $parse_url = parse_url($referer, PHP_URL_PATH);
    $segments = explode('/', $parse_url);
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
        unset($segments[1]);
    }

    array_splice($segments, 1, 0, $lang);
    $url = Request::root().implode("/", $segments);
    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url);
})->name('lang');

//// Comments route
Route::get('/discussion/{id}/load.json', 'DiscussionController@loadComments');
Route::post('/discussion/{id}/comment.json', 'DiscussionController@commentJson');

//// Sidebar route
Route::get('/sidebar/realm-status', 'SidebarController@SidebarStatus')->name('status');
Route::get('/sidebar/client', 'SidebarController@SidebarClient')->name('client');
Route::get('/sidebar/events', 'SidebarController@SidebarEvents')->name('events');
Route::get('/sidebar/blizzard-posts', 'SidebarController@SidebarForum')->name('forum');


Route::get('account/management/services/is-character-eligible', 'DiscussionController@isCharacterEligible');

Route::get('version', 'DiscussionController@version');
Route::post('account/pin/{characters}', 'DiscussionController@pin');


Route::get('item/{item}/tooltip', 'ItemController@tooltip');

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){
    /// Auth route
    Auth::routes();
    Route::get('logout','Auth\LoginController@logout');
    // Password Reset Routes...
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password-reset');
    /// Auth route end

    Route::get('/', 'HomeController@index')->name('home');

    //// Blog route
    Route::resource('blog', 'BlogController', ['parameters' => ['id' => 'id', 't' => 't']]);

    //// Shop route
    Route::get('family/world-of-warcraft', 'ShopController@index')->name('shop');
    Route::get('shop/family/world-of-warcraft', 'ShopController@test')->name('shop-test');
    Route::get('shop/mount-{name}', 'ShopController@view')->name('shop.mount');
    Route::get('shop/item-{name}', 'ShopController@view')->name('shop.item');
    Route::get('shop/buy-{name}', 'ShopController@buy')->name('shop.buy');
    Route::post('shop/complete-{name}', 'ShopController@store')->name('shop.complete');
    Route::get('shop/complete-{name}', 'ShopController@buyComplete')->name('shop.buyComplete');
    Route::get('shop/checkout/add-balance', 'ShopController@addBalance')->name('add-balance');
    Route::post('shop/checkout/pay', 'ShopController@payBalanceAction')->name('pay-balanceAction');
    Route::get('shop/checkout/pay', 'ShopController@payBalance')->name('pay-balance');
    Route::get('shop/checkout/paypal', 'ShopController@payPaypal')->name('pay-paypal');

    /// Forum route
    Route::post('forums/pref/character/{characters}', 'DiscussionController@pin');
    Route::get('forums/', 'CategoryController@index')->name('forums');
    Route::get('forums/{category}', 'CategoryController@show')->name('forum')->where('category', '[0-9]+');
    Route::get('forums/search', 'TopicsController@search')->name('forum.search');
    Route::get('forums/{category}/topic/{topic}/undefined/frag', 'TopicsController@edit')->name('forum.edit-topic')->where(['category' => '[0-9]+', 'topic' => '[0-9]+']);
    Route::post('forums/{category}/create', 'TopicsController@store')->name('forum.topic.store')->where('category', '[0-9]+');
    Route::get('forums/{category}/topic/{topic}', 'TopicsController@show')->name('forum.topic')->where(['category' => '[0-9]+', 'topic' => '[0-9]+']);
    Route::post('forums/{category}/{topic}/create', 'TopicsController@store_reply')->name('forum.topic.reply.create')->where(['category' => '[0-9]+', 'topic' => '[0-9]+']);
    Route::patch('forums/{category}/{topic}', 'TopicsController@update_reply')->name('forum.topic.reply.update')->where(['category' => '[0-9]+', 'topic' => '[0-9]+']);
    Route::delete('forums/{category}/{topic}/{reply}', 'TopicsController@delete_reply')->name('forum.topic.reply.destroy')->where(['category' => '[0-9]+', 'topic' => '[0-9]+', 'reply' => '[0-9]+']);

    /// Account route
    Route::get('account/management', 'UserController@showProfile')->name('account');
    Route::get('account/management/settings/change-email.html', 'UserController@changeEmail');
    Route::post('account/management/settings/change-email.html', 'UserController@changeEmailActoin')->name('change-email');

    Route::get('account/management/settings/change-password.html', 'UserController@changePassword');
    Route::post('account/management/settings/change-password.html', 'UserController@changePasswordActoin')->name('change-password');

    Route::get('account/management/tag-name-change.html', 'UserController@tagNameChange');
    Route::post('account/management/tag-name-change.html', 'UserController@tagNameChangeActoin')->name('tag-name-change');
    Route::get('account/management/tag-name-create', 'UserController@createName')->name('create-name');
    Route::post('account/management/tag-name-create', 'UserController@createNameAction')->name('create-name-action');

    Route::get('account/management/wallet.html', 'UserController@showWallet')->name('wallet');
    Route::get('account/management/primary-address.html', 'UserController@showProfile')->name('primary-address');
    Route::get('account/management/wow/dashboard.html', 'UserController@dashboard')->name('dashboard');

    Route::get('account/management/claim-code.html', 'UserController@claimCode')->name('claim-code');
    Route::get('account/management/claim-code-item.html', 'UserController@claimCodeSendAction')->name('claim-code-send');
    Route::post('account/management/claim-code.html', 'UserController@claimCodeAction')->name('claim-code-action');

    Route::get('account/management/get-a-game.html', 'UserController@showProfile')->name('get-a-game');
    Route::get('account/management/download/', 'UserController@showProfile')->name('download-game');
    Route::get('account/management/beta-profile.html', 'UserController@showProfile')->name('beta-profile');

    Route::get('account/management/orders.html', 'UserController@showOrders')->name('orders');
    Route::get('account/management/transaction-history.html', 'UserController@showProfile')->name('transaction-history');
    Route::get('account/management/gift-claim-history.html', 'UserController@showProfile')->name('gift-claim-history');

    Route::get('community', 'CommunityController@Communityindex')->name('community');
    Route::get('community/bugtracker', 'CommunityController@bugtrackerIndex')->name('bugtracker');
    Route::get('community/status', 'CommunityController@CommunityStatus')->name('community-status');
    Route::get('community/bugtracker/create', 'CommunityController@bugtrackerCreate')->name('bugtracker-create');
    Route::post('community/bugtracker/comment', 'CommunityController@bugtrackerComment')->name('bugtracker-comment');
    Route::post('community/bugtracker/submit', 'CommunityController@bugtrackerSubmit')->name('bugtracker-submit');
    Route::post('community/bugtracker/comment_submit', 'CommunityController@bugtrackerCommentSubmit')->name('bugtracker-comment-submit');
    Route::get('community/bugtracker/comment_edit/{id}', 'CommunityController@bugtrackerCommentEdit')->name('bugtracker-comment-edit');
    Route::get('community/bugtracker/{id}', 'CommunityController@bugtrackerView')->name('bugtracker-view');

    Route::get('characters/ElisGrimm/{characters}/simple', 'CharactersController@characters')->name('characters-simple');
});

///// ADMIN /////
Route::group(['middleware' => ['auth', 'admin']], function(){
    Route::get('/admin','Admin\AdminController@index')->name('admin-home');
    Route::get('/admin/news/list','Admin\NewsController@list')->name('admin-news-list');
    Route::get('/admin/news/edit/{id}','Admin\NewsController@edit')->name('admin-news-edit');
    Route::post('/admin/news/save','Admin\NewsController@save')->name('admin-news-save');
    Route::get('/admin/news/delete/{id}','Admin\NewsController@delete')->name('admin-news-delete');
    Route::get('/admin/news/create','Admin\NewsController@create')->name('admin-news-add');
    Route::post('/admin/news/create','Admin\NewsController@createAction');

    Route::get('/admin/shop/list','Admin\ShopController@list')->name('admin-shop-list');
    Route::get('/admin/shop/edit/{id}','Admin\ShopController@edit')->name('admin-shop-edit');
    Route::post('/admin/shop/save','Admin\ShopController@save')->name('admin-shop-save');
    Route::get('/admin/shop/delete/{id}','Admin\ShopController@delete')->name('admin-shop-delete');
    Route::get('/admin/shop/create','Admin\ShopController@create')->name('admin-shop-add');
    Route::post('/admin/shop/create','Admin\ShopController@createAction');

    Route::get('/admin/forum/list','Admin\ForumController@list')->name('admin-forum-list');
    Route::get('/admin/forum/edit/{id}','Admin\ForumController@edit')->name('admin-forum-edit');
    Route::post('/admin/forum/save','Admin\ForumController@save')->name('admin-forum-save');
    Route::get('/admin/forum/delete/{id}','Admin\ForumController@delete')->name('admin-forum-delete');
    Route::get('/admin/forum/create','Admin\ForumController@create')->name('admin-forum-add');
    Route::post('/admin/forum/create','Admin\ForumController@createAction');
});