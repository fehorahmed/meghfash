import { Link } from "@inertiajs/react";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";

export default function Pagination2({ pagination }) {
    if (!pagination || pagination.last_page <= 1) return null;

    return (
        <div className="pagination__area bg__gray--color">
            <nav className="pagination justify-content-center">
                <ul className="pagination__wrapper">

                    {/* Previous Button */}
                    <li className={`pagination__list ${!pagination.prev_page_url ? 'disabled' : ''}`}>
                        {pagination.prev_page_url ? (
                            <Link href={pagination.prev_page_url} className="pagination__item--arrow link">
                                <FaArrowLeft />
                            </Link>
                        ) : (
                            <span className="pagination__item--arrow link disabled">
                                <FaArrowLeft />
                            </span>
                        )}
                    </li>

                    {/* Page Numbers */}
                    {pagination.links
                        .filter(link => !link.label.includes('Previous') && !link.label.includes('Next'))
                        .map((link, index) => (
                            <li key={index} className="pagination__list">
                                {link.active ? (
                                    <span className="pagination__item pagination__item--current">
                                        {link.label}
                                    </span>
                                ) : (
                                    <Link href={link.url} className="pagination__item link">
                                        {link.label}
                                    </Link>
                                )}
                            </li>
                        ))}

                    {/* Next Button */}
                    <li className={`pagination__list ${!pagination.next_page_url ? 'disabled' : ''}`}>
                        {pagination.next_page_url ? (
                            <Link href={pagination.next_page_url} className="pagination__item--arrow link">
                                <FaArrowRight />
                            </Link>
                        ) : (
                            <span className="pagination__item--arrow link disabled">
                                <FaArrowRight />
                            </span>
                        )}
                    </li>

                </ul>
            </nav>
        </div>
    );
}
