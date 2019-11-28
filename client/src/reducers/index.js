import { combineReducers } from 'redux';
import user from './user';
import messages from './messages';
import notification from './notification';



const rootReducer = combineReducers({
    user: user,
    messages: messages,
    notification: notification
});

export default rootReducer;
