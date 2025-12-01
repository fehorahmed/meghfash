import { IoCartOutline } from "react-icons/io5";
import { CiHeart } from "react-icons/ci";
import { IoEyeOutline } from "react-icons/io5";
import { useState } from "react";
import { MdOutlineStarPurple500 } from "react-icons/md";
import { FaFacebook, FaInstagram, FaTwitter, FaYoutube } from "react-icons/fa";
import Slider from "react-slick";
import QuickViewModal from "../QuickViewModal";
import ProductGallery from "../products/ProductGallery";
import ProductGrid from "../products/ProductGrid";
import NewProductGallery from "../NewProductGallery";


export default function HomeNewProductComponent({topProducts,trandingProducts,latestProducts}) {
    // State to track the active tab
    const [activeTab, setActiveTab] = useState("newarrival");
    const [isModalOpen, setModalOpen] = useState(false);


    const [productQuantity, setProductQuantity] = useState(1);

    const [selectedSize, setSelectedSize] = useState("S"); // Default selected size
    const [selectedColor, setSelectedColor] = useState("Red"); // Default selected color

    const handleSizeChange = (event) => {
        setSelectedSize(event.target.value); // Update the selected size state
        console.log("Selected Size:", event.target.value);
      };

    const handleColorChange = (event) => {
      setSelectedColor(event.target.value); // Update the selected color state
      console.log("Selected Color:", event.target.value);
    };

    const handleIncrement = () =>{
        setProductQuantity((prevQuantity) => prevQuantity + 1);
        console.log('button click pluse', productQuantity)
    }

    const handleDecrement = () => {
        if (productQuantity > 1) {
          setProductQuantity((prevQuantity) => prevQuantity - 1);
        }
      };

    const handleOpenModal = () => {
      setModalOpen(true);
    };
  
    const handleCloseModal = () => {
      setModalOpen(false);
    };


    // Function to handle tab click
    const handleTabClick = (tab) => {
        setActiveTab(tab);
    };



    var settings = {
        dots: false,
        infinite: true,
        autoplay: true,
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 1,
        initialSlide: 0,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              initialSlide: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          }
        ]
      };


      const firstSixTopProducts = topProducts.slice(0, 5);
      const lastSixTopProducts = topProducts.slice(6, 11);

      const firstSixTrandProducts = trandingProducts.slice(0, 5);
      const lastSixTrandProducts = trandingProducts.slice(6, 11);


      const fisrtSixLetestProducts = latestProducts.slice(0, 5);
      const lastSixLetestProducts = latestProducts.slice(6, 11);




    return (
        <>
            <section class="product__section section--padding pb-0 homeProduct">
                <div class="container-fluid">
                  

                    <ul className="product__tab--one product__tab--primary__btn d-flex justify-content-center mb-10">
                        <li className={`product__tab--primary__btn__list ${activeTab === "newarrival" ? "active" : ""}`} onClick={() => handleTabClick("newarrival")}>
                            New Arrival
                        </li>
                        
                        <li className={`product__tab--primary__btn__list ${activeTab === "trending" ? "active" : ""}`} onClick={() => handleTabClick("trending")}>
                            Trending
                        </li>
                        <li className={`product__tab--primary__btn__list ${activeTab === "featured" ? "active" : ""}`} onClick={() => handleTabClick("featured")}>
                            Top Sell
                        </li>
                    </ul>

                    <div className="tab_content">
                        <div id="featured" className={`tab_pane ${activeTab === "featured" ? "active show" : ""}`}>
                            <div class="product__section--inner">
                              
                            {topProducts.length > 0 &&
                              <div className="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                                 {topProducts.map((product, index) => (
                                        <ProductGrid product={product} />
                                    ))}
                              </div>
                                // <div className="slider-container ">
                                //     <Slider {...settings}>
                                //         {firstSixTopProducts.map((product, index) => (
                                //             <ProductGrid product={product} />
                                //         ))}
                                //     </Slider>
                                // </div>
                            }

                            {/* {lastSixTopProducts.length > 0 && 
                                <div className="slider-container ">
                                    <Slider {...settings}>
                                        {lastSixTopProducts.map((product, index) => (
                                            <ProductGrid product={product} />
                                        ))}
                                    </Slider>
                                </div>
                            } */}

                            </div>
                        </div>
                        <div id="trending" className={`tab_pane ${activeTab === "trending" ? "active show" : ""}`}>
                            <div class="product__section--inner">

                            {trandingProducts.length > 0 &&
                              <div className="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                                 {trandingProducts.map((product, index) => (
                                        <ProductGrid product={product} />
                                    ))}
                                    </div>
                                }

                                {/* {firstSixTrandProducts.length > 0 &&
                                    <div className="slider-container ">
                                        <Slider {...settings}>
                                            {firstSixTrandProducts.map((product, index) => (
                                                <ProductGrid product={product} />
                                            ))}
                                        </Slider>
                                    </div>
                                } */}



                                {/* {lastSixTrandProducts.length > 0 &&
                                    <div className="slider-container ">
                                        <Slider {...settings}>
                                            {lastSixTrandProducts.map((product, index) => (
                                                <ProductGrid product={product} />
                                            ))}
                                        </Slider>
                                    </div>
                                } */}
                            </div>
                        </div>
                        <div id="newarrival" className={`tab_pane ${activeTab === "newarrival" ? "active show" : ""}`}>
                            <div class="product__section--inner">

                            {latestProducts.length > 0 &&
                              <div className="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                                 {latestProducts.map((product, index) => (
                                        <ProductGrid product={product} />
                                    ))}
                                    </div>
                                }

