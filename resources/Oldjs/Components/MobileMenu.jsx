import { Link } from "@inertiajs/react";
import { useState } from "react";
import { Button, Dropdown } from "react-bootstrap";
import { FaBars, FaTimes } from "react-icons/fa";
import { LuLogIn } from "react-icons/lu";
import { Inertia } from "@inertiajs/inertia";
import { FaRegUserCircle } from "react-icons/fa";

const MobileMenu = ({ general, headerMenu, auth }) => {
    const [isOpen, setIsopen] = useState(false);

    const ToggleSidebar = () => {
        isOpen === true ? setIsopen(false) : setIsopen(true);
    };

    const handleLogout = (e) => {
        e.preventDefault();
        Inertia.post(route('logout')); 
    };
    

    return (
        <>
            <div className="mobileMenuDiv">
                <div className="container">
                    <nav className="row">
                        <div className="col-10">
                            <Link to href="/">
                                <img src={`/${general.logo}`} alt="" />
                            </Link>
                        </div>
                 
                        <div className="col-2 text-end">
                            <div className="bar" onClick={ToggleSidebar}>
                                <FaBars />
                            </div>
                        </div>
                    </nav>
                    <div
                        className={`sidebar ${isOpen == true ? "active" : ""}`}
                    >
                        <div className="sd-header">
                            <Link to="/">
                                <img src={`/${general.logo}`} alt="" />
                            </Link>
                            <div
                                className="btn btn-primary"
                                onClick={ToggleSidebar}
                            >
                                <FaTimes />
                            </div>
                        </div>

                        {headerMenu && headerMenu.items && (
                            <div className="sd-body">
                                <ul>
                                    {headerMenu.items.map((item) => (
                                        <li>
                                            <Link
                                                className="sd-link"
                                                href={`/${item.slug}`}
                                            >
                                                {item.title}{" "}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}
                         {auth.user ? (

                        <Dropdown>
                            <Dropdown.Toggle variant="primary" id="dropdown-basic">
                                {auth.user.name}
                            </Dropdown.Toggle>
                            <Dropdown.Menu>
                                <Dropdown.Item href={route('user.dashboard')}>Dashboard</Dropdown.Item>
                                <Dropdown.Item href={route('user.profileEdit')}>Profile</Dropdown.Item>
                                <Dropdown.Item href="#" onClick={handleLogout}>Logout</Dropdown.Item>
                            </Dropdown.Menu>
                            </Dropdown>
                            ):(
                            <div className="mobileLoginButton">
                                <Link href={route('login')}>
                                    <Button variant="primary authBtn" >
                                        <LuLogIn style={{ height: "20px", marginRight: "10px" }} />
                                        Login
                                    </Button>
                                
                                </Link>
                            
                            </div>
                        )}
                        
                    </div>
                    <div
                        className={`sidebar-overlay ${
                            isOpen == true ? "active" : ""
                        }`}
                        onClick={ToggleSidebar}
                    ></div>
                </div>
            </div>
        </>
    );
};

export default MobileMenu;
