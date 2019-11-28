import React from "react";
import {connect} from 'react-redux';


const Notification = (state) => {

    const showMessage = () => {
        if (!state.notification.text)
            return;

        return (
            <div className="notification-block">
                <p>{state.notification.text}</p>
            </div>
        )
    };

    return (
        <div>
            {showMessage()}
        </div>
    )
};


const mapStateToProps = state => ({
    notification: state.notification
});

export default connect(mapStateToProps)(Notification);