import RatingStar from '@/Components/products/RatingStar';
import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useState } from 'react'
import { FaEdit } from 'react-icons/fa';

export default function Reviews({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    reviews,
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
        categoryMenu={categoryMenu}
        footerMenu2={footerMenu2}
        carts={carts}
    >
        <Head title={`My Reviews - ${general.web_title}`}>
            <meta name="title" property="og:title" content={`My Reviews - ${general.web_title}`} />
            <meta name="description" property="og:description" content={general.meta_description} />
            <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
            <meta name="image" property="og:image" content={general.logo_url} />
            <meta name="url" property="og:url" content={route('customer.myReviews')} />
            <link rel="canonical" href={route('customer.myReviews')} />
        </Head>
    
        
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {auth.user.name} welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <SideBar auth={auth} />
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Review History</h2>
                            <div class="account__table--area">
                                <table class="account__table">
                                    <thead class="account__table--header">
                                        <tr class="account__table--header__child">
                                            <th class="account__table--header__child--items" style={{width: "50%",maxWidth: "50%"}}>Purchase On </th>
                                            <th class="account__table--header__child--items" style={{textAlign: "left"}}>My Review</th>	 	 	 	
                                        </tr>
                                    </thead>
                                    <tbody class="account__table--body mobile__none">
                                        {reviews.data.length > 0 ?  (
                                            <>
                                            
                                            {reviews.data.map((review) => (
                                                <tr class="account__table--body__child">
                                                    <td class="account__table--body__child--items">
                                                        <div style={{display: "flex"}}>
                                                            <img src={review.image_url} style={{maxWidth: "100px", maxHeight: "80px",marginRight: "5px"}} />
                                                            <div>
                                                                <p>
                                                                {review.link_url ? (
                                                                    <Link href={review.link_url} target="_blank" >{review.product_name}</Link>
                                                                ):(
                                                                    <span>{review.product_name}</span>
                                                                )}
                                                                
                                                                <br />
                                                                {review?.variants?.map((variant) => 
                                                                    <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                                )}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="account__table--body__child--items" style={{textAlign: "center"}}>
                                                        
                                                        {review.review_content ? (
                                                            <>
                                                            <RatingStar rating={review.review_rating} />
                                                            <p>
                                                            {review.review_content}
                                                            </p>
                                                            <Link className="reviewEditBtn" href={route('customer.orderReview',review.id)}>
                                                                <FaEdit style={{marginRight: "5px",marginTop: "-4px"}} />
                                                                Edit Review
                                                            </Link>
                                                            </>
                                                        ):(
                                                            <>
                                                            <Link className="reviewEditBtn" style={{background: "#f69421"}} href={route('customer.orderReview',review.id)}>
                                                                Write Review
                                                            </Link>
                                                            </>
                                                        )}
                                                    </td>
                                                </tr>
                                             ))}
                                            </>
                                        ) : (
                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items" colspan="2">No order found</td>
                                            </tr>
                                        )}
                                    </tbody>
                                    <tbody class="account__table--body mobile__block">
                                    {reviews.data.length > 0 ?  (
                                            <>
                                            
                                            {reviews.data.map((review) => (
                                                <tr class="account__table--body__child">
                                                    <td class="account__table--body__child--items">
                                                        <div style={{width: "100%"}}>
                                                            <strong>Products</strong><br />
                                                            <div style={{display: "flex"}}>
                                                                <img src={review.image_url} style={{maxWidth: "100px", maxHeight: "80px",marginRight: "5px"}} />
                                                                <div>
                                                                    <p>
                                                                    {review.product_name}
                                                                    <br />
                                                                    {review?.variants?.map((variant) => 
                                                                        <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                                    )}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="account__table--body__child--items">
                                                        <div style={{width: "100%",textAlign: "left"}}>
                                                        <strong>My Review</strong>
                                                        <p>
                                                            sdlfkj<br />
                                                            sdlfkj<br />
                                                            sdlfkj<br />
                                                        </p>
                                                        </div>
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
