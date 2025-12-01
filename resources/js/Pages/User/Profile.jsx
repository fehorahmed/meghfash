import AlertMessageComponents from '@/Components/AlertMassageCompononets';
import SideBar from '@/Components/User/SideBar'
import MainLayout from '@/Layouts/MainLayout'
import { Head, Link } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'

export default function Profile({
    general,
    headerMenu,
    footerMenu4,
    footerMenu3,
    footerMenu2,
    categoryMenu,
    carts,
    auth,
    district,
    user,
}) {

    const [successMessage, setSuccessMessage] = useState('');
    const [responseSuccess, setResponseSuccess] = useState(false);
    const [name, setName] = useState(auth.user.name);
    const [email, setEmail] = useState(auth.user.email);
    const [mobile, setMobile] = useState(auth.user.mobile);
    const [address, setAddress] = useState(auth.user.address_line1);
    const [status, setStatus] = useState('');
    const [nameError, setNameError] = useState('');
    const [emailError, setEmailError] = useState('');
    const [mobileError, setMobileError] = useState('');
    const [profileLoading ,setProfileLoading] =useState(false);

    
    const [thanas, setThanas] = useState([]);       // List of thanas
    const [selectedDistrict, setSelectedDistrict] = useState(auth.user.district); // Selected district
    const [selectedCity, setSelecteCity] = useState(auth.user.city); // Selected city

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');




    const [selectedImage, setSelectedImage] = useState(null);
    const [isLoading, setIsLoading] = useState(false);

    // Handle file selection
    const handleFileChange = async (e) => {
        const file = e.target.files[0]; // Get the selected file
        if (file) {
            setIsLoading(true); // Show spinner while uploading
            try {
                // Create a FormData object
                const formData = new FormData();
                formData.append('upload', 'image'); // Add additional parameters if needed
                formData.append('image', file); // Add the selected file
    
                // Send the file to the server
                const response = await fetch('/customer/profile', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json', // Accept JSON response
                        'X-CSRF-TOKEN': csrfToken, // Add CSRF token if required
                    },
                    body: formData, // Send the FormData object
                });
    
                const result = await response.json();
    
                if (!response.ok) {
                    // Handle errors from the server
                    if (result.errors) {
                        setNameError(result.errors.name || 'Something went wrong!');
                    }
                } else {
                    console.log('Server response:', result.message);
                    setStatus('success'); // Indicate success
                    setSuccessMessage('Image uploaded successfully!');
                }
            } catch (error) {
                console.error('Error uploading image:', error);
                setSuccessMessage('Something went wrong!');
            } finally {
                setIsLoading(false); // Hide spinner
            }
    
            // Display the selected image locally
            const imageUrl = URL.createObjectURL(file);
            setSelectedImage(imageUrl);
        } else {
            console.log('No file selected');
        }
    };
    

    const handleUserSubmit = async (e) => {
        e.preventDefault();
        setProfileLoading(true);
        try {
            const response = await fetch('/customer/profile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    mobile: mobile,
                    district: selectedDistrict,
                    city: selectedCity,
                    address: address,
                }),
            });

            const result = await response.json();
            if (!response.ok) {
                if (result.errors) {
                    setNameError(result.errors.name)
                    setEmailError(result.errors.email)
                    setMobileError(result.errors.mobile)
                    setSuccessMessage('Somthing want to worng!');
                    setResponseSuccess(result.success);
                    setStatus('error')
                }
            } else {
                setSuccessMessage(result.message);
                setResponseSuccess(result.success);
                console.log(result.message);
                setStatus('success')
            }
            console.log('Server response:', result);
        } catch (error) {
            console.log(error);
        }finally{
            setProfileLoading(false);
        }
    };



     // Fetch thanas when selectedDistrict changes
  useEffect(() => {
    const fetchThanas = async () => {
      if (!selectedDistrict) return; // Don't fetch if no district is selected

      try {
        const response = await fetch(`/customer/profile?district_id=${selectedDistrict}`); // Replace with your API endpoint
        if (!response.ok) {
          throw new Error(`Failed to fetch thanas: ${response.statusText}`);
        }
        const data = await response.json();
        setThanas(data.datas);
      } catch (error) {
        console.error("Error fetching thanas:", error);
      }

    };

    fetchThanas();

  }, [selectedDistrict]); // Dependency on selectedDistrict



    const handleDistrictChange = (event) => {
        setSelectedDistrict(event.target.value); // Update selectedDistrict
      };
    
      const handleCityChange = (event) => {
        setSelecteCity(event.target.value); // Update selectedDistrict
      };
    


  return (
    <>
    <MainLayout
        auth={auth}
        general={general}
        headerMenu={headerMenu}
        footerMenu4={footerMenu4}
        footerMenu3={footerMenu3}
        categoryMenu={categoryMenu}
        footerMenu2={footerMenu2}
        carts={carts}
    >
        <Head title={`My Profile - ${general.web_title}`}>
            <meta name="title" property="og:title" content={`My Profile - ${general.web_title}`} />
            <meta name="description" property="og:description" content={general.meta_description} />
            <meta name="keyword" property="og:keyword" content={general.meta_keyword}/>
            <meta name="image" property="og:image" content={general.logo_url} />
            <meta name="url" property="og:url" content={route('customer.profile')} />
            <link rel="canonical" href={route('customer.profile')} />
        </Head>
        
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {auth.user.name} welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <SideBar auth={auth} />
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">My Profile</h2>
                            <div>
                                <AlertMessageComponents
                                status={status}
                                message={successMessage}
                                />
                                <form class="contact__form--inner" onSubmit={handleUserSubmit} >
                                    <div className="row">
                                        <div className="col-md-3">
                                      
                                        <div className="ProfileInfo">
                                            {/* Display the selected image or a placeholder */}
                                            <div style={{ position: 'relative', marginBottom: '20px',  width: '100%' }}>

                                            <img
                                                src={
                                                    selectedImage || user.image_url
                                                }
                                                alt="Selected"
                                                style={{
                                                    objectFit: 'cover',
                                                    display: 'block',
                                                    margin: '0 auto',
                                                    height: '100%'
                                                }}
                                            />
                                            </div>

                                            {/* File input with a styled button */}
                                            <div className="mb-3 text-center" style={{width: "100%"}}>
                                                <input
                                                    type="file"
                                                    id="formFile"
                                                    className="form-control"
                                                    style={{ display: 'none' }}
                                                    onChange={handleFileChange}
                                                />
                                                <label
                                                    htmlFor="formFile"
                                                    className="btn btn-danger"
                                                    style={{
                                                        display: 'inline-block',
                                                        padding: '10px 20px',
                                                        fontSize: '16px',
                                                        cursor: 'pointer',
                                                    }}
                                                >
                                                    {isLoading ? (
                                                        <>
                                                            <span
                                                                className="spinner-border spinner-border-sm me-2"
                                                                role="status"
                                                                aria-hidden="true"
                                                            ></span>
                                                            Loading...
                                                        </>
                                                    ) : (
                                                        'Select Image'
                                                    )}
                                                </label>
                                            </div>
                                        </div>
                                                                        </div>
                                        <div className="col-md-9">
                                        <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input1">Your Name  
                                                <span class="contact__form--label__star">* </span>
                                                </label>
                                                <input class="contact__form--input" name="name" id="input1" placeholder="Your Name" type="text"
                                                required=""
                                                value={name}
                                                onChange={e => setName(e.target.value)}
                                                
                                                />
                                                {responseSuccess == true ?
                                                ''
                                                :
                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {nameError && <span >{nameError}</span>}  </p>
                                                }
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input4">Email <span class="contact__form--label__star">* </span></label>
                                                <input class="contact__form--input" name="email" id="input4" placeholder="Email" type="email"
                                                onChange={e => setEmail(e.target.value)}
                                                value={email}
                                                required=""
                                                />
                                                {responseSuccess == true ?
                                                ''
                                                :
                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {emailError && <span >{emailError}</span>}  </p>
                                                }
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">Mobile Number <span class="contact__form--label__star">* </span></label>
                                                <input class="contact__form--input" name="mobile" id="input3" 
                                                value={mobile}
                                                placeholder="Mobile number" type="text"
                                                onChange={e => setMobile(e.target.value)}
                                                required=""
                                                />
                                                {responseSuccess == true ?
                                                ''
                                                :
                                                <p className="errrowMsg" style={{fontSize: "14px"}}> {mobileError && <span >{mobileError}</span>}  </p>
                                                }
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                             <div class="checkout__input--list checkout__input--select select">
                                               
                                             <select class="form-select checkout__input--select__field border-radius-5" 
                                                    name="district"
                                                    value={selectedDistrict}
                                                  onChange={handleDistrictChange}
                                                 >

                                                    <option value="">Select District</option>
                                                    {district.map((d)=>(
                                                        <option key={d.id} value={d.id}>{d.name}</option>
                                                    ))}
                                                </select>


                                             </div>
                                         </div>

                                        <div class="col-lg-6 mb-12">
                                             <div class="checkout__input--list checkout__input--select select">
                                               
                                             <select class="form-select checkout__input--select__field border-radius-5"   disabled={!thanas.length}
                                                   name="city"
                                                   value={selectedCity}
                                                  onChange={handleCityChange}
                                                 >
                                                 <option value="">Select Thana</option>
                                                    {thanas.map((thana) => (
                                                    <option key={thana.id} value={thana.id}>
                                                        {thana.name}
                                                    </option>
                                                    ))}
                                                 </select>

                                             </div>
                                         </div>
                                        <div class="col-12">
                                            <div class="contact__form--list mb-15">
                                                <label class="contact__form--label" for="input5">Address<span class="contact__form--label__star">* </span></label>
                                                <textarea class="contact__form--textarea" name="address"  placeholder="Write Your Message"
                                                value={address}
                                                onChange={e => setAddress( e.target.value)}
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
                                        </div>
                                    </div>
                                   
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
