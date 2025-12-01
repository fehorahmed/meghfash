import React, { useEffect, useRef, useState } from "react";
import { IoCloseOutline, IoEyeOutline } from "react-icons/io5";

// Modal component
export default function QuickViewModal({ isOpen, onClose, content }) {
    const modalRef = useRef(null);

    // Close the modal when clicking outside the modal body
    const handleClickOutside = (event) => {
        if (modalRef.current && !modalRef.current.contains(event.target)) {
            onClose();
        }
    };

    // Attach and clean up event listeners
    useEffect(() => {
        if (isOpen) {
            document.addEventListener("mousedown", handleClickOutside);
        } else {
            document.removeEventListener("mousedown", handleClickOutside);
        }

        return () => {
            document.removeEventListener("mousedown", handleClickOutside);
        };
        
    }, [isOpen]);

    return (
        <div
            style={{
                display: isOpen ? "flex" : "none",
                position: "fixed",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%",
                backgroundColor: "rgba(0, 0, 0, 0.5)",
                alignItems: "center",
                justifyContent: "center",
                zIndex: 1000,
            }}
        >
            <div
                ref={modalRef}
                style={{
                    background: "#fff",
                    borderRadius: "8px",
                    boxShadow: "0 2px 10px rgba(0, 0, 0, 0.2)",
                    padding: "20px",
                    maxWidth: "1000px",
                    width: "100%",
                    animation: isOpen ? "slideIn 0.3s ease" : "slideOut 0.3s ease",
                    transformOrigin: "center",
                }}
            >
                 <button
                    onClick={onClose}
                    style={{
                        float: "right",
                        background: "#e5d3d38f",
                        border: "none",
                        fontSize: "20px",
                        cursor: "pointer",
                        width: '28px',
                        height: '28px',
                        borderRadius: '50%',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                    }}
                >
                    <IoCloseOutline />
                    
                </button>
              
                <div>{content}</div>
            </div>
            <style>
                {`
        @keyframes slideIn {
          from {
            transform: translateY(20%);
            opacity: 0;
          }
          to {
            transform: translateY(0);
            opacity: 1;
          }
        }

        @keyframes slideOut {
          from {
            transform: translateY(0);
            opacity: 1;
          }
          to {
            transform: translateY(20%);
            opacity: 0;
          }
        }
      `}
            </style>
        </div>
    );
}
