import { useCart } from '@/Context/CartContext';
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { CiHeart } from 'react-icons/ci';
import { IoCartOutline, IoCloseOutline, IoEyeOutline } from "react-icons/io5";
import Slider from "react-slick";

export default function WishList({ 
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    products,
    carts,

}) {

    const {initializeWishList, wishList, removeFromWishList} = useCart();

    useEffect(() => {
        initializeWishList(products); // Initialize cart data
      }, [products]);


          const [itemsCount, setItemsCount] = useState(carts.cartsCount); 
          const [wishListCount, setWishListCount] = useState(carts.wlCount); 

        var settings = {
            dots: false,
            infinite: true,
            autoplay: true,
            speed: 1000,
            slidesToShow: 4,
            slidesToScroll: 4,
            initialSlide: 0,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                  infinite: true,
                  dots: true
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                  initialSlide: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          };


          const handleWishListRemove = (id) =>{
                console.log("remove wishlist button click");
                removeFromWishList(id);
          }

console.log(products)

  return (
    <>
         <MainLayout
            auth={auth}
                general={general}
                headerMenu={headerMenu}
                footerMenu4={footerMenu4}
                footerMenu3={footerMenu3}
                categoryMenu={categoryMenu}
                itemsCount={itemsCount}
                carts={carts}
                footerMenu2={footerMenu2}
                wishListCount={wishListCount}
            >
                <Head title={`My Wishlist - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={`My Wishlist - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('myWishlist')} />
                    <link rel="canonical" href={route('myWishlist')} />
                </Head>

                

                <section class="cart__section section--padding">
                    <div class="container-fluid">
                        <div class="cart__section--inner">
                            <form action="#"> 
                                <h2 class="cart__title mb-40">Wishlist </h2>
                                {wishList.length  > 0 ?
                                    <>
                                        <div class="cart__table">
                                    <table class="cart__table--inner">
                                        <thead class="cart__table--header">
                                            <tr class="cart__table--header__items">
                                                <th class="cart__table--header__list">Product </th>
                                                <th class="cart__table--header__list">Price </th>
                                                <th class="cart__table--header__list text-center">STOCK STATUS </th>
                                                <th class="cart__table--header__list text-right">ADD TO CART </th>
                                            </tr>
                                        </thead>
                                        <tbody class="cart__table--body">
                                    {wishList.map((product) =>(
                                        <tr class="cart__table--body__items">
                                        <td class="cart__table--body__list">
                                            <div class="cart__product d-flex align-items-center">
                                                {/* <Link href={route('wishlistCompareUpdate',[product.id,'wishlist'])} class="cart__remove--btn" aria-label="search button" type="button">
                                                    <IoCloseOutline />
                                                </Link> */}
                                                <button onClick={()=>handleWishListRemove(product.id)} class="cart__remove--btn" aria-label="search button" type="button">
                                                    <IoCloseOutline />
                                                </button>
                                                <div class="cart__thumbnail">
                                                    <Link href={route('productView', product.slug?product.slug:'no-title')}><img class="border-radius-5" src={product.image_url} alt={product.name} /></Link>
                                                </div>
                                                <div class="cart__content">
                                                    <h4 class="cart__content--title"><Link href={route('productView', product.slug?product.slug:'no-title')}>{product.name}</Link></h4>
                                                
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <span class="cart__price">{product.finalPrice} </span>
                                        </td>
                                        <td class="cart__table--body__list text-center">
                                            <span class="in__stock text__secondary">{product.stock ? <span style={{color: "green"}}>in stock</span> :<span>stock out</span> } </span>
                                        </td>
                                        <td class="cart__table--body__list text-right">
                                            <Link class="wishlist__cart--btn primary__btn" href={route('productView', product.slug?product.slug:'no-title')}>Add To Cart </Link>
                                        </td>
                                        </tr>
                                    ))}
                                            
                                            
                                        </tbody>
                                    </table> 
                                        </div> 
                                    </>
                                    :
                                    <div style={{textAlign: "center",
                                        fontSize: "40px",
                                        fontWeight: "bold",
                                        color: "gray",
                                        margin: "100px 0"}}>
                                            Wish list not found</div>
                                }
                            </form> 
                        </div>
                    </div>     
                </section>

            </MainLayout>
    </>
  )
}
