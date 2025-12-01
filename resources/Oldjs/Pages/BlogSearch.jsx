import BlogGrid from '@/Components/blogs/BlogGrid'
import BlogSideBar from '@/Components/blogs/BlogSideBar'
import Pagination from '@/Components/Pagination'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'

export default function BlogSearch({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    recentBlogs,
    categories,
    tags,
    blogs,
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
                categoryMenu={categoryMenu}
                footerMenu2={footerMenu2}
            >
                <Head title={`Blog Search - ${general.web_title}`}>
                    <meta name="title" property="og:title" content={`Blog Search - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('blogSearch')} />
                    <link rel="canonical" href={route('blogSearch')} />
                </Head>
               

                <section class="breadcrumb__section breadcrumb__bg" >
                    <div class="container">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="breadcrumb__content text-center">
                                    <h1 class="breadcrumb__content--title text-white mb-25">Search </h1>
                                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                        <li class="breadcrumb__content--menu__items"><Link class="text-white" href={route('index')}>Home </Link></li>
                                        <li class="breadcrumb__content--menu__items"><span class="text-white">Search</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

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
  )
}
