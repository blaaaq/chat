import { SET_MESSAGES } from '../actions/messages';
import { ADD_FILE, DELETE_FILE, SHOW_FORM_UPLOAD_FILE } from '../actions/messages';

import * as _ from 'lodash';

export default (state = {}, action) => {
    switch (action.type) {
        case SET_MESSAGES:
            const result = _.values(_.merge(
                _.keyBy(state.messages, 'id'),
                _.keyBy(action.messages, 'id')
            ));
            return { ...state, messages: _.reverse(result)};

        case ADD_FILE:
            return { ...state, files: {...state.files, [action.file.id]: action.file} };
        case DELETE_FILE:
            let new_files = state.files;
            delete new_files[action.id];
            return { ...state, files: new_files};

        case SHOW_FORM_UPLOAD_FILE:
            return { ...state, showFormUploadFile: !state.showFormUploadFile };

        default:
            return state;
    }
};

