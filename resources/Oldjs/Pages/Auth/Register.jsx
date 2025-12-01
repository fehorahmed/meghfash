import MainLayout from '@/Layouts/MainLayout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { FaArrowCircleRight, FaEdit } from 'react-icons/fa';
import { Inertia } from '@inertiajs/inertia';

export default function Register({
    general,
    headerMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    categoryMenu,
    auth,
}) {

    const [isForm, setIsIsForm] = useState('number');
    const [loading, setLoading] = useState(false);
    const [email_phone, setEmail_phone] = useState('');
    const [otpCode, setOtpCode] =  useState(''); 
    const [name, setName] = useState('');
    const [password, setPassword] = useState('');
    const [nameError, seNameError] = useState('');
    const [passwordError, sePasswordError] = useState('');
    const [terms, setTerms] = useState(false);

    const [responseMessage, setResponseMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log(csrfToken);
    const handlePhoneSubmit = async (e) => {
            e.preventDefault();
            setLoading(true);
        try {
            const response = await fetch('/register', {
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


    const handleOtpSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await fetch('/register', {
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
                setIsIsForm('register');
            }

            console.log('Server response:', result);
        } catch (error) {
            console.error('Error:', error.message);
            setResponseMessage('Something went wrong!');
        }finally{
            setLoading(false)
        }
    };

    const handleUserSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        const bodyData = {
            email_phone: email_phone,
            otpCode: otpCode,
            name: name,
            password: password,
            terms: terms,
        }

        try {
            const response = await fetch('/register', {
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
            if (result.success) {
                console.log("success")
                Inertia.visit('/customer/dashboard');
            }else{
                console.log("fail")
            }
            setResponseMessage(result.message);
            setResponseSuccess(result.success);
            seNameError(result.errors.name);
            sePasswordError(result.errors.password);
            


            console.log('Server response:', result);
        } catch (error) {
            setResponseMessage('Something went wrong!');
        }finally{
            setLoading(false);
        }
    };


    const handleInputChange = (e) => {
        const value = e.target.value;
        setEmail_phone(value);
      };
    
    const handleBackChange = () => {
        setIsIsForm('number');
        setResponseMessage('');
      };


    const handleOtpChange = (e) => {
        const value = e.target.value;
        setOtpCode(value)
    };
    

  return (
    <>
       


          <MainLayout
            auth={auth}
            general={general}
            headerMenu={headerMenu}
            footerMenu2={footerMenu2}
            footerMenu3={footerMenu3}
            footerMenu4={footerMenu4}
            categoryMenu={categoryMenu}
        >
            <Head title="register" />
            <div class="login__section section--padding">
             <div class="container">

                     <div class="login__section--inner">
                         <div class="row">
                            <div className="col-md-3"></div>
                             <div class="col-md-6">
                                 <div class="account__login register">
                                     <div class="account__login--header mb-25">
                                         <h2 class="account__login--header__title h3 mb-10">Create an Account </h2>
                                         <p class="account__login--header__desc">Register here if you are a new customer </p>
                                     </div>
                                     <div class="account__login--inner">
                                        {isForm=='number' &&
                                        <>
                                        <form onSubmit={handlePhoneSubmit}>
                                            <label>
                                                You Email/Mobile number
                                            </label>
                                            <span style={{color: "red"}}>{responseMessage}</span>
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
                                                 <FaArrowCircleRight style={{marginLeft: "5px"}} /> </button>
                                        </form>
                                        </>
                                        }
                                       

                                       {isForm=='otp' &&
                                        <>
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
                                            <label>
                                            {responseSuccess ? (
                                                <span style={{color: "green"}}>{responseMessage}</span>

                                            ) : (
                                                <span style={{color: "red"}}>{responseMessage}</span>

                                            )}

                                            </label>
                                            <input class="account__login--input" placeholder="6 digit Code" type="number"
                                            
                                            value={otpCode}
                                            onChange={handleOtpChange}
                                            
                                            />
                                            <button class="account__login--btn primary__btn mb-10" type="submit">
                                                
                                                {loading ? 
                                                    <div class="spinner-border " role="status"></div>
                                                    : 
                                                    'Verify OTP '
                                                    } 
                                                 <FaArrowCircleRight style={{marginLeft: "5px"}} />
                                                
                                                </button>
                                            </form>
                                        </>
                                        }

                                        {isForm=='register' &&
                                            <>
                                            <form onSubmit={handleUserSubmit}>

                                            <label>Your Name *</label>
                                            {nameError && 
                                            <p className="errrowMsg" style={{fontSize: "14px",margin: "0"}}> <span>{nameError}</span> </p>
                                            }
                                            
                                            <input class="account__login--input" placeholder="Your Name" type="text"
                                            value={name} 
                                            onChange={e => setName(e.target.value)}
                                            />
                                            <label>Password *</label>
                                            {passwordError && 
                                            <p className="errrowMsg" style={{fontSize: "14px",margin: "0"}}> <span>{passwordError}</span> </p>
                                            }
                                            <input class="account__login--input" placeholder="Your Password" type="password"
                                            value={password} 
                                            onChange={e => setPassword(e.target.value)}
                                            />
                                            <label className="mb-3">
                                                <input type="checkbox" name="tarms" required style={{marginRight:"10px"}}
                                                value={terms} 
                                                onChange={e => setTerms(e.target.checked)}
                                                />
                                                I agree to {general.title}'s <a href="/terms-and-conditions" target="_blank"> terms & conditions</a>
                                            </label>
                                            <button class="account__login--btn primary__btn mb-10" type="submit">
                                            {loading ? 
                                                    <div class="spinner-border " role="status"></div>
                                                    : 
                                                    'Submit'
                                                    } 
     
                                            </button>
                                            </form>
                                            </>
                                        }
                                         <br />
                                         <br />
                                         <p class="account__login--signup__text"> <span style={{fontWeight: "normal"}}>I Have already Account?</span>  <Link href={route('login')}><button type="submit">Sign In now </button></Link></p>
                                     </div>
                                 </div>
                             </div>
                             <div className="col-md-3"></div>
                         </div>
                     </div>
             </div>     
         </div>
        </MainLayout>

    </>
  )
}
