import React, { useState, useEffect, useRef } from 'react';
import $ from 'jquery';
import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

// Custom CSS (same as before)
const customStyles = `
  .cloudzoom-zoom-inside {
    cursor: zoom-in;
    z-index: 1;
  }
  #thumbnails {
    position: relative;
    width: 93px;
    height: 330px;
    background-color: #fff;
    float: left;
    z-index: 2;
    overflow: hidden;
  }

  #product-image {
    position: relative;
    display: inline-block;
    line-height: 0;
    margin-left: 1rem;
    overflow: hidden;
  }

    #product-image a img {
    max-width: 600px;
    margin: 0 auto;
    width: 100%;
    transition: 0.5s all;
}
    #product-image a img:hover {
    transform: scale(1.5);
    cursor: all-scroll;
}
  #zoom-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: cover;
    cursor: zoom-out;
    display: none;
    opacity: 0;
    z-index: 1;
    animation: fadeout 0.5s;
  }
  .fullscreen {
    overflow: hidden;
  }
  .fullscreen #thumbnails {
    position: fixed;
    top: 8px;
    left: 8px;
    opacity: 0.8;
  }
  .fullscreen #zoom-overlay {
    animation: fadein 0.5s;
    display: block;
    opacity: 1;
  }
  @keyframes fadein {
    0% { opacity: 0; }
    100% { opacity: 1; }
  }
  @keyframes fadeout {
    0% { opacity: 1; }
    100% { opacity: 0; }
  }
`;

const ProductCarousel = ({ images }) => {
  const [selectedImage, setSelectedImage] = useState(images[0] || ''); // Initialize with the first URL
  const zoomOverlayRef = useRef(null);
  const [slider, setSlider] = useState(null);
  const [currentIndex, setCurrentIndex] = useState(0);

  const settings = {
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    vertical: true,
    verticalSwiping: true,
    swipeToSlide: false,
    focusOnSelect: false,
    beforeChange: (oldIndex, newIndex) => {
      setSelectedImage(images[newIndex] || '');
      setCurrentIndex(newIndex);
    },
    ref: (c) => setSlider(c),
  };

  const goToSlide = (index) => {
    if (slider) {
      slider.slickGoTo(index);
    }
  };

  useEffect(() => {
    if ($('.cloudzoom').length > 0 && $.fn.CloudZoom) {
      $('.cloudzoom').CloudZoom();
    }

    const handleMainImageClick = (e) => {
      e.preventDefault();
      setIsFullScreen(true);
      if (zoomOverlayRef.current) {
        zoomOverlayRef.current.style.display = 'block';
        zoomOverlayRef.current.style.backgroundImage = `url("${selectedImage}")`;
        void zoomOverlayRef.current.offsetWidth;
        zoomOverlayRef.current.style.opacity = 1;
      }
      document.body.classList.add('fullscreen');
    };

    const mainImageLink = $('#product-image').find('a');
    mainImageLink.on('click', handleMainImageClick);

    return () => {
      mainImageLink.off('click', handleMainImageClick);
    };
  }, [selectedImage]);

  const [isFullScreen, setIsFullScreen] = useState(false);
  let nTimer = 0;

  const handleZoomOverlayClick = () => {
    setIsFullScreen(false);
    document.body.classList.remove('fullscreen');
    clearTimeout(nTimer);
    nTimer = setTimeout(() => {
      if (zoomOverlayRef.current) {
        zoomOverlayRef.current.style.opacity = 0;
        setTimeout(() => {
          if (zoomOverlayRef.current) {
            zoomOverlayRef.current.style.display = 'none';
          }
        }, 500);
      }
    }, 0);
  };

  const handleZoomOverlayMouseMove = (e) => {
    if (zoomOverlayRef.current) {
      const W = window.innerWidth;
      const H = window.innerHeight;
      zoomOverlayRef.current.style.backgroundPosition = `${(e.clientX / W) * 100}% ${(e.clientY / H) * 100}%`;
    }
  };

  const handleInsideZoomMouseMove = (e) => {
    if (zoomOverlayRef.current) {
      const target = e.currentTarget;
      const W = target.clientWidth;
      const H = target.clientHeight;
      const nX = e.pageX - target.offsetLeft;
      const nY = e.pageY - target.offsetTop;
      zoomOverlayRef.current.style.backgroundPosition = `${(nX / W) * 100}% ${(nY / H) * 100}%`;
    }
  };

  useEffect(() => {
    if (zoomOverlayRef.current) {
      $(zoomOverlayRef.current).on('click', handleZoomOverlayClick);
      $(zoomOverlayRef.current).on('mousemove', handleZoomOverlayMouseMove);
    }
    $('body').on('mousemove', '.cloudzoom-zoom-inside', handleInsideZoomMouseMove);

    return () => {
      if (zoomOverlayRef.current) {
        $(zoomOverlayRef.current).off('click', handleZoomOverlayClick);
        $(zoomOverlayRef.current).off('mousemove', handleZoomOverlayMouseMove);
      }
      $('body').off('mousemove', '.cloudzoom-zoom-inside', handleInsideZoomMouseMove);
      clearTimeout(nTimer);
    };
  }, [selectedImage, isFullScreen]);

  return (
    <>
      <style>{customStyles}</style>
      <div className="productThamnelGalleryDiv">
      <div id="thumbnails">
        <Slider {...settings}>
          {images.map((image, index) => (
            <div key={index} onClick={() => goToSlide(index)}>
              <img
                src={image} // Now 'image' is a URL string
                alt={`thumbnail ${index + 1}`}
                style={{display: 'block', cursor: 'pointer', border: currentIndex === index ? '2px solid #007bff' : 'none' }}
              />
            </div>
          ))}
        </Slider>
      </div>

      <div id="product-image">
        <a href={selectedImage}>
          <img
            className="cloudzoom"
            src={selectedImage} // Use the currently selected image URL
            alt="product image"
            data-cloudzoom={`
              zoomPosition:'inside',
              zoomOffsetX:0,
              zoomFlyOut:false,
              variableMagnification:false,
              disableZoom:'auto',
              touchStartDelay:100,
              propagateGalleryEvent:true,
              image:'${selectedImage}' // Dynamically update the large image for zoom
            `}
          />
        </a>
      </div>
      </div>

      <div id="zoom-overlay" ref={zoomOverlayRef} style={{ display: 'none', opacity: 0 }}></div>
    </>
  );
};

export default ProductCarousel;