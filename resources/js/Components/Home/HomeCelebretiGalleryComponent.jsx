

export default function HomeCelebretiGalleryComponent({galleries,general}) {


    const firstImage = galleries.slice(0, 1);
    const secondImage = galleries.slice(1, 2);
    const threeImage = galleries.slice(2, 3);
    const fourImage = galleries.slice(3, 4);


    return (
    <>
        <div className="homeCelebretiGalleryMain">
            <div className="container-fluid">
                <div className="row">
                    <div className="col-md-5">
                        {firstImage.length > 0 && 
                            <div className="gridBox">
                                {firstImage.map((gallery) => (
                                    <img src={gallery.image_url} alt={gallery.name?gallery.name:general.title} />
                                ))}
                            </div>
                        }
                    </div>
                    <div className="col-md-7">
                        <div className="row">
                            <div className="col-md-6">
                                {secondImage.length > 0 && 
                                    <div className="gridBox">
                                        {secondImage.map((gallery) => (
                                        <img src={gallery.image_url} alt={gallery.name?gallery.name:general.title} />
                                        ))}
                                    </div>
                                }
                            </div>
                            <div className="col-md-6">
                                {threeImage.length > 0 && 
                                    <div className="gridBox">
                                        {threeImage.map((gallery) => (
                                        <img src={gallery.image_url} alt={gallery.name?gallery.name:general.title} />
                                        ))}
                                    </div>
                                }
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-12">
                                {fourImage.length > 0 && 
                                    <div className="gridBox bottomGalleryImg">
                                         {fourImage.map((gallery) => (
                                        <img src={gallery.image_url} alt={gallery.name?gallery.name:general.title} />
                                        ))}
                                    </div>
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </>
  )
}
