import React, { useEffect, useState, useRef } from "react";
import { IoCloseOutline } from "react-icons/io5";

const HomePopupModal = ({ show, onClose, pupdata }) => {
  console.log(pupdata);
  const [visible, setVisible] = useState(false);
  const modalRef = useRef(null);

  useEffect(() => {
    if (show) {
      setTimeout(() => setVisible(true), 10);
      // Add event listener when modal is shown
      document.addEventListener("mousedown", handleClickOutside);
    } else {
      setVisible(false);
      // Remove event listener when modal is hidden
      document.removeEventListener("mousedown", handleClickOutside);
    }

    // Cleanup function
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [show]);

  // Handle click outside the modal
  const handleClickOutside = (event) => {
    if (modalRef.current && !modalRef.current.contains(event.target)) {
      onClose();
    }
  };

  // Handle escape key press
  useEffect(() => {
    const handleEscapeKey = (event) => {
      if (event.key === "Escape") {
        onClose();
      }
    };

    if (show) {
      document.addEventListener("keydown", handleEscapeKey);
    }

    return () => {
      document.removeEventListener("keydown", handleEscapeKey);
    };
  }, [show, onClose]);

  if (!show && !visible) return null;

  return (
    <div className={`popup-overlay ${visible ? "show" : ""}`}>
      <div 
        className={`popup-modal ${visible ? "fade-in" : "fade-out"}`}
        ref={modalRef}
      >
        <button className="closeButton" onClick={onClose}>
          <IoCloseOutline />
        </button>
        <a href={pupdata.sub_title ? pupdata.sub_title : "#"}>
          <img src={pupdata.image} alt="" />
        </a>
      </div>
    </div>
  );
};

export default HomePopupModal;