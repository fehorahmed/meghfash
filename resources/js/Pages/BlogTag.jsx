import BlogGrid from '@/Components/blogs/BlogGrid'
import BlogSideBar from '@/Components/blogs/BlogSideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'

export default function BlogTag({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    tag,
    recentBlogs,
    categories,
    tags,
    blogs,
    auth,
}) {
  return (
    <MainLayout
            auth={auth}
            general={general}
            headerMenu={headerMenu}
            footerMenu4={footerMenu4}
            footerMenu3={footerMenu3}
            categoryMenu={categoryMenu}
            footerMenu2={footerMenu2}
        >
            <Head title={tag.seo_title?tag.seo_title:`${tag.name} - ${general.web_title}`}>
                <meta name="title" property="og:title" content={tag.seo_title?tag.seo_title:`${tag.name} - ${general.web_title}`} />
                <meta name="description" property="og:description" content={tag.seo_description?tag.seo_description:general.meta_description} />
                <meta name="keyword" property="og:keyword" content={tag.seo_keyword?tag.seo_keyword:general.meta_keyword}/>
                <meta name="image" property="og:image" content={general.logo_url} />
                <meta name="url" property="og:url" content={route('blogTag', tag.slug ? tag.slug : 'no-title')} />
                <link rel="canonical" href={route('blogTag', tag.slug ? tag.slug : 'no-title')} />
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
                                
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4">
                            <BlogSideBar recentBlogs={recentBlogs} categories={categories} tags={tags} />
                        </div>
                    </div>
                </div>
            </section>

        </MainLayout>
  )
}
