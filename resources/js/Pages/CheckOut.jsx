import { useCart } from '@/Context/CartContext';
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link, useForm } from '@inertiajs/react'


import React, { useState } from 'react'
import { useEffect, useRef } from 'react';

export default function CheckOut({ 
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    carts,
    district
    }) {

      
  const {cart, initializeCart} = useCart();

  const [thanas, setThanas] = useState([]);       // List of thanas
  const [shipping, setShipping] = useState("");   
  const [selectedDistrict, setSelectedDistrict] = useState(auth?.user?.district || null); // Selected district
  const [selectedCity, setSelecteCity] = useState(auth?.user?.city || null); // Selected city
  const [selectedMethod, setSelectedMethod] = useState('Cash on delivery');
  const [orderLoading, setOrderLoading] = useState(false);


  const [responseMessage, setResponseMessage] = useState('');
  const [responseSuccess, setResponseSuccess] = useState(false);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [mobile, setMobile] = useState('');
  const [address, setAddress] = useState('');


  const [nameError, setNameError] = useState('');
  const [emailError, setEmailError] = useState('');
  const [phoneError, setPhoneError] = useState('');
  const [addressError, setAdressError] = useState('');
  const [districtError, setDistrictError] = useState('');
  const [cityError, setCityError] = useState('');



  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const { data, setData, post, processing, errors } = useForm({
          name: auth.user?.name || '',
          mobile: auth.user?.mobile || '',
          email: auth.user?.email || '',
          address: auth.user?.address_line1 || '',
          district: auth?.user?.district || null,
          city: auth?.user?.city || null,
          payment_option: "",
          
        });


        // Sync selectedDistrict with useForm
        useEffect(() => {
            setData("district", selectedDistrict);
        }, [selectedDistrict, setData]);

        // Sync selectedCity with useForm
        useEffect(() => {
            setData("city", selectedCity);
        }, [selectedCity, setData]);

        const validateMobile = (number) => {
            const regex = /^[0-9]{11}$/;
            if (!regex.test(number)) {
              setPhoneError("Mobile number must be exactly 11 digits.");
              setResponseSuccess(false);
            } else {
              setPhoneError("");
              setResponseSuccess(true);
            }
          };
  

      
        const submit = async (e) => {

          e.preventDefault();

          const obj = {
                name: name,
                mobile: mobile,
                email: email,
                address: address,
                district: selectedDistrict,
                city: selectedCity,
                payment_option: selectedMethod,
            };

            console.log(obj)

        try {
            setOrderLoading(true);
            const response = await fetch("/checkout", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(obj),
            });
    
            const result = await response.json();

            if (!response.ok) {
                // If the response contains validation errors
                if (result.errors) {
                    // Flatten the errors and display them as a list
                    setNameError(result.errors.name)
                    setEmailError(result.errors.email)
                    setPhoneError(result.errors.mobile)
                    setAdressError(result.errors.address)
                    setDistrictError(result.errors.district)
                    setCityError(result.errors.city)
                    setResponseMessage(Object.values(result.errors).flat().join(", "));
                    setResponseSuccess(result.success);
                } else {
                    setResponseMessage(result.message);
                    setResponseSuccess(result.success);
                }
            } else {
                setResponseMessage(result.message);
                setResponseSuccess(result.success);
            }


            if (result.data) {
                window.location.href = result.data; // Redirect user to SSLCommerz
            } else {
                console.error("Payment initialization failed", result);
            }


            setOrderLoading(false);

        } catch (error) {
            console.error("Error:", error);
        }

          console.log('ovder submited');
      
        //   post(route('checkout'), {
        //       onSuccess: (response) => {
        //           // Handle successful login response here
        //           console.log("Logged in successfully!");
        //           console.log("Response from server:", response);

        //           if (response.props.data?.status === "success") {
        //                 const paymentUrl = response.props.data.data;
        //                 window.location.href = paymentUrl; // Redirect to SSLCommerz
        //             } else {
        //                 console.error("Payment initiation failed");
        //             }

        //       },
        //       onError: (errors) => {
        //           // Handle error responses here
        //           console.log(errors);
        //       },
        //       onFinish: () => {
        //           // Optionally, you can reset form data here
        //           // reset();
        //       }
        //   });
        
    };


    useEffect(() => {
        initializeCart(carts); // Initialize cart data
    }, [carts]);




     // Fetch thanas when selectedDistrict changes
  useEffect(() => {
    const fetchThanas = async () => {
      if (!selectedDistrict) return; // Don't fetch if no district is selected

      try {
        const response = await fetch(`/checkout?district_id=${selectedDistrict}`); // Replace with your API endpoint
        if (!response.ok) {
          throw new Error(`Failed to fetch thanas: ${response.statusText}`);
        }
        const data = await response.json();
        setThanas(data.datas);
        if(data.carts){
            initializeCart(data.carts);
        }

      } catch (error) {
        console.error("Error fetching thanas:", error);
      }

    };

    fetchThanas();

  }, [selectedDistrict]); // Dependency on selectedDistrict



  const handleDistrictChange = (event) => {
    setSelectedDistrict(event.target.value); // Update selectedDistrict 
  };

  const handleCityChange = (event) => {
    setSelecteCity(event.target.value); // Update selectedDistrict
  };

  const handlePaymentChange = (event) => {
    setSelectedMethod(event.target.value);
  };

  useEffect(() => {
    setData("payment_option", selectedMethod);
}, [selectedMethod, setData]);



  const styles = {
    container: {
      fontFamily: 'Arial, sans-serif',
      margin: '0 auto',
    },
    radioGroup: {
      display: 'flex',
      alignItems: 'center',
      flexWrap: 'wrap',
    },
    radioLabel: {
      display: 'flex',
      alignItems: 'center',
      flexWrap: 'wrap',
      marginBottom: '10px',
      fontSize: '16px',
      backgroundColor: '#dfd6d657',
      padding: '10px 20px',
      borderRadius: '5px',
      marginRight: '20px',
      cursor: 'pointer',
    },
    radioInput: {
      marginRight: '10px',
      width: '24px',
      height: '24px',
      display: 'block',
    },
    selectedMethod: {
      marginTop: '10px',
      fontSize: '14px',
      color: '#555',
    },
    button: {
      padding: '10px 20px',
      backgroundColor: '#4CAF50',
      color: '#fff',
      border: 'none',
      borderRadius: '4px',
      cursor: 'pointer',
      width: '100%',
      fontSize: '16px',
    },
  };



  useEffect(() => {

        const variant = (item) =>{
            if (item.variants && item.variants.length > 0) {
                return item.variants.map(v => `${v.title}:${v.value}`).join(',');
            }
            return null;
        }

        const items = cart?.cartItems?.map((item) => ({
            item_id: item.productId,
            item_name: item.productName,
            index: item.index || 0,
            item_category: null,
            item_variant: variant(item),
            price: parseInt(item.subTotal.match(/\d+[\d,.]*/)[0].replace(/,/g, '')),
            quantity: item.quantity,
        }));

        window.dataLayer = window.dataLayer || [];

        window.dataLayer.push({
            event: "begin_checkout",
            currency: general.currency,
            value: cart.cartTotalPrice,
            coupon: cart?.myCoupon?.name,
            items: items,
        });

        console.log("checkout  data layer call");

        if (typeof fbq === 'function') {
            const contentIds = items?.map(item => item.item_id) || [];
            fbq('track', 'InitiateCheckout', {
                content_ids: contentIds,
                content_type: 'product',
                value: cart.grandTotal,
                currency: general.currency,
            });
        }
    
    }, []); 
 

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
                <Head title={`Checkout - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={`Checkout - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('checkout')} />
                    <link rel="canonical" href={route('checkout')} />
                </Head>


   
                <div class="checkout__page--area">
                    <div class="container">
                        <form onSubmit={submit}>
                        <div class="checkout__page--inner d-flex">
                            <div class="main checkout__mian">
                                
                                
                                <main class="main__content_wrappe">
                                
                                        <div class="checkout__content--step section__contact--information">
                                            <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                                <h2 class="section__header--title h3">Contact information </h2>

                                            </div>

                                            <div class="row">
                                                    <div class="col-lg-12 mb-12">
                                                        <div class="checkout__input--list ">
                                                            <label>Your Name *</label>
                                                            <input class="checkout__input--field border-radius-5" placeholder=" Name " type="text" 
                                                                onChange={(e) => setName(e.target.value)}
                                                            />
                                                            {responseSuccess == true ?
                                                                ''
                                                                :
                                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {nameError && <span >{nameError}</span>}  </p>
                                                            }
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-12">
                                                        <div class="checkout__input--list">
                                                            <label>Your Mobile *</label>
                                                            <input
                                                                className="checkout__input--field border-radius-5"
                                                                placeholder="Mobile"
                                                                type="number"
                                                                value={mobile}
                                                                onChange={(e) => {
                                                                    const value = e.target.value;
                                                                    setMobile(value);
                                                                    validateMobile(value);
                                                                }}
                                                                />
                                                              {responseSuccess == true ?
                                                                    ''
                                                                    :

                                                                    <p className="errrowMsg" style={{fontSize: "14px"}}> {phoneError && <span >{phoneError}</span>} </p>
                                                                }
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-12">
                                                        <div class="checkout__input--list">
                                                            <label>Your Email </label>
                                                            <input class="checkout__input--field border-radius-5" placeholder="Email (optional)" type="email" 
                                                            onChange={(e) => setEmail(e.target.value)} 
                                                            />
                                                            {responseSuccess == true ?
                                                                    ''
                                                                    :

                                                                    <p className="errrowMsg" style={{fontSize: "14px"}}> {emailError && <span >{emailError}</span>} </p>
                                                                }
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-12">
                                                        <div class="checkout__input--list checkout__input--select select">
                                                        
                                                            <select class="form-select checkout__input--select__field border-radius-5"
                                                            value={selectedDistrict}
                                                            onChange={handleDistrictChange}
                                                            >
                                                                <option value="">Select District</option>
                                                                {district.map((d)=>(
                                                                    <option key={d.id} value={d.id}>{d.name}</option>
                                                                ))}
                                                            </select>
                                                        </div>
                                                        {responseSuccess == true ?
                                                            ''
                                                            :

                                                            <p className="errrowMsg" style={{fontSize: "14px"}}> {districtError && <span >{districtError}</span>} </p>
                                                        }
                                                    </div>
                                                    <div class="col-lg-6 mb-12">
                                                        <div class="checkout__input--list checkout__input--select select">
                                                        
                                                            <select class="form-select checkout__input--select__field border-radius-5"   disabled={!thanas.length} aria-label="Default select example"
                                                            value={selectedCity}
                                                            onChange={handleCityChange}
                                                            >
                                                            <option value="">Select Thana</option>
                                                                {thanas.map((thana) => (
                                                                <option key={thana.id} value={thana.id}>
                                                                    {thana.name}
                                                                </option>
                                                                ))}
                                                            </select>
                                                        </div>
                                                        {responseSuccess == true ?
                                                            ''
                                                            :

                                                            <p className="errrowMsg" style={{fontSize: "14px"}}> {cityError && <span >{cityError}</span>} </p>
                                                        }
                                                    </div>
                                                    <div class="col-12 mb-12">
                                                        <div class="checkout__input--list">
                                                            <label>Address * </label>
                                                            <textarea class="checkout__input--field border-radius-5" 
                                                            rows="6" style={{height: "unset"}} placeholder="Your Address" type="text" 
                                                           
                                                            onChange={(e) => setAddress(e.target.value)}
                                                            ></textarea>
                                                            {responseSuccess == true ?
                                                                ''
                                                                :
                                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {addressError && <span >{addressError}</span>}  </p>
                                                            }

                                                           
                                                        </div>
                                                    </div>

                                                    
                                                </div>

                                    
                                        </div>
                                        <br/>
                                        {/* <div className="paymentMethod">
                                            <div style={styles.container}>
                                                <div class="section__header mb-0">
                                                    <h3 class="section__header--title">Select Payment Method </h3>
                                                </div>
                                              
                                                <div style={styles.radioGroup}>
                                                    <label>
                                                        <input
                                                            type="radio"
                                                            name="payment_option"
                                                            value="Cash on delivery"
                                                            checked={selectedMethod === 'Cash on delivery'}
                                                            onChange={handlePaymentChange}
                                                        />
                                                        <img src="/images/cash.png" alt="payment Method cash" />
                                                    </label>
                                                    <label>
                                                    <input
                                                        type="radio"
                                                        name="payment_option"
                                                        value="online"
                                                        checked={selectedMethod === 'online'}
                                                        onChange={handlePaymentChange}
    
                                                    />
                                                    <img src="/images/SSLCommerz-Pay.png" alt="payment method online" />
                                                
                                                    </label>
                                                    
                                                
                                                </div>
                                            </div>
                                        </div> */}

                                        <h3 class="section__header--title mb-4">Select Payment Method </h3>
                                        
                                        <div class="newPaymentMethod">
                                        <label>
                                            <input
                                                type="radio"
                                                name="payment_option"
                                                value="Cash on delivery"
                                                checked={selectedMethod === 'Cash on delivery'}
                                                onChange={handlePaymentChange}
                                            />
                                           <span>Cash on delivery </span>
                                        </label>
                                        <label>
                                            <input
                                                type="radio"
                                                name="payment_option"
                                                value="bkash"
                                                checked={selectedMethod === 'bkash'}
                                                onChange={handlePaymentChange}
                                            />
                                           <span>bkash</span>
                                        </label>
                                        <label>
                                            <input
                                                type="radio"
                                                name="payment_option"
                                                value="Nogad"
                                                checked={selectedMethod === 'Nogad'}
                                                onChange={handlePaymentChange}
                                            />
                                           <span>Nogad</span>
                                        </label>
                                        <label>
                                            <input
                                                type="radio"
                                                name="payment_option"
                                                value="online"
                                                checked={selectedMethod === 'online'}
                                                onChange={handlePaymentChange}

                                            />
                                            <span>Online getway</span>
                                        </label>
                                        </div>
                                    
                                </main>
                            
                            </div>
                            <aside class="checkout__sidebar sidebar">
                                <div class="cart__table checkout__product--table">
                                    <table class="cart__table--inner">
                                        <tbody class="cart__table--body">
                                        {cart?.cartItems?.map((cartItem) => (
                                            <tr class="cart__table--body__items">
                                                <td class="cart__table--body__list">
                                                    <div class="product__image two  d-flex align-items-center">
                                                        <div class="product__thumbnail border-radius-5">
                                                            <Link href={route('carts')}><img class="border-radius-5" src={cartItem.productImage} alt="cart-product" /></Link>
                                                            <span class="product__thumbnail--quantity">{cartItem.quantity}</span>
                                                        </div>
                                                        <div class="product__description">
                                                            <h3 class="product__description--name h4"> 
                                                                <Link href={route('carts')}>
                                                                    {cartItem.productName.length > 25
                                                                    ? `${cartItem.productName.slice(0, 25)}...`
                                                                    : cartItem.productName} 
                                                                </Link></h3>

                                                            
                                                                {cartItem?.variants?.map((variant) => 
                                                                            <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                                        )}

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price">{cartItem.finalPrice}</span>
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
                                                <td class="checkout__total--title text-left">Subtotal  </td>
                                                <td class="checkout__total--amount text-right">{cart?.cartTotalPriceFormat}</td>
                                            </tr>
                                            <tr class="checkout__total--items">
                                                <td class="checkout__total--title text-left">Discount  </td>
                                                <td class="checkout__total--amount text-right">{cart?.couponDiscFormat}</td>
                                            </tr>


                                            <tr class="checkout__total--items">
                                                <td class="checkout__total--title text-left"> Shipping Charge </td>
                                                <td class="checkout__total--amount text-right">{cart.shippingChargeFormat}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="checkout__total--footer">
                                            <tr class="checkout__total--footer__items">
                                                <td class="checkout__total--footer__title checkout__total--footer__list text-left">Total  </td>
                                                <td class="checkout__total--footer__amount checkout__total--footer__list text-right">{cart?.grandTotalFormat} </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="submit" disabled={processing} class="continue__shipping--btn primary__btn border-radius-5 mt-4 d-block w-full text-center"> {orderLoading ?   <div class="spinner-border " role="status"></div> : 'Place Order'}</button>
                            </aside>
                        </div>
                        </form>

                

                  
                    </div>
                </div>

            </MainLayout>
    </>
  )
}
