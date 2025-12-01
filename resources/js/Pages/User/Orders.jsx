import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useState } from 'react'

export default function Orders({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    orders,
    carts,
    auth
}) {
    const [itemsCount, setItemsCount] = useState(carts.cartsCount); // Default selected color
        const [wishListCount, setWishListCount] = useState(carts.wlCount); 
    console.log(carts)

  return (
    <>
    <MainLayout
        auth={auth}
        general={general}
        headerMenu={headerMenu}
        footerMenu4={footerMenu4}
        footerMenu3={footerMenu3}
        footerMenu2={footerMenu2}
        categoryMenu={categoryMenu}
        carts={carts}
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
                            <div class="account__table--area">
                                <table class="account__table">
                                    <thead class="account__table--header">
                                        <tr class="account__table--header__child">
                                            <th class="account__table--header__child--items">Order</th>
                                            <th class="account__table--header__child--items">Date</th>
                                            <th class="account__table--header__child--items">Payment Status</th>
                                            <th class="account__table--header__child--items">Order Status</th>
                                            <th class="account__table--header__child--items">Total</th>	 	 	 	
                                        </tr>
                                    </thead>
                                    <tbody class="account__table--body mobile__none">
                                        {orders.data.length > 0 ?  (
                                            <>
                                            
                                            {orders.data.map((order, index) => (
                                                <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items"><Link href={route('invoiceView',order.invoice)}># {order.invoice}</Link> </td>
                                                <td class="account__table--body__child--items">{order.createdAt}</td>
                                                <td class="account__table--body__child--items">
                                                    {order.paymentStatus == "Paid" &&
                                                        <span style={{background: "#03e503", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }
                                                    {order.paymentStatus == "Unpaid" &&
                                                        <span style={{background: "#dd0909", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }
                                                    {order.paymentStatus == "Partial" &&
                                                        <span style={{background: "blue", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    {order.orderStatus == "Shipped" && 
                                                    <span style={{background: "#08c198", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Cancelled" && 
                                                    <span style={{background: "#df425e", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Delivered" && 
                                                    <span style={{background: "#e9a300", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Confirmed" && 
                                                    <span style={{background: "#00e914", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }
                                                    {order.orderStatus == "Pending" && 
                                                    <span style={{background: "#910808", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }
                                                   

                                                </td>
                                                <td class="account__table--body__child--items">{order.grandTotal}</td>
                                            </tr>
                                             ))}
                                            </>
                                        ) : (
                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items" colspan="5">No order found</td>
                                            </tr>
                                        )}
                                    </tbody>
                                    <tbody class="account__table--body mobile__block">
                                    {orders.data.length > 0 ?  (
                                            <>
                                            
                                            {orders.data.map((order, index) => (
                                                <tr class="account__table--body__child">
                                                    <td class="account__table--body__child--items">
                                                        <strong>Order</strong>
                                                        <span><Link href={route('invoiceView',order.invoice)} >#{order.invoice}</Link> </span>
                                                    </td>
                                                    <td class="account__table--body__child--items">
                                                        <strong>Date</strong>
                                                        <span>{order.createdAt}</span>
                                                    </td>
                                                    <td class="account__table--body__child--items">
                                                        <strong>Payment Status</strong>
                                                        {order.paymentStatus == "Paid" &&
                                                        <span style={{background: "#03e503", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }
                                                    {order.paymentStatus == "Unpaid" &&
                                                        <span style={{background: "#dd0909", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }
                                                    {order.paymentStatus == "Partial" &&
                                                        <span style={{background: "blue", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.paymentStatus}</span>
                                                    }

                                                    </td>
                                                    <td class="account__table--body__child--items">
                                                        <strong>Order Status</strong>
                                                        {order.orderStatus == "Shipped" && 
                                                    <span style={{background: "#08c198", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Cancelled" && 
                                                    <span style={{background: "#df425e", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Delivered" && 
                                                    <span style={{background: "#e9a300", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }

                                                    {order.orderStatus == "Confirmed" && 
                                                    <span style={{background: "#00e914", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }
                                                    {order.orderStatus == "Pending" && 
                                                    <span style={{background: "#910808", color: "#fff", padding: "3px 10px", borderRadius: "5px"}}>{order.orderStatus}</span>
                                                    }
                                                   
                                                    </td>
                                                    <td class="account__table--body__child--items">
                                                        <strong>Total</strong>
                                                        <span>{order.grandTotal}</span>
                                                    </td>
                                                </tr>
                                             ))}
                                            </>
                                        ) : (
                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items">No order found</td>
                                            </tr>
                                        )}
                                        
                                        
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
