
import Slider from "react-slick";
import BlogGrid from "../blogs/BlogGrid";
export default function HomeNewsAndBlog({blogs}) {
    var settings = {
        dots: false,
        infinite: true,
        autoplay: true,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        initialSlide: 0,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
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
        <section class="blog__section section--padding pt-0 homeNews">
             <div class="container-fluid">
                 <div class="section__heading text-center mb-40">
                     <h2 class="section__heading--maintitle">News & Blog </h2>
                 </div>
                <div className="slider-container">
                        <Slider {...settings}>
                            {blogs.map((blog, index) => (
                                <BlogGrid key={index} blog={blog} />
                            ))}
                        </Slider>
                </div>  

                </div>
         </section> 
    </>
  )
}
