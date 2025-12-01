

import ProductGallery from "@/Components/products/ProductGallery";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import Slider from "react-slick";
import { FaHeart, FaInstagram } from "react-icons/fa";
import { useEffect, useState } from "react";
import { FaFacebookF } from "react-icons/fa";
import { FaTwitter } from "react-icons/fa";
import { FaYoutube } from "react-icons/fa6";
import ProductReview from "@/Components/products/ProductReview";
import ProductGrid from "@/Components/products/ProductGrid";
import RatingStar from "@/Components/products/ratingStar";
import AlertMessageComponents from "@/Components/AlertMassageCompononets";
import { useCart } from "@/Context/CartContext";
import ProductSocialSear from "@/Components/products/ProductSocialSear";
import { MdOutlineShoppingCart } from "react-icons/md";
import { toast } from 'react-toastify';
import ProductCarousel from "@/Components/products/ProductCarousel";

export default function ProductDetail({ 
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    auth,
    reviews,
    selectVariation,
    product,
    meta,
    carts,
    relatedProducts
    }) {

        const {cart, initializeCart, addToCart, addToWishList,initializeWishList,wishList} = useCart();

        const [selectedVariants, setSelectedVariants] = useState(selectVariation);

        const [filteredVariation, setFilteredVariation] = useState(null);

        const [isStockOut, setIsStockOut] = useState(false);


        const [productQuantity, setProductQuantity] = useState(1);

        const [loading, setLoading] = useState(false);
        const [loading2, setLoading2] = useState(false);

        const [activeTab, setActiveTab] = useState('delivery');


        const queryParams = new URLSearchParams(window.location.search);
        const variant = queryParams.get('cart');

        useEffect(() => {
            if (variant) {
              toast.success("Please Select Size or Any Variant");
            }
          }, [variant]);


        const handleChange = (variationId, itemId) => {

            setSelectedVariants((prev) => ({
            ...prev,
            [variationId]: itemId.toString(),
            }));
        };

        const handleTabClick = (tabName) => {
          setActiveTab(tabName);
        };

        const handleSizeChange = (event) => {
            setSelectedSize(event.target.value); // Update the selected size state
            console.log("Selected Size:", event.target.value);
          };

        const handleColorChange = (event) => {
          setSelectedColor(event.target.value); // Update the selected color state
          console.log("Selected Color:", event.target.value);
        };


         useEffect(() => {
            initializeCart(carts); // Initialize cart data
        }, [carts]);


        const fbLayerAddToCart = (product) => {
            
            fbq('track', 'AddToCart', {
                content_ids: [product.id],
                content_name: product.name,
                content_type: 'product',
                value: parseInt(product.final_price, 10),
                currency: 'BDT',
                quantity: productQuantity
            });

        };

        const dataLayerAddToCart = (product) => {
            console.log(product.name);
            const itemCategory = product.ctgs
            ? product.ctgs.map((category) => category.name).join(", ")
            : null;

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: "add_to_cart",
                currency: general.currency,
                value: parseInt(product.final_price, 10),
                items: [
                    {
                        item_id: product.id, // Product ID
                        item_name: product.name, // Product Name
                        coupon: product.coupon || null, // Optional coupon 
                        discount: product.discount,
                        index: 0,
                        item_brand: product.brandName,
                        item_category: itemCategory,
                        item_variant: selectedVariants,
                        price: parseInt(product.final_price, 10),
                        quantity: productQuantity,

                    }
                ]
            });
            console.log('add to cart data layer');
        }

        const handleAddToCard = (id) => {

            dataLayerAddToCart(product);

            addToCart({
                product_id: id,
                quantity: productQuantity,
                option: selectedVariants, 
            });

            fbLayerAddToCart(product);

        }


        const handleBuyCard = (id) => {
            dataLayerAddToCart(product);
            addToCart({
                product_id: id,
                quantity: productQuantity,
                option: selectedVariants,
                ordernow: true,

            });
        }

        const handleWishList = (id) => {
            addToWishList(id)
        }

        var settings = {
            dots: false,
            infinite: true,
            autoplay: true,
            speed: 1000,
            slidesToShow: 4,
            slidesToScroll: 4,
            initialSlide: 0,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
                },
                {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    initialSlide: 2
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
            ]
            };


        useEffect(() => {
            initializeWishList(carts?.wlProducts); // Initialize cart data
        }, [carts?.wlProducts]);




        useEffect(() => {
        // Push data to the data layer


        // Extract category names dynamically
        const itemCategory = product.ctgs
        ? product.ctgs.map((category) => category.name).join(", ")
        : null;

       // Transform to the desired output
        const variantItem = product.variations.reduce((acc, variation) => {
            const validNames = variation.items;
            const itemName = validNames.map((vari) => vari.title).join(", ")
            acc.push(`${variation.title}: ${itemName}`); // Format the output as requested
            return acc;
        }, []);


        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "view_item",
            currency: general.currency,
            value: parseInt(product.final_price, 10),
            items: [
                {
                    item_id: product.id, // Product ID
                    item_name: product.name, // Product Name
                    coupon: product.coupon || null, // Optional coupon 
                    discount: product.discount,
                    index: 0,
                    item_brand: product.brandName,
                    item_category: itemCategory,
                    item_variant: variantItem,
                    price: parseInt(product.final_price, 10),
                    quantity: 1,

                }
            ]
        });

        if (typeof fbq === 'function') {
            fbq('track', 'ViewContent', {
                content_ids: [product.id],
                content_name: product.name,
                content_category: itemCategory,
                content_type: 'product',
                value: product.final_price,
                currency: 'BDT'
            });
        }

        }, [product]);



        const selectedVariantStock = product.variations.some(variation => {
            const selectedItemId = selectedVariants[variation.id]; // Get selected variant ID

            if (!selectedItemId) return false; // No variant selected
        
            const selectedItem = variation.items.find(item => item.id == selectedItemId);
            
            return selectedItem ? true : false;
        });

        const [availableSizes, setAvailableSizes] = useState([]);

        useEffect(() => {
            if (!product.variationDatas || !product.variationDatas.length) return;
          
            // Get selected attribute IDs
            const selectedItemIds = Object.values(selectedVariants);
          
            // Find selected color from "Colour" variation
            const colorVariation = product.variations.find((v) => v.title === "Colour");
            const selectedColorId = selectedVariants[colorVariation?.id];
          
            // Filter variations by the selected color
            const colorVariations = product.variationDatas.filter((variation) =>
              variation.items.some((item) => item.attribute_item_id.toString() === selectedColorId)
            );
          
            // Get size variation
            const sizeVariation = product.variations.find((v) => v.title === "Size");
          
            // Extract available sizes for the selected color
            const newAvailableSizes = colorVariations.flatMap((variation) =>
              variation.items
                .filter((item) =>
                  sizeVariation?.items.some((size) => size.id === item.attribute_item_id)
                )
                .map((item) => item.attribute_item_id)
            );
          
            setAvailableSizes(newAvailableSizes);
          
            if (selectedColorId && sizeVariation && 
                (!selectedVariants[sizeVariation.id] || 
                 !newAvailableSizes.includes(Number(selectedVariants[sizeVariation.id])))) {
              
              const firstAvailableSize = sizeVariation.items.find(item => 
                newAvailableSizes.includes(item.id)
              );
          
              if (firstAvailableSize) {
                setSelectedVariants(prev => ({
                  ...prev,
                  [sizeVariation.id]: firstAvailableSize.id.toString()
                }));
              }
            }
          
            // Set the matching variation
            const matchingVariation = product.variationDatas.find((variation) =>
              variation.items.every((item) =>
                selectedItemIds.includes(item.attribute_item_id.toString())
              )
            );
          
            setFilteredVariation(matchingVariation);
            setIsStockOut(!(matchingVariation?.stock_status && matchingVariation?.quantity > 0));
          
          }, [selectedVariants, product.variationDatas]);



          const stock = (product) =>{
                if(product.quantity > 0){
                    return true;
                }else{
                    return false;
                }

          }

          const stockCheck = stock(product);



          useEffect(() => {
            if (filteredVariation && productQuantity !== null) {
                if (productQuantity > filteredVariation.quantity) {
                    setIsStockOut(true); // Stock is out
                } else {
                    setIsStockOut(false); // Stock is available
                }
            }
        }, [productQuantity, filteredVariation]);


          const handleIncrement = () => {
            const newQuantity = productQuantity + 1;
            setProductQuantity(newQuantity);
        
            if (newQuantity > filteredVariation.quantity) {
                setIsStockOut(true); // Stock is out
            } else {
                setIsStockOut(false); // Stock is available
            }
        };
        

        const handleDecrement = () => {
            if (productQuantity > 1) {
                const newQuantity = productQuantity - 1;
                setProductQuantity(newQuantity);
                if (newQuantity <= filteredVariation.quantity) {
                    setIsStockOut(false); // Stock is still available
                }
            }
        };


