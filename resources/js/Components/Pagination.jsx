import { Link } from "@inertiajs/react";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";
export default function Pagination({ pagination, currentPage, totalPages, onPageChange }) {

    return (
        <>
           {pagination.links.length > 3 && (
                <>
                <div class="pagination__area bg__gray--color">
                    <nav class="pagination justify-content-center">
                        <ul class="pagination__wrapper">
                            <li class={`pagination__list ${pagination.current_page === 1 ? 'disabled' : ''}`}>
                                <Link href={pagination.prev_page_url} class="pagination__item--arrow  link ">
                                    <FaArrowLeft />
                                    <span class="visually-hidden">pagination arrow </span>
                                </Link>
                            </li>

                            {Array.from({ length: pagination.last_page }, (_, index) => (
                            <li class="pagination__list">
                                    {pagination.current_page === index + 1 ? <span className="pagination__item pagination__item--current">{ index + 1 }</span> 
                                    :
                                    <Link className="pagination__item link" href={`${pagination.path}?page=${index+1}`}>
                                        {index + 1}
                                    </Link>
                                    }
                            </li>
                            ))}
                            <li class={`pagination__list ${pagination.current_page === pagination.last_page ? 'disabled' : ''}`}>
                                <Link href={pagination.next_page_url} class="pagination__item--arrow  link">
                                    <FaArrowRight />
                                    <span class="visually-hidden">pagination arrow </span>
                                </Link>
                            </li>
                            </ul>
                    </nav>
                </div>
                </>
            )} 


            {/* {pagination.links.length > 3 && (
                <div className="pagination__area bg__gray--color">
                    <nav className="pagination justify-content-center">
                    <ul className="pagination__wrapper d-flex align-items-center justify-content-center">
                     
                        <li
                        className={`pagination__list ${
                            pagination.current_page === 1 ? 'disabled' : ''
                        }`}
                        >
                        <button
                            onClick={() => onPageChange(pagination.current_page - 1)}
                            disabled={pagination.current_page === 1}
                            className="pagination__item--arrow link"
                        >
                            <FaArrowLeft />
                            <span className="visually-hidden">pagination arrow</span>
                        </button>
                        </li>

      
                        {Array.from({ length: pagination.last_page }, (_, index) => (
                        <li key={index} className="pagination__list">
                            {pagination.current_page === index + 1 ? (
                            <span className="pagination__item pagination__item--current">
                                {index + 1}
                            </span>
                            ) : (
                            <button
                                onClick={() => onPageChange(index + 1)}
                                className="pagination__item link"
                            >
                                {index + 1}
                            </button>
                            )}
                        </li>
                        ))}

                    
                        <li
                        className={`pagination__list ${
                            pagination.current_page === pagination.last_page ? 'disabled' : ''
                        }`}
                        >
                        <button
                            onClick={() => onPageChange(pagination.current_page + 1)}
                            disabled={pagination.current_page === pagination.last_page}
                            className="pagination__item--arrow link"
                        >
                            <FaArrowRight />
                            <span className="visually-hidden">pagination arrow</span>
                        </button>
                        </li>
                    </ul>
                    </nav>
                </div>
            )} */}



        </>
    );
}
