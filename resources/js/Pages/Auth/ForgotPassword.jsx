import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import { Link, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import { FaArrowCircleRight, FaEdit } from "react-icons/fa";
import { LuLogIn } from 'react-icons/lu';
import { Inertia } from '@inertiajs/inertia';

export default function Login({
    general,
    headerMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    categoryMenu,
    auth,
}) {

    const [responseMessage, setResponseMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);
    const [isForm, setIsIsForm] = useState('number');
    const [loading, setLoading] = useState(false);

    const [email_phone, setEmail_phone] = useState('');
    const [otpCode, setOtpCode] =  useState(''); 

    const [confirm_password, setConfirm_password] = useState('');
    const [password, setPassword] = useState('');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handlePhoneSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
    try {
        const response = await fetch('/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                email_phone: email_phone,
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const result = await response.json();
        setResponseMessage(result.message);
        setResponseSuccess(result.success);
        if(result.success){
            setIsIsForm('otp');
        }
        console.log('Server response:', result);
    } catch (error) {
        console.error('Error:', error.message);
        setResponseMessage('Something went wrong!');
    }finally{
        setLoading(false);
    }
};

const handleInputChange = (e) => {
    const value = e.target.value;
    setEmail_phone(value);
  };

  const handleOtpChange = (e) => {
    const value = e.target.value;
    setOtpCode(value)
};


const handleBackChange = () => {
    setIsIsForm('number');
  };


  const handleOtpSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
        const response = await fetch('/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                email_phone: email_phone,
                otpCode: otpCode,
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        setResponseMessage(result.message);
        setResponseSuccess(result.success);
        if(result.success){
            setIsIsForm('confirm');
        }

        console.log('Server response:', result);
    } catch (error) {
        console.error('Error:', error.message);
        setResponseMessage('Something went wrong!');
    }finally{
        setLoading(false);
    }
};


const handleUserSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    const bodyData = {
        email_phone: email_phone,
        otpCode: otpCode,
        password: password,
        confirm_password: confirm_password,

    }
    try {
        const response = await fetch('/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(bodyData),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();
        setResponseMessage(result.message);
        setResponseSuccess(result.success);

        if (result.success) {
            Inertia.visit('/customer/dashboard');
        }

        console.log('Server response:', result);
    } catch (error) {
        console.error('Error:', error.message);
        setResponseMessage('Something went wrong!');
    }finally{
        setLoading(false);
    }
};




    return (
        <MainLayout
        auth={auth}
            general={general}
            headerMenu={headerMenu}
            footerMenu2={footerMenu2}
            footerMenu3={footerMenu3}
            footerMenu4={footerMenu4}
            categoryMenu={categoryMenu}
        >
            <Head title="Login" />
            <div className="" style={{ minHeight: "400px" }}>
                
                {/* <div className="container">
                    <div className="row">
                        <div className="col-md-3"></div>
                        <div className="col-md-6">
                            <div className="authForm">
                          
                                <h2>Forgot Password</h2><br />

                                <Form onSubmit={submit}>
                                <Form.Group className="mb-3" controlId="loginEmail">
                                <Form.Label>Email address</Form.Label>
                                <Form.Control type="email" placeholder="Email Address" value={data.email}
                                        onChange={e => setData('email', e.target.value)} />
                            
                                    <span className='text-danger'>{errors.email && <span>{errors.email}</span>}</span>
                                </Form.Group>
                                <div className='row'>
                                
                                <div className='col-md-12'>
                                <Button type="submit" className="w-100" size="lg" disabled={processing}>
                                <LuLogIn style={{ height: "20px", marginRight: "10px" }} /> Forget
                                </Button>
                                
                                </div>
                                <div className='col-md-12 text-center mt-3 mb-3'>
                                    <p>
                                    I have not an account
                                    <Link href={route('register')} > Register</Link>
                                    </p>
                                </div>
                                </div>
                            </Form>
                               
                            </div>
                        </div>
                    </div>
                </div> */}
              {isForm=='number' &&
                <div class="login__section section--padding">
            <div class="container">
                <div class="login__section--inner">
                    <div class="row ">
                    <div className="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="account__login">
                                <div class="account__login--header mb-25">
                                    <h2 class="account__login--header__title h3 mb-10">Forgot Password </h2>
                                    
                                </div>
                                <div class="account__login--inner">
                                    <>
                                    <form onSubmit={handlePhoneSubmit}>
                                        <label>
                                            You Email/Mobile number
                                        </label>
                                        <label>
                                        {responseSuccess ? (
                                            <span style={{color: "green"}}>{responseMessage}</span>

                                        ) : (
                                            <span style={{color: "red"}}>{responseMessage}</span>

                                        )}
                                        </label>
                                        <input class="account__login--input" placeholder="E-mail or Mobile number"
                                        type="text"
                                        value={email_phone}
                                        onChange={handleInputChange}
                                        />
                                        <button class="account__login--btn primary__btn mb-10" type="submit">
                                                {loading ? 
                                                    <div class="spinner-border " role="status"></div>
                                                    : 
                                                    'Continue'
                                                    } 
                                             <FaArrowCircleRight /> 
                                        </button>
                                    </form>
                                    <p class="account__login--signup__text mt-3"> <span style={{fontWeight: "normal"}}>Don,t Have an Account?</span>  <Link href={route('register')}><button type="submit">Sign up now </button></Link></p>

                                    </>

                                   
                                </div>
                            </div>
                        </div>
                    <div className="col-md-3"></div>
                    </div>
                </div>
            </div>     
                </div>
              }

                {isForm=='otp' &&

                <>
                <div class="login__section section--padding">
                    <div class="container">
                        <div class="login__section--inner">
                            <div class="row ">
                            <div className="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="account__login">
                                        <div class="account__login--header mb-25">
                                            <h2 class="account__login--header__title h3 mb-10">Forgot Password </h2>
                                            
                                        </div>
                                        <div class="account__login--inner">
                                        <form onSubmit={handleOtpSubmit}>
                                <label style={{color: "gray"}}>
                                    {email_phone}
                                    <span
                                        onClick={handleBackChange}
                                        style={{
                                            padding: "0px 15px",
                                            color: "#ffffff",
                                            cursor: "pointer",
                                            display: "inline-block",
                                            background: "#dd0909",
                                            margin: "0 5px",
                                            borderRadius: "5",
                                            display: "inline-flex",
                                            alignItems: "center",
                                        }}
                                        >
                                        <FaEdit style={{marginRight: "5px"}} />
                                        Edit
                                        </span>
                                </label>
                                {responseSuccess ? (
                                        <span style={{color: "green"}}>{responseMessage}</span>

                                    ) : (
                                        <span style={{color: "red"}}>{responseMessage}</span>

                                    )}
                            <input class="account__login--input" placeholder="6 digit Code" type="number"
                            
                            value={otpCode}
                            onChange={handleOtpChange}
                            
                            />
                            <button class="account__login--btn primary__btn mb-10" type="submit">
                                    {loading ? 
                                    <div class="spinner-border " role="status"></div>
                                    : 
                                    ' Verify OTP'
                                    } 
                                <FaArrowCircleRight /> 
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



                    {isForm=='confirm' &&


                    <div class="login__section section--padding">
                    <div class="container">
                        <div class="login__section--inner">
                            <div class="row ">
                            <div className="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="account__login">
                                        <div class="account__login--header mb-25">
                                            <h2 class="account__login--header__title h3 mb-10">Forgot Password </h2>
                                            
                                        </div>
                                        <div class="account__login--inner">
                                        <form onSubmit={handleUserSubmit}>

                                        <label>Password *</label>
                                        <input class="account__login--input" placeholder="Your Name" type="password"
                                        value={password} 
                                        onChange={e => setPassword(e.target.value)}
                                        />
                                        <label>Confirm Password *</label>
                                        <input class="account__login--input" placeholder="Confirm Password" type="password"
                                        value={confirm_password} 
                                        onChange={e => setConfirm_password(e.target.value)}
                                        />
         
                                         <button class="account__login--btn primary__btn mb-10" type="submit">
                                            {loading ? 
                                            <div class="spinner-border " role="status"></div>
                                            : 
                                            ' Submit'
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
                                                        
                    }


                </div>
        </MainLayout>
    );
}
