import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { IoIosSearch } from "react-icons/io";



export default function ProductSearch({categoryMenu}) {

    const { data, setData, get, processing, errors } = useForm({
        category_id: '',
        search: '',
    });

    const [showAlert, setShowAlert] = useState(false);
    const [alertMessage, setAlertMessage] = useState('hellow');
    
    const submit = (e) => {
        e.preventDefault();
    
        get(route('search'), {
            onSuccess: () => {
                // Handle successful login response here
                console.log("Logged in successfully!");
            },
            onError: (errors) => {
                setShowAlert(true);
                setAlertMessage('sdflksd');
                console.log(errors);

            },
            onFinish: () => {
                // Optionally, you can reset form data here
                //reset();
            }
        });
    };



  return (
        <form className="d-flex header__search--form" onSubmit={submit} >
            {categoryMenu && categoryMenu.items &&
            <div className="header__select--categories select">
                    <select className="form-select header__select--inner"
                    name="category_id"
                    value={data.category_id}
                    onChange={e => setData('category_id', e.target.value)}
                    >
                    <option value=""> {categoryMenu.title} </option>
                    {categoryMenu.items.map((item, index) => (
                    <option value={item.src_id}>{item.title}</option>
                    ))}
                </select>
            </div>
            }
            <div className="header__search--box">
                <label>
                    <input className="header__search--input" name="search" placeholder="Keyword here..." type="text"
                     value={data.search}
                     onChange={e => setData('search', e.target.value)}
                    />
                </label>
                <button className="header__search--button bg__secondary text-white" type="submit" aria-label="search button">
                <IoIosSearch />
                </button>
            </div>
        </form>
  )
}
