

export default function HomeCategoryComponent({bannerGroupOne}) {

    const oneGroup = bannerGroupOne.slice(0, 1);
    const twoGroup = bannerGroupOne.slice(1, 3);
    const threeGroup = bannerGroupOne.slice(3, 4);



  return (
    <>
         <section className="banner__section section--padding">
             <div className="container-fluid">
                 <div className="row mb--n28">
                    {oneGroup.map((banner) => (
                     <div className="col-lg-5 col-md-order mb-28">
                         <div className="banner__items">
                             <a className="banner__items--thumbnail position__relative" href={banner.link}>
                                <img className="banner__items--thumbnail__img" src={banner.image_url} alt={banner.name} />
                                 <div className="banner__items--content">
                                     <span className="banner__items--content__subtitle"  >{banner.sub_title}</span>
                                     <h2 className="banner__items--content__title h3" dangerouslySetInnerHTML={{ __html: banner.name}}></h2>
                                     <span className="banner__items--content__link">
                                     {banner.link == null ? "": 
                                                <>
                                                 View Discounts
                                                 <svg className="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewbox="0 0 6.2 6.2">
                                                     <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                                 </svg>
                                                 </>
                                                 }
                                     </span>
                                 </div>
                             </a>
                         </div>
                     </div>
                    ))}
                     <div className="col-lg-7 mb-28">
                         <div className="row row-cols-lg-2 row-cols-sm-2 row-cols-1">
                            {twoGroup.map((banner) => (
                             <div className="col mb-28">
                                 <div className="banner__items">
                                     <a className="banner__items--thumbnail position__relative" href={banner.link}>
                                        <img className="banner__items--thumbnail__img" src={banner.image_url} alt={banner.name} /> 
                                        <div className="banner__items--content">
                                             <span className="banner__items--content__subtitle text__secondary">{banner.sub_title}</span>
                                             <h2 className="banner__items--content__title h3" dangerouslySetInnerHTML={{ __html: banner.name}}></h2>
                                             <span className="banner__items--content__link">
                                                {banner.link == null ? "": 
                                                <>
                                                 View Discounts
                                                 <svg className="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewbox="0 0 6.2 6.2">
                                                     <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                                 </svg>
                                                 </>
                                                 }
                                             </span>
                                         </div>
                                     </a>
                                 </div>
                             </div>
                            ))}
                         </div>
                         {threeGroup.map((banner) => (
                         <div className="banner__items">
                             <a className="banner__items--thumbnail position__relative" href={banner.link}>
                                <img className="banner__items--thumbnail__img banner__img--max__height" src={banner.image_url} alt={banner.name} /> 
                                 <div className="banner__items--content">
                                     <span className="banner__items--content__subtitle">{banner.sub_title}</span>
                                     <h2 className="banner__items--content__title h3"  dangerouslySetInnerHTML={{ __html: banner.name}}></h2>
                                     <span className="banner__items--content__link">
                                     {banner.link == null ? "": 
                                                <>
                                                 View Discounts
                                                 <svg className="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewbox="0 0 6.2 6.2">
                                                     <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                                 </svg>
                                                 </>
                                                 }
                                     </span>
                                 </div>
                             </a>
                         </div>
                        ))}
                     </div>

                 </div>
             </div>
         </section>
    </>
  )
}
