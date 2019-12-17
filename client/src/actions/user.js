import Axios from 'axios';
import { showNotification } from '../actions/notification';


export const SET_USER = 'SET_USER';
export const AUTH_VIEW_TYPE = 'VIEW_TYPE';



export const setUser = (user,newSession) => {
    return {
        type: SET_USER,
        user: user,
        session: newSession
    };
};

export const changeAuthViewType = (authViewType) => {
    return {
        type: AUTH_VIEW_TYPE,
        authViewType: authViewType,
    };
};




export const checkUser = () => {
    return (dispatch) => {
        return Axios.get('/api/auth/check')
            .then(response => {
                if(response.data.nick)
                    dispatch(setUser(response.data.nick, response.data.newSession));
                else
                   dispatch(setUser('null'));
            })
    };
};


export const login = (data) => {
    return dispatch => {
        return Axios.post('/api/auth', JSON.stringify(data))
            .then(response => {
                if(response.data.nick){
                    dispatch(setUser(response.data.nick, response.data.newSession));
                    dispatch(showNotification('Вы успешо вошли!'));
                }
                else
                    dispatch(showNotification(response.data));
            })
            .catch(err => {
                dispatch(showNotification('Какая-то ошибка. Попробуйте позже...'));
            });
    };
};

export const register = (data) => {
    return dispatch => {
        if(data.password !== data.password2) {
            dispatch(showNotification('Пароли не совпадают!'));
            return;
        }

        return Axios.post('/api/register', JSON.stringify(data))
            .then(response => {
                if(response.data.nick){
                    dispatch(setUser(response.data.nick, response.data.newSession));
                    dispatch(showNotification('Вы успешо зарегистрировались!'));
                }
                else
                    dispatch(showNotification(response.data));
            })
            .catch(err => {
                dispatch(showNotification('Какая-то ошибка. Попробуйте позже...'));
            });
    };
};

export const logout = () => {
    return dispatch => {
        return Axios.post('/api/logout')
            .then(response => {
                if(response.data.success==='ok') {
                    dispatch(setUser('null', ''));
                    dispatch(showNotification('Вы успешно вышли!'));
                }
                else
                    dispatch(showNotification('Какая-то ошибка. Попробуйте позже...'));
            })
            .catch(err => {

            });
    };
};