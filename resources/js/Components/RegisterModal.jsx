import { Link } from '@inertiajs/react';
import { useState } from 'react';
import { Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import { LuLogIn } from 'react-icons/lu';

function RegisterModal() {
  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  return (
    <>
      <p  onClick={handleShow}>
        Register
      </p>

      <Modal show={show} onHide={handleClose} centered >
        <Modal.Header closeButton style={{border:"none", paddingBottom: "0"}} >
          <Modal.Title>Login</Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <Form>
                <Form.Group className="mb-3" controlId="exampleForm.ControlInput1">
                    <Form.Label>Email address</Form.Label>
                    <Form.Control type="email" placeholder="Email Address" />
                </Form.Group>
                <Form.Group className="mb-3" controlId="exampleForm.ControlTextarea1">
                    <Form.Label>Password</Form.Label>
                    <Form.Control type="password" placeholder="Password" />
                </Form.Group>
                <div className='row'>
                    <div className='col-md-12 text-end mb-3'>
                        <Link href="" >Forget Password</Link>
                    </div>
                    <div className='col-md-2'></div>
                    <div className='col-md-8'>
                        <Button type="button" className="w-100"  size="lg" > <LuLogIn style={{height: "20px",marginRight: "10px"}} /> Login</Button>
                    </div>
                    <div className='col-md-2'></div>
                    <div className='col-md-2'></div>
                    <div className='col-md-12 text-center mt-3 mb-3'>
                        <p>
                        I have an Account
                        <Link href="">Login</Link>
                        </p>
                    </div>
                </div>
            </Form>
        </Modal.Body>
      </Modal>
    </>
  );
}

export default RegisterModal;