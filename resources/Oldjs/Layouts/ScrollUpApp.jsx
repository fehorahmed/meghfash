import React, { useState, useEffect } from "react";
import { FaArrowUp } from "react-icons/fa";


const ScrollUpApp = () => {
    const [showScroll, setShowScroll] = useState(false);

    // Handle scroll event to toggle the visibility of the button
        useEffect(() => {
        const handleScroll = () => {
            if (window.scrollY >= 400) {
                setShowScroll(true);
            } else {
                setShowScroll(false);
            }
        };

        // Add scroll event listener
        window.addEventListener("scroll", handleScroll);

        // Cleanup the event listener on component unmount
        return () => {
            window.removeEventListener("scroll", handleScroll);
        };
    }, []);

    // Scroll to top function
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

    return (
        <div>
            {showScroll && (

                <div className="upArrowDiv"  style={{
                    position: "fixed",
                    bottom: "30px",
                    right: "20px",
                    cursor: "pointer",
                }}
                onClick={scrollToTop}
                >
                        <FaArrowUp />
                </div>
               
            )}
        </div>
    );
};

export default ScrollUpApp;