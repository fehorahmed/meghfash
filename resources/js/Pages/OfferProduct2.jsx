import Pagination from "@/Components/Pagination";
import ProductGrid from "@/Components/products/ProductGrid";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";

export default function OfferProduct2({
    general,
    headerMenu,
    footerMenu2,
    footerMenu4,
    footerMenu3,
    categoryMenu,
    page,
    auth,
    offerCtgProducts,
}) {

    console.log(offerCtgProducts);

    return (
        <>
            <MainLayout
            auth={auth}
                general={general}
                headerMenu={headerMenu}
                footerMenu4={footerMenu4}
                footerMenu3={footerMenu3}
                footerMenu2={footerMenu2}
                categoryMenu={categoryMenu}
            >

                <div
                    className="pageContect"
                    style={{ minHeight: "300px" }}
                >
                    
                    <div className="container">
                        <h2 className="breadcrumb__content--title mb-40 text-center">Offer Products</h2>
                        <div>
                            {offerCtgProducts.length > 0 && 
                            <div className="product__section--inner product__grid--inner pb-4">
                                {offerCtgProducts.map((offerCtgProduct) =>
                                <div className="offerCtgLayout">
                                    <div className="offerCtgHead">
                                        <h3 className="offerCtgTitle">{offerCtgProduct.ctg_name}</h3>
                                        <Link 
                                            href={route('offerProduct', { category: offerCtgProduct.ctg_slug })}>
                                            View More
                                        </Link>
                                    </div>
                                    <div className="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                        {offerCtgProduct.products.map((product, index) => (
                                            <div className="col mb-30" key={index}>
                                                <ProductGrid product={product} />
                                            </div>
                                        ))}
                                    </div>
                                 </div>
                                )}
                                
                            </div>
                            }
                            {/* <div className="PagiDiv">
                         <Pagination pagination={products} />

                            </div> */}
                        </div>
                    </div>
                </div>
            </MainLayout>
        </>
    );
}
