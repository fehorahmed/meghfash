import React, { useState, useEffect } from 'react';

const NewsletterPopup = () => {
  const [isPopupVisible, setIsPopupVisible] = useState(false);
  const [isChecked, setIsChecked] = useState(false);

  // Check local storage if user doesn't want to see the popup again
  useEffect(() => {
    const isPopupDisabled = localStorage.getItem('dontShowPopup') === 'true';
    if (!isPopupDisabled) {
      // Show popup after 2 seconds
      setTimeout(() => {
        setIsPopupVisible(true);
      }, 500); // Adjust the delay as needed
    }
  }, []);

  // Close popup function
  const closePopup = () => {
    setIsPopupVisible(false);
  };

  // Handle 'Don't show this again' checkbox change
  const handleCheckboxChange = (event) => {
    setIsChecked(event.target.checked);
    if (event.target.checked) {
      localStorage.setItem('dontShowPopup', 'true');
    } else {
      localStorage.removeItem('dontShowPopup');
    }
  };

  return (
    <>
      {isPopupVisible && (
        <div className="newsletter__popup" data-animation="slideInUp">
          <div id="boxes" className="newsletter__popup--inner">
            <button
              className="newsletter__popup--close__btn"
              aria-label="search close button"
              onClick={closePopup}
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                <path
                  fill="currentColor"
                  stroke="currentColor"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="32"
                  d="M368 368L144 144M368 144L144 368"
                ></path>
              </svg>
            </button>
            <div className="box newsletter__popup--box d-flex align-items-center">
              <div className="newsletter__popup--thumbnail">
                <img
                  className="newsletter__popup--thumbnail__img display-block"
                  src="assets/img/banner/newsletter-popup-thumb2.png"
                  alt="newsletter-popup-thumb"
                />
              </div>
              <div className="newsletter__popup--box__right">
                <h2 className="newsletter__popup--title">Join Our Newsletter</h2>
                <div className="newsletter__popup--content">
                  <label className="newsletter__popup--content--desc">
                    Enter your email address __ subscribe to our notification of new posts &amp; features.
                  </label>
                  <div className="newsletter__popup--subscribe" id="frm_subscribe">
                    <form className="newsletter__popup--subscribe__form">
                      <input
                        className="newsletter__popup--subscribe__input"
                        type="text"
                        placeholder="Enter your email address here..."
                      />
                      <button className="newsletter__popup--subscribe__btn">Subscribe</button>
                    </form>
                    <div className="newsletter__popup--footer">
                      <input
                        type="checkbox"
                        id="newsletter__dont--show"
                        checked={isChecked}
                        onChange={handleCheckboxChange}
                      />
                      <label className="newsletter__popup--dontshow__again--text" htmlFor="newsletter__dont--show">
                        Don't show this popup again
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
};

export default NewsletterPopup;
