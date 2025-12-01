<table class="table mt-1">
     <thead>
         <tr>
             <th>Module Permission </th>
             <th><small>Items Added & Updated</small> </th>
             <th><small>Items Deleted</small> </th>
             <th><small> All Users Items Permited </small></th>
             <th>
             	<label>
             	<input type="checkbox"  id="checkall" style="display: inline-block;">
             	<small> All (Leftside Show Menus) </small>
             	</label>
           		</th>
         </tr>
     </thead>
     <tbody>
       
         <tr>
             <td>Posts </td>
             <td>
             	<label>
                 	<input type="checkbox" name="permission[posts][add]" @isset(json_decode($role->permission, true)['posts']['add']) checked @endisset> Add/Update</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[posts][delete]" @isset(json_decode($role->permission, true)['posts']['delete']) checked @endisset> Delete</label>
             </td>
             <td>
                <label>
                 	<input type="checkbox" name="permission[posts][all]"  @isset(json_decode($role->permission, true)['posts']['all']) checked @endisset> All</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[posts][list]" @isset(json_decode($role->permission, true)['posts']['list']) checked @endisset> List</label>
             </td>
         </tr>
          <tr>
             <td>Posts Others </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][category]" @isset(json_decode($role->permission, true)['postsOther']['category']) checked @endisset> Categories</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[postsOther][tags]"  @isset(json_decode($role->permission, true)['postsOther']['tags']) checked @endisset> Tags</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][comments]" @isset(json_decode($role->permission, true)['postsOther']['comments']) checked @endisset> Comments</label>
             </td>
             <td>
                 
             </td>
        </tr>
        <tr>
             <td>Pages </td>
             <td>
             	<label>
                 	<input  type="checkbox" name="permission[pages][add]" @isset(json_decode($role->permission, true)['pages']['add']) checked @endisset> Add/Update</label>
             </td>
             <td>
                 <label>
                 	<input  type="checkbox" name="permission[pages][delete]" @isset(json_decode($role->permission, true)['pages']['delete']) checked @endisset> Delete</label>
             </td>
             <td>
                <label>
                 	<input  type="checkbox" name="permission[pages][all]" @isset(json_decode($role->permission, true)['pages']['all']) checked @endisset> All</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[pages][list]" @isset(json_decode($role->permission, true)['pages']['list']) checked @endisset> List</label>
             </td>
         </tr>
         <tr>
             <td>Medies Library </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[medies][add]" @isset(json_decode($role->permission, true)['medies']['add']) checked @endisset> Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[medies][delete]" @isset(json_decode($role->permission, true)['medies']['delete']) checked @endisset> Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[medies][all]" @isset(json_decode($role->permission, true)['medies']['all']) checked @endisset> All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[medies][list]" @isset(json_decode($role->permission, true)['medies']['list']) checked @endisset> List</label>
             </td>
         </tr>
         <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Ecommerce Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][general]" @isset(json_decode($role->permission, true)['ecommerceSetting']['general']) checked @endisset > General</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][coupons]" @isset(json_decode($role->permission, true)['ecommerceSetting']['coupons']) checked @endisset > Coupons</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][promotions]" @isset(json_decode($role->permission, true)['ecommerceSetting']['promotions']) checked @endisset > Promotions</label>
             </td>
             
             <td>
                 
             </td>
         </tr>
         <tr>
             <td>Products</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[products][add]" @isset(json_decode($role->permission, true)['products']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[products][delete]" @isset(json_decode($role->permission, true)['products']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[products][all]" @isset(json_decode($role->permission, true)['products']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[products][list]" @isset(json_decode($role->permission, true)['products']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>Products Other</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][category]" @isset(json_decode($role->permission, true)['postsOther']['category']) checked @endisset > Category</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[postsOther][tag]" @isset(json_decode($role->permission, true)['postsOther']['tag']) checked @endisset > Tag</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][attribute]" @isset(json_decode($role->permission, true)['postsOther']['attribute']) checked @endisset > Attribute</label>
             </td>
             <td>
                
             </td>
         </tr>
         <tr>
             <td>Order Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[orders][manage]" @isset(json_decode($role->permission, true)['orders']['manage']) checked @endisset > Manage</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[orders][delete]" @isset(json_decode($role->permission, true)['orders']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[orders][list]" @isset(json_decode($role->permission, true)['orders']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>POS Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[posUrders][manage]" @isset(json_decode($role->permission, true)['posUrders']['manage']) checked @endisset > Manage</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[posUrders][delete]" @isset(json_decode($role->permission, true)['posUrders']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[posUrders][all]" @isset(json_decode($role->permission, true)['posUrders']['all']) checked @endisset > All</label>
             </td>
             <td>
               <label>
                    <input type="checkbox" name="permission[posUrders][list]" @isset(json_decode($role->permission, true)['posUrders']['list']) checked @endisset > List</label> 
             </td>
         </tr>
         <tr>
             <td>Expenses</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[expenses][add]" @isset(json_decode($role->permission, true)['expenses']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[expenses][delete]" @isset(json_decode($role->permission, true)['expenses']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[expenses][type]" @isset(json_decode($role->permission, true)['expenses']['type']) checked @endisset > Head Of Expenses</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[expenses][list]" @isset(json_decode($role->permission, true)['expenses']['list']) checked @endisset > List</label>
             </td>
         </tr>
         
         <tr>
             <td>Report Management</td>
             
             <td>
                <label>
                    <input  type="checkbox" name="permission[reports][summery]" @isset(json_decode($role->permission, true)['reports']['summery']) checked @endisset > Summery Report</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[reports][products]" @isset(json_decode($role->permission, true)['reports']['products']) checked @endisset > Products Report</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[reports][customer]" @isset(json_decode($role->permission, true)['reports']['customer']) checked @endisset > Customer Report</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[reports][orders]" @isset(json_decode($role->permission, true)['reports']['orders']) checked @endisset > Order Report</label>
             </td>
         </tr>
         <tr>
             <td></td>
             
             <td>
                <label>
                    <input type="checkbox" name="permission[posUrders][salesreport]" @isset(json_decode($role->permission, true)['posUrders']['salesreport']) checked @endisset > Sales Report</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[expenses][report]" @isset(json_decode($role->permission, true)['expenses']['report']) checked @endisset > Expenses Report</label>
             </td>
             <td>
                 
             </td>
             <td>
               
             </td>
         </tr>
        <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Suppliers</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[suppliers][add]" @isset(json_decode($role->permission, true)['suppliers']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[suppliers][delete]" @isset(json_decode($role->permission, true)['suppliers']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[suppliers][all]" @isset(json_decode($role->permission, true)['suppliers']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[suppliers][list]" @isset(json_decode($role->permission, true)['suppliers']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>Store/Branch</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[warehouse][add]" @isset(json_decode($role->permission, true)['warehouse']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[warehouse][delete]" @isset(json_decode($role->permission, true)['warehouse']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[warehouse][all]" @isset(json_decode($role->permission, true)['warehouse']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[warehouse][list]" @isset(json_decode($role->permission, true)['warehouse']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>Stock Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[stockManage][add]" @isset(json_decode($role->permission, true)['stockManage']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[stockManage][delete]" @isset(json_decode($role->permission, true)['stockManage']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[stockManage][list]" @isset(json_decode($role->permission, true)['stockManage']['list']) checked @endisset > List</label>
                
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[stockManage][report]" @isset(json_decode($role->permission, true)['stockManage']['report']) checked @endisset > Report</label>
               
             </td>
         </tr>
         <tr>
             <td>Payment Method</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[paymentMethod][add]" @isset(json_decode($role->permission, true)['paymentMethod']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[paymentMethod][delete]" @isset(json_decode($role->permission, true)['paymentMethod']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[paymentMethod][all]" @isset(json_decode($role->permission, true)['paymentMethod']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[paymentMethod][list]" @isset(json_decode($role->permission, true)['paymentMethod']['list']) checked @endisset > List</label>
             </td>
         </tr>
        
        <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Clients</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[clients][add]" @isset(json_decode($role->permission, true)['clients']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[clients][delete]" @isset(json_decode($role->permission, true)['clients']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[clients][all]" @isset(json_decode($role->permission, true)['clients']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[clients][list]" @isset(json_decode($role->permission, true)['clients']['list']) checked @endisset > List</label>
             </td>
         </tr>

         <tr>
             <td>Brands</td>
             <td>
                <label>
                    <input  type="checkbox"  name="permission[brands][add]" @isset(json_decode($role->permission, true)['brands']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[brands][delete]" @isset(json_decode($role->permission, true)['brands']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[brands][all]" @isset(json_decode($role->permission, true)['brands']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[brands][list]" @isset(json_decode($role->permission, true)['brands']['list']) checked @endisset > List</label>
             </td>
         </tr>

          <tr>
             <td>Sliders</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[sliders][add]" @isset(json_decode($role->permission, true)['sliders']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[sliders][delete]" @isset(json_decode($role->permission, true)['sliders']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[sliders][all]" @isset(json_decode($role->permission, true)['sliders']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[sliders][list]" @isset(json_decode($role->permission, true)['sliders']['list']) checked @endisset > List</label>
             </td>
         </tr>

         <tr>
             <td>Galleries</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[galleries][add]" @isset(json_decode($role->permission, true)['galleries']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[galleries][delete]" @isset(json_decode($role->permission, true)['galleries']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[galleries][all]" @isset(json_decode($role->permission, true)['galleries']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[galleries][list]" @isset(json_decode($role->permission, true)['galleries']['list']) checked @endisset > List</label>
             </td>
         </tr>

          <tr>
             <td>Menus Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[menus][add]" @isset(json_decode($role->permission, true)['menus']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[menus][delete]" @isset(json_decode($role->permission, true)['menus']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[menus][all]" @isset(json_decode($role->permission, true)['menus']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[menus][list]" @isset(json_decode($role->permission, true)['menus']['list']) checked @endisset > List</label>
             </td>
         </tr>

         <tr>
             <td>Theme Setting</td>
             <td>
                 
             </td>
             <td>
                 
             </td>
             <td>
                
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[themeSetting][list]" @isset(json_decode($role->permission, true)['themeSetting']['list']) checked @endisset > List</label>
             </td>
         </tr>
          <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Administrator Users</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminUsers][add]" @isset(json_decode($role->permission, true)['adminUsers']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[adminUsers][delete]" @isset(json_decode($role->permission, true)['adminUsers']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[adminUsers][list]" @isset(json_decode($role->permission, true)['adminUsers']['list']) checked @endisset > List</label>
             </td>
         </tr>

         <tr>
             <td>Roles User</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminRoles][add]" @isset(json_decode($role->permission, true)['adminRoles']['add']) checked @endisset > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[adminRoles][delete]" @isset(json_decode($role->permission, true)['adminRoles']['delete']) checked @endisset > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminRoles][all]" @isset(json_decode($role->permission, true)['adminRoles']['all']) checked @endisset > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[adminRoles][list]" @isset(json_decode($role->permission, true)['adminRoles']['list']) checked @endisset > List</label>
             </td>
         </tr>
        <tr>
             <td>Customer Users</td>
             <td>
                <label>
                    <input type="checkbox" name="permission[users][add]" @isset(json_decode($role->permission, true)['users']['add']) checked @endisset > Add</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[users][update]" @isset(json_decode($role->permission, true)['users']['update']) checked @endisset > Update</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[users][delete]" @isset(json_decode($role->permission, true)['users']['delete']) checked @endisset > Delete</label>
             </td>
             
             <td>
                 <label>
                    <input type="checkbox" name="permission[users][list]" @isset(json_decode($role->permission, true)['users']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>Subscribe Users</td>
             <td>

             </td>
             <td>

             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[subscribe][delete]" @isset(json_decode($role->permission, true)['subscribe']['delete']) checked @endisset > Delete</label>
             </td>
             
             <td>
                 <label>
                    <input type="checkbox" name="permission[subscribe][list]" @isset(json_decode($role->permission, true)['subscribe']['list']) checked @endisset > List</label>
             </td>
         </tr>
         <tr>
             <td>Apps Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[appsSetting][general]" @isset(json_decode($role->permission, true)['appsSetting']['general']) checked @endisset > General Setting </label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[appsSetting][mail]" @isset(json_decode($role->permission, true)['appsSetting']['mail']) checked @endisset > Mail Setting</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[appsSetting][sms]" @isset(json_decode($role->permission, true)['appsSetting']['sms']) checked @endisset > SMS Setting</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[appsSetting][social]" @isset(json_decode($role->permission, true)['appsSetting']['social']) checked @endisset > Social Setting</label>
             </td>
         </tr>
         

     </tbody>
 </table>