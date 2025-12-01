import { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import { Link } from "@inertiajs/react";
import ProductGrid from "@/Components/products/ProductGrid";
import CategoryFillterSideBar from "@/Components/CategoryFillterSideBar";
import { useRef } from "react";
import { useEffect } from "react";
import Pagination from "@/Components/Pagination";

export default function ProductCategory({ 
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    categoryMenu,
    auth,
    category,
    products,
    footerMenu2,
    carts,
    attributes,
    subCtg,
    maxPrice,
    
    }) {

        const [productLoading, setProductLoading] = useState(false);

        const [totalPages, setTotalPages] = useState(1);

        const [currentPage, setCurrentPage] = useState(1);

        const isInitialMount = useRef(true);

        const [filters, setFilters] = useState({
            category: [],
            color: [],
            attribute: [],
            fabric: [],
            size: [],
            cut_fit: [],
            min_price: 0, 
            max_price: maxPrice,
            sort_by: "latest",
            page: 1,
          });
        

          const [filteredProductData, setFilteredProductData] = useState(products);

          const [summery, setSummery] = useState({
            total: products.total,
            from: products.from,
            to: products.to
          })

          const maxRange = maxPrice;
          const getPercentage = (value) => (value / maxRange) * 100;

          const handleCheckboxChange = (e) => {
            const { name, value, checked, type } = e.target;
          
            setFilters((prevFilters) => {
              // Handle checkboxes for array-based filters
              if (["category", "color", "fabric", "size", "cut_fit"].includes(name)) {
                return {
                  ...prevFilters,
                  [name]: checked
                    ? [...prevFilters[name], value] // Add value if checked
                    : prevFilters[name].filter((item) => item !== value), // Remove value if unchecked
                };
              }
          
              // Handle min_price and max_price (input type="number" or range)
              if (name === "min_price" || name === "max_price") {
                return {
                  ...prevFilters,
                  [name]: value !== "" ? parseFloat(value) : null, // Convert to number or reset to null
                };
              }
          
              if (name === "sort_by") {
                return {
                  ...prevFilters,
                  [name]: value ,
                };
              }
          
              return prevFilters;
            });
          };


          const fetchFilteredData = async () => {
            setProductLoading(true);
            try {
              const queryParams = new URLSearchParams(filters); // Convert filters to query string
              const response = await fetch(`/product/filter/${category.slug}?${queryParams}`, {
                method: 'GET',
                headers: {
                  'Accept': 'application/json',
                },
              });
          
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
          
              const data = await response.json();
              setFilteredProductData(data.products);
              setTotalPages(data.last_page);
              setSummery({
                total: data.products.total,
                from: data.products.from,  
                to: data.products.to,
              });


            } catch (error) {
              console.error('Error fetching filtered data:', error.message);
            }finally{
              setProductLoading(false);
            }

          };
          

          
          useEffect(() => {
            if (isInitialMount.current) {
              // Skip the first render
              isInitialMount.current = false;
            } else {
              // Call fetchFilteredData only when filters change after the first render
              fetchFilteredData();
            }
          }, [filters]);

        const [isVisible, setIsVisible] = useState(false); // Initialize visibility state
        const sidebarRef = useRef(null); // Reference for the sidebar element
      
        const toggleVisibility = () => {
          setIsVisible(!isVisible); // Toggle the visibility state
        };


  
      // Close the sidebar when clicking outside
      useEffect(() => {
        const handleOutsideClick = (event) => {
          // Check if the click is outside the sidebar
          if (
            sidebarRef.current &&
            !sidebarRef.current.contains(event.target) &&
            isVisible
          ) {
            setIsVisible(false); // Close the sidebar
          }
        };

        // Attach the event listener
        document.addEventListener("mousedown", handleOutsideClick);

        // Cleanup the event listener on component unmount
        return () => {
          document.removeEventListener("mousedown", handleOutsideClick);
        };
      }, [isVisible]);

        
        useEffect(() => {
          if (isVisible) {
            document.body.classList.add('offcanvas__filter--sidebar_active');
          } else {
            document.body.classList.remove('offcanvas__filter--sidebar_active');
          }
      
          
        }, [isVisible]);



    const topRef = useRef(null);
    
  // Update page number
  const handlePageChange = (newPage) => {
    setFilters((prev) => ({ ...prev, page: newPage }));
    
     // Smooth scroll to top of product section
        if (topRef.current) {
          topRef.current.scrollIntoView({
            behavior: "smooth",
            block: "start"
          });
        }

      setCurrentPage(newPage);
     
  };



 console.log(filters);






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
                carts={carts}
            >
                <Head title={category.seo_title?category.seo_title:`${category.name} - ${general.web_title}`} >
                    <meta name="title" property="og:title" content={category.seo_title?category.seo_title:`${category.name} - ${general.web_title}`} />
                    <meta name="description" property="og:description" content={category.seo_description?category.seo_description:general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={category.seo_keyword?category.seo_keyword:general.meta_keyword}/>
                    <meta name="image" property="og:image" content={category.meta_image?category.meta_image:general.logo_url} />
                    <meta name="url" property="og:url" content={route('productCategory', category.slug ? category.slug : 'no-title')} />
                    <link rel="canonical" href={route('productCategory', category.slug ? category.slug : 'no-title')} />
                </Head>

              <section className="breadcrumb__section breadcrumb__bg" >
                  <div className="container">
                      <div className="row row-cols-1">
                          <div className="col">
                              <div className="breadcrumb__content text-center">
                                  <h1 className="breadcrumb__content--title text-white mb-25">{category.name}</h1>
                                  <ul className="breadcrumb__content--menu d-flex justify-content-center">
                                      <li className="breadcrumb__content--menu__items"><Link className="text-white" href={route('index')}>Home </Link></li>
                                      {category.parentCtgs.length > 0 && 
                                        <>
                                            {category.parentCtgs.map((ctg) => (
                                              <li className="breadcrumb__content--menu__items"><Link className="text-white" href={route('productCategory', ctg.slug ? ctg.slug : 'no-title')} > {ctg.name} </Link></li>
                                            ))}
                                        
                                        </>
                                      }
                                      <li className="breadcrumb__content--menu__items"><span className="text-white">{category.name}</span></li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>

         {/* <section class="cgtPageDiscountBanner">
             <div class="container-fluid">
                 <div class="deals__banner--inner banner__bg ctgDiscountBg">
                     <div class="row row-cols-1 align-items-center">
                         <div class="col">
                             <div class="deals__banner--content position__relative">
                                 <h2 class="deals__banner--content__maintitle">FLAT 50% OFF</h2>
                                    <OfferCountDown date='2025-05-05' />
                                    <Link class="primary__btn" href="#">Show Collection
                                        <BsArrowRight />
                                    </Link>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section> */}


         <section className="shop__section section--padding" ref={topRef}>
             <div className="container-fluid">
                 <div className="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                     <button className="widget__filter--btn d-flex d-lg-none align-items-center" onClick={toggleVisibility}>
                         <span className="widget__filter--btn__text">Filter </span>
                     </button>
                     <div className="product__view--mode d-flex align-items-center">
                         <div className="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
                             <label className="product__view--label">Sort By : </label>
                             <div className="select shop__header--select">
                             <select className="form-select product__view--select" name="sort_by" onChange={handleCheckboxChange} >
                                  <option value="latest">Sort by latest </option>
                                  <option value="high">Price (High To Low)</option>
                                  <option value="low">Price (Low To High)</option>
                              </select>
                             </div>
                         </div>
                     </div>
                     <p className="product__showing--count">Showing {summery.from} - {summery.to}  of {summery.total} results </p>
                 </div>
                 <div className="row">
                     <div className="col-xl-3 col-lg-4">
                      <div className="shop__sidebar--widget widget__area d-none d-lg-block">

                            <CategoryFillterSideBar
                                handleCheckboxChange={handleCheckboxChange}
                                filters={filters}
                                maxRange={maxRange}
                                getPercentage={getPercentage}
                                attributes={attributes}
                                subCtg={subCtg}
                                maxPrice={maxPrice}
                                
                                />
                      </div>
                     </div>
                     <div className="col-xl-9 col-lg-8">
                         <div className="shop__product--wrapper">
                            {productLoading ? <p className="text-center">Loading...</p> : 
                            <>
                            {filteredProductData.data.length > 0 ?(
                            <div>
                                <div className="product__section--inner product__grid--inner">
                                    <div className="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                        {filteredProductData.data.map((product, index) => (
                                            <div className="col mb-30" key={index}>
                                                <ProductGrid product={product} />
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                {/* <Pagination pagination={filteredProductData}/> */}
                                <Pagination pagination={filteredProductData} currentPage={filters.page}
                                  totalPages={totalPages}
                                  onPageChange={handlePageChange}/>
                               
                             </div>
                            ) :(
                                <div className="text-center">No products found</div>
                            )
                            }
                            </>
                          }
                         </div>
                     </div>
                 </div>
             </div>
         </section>

          <div  ref={sidebarRef} class={`offcanvas__filter--sidebar widget__area ${isVisible?'active':''}`}>
                <button type="button" class="offcanvas__filter--close" onClick={toggleVisibility}>
                    <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path></svg> <span class="offcanvas__filter--close__text">Close</span>
                </button>
                <div class="offcanvas__filter--sidebar__inner">
                    
                    <CategoryFillterSideBar
                        handleCheckboxChange={handleCheckboxChange}
                        filters={filters}
                        maxRange={maxRange}
                        getPercentage={getPercentage}
                        attributes={attributes}
                        subCtg={subCtg}
                        maxPrice={maxPrice}
                        />
                </div>
          </div>


          </MainLayout>

    </>
  )
}
