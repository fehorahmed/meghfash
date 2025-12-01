import AlertMessageComponents from '@/Components/AlertMassageCompononets';
import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link, useForm } from '@inertiajs/react'
import React, { useState } from 'react'
import { Form , InputGroup } from 'react-bootstrap';
import { FaEyeSlash } from 'react-icons/fa';
import { IoEyeSharp } from 'react-icons/io5';

export default function ChangePassword({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    carts,
    auth
}) {

    const [showPassword, setShowPassword] = useState(false);
    const [profileLoading ,setProfileLoading] =useState(false);

    const togglePasswordVisibility = () => {
        setShowPassword((prev) => !prev);
    };

    const { data, setData, post, reset, processing, errors } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('customer.changePassword'), {
            onSuccess: (response) => {
                reset(); // Reset the form data
            },
            onError: (errors) => {
                console.log(errors);
                // If the error response contains status and message, set them
                if(errors.status=='success'){
                    reset();
                }
            },
            onFinish: () => {
                console.log("Password change process finished.");
            }
        });
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
        carts={carts}
    >
        <Head title={`Change password - ${general.web_title}`}>
            <meta name="title" property="og:title" content={`Change password - ${general.web_title}`} />
            <meta name="description" property="og:description" content={general.meta_description} />
            <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
            <meta name="image" property="og:image" content={general.logo_url} />
            <meta name="url" property="og:url" content={route('customer.changePassword')} />
            <link rel="canonical" href={route('customer.changePassword')} />
        </Head>
        
        
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {auth.user.name} welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <SideBar auth={auth} />
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Change Password</h2>
                            <div>
                            <AlertMessageComponents status={errors.status} message={errors.message} />
                            <form class="contact__form--inner" onSubmit={submit}>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="contact__form--list">
                                            <label class="contact__form--label" for="input1">Current Password
                                            <span class="contact__form--label__star">* </span>
                                            </label>
                                            <div className="input-group">
                                            <input class="contact__form--input" name="current_password" id="input1" 
                                            placeholder="Current password"
                                            style={{flex: "1 1 auto",width: "1%"}} 
                                            type={showPassword ? 'text' : 'password'}
                                            required=""
                                            value={data.current_password}
                                            onChange={e => setData('current_password', e.target.value)}
                                            
                                            />
                                                <span className='input-group-text' onClick={togglePasswordVisibility} style={{cursor: "pointer", width: "50px"}}>
                                                    {showPassword ?  <IoEyeSharp style={{fontSize: "30px"}}/> :  <FaEyeSlash style={{fontSize: "30px"}}/>}
                                                </span>
                                            </div>
                                            <span className='errrowMsg'> {errors.current_password && <span>{errors.current_password}</span>}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="contact__form--list">
                                            <label class="contact__form--label" for="input1">New Password
                                            <span class="contact__form--label__star">* </span>
                                            </label>
                                            <div className="input-group">
                                            <input class="contact__form--input" name="password" id="input1" 
                                            placeholder="New Password"
                                            type={showPassword ? 'text' : 'password'}
                                            required=""
                                            value={data.password}
                                            onChange={e => setData('password', e.target.value)}
                                            
                                            />
                                            </div>
                                            <span className='errrowMsg'> {errors.password && <span>{errors.password}</span>}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-md-12">
                                        <div class="contact__form--list">
                                            <label class="contact__form--label" for="input1">Confirmed Password
                                            <span class="contact__form--label__star">* </span>
                                            </label>
                                            <div className="input-group">
                                            <input class="contact__form--input" name="password_confirmation" id="input1" 
                                            placeholder="Confirmed Password"
                                            type={showPassword ? 'text' : 'password'}
                                            required=""
                                            value={data.password_confirmation}
                                            onChange={e => setData('password_confirmation', e.target.value)}
                                            
                                            />
                                            </div>
                                            <span className='errrowMsg'> {errors.password_confirmation && <span>{errors.password_confirmation}</span>}</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="contact__form--btn primary__btn" type="submit" style={{position: "relative",    minWidth: "200px"}}>
                                    {profileLoading ? (
                                                <span className="loading"></span>
                                            ):(
                                                <span>
                                                    Change Password
                                                </span>
                                            )}

                                        </button>  
                            </form>
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
