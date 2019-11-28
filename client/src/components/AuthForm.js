import React, {useRef} from "react";



let AuthForm = ({login}) => {
    const nickInput = useRef(null);
    const passwordInput = useRef(null);

    return (
        <div>
            <div className="form-group">
                <label htmlFor="exampleInputEmail1">Логин</label>
                <input type="text" className="form-control" id="exampleInputEmail1" name="nick" aria-describedby="emailHelp"
                       placeholder="Ник..." ref={nickInput} />
            </div>
            <div className="form-group">
                <label htmlFor="exampleInputPassword1">Пароль</label>
                <input type="password" className="form-control" id="exampleInputPassword1" name="password" placeholder="Пароль..." ref={passwordInput} />
            </div>
            <button type="submit" className="btn btn-primary float-right" onClick={() => login({nick:nickInput.current.value,password:passwordInput.current.value})}>Войти</button>
        </div>
        )
};


export default AuthForm;