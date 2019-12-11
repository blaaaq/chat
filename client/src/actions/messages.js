import Axios from 'axios';
import { showNotification } from '../actions/notification';

export const SET_MESSAGES = 'SET_MESSAGES';
export const ADD_FILE = 'ADD_FILE';
export const DELETE_FILE = 'DELETE_FILE';
export const SHOW_FORM_UPLOAD_FILE = 'SHOW_FORM_UPLOAD_FILE';



export const setMessage = (messages) => {
    return {
        type: SET_MESSAGES,
        messages: messages
    };
};

export const addFile = (id, hash, type, name) => {
    return {
        type: ADD_FILE,
        file: {id: id, hash: hash, type: type, name: name}
    };
};

export const deleteFile = (id) => {
    return {
        type: DELETE_FILE,
        id: id
    };
};

export const changeShowFormUploadFile = () => {
    return {
        type: SHOW_FORM_UPLOAD_FILE
    };
};

/*
export const sendMessage = (text) => {
    return (dispatch) => {
        return Axios.post('/api/message/send', JSON.stringify(text))
            .then(response => {
                dispatch(setMessage(response.data));
            })
    };
};
*/

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


export const loadFile = (file) => {
    return (dispatch) => {
        return Axios.post('/api/message/loadfile', file)
            .then(response => {
                if (response.data.result === 'ok')
                    dispatch(addFile(response.data.id, response.data.hash, response.data.type, response.data.name));
                else
                    dispatch(showNotification(response.data));
            })
    };
};
