import ShipingComponent from "@/Components/ShipingComponent";
import { Link } from "@inertiajs/react";
import { useState } from "react";
import { FaInstagram, FaMapMarkerAlt, FaTiktok } from "react-icons/fa";
import { FaFacebookF, FaLinkedin, FaPhone, FaPinterest, FaTwitter, FaYoutube } from "react-icons/fa6";
import { MdEmail } from "react-icons/md";

const Footer = ({ general, footerMenu2, footerMenu3, footerMenu4 }) => {

    const [email ,setEmail] =useState('Eb');
    const [error ,setError] =useState('');
    const [success ,setSuccess] =useState('');
    const [subcribeLoading ,setSubcribeLoading] =useState(false);

    const SubscribeForm = async (e) => {
        setSubcribeLoading(true);
        const form =e.target;

        e.preventDefault();

        setError('');
        setSuccess('');

        try {
          const response = await fetch('/subscribe', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({email:email}),
          });
    
          if (response.ok) {
            const data = await response.json();
            console.log(data)
            if(data.success){
                setSuccess(data.message);
                setEmail('');
                form.reset();
            }else{
                setError(data.message);
            }
          }
        } catch (error) {
          console.error('Failed to Subscribe:', error);
          setError(error);
        }finally{
            setSubcribeLoading(false);
        }
      };



    return (
        <>

          <footer className="footer__section bg__black">
                <div className="container-fluid">
                    <div className="main__footer d-flex justify-content-between">
                        <div className="footer__widget footer__widget--width">
                            <h2 className="footer__widget--title text-ofwhite h3">Contact Us</h2>
                            <div className="footer__widget--inner">
                                {general.mobile &&<p className="footer__widget--desc text-ofwhite mb-20"><FaPhone /> <a href={`tel:${general.mobile.trim()}`} >{general.mobile}</a></p>}
                                {general.email && <p className="footer__widget--desc text-ofwhite mb-20"><MdEmail /> <a href={`mailto:${general.email}`}>{general.email}</a> </p>}
                                {/* <h3 className="social__title text-ofwhite h4 mb-15">Office Address</h3> */}
                                {/* <p className="footer__widget--desc text-ofwhite mb-20">{general.address_one}</p> */}
                                {general.address_one && <p className="footer__widget--desc text-ofwhite mb-20"><FaMapMarkerAlt /> {general.address_one} </p>}
                               
                            </div>
                        </div>
                        {/* <div className="footer__widget--menu__wrapper d-flex footer__widget--width">
                        {footerMenu2 && footerMenu2.items && 
                            <div className="footer__widget">
                                
                                <h2 className="footer__widget--title text-ofwhite h3">{footerMenu2.title}</h2>
                                <ul className="footer__widget--menu footer__widget--inner">
                                    {footerMenu2.items.map((item, index) => (
                                    <li className="footer__widget--menu__list" key={index}><Link className="footer__widget--menu__text" href={`/${item.slug}`}> {item.title}  </Link></li>
                                    ))}
                                </ul>
                            </div>
                            }   
                          
                        </div> */}
                        {footerMenu2 && footerMenu2.items && 
                        <div className="footer__widget footer__widget--width">
                            <h2 className="footer__widget--title text-ofwhite h3">{footerMenu2.title}</h2>
                            <ul className="footer__widget--menu footer__widget--inner">
                                {footerMenu2.items.map((item, index) => (
                                    <li className="footer__widget--menu__list" key={index}><Link className="footer__widget--menu__text" href={`/${item.slug}`}> {item.title}  </Link></li>
                                ))}
                            </ul>
                        </div>
                        }
                        
                        {footerMenu3 && footerMenu3.items && 
                        <div className="footer__widget footer__widget--width">
                            <h2 className="footer__widget--title text-ofwhite h3">{footerMenu3.title}</h2>
                            <ul className="footer__widget--menu footer__widget--inner">
                                {footerMenu3.items.map((item, index) => (
                                    <li className="footer__widget--menu__list" key={index}><Link className="footer__widget--menu__text" href={`/${item.slug}`}> {item.title}  </Link></li>
                                ))}
                            </ul>
                        </div>
                        }
                        {footerMenu4 && footerMenu4.items && 
                        <div className="footer__widget footer__widget--width">
                            <h2 className="footer__widget--title text-ofwhite h3">{footerMenu4.title}</h2>
                            <ul className="footer__widget--menu footer__widget--inner">
                                {footerMenu4.items.map((item, index) => (
                                    <li className="footer__widget--menu__list" key={index}><Link className="footer__widget--menu__text" href={`/${item.slug}`}> {item.title}  </Link></li>
                                ))}
                            </ul>
                        </div>
                        }
                        <div className="footer__widget footer__widget--width">
                            <h2 className="footer__widget--title text-ofwhite h3">Newsletter 
                                <button className="footer__widget--button" aria-label="footer widget button">
                                    <svg className="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewbox="0 0 10.355 6.394">
                                        <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div className="footer__widget--inner">
                                <p className="footer__widget--desc text-ofwhite m-0">Fill their seed open meat. Sea you  <br /> great Saw image stl </p> 
                                <div className="newsletter__subscribe" style={{marginTop: "10px"}}>
                                    <div style={{height: "20px"}}>
                                    
                                    {success && (
                                        <p style={{margin: "0"}}>
                                            <span
                                            style={{
                                                color: "white",
                                                background: "#14af67",
                                                display: "block",
                                                marginBottom: 5,
                                                padding: "5px 10px",
                                                borderRadius: 10
                                            }}
                                            >
                                            {success}
                                            </span>
                                        </p>
                                        )}
                                        {error && (
                                            <p style={{margin: "0",color: "#dd0909"}}>{error}</p>
                                        )}


                                    </div>
                                    <form className="newsletter__subscribe--form" onSubmit={SubscribeForm} >
                                        <label>
                                            <input className="newsletter__subscribe--input"
                                            placeholder="Email Address"
                                            type="email"
                                            name="email"
                                            onChange={(e) => setEmail(e.target.value)}
                                            />
                                        </label>
                                        
                                        <button className="newsletter__subscribe--button" style={{position: "relative"}} type="submit">
                                            {subcribeLoading ? (
                                                <span className="loading"></span>
                                            ):(
                                                <span>
                                                    Subscribe 
                                                </span>
                                            )}
                                            </button>

                                    </form>   
                                </div> 
                            </div> 
                        </div>
                    </div>
         
                   
                    <div className="footer__bottom d-flex justify-content-between align-items-center">
                        <p className="copyright__content text-ofwhite m-0">Copyright@ 2025 Megh Fashion. All Rights Reserved. Development By <a href="https://natoreit.com/" style={{color: "#0092d7", fontWeight: "bold" }} target="_blank">Natore-IT</a></p>
                        <div className="footer__social">
                        <h3 className="social__title text-ofwhite h4 mb-15">Follow Us </h3>
                        <ul className="social__shear d-flex">
                            {general.facebook_link && 
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.facebook_link}>
                                    <FaFacebookF />
                                    <span className="visually-hidden">Facebook </span>
                                </a>
                            </li>
                            }
                            {general.twitter_link &&
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.twitter_link}>
                                    <FaTwitter />
                                    <span className="visually-hidden">Twitter </span>
                                </a>
                            </li>
                            }
                            {general.instagram_link &&
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.instagram_link}>
                                <FaInstagram />
                                    <span className="visually-hidden">Instagram </span>
                                </a>
                            </li>
                            } 
                            {general.linkedin_link &&
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.linkedin_link}>
                                <FaLinkedin />
                                    <span className="visually-hidden">Linkdin </span>
                                </a>
                            </li>
                            }
                            {general.youtube_link &&
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.youtube_link}>
                                    <FaYoutube />
                                    <span className="visually-hidden">Youtube </span>
                                </a>
                            </li>
                            }
                            {general.pinterest_link &&
                            <li className="social__shear--list">
                                <a className="social__shear--list__icon" target="_blank" href={general.pinterest_link}>
                                <FaTiktok />
                                    <span className="visually-hidden"> </span>
                                </a>
                            </li>
                            }
                        </ul>

                    </div>
                        <div className="footer__payment text-right">
                            <img className="display-block" style={{maxWidth: "300px"}} src="/images/footer.png" alt="visa-card" />
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
};

export default Footer;
