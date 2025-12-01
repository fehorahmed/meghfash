import React, { useState, useEffect } from "react";


const WowSlider = ({sliders}) => {

    const [currentIndex, setCurrentIndex] = useState(0);

    // Auto-slide every 3 seconds
    useEffect(() => {
      const interval = setInterval(() => {
        setCurrentIndex((prevIndex) => (prevIndex + 1) % sliders.length);
      }, 3000);
      return () => clearInterval(interval); // Cleanup interval on unmount
    }, [sliders.length]);
  
    // Function to handle bullet navigation
    const goToSlide = (index) => {
      setCurrentIndex(index);
    };

  return (
    <>
   
   <div className="slider-container">
      <div className="slider">
        {sliders.map((slide, index) => (
          <div
            key={index}
            className={`slide ${index === currentIndex ? "active" : ""}`}
            style={{ backgroundImage: `url(${slide.image})` }}
          ></div>
        ))}
      </div>

      {/* Bullets Navigation */}
      <div className="bullets">
        {sliders.map((_, index) => (
          <span
            key={index}
            className={`bullet ${index === currentIndex ? "active" : ""}`}
            onClick={() => goToSlide(index)}
          ></span>
        ))}
      </div>
    </div>


    </>
  );
};

export default WowSlider;
