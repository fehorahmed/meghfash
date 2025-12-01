import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay} from 'swiper/modules';
// import 'animate.css';
import { useRef } from 'react';
import { useEffect } from 'react';

import { Navigation } from 'swiper/modules';

export default function HomeSliderComponent({sliders}) {
  const swiperRef = useRef(null);

  useEffect(() => {
    // Ensure Swiper instance is initialized
    const swiper = swiperRef.current?.swiper;
    if (!swiper) return;

    // Add animation to the first slide after the swiper is initialized
    // const slides = swiper.wrapperEl.querySelectorAll('.swiper-slide');
    // if (slides.length > 0) {
    //   slides[0].classList.add('animate__animated', 'animate__rotateIn',);
    // }

    // Listen to slide change events and trigger animations
    // swiper.on('slideChangeTransitionStart', () => {
    //   const slides = swiper.wrapperEl.querySelectorAll('.swiper-slide');
    //   slides.forEach((slide) => slide.classList.remove('animate__animated', 'animate__rotateIn',));

    //   const activeSlide = swiper.wrapperEl.querySelector('.swiper-slide-active');
    //   if (activeSlide) {
    //     // Adding a short timeout to allow the class to take effect
    //     setTimeout(() => {
    //       activeSlide.classList.add('animate__animated', 'animate__rotateIn',);
    //     }, 50); // 50ms delay to trigger the animation
    //   }
    // });

    // Cleanup event listener on component unmount
    return () => {
      if (swiper) {
        swiper.off('slideChangeTransitionStart');
      }
    };
  }, []);


  
  return (
    <>
      <div className="homeSliderMain">
      <Swiper
        ref={swiperRef} // Attach the ref directly to the Swiper component
       
       
        className="mySwiper"
        navigation={true} modules={[Navigation]}
      >
        {sliders.map((slider, index) => (
          <SwiperSlide key={index}>
            {slider.button_link ? (
              <div style={{textAlign:'center'}}>
                <a href={slider.button_link} target="_blank" rel="noreferrer">
                  <img src={slider.image} alt={slider.title} />
                </a>
              </div>
            ):(
            <div style={{textAlign:'center'}}>
              <img src={slider.image} alt={slider.title} />
            </div>
            )}
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
    </>
  )
}
