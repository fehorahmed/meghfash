import OfferCountDown from '@/Components/Home/OfferCountDown'
import ProductGrid from '@/Components/products/ProductGrid'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useState } from 'react'
import { BsArrowRight } from 'react-icons/bs'
import { CiHeart } from 'react-icons/ci'
import { IoIosSearch } from 'react-icons/io'
import { IoCartOutline, IoEyeOutline } from 'react-icons/io5'

export default function ProductAll({
    general,
    headerMenu,
    footerMenu2,
    footerMenu4,
    footerMenu3,
    categoryMenu,
    auth,
    products,
    page,
}) {
    
    // State to toggle submenu visibility
    const [isSubmenuOpen, setIsSubmenuOpen] = useState(true);
    const [isFabricOpen, setIsFabricOpen] = useState(true);
    const [isSizeOpen, setIsSizeOpen] = useState(true);
    const [isFitOpen, setIsFitOpen] = useState(true);

    // Toggle function
    const handleToggleSubmenu = () => {
        setIsSubmenuOpen(!isSubmenuOpen);
    };

    // Fabric Toggle function
    const handleToggleFabric = () => {
        setIsFabricOpen(!isFabricOpen);
    };

    // Size Toggle function
    const handleToggleSize = () => {
        setIsSizeOpen(!isSizeOpen);
    };

    // Fit Toggle function
    const handleToggleFit = () => {
        setIsFitOpen(!isFitOpen);
    };



  return (
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


        <section className="breadcrumb__section">
             <div className="container">
                 <div className="row row-cols-1">
                     <div className="col">
                         <div className="breadcrumb__content text-center">
                             <h1 className="breadcrumb__content--title mb-25">{page.name}</h1>
                             <ul className="breadcrumb__content--menu d-flex justify-content-center">
                                 <li className="breadcrumb__content--menu__items"><a href={route('index')}>Home </a></li>
                                 <li className="breadcrumb__content--menu__items"><span>{page.name}</span></li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </section>

         <section class="cgtPageDiscountBanner">
             <div class="container-fluid">
                 <div class="deals__banner--inner banner__bg ctgDiscountBg">
                     <div class="row row-cols-1 align-items-center">
                         <div class="col">
                             <div class="deals__banner--content position__relative">
                                 <h2 class="deals__banner--content__maintitle">FLAT 50% OFF</h2>
                                <OfferCountDown date="2025-05-05"/>
                                 <Link class="primary__btn" href="#">Show Collection
                                    <BsArrowRight />
                                 </Link>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>

        <section className="shop__section section--padding">
            <div className="container-fluid">
                <div className="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                    <button className="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas="">
                        <span className="widget__filter--btn__text">Filter </span>
                    </button>
                    <div className="product__view--mode d-flex align-items-center">
                        <div className="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
                            <label className="product__view--label">Prev Page : </label>
                            <div className="select shop__header--select">

                                    <select className="form-select product__view--select" >
                                        <option selected> 65  </option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>

                            </div>
                        </div>
                        <div className="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
                            <label className="product__view--label">Sort By : </label>
                            <div className="select shop__header--select">
                            <select className="form-select product__view--select" >
                                        <option selected>Sort by latest </option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                

                            </div>
                        </div>
                        <div className="product__view--mode__list product__view--search d-none d-lg-block">
                            <form className="product__view--search__form" action="#">
                                <label>
                                    <input className="product__view--search__input border-0" placeholder="Search by" type="text" />
                                </label>
                                <button className="product__view--search__btn" aria-label="shop button" type="submit">
                                <IoIosSearch />
                                </button>
                            </form>
                        </div>
                    </div>
                    <p className="product__showing--count">Showing 1–9 of 21 results </p>
                </div>
                <div className="row">
                     <div className="col-xl-3 col-lg-4">
                         <div className="shop__sidebar--widget widget__area ">

                             <div className="single__widget widget__bg">
                                <h2 className="widget__title h3">Categories</h2>
                                <ul className="widget__categories--menu">
                                    <li className="widget__categories--menu__list">
                                        <label
                                            className="widget__categories--menu__label d-flex align-items-center"
                                            onClick={handleToggleSubmenu} // Toggle on click
                                            style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                                        >
                                            <img
                                                className="widget__categories--menu__img"
                                                src="/images/img/product/small-product1.png"
                                                alt="categories-img"
                                            />
                                            <span className="widget__categories--menu__text">
                                                Denim Jacket
                                            </span>
                                            <svg
                                                className={`widget__categories--menu__arrowdown--icon ${
                                                    isSubmenuOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                                                }`}
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="12.355"
                                                height="8.394"
                                            >
                                                <path
                                                    d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                                    transform="translate(-6 -8.59)"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </label>
                                        {isSubmenuOpen && ( // Conditionally render submenu
                                            <ul className={`widget__categories--sub__menu ${
                                                isSubmenuOpen ? "open" : ""
                                            }`}>
                                              
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <label className="widget__form--check__label" for="flexCheckDefault26" >
                                                        <img
                                                            className="widget__categories--sub__menu--img"
                                                            src="/images/img/product/small-product2.png"
                                                            alt="categories-img"
                                                        />
                                                       Jacket, Women
                                                    </label>
                                                
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault26" />
                                                    </div>
                                                </li>
                                                
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <label className="widget__form--check__label" for="flexCheckDefault27" >
                                                    <img
                                                            className="widget__categories--sub__menu--img"
                                                            src="/images/img/product/small-product3.png"
                                                            alt="categories-img"
                                                        />
                                                       Woolend Jacket
                                                    </label>
                                                
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault27" />
                                                    </div>
                                                </li>

                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <label className="widget__form--check__label" for="flexCheckDefault28" >
                                                    <img
                                                            className="widget__categories--sub__menu--img"
                                                            src="/images/img/product/small-product4.png"
                                                            alt="categories-img"
                                                        />
                                                        Western denim
                                                    </label>
                                                
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault28" />
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <label className="widget__form--check__label" for="flexCheckDefault29" >
                                                    <img
                                                            className="widget__categories--sub__menu--img"
                                                            src="/images/img/product/small-product5.png"
                                                            alt="categories-img"
                                                        />
                                                        Mini Dress
                                                    </label>
                                                
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault29" />
                                                    </div>
                                                </li>

                                            </ul>
                                        )}
                                    </li>
                                </ul>
                            </div>


                            <div className="single__widget widget__bg">
                                 <h2 className="widget__title h3">Color </h2>
                                 <ul className="widget__form--check">
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault6" >
                                            <span style={{backgroundColor: "black"}} className="colorBox"></span>
                                            Black
                                        </label>
                                       
                                         <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault6" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault7">
                                         <span style={{backgroundColor: "blue"}} className="colorBox"></span>
                                            Blue 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault7" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric" >
                                         <label className="widget__form--check__label" for="flexCheckDefault8">
                                         <span style={{backgroundColor: "brown"}} className="colorBox"></span>
                                            Brown 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault8" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault9">
                                         <span style={{backgroundColor: "red"}} className="colorBox"></span>
                                            Red 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault9" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric" >
                                         <label className="widget__form--check__label" for="flexCheckDefault10">
                                         <span style={{backgroundColor: "white", border: '1px solid lightgray'}} className="colorBox"></span>
                                            White 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault10" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault11">
                                         <span style={{backgroundColor: "cyan"}} className="colorBox"></span>
                                         Cyan 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault11" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault12">
                                         <span style={{backgroundColor: "green"}} className="colorBox"></span>
                                         Green 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault12" />
                                        </div>
                                     </li>
                                     <li className="widget__form--check__list fabric">
                                         <label className="widget__form--check__label" for="flexCheckDefault13">
                                         <span style={{backgroundColor: "yellow"}} className="colorBox"></span>
                                         Yellow 
                                        </label>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault13" />
                                        </div>
                                     </li>
                                 </ul>
                             </div>

                             <div className="single__widget price__filter widget__bg">
                                 <h2 className="widget__title h3">Filter By Price </h2>
                                 <form className="price__filter--form" action="#"> 
                                     <div className="price__filter--form__inner mb-15 d-flex align-items-center">
                                         <div className="price__filter--group">
                                             <label className="price__filter--label" for="Filter-Price-GTE2">From </label>
                                             <div className="price__filter--input border-radius-5 d-flex align-items-center">
                                                 <span className="price__filter--currency">Tk </span>
                                                 <label>
                                                     <input className="price__filter--input__field border-0" name="filter.v.price.gte" type="number" placeholder="0" min="0" max="250.00" />
                                                 </label>
                                             </div>
                                         </div>
                                         <div className="price__divider">
                                             <span>- </span>
                                         </div>
                                         <div className="price__filter--group">
                                             <label className="price__filter--label" for="Filter-Price-LTE2">To </label>
                                             <div className="price__filter--input border-radius-5 d-flex align-items-center">
                                                 <span className="price__filter--currency">Tk </span>
                                                 <label>
                                                     <input className="price__filter--input__field border-0" name="filter.v.price.lte" type="number" min="0" placeholder="250.00" max="250.00" /> 
                                                 </label>
                                             </div>	
                                         </div>
                                     </div>
                                     <button className="price__filter--btn primary__btn" type="submit">Filter </button>
                                 </form>
                             </div>

                             <div className="single__widget widget__bg">
                                <h2 className="widget__title h3">Fabric</h2>
                                <ul className="widget__categories--menu">
                                    <li className="widget__categories--menu__list">
                                        <label
                                            className="widget__categories--menu__label d-flex align-items-center"
                                            onClick={handleToggleFabric} // Toggle on click
                                            style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                                        >
                                            <img
                                                className="widget__categories--menu__img"
                                                src="/images/img/product/small-product1.png"
                                                alt="categories-img"
                                            />
                                            <span className="widget__categories--menu__text">
                                            Fabric
                                            </span>
                                            <svg
                                                className={`widget__categories--menu__arrowdown--icon ${
                                                    isFabricOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                                                }`}
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="12.355"
                                                height="8.394"
                                            >
                                                <path
                                                    d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                                    transform="translate(-6 -8.59)"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </label>
                                        {isFabricOpen && ( // Conditionally render submenu
                                            <ul className={`widget__categories--sub__menu ${
                                                isFabricOpen ? "open" : ""
                                            }`}>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                                        <label className="form-check-label" for="flexCheckDefault">
                                                            Cotton
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric ">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault1" />
                                                        <label className="form-check-label" for="flexCheckDefault1">
                                                            Handloom Cotton
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric ">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault2" />
                                                        <label className="form-check-label" for="flexCheckDefault2">
                                                            Mixed Cotton
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault3" />
                                                        <label className="form-check-label" for="flexCheckDefault3">
                                                            Mixed Viscose
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault4" />
                                                        <label className="form-check-label" for="flexCheckDefault4">
                                                        Viscose
                                                        </label>
                                                    </div>
                                                </li>
                                              
                                            </ul>
                                        )}
                                    </li>
                                </ul>
                            </div>


                             <div className="single__widget widget__bg">
                                <h2 className="widget__title h3">Size</h2>
                                <ul className="widget__categories--menu">
                                    <li className="widget__categories--menu__list">
                                        <label
                                            className="widget__categories--menu__label d-flex align-items-center"
                                            onClick={handleToggleSize} // Toggle on click
                                            style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                                        >
                                            <img
                                                className="widget__categories--menu__img"
                                                src="/images/img/product/small-product1.png"
                                                alt="categories-img"
                                            />
                                            <span className="widget__categories--menu__text">
                                            Size
                                            </span>
                                            <svg
                                                className={`widget__categories--menu__arrowdown--icon ${
                                                    isSizeOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                                                }`}
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="12.355"
                                                height="8.394"
                                            >
                                                <path
                                                    d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                                    transform="translate(-6 -8.59)"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </label>
                                        {isSizeOpen && ( // Conditionally render submenu
                                            <ul className={`widget__categories--sub__menu ${
                                                isSizeOpen ? "open" : ""
                                            }`}>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault14" />
                                                        <label className="form-check-label" for="flexCheckDefault14">
                                                            36
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric ">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault15" />
                                                        <label className="form-check-label" for="flexCheckDefault15">
                                                           38
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric ">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault16" />
                                                        <label className="form-check-label" for="flexCheckDefault16">
                                                            40
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault17" />
                                                        <label className="form-check-label" for="flexCheckDefault17">
                                                           42
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault18" />
                                                        <label className="form-check-label" for="flexCheckDefault18">
                                                       44
                                                        </label>
                                                    </div>
                                                </li>
                                              
                                            </ul>
                                        )}
                                    </li>
                                </ul>
                            </div>

                             <div className="single__widget widget__bg">
                                <h2 className="widget__title h3">Cut /Fit</h2>
                                <ul className="widget__categories--menu">
                                    <li className="widget__categories--menu__list">
                                        <label
                                            className="widget__categories--menu__label d-flex align-items-center"
                                            onClick={handleToggleFit} // Toggle on click
                                            style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                                        >
                                            <img
                                                className="widget__categories--menu__img"
                                                src="/images/img/product/small-product1.png"
                                                alt="categories-img"
                                            />
                                            <span className="widget__categories--menu__text">
                                            Cut /Fit
                                            </span>
                                            <svg
                                                className={`widget__categories--menu__arrowdown--icon ${
                                                    isFitOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                                                }`}
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="12.355"
                                                height="8.394"
                                            >
                                                <path
                                                    d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                                    transform="translate(-6 -8.59)"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </label>
                                        {isFitOpen && ( // Conditionally render submenu
                                            <ul className={`widget__categories--sub__menu ${
                                                isFitOpen ? "open" : ""
                                            }`}>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault20" />
                                                        <label className="form-check-label" for="flexCheckDefault20">
                                                        Regular Fit
                                                        </label>
                                                    </div>
                                                </li>
                                                <li className="widget__categories--sub__menu--list fabric">
                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault21" />
                                                        <label className="form-check-label" for="flexCheckDefault21">
                                                        Slim Fit
                                                        </label>
                                                    </div>
                                                </li>
                                               
                                            </ul>
                                        )}
                                    </li>
                                </ul>
                            </div>

                             <div className="single__widget widget__bg">
                                 <h2 className="widget__title h3">Top Rated Product </h2>
                                 <div className="product__grid--inner">
                                     <div className="product__items product__items--grid d-flex align-items-center">
                                         <div className="product__items--grid__thumbnail position__relative">
                                             <a className="product__items--link" href="product-details.html">
                                                 <img className="product__items--img product__primary--img" src="/images/img/product/small-product1.png" alt="product-img" />
                                                 <img className="product__items--img product__secondary--img" src="/images/img/product/small-product2.png" alt="product-img" />
                                             </a>
                                         </div>
                                         <div className="product__items--grid__content">
                                             <h3 className="product__items--content__title h4"><a href="product-details.html">Women Fish Cut </a></h3>
                                             <div className="product__items--price">
                                                 <span className="current__price">Tk 110 </span>
                                                 <span className="price__divided"></span>
                                                 <span className="old__price">Tk 78 </span>
                                             </div>
                                             <ul className="rating product__rating d-flex">
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                     <div className="product__items product__items--grid d-flex align-items-center">
                                         <div className="product__items--grid__thumbnail position__relative">
                                             <a className="product__items--link" href="product-details.html">
                                                 <img className="product__items--img product__primary--img" src="/images/img/product/small-product3.png" alt="product-img" />
                                                 <img className="product__items--img product__secondary--img" src="/images/img/product/small-product4.png" alt="product-img" />
                                             </a>
                                         </div>
                                         <div className="product__items--grid__content">
                                             <h3 className="product__items--content__title h4"><a href="product-details.html">Gorgeous Granite is </a></h3>
                                             <div className="product__items--price">
                                                 <span className="current__price">Tk 140 </span>
                                                 <span className="price__divided"></span>
                                                 <span className="old__price">Tk 115 </span>
                                             </div>
                                             <ul className="rating product__rating d-flex">
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                                 <li className="rating__list">
                                                     <span className="rating__list--icon">
                                                         <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                         <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                         </svg>
                                                     </span>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                     <div className="product__items product__items--grid d-flex align-items-center">
                                         <div className="product__items--grid__thumbnail position__relative">
                                             <a className="product__items--link" href="product-details.html">
                                                 <img className="product__items--img product__primary--img" src="/images/img/product/small-product5.png" alt="product-img" />
                                                 <img className="product__items--img product__secondary--img" src="/images/img/product/small-product6.png" alt="product-img" />
                                             </a>
                                         </div>
                                         <div className="product__items--grid__content">
                                             <h4 className="product__items--content__title"><a href="product-details.html">Durable A Steel  </a></h4>
                                             <div className="product__items--price">
                                                 <span className="current__price">Tk 160 </span>
                                                 <span className="price__divided"></span>
                                                 <span className="old__price">Tk 118 </span>
                                             </div>
                                                <ul className="rating product__rating d-flex">
                                                             <li className="rating__list">
                                                                 <span className="rating__list--icon">
                                                                     <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                                     <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                     </svg>
                                                                 </span>
                                                             </li>
                                                             <li className="rating__list">
                                                                 <span className="rating__list--icon">
                                                                     <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                                     <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                     </svg>
                                                                 </span>
                                                             </li>
                                                             <li className="rating__list">
                                                                 <span className="rating__list--icon">
                                                                     <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                                     <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                     </svg>
                                                                 </span>
                                                             </li>
                                                             <li className="rating__list">
                                                                 <span className="rating__list--icon">
                                                                     <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                                     <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                     </svg>
                                                                 </span>
                                                             </li>
                                                             <li className="rating__list">
                                                                 <span className="rating__list--icon">
                                                                     <svg className="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                                     <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                     </svg>
                                                                 </span>
                                                             </li>
                                                </ul>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div className="single__widget widget__bg">
                                 <h2 className="widget__title h3">Brands </h2>
                                 <ul className="widget__tagcloud">
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Jacket </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Women </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Oversize </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Cotton  </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Shoulder  </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Winter </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Accessories </a></li>
                                     <li className="widget__tagcloud--list"><a className="widget__tagcloud--link" href="shop.html">Dress  </a></li>
                                 </ul>
                             </div>


                         </div>
                     </div>
                     <div className="col-xl-9 col-lg-8">
                                    
                        <div className="shop__product--wrapper">
                        {products.data.length > 0 ?(
                            <div>
                            <div className="product__section--inner product__grid--inner">
                                <div className="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                   {products.map((product, index) => (
                                    <div className="col mb-30" key={index}>
                                        <ProductGrid product={product} />
                                    </div>
                                    ))}
                                </div>
                            </div>
                            <div className="pagination__area bg__gray--color">
                                 <nav className="pagination justify-content-center">
                                     <ul className="pagination__wrapper d-flex align-items-center justify-content-center">
                                         <li className="pagination__list">
                                             <a href="shop.html" className="pagination__item--arrow  link ">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewbox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292"></path></svg>
                                                 <span className="visually-hidden">pagination arrow </span>
                                             </a>
                                         </li><li>
                                         </li><li className="pagination__list"><span className="pagination__item pagination__item--current">1 </span></li>
                                         <li className="pagination__list"><a href="shop.html" className="pagination__item link">2 </a></li>
                                         <li className="pagination__list"><a href="shop.html" className="pagination__item link">3 </a></li>
                                         <li className="pagination__list"><a href="shop.html" className="pagination__item link">4 </a></li>
                                         <li className="pagination__list">
                                             <a href="shop.html" className="pagination__item--arrow  link ">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewbox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100"></path></svg>
                                                 <span className="visually-hidden">pagination arrow </span>
                                             </a>
                                         </li><li>
                                     </li></ul>
                                 </nav>
                             </div>
                             </div>
                        ) : (
                            <div className="text-center">No products found</div>
                        )}

                        </div>
                     </div>
                </div>
            </div>
        </section>



    </MainLayout>
  )
}
