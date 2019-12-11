export const CHANGE_NOTIFICATION = 'CHANGE_NOTIFICATION';



export const changeNotification = (text) => {
    return {
        type: CHANGE_NOTIFICATION,
        text: text
    };
};


export const showNotification = (message) => {
    return dispatch => {
        dispatch(changeNotification(message));
        setTimeout(() => dispatch(changeNotification('')),2000);
    };
};