{/* 
                                {fisrtSixLetestProducts.length > 0 &&
                                    <div className="slider-container ">
                                        <Slider {...settings}>
                                            {fisrtSixLetestProducts.map((product, index) => (
                                                <ProductGrid product={product} />
                                            ))}
                                        </Slider>
                                    </div>
                                }
                                {lastSixLetestProducts.length > 0 &&
                                    <div className="slider-container ">
                                        <Slider {...settings}>
                                            {lastSixLetestProducts.map((product, index) => (
                                                <ProductGrid product={product} />
                                            ))}
                                        </Slider>
                                    </div>
                                } */}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

           <QuickViewModal 
               isOpen={isModalOpen}
               onClose={handleCloseModal}
               content={
                <>
                  <section class="product__details--section section--padding modalView">
               <div class="container">
                   <div class="row row-cols-lg-2 row-cols-md-2">
                       <div class="col">
                       <NewProductGallery />
                       </div>   
                       <div class="col">
                           <div class="product__details--info">
                               <form action="#">
                                   <h2 class="product__details--info__title mb-15">Oversize Cotton Dress </h2>
                                   <div class="product__details--info__price mb-10">
                                       <span class="current__price">$110 </span>
                                       <span class="price__divided"></span>
                                       <span class="old__price">$178 </span>
                                   </div>
                                   <div class="product__details--info__rating d-flex align-items-center mb-15">
                                       <ul class="rating d-flex justify-content-center">
                                           <li class="rating__list">
                                               <span class="rating__list--icon">
                                                   <MdOutlineStarPurple500 />
                                               </span>
                                           </li>
                                           <li class="rating__list">
                                               <span class="rating__list--icon">
                                                   <MdOutlineStarPurple500 />
                                               </span>
                                           </li>
                                           <li class="rating__list">
                                               <span class="rating__list--icon">
                                                   <MdOutlineStarPurple500 />
                                               </span>
                                           </li>
                                           <li class="rating__list">
                                               <span class="rating__list--icon">
                                                   <MdOutlineStarPurple500 />
                                               </span>
                                           </li>
                                           <li class="rating__list">
                                               <span class="rating__list--icon">
                                                   <MdOutlineStarPurple500 />
                                               </span>
                                           </li>
                                       </ul>
                                       <span class="product__items--rating__count--number">(24) </span>
                                   </div>
                                   <p class="product__details--info__desc mb-15">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut numquam ullam is recusandae laborum explicabo id sequi quisquam, ab sunt deleniti quidem ea animi facilis quod nostrum odit! Repellendus voluptas suscipit cum harum dolor sciunt.
                                   </p>
                                   <div class="product__variant">

                                       <div className="product__variant--list mb-10">
                                       <fieldset className="variant__input--fieldset">
                                           <legend className="product__variant--title mb-8">Color : {selectedColor}</legend>

                                           <input
                                           id="color-red1"
                                           name="color"
                                           type="radio"
                                           value="Red"
                                           checked={selectedColor === "Red"} // Controlled component
                                           onChange={handleColorChange}
                                           />
                                           <label
                                           className="variant__color--value red"
                                           htmlFor="color-red1"
                                           title="Red"
                                           >
                                           <img
                                               className="variant__color--value__img"
                                               src="/images/img/product/product1.png"
                                               alt="variant-color-img"
                                           />
                                           </label>

                                           <input
                                           id="color-red2"
                                           name="color"
                                           type="radio"
                                           value="Black"
                                           checked={selectedColor === "Black"} // Controlled component
                                           onChange={handleColorChange}
                                           />
                                           <label
                                           className="variant__color--value red"
                                           htmlFor="color-red2"
                                           title="Black"
                                           >
                                           <img
                                               className="variant__color--value__img"
                                               src="/images/img/product/product2.png"
                                               alt="variant-color-img"
                                           />
                                           </label>

                                           <input
                                           id="color-red3"
                                           name="color"
                                           type="radio"
                                           value="Pink"
                                           checked={selectedColor === "Pink"} // Controlled component
                                           onChange={handleColorChange}
                                           />
                                           <label
                                           className="variant__color--value red"
                                           htmlFor="color-red3"
                                           title="Pink"
                                           >
                                           <img
                                               className="variant__color--value__img"
                                               src="/images/img/product/product3.png"
                                               alt="variant-color-img"
                                           />
                                           </label>

                                           <input
                                           id="color-red4"
                                           name="color"
                                           type="radio"
                                           value="Orange"
                                           checked={selectedColor === "Orange"} // Controlled component
                                           onChange={handleColorChange}
                                           />
                                           <label
                                           className="variant__color--value red"
                                           htmlFor="color-red4"
                                           title="Orange"
                                           >
                                           <img
                                               className="variant__color--value__img"
                                               src="/images/img/product/product4.png"
                                               alt="variant-color-img"
                                           />
                                           </label>
                                       </fieldset>

                                       </div>

                                       <div className="product__variant--list mb-15">
                                           <fieldset className="variant__input--fieldset weight">
                                               <legend className="product__variant--title mb-8">Size : {selectedSize} </legend>
                                               <input
                                               id="weight1"
                                               name="weight"
                                               type="radio"
                                               value="S"
                                               checked={selectedSize === "S"} 
                                               onChange={handleSizeChange}
                                               />
                                               <label className="variant__size--value red" htmlFor="weight1">
                                               S
                                               </label>
                                               <input
                                               id="weight2"
                                               name="weight"
                                               type="radio"
                                               value="M"
                                               checked={selectedSize === "M"} 
                                               onChange={handleSizeChange}
                                               />
                                               <label className="variant__size--value red" htmlFor="weight2">
                                               M
                                               </label>
                                               <input
                                               id="weight3"
                                               name="weight"
                                               type="radio"
                                               value="L"
                                               checked={selectedSize === "L"} 
                                               onChange={handleSizeChange}
                                               />
                                               <label className="variant__size--value red" htmlFor="weight3">
                                               L
                                               </label>
                                               <input
                                               id="weight4"
                                               name="weight"
                                               type="radio"
                                               value="XL"
                                               checked={selectedSize === "XL"} 
                                               onChange={handleSizeChange}
                                               />
                                               <label className="variant__size--value red" htmlFor="weight4">
                                               XL
                                               </label>
                                           </fieldset>

                                       
                                       </div>


                                       <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                           <div class="quantity__box">
                                               <button onClick={handleDecrement} type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">- </button>
                                               <label>
                                                   <input type="number" class="quantity__number quickview__value--number" value={productQuantity} />
                                               </label>
                                               <button onClick={handleIncrement} type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+ </button>
                                           </div>
                                           <button class="quickview__cart--btn primary__btn" type="submit">Add To Cart </button>  
                                           <button class="quickview__cart--btn primary__btn wishList" type="submit">Add to Wishlist </button>  
                                       </div>
                                       <div class="product__variant--list mb-15">
                                           
                                           <button class="variant__buy--now__btn primary__btn" type="submit">Buy it now </button>
                                       </div>
                                       {/* <div class="product__details--info__meta">
                                           <p class="product__details--info__meta--list"><strong>Barcode: </strong>   <span>565461 </span>  </p>
                                           <p class="product__details--info__meta--list"><strong>Sky: </strong>   <span>4420 </span>  </p>
                                           <p class="product__details--info__meta--list"><strong>Vendor: </strong>   <span>Belo </span>  </p>
                                           <p class="product__details--info__meta--list"><strong>Type: </strong>   <span>Dress </span>  </p>
                                       </div> */}
                                   </div>
                                   <div class="quickview__social d-flex align-items-center mb-15">
                                       <label class="quickview__social--title">Social Share: </label>
                                       <ul class="quickview__social--wrapper mt-0 d-flex">
                                           <li class="quickview__social--list">
                                               <a class="quickview__social--icon" target="_blank" href="https://www.facebook.com">
                                                   <FaFacebook />
                                                   <span class="visually-hidden">Facebook </span>
                                               </a>
                                           </li>
                                           <li class="quickview__social--list">
                                               <a class="quickview__social--icon" target="_blank" href="https://twitter.com">
                                                   <FaTwitter />
                                                   <span class="visually-hidden">Twitter </span>
                                               </a>
                                           </li>
                                           <li class="quickview__social--list">
                                               <a class="quickview__social--icon" target="_blank" href="https://www.instagram.com">
                                                   <FaInstagram />
                                                   <span class="visually-hidden">Instagram </span> 
                                               </a>
                                           </li>
                                           <li class="quickview__social--list">
                                               <a class="quickview__social--icon" target="_blank" href="../../../../www.youtube.com/supported_browsers_c942f037.html">
                                                   <FaYoutube />
                                                   <span class="visually-hidden">Youtube </span>
                                               </a>
                                           </li>
                                       </ul>
                                   </div>
                                   {/* <div class="guarantee__safe--checkout">
                                       <h5 class="guarantee__safe--checkout__title">Guaranteed Safe Checkout </h5>
                                       <img class="guarantee__safe--checkout__img" src="/images/img/other/safe-checkout.png" alt="Payment Image" />
                                   </div> */}
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
                 </section>
               </>
              }
           />
        </>
    );
}
