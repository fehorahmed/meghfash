
import { CiStar } from 'react-icons/ci'; // Full star
import { IoIosStarHalf } from 'react-icons/io';
import { MdOutlineStarPurple500 } from 'react-icons/md'; 

export default function RatingStar({rating}) {


//   const fullStars = Math.floor(rating);
//   const hasHalfStar = rating % 1 >= 0.5;
//   const emptyStars = 5 - (hasHalfStar ? fullStars + 1 : fullStars);

    const fullStars = Math.floor(rating); // Calculate the full stars
    const hasHalfStar = rating % 1 >= 0.5 && rating > 0; // Ensure there's no half star if rating is 0
    const emptyStars = 5 - (hasHalfStar ? fullStars + 1 : fullStars);

  return (
    <ul className="rating d-flex mb-2">

        {[...Array(fullStars)].map((_, index) => (
            <li key={index} className="rating__list">
                <span className="rating__list--icon">
                    <MdOutlineStarPurple500 />
                </span>
            </li>
        ))}


        {hasHalfStar  &&
        <>
        {[...Array(hasHalfStar)].map((_, index) => (
            <li key={index} className="rating__list">
            <span className="rating__list--icon">
            <IoIosStarHalf />
            </span>
            </li>
        ))}
        </>
        }
        {[...Array(emptyStars)].map((_, index) => (
            <li key={index} className="rating__list">
                <span className="rating__list--icon">
                    <CiStar/>
                </span>
            </li>
        ))}
    </ul>
  )
}
