<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Route::auth();
/******************************************
****@AuThor:rubbish.boy@163.com
****@Title :公共方法访问控制
*******************************************/
Route::group(['middleware' => ['cors'], 'prefix' => 'captcha'], function() {  
Route::get('/register/{tmp?}', 'CaptchaController@register')->name('get.captcha.register');
Route::get('/login/{tmp?}', 'CaptchaController@login')->name('get.captcha.login');
});

/******************************************
****@AuThor:rubbish.boy@163.com
****@Title :会员中心
*******************************************/
Route::group(['namespace' => 'User', 'middleware' => ['cors'], 'prefix' => 'user'], function() {  
    /******************************************
	****@AuThor:rubbish.boy@163.com
	****@Title :会员注册
	*******************************************/
	Route::get('register/{type?}','RegisterController@register')->name('get.user.register');
	Route::post('register', 'RegisterController@store')->name('post.user.register');
	Route::post('register/exit_api', 'RegisterController@exit_api')->name('post.user.register.exit_api');
	/******************************************
	****@AuThor:rubbish.boy@163.com
	****@Title :会员登录
	*******************************************/
	Route::get('login/{type?}','LoginController@login')->name('get.user.login');
	Route::post('login', 'LoginController@login_action')->name('post.user.login');
	/******************************************
	****@AuThor:rubbish.boy@163.com
	****@Title :退出登录
	*******************************************/
	Route::get('logout','LoginController@logout')->name('get.user.logout');
});


/******************************************
****@AuThor:rubbish.boy@163.com
****@Title :前台访问控制
*******************************************/
Route::group(['middleware' => ['cors']], function() {  
Route::get('/', 'HomeController@index');
});





