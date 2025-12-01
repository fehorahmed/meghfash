import React, { useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
// import { Thumbs } from "swiper"; // Correct import for Swiper v7+
import {  Thumbs } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";

const SwiperThumbsGallery = () => {
  const [thumbsSwiper, setThumbsSwiper] = useState(null);

  const images = [
    "https://www.aarong.com/media/catalog/product/1/4/1420000180072.jpg",
    "https://www.aarong.com/media/catalog/product/1/4/1420000180072.jpg",
    "https://www.aarong.com/media/catalog/product/1/4/1420000180072.jpg",
    "https://www.aarong.com/media/catalog/product/1/4/1420000180072.jpg",
    "https://www.aarong.com/media/catalog/product/1/4/1420000180072.jpg",
  ];

  return (
    <div className="swiper-gallery">
      {/* Main Swiper */}
      <Swiper
        spaceBetween={10}
        navigation={true}
        thumbs={{ swiper: thumbsSwiper }}
        modules={[Thumbs]} // Add Thumbs module here
        className="main-swiper"
      >
        {images.map((image, index) => (
          <SwiperSlide key={index}>
            <img src={image} alt={`Slide ${index}`} />
          </SwiperSlide>
        ))}
      </Swiper>

      {/* Thumbnail Swiper */}
      <Swiper
        onSwiper={setThumbsSwiper}
        spaceBetween={10}
        slidesPerView={4}
        watchSlidesProgress={true}
        modules={[Thumbs]} // Add Thumbs module here
        className="thumbs-swiper"
      >
        {images.map((image, index) => (
          <SwiperSlide key={index}>
            <img src={image} alt={`Thumbnail ${index}`} />
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
  );
};

export default SwiperThumbsGallery;
