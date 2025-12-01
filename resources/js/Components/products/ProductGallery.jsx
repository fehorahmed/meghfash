import { Swiper, SwiperSlide } from "swiper/react";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import { useState } from "react";
import { useRef } from "react";
import { useEffect } from "react";
import { CiPlay1 } from "react-icons/ci";

export default function ProductGallery({images, product}) {
    const [thumbsSwiper, setThumbsSwiper] = useState(null);


    const [isModalOpen, setIsModalOpen] = useState(false);
     const videoRef = useRef(null); // Reference for the sidebar element

    // Function to open modal
    const openModal = () => {
      setIsModalOpen(true);
    };
  
    // Function to close modal
    const closeModal = () => {
      setIsModalOpen(false);
    };



// Styles
const modalStyles = {
    overlay: {
      position: "fixed",
      top: 0,
      left: 0,
      width: "100%",
      height: "100%",
      backgroundColor: "rgba(0, 0, 0, 0.7)",
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      zIndex: 1000,
      transition: "opacity 0.3s ease-in-out", // Smooth fade-in for overlay
    },
    modal: {
      position: "relative",
      backgroundColor: "#fff",
      padding: "20px",
      borderRadius: "10px",
      width: "1000px",
      height: "500px",
      boxShadow: "0 4px 10px rgba(0, 0, 0, 0.3)",
      textAlign: "center",
      transform: "scale(0.9)", // Initial scale for animation
      transition: "transform 0.3s ease-in-out", // Smooth scale animation
    },
    closeButton: {
      position: "absolute",
      top: "10px",
      right: "10px",
      backgroundColor: "transparent",
      border: "none",
      fontSize: "24px",
      cursor: "pointer",
    },
  };
  
  // Add animation on render with a CSS class
  const modalAnimationStyles = `
  .modal-animation {
    animation: scaleUp 0.3s ease-in-out forwards;
  }
  
  @keyframes scaleUp {
    from {
      transform: scale(0.9);
      opacity: 0;
    }
    to {
      transform: scale(1);
      opacity: 1;
    }
  }
  `;
  
  // Append the animation styles to the document head
  const appendStyles = () => {
    const styleElement = document.createElement("style");
    styleElement.innerHTML = modalAnimationStyles;
    document.head.appendChild(styleElement);
  };
  appendStyles();


// Close the sidebar when clicking outside
    useEffect(() => {
    const handleOutsideClick = (event) => {
        // Check if the click is outside the sidebar
        if (
        videoRef.current &&
        !videoRef.current.contains(event.target) &&
        isModalOpen
        ) {
        setIsModalOpen(false); // Close the sidebar
        }
    };

    // Attach the event listener
    document.addEventListener("mousedown", handleOutsideClick);

    // Cleanup the event listener on component unmount
    return () => {
        document.removeEventListener("mousedown", handleOutsideClick);
    };
    }, [isModalOpen]);




    return (
        <>
    
            <div className="productDetailThamelSlider">
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

                    {images.map((image2) => (
                        <SwiperSlide>
                            <img src={image2} />
                        </SwiperSlide>

                    ))}

                  {product.video.video_url &&
                     <SwiperSlide>
                            <div  onClick={openModal}>
                            <img src={product.video.image_url}/>
                            <span className="playIcon"><CiPlay1 /></span>
                            </div>
                    </SwiperSlide>
                    }

                    
                </Swiper>
                <Swiper onSwiper={setThumbsSwiper} loop={true} spaceBetween={10} slidesPerView={4} freeMode={true} watchSlidesProgress={true} modules={[FreeMode, Navigation, Thumbs]} className="mySwiper">
                    {images.map((image) => (
                    <SwiperSlide>
                        <img src={image} />
                    </SwiperSlide>
                    ))}

                    {product.video.video_url &&
                     <SwiperSlide>
                            <div  onClick={openModal}>
                            <img src={product.video.image_url}/>
                            <span className="playIcon"><CiPlay1 /></span>
                            </div>
                            
                    </SwiperSlide>
                    }


                </Swiper>
            </div>


            {/* Modal */}
            {isModalOpen && (
                <div style={modalStyles.overlay}>
                    <div  ref={videoRef} style={modalStyles.modal} className="modal-animation">
                        <button style={modalStyles.closeButton} onClick={closeModal}>
                            &times;
                        </button>
                        <video
                            src={product?.video?.video_url}
                            preload="auto"
                            controls
                            autoPlay
                            style={{ width: "100%", height: "100%", display: "block" }}
                        />
                    </div>
                </div>
            )}


            
 
        </>
    );
}
