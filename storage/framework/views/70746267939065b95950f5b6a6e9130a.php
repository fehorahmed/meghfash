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
                 	<input type="checkbox" name="permission[posts][add]" <?php if(isset(json_decode($role->permission, true)['posts']['add'])): ?> checked <?php endif; ?>> Add/Update</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[posts][delete]" <?php if(isset(json_decode($role->permission, true)['posts']['delete'])): ?> checked <?php endif; ?>> Delete</label>
             </td>
             <td>
                <label>
                 	<input type="checkbox" name="permission[posts][all]"  <?php if(isset(json_decode($role->permission, true)['posts']['all'])): ?> checked <?php endif; ?>> All</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[posts][list]" <?php if(isset(json_decode($role->permission, true)['posts']['list'])): ?> checked <?php endif; ?>> List</label>
             </td>
         </tr>
          <tr>
             <td>Posts Others </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][category]" <?php if(isset(json_decode($role->permission, true)['postsOther']['category'])): ?> checked <?php endif; ?>> Categories</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[postsOther][tags]"  <?php if(isset(json_decode($role->permission, true)['postsOther']['tags'])): ?> checked <?php endif; ?>> Tags</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][comments]" <?php if(isset(json_decode($role->permission, true)['postsOther']['comments'])): ?> checked <?php endif; ?>> Comments</label>
             </td>
             <td>
                 
             </td>
        </tr>
        <tr>
             <td>Pages </td>
             <td>
             	<label>
                 	<input  type="checkbox" name="permission[pages][add]" <?php if(isset(json_decode($role->permission, true)['pages']['add'])): ?> checked <?php endif; ?>> Add/Update</label>
             </td>
             <td>
                 <label>
                 	<input  type="checkbox" name="permission[pages][delete]" <?php if(isset(json_decode($role->permission, true)['pages']['delete'])): ?> checked <?php endif; ?>> Delete</label>
             </td>
             <td>
                <label>
                 	<input  type="checkbox" name="permission[pages][all]" <?php if(isset(json_decode($role->permission, true)['pages']['all'])): ?> checked <?php endif; ?>> All</label>
             </td>
             <td>
                 <label>
                 	<input type="checkbox" name="permission[pages][list]" <?php if(isset(json_decode($role->permission, true)['pages']['list'])): ?> checked <?php endif; ?>> List</label>
             </td>
         </tr>
         <tr>
             <td>Medies Library </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[medies][add]" <?php if(isset(json_decode($role->permission, true)['medies']['add'])): ?> checked <?php endif; ?>> Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[medies][delete]" <?php if(isset(json_decode($role->permission, true)['medies']['delete'])): ?> checked <?php endif; ?>> Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[medies][all]" <?php if(isset(json_decode($role->permission, true)['medies']['all'])): ?> checked <?php endif; ?>> All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[medies][list]" <?php if(isset(json_decode($role->permission, true)['medies']['list'])): ?> checked <?php endif; ?>> List</label>
             </td>
         </tr>
         <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Ecommerce Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][general]" <?php if(isset(json_decode($role->permission, true)['ecommerceSetting']['general'])): ?> checked <?php endif; ?> > General</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][coupons]" <?php if(isset(json_decode($role->permission, true)['ecommerceSetting']['coupons'])): ?> checked <?php endif; ?> > Coupons</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[ecommerceSetting][promotions]" <?php if(isset(json_decode($role->permission, true)['ecommerceSetting']['promotions'])): ?> checked <?php endif; ?> > Promotions</label>
             </td>
             
             <td>
                 
             </td>
         </tr>
         <tr>
             <td>Products</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[products][add]" <?php if(isset(json_decode($role->permission, true)['products']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[products][delete]" <?php if(isset(json_decode($role->permission, true)['products']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[products][all]" <?php if(isset(json_decode($role->permission, true)['products']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[products][list]" <?php if(isset(json_decode($role->permission, true)['products']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         <tr>
             <td>Products Other</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][category]" <?php if(isset(json_decode($role->permission, true)['postsOther']['category'])): ?> checked <?php endif; ?> > Category</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[postsOther][tag]" <?php if(isset(json_decode($role->permission, true)['postsOther']['tag'])): ?> checked <?php endif; ?> > Tag</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[postsOther][attribute]" <?php if(isset(json_decode($role->permission, true)['postsOther']['attribute'])): ?> checked <?php endif; ?> > Attribute</label>
             </td>
             <td>
                
             </td>
         </tr>
         <tr>
             <td>Order Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[orders][manage]" <?php if(isset(json_decode($role->permission, true)['orders']['manage'])): ?> checked <?php endif; ?> > Manage</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[orders][delete]" <?php if(isset(json_decode($role->permission, true)['orders']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[orders][list]" <?php if(isset(json_decode($role->permission, true)['orders']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         <tr>
             <td>POS Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[posUrders][manage]" <?php if(isset(json_decode($role->permission, true)['posUrders']['manage'])): ?> checked <?php endif; ?> > Manage</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[posUrders][delete]" <?php if(isset(json_decode($role->permission, true)['posUrders']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[posUrders][all]" <?php if(isset(json_decode($role->permission, true)['posUrders']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
               <label>
                    <input type="checkbox" name="permission[posUrders][list]" <?php if(isset(json_decode($role->permission, true)['posUrders']['list'])): ?> checked <?php endif; ?> > List</label> 
             </td>
         </tr>
         <tr>
             <td>Expenses</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[expenses][add]" <?php if(isset(json_decode($role->permission, true)['expenses']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[expenses][delete]" <?php if(isset(json_decode($role->permission, true)['expenses']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[expenses][type]" <?php if(isset(json_decode($role->permission, true)['expenses']['type'])): ?> checked <?php endif; ?> > Head Of Expenses</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[expenses][list]" <?php if(isset(json_decode($role->permission, true)['expenses']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         
         <tr>
             <td>Report Management</td>
             
             <td>
                <label>
                    <input  type="checkbox" name="permission[reports][summery]" <?php if(isset(json_decode($role->permission, true)['reports']['summery'])): ?> checked <?php endif; ?> > Summery Report</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[reports][products]" <?php if(isset(json_decode($role->permission, true)['reports']['products'])): ?> checked <?php endif; ?> > Products Report</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[reports][customer]" <?php if(isset(json_decode($role->permission, true)['reports']['customer'])): ?> checked <?php endif; ?> > Customer Report</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[reports][orders]" <?php if(isset(json_decode($role->permission, true)['reports']['orders'])): ?> checked <?php endif; ?> > Order Report</label>
             </td>
         </tr>
         <tr>
             <td></td>
             
             <td>
                <label>
                    <input type="checkbox" name="permission[posUrders][salesreport]" <?php if(isset(json_decode($role->permission, true)['posUrders']['salesreport'])): ?> checked <?php endif; ?> > Sales Report</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[expenses][report]" <?php if(isset(json_decode($role->permission, true)['expenses']['report'])): ?> checked <?php endif; ?> > Expenses Report</label>
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
                    <input  type="checkbox" name="permission[suppliers][add]" <?php if(isset(json_decode($role->permission, true)['suppliers']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[suppliers][delete]" <?php if(isset(json_decode($role->permission, true)['suppliers']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[suppliers][all]" <?php if(isset(json_decode($role->permission, true)['suppliers']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[suppliers][list]" <?php if(isset(json_decode($role->permission, true)['suppliers']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         <tr>
             <td>Store/Branch</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[warehouse][add]" <?php if(isset(json_decode($role->permission, true)['warehouse']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[warehouse][delete]" <?php if(isset(json_decode($role->permission, true)['warehouse']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[warehouse][all]" <?php if(isset(json_decode($role->permission, true)['warehouse']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[warehouse][list]" <?php if(isset(json_decode($role->permission, true)['warehouse']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         <tr>
             <td>Stock Management</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[stockManage][add]" <?php if(isset(json_decode($role->permission, true)['stockManage']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[stockManage][delete]" <?php if(isset(json_decode($role->permission, true)['stockManage']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[stockManage][list]" <?php if(isset(json_decode($role->permission, true)['stockManage']['list'])): ?> checked <?php endif; ?> > List</label>
                
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[stockManage][report]" <?php if(isset(json_decode($role->permission, true)['stockManage']['report'])): ?> checked <?php endif; ?> > Report</label>
               
             </td>
         </tr>
         <tr>
             <td>Payment Method</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[paymentMethod][add]" <?php if(isset(json_decode($role->permission, true)['paymentMethod']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[paymentMethod][delete]" <?php if(isset(json_decode($role->permission, true)['paymentMethod']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[paymentMethod][all]" <?php if(isset(json_decode($role->permission, true)['paymentMethod']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[paymentMethod][list]" <?php if(isset(json_decode($role->permission, true)['paymentMethod']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
        
        <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Clients</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[clients][add]" <?php if(isset(json_decode($role->permission, true)['clients']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[clients][delete]" <?php if(isset(json_decode($role->permission, true)['clients']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[clients][all]" <?php if(isset(json_decode($role->permission, true)['clients']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[clients][list]" <?php if(isset(json_decode($role->permission, true)['clients']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>

         <tr>
             <td>Brands</td>
             <td>
                <label>
                    <input  type="checkbox"  name="permission[brands][add]" <?php if(isset(json_decode($role->permission, true)['brands']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[brands][delete]" <?php if(isset(json_decode($role->permission, true)['brands']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[brands][all]" <?php if(isset(json_decode($role->permission, true)['brands']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[brands][list]" <?php if(isset(json_decode($role->permission, true)['brands']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>

          <tr>
             <td>Sliders</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[sliders][add]" <?php if(isset(json_decode($role->permission, true)['sliders']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[sliders][delete]" <?php if(isset(json_decode($role->permission, true)['sliders']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[sliders][all]" <?php if(isset(json_decode($role->permission, true)['sliders']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[sliders][list]" <?php if(isset(json_decode($role->permission, true)['sliders']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>

         <tr>
             <td>Galleries</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[galleries][add]" <?php if(isset(json_decode($role->permission, true)['galleries']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[galleries][delete]" <?php if(isset(json_decode($role->permission, true)['galleries']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[galleries][all]" <?php if(isset(json_decode($role->permission, true)['galleries']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[galleries][list]" <?php if(isset(json_decode($role->permission, true)['galleries']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>

          <tr>
             <td>Menus Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[menus][add]" <?php if(isset(json_decode($role->permission, true)['menus']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[menus][delete]" <?php if(isset(json_decode($role->permission, true)['menus']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[menus][all]" <?php if(isset(json_decode($role->permission, true)['menus']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[menus][list]" <?php if(isset(json_decode($role->permission, true)['menus']['list'])): ?> checked <?php endif; ?> > List</label>
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
                    <input type="checkbox" name="permission[themeSetting][list]" <?php if(isset(json_decode($role->permission, true)['themeSetting']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
          <tr>
             <td colspan="5" style="background: #f1f1f1;"></td>
         </tr>
         <tr>
             <td>Administrator Users</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminUsers][add]" <?php if(isset(json_decode($role->permission, true)['adminUsers']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[adminUsers][delete]" <?php if(isset(json_decode($role->permission, true)['adminUsers']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[adminUsers][list]" <?php if(isset(json_decode($role->permission, true)['adminUsers']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>

         <tr>
             <td>Roles User</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminRoles][add]" <?php if(isset(json_decode($role->permission, true)['adminRoles']['add'])): ?> checked <?php endif; ?> > Add/Update</label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[adminRoles][delete]" <?php if(isset(json_decode($role->permission, true)['adminRoles']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[adminRoles][all]" <?php if(isset(json_decode($role->permission, true)['adminRoles']['all'])): ?> checked <?php endif; ?> > All</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[adminRoles][list]" <?php if(isset(json_decode($role->permission, true)['adminRoles']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
        <tr>
             <td>Customer Users</td>
             <td>
                <label>
                    <input type="checkbox" name="permission[users][add]" <?php if(isset(json_decode($role->permission, true)['users']['add'])): ?> checked <?php endif; ?> > Add</label>
             </td>
             <td>
                <label>
                    <input type="checkbox" name="permission[users][update]" <?php if(isset(json_decode($role->permission, true)['users']['update'])): ?> checked <?php endif; ?> > Update</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[users][delete]" <?php if(isset(json_decode($role->permission, true)['users']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             
             <td>
                 <label>
                    <input type="checkbox" name="permission[users][list]" <?php if(isset(json_decode($role->permission, true)['users']['list'])): ?> checked <?php endif; ?> > List</label>
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
                    <input type="checkbox" name="permission[subscribe][delete]" <?php if(isset(json_decode($role->permission, true)['subscribe']['delete'])): ?> checked <?php endif; ?> > Delete</label>
             </td>
             
             <td>
                 <label>
                    <input type="checkbox" name="permission[subscribe][list]" <?php if(isset(json_decode($role->permission, true)['subscribe']['list'])): ?> checked <?php endif; ?> > List</label>
             </td>
         </tr>
         <tr>
             <td>Apps Setting</td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[appsSetting][general]" <?php if(isset(json_decode($role->permission, true)['appsSetting']['general'])): ?> checked <?php endif; ?> > General Setting </label>
             </td>
             <td>
                 <label>
                    <input  type="checkbox" name="permission[appsSetting][mail]" <?php if(isset(json_decode($role->permission, true)['appsSetting']['mail'])): ?> checked <?php endif; ?> > Mail Setting</label>
             </td>
             <td>
                <label>
                    <input  type="checkbox" name="permission[appsSetting][sms]" <?php if(isset(json_decode($role->permission, true)['appsSetting']['sms'])): ?> checked <?php endif; ?> > SMS Setting</label>
             </td>
             <td>
                 <label>
                    <input type="checkbox" name="permission[appsSetting][social]" <?php if(isset(json_decode($role->permission, true)['appsSetting']['social'])): ?> checked <?php endif; ?> > Social Setting</label>
             </td>
         </tr>
         

     </tbody>
 </table><?php /**PATH /home/posherbd/public_html/resources/views/admin/users/includes/rolesPermission.blade.php ENDPATH**/ ?>