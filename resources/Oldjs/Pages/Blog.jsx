
import BlogGrid from "@/Components/blogs/BlogGrid";
import BlogSideBar from "@/Components/blogs/BlogSideBar";
import Pagination from "@/Components/Pagination";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import { useState } from "react";
import { IoSearchOutline } from "react-icons/io5";

export default function Blog({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    page,
    recentBlogs,
    categories,
    tags,
    blogs,
    auth,
    carts,
}) {

    const [itemsCount, setItemsCount] = useState(carts.cartsCount); 
    const [wishListCount, setWishListCount] = useState(carts.wlCount);


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
               


                <section class="blog__section section--padding">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xxl-9 col-xl-8 col-lg-8">
                                <div class="blog__wrapper blog__wrapper--sidebar">
                                    <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-sm-u-2 row-cols-1 mb--n30">
                                        
                                        {blogs.data.map((blog, index) => (
                                            <div class="col mb-30">
                                                <BlogGrid key={index} blog={blog} />
                                            </div>
                                        ))}

                                    </div>

                                    <Pagination pagination={blogs}/>

                                    {/* <div class="pagination__area bg__gray--color">
                                        <nav class="pagination justify-content-center">
                                            <ul class="pagination__wrapper d-flex align-items-center justify-content-center">
                                                <li class="pagination__list">
                                                    <a href="blog.html" class="pagination__item--arrow  link ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewbox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292"></path></svg>
                                                        <span class="visually-hidden">pagination arrow </span>
                                                    </a>
                                                </li><li>
                                                </li><li class="pagination__list"><span class="pagination__item pagination__item--current">1 </span></li>
                                                <li class="pagination__list"><a href="blog.html" class="pagination__item link">2 </a></li>
                                                <li class="pagination__list"><a href="blog.html" class="pagination__item link">3 </a></li>
                                                <li class="pagination__list"><a href="blog.html" class="pagination__item link">4 </a></li>
                                                <li class="pagination__list">
                                                    <a href="blog.html" class="pagination__item--arrow  link ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewbox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100"></path></svg>
                                                        <span class="visually-hidden">pagination arrow </span>
                                                    </a>
                                                </li><li>
                                            </li></ul>
                                        </nav>
                                    </div> */}


                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-lg-4">
                                <BlogSideBar recentBlogs={recentBlogs} categories={categories} tags={tags} />
                            </div>
                        </div>
                    </div>
                </section>

            </MainLayout>
        </>
    );
}
