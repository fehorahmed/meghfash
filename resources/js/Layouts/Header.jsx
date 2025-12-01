
import { CiHeart } from "react-icons/ci";
import { CiUser } from "react-icons/ci";
import { AiOutlineShoppingCart } from "react-icons/ai";
import { IoIosSearch, IoMdClose, IoMdSearch } from "react-icons/io";
import { Link } from "@inertiajs/react";
import { IoCartOutline } from "react-icons/io5";
import { FaBars, FaCartPlus, FaFacebook, FaHeart, FaHome, FaInstagram, FaLinkedinIn, FaTiktok, FaTwitter, FaWhatsapp, FaYoutube } from "react-icons/fa";
import { useEffect,  useRef,  useState } from "react";
import { FaFacebookF, FaPhone } from "react-icons/fa6";
import ProductSearch from "@/Components/products/ProductSearch";
import { useCart } from "@/Context/CartContext";
import ProductMobileSearch from "@/Components/products/ProductMobileSearch";
import ProductSearchAuto from "@/Components/products/ProductSearchAuto";
import { BiSolidOffer } from "react-icons/bi";


const Header = ({auth, general, headerMenu,categoryMenu,itemsCount, wishListCount, carts }) => {

    const [isSticky, setIsSticky] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsSticky(window.scrollY > 100); // change 100 to your scroll trigger point
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);


    const submenuRef = useRef(null);

    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    const [isSubMenuOpen, setIsSubMenuOpen] = useState(false);
    const [isModalOpen, setIsModalOpen] = useState(false);

    const {cart, removeFromCart,wishList,initializeWishList, initializeCart} = useCart();

    const [isCartOpen, setIsCartOpen] = useState(false);

    const sidebarCartRef = useRef(null); // Reference for the sidebar element

    // Toggle cart open/close
    const toggleCart = () => {
      setIsCartOpen(!isCartOpen);
    };


    // Close the sidebar when clicking outside
    useEffect(() => {
        const handleOutsideClick = (event) => {
          // Check if the click is outside the sidebar
          if (
            sidebarCartRef.current &&
            !sidebarCartRef.current.contains(event.target) &&
            isCartOpen
          ) {
            setIsCartOpen(false); // Close the sidebar
          }
        };

        // Attach the event listener
        document.addEventListener("mousedown", handleOutsideClick);

        // Cleanup the event listener on component unmount
        return () => {
          document.removeEventListener("mousedown", handleOutsideClick);
        };
      }, [isCartOpen]);




  // Add event listener to close the cart on outside click
  useEffect(() => {
    if (isCartOpen) {
      document.body.classList.add('offCanvas__minicart_active');
    } else {
      document.body.classList.remove('offCanvas__minicart_active');
    }

   
  }, [isCartOpen]);





  const handleCartRemove = (id, type) =>{
    removeFromCart(id,type)
}


  // Toggle modal visibility
  const handleModalToggle = () => {
    setIsModalOpen(!isModalOpen);
  };

