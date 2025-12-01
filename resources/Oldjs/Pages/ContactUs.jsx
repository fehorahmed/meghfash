import AlertMessageComponents from "@/Components/AlertMassageCompononets";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import { useRef, useState } from "react";
import { FaFacebookF, FaInstagram, FaLinkedin, FaPinterest, FaTwitter, FaYoutube } from "react-icons/fa";
export default function ContactUs({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    page,
    carts,
}) {
    const [itemsCount, setItemsCount] = useState(carts.cartsCount); // Default selected color
    const [wishListCount, setWishListCount] = useState(carts.wlCount); 

    const [responseMessage, setResponseMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [mobile, setMobile] = useState('');
    const [message, setMessage] = useState('');
    const [status, setStatus] = useState('');
    const [nameError, setNameError] = useState('');
    const [emailError, setEmailError] = useState('');

    const [loading, setLoading] = useState(false);

    const form = useRef(null);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    const handleUserSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await fetch('/contact-mail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    message: message,
                    mobile: mobile
                }),
            });

            const result = await response.json();
            if (!response.ok) {
                // If the response contains validation errors
                if (result.errors) {
                    // Flatten the errors and display them as a list
                    console.log(result.errors.name)
                    console.log(result.errors.email)
                    setNameError(result.errors.name)
                    setEmailError(result.errors.email)
                    setResponseMessage(Object.values(result.errors).flat().join(", "));
                    setResponseSuccess(result.success);
                } else {
                    
                    setResponseMessage(result.message);
                    setResponseSuccess(result.success);
                    console.log('Not ok');
                }
            } else {
                setResponseMessage(result.message);
                setResponseSuccess(result.success);
                setStatus('success')
                setName('');
                setEmail('');
                setMobile('');
                setMessage('');
                
                console.log('success');
            }

            form.current.reset();
            console.log('Server response:', result);
        } catch (error) {
            setResponseMessage('Something went wrong!');
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
                itemsCount={itemsCount}
                carts={carts}
                wishListCount={wishListCount}
                footerMenu2={footerMenu2}
            >
                <Head title={page.seo_title?page.seo_title:`${page.name} - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={page.seo_title?page.seo_title:`${page.name} - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={page.seo_description?page.seo_description:general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={page.seo_keyword?page.seo_keyword:general.meta_keyword}/>
                    <meta name="image" property="og:image" content={page.meta_image} />
                    <meta name="url" property="og:url" content={route('pageView', page.slug ? page.slug : 'no-title')} />
                    <link rel="canonical" href={route('pageView', page.slug ? page.slug : 'no-title')} />
                </Head>
               



                <section class="contact__section section--padding">
             <div class="container">
                 <div class="section__heading text-center mb-40">
                     <h2 class="section__heading--maintitle">Get In Touch </h2>
                 </div>
                 <div class="main__contact--area position__relative">
                    
                     <div class="contact__form">
                         <h3 class="contact__form--title mb-40">Contact Us </h3>
                         <AlertMessageComponents
                            status={status}
                            message={responseMessage}
                         />
                         <form ref={form} class="contact__form--inner" onSubmit={handleUserSubmit} >
                             <div class="row">
                                 <div class="col-lg-12 col-md-12">
                                     <div class="contact__form--list mb-20">
                                         <label class="contact__form--label" for="input1">Your Name  
                                         <span class="contact__form--label__star">* </span>
                                         </label>
                                         <input class="contact__form--input" name="name" id="input1"
                                        placeholder="Your Name"
                                        type="text"
                                        value={name}
                                        required=""
                                        onChange={(e) => setName(e.target.value)}
                                         />
                                        {responseSuccess == true ?
                                        ''
                                        :
                                        <p className="errrowMsg" style={{fontSize: "14px"}}> {nameError && <span >{nameError}</span>}  </p>
                                        }
                                     </div>
                                 </div>
                                 
                                 <div class="col-lg-6 col-md-6">
                                     <div class="contact__form--list mb-20">
                                         <label class="contact__form--label" for="input4">Email <span class="contact__form--label__star">* </span></label>
                                         <input class="contact__form--input" name="email" id="input4" placeholder="Email"
                                         value={email}
                                         type="email"
                                         onChange={(e) => setEmail(e.target.value)}
                                         />
                                        {responseSuccess == true ?
                                        ''
                                        :
                                        <p className="errrowMsg" style={{fontSize: "14px"}}> {emailError && <span >{emailError}</span>}  </p>
                                        }
                                     </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6">
                                     <div class="contact__form--list mb-20">
                                         <label class="contact__form--label" for="input3">Mobile Number </label>
                                         <input class="contact__form--input" name="mobile" id="input3" 
                                         value={mobile}
                                         placeholder="Mobile number" type="text"
                                         onChange={(e) => setMobile(e.target.value)}
                                         />
                                     </div>
                                 </div>
                                 <div class="col-12">
                                     <div class="contact__form--list mb-15">
                                         <label class="contact__form--label" for="input5">Write Your Message  <span class="contact__form--label__star">* </span></label>
                                         <textarea class="contact__form--textarea" name="message" id="input5" 
                                         placeholder="Write Your Message"
                                         value={message}
                                         onChange={(e) => setMessage(e.target.value)}
                                         ></textarea>
                                     </div>
                                 </div>
                             </div>
                             <button class="contact__form--btn primary__btn" type="submit">
                                {loading ? 
                                    <div class="spinner-border " role="status"></div>
                                    : 
                                    'Submit Now '
                                } 
                                </button>
                         </form>
                     </div>
                     <div class="contact__info border-radius-5">
                         <div class="contact__info--items">
                             <h3 class="contact__info--content__title text-white mb-15">Contact Us </h3>
                             <div class="contact__info--items__inner d-flex">
                                 <div class="contact__info--icon">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="31.568" height="31.128" viewbox="0 0 31.568 31.128">
                                         <path id="ic_phone_forwarded_24px" d="M26.676,16.564l7.892-7.782L26.676,1V5.669H20.362v6.226h6.314Zm3.157,7a18.162,18.162,0,0,1-5.635-.887,1.627,1.627,0,0,0-1.61.374l-3.472,3.424a23.585,23.585,0,0,1-10.4-10.257l3.472-3.44a1.48,1.48,0,0,0,.395-1.556,17.457,17.457,0,0,1-.9-5.556A1.572,1.572,0,0,0,10.1,4.113H4.578A1.572,1.572,0,0,0,3,5.669,26.645,26.645,0,0,0,29.832,32.128a1.572,1.572,0,0,0,1.578-1.556V25.124A1.572,1.572,0,0,0,29.832,23.568Z" transform="translate(-3 -1)" fill="currentColor"></path>
                                     </svg>
                                 </div>
                                 <div class="contact__info--content">
                                     <p class="contact__info--content__desc text-white">Hotline <br /> <a href={`tel:${general.mobile.trim()}`}> {general.mobile}</a>  </p>
                                 </div>
                             </div>
                         </div>
                         <div class="contact__info--items">
                             <h3 class="contact__info--content__title text-white mb-15">Email Address </h3>
                             <div class="contact__info--items__inner d-flex">
                                 <div class="contact__info--icon">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewbox="0 0 31.57 31.13">
                                         <path id="ic_email_24px" d="M30.413,4H5.157C3.421,4,2.016,5.751,2.016,7.891L2,31.239c0,2.14,1.421,3.891,3.157,3.891H30.413c1.736,0,3.157-1.751,3.157-3.891V7.891C33.57,5.751,32.149,4,30.413,4Zm0,7.783L17.785,21.511,5.157,11.783V7.891l12.628,9.728L30.413,7.891Z" transform="translate(-2 -4)" fill="currentColor"></path>
                                     </svg>  
                                 </div>
                                 <div class="contact__info--content">
                                     <p class="contact__info--content__desc text-white">
                                        Mail Us<br />  
                                        <a href={`mailto:${general.email}`}>{general.email} </a>
                                    </p> 
                                 </div>
                             </div>
                         </div>
                         <div class="contact__info--items">
                             <h3 class="contact__info--content__title text-white mb-15">Office Location </h3>
                             <div class="contact__info--items__inner d-flex">
                                 <div class="contact__info--icon">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewbox="0 0 31.57 31.13">
                                         <path id="ic_account_balance_24px" d="M5.323,14.341V24.718h4.985V14.341Zm9.969,0V24.718h4.985V14.341ZM2,32.13H33.57V27.683H2ZM25.262,14.341V24.718h4.985V14.341ZM17.785,1,2,8.412v2.965H33.57V8.412Z" transform="translate(-2 -1)" fill="currentColor"></path>
                                     </svg> 
                                 </div>
                                 <div class="contact__info--content">
                                    <p class="contact__info--content__desc text-white">
                                    {general.address_one}
                                    </p> 
                                 </div>
                             </div>
                         </div>
                         <div class="contact__info--items">
                             <h3 class="contact__info--content__title text-white mb-15">Follow Us </h3>
                             <ul class="contact__info--social d-flex">
                                {general.facebook_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.facebook_link}>
                                         <FaFacebookF />
                                         <span class="visually-hidden">Facebook </span>
                                     </a>
                                 </li>
                                }
                                
                                {general.twitter_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.twitter_link}>
                                         <FaTwitter />
                                         <span class="visually-hidden">Twitter </span>
                                     </a>
                                 </li>
                                }
                               
                                {general.instagram_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.instagram_link}>
                                        <FaInstagram />
                                         <span class="visually-hidden">Instagram </span>
                                     </a>
                                 </li>
                                }
                                
                                {general.linkedin_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.linkedin_link}>
                                        <FaLinkedin />
                                         <span class="visually-hidden">Linkdin </span>
                                     </a>
                                 </li>
                                }
                                
                                {general.youtube_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.youtube_link}>
                                        <FaYoutube />
                                         <span class="visually-hidden">Youtube </span>
                                     </a>
                                 </li>
                                }
                                {general.pinterest_link && 
                                 <li class="contact__info--social__list">
                                     <a class="contact__info--social__icon" target="_blank" href={general.pinterest_link}>
                                        <FaPinterest />
                                         <span class="visually-hidden">Pinterest </span>
                                     </a>
                                 </li>
                                }
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
                </section>

                <div class="contact__map--area section--padding pt-0">
                    <div className="container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116833.83187882077!2d90.33728802520291!3d23.78097572833174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1734956206702!5m2!1sen!2sbd" width="100%" height="550" style={{border: "0"}} allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>


                {/* <section class="shipping__section2 shipping__style3 section--padding">
                    <div class="container">
                        <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                            <div class="shipping__items2 d-flex align-items-center">
                                <div class="shipping__items2--icon">
                                    <img src="/images/img/other/shipping1.png" alt="" />
                                </div>
                                <div class="shipping__items2--content">
                                    <h2 class="shipping__items2--content__title h3">Shipping </h2>
                                    <p class="shipping__items2--content__desc">From handpicked sellers </p>
                                </div>
                            </div>
                            <div class="shipping__items2 d-flex align-items-center">
                                <div class="shipping__items2--icon">
                                    <img src="/images/img/other/shipping2.png" alt="" />
                                </div>
                                <div class="shipping__items2--content">
                                    <h2 class="shipping__items2--content__title h3">Payment </h2>
                                    <p class="shipping__items2--content__desc">From handpicked sellers </p>
                                    
                                </div>
                            </div>
                            <div class="shipping__items2 d-flex align-items-center">
                                <div class="shipping__items2--icon">
                                    <img src="/images/img/other/shipping3.png" alt="" />
                                </div>
                                <div class="shipping__items2--content">
                                    <h2 class="shipping__items2--content__title h3">Return </h2>
                                    <p class="shipping__items2--content__desc">From handpicked sellers </p>
                                </div>
                            </div>
                            <div class="shipping__items2 d-flex align-items-center">
                                <div class="shipping__items2--icon">
                                    <img src="/images/img/other/shipping4.png" alt="" />
                                </div>
                                <div class="shipping__items2--content">
                                    <h2 class="shipping__items2--content__title h3">Support </h2>
                                    <p class="shipping__items2--content__desc">From handpicked sellers </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="brand__logo--section bg__secondary section--padding">
                    <div class="container">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="brand__logo--section__inner d-flex justify-content-center align-items-center">
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block" src="/images/img/logo/brand-logo1.png" alt="brand logo" />
                                    </div>
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block" src="/images/img/logo/brand-logo2.png" alt="brand logo" />
                                    </div>
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block" src="/images/img/logo/brand-logo3.png" alt="brand logo" />
                                    </div>
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block" src="/images/img/logo/brand-logo4.png" alt="brand logo" />
                                    </div>
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block" src="/images/img/logo/brand-logo5.png" alt="brand logo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> */}


            </MainLayout>
        </>
    );
}
