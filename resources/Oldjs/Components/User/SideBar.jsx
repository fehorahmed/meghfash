import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/react';
import React from 'react'

export default function SideBar({auth}) {

    const handleLogout = (e) => {
        e.preventDefault();
        Inertia.post(route('logout')); 
  };

  const pathname = window.location.pathname;

  // Check if the current path matches any of the target routes
  const isDashboardActive = pathname.startsWith('/customer/dashboard');
  const isProfileActive = pathname.startsWith('/customer/profile');
  const isOrderActive = pathname.startsWith('/customer/orders');
  const isReviewActive = pathname.startsWith('/customer/my-reviews');
  const isChangePasswordActive = pathname.startsWith('/customer/change-password');

  return (
    <div class="account__left--sidebar">
        <h2 class="account__content--title h3 mb-20">
          
        <div>My Profile</div>

        <div className="dLogout"><Link href="#" onClick={handleLogout}>Log Out</Link></div>

        </h2>
                  <div className="mainMenu dMenu">
                        <div className="">
                         
                          <ul>
                         
                        {auth?.user?.admin ? 
                          (

                            <li ><a href={route('admin.dashboard')}>Admin Dashboard</a></li>
                          )
                        :
                        (
                          null
                        )
                        }

                          <li class={`dMenuI ${isDashboardActive ? 'active' : ''}`} ><Link href={route('customer.dashboard')}>Dashboard</Link></li>
                          <li class={`dMenuI ${isOrderActive ? 'active' : ''}`}><Link href={route('customer.myOrders')}>My Order</Link></li>
                          <li class={`dMenuI ${isReviewActive ? 'active' : ''}`}><Link href={route('customer.myReviews')}>My Review</Link></li>
                          <li class={`dMenuI ${isProfileActive ? 'active' : ''}`}><Link href={route('customer.profile')}>My Profile</Link></li>
                          <li class={`dMenuI ${isChangePasswordActive ? 'active' : ''}`}><Link href={route('customer.changePassword')}>Change Password</Link></li>
                          <li class="dMenuI "><Link href={route('myWishlist')}>Wishlist</Link></li>
                         
                               
                          </ul>
                        </div>
                    </div>
                <ul class="account__menu"> 
                  {auth?.user?.admin ? 
                    (

                      <li class="account__menu--list"><a href={route('admin.dashboard')}>Admin Dashboard</a></li>
                    )
                  :
                  (
                    null
                  )
                  }

                    <li class={`account__menu--list ${isDashboardActive ? 'active' : ''}`} ><Link href={route('customer.dashboard')}>Dashboard</Link></li>
                    <li class={`account__menu--list ${isOrderActive ? 'active' : ''}`}><Link href={route('customer.myOrders')}>My Order</Link></li>
                    <li class={`account__menu--list ${isReviewActive ? 'active' : ''}`}><Link href={route('customer.myReviews')}>My Review</Link></li>
                    <li class={`account__menu--list ${isProfileActive ? 'active' : ''}`}><Link href={route('customer.profile')}>My Profile</Link></li>
                    <li class={`account__menu--list ${isChangePasswordActive ? 'active' : ''}`}><Link href={route('customer.changePassword')}>Change Password</Link></li>
                    <li class="account__menu--list"><Link href={route('myWishlist')}>Wishlist</Link></li>
                    <li class="account__menu--list"><Link href="#" onClick={handleLogout}>Log Out</Link></li>


                </ul>
    </div>
  )
}
