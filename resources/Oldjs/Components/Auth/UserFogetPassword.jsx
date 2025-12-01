import { Link, router, useForm } from '@inertiajs/react';
import { Form } from 'react-bootstrap';
import Button from 'react-bootstrap/Button';
import { LuLogIn } from 'react-icons/lu';

export default function UserFogetPassword({toggleForm}) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        remember_me: false,
    });
    
    const submit = (e) => {
        e.preventDefault();
    
        post(route('forgotPassword'), {
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
              <Form.Label>Email address</Form.Label>
              <Form.Control type="email" placeholder="Email Address" value={data.email}
                    onChange={e => setData('email', e.target.value)} />
           
                <span className='text-danger'>{errors.email && <span>{errors.email}</span>}</span>
            </Form.Group>
            <div className='row'>
              
              <div className='col-md-12'>
              <Button type="submit" className="w-100" size="lg" disabled={processing}>
              <LuLogIn style={{ height: "20px", marginRight: "10px" }} /> Forget
            </Button>
             
              </div>
              <div className='col-md-12 text-center mt-3 mb-3'>
                <p>
                  I have not an account
                  <Link href="#" onClick={() => toggleForm('register')}> Register</Link>
                </p>
              </div>
            </div>
          </Form>
    </>
  )
}
