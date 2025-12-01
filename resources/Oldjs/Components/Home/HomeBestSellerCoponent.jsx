import Slider from "react-slick";
import ProductGrid from "../products/ProductGrid";
export default function HomeBestSellerCoponent({latestProducts, name}) {

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
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      };

  return (
    
    <>
         <section class="product__section section--padding pt-0 homeBest">
             <div class="container-fluid">
                    <div class="section__heading text-center mb-50">
                        <h2 class="section__heading--maintitle">{name}</h2>
                    </div>
                    {latestProducts.length > 0 &&
                    <div className="slider-container ">
                        <Slider {...settings}>
                            {latestProducts.map((product, index) => (
                                <ProductGrid product={product} />
                            ))}
                        </Slider>
                    </div>
                    }
              </div>
         </section>   
    </>
  )
}
