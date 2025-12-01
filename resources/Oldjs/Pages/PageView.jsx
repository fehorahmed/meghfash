import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";

export default function PageView({
    general,
    headerMenu,
    footerMenu2,
    footerMenu4,
    footerMenu3,
    categoryMenu,
    page,
    auth,
}) {
    return (
        <>
            <MainLayout
            auth={auth}
                general={general}
                headerMenu={headerMenu}
                footerMenu4={footerMenu4}
                footerMenu3={footerMenu3}
                footerMenu2={footerMenu2}
                categoryMenu={categoryMenu}
            >
                <Head title={page.seo_title?page.seo_title:`${page.name} - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={page.seo_title?page.seo_title:`${page.name} - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={page.seo_description?page.seo_description:general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={page.seo_keyword?page.seo_keyword:general.meta_keyword}/>
                    <meta name="image" property="og:image" content={page.meta_image} />
                    <meta name="url" property="og:url" content={route('pageView', page.slug ? page.slug : 'no-title')} />
                    <link rel="canonical" href={route('pageView', page.slug ? page.slug : 'no-title')} />
                </Head>


                <section class="breadcrumb__section">
                    <div class="container">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="breadcrumb__content text-center">
                                    <h1 class="breadcrumb__content--title mb-25">{page.name}</h1>
                                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                        <li class="breadcrumb__content--menu__items"><a href={route('index')}>Home</a></li>
                                        <li class="breadcrumb__content--menu__items"><span>{page.name}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div
                    className="pageContect"
                    style={{ minHeight: "300px" }}
                >
                    <div className="container">
                    <div style={{ padding: "50px 0"}} dangerouslySetInnerHTML={{ __html: page.description }} />
                    </div>
                </div>
            </MainLayout>
        </>
    );
}
