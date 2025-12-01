import { Link, router, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import { LuLogIn } from 'react-icons/lu';

export default function UserRegister({toggleForm}) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        mobile: '',
        email: '',
        password: '',
        remember_me: false,
    });

    console.log(data)
    
    const submit = (e) => {
        e.preventDefault();
    
        post(route('register'), {
            onSuccess: () => {
                // Handle successful login response here
                console.log("Logged in successfully!");
            },
            onError: (errors) => {
                // Handle error responses here
                console.log(errors);
            },
            onFinish: () => {
                // Optionally, you can reset form data here
                // reset();
            }
        });
    };
  return (
    <>
     <Form onSubmit={submit}>
            <Form.Group className="mb-3" controlId="loginEmail">
              <Form.Label>Your Name</Form.Label>
              <Form.Control type="text" placeholder="Your Name" value={data.name}
                    onChange={e => setData('name', e.target.value)} />
             
                <span className='text-danger'>{errors.name && <span>{errors.name}</span>}</span>
            </Form.Group>
            <Form.Group className="mb-3" controlId="loginEmail">
              <Form.Label>Mobile Number</Form.Label>
              <Form.Control type="text" placeholder="Mobile Number" value={data.mobile}
                    onChange={e => setData('mobile', e.target.value)} />
             
                <span className='text-danger'>{errors.mobile && <span>{errors.mobile}</span>}</span>
            </Form.Group>
           
            <Form.Group className="mb-3" controlId="loginEmail">
              <Form.Label>Email address</Form.Label>
              <Form.Control type="email" placeholder="Email Address" value={data.email}
                    onChange={e => setData('email', e.target.value)} />
             
                <span className='text-danger'>{errors.email && <span>{errors.email}</span>}</span>
            </Form.Group>
            <Form.Group className="mb-3" controlId="loginPassword">
              <Form.Label>Password</Form.Label>
              <Form.Control type="password" placeholder="Password" value={data.password}
                    onChange={e => setData('password', e.target.value)} />
              
               <span className='text-danger'> {errors.password && <span>{errors.password}</span>}</span>
            </Form.Group>
            <div className='row'>
              <div className='col-md-12 text-end mb-3'>
                <Link href="">Forget Password</Link>
              </div>
              <div className='col-md-12'>
              <Button type="submit" className="w-100" size="lg" disabled={processing}>
              <LuLogIn style={{ height: "20px", marginRight: "10px" }} /> Register
            </Button>
             
              </div>
              <div className='col-md-12 text-center mt-3 mb-3'>
                <p>
                  I have  an alrady account
                  <Link href="#" onClick={() => toggleForm('login')}> Login</Link>
                </p>
              </div>
            </div>
          </Form>
    </>
  )
}
