import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useState } from 'react'

export default function Dashboard({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    orders,
    carts,
    auth,
    user,
}) {
    const [itemsCount, setItemsCount] = useState(carts.cartsCount); // Default selected color
        const [wishListCount, setWishListCount] = useState(carts.wlCount); 


    console.log(user)

  return (
    <>
    <MainLayout
        auth={auth}
        general={general}
        headerMenu={headerMenu}
        footerMenu4={footerMenu4}
        footerMenu3={footerMenu3}
        categoryMenu={categoryMenu}
        carts={carts}
        footerMenu2={footerMenu2}
    >
        <Head title={`Dashboard - ${general.web_title}`}>
            <meta name="title" property="og:title" content={`Dashboard - ${general.web_title}`} />
            <meta name="description" property="og:description" content={general.meta_description} />
            <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
            <meta name="image" property="og:image" content={general.logo_url} />
            <meta name="url" property="og:url" content={route('customer.dashboard')} />
            <link rel="canonical" href={route('customer.dashboard')} />
        </Head>
        
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {auth.user.name} welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <SideBar auth={auth} />
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Orders History</h2>
                          <div className="dahsboardHistryMain">
                          <div className="coustomerDashBoardHead">
                                <div className="ProfileInfo">
                                    <img src={user.image_url} alt="" />
                                    {/* <img src="/images/male.jpg" alt="" /> */}
                                    <h5>{user.name}</h5>
                                </div>
                                <div>
                                   <Link href={route('customer.profile')} > <button className="btn btn-outline-primary">Edit Profile</button></Link><br/>
                                   <Link href={route('customer.changePassword')} ><button className="btn btn-outline-danger">Change Password</button></Link> 
                                </div>
                           </div>
                           <div className="orderInfoMain">
                                <ul>
                                    <li>
                                        <span>{user.allOrder}</span>
                                        <Link href={route('customer.myOrders')} style={{backgroundColor: "#65cfc9",color: "#fff", padding: "0 5px",     borderRadius: "5px"}}>All Order</Link>
                                    </li>
                                    <li>
                                        <span>{user.pendingOrder}</span>
                                        <Link href="#" style={{backgroundColor: "#a654c8",color: "#fff", padding: "0 5px", borderRadius: "5px" }}>Pending </Link>
                                    </li>
                                    <li>
                                        <span>{user.contrimedOrder}</span>
                                        <Link href="#" style={{backgroundColor: "#c5790d",color: "#fff", padding: "0 5px", borderRadius: "5px"}}>Confirm </Link>
                                    </li>
                                    <li>
                                        <span>{user.shippedOrder}</span>
                                        <Link href="#" style={{backgroundColor: "#142ab5",color: "#fff", padding: "0 5px", borderRadius: "5px"}}>Shipped </Link>
                                    </li>
                                    <li>
                                        <span>{user.completedOrder}</span>
                                        <Link href="#" style={{backgroundColor: "#65cf65",color: "#fff", padding: "0 5px", borderRadius: "5px"}}>Completed </Link>
    
                                    </li>
                                </ul>
                           </div>
                          </div>
                          <div className="shipingAddrss">
                          <table class="table table-bordered shippingTable">
                            <tbody>
                            <tr>
                                <td style={{width: "150px", minWidth: "150px"}}>Address</td>
                                <td>{user.address_line1}</td>
                            </tr>
                            
                            <tr>
                                <td>City</td>
                                <td> {user.cityName}</td>
                            </tr>
                            <tr>
                                <td>District </td>
                                <td>{user.dristicName}</td>
                            </tr>
                        </tbody>

                        </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </MainLayout>
    
    </>
  )
}
