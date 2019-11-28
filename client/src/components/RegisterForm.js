import React, {useRef} from "react";


const RegisterForm = ({register}) => {
    const nickInput = useRef(null);
    const passwordInput = useRef(null);
    const passwordInput2 = useRef(null);

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
            <div className="form-group">
                <label htmlFor="exampleInputPassword1">Повтор пароля</label>
                <input type="password" className="form-control" id="exampleInputPassword1" name="password2" placeholder="Пароль..." ref={passwordInput2} />
            </div>
            <button type="submit" className="btn btn-primary float-right" onClick={() => register({nick:nickInput.current.value,password:passwordInput.current.value,password2:passwordInput2.current.value})}>Регистрация</button>
        </div>
    )
};




export default RegisterForm;