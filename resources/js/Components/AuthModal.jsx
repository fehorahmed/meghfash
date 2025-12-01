
import { Link, router, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { Dropdown, Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import { LuLogIn } from 'react-icons/lu';
import UserLogin from './Auth/UserLogin';
import UserRegister from './Auth/UserRegister';
import UserFogetPassword from './Auth/UserFogetPassword';
import { Inertia } from "@inertiajs/inertia";


function AuthModal({auth}) {
  const [show, setShow] = useState(false);

  const [formType, setFormType] = useState(''); // Track which form to show

  console.log(formType)


//   const { data, setData, post, processing, errors } = useForm({
//     email: '',
//     password: '',
//     remember_me: false,
//     });



  const handleClose = () => setShow(false);
  const handleShow = () => {
    setShow(true);
  }
    
  const toggleForm = (type) => setFormType(type);

  const handleLogout = (e) => {
    e.preventDefault();
    Inertia.post(route('logout')); 
};
  

  const renderForm = () => {
    switch (formType) {
      case 'login':
          return <UserLogin toggleForm={toggleForm} />;
      case 'register':
          return <UserRegister toggleForm={toggleForm} />;
      case 'forgot':
          return <UserFogetPassword toggleForm={toggleForm} />;
      default:
          return null;
    }
  };

  return (
    <>





      {auth.user ? (

        <Dropdown>
          <Dropdown.Toggle variant="primary" id="dropdown-basic">
              Dashboard
          </Dropdown.Toggle>
          <Dropdown.Menu>
            <Dropdown.Item href={route('user.dashboard')}>Dashboard</Dropdown.Item>
            <Dropdown.Item href={route('user.profileEdit')}>Profile</Dropdown.Item>
            <Dropdown.Item href="#" onClick={handleLogout}>Logout</Dropdown.Item>
          </Dropdown.Menu>
        </Dropdown>
      ):(
      <div style={{display: "inline-block", float: "right"}}>
        <Button variant="primary authBtn" onClick={() => {
        handleShow();
        toggleForm('login')
      
    }}>
          <LuLogIn style={{ height: "20px", marginRight: "10px" }} />
          Login
        </Button>

        <Modal show={show} onHide={handleClose} centered>
          <Modal.Header closeButton style={{ border: "none", paddingBottom: "0" }}>
            <Modal.Title>{formType.charAt(0).toUpperCase() + formType.slice(1)}</Modal.Title>
          </Modal.Header>
          <Modal.Body>

            {renderForm()}
          

          </Modal.Body>
        </Modal>
        </div>
        )}
    </>
  );
}

export default AuthModal;
