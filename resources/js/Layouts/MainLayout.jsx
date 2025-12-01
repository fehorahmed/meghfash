
import { useCart } from "@/Context/CartContext";
import Footer from "@/Layouts/Footer";
import Header from "@/Layouts/Header";
import ScrollUpApp from "@/Layouts/ScrollUpApp";
import React, { useEffect, useState } from "react";
import { ToastContainer } from 'react-toastify';

export default function MainLayout({
    children,
    auth,
    general,
    headerMenu,
    categoryMenu,
    footerMenu2,
    footerMenu4,
    footerMenu3,
    itemsCount,
    carts,
    wishListCount
    // setItemsCount
}) {
const {cart} = useCart();
    // const [CartCount, setCartCount] = useState(carts.cartsCount);




    // useEffect(() => {
    //     const fetchCartCount = async () => {
    //         try {
    //             const response = await fetch("/cart-count", {
    //                 headers: {
    //                     "X-Requested-With": "XMLHttpRequest",
    //                 },
    //             });

    //             if (!response.ok) {
    //                 throw new Error("Failed to fetch cart count");
    //             }
    //             const data = await response.json();
    //             setCartCount(data.cart_count);
    //         } catch (error) {
    //             console.error("Error fetching cart count:", error);
    //         }
    //     };

    //     fetchCartCount();
    // }, [setCartCount]);



    return (
        <>

            <Header auth={auth} general={general} headerMenu={headerMenu} categoryMenu={categoryMenu} itemsCount={itemsCount} wishListCount={wishListCount} carts={carts}/>
            <main>
                <ToastContainer />
                {children}
                <ScrollUpApp/>
            </main>
            <Footer
                general={general}
                footerMenu4={footerMenu4}
                footerMenu2={footerMenu2}
                footerMenu3={footerMenu3}
            />

        </>
    );
}
