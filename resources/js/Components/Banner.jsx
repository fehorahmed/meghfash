
import { Image } from "react-bootstrap";
import Carousel from "react-bootstrap/Carousel";
import DonationFilterModal from "./Donation/DonationFilterModal";
const Banner = ({ sliders, donationType, donation_categories }) => {
    console.log(sliders);
    return (
        <>
            <Carousel>
                {sliders.map((slider) => (
                    <Carousel.Item interval={1000} style={{ backgroundImage: `url(${slider.image_url})` }} >
                        <Carousel.Caption>
                            <h3>Donation</h3>
                            <p>
                                Nulla vitae elit libero, a pharetra augue mollis
                                interdum.
                            </p>
                            <DonationFilterModal donationType="homeModal" donation_categories={ donation_categories} />
                        </Carousel.Caption>
                    </Carousel.Item>
                ))}
            </Carousel>
        </>
    );
};

export default Banner;
