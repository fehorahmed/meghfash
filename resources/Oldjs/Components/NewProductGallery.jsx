import { Swiper, SwiperSlide } from "swiper/react";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import { useState } from "react";
// Add this for custom styling
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";

export default function NewProductGallery() {
  const [thumbsSwiper, setThumbsSwiper] = useState(null);
  const [position, setPosition] = useState({ x: 0, y: 0 });
  const [zoom, setZoom] = useState(false);

  const handleMouseEnter = () => setZoom(true);
  const handleMouseLeave = () => {
    setZoom(false);
    setPosition({ x: 0, y: 0 });
  };
  const handleMouseMove = (e) => {
    const rect = e.target.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width) * 100;
    const y = ((e.clientY - rect.top) / rect.height) * 100;
    setPosition({ x, y });
  };

  return (
    <>
      <div className="productDetailThamelSlider">
        {/* Main Swiper */}
        <Swiper
          style={{
            "--swiper-navigation-color": "#fff",
            "--swiper-pagination-color": "#fff",
          }}
          loop={true}
          spaceBetween={10}
          navigation={true}
          thumbs={{ swiper: thumbsSwiper }}
          modules={[FreeMode, Navigation, Thumbs]}
          className="mySwiper2"
        >
          {/* First SwiperSlide with hover zoom effect */}
          <SwiperSlide>
            <div
              className="zoomable-image"
              onMouseEnter={handleMouseEnter}
              onMouseMove={handleMouseMove}
              onMouseLeave={handleMouseLeave}
              style={{
                overflow: "hidden",
                position: "relative",
                width: "100%",
                height: "100%",
              }}
            >
              <img
                src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product2.jpg"
                alt="Product"
                style={{
                  width: "100%",
                  height: "100%",
                  transform: zoom
                    ? `scale(2) translate(-${position.x}%, -${position.y}%)`
                    : "scale(1)",
                  transition: "transform 0.2s ease-out",
                  transformOrigin: "center center",
                }}
              />
            </div>
          </SwiperSlide>

          {/* Other SwiperSlides */}
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product3.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product4.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product5.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product6.jpg" />
          </SwiperSlide>
        </Swiper>

        {/* Thumbnail Swiper */}
        <Swiper
          onSwiper={setThumbsSwiper}
          loop={true}
          spaceBetween={10}
          slidesPerView={4}
          freeMode={true}
          watchSlidesProgress={true}
          modules={[FreeMode, Navigation, Thumbs]}
          className="mySwiper"
        >
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product2.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product3.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product4.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product5.jpg" />
          </SwiperSlide>
          <SwiperSlide>
            <img src="https://risingtheme.com/html/demo-suruchi-v1/suruchi/assets/img/product/big-product6.jpg" />
          </SwiperSlide>
        </Swiper>
      </div>
    </>
  );
}
