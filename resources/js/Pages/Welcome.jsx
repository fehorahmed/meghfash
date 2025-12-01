
import DemoImageComponent from "@/Components/DemoImageComponent";
import HomeBestSellerCoponent from "@/Components/Home/HomeBestSellerCoponent";
import HomeCategoryComponent from "@/Components/Home/HomeCategoryComponent";
import HomeCelebretiGalleryComponent from "@/Components/Home/HomeCelebretiGalleryComponent";
import HomeDiscountBannerCoponent from "@/Components/Home/HomeDiscountBannerCoponent";
import HomeNewProductComponent from "@/Components/Home/HomeNewProductComponent";
import HomeNewsAndBlog from "@/Components/Home/HomeNewsAndBlog";
import HomeSliderComponent from "@/Components/Home/HomeSliderComponent";
import NewsletterPopup from "@/Components/NewsletterPopup";
import OurClients from "@/Components/Home/OurClients";
import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import WowSlider from "@/Components/Home/WowSlider";
import HomePopupModal from "@/Components/Home/HomePopupModal";
import { useEffect, useState } from "react";

export default function Welcome({
    general,
    sliders,
    headerMenu,
    categoryMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    topProducts,
    trandingProducts,
    latestProducts,
    clients,
    bannerGroupOne,
    timeOfferBanner,
    galleries,
    promotions,
    auth,
    blogs,
    carts,
    popupActive 
}) { 



  
  const [showModal, setShowModal] = useState(false);

  useEffect(() => {
    // If Laravel data says popup is active, show it
    if (popupActive) {
      setShowModal(true);
    }
  }, [popupActive]);



    return (
        <>
            <MainLayout
                auth={auth}
                general={general}
                headerMenu={headerMenu}
                categoryMenu={categoryMenu}
                footerMenu4={footerMenu4}
                footerMenu2={footerMenu2}
                footerMenu3={footerMenu3}
                carts={carts}
            >
                <Head>
                    <meta name="title" property="og:title" content={general.meta_title} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword} />
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('index')} />
                    <link rel="canonical" href={route('index')} />
                </Head>
                <NewsletterPopup
                 
                
                />

                <HomePopupModal
                pupdata={popupActive}
                show={showModal}
                    onClose={() => setShowModal(false)}
                />




                {sliders.length > 0 && 
                <HomeSliderComponent sliders={sliders} />
                }

           
                <HomeNewProductComponent topProducts={topProducts} trandingProducts={trandingProducts} latestProducts={latestProducts} />

                {bannerGroupOne.length > 0 &&   
                <HomeCategoryComponent bannerGroupOne={bannerGroupOne}/>
                }

                
                {timeOfferBanner &&
                <HomeDiscountBannerCoponent timeOfferBanner={timeOfferBanner} />
                }

                {promotions.length > 0 && 
                    <>
                        {promotions.map((promotion)=> (
                            <>
                                 <DemoImageComponent image={promotion?.image_url} imageLink={promotion?.image_link} name={promotion?.name}/>
                                 <HomeBestSellerCoponent latestProducts={promotion?.products} name={promotion?.name}/>
                            </>
                        ))}
                       
                        
                    </>
                }

               

                {galleries.length > 0 &&
                <HomeCelebretiGalleryComponent galleries={galleries} general={general} />
                }

                {clients.length > 0 && 
                <OurClients clients={clients} />
                }
                {blogs.length > 0 && 
                <HomeNewsAndBlog blogs={blogs}/>
                }
          
            </MainLayout>
        </>
    );
}
