import React from 'react'

export default function BlogComments() {
  return (
    <div class="comment__box">
        <div class="reviews__comment--area2 mb-50">
            <h2 class="reviews__comment--reply__title mb-25">Recent Comment </h2>
            <div class="reviews__comment--inner">
                <div class="reviews__comment--list d-flex">
                    <div class="reviews__comment--thumb">
                        <img class="display-block" src="/images/img/other/comment-thumb1.png" alt="comment-thumb" />
                    </div>
                    <div class="reviews__comment--content ">
                        <div class="comment__content--topbar d-flex justify-content-between">
                            <div class="comment__content--topbar__left">
                                <h4 class="reviews__comment--content__title2">Jakes on </h4>
                                <span class="reviews__comment--content__date2">February 18, 2024 </span>
                            </div>
                            <button class="comment__reply--btn primary__btn" type="submit">Reply </button>
                        </div>
                        <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos ex repellat officiis neque. Veniam, rem nesciunt. Assumenda distinctio, autem error repellat eveniet ratione dolor facilis accusantium amet pariatur, non eius! </p>
                    </div>
                </div>
                <div class="reviews__comment--list margin__left d-flex">
                    <div class="reviews__comment--thumb">
                        <img class="display-block" src="/images/img/other/comment-thumb2.png" alt="comment-thumb" />
                    </div>
                    <div class="reviews__comment--content">
                        <div class="comment__content--topbar d-flex justify-content-between">
                            <div class="comment__content--topbar__left">
                                <h4 class="reviews__comment--content__title2">John Deo </h4>
                                <span class="reviews__comment--content__date2">February 18, 2024 </span>
                            </div>
                            <button class="comment__reply--btn primary__btn" type="submit">Reply </button>
                        </div>
                        <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos ex repellat officiis neque. Veniam, rem nesciunt. Assumenda distinctio, autem error repellat eveniet ratione dolor facilis accusantium amet pariatur, non eius! </p>
                    </div>
                </div>
                <div class="reviews__comment--list d-flex">
                    <div class="reviews__comment--thumb">
                        <img class="display-block" src="/images/img/other/comment-thumb3.png" alt="comment-thumb" />
                    </div>
                    <div class="reviews__comment--content">
                        <div class="comment__content--topbar d-flex justify-content-between">
                            <div class="comment__content--topbar__left">
                                <h4 class="reviews__comment--content__title2">Laura Johnson </h4>
                                <span class="reviews__comment--content__date2">February 18, 2024 </span>
                            </div>
                            <button class="comment__reply--btn primary__btn" type="submit">Reply </button>
                        </div>
                        <p class="reviews__comment--content__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos ex repellat officiis neque. Veniam, rem nesciunt. Assumenda distinctio, autem error repellat eveniet ratione dolor facilis accusantium amet pariatur, non eius!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviews__comment--reply__area">
            <form action="#">
                <h2 class="reviews__comment--reply__title mb-20">Leave A Comment </h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-20">
                        <label>
                            <input class="reviews__comment--reply__input" placeholder="Your Name...." type="text" />
                        </label>
                    </div>  
                    <div class="col-lg-4 col-md-6 mb-20">
                        <label>
                            <input class="reviews__comment--reply__input" placeholder="Your Email...." type="email" />
                        </label>
                    </div> 
                    <div class="col-lg-4 col-md-6 mb-20">
                        <label>
                            <input class="reviews__comment--reply__input" placeholder="Your Website...." type="text" />
                        </label>
                    </div> 
                    <div class="col-12 mb-15">
                        <textarea class="reviews__comment--reply__textarea" placeholder="Your Comments...."></textarea>
                    </div> 
                    
                </div>
                <button class="reviews__comment--btn primary__btn text-white" data-hover="Submit" type="submit">SUBMIT </button>
            </form>   
        </div> 
    </div> 
  )
}
