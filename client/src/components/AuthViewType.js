import React, {useRef} from "react";


let AuthViewType = ({authViewType, changeAuthViewType}) => {
    return (
        <div>
            <div className="btn-group" role="group">
                <button type="button" className={authViewType !== 'register' ? "btn btn-secondary" : "btn bg-light"}
                        onClick={() => changeAuthViewType('auth')}>
                    Вход
                </button>
                <button type="button" className={authViewType === 'register' ? "btn btn-secondary" : "btn bg-light"}
                        onClick={() => changeAuthViewType('register')}>
                    Регистрация
                </button>
            </div>
            <div className="clearfix"></div>
            <hr className="bg-secondary"/>
        </div>
    )
};


export default AuthViewType;