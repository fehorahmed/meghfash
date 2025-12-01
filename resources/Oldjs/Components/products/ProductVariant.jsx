import React, { useState } from 'react'

export default function ProductVariant() {
    const [selectedSize, setSelectedSize] = useState("S"); // Default selected size
    const [selectedColor, setSelectedColor] = useState("Red"); // Default selected color
    
    const handleSizeChange = (event) => {
        setSelectedSize(event.target.value); // Update the selected size state
        console.log("Selected Size:", event.target.value);
      };

    const handleColorChange = (event) => {
      setSelectedColor(event.target.value); // Update the selected color state
      console.log("Selected Color:", event.target.value);
    };

    return (
    <div className="product__variant">
            <div className="product__variant--list mb-10">
            <fieldset className="variant__input--fieldset">
                <legend className="product__variant--title mb-8">Color : {selectedColor}</legend>

                <input
                id="color-red1"
                name="color"
                type="radio"
                value="Red"
                checked={selectedColor === "Red"} // Controlled component
                onChange={handleColorChange}
                />
                <label
                className="variant__color--value red"
                htmlFor="color-red1"
                title="Red"
                >
                <img
                    className="variant__color--value__img"
                    src="/images/img/product/product1.png"
                    alt="variant-color-img"
                />
                </label>

                <input
                id="color-red2"
                name="color"
                type="radio"
                value="Black"
                checked={selectedColor === "Black"} // Controlled component
                onChange={handleColorChange}
                />
                <label
                className="variant__color--value red"
                htmlFor="color-red2"
                title="Black"
                >
                <img
                    className="variant__color--value__img"
                    src="/images/img/product/product2.png"
                    alt="variant-color-img"
                />
                </label>

                <input
                id="color-red3"
                name="color"
                type="radio"
                value="Pink"
                checked={selectedColor === "Pink"} // Controlled component
                onChange={handleColorChange}
                />
                <label
                className="variant__color--value red"
                htmlFor="color-red3"
                title="Pink"
                >
                <img
                    className="variant__color--value__img"
                    src="/images/img/product/product3.png"
                    alt="variant-color-img"
                />
                </label>

                <input
                id="color-red4"
                name="color"
                type="radio"
                value="Orange"
                checked={selectedColor === "Orange"} // Controlled component
                onChange={handleColorChange}
                />
                <label
                className="variant__color--value red"
                htmlFor="color-red4"
                title="Orange"
                >
                    <img
                        className="variant__color--value__img"
                        src="/images/img/product/product4.png"
                        alt="variant-color-img"
                    />
                </label>
            </fieldset>

            </div>

            <div className="product__variant--list mb-15">
                <fieldset className="variant__input--fieldset weight">
                    <legend className="product__variant--title mb-8">Size : {selectedSize} </legend>
                    <input
                    id="weight1"
                    name="weight"
                    type="radio"
                    value="S"
                    checked={selectedSize === "S"} 
                    onChange={handleSizeChange}
                    />
                    <label className="variant__size--value red" htmlFor="weight1">
                    S
                    </label>
                    <input
                    id="weight2"
                    name="weight"
                    type="radio"
                    value="M"
                    checked={selectedSize === "M"} 
                    onChange={handleSizeChange}
                    />
                    <label className="variant__size--value red" htmlFor="weight2">
                    M
                    </label>
                    <input
                    id="weight3"
                    name="weight"
                    type="radio"
                    value="L"
                    checked={selectedSize === "L"} 
                    onChange={handleSizeChange}
                    />
                    <label className="variant__size--value red" htmlFor="weight3">
                    L
                    </label>
                    <input
                    id="weight4"
                    name="weight"
                    type="radio"
                    value="XL"
                    checked={selectedSize === "XL"} 
                    onChange={handleSizeChange}
                    />
                    <label className="variant__size--value red" htmlFor="weight4">
                    XL
                    </label>
                </fieldset>

            
            </div>


            <div className="product__variant--list quantity d-flex align-items-center mb-20">
                <div className="quantity__box">
                    <button onClick={handleDecrement} type="button" className="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">- </button>
                    <label>
                        <input type="number" className="quantity__number quickview__value--number" value={productQuantity} />
                    </label>
                    <button onClick={handleIncrement} type="button" className="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+ </button>
                </div>
                <button className="quickview__cart--btn primary__btn" type="submit">Add To Cart </button>  
                <button className="quickview__cart--btn primary__btn wishList" type="submit">Add to Wishlist </button>  
            </div>
            <div className="product__variant--list mb-15">
                
                <button className="variant__buy--now__btn primary__btn" type="submit">Buy it now </button>
            </div>
            <div className="product__details--info__meta">
                {product.sku_code && (
                    <p className="product__details--info__meta--list"><strong>SKU: </strong>   <span>{product.sku_code} </span>  </p>
                )}  
                {product.brandName && (
                <p className="product__details--info__meta--list"><strong>Brand: </strong>   <span>{product.brandName} </span>  </p>
                )}  
                {/* <p className="product__details--info__meta--list"><strong>Vendor: </strong>   <span>Belo </span>  </p>
                <p className="product__details--info__meta--list"><strong>Status: </strong>   <span>Dress </span>  </p> */}
            </div>
        </div>
  )
}
