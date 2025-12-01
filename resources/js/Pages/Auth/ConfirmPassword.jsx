import AlertMessageComponents from "@/Components/AlertMassageCompononets";
import SEOHeadComponent from "@/Components/SEOHeadComponent";
import MainLayout from "@/Layouts/MainLayout";
import { Link, useForm, usePage } from '@inertiajs/react';
import { useEffect } from "react";
import { Button } from "react-bootstrap";
import { LuLogIn } from "react-icons/lu";

export default function forgotPassword({
    general,
    headerMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    token,
    auth,
}) {

    const { errors } = usePage().props;

    const { data, setData, post, processing} = useForm({
        password: '',
        password_confirmation: '',
        verifycode: '',
    });

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const verifycode = params.get('verifycode');

        setData(prevData => ({
            ...prevData,
            ...(verifycode && { verifycode })
        }));
    }, []);

    const submit = (e) => {
        e.preventDefault();
    
        post(route('resetPassword',token), {
            onSuccess: () => {
                // Handle successful login response here
                console.log("Acton in successfully!");
            },
            onError: (errors) => {
                // Handle error responses here
                console.log(errors);

            },
            onFinish: () => {
                // Optionally, you can reset form data here
                //reset();
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
            footerMenu4={footerMenu4}
        >

            <SEOHeadComponent 
            title={`Confirm Password - ${general.web_title}`}
            description={general.meta_description}
            keyword={general.meta_keyword}
            image={general.logo}
            url={route('resetPassword',token)}
             />

            <div className="" style={{ minHeight: "400px" }}>

            <section className="our-log bgc-f9">
                <div className="container">
                    <div className="row">
                        <div className="col-md-3 col-lg-3 col-xl-3"></div>
                        <div className="col-md-6 col-lg-6 col-xl-5">
                            <div className="authForm">
                                <h2 className="title mb-2">Confirm Password</h2>
                            
                                <AlertMessageComponents status={errors.status} message={errors.message} />

                                <form onSubmit={submit} >
                                    <div className="mb-2 mr-sm-2">
                                        <label className="form-label">Verify Code*</label>
                                        <input 
                                            type="number" 
                                            className="form-control"
                                            placeholder="Enter 6 Digit Code"
                                            value={data.verifycode}
                                            onChange={e => setData('verifycode', e.target.value)}
                                        />
                                        {errors.verifycode && <span className='text-danger'>{errors.verifycode}</span>}
                                    </div>
                                    <div className="mb-2 mr-sm-2">
                                        <label className="form-label">New Password*</label>
                                        <input 
                                            type="password" 
                                            className="form-control"
                                            placeholder="Enter Password"
                                            value={data.password}
                                            onChange={e => setData('password', e.target.value)}
                                        />
                                        {errors.password && <span className='text-danger'>{errors.password}</span>}
                                    </div>
                                    <div className="mb-2 mr-sm-2">
                                        <label className="form-label">Confirm Password*</label>
                                        <input 
                                            type="password" 
                                            className="form-control"
                                            placeholder="Enter Confirm Password"
                                            value={data.password_confirmation}
                                            onChange={e => setData('password_confirmation', e.target.value)}
                                        />
                                        {errors.password_confirmation && <span className='text-danger'>{errors.password_confirmation}</span>}
                                    </div>
                                    <Button type="submit" className="w-100 mt-2" size="lg" disabled={processing}>
                                        <LuLogIn style={{ height: "20px", marginRight: "10px" }} /> Confirm Password
                                    </Button>
                                    <p className="text-center mt-4">Already have a profile? <Link href={route('login')}>Sign in.</Link></p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </div>
        </MainLayout>
    );
}