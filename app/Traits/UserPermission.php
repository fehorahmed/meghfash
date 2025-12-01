<?php

namespace App\Traits;
use App\Models\Permission;
use Auth;
trait UserPermission{
	public function checkRequestPermission(){

		if($activerole =Permission::find(Auth::user()->permission_id)){
			if(
				
				empty(json_decode($activerole->permission, true)['products']['list']) && \Route::is('admin.services')||
				empty(json_decode($activerole->permission, true)['products']['add']) && \Route::is('admin.productsCreate') ||
				empty(json_decode($activerole->permission, true)['products']['add']) && \Route::is('admin.productsUpdate') ||
				empty(json_decode($activerole->permission, true)['products']['delete']) && \Route::is('admin.productsDelete') ||


				empty(json_decode($activerole->permission, true)['users']['list']) && \Route::is('admin.customerUsers')||
				empty(json_decode($activerole->permission, true)['users']['add']) && \Route::is('admin.usersCustomerAdd') ||
				empty(json_decode($activerole->permission, true)['users']['add']) && \Route::is('admin.usersCustomerPost') ||
				empty(json_decode($activerole->permission, true)['users']['update']) && \Route::is('admin.usersCustomerUpdate') ||
				empty(json_decode($activerole->permission, true)['users']['delete']) && \Route::is('admin.usersCustomerDelete') ||

				empty(json_decode($activerole->permission, true)['adminUsers']['list']) && \Route::is('admin.adminUsers')||
				empty(json_decode($activerole->permission, true)['adminUsers']['add']) && \Route::is('admin.adminUsersCreate') ||
				empty(json_decode($activerole->permission, true)['adminUsers']['add']) && \Route::is('admin.adminUsersPost') ||
				empty(json_decode($activerole->permission, true)['adminUsers']['suspend']) && \Route::is('admin.adminUsersSuspend') ||

				empty(json_decode($activerole->permission, true)['adminRoles']['list']) && \Route::is('admin.userRoles') ||
				empty(json_decode($activerole->permission, true)['adminRoles']['add']) && \Route::is('admin.userRoleAction') ||
				empty(json_decode($activerole->permission, true)['adminRoles']['delete']) && \Route::is('admin.usersRolesDelete') ||

				empty(json_decode($activerole->permission, true)['appsSetting']['general']) && \Request::is('admin/setting/general*') ||
				empty(json_decode($activerole->permission, true)['appsSetting']['general']) && \Request::is('admin/setting/logo*') ||
				empty(json_decode($activerole->permission, true)['appsSetting']['general']) && \Request::is('admin/setting/favicon*') ||
				empty(json_decode($activerole->permission, true)['appsSetting']['mail']) && \Request::is('admin/setting/mail*') ||
				empty(json_decode($activerole->permission, true)['appsSetting']['sms']) && \Request::is('admin/setting/sms*') ||
				empty(json_decode($activerole->permission, true)['appsSetting']['social']) && \Request::is('admin/setting/social*')


			){
				return abort('401');
			}
		}
	}
}