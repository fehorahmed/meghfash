import { useState } from "react";


export default function CategoryFillterSideBar({
    handleCheckboxChange,
    filters,
    maxRange,
    getPercentage,
    attributes,
    subCtg,
    maxPrice,
}) {
     // State to toggle submenu visibility
     const [isSubmenuOpen, setIsSubmenuOpen] = useState(true);

     const [isPriceOpen, setIsPriceOpen] = useState(true);

     const [toggleStates, setToggleStates] = useState({});
 

     const handleToggle = (id) => {
        setToggleStates((prevState) => ({
          ...prevState,
          [id]: !prevState[id], // Toggle the state for the given id
        }));
      };
     // Toggle function
     const handleToggleSubmenu = () => {
         setIsSubmenuOpen(!isSubmenuOpen);
         handleCheckboxChange();
        // const { 'category', value, checked, type } = e.target;
     };
 
    

     // price Toggle function
     const handleTogglePrice = () => {
        setIsPriceOpen(!isPriceOpen);
     };


 
  return (
    <>
         <div className="mainSidebar">

            {subCtg.length > 0 &&
            <div className="single__widget widget__bg">
            <h2 className="widget__title h3">
               
                <label
                    className="widget__categories--menu__label d-flex align-items-center"
                    onClick={handleToggleSubmenu} // Toggle on click
                    style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                >
                    
                    <span className="widget__categories--menu__text">
                    Categories
                    </span>
                    <svg
                        className={`widget__categories--menu__arrowdown--icon ${
                            isSubmenuOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                        }`}
                        xmlns="http://www.w3.org/2000/svg"
                        width="12.355"
                        height="8.394"
                    >
                        <path
                            d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                            transform="translate(-6 -8.59)"
                            fill="currentColor"
                        ></path>
                    </svg>
                </label>
            </h2>
            <ul className="widget__categories--menu">
                <li className="">
                    {isSubmenuOpen && ( // Conditionally render submenu
                        <ul className={`widget__categories--sub__menu ${
                            isSubmenuOpen ? "open" : ""
                        }`}>
                            
                            {subCtg.map((ctg)=>(
                                <li  key={ctg.id} className="widget__categories--sub__menu--list fabric">
                                <label className="widget__form--check__label" for={`flexCheckDefault${ctg.id}`} >

                                    {ctg.name}
                                </label>
                            
                                <div className="form-check">
                                    <input className="form-check-input" type="checkbox"  name="category" value={ctg.id} id={`flexCheckDefault${ctg.id}`}
                                        onChange={handleCheckboxChange}  
                                        checked={filters.category.includes(ctg.id.toString())}
                                     />
                                </div>
                            </li>
                            ))}
                            
                            
                       

                        </ul>
                    )}
                </li>
            </ul>
            </div>
            }

            {attributes.length > 0 &&
            attributes.map((attribute) => (
                <div key={attribute.id} className="single__widget widget__bg">
                <h2 className="widget__title h3">
                    <label
                    className="widget__categories--menu__label d-flex align-items-center"
                    onClick={() => handleToggle(attribute.id)} // Pass the id dynamically
                    style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                    >
                    <span className="widget__categories--menu__text">
                        {attribute.name}
                    </span>
                    <svg
                        className={`widget__categories--menu__arrowdown--icon ${
                        toggleStates[attribute.id] ? "rotate-icon" : "" // Rotate icon if open
                        }`}
                        xmlns="http://www.w3.org/2000/svg"
                        width="12.355"
                        height="8.394"
                    >
                        <path
                        d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                        transform="translate(-6 -8.59)"
                        fill="currentColor"
                        ></path>
                    </svg>
                    </label>
                </h2>
                <ul className="widget__categories--menu">
                    <li>
                    {toggleStates[attribute.id] && ( // Conditionally render submenu
                        <ul
                        className={`widget__categories--sub__menu ${
                            toggleStates[attribute.id] ? "open" : ""
                        }`}
                        >
   
                        {attribute.subAttr.map((attr)=>(
                            <li className="widget__categories--sub__menu--list fabric">
                            <div className="form-check">
                            <input
                                className="form-check-input"
                                type="checkbox"
                                name="fabric"
                                value={attr.id}
                                id={`flexCheckDefault-${attr.id}-1`}
                                onChange={handleCheckboxChange}
                                checked={filters.fabric.includes(attr.id.toString())}
                            />
                            <label
                                className="form-check-label"
                                htmlFor={`flexCheckDefault-${attr.id}-1`}
                            >
                                {attr.name}
                            </label>
                            </div>
                        </li>
                        ))}
                        

                        </ul>
                    )}
                    </li>
                </ul>
                </div>
            ))}


            
            {maxPrice > 0 && 
            <div className="single__widget price__filter widget__bg">
                <h2 className="widget__title h3">
                <label
                        className="widget__categories--menu__label d-flex align-items-center"
                        onClick={handleTogglePrice} // Toggle on click
                        style={{ cursor: "pointer" }} // Optional: Add pointer cursor for better UX
                    >
                       
                        <span className="widget__categories--menu__text">
                        Filter By Price 
                        </span>
                        <svg
                            className={`widget__categories--menu__arrowdown--icon ${
                                isPriceOpen ? "rotate-icon" : "" // Add a rotation class for open state (optional)
                            }`}
                            xmlns="http://www.w3.org/2000/svg"
                            width="12.355"
                            height="8.394"
                        >
                            <path
                                d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                transform="translate(-6 -8.59)"
                                fill="currentColor"
                            ></path>
                        </svg>
                </label>
                </h2>
                {isPriceOpen && ( 
                <form className={`price__filter--form ${ isPriceOpen ? "open" : "" }`} action="#"> 

                <div className="slider-container">
                    <div className="range-values">
                        <span>BDT : {filters.min_price} </span>
                        <span>BDT : {filters.max_price} </span>
                    </div>
                    <div className="slider-track">
                        <input
                        type="range"
                        name="min_price"
                        value={filters.min_price}
                        min="0"
                        max={maxRange}
                        onChange={handleCheckboxChange}
                        className="thumb thumb-left"
                        />
                        <input
                        type="range"
                        name="max_price"
                        value={filters.max_price}
                        min="0"
                        max={maxRange}
                        onChange={handleCheckboxChange}
                        className="thumb thumb-right"
                        />
                        <div
                        className="range-highlight"
                        style={{
                            left: `${getPercentage(filters.min_price)}%`,
                            width: `${getPercentage(filters.max_price) - getPercentage(filters.min_price)}%`,
                        }}
                        ></div>
                    </div>
                </div>



                </form>
                )}
            </div>
            }

        </div>


        <style>
    {`
    .slider-container {
    margin: 20px auto;
    position: relative;
  }
  
  .range-values {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  
  .slider-track {
    position: relative;
    height: 6px;
    background: #ddd;
    border-radius: 3px;
  }
  
  .thumb {
    position: absolute;
    width: 100%;
    pointer-events: none;
    -webkit-appearance: none;
    appearance: none;
    background: transparent;
  }
  
  .thumb::-webkit-slider-thumb {
    pointer-events: all;
    width: 16px;
    height: 16px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
  }
  
  .thumb::-moz-range-thumb {
    pointer-events: all;
    width: 16px;
    height: 16px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
  }
  
  .range-highlight {
    position: absolute;
    top: 0;
    height: 100%;
    background: #007bff;
    border-radius: 3px;
    z-index: 1;
  }
    .range-values span {
    background-color: #0092d7;
    color: #fff;
    padding: 1px 10px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 3px;
    margin-bottom: 10px;
    }

    `}
</style>





    </>
  )
}
