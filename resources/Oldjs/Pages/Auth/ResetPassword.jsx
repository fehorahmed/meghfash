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
    auth,
}) {

    const { data, setData, post, processing, errors } = useForm({
        email: '',
        remember_me: false,
    });
    
    const submit = (e) => {
        e.preventDefault();
    
        post(route('forgotPassword'), {
            onSuccess: () => {
                // Handle successful login response here
                console.log("Logged in successfully!");
            },
            onError: (errors) => {
                // Handle error responses here
                console.log(errors);
            },
            onFinish: () => {
                // Optionally, you can reset form data here
                // reset();
            }
        });
    };



    return (
        <MainLayout
        auth={auth}
            general={general}
            headerMenu={headerMenu}
            footerMenu2={footerMenu2}
            footerMenu3={footerMenu3}
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
                                    <form onSubmit={submit}>
                                    <input class="account__login--input" placeholder="Email Addres" type="email"
                                    value={data.email} 
                                    onChange={e => setData('email', e.target.value)}
                                    />
                                    <span className='text-danger'>{errors.email && <span>{errors.email}</span>}</span>

                                        <button class="account__login--btn primary__btn" type="submit">Submit </button>
                                    </form>
                               
                                   
                                </div>
                            </div>
                        </div>
                    <div className="col-md-3"></div>
                    </div>
                </div>
            </div>     
                </div>

                </div>
        </MainLayout>
    );
}