console.log(product);




  return (
    <>

        <style>
            {`
                @media only screen and (max-width: 768px) {
                ul.breadcrumb__content--menu {
                        display: none !important;
                }
                }
            `}
        </style>

         <MainLayout
                auth={auth}
                general={general}
                headerMenu={headerMenu}
                footerMenu4={footerMenu4}
                footerMenu3={footerMenu3}
                footerMenu2={footerMenu2}
                categoryMenu={categoryMenu}
                carts={carts}
               
            >
                {/* <Head title={product.seo_title?product.seo_title:product.name}>
                    <meta name="title" property="og:title" content={product.seo_title?product.seo_title:product.name} />
                    <meta name="description" property="og:description" content={product.seo_description?product.seo_description:general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={product.seo_keyword?product.seo_keyword:general.meta_keyword}/>
                    <meta name="image" property="og:image" content={product.image_url} />
                    <meta name="url" property="og:url" content={route('productView', product.slug ? product.slug : 'no-title')} />
                    <link rel="canonical" href={route('productView', product.slug ? product.slug : 'no-title')} />
                </Head> */}

            <Head>
                <title>{meta?.title}</title>
                <meta name="title" property="og:title" content={meta?.title} />
                <meta name="description" property="og:description" content={meta?.description} />
                <meta name="keyword" property="og:keyword" content={meta?.keywords} />
                <meta name="image" property="og:image" content={meta?.image} />
                <meta name="url" property="og:url" content={meta?.url} />
                <link rel="canonical" href={meta?.url} />
                <meta property="product:brand" content={meta?.brand} /> 
                <meta property="product:availability" content={meta?.stock} /> 
                <meta property="product:condition" content={meta?.condition} /> 
                <meta property="product:price:amount" content={meta?.price} /> 
                <meta property="product:price:currency" content={meta?.currency} /> 
                <meta property="product:retailer_item_id" content={meta?.retailer_item_id} />
            </Head>


                <section className="product__details--section section--padding pt-3">
                    <div className="container-fluid">
                        
                        <div className="row">
                            <div className="col-md-6">
                            {/* <ProductGallery images={product.images} product={product} /> */}
                            <ProductCarousel images={product.images} product={product} />
   
                            </div>   
                            <div className="col-md-6">
                                <div className="product__details--info">
                                    <ul className="CategoryBread">
                                        <li><Link  href={route('index')}>Home </Link></li>
                                        
                                        {product.ctgs.length > 0 && 
                                            <>
                                                
                                                {product.ctgs.map((ctg) => (
                                                    <>
                                                    <li>/</li>
                                                    <li><Link href={route('productCategory', ctg.slug ? ctg.slug : 'no-title')}>{ctg.name} </Link></li>
                                                    </>
                                                ))}
                                            
                                            </>
                                        }
                                    </ul>
                                    <form>
                                        <h2 className="product__details--info__title mb-15">{product.name}</h2>
                                        <div className="product__details--info__price mb-10">

                                            <span className="current__price">{product.finalPrice}</span>

                                            {product.regularPrice && (
                                                <>
                                                <span className="price__divided"></span>
                                                <span className="old__price">{product.regularPrice}</span>
                                                </>
                                            )}
                                        </div>
                                        <div className="product__details--info__rating d-flex align-items-center mb-15">
                                            
                                            <RatingStar rating={product.rating} />
                                            <span className="product__items--rating__count--number">({product.totalReview}) </span>
                                        </div>
                         
                                        {product.short_description &&
                                        <p className="product__details--info__desc mb-15">
                                        {product.short_description}
                                        </p>
                                        }


                                            <div className="ProductCode">
                                                <p><b>Code : {product.id}</b></p>
                                            </div>

                                                <div className="product__tab--content__step mb-30 tableSpecification">
                                                    {product.specifications.length > 0 && (
                                                        <div className="table-responsive ">
                                                        <p><b style={{color: "black"}}>Specification : </b></p>
                                                        <table className="table">
                                                            {product.specifications.map((specification, index) => (
                                                                <tr>
                                                                <th style={{width: "150px",maxWidth: "150px"}}>{specification.name}</th>
                                                                <td>
                                                                    {Array.isArray(specification.values) ? (
                                                                        specification.values.map((value, index) => (
                                                                            <span key={index}>{value.name}</span>
                                                                        ))
                                                                    ) : (
                                                                        <span>{specification.value}</span>
                                                                    )}
                                                                </td>
                                                            </tr>
                                                            ))}
                                                        </table>
                                                    </div>
                                                    )}
                                                </div>
                                        


                                        {variant && 
                                            <p className="variant">Please select Variant</p>
                                        }

                                        {/* {!selectedVariantStock && <p className="out-of-stock">Out of Stock</p>} */}
                                        {!stockCheck && <p className="out-of-stock">Out of Stock</p>}

                             

                                        <div className="product__variant">

                                      

                                        {/* {product.variations.length > 0 && (
                                            <>
                                                {product.variations.map((variation) => (
                                                    <div key={variation.id} className="product__variant--list mb-10">
                                                        <fieldset className="variant__input--fieldset">
                                                        <legend className="product__variant--title mb-8">{variation.title}</legend>

                                                        {variation.items.map((item) => {
                                                            const isActive = selectedVariants[variation.id] === item.id.toString();

                                                            // Disable sizes if not available
                                                            const isDisabled =
                                                            variation.title === "Size" && !availableSizes.includes(item.id);


                                                             // Debugging logs
                                                        console.log("Variation Title:", variation.title);
                                                        console.log("Available Sizes:", availableSizes);

                                                            return (
                                                            <div key={item.id} style={{ display: "inline-block", marginRight: "10px" }}>
                                                                <input
                                                                id={`variant-${item.id}`}
                                                                name={variation.id}
                                                                value={item.id}
                                                                type="radio"
                                                                checked={isActive}
                                                                // disabled={isDisabled} // Disable unavailable items
                                                                onChange={() => handleChange(variation.id, item.id)}
                                                                />

                                                                {variation.type === 3 ? (
                                                                <label
                                                                    className={`variant__color--value ${isActive ? "active" : ""} ${
                                                                    isDisabled ? "disabled" : ""
                                                                    }`}
                                                                    htmlFor={`variant-${item.id}`}
                                                                    title={item.title}
                                                                >
                                                                    <img
                                                                    className="variant__color--value__img"
                                                                    src={item.title}
                                                                    alt={item.title}
                                                                    />
                                                                </label>
                                                                ) : (
                                                                <label
                                                                    className={`variant__size--value ${isActive ? "active" : ""} ${
                                                                    isDisabled ? "disabled" : ""
                                                                    }`}
                                                                    htmlFor={`variant-${item.id}`}
                                                                >
                                                                    {item.title}
                                                                </label>
                                                                )}
                                                            </div>
                                                            );
                                                        })}
                                                        </fieldset>
                                                    </div>
                                                ))}
                                            </>

                                        )} */}


                                    {product.variations.length > 0 && (
                                    <>
                                        {product.variations.map((variation) => (
                                        <div key={variation.id} className="product__variant--list mb-10">
                                            <fieldset className="variant__input--fieldset">
                                            <legend className="product__variant--title mb-8">{variation.title}</legend>

                                            {variation.items.map((item) => {

                                                const isActive = selectedVariants[variation.id] === item.id.toString();

                                                // Determine if a color variation exists
                                                const colorVariation = product.variations.find((v) => v.title === "Colour");

                                                // Disable sizes only if a color is selected AND the variation is "Size"
                                                const isDisabled =
                                                colorVariation && // Check if a color variation exists
                                                selectedVariants[colorVariation?.id] && // Check if a color is selected
                                                variation.title === "Size" &&
                                                !availableSizes.includes(Number(item.id)); // Convert item.id to a number

                                               
                                                return (
                                                <div key={item.id} style={{ display: "inline-block", marginRight: "5px" }}>
                                                    <input
                                                    id={`variant-${item.id}`}
                                                    name={variation.id}
                                                    value={item.id}
                                                    type="radio"
                                                    checked={isActive}
                                                    disabled={isDisabled} // Apply the disable logic
                                                    onChange={() => handleChange(variation.id, item.id)}
                                                    />

                                                    {variation.type === 3 ? (
                                                    <label
                                                        className={`variant__color--value ${isActive ? "active" : ""} ${
                                                        isDisabled ? "disabled" : ""
                                                        }`}
                                                        htmlFor={`variant-${item.id}`}
                                                        title={item.title}
                                                    >
                                                        <img
                                                        className="variant__color--value__img"
                                                        src={item.title}
                                                        alt={item.title}
                                                        />
                                                    </label>
                                                    ) : (
                                                    <label
                                                        className={`variant__size--value ${isActive ? "active" : ""} ${
                                                        isDisabled ? "disabled" : ""
                                                        }`}
                                                        htmlFor={`variant-${item.id}`}
                                                    >
                                                        {item.title}
                                                    </label>
                                                    )}
                                                </div>
                                                );
                                            })}
                                            </fieldset>
                                        </div>
                                        ))}
                                    </>
                                    )}


                           
                                {filteredVariation && stockCheck ? (
                                        <div>
                                        <p className="mb-4" style={{color: "green"}}>
                                            {filteredVariation.stock_status && isStockOut == false
                                            ?  <p className="mb-4"  style={{ color: "green" }}> Stock In</p>: 
                                            <p className="mb-4"  style={{ color: "red" }}>Out of Stock</p>
                                            }
                                            </p>
                                     
                                        </div>
                                    ) : (
                                       ''
                                    )}
                              


                            {/* {isStockOut && <p style={{ color: "red" }}>Out of Stock</p>} */}

                                            <div className="product__variant--list quantity d-flex align-items-center mb-20">
                                                <div className="quantity__box">
                                                    <button onClick={handleDecrement} type="button" className="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">- </button>
                                                    <label>
                                                        <input type="number" className="quantity__number quickview__value--number" value={productQuantity} />
                                                    </label>
                                                    <button onClick={handleIncrement} type="button" className="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+ </button>
                                                </div>
                                                <button className="quickview__cart--btn primary__btn" disabled={!stockCheck || isStockOut} type="button" onClick={() => handleAddToCard(product.id)}>Add to Cart</button>   
                                                {/* <button className="quickview__cart--btn primary__btn" type="button" onClick={() => handleAddToCard(product.id)}>Add to Cart</button>    */}
                                                <button className="quickview__cart--btn primary__btn wishList" type="button" onClick={() => handleWishList(product.id)}> Add to Wishlist</button>  

                                            </div>
                                            <div className="productContactInfo">
                                                <p> <b>Contact:</b> {product.productContact}</p>
                                            </div>
                                            <div className="product__variant--list mb-15">
                                                <button  disabled={!stockCheck || isStockOut}  className="variant__buy--now__btn primary__btn" onClick={() => handleBuyCard(product.id)} type="button">{loading2 ? "Adding..." : "Buy it now"}</button>
                                                {/* <button    className="variant__buy--now__btn primary__btn" onClick={() => handleBuyCard(product.id)} type="button">{loading2 ? "Adding..." : "Buy it now"}</button> */}
                                            </div>
                                            <div className="product__details--info__meta">
                                                {product.sku_code && (
                                                    <p className="product__details--info__meta--list"><strong>SKU: </strong>   <span>{product.sku_code} </span>  </p>
                                                )}  
                                                {product.brandName && (
                                                <p className="product__details--info__meta--list"><strong>Brand: </strong>   <span>{product.brandName} </span>  </p>
                                                )}  
                                                {/* <p className="product__details--info__meta--list"><strong>Vendor: </strong>   <span>Belo </span>  </p>
                                                <p className="product__details--info__meta--list"><strong>Status: </strong>   <span>Dress </span>  </p> */}
                                            </div>
                                        </div>

                                        {/* <div className="quickview__social d-flex align-items-center mb-15">
                                            <label className="quickview__social--title">Social Share: </label>
                                            <ul className="quickview__social--wrapper mt-0 d-flex">
                                                <li className="quickview__social--list">
                                                    <a className="quickview__social--icon" target="_blank"
                                                    onClick={() => handleShare('facebook')}
                                                    >
                                                        <FaFacebookF />
                                                        <span className="visually-hidden">Facebook </span>
                                                    </a>
                                                </li>
                                                <li className="quickview__social--list">
                                                    <a className="quickview__social--icon" target="_blank" href="https://twitter.com">
                                                       <FaTwitter />
                                                        <span className="visually-hidden">Twitter </span>
                                                    </a>
                                                </li>
                                                <li className="quickview__social--list">
                                                    <a className="quickview__social--icon" target="_blank" href="https://www.instagram.com">
                                                       <FaInstagram />
                                                        <span className="visually-hidden">Instagram </span> 
                                                    </a>
                                                </li>
                                                <li className="quickview__social--list">
                                                    <a className="quickview__social--icon" target="_blank" href="../../../../www.youtube.com/supported_browsers_c942f037.html">
                                                       <FaYoutube />
                                                        <span className="visually-hidden">Youtube </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> */}

                                        <ProductSocialSear product={product} />

                                        <div className="guarantee__safe--checkout">
                                            <h5 className="guarantee__safe--checkout__title">Guaranteed Safe Checkout </h5>
                                            <img className="guarantee__safe--checkout__img" src="/images/SSLCommerz-Pay.png" alt="Payment Image" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="product__details--tab__section section--padding">
                    <div className="container-fluid">
                        <div className="row row-cols-1">
                            <div className="col">
                             
                                 <ul className="product__details--tab d-flex mb-30">
                                     
                                 
                                    <li
                                    className={`product__details--tab__list ${activeTab === 'delivery' ? 'active' : ''}`}
                                    onClick={() => handleTabClick('delivery')}
                                    >
                                    Delivery System
                                    </li>
                                       
                                    <li
                                    className={`product__details--tab__list ${activeTab === 'description' ? 'active' : ''}`}
                                    onClick={() => handleTabClick('description')}
                                    >
                                    Description
                                    </li>
                                    <li
                                    className={`product__details--tab__list ${activeTab === 'reviews' ? 'active' : ''}`}
                                    onClick={() => handleTabClick('reviews')}
                                    >
                                    Product Reviews
                                    </li>
                                    {product.sizeCart &&
                                 
                                    <li
                                    className={`product__details--tab__list ${activeTab === 'sizechart' ? 'active' : ''}`}
                                    onClick={() => handleTabClick('sizechart')}
                                    >
                                    Size Chart
                                    </li>
                                       }
                              
                                </ul>

                                <div className="product__details--tab__inner border-radius-10">
                                    <div className="tab_content">
                                        <div
                                            id="delivery"
                                            className={`tab_pane ${activeTab === 'delivery' ? 'active show' : ''}`}
                                        >
                                            <div className="product__tab--content">
                                               <p>
                                                 <div dangerouslySetInnerHTML={{ __html: product.deliverySystem}}></div> 
                                               </p>
                                            </div> 
                                        </div>
                                        <div
                                            id="description"
                                            className={`tab_pane ${activeTab === 'description' ? 'active show' : ''}`}
                                        >
                                            <div className="product__tab--content">
                                                {product.description ? (
                                                   <div dangerouslySetInnerHTML={{ __html: product.description }}>


                                                   </div> 
                                                ):(
                                                    <div>
                                                        <p>Product Description Not Available</p>
                                                    </div>
                                                )} 
                                            </div> 
                                        </div>

                                    <div
                                        id="reviews"
                                        className={`tab_pane ${activeTab === 'reviews' ? 'active show' : ''}`}
                                    >
                                        <ProductReview product={product} reviews={reviews} />
                                         
                                    </div>
                                    <div
                                        id="sizechart"
                                        className={`tab_pane ${activeTab === 'sizechart' ? 'active show' : ''}`}
                                    >
                                    <img src={product.sizeCart} alt="size cart" />
                                         
                                    </div>

                                    {/* <div
                                        id="information"
                                        className={`tab_pane ${activeTab === 'information' ? 'active show' : ''}`}
                                    >
                                        <div className="product__tab--conten">
                                                <div className="product__tab--content__step mb-30 tableSpecification">
                                                    {product.specifications.length > 0 ? (
                                                    <div className="table-responsive ">
                                                        <table className="table">
                                                            {product.specifications.map((specification, index) => (
                                                                <tr>
                                                                <th style={{width: "150px",maxWidth: "150px"}}>{specification.name}</th>
                                                                <td>
                                                                    {Array.isArray(specification.values) ? (
                                                                        specification.values.map((value, index) => (
                                                                            <span key={index}>{value.name}</span>
                                                                        ))
                                                                    ) : (
                                                                        <span>{specification.value}</span>
                                                                    )}
                                                                </td>
                                                            </tr>
                                                            ))}
                                                        </table>
                                                    </div>
                                                    ):(
                                                        <div>
                                                            <p>Product Specification Not Available</p>
                                                        </div>
                                                    )}
                                                </div>
                                        </div> 
                                    </div> */}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {relatedProducts.length > 1 &&
                
                <section className="product__section product__section--style3 section--padding related">
                    <div className="container product3__section--container">
                        <div className="section__heading text-center mb-50">
                            <h2 className="section__heading--maintitle">Related Products </h2>
                        </div>
                        <div className="slider-container">
                            <Slider {...settings}>
                                {relatedProducts.map((product, index) => (
                                    <ProductGrid product={product} key={index} />
                                ))}
                                {relatedProducts.map((product, index) => (
                                    <ProductGrid product={product} key={index} />
                                ))}
                            </Slider>
                        </div>
                    </div>
                </section>
                }
            </MainLayout>
    </>
  )
}