/******************************************
****@AuThor:rubbish.boy@163.com
****@Title :后台访问需登录控制
*******************************************/
Route::group(['middleware' => 'auth_admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {  
	/*
	 ***********************************************************************
	 *	   get 路由
	 ***********************************************************************
	 */	
    Route::get('/', 'HomeController@index')->name('get.admin');
	
	Route::get('setting', 
				[
			        'middleware' => ['ability:admin,model_setting'], 
			        'uses' => 'SettingController@index'
    			])->name('get.admin.setting');

	Route::get('user', 
				[
			        'middleware' => ['ability:admin,model_user'], 
			        'uses' => 'UserController@index'
    			])->name('get.admin.user');
	Route::get('userinfo', 
				[
			        'middleware' => ['ability:admin,set_userinfo'], 
			        'uses' => 'UserController@userinfo'
    			])->name('get.admin.userinfo');
	Route::get('edit_pwd', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'UserController@edit_pwd'
    			])->name('get.admin.edit_pwd');
	Route::get('user/set/{id?}', 
				[
			        'middleware' => ['ability:admin,set_role'], 
			        'uses' => 'UserController@set'
    			])->name('get.admin.user.set');
	//用户角色			
	Route::get('userrole', 
				[
			        'middleware' => ['ability:admin,model_role'], 
			        'uses' => 'UserroleController@index'
    			])->name('get.admin.userrole');
	Route::get('userrole/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'UserroleController@add'
    			])->name('get.admin.userrole.add');
	Route::get('userrole/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'UserroleController@edit'
    			])->name('get.admin.userrole.edit');
	Route::get('userrole/set/{id?}', 
				[
			        'middleware' => ['ability:admin,set_permission'], 
			        'uses' => 'UserroleController@set'
    			])->name('get.admin.userrole.set');
	//角色权限				
	Route::get('userpermission', 
				[
			        'middleware' => ['ability:admin,model_permission'], 
			        'uses' => 'UserpermissionController@index'
    			])->name('get.admin.userpermission');
	Route::get('userpermission/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'UserpermissionController@add'
    			])->name('get.admin.userpermission.add');
	Route::get('userpermission/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'UserpermissionController@edit'
    			])->name('get.admin.userpermission.edit');
	//主导航栏			
	Route::get('navigation', 
				[
			        'middleware' => ['ability:admin,model_navigation'], 
			        'uses' => 'NavigationController@index'
    			])->name('get.admin.navigation');
	Route::get('navigation/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'NavigationController@add'
    			])->name('get.admin.navigation.add');
	Route::get('navigation/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'NavigationController@edit'
    			])->name('get.admin.navigation.edit');		    
	//文章分类			
	Route::get('classify', 
				[
			        'middleware' => ['ability:admin,model_classify'], 
			        'uses' => 'ClassifyController@index'
    			])->name('get.admin.classify');
	Route::get('classify/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'ClassifyController@add'
    			])->name('get.admin.classify.add');
	Route::get('classify/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'ClassifyController@edit'
    			])->name('get.admin.classify.edit');
	//文章资讯				
	Route::get('article', 
				[
			        'middleware' => ['ability:admin,model_article'], 
			        'uses' => 'ArticleController@index'
    			])->name('get.admin.article');
	Route::get('article/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'ArticleController@add'
    			])->name('get.admin.article.add');
	Route::get('article/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'ArticleController@edit'
    			])->name('get.admin.article.edit');	
	//广告图片		
	Route::get('picture', 
				[
			        'middleware' => ['ability:admin,model_picture'], 
			        'uses' => 'PictureController@index'
    			])->name('get.admin.picture');
	Route::get('picture/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'PictureController@add'
    			])->name('get.admin.picture.add');
	Route::get('picture/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'PictureController@edit'
    			])->name('get.admin.picture.edit');
	//文章分类			
	Route::get('classifylink', 
				[
			        'middleware' => ['ability:admin,model_classifylink'], 
			        'uses' => 'ClassifylinkController@index'
    			])->name('get.admin.classifylink');
	Route::get('classifylink/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'ClassifylinkController@add'
    			])->name('get.admin.classifylink.add');
	Route::get('classifylink/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'ClassifylinkController@edit'
    			])->name('get.admin.classifylink.edit');			
	//友情链接		
	Route::get('link', 
				[
			        'middleware' => ['ability:admin,model_link'], 
			        'uses' => 'LinkController@index'
    			])->name('get.admin.link');
	Route::get('link/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'LinkController@add'
    			])->name('get.admin.link.add');
	Route::get('link/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'LinkController@edit'
    			])->name('get.admin.link.edit');	
	//日志管理		
	Route::get('log', 
				[
			        'middleware' => ['ability:admin,model_log'], 
			        'uses' => 'LogController@index'
    			])->name('get.admin.log');
	//信件管理				
	Route::get('letter', 
				[
			        'middleware' => ['ability:admin,model_letter'], 
			        'uses' => 'LetterController@index'
    			])->name('get.admin.letter');
	Route::get('letter/send', 
				[
			        'middleware' => ['ability:admin,model_letter'], 
			        'uses' => 'LetterController@send'
    			])->name('get.admin.letter.send');
	Route::get('letter/star', 
				[
			        'middleware' => ['ability:admin,model_letter'], 
			        'uses' => 'LetterController@star'
    			])->name('get.admin.letter.star');	
	Route::get('letter/trash', 
				[
			        'middleware' => ['ability:admin,model_letter'], 
			        'uses' => 'LetterController@trash'
    			])->name('get.admin.letter.trash');										
	Route::get('letter/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'LetterController@add'
    			])->name('get.admin.letter.add');
	//微信管理		
	Route::get('wechat', 
				[
			        'middleware' => ['ability:admin,model_wechat'], 
			        'uses' => 'WechatController@index'
    			])->name('get.admin.wechat');
	Route::get('wechat/add', 
				[
			        'middleware' => ['ability:admin,add'], 
			        'uses' => 'WechatController@add'
    			])->name('get.admin.wechat.add');
	Route::get('wechat/edit/{id?}', 
				[
			        'middleware' => ['ability:admin,edit'], 
			        'uses' => 'WechatController@edit'
    			])->name('get.admin.wechat.edit');
	/*
	 ***********************************************************************
	 *	   post 路由
	 ***********************************************************************
	 */	
	Route::post('home/api_setting', 'HomeController@api_setting')->name('post.admin.home.api_setting');
	Route::post('setting/api_info', 'SettingController@api_info')->name('post.admin.setting.api_info');

	Route::post('cacheapi/api_cache', 'CacheapiController@api_cache')->name('post.admin.cacheapi.api_cache');
	Route::post('district/api_area', 'DistrictController@api_area')->name('post.admin.district.api_area');

	Route::post('deleteapi/api_delete', 'DeleteapiController@api_delete')->name('post.admin.deleteapi.api_delete');
	Route::post('deleteapi/api_clear', 'DeleteapiController@api_clear')->name('post.admin.deleteapi.api_clear');
	Route::post('deleteapi/api_del_image', 'DeleteapiController@api_del_image')->name('post.admin.deleteapi.api_del_image');

	Route::post('markdownupload', 'MarkdownapiController@upload')->name('post.admin.markdownupload');
	Route::post('oneactionapi/api_one_action', 'OneactionapiController@api_one_action')->name('post.admin.oneactionapi.api_one_action');

	Route::post('log/api_list', 'LogController@api_list')->name('post.admin.log.api_list');

	Route::post('user/api_list', 'UserController@api_list')->name('post.admin.user.api_list');
	Route::post('user/api_get_one', 'UserController@api_get_one')->name('post.admin.user.api_get_one');
	Route::post('user/api_edit_pwd', 'UserController@api_edit_pwd')->name('post.admin.user.api_edit_pwd');
	Route::post('userinfo/api_info', 'UserController@api_info')->name('post.admin.user.api_info');
	Route::post('userinfo/api_edit', 'UserController@api_edit')->name('post.admin.user.api_edit');

	Route::post('userrole/api_list', 'UserroleController@api_list')->name('post.admin.userrole.api_list');
	Route::post('userrole/api_get_role', 'UserroleController@api_get_role')->name('post.admin.userrole.api_get_role');
	Route::post('userrole/api_cancel_role', 'UserroleController@api_cancel_role')->name('post.admin.userrole.api_cancel_role');
	Route::post('userrole/api_list_related', 'UserroleController@api_list_related')->name('post.admin.userrole.api_list_related');
	Route::post('userrole/api_add', 'UserroleController@api_add')->name('post.admin.userrole.api_add');
	Route::post('userrole/api_info', 'UserroleController@api_info')->name('post.admin.userrole.api_info');
	Route::post('userrole/api_edit', 'UserroleController@api_edit')->name('post.admin.userrole.api_edit');

	Route::post('userpermission/api_list', 'UserpermissionController@api_list')->name('post.admin.userpermission.api_list');
	Route::post('userpermission/api_get_permission', 'UserpermissionController@api_get_permission')->name('post.admin.userpermission.api_get_permission');
	Route::post('userpermission/api_cancel_permission', 'UserpermissionController@api_cancel_permission')->name('post.admin.userpermission.api_cancel_permission');
	Route::post('userpermission/api_list_related', 'UserpermissionController@api_list_related')->name('post.admin.userpermission.api_list_related');
	Route::post('userpermission/api_add', 'UserpermissionController@api_add')->name('post.admin.userpermission.api_add');
	Route::post('userpermission/api_info', 'UserpermissionController@api_info')->name('post.admin.userpermission.api_info');
	Route::post('userpermission/api_edit', 'UserpermissionController@api_edit')->name('post.admin.userpermission.api_edit');

	Route::post('navigation/api_list', 'NavigationController@api_list')->name('post.admin.navigation.api_list');
	Route::post('navigation/api_add', 'NavigationController@api_add')->name('post.admin.navigation.api_add');
	Route::post('navigation/api_info', 'NavigationController@api_info')->name('post.admin.navigation.api_info');
	Route::post('navigation/api_edit', 'NavigationController@api_edit')->name('post.admin.navigation.api_edit');

	Route::post('classify/api_list', 'ClassifyController@api_list')->name('post.admin.classify.api_list');
	Route::post('classify/api_add', 'ClassifyController@api_add')->name('post.admin.classify.api_add');
	Route::post('classify/api_info', 'ClassifyController@api_info')->name('post.admin.classify.api_info');
	Route::post('classify/api_edit', 'ClassifyController@api_edit')->name('post.admin.classify.api_edit');

	Route::post('article/api_list', 'ArticleController@api_list')->name('post.admin.article.api_list');
	Route::post('article/api_add', 'ArticleController@api_add')->name('post.admin.article.api_add');
	Route::post('article/api_info', 'ArticleController@api_info')->name('post.admin.article.api_info');
	Route::post('article/api_edit', 'ArticleController@api_edit')->name('post.admin.article.api_edit');

	Route::post('picture/api_list', 'PictureController@api_list')->name('post.admin.picture.api_list');
	Route::post('picture/api_add', 'PictureController@api_add')->name('post.admin.picture.api_add');
	Route::post('picture/api_info', 'PictureController@api_info')->name('post.admin.picture.api_info');
	Route::post('picture/api_edit', 'PictureController@api_edit')->name('post.admin.picture.api_edit');

	Route::post('classifylink/api_list', 'ClassifylinkController@api_list')->name('post.admin.classifylink.api_list');
	Route::post('classifylink/api_add', 'ClassifylinkController@api_add')->name('post.admin.classifylink.api_add');
	Route::post('classifylink/api_info', 'ClassifylinkController@api_info')->name('post.admin.classifylink.api_info');
	Route::post('classifylink/api_edit', 'ClassifylinkController@api_edit')->name('post.admin.classifylink.api_edit');

	Route::post('link/api_list', 'LinkController@api_list')->name('post.admin.link.api_list');
	Route::post('link/api_add', 'LinkController@api_add')->name('post.admin.link.api_add');
	Route::post('link/api_info', 'LinkController@api_info')->name('post.admin.link.api_info');
	Route::post('link/api_edit', 'LinkController@api_edit')->name('post.admin.link.api_edit');

	Route::post('letter/api_list', 'LetterController@api_list')->name('post.admin.letter.api_list');
	Route::post('letter/api_add', 'LetterController@api_add')->name('post.admin.letter.api_add');
	Route::post('letter/api_info', 'LetterController@api_info')->name('post.admin.letter.api_info');
	Route::post('letter/api_count', 'LetterController@api_count')->name('post.admin.letter.api_edit');

	Route::post('wechat/api_list', 'WechatController@api_list')->name('post.admin.wechat.api_list');
	Route::post('wechat/api_add', 'WechatController@api_add')->name('post.admin.wechat.api_add');
	Route::post('wechat/api_info', 'WechatController@api_info')->name('post.admin.wechat.api_info');
	Route::post('wechat/api_edit', 'WechatController@api_edit')->name('post.admin.wechat.api_edit');
	
});


