import { useState } from "react";

export default function AlertMessageComponents({ status, message }) {
    const [alertMsgShow, setAlertMsgShow] = useState(true);

    const closeButton = () => {
        setAlertMsgShow(false);
    };

    const renderAlert = () => {
        if (!alertMsgShow) return null; // If alert is not to be shown, return null

        switch (status) {
            case 'success':
                return (
                    <div className="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> {message}
                        <button type="button" className="btn-close" onClick={closeButton}></button>
                    </div>
                );
            case 'error':
                return (
                    <div className="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops!</strong> {message}
                        <button type="button" className="btn-close" onClick={closeButton}></button>
                    </div>
                );
            case 'info':
                return (
                    <div className="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Info</strong> {message}
                        <button type="button" className="btn-close"></button>
                    </div>
                );
            default:
                return null;
        }
    };

    return <>{renderAlert()}</>;
}
