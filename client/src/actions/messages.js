import Axios from 'axios';
import { showNotification } from '../actions/notification';


export const SET_MESSAGES = 'SET_MESSAGES';




export const setMessage = (messages) => {
    return {
        type: SET_MESSAGES,
        messages: messages
    };
};



export const sendMessage = (text) => {
    return (dispatch) => {
        return Axios.post('/api/message/send', JSON.stringify(text))
            .then(response => {
                dispatch(setMessage(response.data));
            })
    };
};


export const getLastMessages = () => {
    return (dispatch) => {
        return Axios.get('/api/messages/last')
            .then(response => {
                dispatch(setMessage(response.data));
            })
    };
};


export const getMessagesFromId = (id) => {
    return (dispatch) => {
        return Axios.get('/api/messages/from/'+id)
            .then(response => {
                dispatch(setMessage(response.data));
            })
    };
};


