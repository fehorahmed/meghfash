import React from 'react'
import { IoSearchOutline } from "react-icons/io5";
import { Link, useForm } from '@inertiajs/react';

export default function BlogSideBar({recentBlogs, categories, tags}) {
    
    

    const { data, setData, get, processing, errors } = useForm({
        blog_search: '',
    });
    
    const submit = (e) => {
        e.preventDefault();
    
        get(route('blogSearch'), {
            onSuccess: () => {
                // Handle successful login response here
                console.log("Logged in successfully!");
            },
            onError: (errors) => {
                console.log(errors);
            },
            onFinish: () => {
                // Optionally, you can reset form data here
                //reset();
            }
        });
    };

    return (
    <div class="blog__sidebar--widget left widget__area">
        <div class="single__widget widget__search widget__bg">
            <h2 class="widget__title h3">Search </h2>
            <form class="widget__search--form" onSubmit={submit}>
                <label>
                    <input class="widget__search--form__input" 
                    name="blog_search" 
                    placeholder="Search..." 
                    type="text"
                    value={data.blog_search}
                    onChange={e => setData('blog_search', e.target.value)}
                    />
                </label>
                <button class="widget__search--form__btn" aria-label="search button" type="submit">
                <IoSearchOutline />
                </button>
            </form>
        </div>
        {categories.length > 0 && (
            <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Categories </h2>
            <ul class="widget__categories--menu">
                {categories.map((category, index) => (
                <li class="widget__categories--menu__list">
                    <Link href={route('blogCategory',category.slug?category.slug:'no-title')} class="widget__categories--menu__label d-flex align-items-center p-3">
                        <span class="widget__categories--menu__text">{category.name}</span>
                    </Link>
                </li>
                ))}
            </ul>
        </div>
        )}
        
        <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Post Article </h2>
            <div class="product__grid--inner">
                {recentBlogs.map((blog, index) => (
                    <div class="product__items product__items--grid d-flex align-items-center" key={index}>
                    <div class="product__items--grid__thumbnail position__relative">
                        <Link class="product__items--link" href={route('blogView',blog.slug?blog.slug:'no-title')}>
                            <img class="product__grid--items__img product__primary--img" src={blog.image_url} alt={blog.name} />
                            <img class="product__grid--items__img product__secondary--img" src={blog.image_url} alt={blog.name} />
                        </Link>
                    </div>
                    <div class="product__items--grid__content">
                        <h3 class="product__items--content__title h4"><Link href={route('blogView',blog.slug?blog.slug:'no-title')}>{blog.name}</Link></h3>
                        <span class="meta__deta">{blog.createdAt}</span>
                    </div>
                </div>
                ))}
            </div>
        </div>
        {/* <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Tags </h2>
            <ul class="widget__tagcloud">
                {tags.map((tag, index) => (
                    <li key={index} class="widget__tagcloud--list"><Link class="widget__tagcloud--link" href={route('blogTag',tag.slug?tag.slug:'no-title')}>{tag.name}</Link></li>
                ))}
            </ul>
        </div> */}
    </div>
  )
}