useEffect(() => {
    initializeCart(carts); // Initialize cart data
}, [carts]);


  useEffect(() => {
    initializeWishList(carts?.wlProducts); 
  }, [carts?.wlProducts]);





      // State to track open submenus
      const [openSubMenus, setOpenSubMenus] = useState({});

      // Toggle submenu visibility
      const toggleSubMenu = (menuId) => {
        setOpenSubMenus((prevState) => ({
          ...prevState,
          [menuId]: !prevState[menuId], // Toggle the submenu
        }));
      };

      const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    const sidebarRef = useRef(null); // Reference for the sidebar element


      // Close the sidebar when clicking outside
  useEffect(() => {
    const handleOutsideClick = (event) => {
      // Check if the click is outside the sidebar
      if (
        sidebarRef.current &&
        !sidebarRef.current.contains(event.target) &&
        isMobileMenuOpen
      ) {
        setIsMobileMenuOpen(false); // Close the sidebar
      }
    };

    // Attach the event listener
    document.addEventListener("mousedown", handleOutsideClick);

    // Cleanup the event listener on component unmount
    return () => {
      document.removeEventListener("mousedown", handleOutsideClick);
    };
  }, [isMobileMenuOpen]);



     // Add event listener to close the cart on outside click
  useEffect(() => {
    if (isMobileMenuOpen) {
      document.body.classList.add('mobile_menu_open');
    } else {
      document.body.classList.remove('mobile_menu_open');
    }

   
  }, [isMobileMenuOpen]);





 
    return (
        <>
            <header className="header__section">
            <div className="mobileTopHeader">
                       <div className="container-fluid">
                       {/* <p>Welcome to Megh Fashion  Online Store</p> */}
                       </div>
                    </div>
            <div className="header__topbar bg__secondary">
                <div className="container-fluid">
                    
                    <div className="header__topbar--inner d-flex align-items-center justify-content-between">
                        <div className="header__shipping">
                            <ul className="header__shipping--wrapper d-flex">
                                <li className="header__shipping--text text-white">Welcome to Megh Fashion </li>
                                <li className="header__shipping--text text-white d-sm-2-none"> <Link href={route('orderTracking')}><img className="header__shipping--text__icon" src="/images/img/icon/bus.png" alt="bus-icon" /> Track Your Order </Link> </li>
                                {general.email && <li className="header__shipping--text text-white d-sm-2-none"><img className="header__shipping--text__icon" src="/images/img/icon/email.png" alt="email-icon" />  <a className="header__shipping--text__link" href={`mailto:${general.email}`}>{general.email} </a></li>}
                            </ul>
                        </div>
                        <div className="language__currency ">
                            <ul className="d-flex align-items-center">
                                {general.mobile && 
                                <li className="language__currency--list">
                                    <a href={`tel:${general.mobile.trim()}`}> <FaPhone />  {general.mobile}</a>
                                </li>
                                }
                            </ul>
                            <div className="headerSocialLink">
                                <p>   </p>
                                <ul class="mobileHeadSocial">
                                      {general.facebook_link && (
                                        <li>
                                            <a href={general.facebook_link} target="_blank"><FaFacebookF /></a>
                                        </li>
                                        )}

                                        {general.youtube_link  && (
                                        <li>
                                            <a href={general.youtube_link } target="_blank"><FaYoutube /></a>
                                        </li>
                                        )}

                                    {general.instagram_link  && (
                                    <li>
                                        <a href={general.instagram_link} target="_blank"><FaInstagram /></a>
                                    </li>
                                    )}

                                    {general.instagram_link  && (
                                    <li>
                                        <a href={general.pinterest_link}><FaTiktok /></a>
                                    </li>
                                    )}
                                    {general.twitter_link  && (
                                    <li>
                                        <a href={general.twitter_link} target="_blank"><FaTwitter /></a>
                                    </li>
                                    )}
                                     {general.linkedin_link  && (
                                    <li>
                                        <a href={general.linkedin_link} target="_blank"><FaLinkedinIn /></a>
                                    </li>
                                     )}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className={`desktopHeader ${isSticky ? 'sticky' : ''}`}>
                <div className="main__header header__sticky">
                    <div className="container-fluid">
                        <div className="main__header--inner position__relative d-flex justify-content-between align-items-center">
                            <div className="offcanvas__header--menu__open ">
                                <a className="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas="">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="ionicon offcanvas__header--menu__open--svg" viewbox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"></path></svg>
                                    <span className="visually-hidden">Menu Open </span>
                                </a>
                            </div>
                            <div className="main__logo">
                                <h1 className="main__logo--title">
                                    <Link className="main__logo--link" href={route('index')}>
                                    <img className="main__logo--img" src={`/${general.logo}`} alt={general.title} />
                                    </Link>
                                </h1>
                            </div>
                            <div className="header__search--widget header__sticky--none d-none d-lg-block">
                                {/* <ProductSearch categoryMenu={categoryMenu}   /> */}
                                <ProductSearchAuto categoryMenu={categoryMenu} />
                            </div>
                            <div className="header__account header__sticky--none">
                                <ul className="d-flex">
                                    <li className="header__account--items">
                                        <Link className="header__account--btn" href="/login">
                                        <CiUser />
                                            <span className="header__account--btn__text">My Account </span>
                                        </Link >
                                    </li>
                                    <li className="header__account--items d-none d-lg-block">
                                        <Link className="header__account--btn" href={route('myWishlist')}>
                                        <CiHeart />
                                            <span className="header__account--btn__text"> Wish List </span>
                                            <span className="items__count wishlist">{wishList.length}</span> 
                                        </Link>
                                    </li>
                                    <li className="header__account--items"  onClick={toggleCart}>
                                        <a className="header__account--btn minicart__open--btn" href="javascript:void(0)" data-offcanvas="">
                                            <AiOutlineShoppingCart />
                                            <span className="header__account--btn__text"> My cart </span>   
                                            <span className="items__count">{cart.cartsCount} </span> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div className="header__account header__account2 header__sticky--block">
                                <ul className="d-flex">
                                    <li className="header__account--items header__account2--items  header__account--search__items d-none d-lg-block">
                                        <a className="header__account--btn search__open--btn" href="javascript:void(0)" data-offcanvas="">
                                            <svg className="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewbox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path></svg>  
                                            <span className="visually-hidden">Search </span>
                                        </a>
                                    </li>
                                    <li className="header__account--items header__account2--items">
                                        <a className="header__account--btn" href="my-account.html">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewbox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                                            <span className="visually-hidden">My Account </span>
                                        </a>
                                    </li>
                                    <li className="header__account--items header__account2--items d-none d-lg-block">
                                        <a className="header__account--btn" href="wishlist.html">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28.51" height="23.443" viewbox="0 0 512 512"><path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg>
                                            <span className="items__count  wishlist style2">02 </span> 
                                        </a>
                                    </li>
                                    <li className="header__account--items header__account2--items">
                                        <a className="header__account--btn minicart__open--btn" href="javascript:void(0)" data-offcanvas="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewbox="0 0 14.706 13.534">
                                                <g transform="translate(0 0)">
                                                <g>
                                                    <path data-name="Path 16787" d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z" transform="translate(0 -463.248)" fill="currentColor"></path>
                                                    <path data-name="Path 16788" d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z" transform="translate(-1.191 -466.622)" fill="currentColor"></path>
                                                    <path data-name="Path 16789" d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z" transform="translate(-2.875 -466.622)" fill="currentColor"></path>
                                                </g>
                                                </g>
                                            </svg>
                                            <span className="items__count style2">02 </span> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="header__bottom">
                    <div className="container-fluid">
                        <div className="header__bottom--inner position__relative d-none d-lg-flex justify-content-between align-items-center">
                        <div className="header__menu">
                                {headerMenu && headerMenu.items && 
                                <nav className="header__menu--navigation">                                
                                    <ul className="d-flex">

                                        {headerMenu.items.map((item, index) => (
                                        <li className={`header__menu--items`} key={index} >
                                            <Link className="header__menu--link" href={`/${item.slug}`} > {item.title} 
                                            {item.items.length > 0 &&
                                            <svg className="menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12" height="7.41" viewbox="0 0 12 7.41">
                                                <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7"></path>
                                            </svg>
                                            }
                                            </Link>
                                            {item.items.length > 0 &&
                                            <ul className="header__sub--menu">
                                                {item.items.map((group, index) => (
                                                    <>
                                                    {group.items.length > 0 &&(
                                                        <>
                                                        {group.items.map((subMenu, index) => (
                                                            <li className="header__sub--menu__items" key={index}>
                                                            <Link className="header__sub--menu__link" href={`/${subMenu.slug}`} >{subMenu.title} </Link>
                                                                {subMenu.items.length > 0 &&
                                                                <ul className="header__sub--menu2">
                                                                    {subMenu.items.map((subsubMenu, index) => (
                                                                        <li class="header__sub--menu__items"><Link className="header__sub--menu__link" href={`/${subsubMenu.slug}`}>{subsubMenu.title}</Link></li>
                                                                    ))}
                                                                </ul>
                                                                }
                                                            </li>
                                                        ))}
                                                        </>
                                                    )}
                                                    </>
                                                ))}
                                                
                                            </ul>
                                            }
                                        </li>
                                        ))}
                                        
                                    </ul>
                                </nav>
                                }
                            </div>
                            {/* <p className="header__discount--text">
                                {general.special_offce_status  ? 
                                    <span>
                                        <img className="header__discount--icon__img" src="/images/img/icon/lamp.png" alt="lamp-img" /> 
                                        {general.special_offce_text}
                                    </span>
                                    :
                                    null
                                }
                            </p> */}
                        </div>
                    </div>
                </div>
            </div>

            <div className="offcanvas__stikcy--toolbar">
                <ul className="d-flex justify-content-between">
                    <li className="offcanvas__stikcy--toolbar__list">
                        <Link className="offcanvas__stikcy--toolbar__btn" href="/">
                        <span className="offcanvas__stikcy--toolbar__icon"> 
                            <FaHome />
                            </span>
                        <span className="offcanvas__stikcy--toolbar__label">Home </span>
                        </Link>
                    </li>

                    <li className="offcanvas__stikcy--toolbar__list" style={{background: "#b6e7ff",borderRadius: "5px",padding: "3px 10px"}}>
                        <Link className="offcanvas__stikcy--toolbar__btn" href={route('offerProduct')}>
                            <span className="offcanvas__stikcy--toolbar__icon"> 
                           <BiSolidOffer />
                            </span>
                            <span className="offcanvas__stikcy--toolbar__label">OFFER </span>
               
                        </Link>
                    </li>
                  
                    
                    <li className="offcanvas__stikcy--toolbar__list">
                        <span className="offcanvas__stikcy--toolbar__btn minicart__open--btn" onClick={toggleCart}>
                            <span className="offcanvas__stikcy--toolbar__icon"> 
                            <FaCartPlus />
                            </span>
                            <span className="offcanvas__stikcy--toolbar__label">Cart </span>
                            <span className="items__count botton-count">{cart.cartsCount}</span> 
                        </span>
                    </li>
                    {/* <li className="offcanvas__stikcy--toolbar__list">
                        <Link className="offcanvas__stikcy--toolbar__btn" href={route('myWishlist')}>
                            <span className="offcanvas__stikcy--toolbar__icon"> 
                            <FaHeart /> 
                            </span>
                            <span className="offcanvas__stikcy--toolbar__label">Wishlist </span>
                            <span className="items__count botton-count">{wishList.length}</span> 
                        </Link>
                    </li> */}
                    <li className="offcanvas__stikcy--toolbar__list "  onClick={handleModalToggle}>
                        <a className="offcanvas__stikcy--toolbar__btn search__open--btn" href="javascript:void(0)" data-offcanvas="">
                            <span className="offcanvas__stikcy--toolbar__icon"> 
                            <IoMdSearch />
                            </span>
                        <span className="offcanvas__stikcy--toolbar__label">Search </span>
                        </a>
                    </li>
                </ul>
            </div>


                {isModalOpen && (
                <div className={`modal-overlay ${isModalOpen ? "show" : "hide"}`}
                    onClick={handleModalToggle}>
                <div className={`modal-content ${isModalOpen ? "slide-in" : "slide-out"}`}
                     onClick={(e) => e.stopPropagation()}>
                    
                   <div className="searchHead">
                    <h2>Search Product</h2>
                        <button className="modal-close-btn" onClick={handleModalToggle}>
                            <IoMdClose />
                        </button>
                    </div>
                        {/* <ProductMobileSearch/> */}
                        <ProductSearchAuto categoryMenu={categoryMenu} />
                    </div>
                </div>
            )}

            <style jsx>{`
                    .modal-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 1000;
                        opacity: 0;
                        pointer-events: none;
                        transition: opacity 0.5s ease-in-out;
                        }

                        .modal-overlay.show {
                        opacity: 1;
                        pointer-events: auto;
                        }

                        .modal-overlay.hide {
                        opacity: 0;
                        pointer-events: none;
                        }

                        .modal-content {
                        background: #fff;
                        padding: 20px;
                        text-align: center;
                        width: 100%;
                        max-width: 400px;
                        transform: translateY(-20px);
                        transition: transform 0.5s ease-in-out;
                        position: fixed;
                        top: 0;

                        }
                        .modal-content.slide-in {
                        transform: translateY(0);
                        }
                        .modal-content.slide-out {
                        transform: translateY(-20px);
                        }
                    .searchHead {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        margin-bottom: 10px;
                    }
                    .modal-search-input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    }
                    .modal-close-btn {
                        border: none;
                        width: 30px;
                        height: 30px;
                        text-align: center;
                        border-radius: 50%;
                    }
                    .modal-close-btn svg {
                            font-size: 24px;
                        }
                    
                `}</style>


    
            <div  ref={sidebarCartRef} className={`offCanvas__minicart ${isCartOpen ? 'active' : ''}`}  >
                <div className="minicart__header">
                <div className="minicart__header--top d-flex justify-content-between align-items-center">
                    <h2 className="minicart__title h3">Shopping Cart</h2>
                    <button
                    className="minicart__close--btn"
                    aria-label="minicart close button"
                    onClick={toggleCart}
                    >
                    <svg
                        className="minicart__close--icon"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                    >
                        <path
                        fill="currentColor"
                        stroke="currentColor"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="32"
                        d="M368 368L144 144M368 144L144 368"
                        ></path>
                    </svg>
                    </button>
                </div>
                <p className="minicart__header--desc"> Megh Fashion online Store</p>
                </div>
                {/* Cart Products */}

                {cart?.cartItems?.length > 0 ? 
                <>
                    <div className="minicart__product">

                    {cart?.cartItems.map((cartItem)=>(
 
                            <div className="minicart__product--items d-flex">
                        <div className="minicart__thumb">
                        <Link href={route('productView', cartItem.productSlug?cartItem.productSlug:'no-title')}>
                            <img src={cartItem.productImage} alt="product-img" />
                        </Link>
                        </div>
                        <div className="minicart__text">
                        <h3 className="minicart__subtitle h4">
                            <Link href={route('productView', cartItem.productSlug?cartItem.productSlug:'no-title')}>
                                {cartItem.productName.length > 20
                                ? `${cartItem.productName.slice(0, 20)}...`
                                : cartItem.productName} 
                            </Link>
                        </h3>
                        {cartItem?.variants?.map((variant) => 
                            <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                        )}
                    <div className="minicart__price">
                            <span className="current__price">{cartItem.finalPrice}</span>

                          
                        </div>
                        <div class="minicart__text--footer d-flex align-items-center">
                            <div class="quantity__box minicart__quantity">
                                <button onClick={()=>handleCartRemove(cartItem.id, 'decrement')} type="button" class="quantity__value decrease" aria-label="quantity value" value="Decrease Value">-</button>
                                <label>
                                    <input type="number" class="quantity__number" value={cartItem.quantity} data-counter="" />
                                </label>
                                <button onClick={()=>handleCartRemove(cartItem.id, 'increment')} type="button" class="quantity__value increase" value="Increase Value">+</button>
                            </div>
                            <button onClick={()=>handleCartRemove(cartItem.id, 'delete')} class="minicart__product--remove">Remove</button>
                        </div>
                        </div>
                            </div>
                    ))}


                    </div>
                    {/* Cart Summary */}
                    <div className="minicart__amount">
                    <div className="minicart__amount_list d-flex justify-content-between">
                        <span>Sub Total:</span>
                        <span>
                        <b>{cart?.cartTotalPriceFormat}</b>
                        </span>
                    </div>

                    </div>
                    <div className="minicart__button d-flex justify-content-center">
                        <Link className="primary__btn minicart__button--link" href={route('carts')}>
                            View cart
                        </Link>
                        <Link className="primary__btn minicart__button--link" href={route('checkout')}>
                            Checkout
                        </Link >
                        </div>
                </>
                :
                <div style={{textAlign: "center",
                    fontSize: "40px",
                    fontWeight: "bold",
                    color: "gray",
                    margin: "100px 0"}}>
                        Cart is empty
                </div>
                }


               
            </div>





            </header>

     

            <div  ref={sidebarRef} className={`offcanvas__header ${isMobileMenuOpen ? 'open' : ''}`}>
                <div className="offcanvas__inner">
                    <div className="offcanvas__logo">
                        <Link className="offcanvas__logo_link" href={route('index')}>
                            <img src={`/${general.logo}`} alt={general.title} width="158" height="36" />
                        </Link>
                        <button  onClick={toggleMobileMenu} className="offcanvas__close--btn" data-offcanvas="">close </button>
                    </div>
                    
                    {headerMenu && headerMenu.items && 
                    <nav className="offcanvas__menu">
                        <ul className="offcanvas__menu_ul">
                        {headerMenu.items.map((item, index) => (
                        <li className="offcanvas__menu_li">
                            <Link className="offcanvas__menu_item" href={`/${item.slug}`}> {item.title} </Link>
                            {item.items.length > 0 &&
                            <button
                                onClick={() => toggleSubMenu(item.id)}
                                className={`offcanvas__sub_menu_toggle ${openSubMenus[item.id] ? "active" : ""}`}
                            >
                            
                            </button>
                            }
                            {item.items.length > 0 &&
                           <>
                                {item.items.map((group, index) => (
                                    <>
                                    {group.items.length > 0 &&

                                        <ul
                                            className={`offcanvas__sub_menu ${openSubMenus[item.id] ? "open-submenu" : ""}`}

                                        >
                                        {group.items.map((subMenu, index) => (
                                            <li className="offcanvas__sub_menu_li">
                                            <Link className="offcanvas__sub_menu_item" href={`/${subMenu.slug}`}> {subMenu.title}</Link>
                                            {subMenu.items.length > 0 &&
                                             <>
                                                <button
                                                    onClick={() => toggleSubMenu(subMenu.id)}
                                                    className={`offcanvas__sub_menu_toggle ${openSubMenus[subMenu.id] ? "active" : ""}`}
                                                >
                                                
                                                </button>

                                                <ul
                                                    className={`offcanvas__sub_menu ${openSubMenus[subMenu.id] ? "open-submenu" : ""}`}

                                                >
                                                    {subMenu.items.map((subsubMenu, index) => (
                                                    <li className="offcanvas__sub_menu_li">
                                                    <Link className="offcanvas__sub_menu_item" href={`/${subsubMenu.slug}`}> {subsubMenu.title}</Link>
                                                    </li>
                                                    ))}

                                                </ul>
                                            </>
                                            }
                                            </li>

                                            ))}
                                        </ul>
                                    }
                                    
                                    </>
                                ))}
                            </>
                            }
                        </li>
                        ))}

 
                        </ul>
                        <div className="offcanvas__account--items">
                            {auth.user  ? (
                                <Link className="offcanvas__account--items__btn d-flex align-items-center" href={route('customer.dashboard')}>
                                <span className="offcanvas__account--items__icon"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20.51" height="19.443" viewbox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg> 
                                    </span>
                                <span className="offcanvas__account--items__label">My Account </span>
                            </Link>
                            ):
                            (
                            <Link className="offcanvas__account--items__btn d-flex align-items-center" href={route('login')}>
                                <span className="offcanvas__account--items__icon"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20.51" height="19.443" viewbox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg> 
                                    </span>
                                <span className="offcanvas__account--items__label">Login / Register </span>
                            </Link>
                            )}
                            
                        </div>
                    </nav>
                    }
                </div>
            </div>

            <div className={`mobileHeaderMain ${isSticky ? 'sticky' : ''}`}>
                <div className="container">
                    <div className="row">
                        <div className="col-2">
                            <div className="mobileHeaderIcon">
                                <ul>
                                    <li onClick={toggleMobileMenu} className="bar">
                                        <FaBars />
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div className="col-5">
                            <div className="mobileHeaderLogo">
                              <Link href={route('index')}>  <img src={`/${general.logo}`} alt={general.title} /></Link>
                            </div>
                        </div>
                        <div className="col-5">
                            <div className="mobileHeaderIcon">
                                <ul>
                                    <li>
                                        <ul class="mobileSocail">

                                           {general.facebook_link && (
                                        <li>
                                            <a href={general.facebook_link} target="_blank"><FaFacebookF /></a>
                                        </li>
                                        )}

                                        {general.youtube_link  && (
                                        <li>
                                            <a href={general.youtube_link } target="_blank"><FaYoutube /></a>
                                        </li>
                                        )}

                                    {general.instagram_link  && (
                                    <li>
                                        <a href={general.instagram_link} target="_blank"><FaInstagram /></a>
                                    </li>
                                    )}

                                    {general.instagram_link  && (
                                    <li>
                                        <a href={general.pinterest_link}><FaTiktok /></a>
                                    </li>
                                    )}
                                  
                                     {general.linkedin_link  && (
                                    <li>
                                        <a href={general.linkedin_link} target="_blank"><FaLinkedinIn /></a>
                                    </li>
                                     )}
                                         
                                        </ul>
                                    </li>
                                    <li className="header__account--items ">
                                        {auth.user ? (
                                            <Link className="header__account--btn" href={route('customer.dashboard')}>
                                                <CiUser />
                                                {/* <CiHeart /> */}
                                                {/* <span className="items__count wishlist">02 </span>  */}
                                            </Link>
                                        ) : (
                                            <Link className="header__account--btn" href={route('login')}>
                                                <CiUser />
                                                {/* <CiHeart /> */}
                                                {/* <span className="items__count wishlist">02 </span>  */}
                                            </Link>
                                        )}
                                    

                                    </li>
                                    {/* <li className="header__account--items"  onClick={toggleCart}>
                                        <span className="header__account--btn minicart__open--btn">
                                            <AiOutlineShoppingCart />
                                            <span className="items__count">{cart.cartsCount}</span> 
                                        </span>
                                    </li> */}
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
               
                {/* {categoryMenu?.items?.length > 0 &&
                <>
                <hr />
                    <div className="mainMenu">
                        <div className="container">
                           
                                <ul>
                                    {categoryMenu?.items?.map((ctgMenu)=>(
                                        <li key={ctgMenu.id}>
                                            <Link href={`/${ctgMenu.slug}`}>{ctgMenu.title} </Link>
                                        </li>
                                    ))}
                                </ul>
                        </div>
                    </div>
                <hr />
                </>
              } */}
            </div>




        </>
    );
};

export default Header;
