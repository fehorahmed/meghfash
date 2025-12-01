
import BlogGrid from "@/Components/blogs/BlogGrid";
import BlogSideBar from "@/Components/blogs/BlogSideBar";
import { useCart } from "@/Context/CartContext";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import { useEffect, useState } from "react";


export default function TrackYourOrder({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    carts,
}) {

    const {cart, initializeCart} = useCart();
          useEffect(() => {
                initializeCart(carts); // Initialize cart data
            }, [carts]);

    const [orderNumber, setOrderNumber] = useState('');

    const [order, setOrder] = useState(null);
    const [status, setStatus] = useState(0);

    const [responseMessage, setResponseMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);


    const [loading, setLoading] = useState(false);

    // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleOrderSubmit = async (e) => {

        e.preventDefault();
        console.log(orderNumber)
        setLoading(true);
    
        try {
            // Add orderNumber as a query parameter
            const response = await fetch(`/order-tracking?orderNumber=${encodeURIComponent(orderNumber)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            });
    
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
    
            const result = await response.json();
            setResponseMessage(result.message);
            setResponseSuccess(result.success);
            setOrder(result.order);
            setStatus(result.status);
        } catch (error) {
            console.error('Error:', error.message);
        } finally {
            setLoading(false);
        }
    };





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
            >
                <Head title={`Order Tracking - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={`Order Tracking  - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('orderTracking')} />
                    <link rel="canonical" href={route('orderTracking')} />
                </Head>
               



                {status != 1 &&

                <>
                    <div class="login__section section--padding">
                        <div class="container">
                            <div class="login__section--inner">
                                <div class="row ">
                                <div className="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="account__login">
                                            <div class="account__login--header mb-25">
                                                <h2 class="account__login--header__title h3 mb-10">Track Order </h2>
                                            </div>
                                            <div class="account__login--inner">
                                                <form onSubmit={handleOrderSubmit}>
                                                    <input class="account__login--input" placeholder="Inter Your Order Number" type="text"
                                                        value={orderNumber}
                                                        onChange={e => setOrderNumber(e.target.value)}
                                                    />
                                                    <button class="account__login--btn primary__btn" type="submit">
                                                    {loading ? 
                                                        <div class="spinner-border " role="status"></div>
                                                        : 
                                                        'Track Your Order '
                                                    } 
                                                        
                                                    </button>
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                <div className="col-md-3"></div>
                                </div>
                            </div>
                        </div>     
                    </div>
                </>
                }

                {status == 1 ?         
                   <>
                         <div class="checkout__page--area">
                            <div class="container">
                                <div class="checkout__page--inner">
                                    <div class="main checkout__mian" style={{margin: "auto"}}>
                                        {/* <header class="main__header checkout__mian--header mb-30" style={{display: "block"}}>
                                            <h1 class="main__logo--title"><a class="logo logo__left mb-20" href="index.html"><img src={`/${general.logo}`} alt={general.title}  /></a></h1>
                                            
                                        </header> */}
        
                                                <div class="checkout__content--step section__shipping--address pt-0">
                                                    
                                                    <div class="section__header checkout__header--style3 position__relative mb-25">
                                                        <span class="checkout__order--number">Order #{order.invoice}</span>
                                                        <h2 class="section__header--title h3">Thank you submission</h2>
                                                        <div class="checkout__submission--icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25.995" height="25.979" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96"></path></svg>
                                                        </div>
                                                    </div>
                                                    {/* <div class="order__confirmed--area border-radius-5 mb-15">
                                                        <h3 class="order__confirmed--title h4">Your order is confirmed</h3>
                                                        <p class="order__confirmed--desc">You,ll receive a confirmation email with your order number shortly</p>
                                                    </div> */}
                                                    <div class="customer__information--area border-radius-5">

                                                    <h3 class="customer__information--title h4" style={{marginTop: "20px"}}>Customer Information</h3>
                                                        <div class="customer__information--inner d-flex">
                                                            <div class="customer__information--list">
                                                                <div class="customer__information--step">

                                                                    <p style={{    marginBottom: "15px"}}>
                                                                        <b>Name:</b> {order.name} <br/>
                                                                        <b>Mobile: </b> {order.mobile}<br/>
                                                                        {order.email && 
                                                                        <>
                                                                        <b>Email: </b> {order.email}<br/>
                                                                        </>
                                                                        }
                                                                        <b>Address: </b> {order.address}
                                                                    </p>
                                                                    <br/>
                                                                </div>
                                                            
                                                            </div>
                                                            <div class="customer__information--list" style={{display: "flex",  alignItems: "baseline", justifyContent: "end"}}>
        

        
                                                                <div class="customer__information--step">
                                                                    <h4 class="customer__information--subtitle h5">Payment method</h4>
                                                                    <ul>
                                                                        <li><span class="customer__information--text">Cash on Delivery</span></li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    <details class="order__summary--mobile__version" style={{display: "block"}} open>
                                                            <summary class="order__summary--toggle border-radius-5">
                                                                <span class="order__summary--toggle__inner">
                                                                    <span class="order__summary--toggle__icon">
                                                                        <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z" fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="order__summary--toggle__text show">
                                                                        <span>Show order summary</span>
                                                                        <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__dropdown" fill="currentColor"><path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z"></path></svg>
                                                                    </span>
                                                                    <span class="order__summary--final__price">{order.grandTotal}</span>
                                                                </span>
                                                            </summary>
                                                            <div class="order__summary--section">
                                                                <div class="cart__table checkout__product--table">
                                                                    <table class="cart__table--inner">
                                                                        <thead class="cart__table--header">
                                                                            <tr class="cart__table--header__items">
                                                                                <th class="" style={{padding:  "5px 10px" , borderBottom: "1px solid #e4e4e4"}} >Product </th>
                                                                                <th class="" style={{padding:  "5px 10px" , borderBottom: "1px solid #e4e4e4", minWidth: "120px"}}>Price </th>
                                                                                <th class="" style={{padding:  "5px 10px" , borderBottom: "1px solid #e4e4e4"}} >Qty </th>
                                                                                <th class="" style={{padding:  "5px 10px" , borderBottom: "1px solid #e4e4e4", minWidth: "120px", textAlign: "right"}} >Total </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="cart__table--body">
                                                                        {order?.cartItems?.map((cartItem) => (
                                                                            <tr key={cartItem.id} class="cart__table--body__items">
                                                                                <td class="">
                                                                                    <div class="cart__product d-flex align-items-center">
                                                                                        {cartItem.productImage &&
                                                                                        <div class="cart__thumbnail">
                                                                                            <img class="border-radius-5" src={cartItem.productImage} alt="cart-product" />
                                                                                        </div>
                                                                                        }
                                                                                        <div class="cart__content">
                                                                                            <h4 class="cart__content--title">
                                                                                            <span>

                                                                                                {cartItem.productName} 
                                                                                        
                                                                                                </span>
                                                                                        </h4>
                                                                                
                                                                                        {cartItem?.variants?.map((variant) => 
                                                                                                <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                                                        )}
                            
                                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="">
                                                                                    <span class="cart__price">{cartItem.finalPrice} </span>
                                                                                </td>
                                                                                <td class="" style={{textAlign: "center"}}>
                                                                                {cartItem.quantity}
                                                                                </td>
                                                                                <td style={{textAlign: "right"}}>
                                                                                    <span class="cart__price end">{cartItem.subTotal} </span>
                                                                                </td>
                                                                            </tr>
                                                                        ))}
                                                                        
                                                                        </tbody>
                                                                    </table> 
                                                                </div>

                                                                <div class="checkout__total">
                                                                    <table class="checkout__total--table">
                                                                        <tbody class="checkout__total--body">
                                                                            <tr class="checkout__total--items">
                                                                                <td class="checkout__total--title text-left">Subtotal </td>
                                                                                <td class="checkout__total--amount text-right">{order.subTotal}</td>
                                                                            </tr>
                                                                            <tr class="checkout__total--items">
                                                                                <td class="checkout__total--title text-left">Discount</td>
                                                                                <td class="checkout__total--calculated__text text-right">BDT 0</td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot class="checkout__total--footer">
                                                                            <tr class="checkout__total--footer__items">
                                                                                <td class="checkout__total--footer__title checkout__total--footer__list text-left">Total </td>
                                                                                <td class="checkout__total--footer__amount checkout__total--footer__list text-right">{order.grandTotal}</td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </details>
                                                        <br/>
                                                        <p style={{textAlign: "center",}}>Thank you for shopping from {general.title}</p>
                                                    
                                                    </div>
                                                </div>




                                    </div>

                                </div>
                            </div>
                        </div>
                   </> 
                   :
                   status == 2 ? 
                   <div style={{display: "block",
                    marginBottom: "70px",
                    fontSize: "22px",
                    color: "#dd0909",
                    textAlign: "center"
                    }}
                    >
                    Your Order Email Or Invoice Number Are Not Correct No order Match!
                    </div> 

                    : 

                    ""

                }
       

            </MainLayout>
        </>
    );
}
