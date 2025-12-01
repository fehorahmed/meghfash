
import Slider from "react-slick";
export default function OurClients({clients}) {
    var settings = {
        dots: false,
        infinite: true,
        autoplay: true,
        speed: 1000,
        slidesToShow: 3,
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
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      };
  return (
    <>
         <section class="testimonial__section section--padding pt-0 ourClients">
             <div class="container-fluid">
                 <div class="section__heading text-center mb-40">
                     <h2 class="section__heading--maintitle">Our Clients Say </h2>
                 </div>

                    <div className="slider-container">
                            <Slider {...settings}>
                                {clients.map((client, index) => (
                                <div class="testimonial__items text-center">
                                 <div class="testimonial__items--thumbnail">
                                     <img class="testimonial__items--thumbnail__img border-radius-50" src={client.image_url} alt={client.name} />
                                 </div>
                                 <div class="testimonial__items--content">
                                     <h3 class="testimonial__items--title">{client.name}</h3>
                                     {/* <span class="testimonial__items--subtitle"> </span> */}
                                     <p class="testimonial__items--desc">
                                     {client.short_description}
                                     </p>
                                     <ul class="rating testimonial__rating d-flex justify-content-center">
                                         <li class="rating__list">
                                             <span class="rating__list--icon">
                                                 <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                 <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                 </svg>
                                             </span>
                                         </li>
                                         <li class="rating__list">
                                             <span class="rating__list--icon">
                                                 <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                 <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                 </svg>
                                             </span>
                                         </li>
                                         <li class="rating__list">
                                             <span class="rating__list--icon">
                                                 <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                 <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                 </svg>
                                             </span>
                                         </li>
                                         <li class="rating__list">
                                             <span class="rating__list--icon">
                                                 <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                 <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                 </svg>
                                             </span>
                                         </li>
                                         <li class="rating__list">
                                             <span class="rating__list--icon">
                                                 <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewbox="0 0 10.105 9.732">
                                                 <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                 </svg>
                                             </span>
                                         </li>

                                     </ul>
                                 </div>
                                </div>
                                ))}
                            </Slider>
                    </div>

            </div>
        </section>
        

    </>
  )
}
