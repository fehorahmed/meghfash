import ProductGrid from '@/Components/products/ProductGrid';
import { useCart } from '@/Context/CartContext';
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useEffect, useState,useRef } from 'react'
import { CiHeart } from 'react-icons/ci';
import { IoCartOutline, IoCloseOutline, IoEyeOutline } from "react-icons/io5";
import Slider from "react-slick";

export default function Cart({ 
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    carts,
    latestProducts
    }) {

         const {cart, initializeCart, removeFromCart} = useCart();

        const [itemsCount, setItemsCount] = useState(carts.cartsCount); 
        const [wishListCount, setWishListCount] = useState(carts.wlCount); 

        const [cupon, setCupon] = useState(''); 
        const [cuponLoading, setCuponLoading] = useState(false); 

        const [responseMessage, setResponseMessage] = useState('');
        const [responseSuccess, setResponseSuccess] = useState(false);


         useEffect(() => {
             initializeCart(carts); // Initialize cart data
        }, [carts]);


    
        useEffect(() => {
            initializeCart(carts); // Initialize cart data
        }, [setCupon]);
        



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

        const handleCartRemove = (id, type) =>{
            removeFromCart(id, type)
        }


        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const handleCuponSubmit = async (e) => {
            e.preventDefault();

            setCuponLoading(true);

        try {
            const response = await fetch('/my-coupon-apply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    coupon_code: cupon,
                }),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            setResponseMessage(result.message);
            setResponseSuccess(result.success);
            if(result.carts){
                initializeCart(result.carts);
            }

            console.log('Server response:', result);

        } catch (error) {
            console.error('Error:', error.message);
        }finally{
            setCuponLoading(false);
        }
    
        }

        // const submit = (e) => {
        //     e.preventDefault();
        //     console.log('submit')
        // }

        const firstRender = useRef(true);

         useEffect(() => {

            if (firstRender.current) {
                firstRender.current = false; // ✅ Skip the first duplicate call0000000
                return;
            }

            if (!cart) return; // ✅ Prevent running if cart is null/undefined

            const variant = (item) =>{
                if (item.variants && item.variants.length > 0) {
                    return item.variants.map(v => `${v.title}:${v.value}`).join(',');
                }
                return null;
        
            }
        
            const items = cart?.cartItems?.map((item) => ({
                item_id: item.productId, // SKU or Product ID
                item_name: item.productName, // Product name
                index: item.index || 0, // Optional index in the list
                item_category: null,
                item_variant: variant(item), // Variant like color, size, etc.
                price: parseInt(item.subTotal.match(/\d+[\d,.]*/)[0].replace(/,/g, '')), // Price of the item
                quantity: item.quantity, // Quantity being purchased
            }));
        
        
            window.dataLayer = window.dataLayer || [];

            window.dataLayer.push({
                event: "view_cart",
                currency: general.currency,
                value: cart.grandTotal,
                coupon: cart?.myCoupon?.name,
                items: items,
            });

            console.log("cart data layer call");

            }, [cart]);
        


        // console.log(cupon);
        // console.log(cart);



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
                wishListCount={wishListCount}
                footerMenu2={footerMenu2}
            >
                <Head title={`My Cart - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={`My Cart - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('carts')} />
                    <link rel="canonical" href={route('carts')} />
                </Head>


                <section class="cart__section section--padding">
                    <div class="container-fluid">
                 <div class="cart__section--inner">
                     <div action="#"> 
                         <h2 class="cart__title mb-40">Shopping Cart </h2>
                         {cart?.cartItems?.length > 0 ?
                         <div class="row">
                             <div class="col-lg-8">
                                 <div class="cart__table">
                                     <table class="cart__table--inner">
                                         <thead class="cart__table--header">
                                             <tr class="cart__table--header__items">
                                                 <th class="cart__table--header__list">Product </th>
                                                 <th class="cart__table--header__list">Price </th>
                                                 <th class="cart__table--header__list">Quantity </th>
                                                 <th class="cart__table--header__list">Total </th>
                                             </tr>
                                         </thead>
                                         <tbody class="cart__table--body">
                                            {cart?.cartItems?.map((cartItem) => (
                                                <tr key={cartItem.id} class="cart__table--body__items">
                                                 <td class="cart__table--body__list">
                                                     <div class="cart__product d-flex align-items-center">
                                                         <button onClick={()=>handleCartRemove(cartItem.id, 'delete')} class="cart__remove--btn" aria-label="search button" type="button">
                                                         <IoCloseOutline />
                                                         </button>
                                                         <div class="cart__thumbnail">
                                                             <img class="border-radius-5" src={cartItem.productImage} alt="cart-product" />
                                                         </div>
                                                         <div class="cart__content">
                                                             <h4 class="cart__content--title">
                                                               
                                                                    {cartItem.productName.length > 25
                                                                    ? `${cartItem.productName.slice(0, 25)}...`
                                                                    : cartItem.productName} 
                                                              
                                                            </h4>
                                                            {cartItem?.variants?.map((variant) => 
                                                                 <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                            )}

                                                           
                                                         </div>
                                                     </div>
                                                 </td>
                                                 <td class="cart__table--body__list">
                                                     <span class="cart__price">{cartItem.finalPrice} </span>
                                                 </td>
                                                 <td class="cart__table--body__list">
                                                     <div class="quantity__box">
                                                         <button onClick={()=>handleCartRemove(cartItem.id, 'decrement')} type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">- </button>
                                                         <label>
                                                             <input type="number" class="quantity__number quickview__value--number" value={cartItem.quantity}  />
                                                         </label>
                                                         <button onClick={()=>handleCartRemove(cartItem.id, 'increment')} type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+ </button>
                                                     </div>
                                                 </td>
                                                 <td class="cart__table--body__list">
                                                     <span class="cart__price end">{cartItem.subTotal} </span>
                                                 </td>
                                             </tr>
                                            ))}
                                         </tbody>
                                     </table> 
                                 </div>
                             </div>
                             <div class="col-lg-4">
                                 <div class="cart__summary border-radius-10">
                                     <div class="coupon__code mb-30">
                                         <h3 class="coupon__code--title">Coupon </h3>
                                         <p class="coupon__code--desc">Enter your coupon code if you have one. </p>
                                         {responseSuccess == true && 
                                                <p style={{color: "green"}}>{responseMessage}</p>
                                            }
                                         {responseSuccess == false && 
                                                <p style={{color: "red", fontSize: "13px"}}>{responseMessage}</p>
                                            }
                                         <div class="coupon__code--field d-flex">
                                           
                                            <form className="d-flex" onSubmit={handleCuponSubmit}>
                                                <label>
                                                   <input class="coupon__code--field__input border-radius-5" value={cupon} placeholder="Coupon code" type="text" 
                                                        onChange={(e)=>setCupon(e.target.value)}
                                                   />
                                                </label>
                                                  <button class="coupon__code--field__btn primary__btn" type="submit" >
                                                  {cuponLoading ? 
                                                    <div class="spinner-border " role="status"></div>
                                                    : 
                                                    ' Apply Coupon '
                                                    } 
                                                   
                                                  </button>
                                             </form>
                                         </div>
                                     </div>

                                     <div class="cart__summary--total mb-20">
                                         <table class="cart__summary--total__table">
                                             <tbody>
                                                 <tr class="cart__summary--total__list">
                                                     <td class="cart__summary--total__title text-left">SUBTOTAL </td>
                                                     <td class="cart__summary--amount text-right"> {cart?.cartTotalPriceFormat} </td>
                                                 </tr>
                                                 <tr class="cart__summary--total__list">
                                                     <td class="cart__summary--total__title text-left">DISCOUNT </td>
                                                     <td class="cart__summary--amount text-right"> {cart?.couponDiscFormat}</td>
                                                 </tr>
                                                 <tr class="cart__summary--total__list">
                                                     <td class="cart__summary--total__title text-left">GRAND TOTAL </td>
                                                     <td class="cart__summary--amount text-right">{cart?.grandTotalFormat} </td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                     <div class="cart__summary--footer">
                                         {/* <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout </p> */}
                                         <ul class="d-flex justify-content-between">

                                             <li><Link class="cart__summary--footer__btn primary__btn checkout" href={route('checkout')}>Check Out </Link></li>
                                         </ul>
                                     </div>
                                 </div> 
                             </div>
                         </div> 
                         :
                         <div style={{textAlign: "center",
                            fontSize: "40px",
                            fontWeight: "bold",
                            color: "gray",
                            margin: "100px 0"}}>
                              Cart is empty
                        </div>
                         }
                     </div> 
                 </div>
                    </div>     
                </section>


                <section class="product__section section--padding pt-0 cart">
                    <div class="container-fluid">
                        <div class="section__heading text-center mb-50">
                            <h2 class="section__heading--maintitle">New Products </h2>
                        </div>

                        {latestProducts.length > 0 &&
                            <div className="slider-container ">
                                <Slider {...settings}>
                                    {latestProducts.map((product, index) => (
                                        <ProductGrid product={product} />
                                    ))}
                                </Slider>
                            </div>
                        }
                    </div>
                </section>





            </MainLayout>
    </>
  )
}
