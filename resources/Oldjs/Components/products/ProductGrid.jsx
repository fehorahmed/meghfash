import { useCart } from "@/Context/CartContext";
import { Link } from "@inertiajs/react";
import { useState } from "react";
import { CiHeart } from "react-icons/ci";
import { IoCartOutline, IoEyeOutline } from "react-icons/io5";
import { Inertia } from '@inertiajs/inertia';
import RatingStar from "./RatingStar";



export default function ProductGrid({product}) {

         const {cart, initializeCart, addToCart, addToWishList,initializeWishList,wishList, loading} = useCart();

        const [setModalOpen] = useState(false);
    
        const handleOpenModal = () => {
          setModalOpen(true);
        };
      
        const handleWishList = (id) => {
            addToWishList(id)
        }


        const dataLayerAddToCart = (product) => {
            console.log(product.name);
            const itemCategory = product.ctgs
            ? product.ctgs.map((category) => category.name).join(", ")
            : null;

        

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: "add_to_cart",
                currency: "BDT",
                value: product.final_price,

                items: [
                    {
                        item_id: product.id, // Product ID
                        item_name: product.name, // Product Name
                        coupon: product.coupon || null, // Optional coupon 
                        discount: product.discount,
                        index: 0,
                        item_brand: product.brandName,
                        item_category: itemCategory,
                        item_variant: null,
                        price: product.final_price,
                        quantity: 1,

                    }
                ]
            });

            console.log('add to cart data layer');
        }


        const handleAddToCard = (id,) => {
            addToCart({
                product_id: id,
                quantity: 1,
            });


            dataLayerAddToCart(product);
            

        }






  return (
        <div class="product__items ">                       
            <div class="product__items--thumbnail">
                <Link class="product__items--link" href={route('productView', product.slug?product.slug:'no-title')}>
                    <img class="product__items--img product__primary--img" src={product.image_url} alt={product.name} />
                    <img class="product__items--img product__secondary--img" src={product.hoverImage_url} alt={product.name} />
                </Link>
                <div class="product__badge">
                {product.sale_label ? 
                <div class="product__badge--items sale">  sale </div>
                :
                null
                }
                {product.discountPercent > 0 && 
                <div class="product__badge--items sale persent">{product.discountPercent} % </div>
                }
                </div>

                {/* <div className="addToCartAndWishList">
                   

                    {product.variation_status==1 ? (
                            <Link 
                                href={route('productView', {
                                slug: product.slug ? product.slug : 'no-title',
                                cart: 'variant',
                            })}

                            >
                                
                               
                                    <span >  
                                        {loading[product.id] ? 
                                        <div class="spinner-border " role="status"></div>
                                        : 
                                        <IoCartOutline /> 
                                        } 
                                </span>
                            </Link>
                            
                        ):(
                            <button onClick={() => handleAddToCard(product.id)}>
                                   
                                    <span >
                                        {loading[product.id] ? 
                                        <div class="spinner-border " role="status"></div>
                                        : 
                                        <IoCartOutline /> 
                                        } 
                                </span>
                            </button> 
                        )

                        }




                    <button className={`product__items--action__btn ${product.wishListStatus == true ? 'active' : ''}`}  onClick={() => handleWishList(product.id)}>   <CiHeart /> </button>
                </div> */}

            </div>
            <div class="product__items--content">
                {/* <span class="product__items--content__subtitle">Jacket, Women  </span> */}
                <h3 class="product__items--content__title h4"><Link href={route('productView', product.slug?product.slug:'no-title')}>{product.name}</Link></h3>
                <div class="product__items--price">
                    <span class="current__price">{product.finalPrice}</span> 
                    {product.regularPrice && (
                        <>
                        <span class="price__divided"></span>
                        <span class="old__price">{product.regularPrice}</span>
                        </>
                    )
                    }
                    
                </div>
              

                <RatingStar rating={product.rating} />


                {/* <ul class="product__items--action d-flex" style={{justifyContent: "space-between"}}>
                    <li class="product__items--action__list">
                        {product.variation_status==1 ? (
                            <Link class="product__items--action__btn add__to--cart"  
                                href={route('productView', {
                                slug: product.slug ? product.slug : 'no-title',
                                cart: 'variant',
                            })}

                            >
                                
                                <IoCartOutline />
                                    <span class="add__to--cart__text">  
                                        {loading[product.id] ? 
                                        <div class="spinner-border " role="status"></div>
                                        : 
                                        '+ Add to Cart'
                                        } 
                                </span>
                            </Link>
                            
                        ):(
                            <button class="product__items--action__btn add__to--cart" onClick={() => handleAddToCard(product.id)}>
                                    <IoCartOutline /> 
                                    <span class="add__to--cart__text">
                                        {loading[product.id] ? 
                                        <div class="spinner-border " role="status"></div>
                                        : 
                                        '+ Add to Cart'
                                        } 
                                </span>
                            </button> 
                        )

                        }
                        
                    </li>
                    <li class="product__items--action__list">
                        <button className={`product__items--action__btn ${product.wishListStatus == true ? 'active' : ''}`}  onClick={() => handleWishList(product.id)} >
                             <CiHeart />
                            <span class="visually-hidden">Wishlist </span>
                        </button>
                    </li>
                    <li class="product__items--action__list" onClick={handleOpenModal}>
                        <a class="product__items--action__btn" data-open="modal1" href="javascript:void(0)">
                        <IoEyeOutline />
                            <span class="visually-hidden">Quick View </span>
                        </a>
                    </li>
                </ul> */}
            </div>
        </div>
  )
}
