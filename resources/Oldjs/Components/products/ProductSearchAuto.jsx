import { useState } from "react";
import { IoIosSearch } from "react-icons/io";
import axios from "axios";
import { Link } from "@inertiajs/react";
import { useForm } from "@inertiajs/inertia-react";
export default function ProductSearchAuto({ categoryMenu }) {

  const [datas, setDatas] = useState({
    category_id: '',
    search: '',
    autoSearch: true,
  });

  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);
  const [debounceTimeout, setDebounceTimeout] = useState(null);

  // Function to update URL parameters
  const updateURLParams = (updatedData) => {
    const params = new URLSearchParams();

    if (updatedData.category_id) {
      params.set('category_id', updatedData.category_id);
    }

    if (updatedData.search) {
      params.set('search', updatedData.search);
    }

    // Update the URL without reloading the page
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState(null, '', newUrl);
  };

  // Function to handle automatic search
  const handleSearch = (updatedData) => {
    if (debounceTimeout) clearTimeout(debounceTimeout);

    setDebounceTimeout(
      setTimeout(() => {
        setLoading(true);
        axios
          .get(route('search'), {
            params: updatedData, // Send updated data as query params
          })
          .then((response) => {
            setResults(response.data.results.data || []);
            setLoading(false);
          })
          .catch((error) => {
            console.error("Search error:", error);
            setLoading(false);
          });
      }, 500) // Add a debounce delay
    );
  };

  // Handle input changes
  const handleInputChange = (e) => {
    const { name, value } = e.target;

    setDatas((prevData) => {
      const updatedData = { ...prevData, [name]: value };

      // Update the URL parameters
      updateURLParams(updatedData);

      setData(name, value);

      // Trigger search if autoSearch is enabled
      if (updatedData.autoSearch && name === 'search' || name === 'category_id') {
        handleSearch(updatedData);
      }

      return updatedData;
    });
  };


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
    <div className="product-search">
      <form className="d-flex header__search--form" onSubmit={submit}>
        {categoryMenu && categoryMenu.items && (
          <div className="header__select--categories select">
            <select
              className="form-select header__select--inner"
              name="category_id"
              value={datas.category_id}
              onChange={handleInputChange}
            >
              <option value="">{categoryMenu.title}</option>
              {categoryMenu.items.map((item, index) => (
                <option key={index} value={item.src_id}>
                  {item.title}
                </option>
              ))}
            </select>
          </div>
        )}
        <div className="header__search--box">
          <label>
            <input
              className="header__search--input"
              name="search"
              placeholder="Keyword here..."
              type="text"
              value={datas.search}
              onChange={handleInputChange}
            />
          </label>
          {/* <button
            className="header__search--button bg__secondary text-white"
            type="button"
            aria-label="search button"
            onClick={() => handleSearch(data)}
          >
            <IoIosSearch />
          </button> */}
          <button
            className="header__search--button bg__secondary text-white"
            type="submit"
            aria-label="search button"
           
          >
            {processing ? <><div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div></> : <IoIosSearch />}
            
          </button>
        </div>
      </form>

      {/* Results Section */}
      <div className="search-results">
        {loading && <p className="text-center pt-2">Search...</p>}
        {!loading && results.length > 0 && (
          <div className="searchProduct">
            {results.map((product, index) => (
              <Link className="row" href={route('productView', product.slug?product.slug:'no-title')}  key={index} >
                <div className="col-1" style={{padding: "0"}}><img src={product.image_url} alt={product.name} className="result-image" /></div>
                <div className="col-8"> <h4 className="result-title"> 
                    {product.name.length > 60 ? product.name.slice(0, 60) + '...' : product.name}
                </h4></div>
                <div className="col-3" style={{padding: "0"}}><span className="result-price" style={{textAlign: "right", display: "block"}}> {product.finalPrice} </span></div>
              </Link>
            ))}
          </div>
        )}
        {!loading && results.length === 0 && datas.search && <p className="no-results text-center mt-2">No products found!</p>}
      </div>
    </div>
  );
}
