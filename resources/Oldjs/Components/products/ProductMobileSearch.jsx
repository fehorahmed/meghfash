import { useForm } from '@inertiajs/inertia-react';
import React from 'react'

export default function ProductMobileSearch() {
        const { data, setData, get, processing, errors } = useForm({
            category_id: '',
            search: '',
        });

        
        const submit = (e) => {
            e.preventDefault();
        
            get(route('search'), {
                onSuccess: () => {
                    // Handle successful login response here
                    console.log("Logged in successfully!");
                },
                onError: (errors) => {

                    console.log(errors);
    
                },
                onFinish: () => {
                    // Optionally, you can reset form data here
                    //reset();
                }
            });
        };
  return (
            <form onSubmit={submit} class="predictive__search--form" action="#">
                <label>

                    <input className="predictive__search--input" name="search" placeholder="Keyword here..." type="text"
                     value={data.search}
                     onChange={e => setData('search', e.target.value)}
                    />
                </label>
                <button class="predictive__search--button" aria-label="search button" type="submit"><svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="25.443" viewBox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path></svg>  </button>
            </form>
  )
}
