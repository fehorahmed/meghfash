import AlertMessageComponents from '@/Components/AlertMassageCompononets';
import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'
import { Inertia } from '@inertiajs/inertia';

export default function ReviewsEdit({
    general,
    headerMenu,
    footerMenu4,
    footerMenu2,
    footerMenu3,
    categoryMenu,
    carts,
    auth,
    item
}) {

    const [successMessage, setSuccessMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);
    const [rating, setRating] = useState(item?.review_rating ?? 5);
    const [review, setReview] = useState(item?.review_content);
    const [ratingError, setRatingError] = useState('');
    const [reviewError, setReviewError] = useState('');
    const [profileLoading ,setProfileLoading] =useState(false);
    const [status, setStatus] = useState('');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleReviewSubmit = async (e) => {
        e.preventDefault();
        setProfileLoading(true);
        try {
            const response = await fetch(`/customer/my-reviews/review/${item.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    rating: rating,
                    review: review,
                }),
            });

            const result = await response.json();
            if (!response.ok) {
                if (result.errors) {
                    setRatingError(result.errors.rating)
                    setReviewError(result.errors.review)
                    setSuccessMessage('Somthing want to worng!');
                    setResponseSuccess(result.success);
                    setStatus('error')
                }
            } else {
                setSuccessMessage(result.message);
                console.log(result.message);
                setResponseSuccess(result.success);
                setStatus('success')
                Inertia.visit('/customer/my-reviews');
            }

            console.log('Server response:', result);
        } catch (error) {
            console.log(error);
        }finally{
            setProfileLoading(false);
        }
    };

    const handleRatingChange = (event) => {
        setRating(event.target.value);
      };
    
      console.log(rating);

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
        carts={carts}
    >
        <Head title={`My Profile - ${general.web_title}`}>
            <meta name="title" property="og:title" content={`My Profile - ${general.web_title}`} />
            <meta name="description" property="og:description" content={general.meta_description} />
            <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
            <meta name="image" property="og:image" content={general.logo_url} />
            <meta name="url" property="og:url" content={route('customer.orderReview',item.id)} />
            <link rel="canonical" href={route('customer.orderReview',item.id)} />
        </Head>
        
        
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {auth.user.name} welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <SideBar auth={auth} />
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">My Review</h2>
                            <div>
                                <AlertMessageComponents
                                status={status}
                                message={successMessage}
                                />
                                <form class="contact__form--inner" onSubmit={handleReviewSubmit} >
                                    <div class="row">
                                        <div class="col-lg-12 mb-12">
                                            <div style={{display: "flex"}}>
                                                <img src={item.image_url} style={{maxWidth: "100px", maxHeight: "80px",marginRight: "5px"}} />
                                                <div>
                                                    <p>
                                                    {item.product_name}
                                                    <br />
                                                    {item?.variants?.map((variant) => 
                                                        <span class="cart__content--variant"> {variant.title}: {variant.value} </span>
                                                    )}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                        <label class="contact__form--label" for="input5">Rating <span class="contact__form--label__star">* </span></label>
                                             <div class="checkout__input--list checkout__input--select select">
                                             {responseSuccess == true ?
                                                ''
                                                :
                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {ratingError && <span >{ratingError}</span>}  </p>
                                                }
                                             <select class="form-select checkout__input--select__field border-radius-5" 
                                                    name="rating"
                                                    required=""
                                                    value={rating}
                                                    onChange={handleRatingChange}
                                                 >
                                                    <option value="5">5 Star</option>
                                                    <option value="4">4 Star</option>
                                                    <option value="3">3 Star</option>
                                                    <option value="2">2 Star</option>
                                                    <option value="1">1 Star</option>
                                                </select>
                                             </div>
                                             
                                         </div>
                                        <div class="col-12">
                                            <div class="contact__form--list mb-15">
                                                <label class="contact__form--label" for="input5">Review <span class="contact__form--label__star">* </span></label>
                                                {responseSuccess == true ?
                                                ''
                                                :
                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {reviewError && <span >{reviewError}</span>}  </p>
                                                }
                                                <textarea class="contact__form--textarea" name="review"  
                                                required=""
                                                placeholder="Write Your Review"
                                                value={review}
                                                onChange={e => setReview( e.target.value)}
                                                ></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <button class="contact__form--btn primary__btn" type="submit" style={{position: "relative",    minWidth: "200px"}}>
                                            {profileLoading ? (
                                                <span className="loading"></span>
                                            ):(
                                                <span>
                                                    Submit Now 
                                                </span>
                                            )}

                                    </button>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </MainLayout>
    
    </>
  )
}
