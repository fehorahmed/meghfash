import { Link } from "@inertiajs/react";
import { FaYoutube } from "react-icons/fa";
import { BsArrowRight } from "react-icons/bs";
import OfferCountDown from "./OfferCountDown";


export default function HomeDiscountBannerCoponent({timeOfferBanner}) {
  return (
    <>
          <section class="deals__banner--section section--padding pt-0">
             <div class="container-fluid">
                 <div class="deals__banner--inner" 
                 style={{
                    backgroundImage: `url(${timeOfferBanner.image_url})`,
                    backgroundRepeat: "no-repeat",
                    backgroundSize: "cover", 
                    borderRadius: "20px",
                  }}
>
                     <div class="row row-cols-1 align-items-center">
                         <div class="col">
                             <div class="deals__banner--content position__relative">
                                 <span class="deals__banner--content__subtitle text__secondary">{timeOfferBanner.sub_title}</span>
                                 {/* <h2 class="deals__banner--content__maintitle" >{timeOfferBanner.name}</h2> */}
                                 <p class="deals__banner--content__desc"  >{timeOfferBanner.description} </p>
                                 
                                <OfferCountDown date={timeOfferBanner.createdAt}/>

                                 <Link class="primary__btn" href={timeOfferBanner.link}> Show Collection
                                    <BsArrowRight />
                                 </Link>
                                 <br />
                                 {/* <div class="banner__bideo--play">
                                     <a class="banner__bideo--play__icon glightbox" href="https://vimeo.com/115041822" data-gallery="video">
                                     <FaYoutube />
                                         <span class="visually-hidden">Video Play </span>
                                     </a>
                                 </div> */}
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
    </>
  )
}
