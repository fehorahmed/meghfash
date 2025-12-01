
import { Link } from '@inertiajs/react';

export default function DemoImageComponent({image, imageLink, name}) {
  
  return (
    <>
        <div className="demoImageMain">
            <div className="container-fluid">

              {imageLink ? 
                 <Link href={imageLink} > <img src={image} alt={name}/> </Link>
                  :
                 <img src={image} alt="" />
              }

            </div>
        </div>
    </>
  )
}
