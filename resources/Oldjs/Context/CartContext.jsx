import React, { createContext, useContext, useState } from 'react';
import { toast } from 'react-toastify';
import { Inertia } from '@inertiajs/inertia';

// Create Cart Context
const CartContext = createContext();

// Cart Provider
export const CartProvider = ({ children }) => {
  const [loading, setLoading] = useState({});
  const [cart, setCart] = useState([]);
  const [wishList, setWishList] = useState([]);



  // Initialize cart with server data
  const initializeCart = (serverCart) => setCart(serverCart || []);

  const initializeWishList = (serverWishList) => setWishList(serverWishList || []);

  // Add to cart
  const addToCart = async (product) => {
    
    const productId = product.product_id;
    const ordernow = product.ordernow? true : false;

    setLoading((prevState) => ({ ...prevState, [productId]: true }));


    try {
      const response = await fetch('/add-to-cart', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(product),
      });

      if (response.ok) {
        const data = await response.json();
        console.log(data)
        setCart(data?.carts);

        if(ordernow){
           Inertia.visit('/checkout');
        }else{
          toast.success('Product added to cart successfully!');

        }


      }
    } catch (error) {
      console.error('Failed to add product to cart:', error);
    }finally {
      setLoading((prevState) => ({ ...prevState, [productId]: false })); // Reset loading for the product
    }
  };



  // Remove from cart
  const removeFromCart = async (id,type) => {

    try {
      const response = await fetch(`/change-to-cart/${id}/${type}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',

        },
      });

      if (response.ok) {
        const data = await response.json();
        setCart(data?.carts);
      }
    } catch (error) {
      console.error('Failed to remove product from cart:', error);
    }
  };

   // Add to cart
   const addToWishList = async (id) => {
    try {
      const response = await fetch(`/wishlist-compare/update/${id}/wishlist`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },

      });

      if (response.ok) {
        const data = await response.json();
        setWishList(data?.products);
        if(data.status){
          toast.success('WishList added to  successfully!');
        }else{
          toast.success('WishList romove to  successfully!');

        }
      }
    } catch (error) {
      console.error('Failed to add product to cart:', error);
    }
  };


  // Remove from whishList
  const removeFromWishList = async (id) => {
    try {
      const response = await fetch(`/wishlist-compare/update/${id}/wishlist`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
        
      });

      if (response.ok) {
        const data = await response.json();
        console.log(data);
        setWishList(data.products);
      }
    } catch (error) {
      console.error('Failed to remove product from cart:', error);
    }
  };


  // Update cart quantity
  const updateCartQuantity = async (id) => {
    try {
      const response = await fetch('/cart/update', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },

      });

      if (response.ok) {
        const data = await response.json();
        setCart(data?.carts);
      }
    } catch (error) {
      console.error('Failed to update cart:', error);
    }
  };



  return (
    <CartContext.Provider value={{
        loading,
        cart, 
        initializeCart,
        addToCart,
        removeFromCart,
        updateCartQuantity,
        wishList,
        initializeWishList,
        removeFromWishList,
        addToWishList,


       }}>

      {children}

    </CartContext.Provider>
  );
};

// Hook to use Cart Context
export const useCart = () => useContext(CartContext);
