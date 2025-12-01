import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import { Link, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import { LuLogIn } from 'react-icons/lu';

export default function Login({
    general,
    headerMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    categoryMenu,
    auth,
    carts,
    flash,
}) {

    const [itemsCount, setItemsCount] = useState(carts.cartsCount); 
    const [wishListCount, setWishListCount] = useState(carts.wlCount); 

    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember_me: false,
    });

    const [showAlert, setShowAlert] = useState(false);
    const [alertMessage, setAlertMessage] = useState('hellow');
    
    const submit = (e) => {
        e.preventDefault();
    console.log('login submit')
        post(route('login'), {
            // onSuccess: () => {
            //     // Handle successful login response here
            //     console.log("Logged in successfully!");
            // },
            onError: (errors) => {
                // Handle error responses here
                 setShowAlert(true);
                setAlertMessage('sdflksd');
                console.log(errors);

            },
            onFinish: () => {
                // Optionally, you can reset form data here
                //reset();
            }
        });
    };

    console.log(flash)



    return (
        <MainLayout
        auth={auth}
            general={general}
            headerMenu={headerMenu}
            footerMenu2={footerMenu2}
            footerMenu3={footerMenu3}
            footerMenu4={footerMenu4}
            itemsCount={itemsCount}
            categoryMenu={categoryMenu}
            carts={carts}
            wishListCount={wishListCount}
        >
            <Head title="Login" />

             {/* <section class="breadcrumb__section breadcrumb__bg">
             <div class="container">
                 <div class="row row-cols-1">
                     <div class="col">
                         <div class="breadcrumb__content text-center">
                             <h1 class="breadcrumb__content--title text-white mb-25">Login Page </h1>
                             <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                 <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home </a></li>
                                 <li class="breadcrumb__content--menu__items"><span class="text-white">Login Page </span></li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </section> */}

           



         <div class="login__section section--padding">
             <div class="container">
                <div class="login__section--inner">
                    <div class="row ">
                    <div className="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="account__login">
                                <div class="account__login--header mb-25">
                                    <h2 class="account__login--header__title h3 mb-10">Login </h2>
                                    <p class="account__login--header__desc">Login if you area a returning customer. </p>
                                </div>
                                {flash.error && <p className="text-danger"><span>{flash.error}</span></p>}
                                <div class="account__login--inner">
                                    <form onSubmit={submit}>
                                    <input class="account__login--input" placeholder="Email Addres" type="email"
                                    value={data.email} 
                                    onChange={e => setData('email', e.target.value)}
                                    />
                                    <span className='text-danger'>{errors.email && <span>{errors.email}</span>}</span>

                                    <input class="account__login--input" placeholder="Password" type="password" value={data.password}
                                            onChange={e => setData('password', e.target.value)}
                                    />
                                    <span className='text-danger'> {errors.password && <span>{errors.password}</span>}</span>

                                    <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                        <div class="account__login--remember position__relative">
                                            <input class="checkout__checkbox--input" id="check1" type="checkbox" />
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                Remember me </label>
                                        </div>
                                        <Link class="account__login--forgot" href={route('forgotPassword')} >Forgot Your Password? </Link>
                                    </div>
                                    <button class="account__login--btn primary__btn" type="submit">Login </button>
                                    </form>
                                    <div class="account__login--divide">
                                        <span class="account__login--divide__text">OR </span>
                                    </div>
                                    {(general.fb_app_redirect_url || general.google_client_redirect_url || general.tw_app_redirect_url) &&



                                        <div class="account__social d-flex justify-content-center mb-15">
                                            {general.fb_app_redirect_url &&
                                            <a class="account__social--link facebook" target="_blank" href="/login/facebook">Facebook </a>
                                        }
                                        {general.google_client_redirect_url &&
                                            <a class="account__social--link google" target="_blank" href="/login/google">Google </a>
                                        }
                                        {/* {general.tw_app_redirect_url &&
                                        <a class="account__social--link twitter" target="_blank" href={general.tw_app_redirect_url}>Twitter </a>
                                        } */}
                                      
                                        </div>
                                    }


                                    <p class="account__login--signup__text"> <span style={{fontWeight: "normal"}}>Don,t Have an Account?</span>  <Link href={route('register')}><button type="submit">Sign up now </button></Link></p>
                                </div>
                            </div>
                        </div>
                    <div className="col-md-3"></div>
                    </div>
                </div>
             </div>     
         </div>
        </MainLayout>
    );
}
