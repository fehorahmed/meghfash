
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import BlogRelated from "@/Components/blogs/BlogRelated";
import BlogSideBar from "@/Components/blogs/BlogSideBar";
import { useState } from "react";
import ProductSocialSear from "@/Components/products/ProductSocialSear";

export default function BlogDetail({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    blog,
    meta,
    recentBlogs,
    categories,
    tags,
    relatedBlog,
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


               {/* <Head title={blog.seo_title?blog.seo_title:`${blog.name} - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={blog.seo_title?blog.seo_title:`${blog.name} - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={blog.seo_description?blog.seo_description:general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={blog.seo_keyword?blog.seo_keyword:general.meta_keyword}/>
                    <meta name="image" property="og:image" content={blog.meta_image} />
                    <meta name="url" property="og:url" content={route('blogView', blog.slug ? blog.slug : 'no-title')} />
                    <link rel="canonical" href={route('blogView', blog.slug ? blog.slug : 'no-title')} />
                </Head>
                */}

            <Head>
                <title>{meta?.title}</title>
                <meta name="title" property="og:title" content={meta?.title} />
                <meta name="description" property="og:description" content={meta?.description} />
                <meta name="keyword" property="og:keyword" content={meta?.keywords} />
                <meta name="image" property="og:image" content={meta?.image} />
                <meta name="url" property="og:url" content={meta?.url} />
                <link rel="canonical" href={meta?.url} />
            </Head>



             
            <section class="blog__section section--padding">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-9 col-xl-8 col-lg-8">
                            <div class="blog__details--wrapper">
                                <div class="entry__blog">
                                    <div class="blog__post--header mb-30">
                                        <h2 class="post__header--title mb-15">{blog.name}</h2>
                                        <p class="blog__post--meta">Posted by : {blog.authorName} / On : {blog.createdAt} 
                                            {blog.postCtg.length > 0 &&
                                            <>
                                            / In :   
                                            {blog.postCtg.map((ctg, index) => (
                                                <>
                                                <Link class="blog__post--meta__link" href={route('blogCategory',ctg.slug)}>{ctg.name}</Link>
                                                {index < blog.postCtg.length - 1 && ', '}
                                                </>
                                            ))}
                                            </>
                                            }
                                            
                                        </p>                                     
                                    </div>
                                    <div class="blog__thumbnail mb-30">
                                        <img class="blog__thumbnail--img border-radius-10" src={blog.image_url} alt={blog.name} />
                                    </div>
                                    <div class="blog__details--content" >
                                            <div dangerouslySetInnerHTML={{ __html: blog.description }} />
                                    </div>
                                </div>
                                <div class="blog__tags--social__media d-flex align-items-center justify-content-between">
                                    {/* <div class="blog__tags--media d-flex align-items-center">
                                        <label class="blog__tags--media__title">Releted Tags : </label>
                                        <ul class="d-flex">
                                            <li class="blog__tags--media__list"><a class="blog__tags--media__link" href="blog-details.html">Popular </a></li>
                                            <li class="blog__tags--media__list"><a class="blog__tags--media__link" href="blog-details.html">Business </a></li>
                                            <li class="blog__tags--media__list"><a class="blog__tags--media__link" href="blog-details.html">desgin </a></li>
                                            <li class="blog__tags--media__list"><a class="blog__tags--media__link" href="blog-details.html">Service </a></li>
                                        </ul>
                                    </div> */}
                                    <div class="blog__social--media d-flex align-items-center">
                                        {/* <label class="blog__social--media__title">Social Share : </label> */}
                                        <ProductSocialSear product={blog}/>
                                    </div>
                                </div>
                                {relatedBlog.length > 0 &&  
                                <BlogRelated relatedBlog={relatedBlog} />
                                }
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
