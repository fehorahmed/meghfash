import React from 'react'
import RatingStar from './RatingStar'

export default function ProductReview({product,reviews}) {


  return (
    <div class="product__reviews">
        <div class="product__reviews--header">
            <h2 class="product__reviews--header__title h3 mb-20">Customer Reviews </h2>
            <div class="reviews__ratting d-flex align-items-center">
                <RatingStar rating={product.rating} />
                <span class="reviews__summary--caption">Based on {product.totalReview} reviews </span>
            </div>
        </div>
        <div class="reviews__comment--area">
            {reviews.data.length > 0 ?
            
            <>
            
            {reviews.data.map((review) => (
            <div class="reviews__comment--list d-flex">
                <div class="reviews__comment--content">
                    <div class="reviews__comment--top d-flex justify-content-between">
                        <div class="reviews__comment--top__left">
                            <h3 class="reviews__comment--content__title h4">{review.name}</h3>
                            <RatingStar rating={review.rating} />
                        </div>
                        <span class="reviews__comment--content__date">{review.createdAt}</span>
                    </div>
                    <p class="reviews__comment--content__desc">
                    {review.content}
                    </p>
                </div>
            </div>
            ))}
            </>
            :
            <>
            
            <div>
                <p>No Review</p>
            </div>
            </>


            }

        </div> 
    </div>  
  )
}
