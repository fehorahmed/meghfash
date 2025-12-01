import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";

export default function Error({ general, headerMenu, footerMenu2, footerMenu3, auth, status, message }) {
    return (
        <>
            <MainLayout auth={auth} general={general} headerMenu={headerMenu} footerMenu2={footerMenu2} footerMenu3={footerMenu3}>
                <Head title={status} />
                <section class="breadcrumb__section breadcrumb__bg">
                    <div class="container">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="breadcrumb__content text-center">
                                    <h1 class="breadcrumb__content--title text-white mb-25">404 </h1>
                                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                        <li class="breadcrumb__content--menu__items"><a class="text-white" href={route('index')}>Home </a></li>
                                        <li class="breadcrumb__content--menu__items"><span class="text-white">Error 404 </span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="error__section section--padding">
                <div class="container">
                    <div class="row row-cols-1">
                        <div class="col">
                            <div class="error__content text-center">
                                <img class="error__content--img mb-50" src="/images/img/other/404-thumb.png" alt="error-img" />
                                <h2 class="error__content--title">Opps ! We,ar Not Found This Page </h2>
                                <p class="error__content--desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi animi aliquid minima assumenda. </p>
                                <Link class="error__content--btn primary__btn" href="/">Back To Home </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
   

            </MainLayout>
        </>
    );
}
