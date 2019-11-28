import React, {useRef} from "react";

const SendMessageForm = (props) => {
    const {send} = props;

    let msg = useRef(null);

    return (
            <div>
                <div className="form-group">
                    <textarea className="form-control textarea-msg" name="msg" placeholder="Сообщение..." ref={msg}/>
                </div>
                <button type="submit" className="btn btn-primary float-right" onClick={()=>send(msg)}>Отправить</button>
            </div>
    )
};


export default SendMessageForm;