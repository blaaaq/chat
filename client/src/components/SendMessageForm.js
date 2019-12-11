import React, {useRef} from "react";
import upload_icon from '../images/icons/icon_upload_file.png';

const SendMessageForm = (props) => {
    const {send, showFormUploadFile, changeShowFormUploadFile, loadFile, deleteFile, files} = props;

    let msg = useRef(null);

    let clickUpload = (event) => {
        if(event.target.id !== 'file_input')
            changeShowFormUploadFile();
    };

    let selectFile = (e) => {
        let fileData = new FormData();
        fileData.append( 'file', e.target.files[0] );
        e.target.value='';
        loadFile(fileData)
    };

    let showFiles = () => {
        let msg = '', i = 1;
        for(let id in files) {
            msg += `<div class="ml-2"><span class="small">${i}.</span> ${files[id].name}<a class="ml-3 text-danger cursor-pointer" id="${files[id].id}">x</a></div>`;
            i++;
        }
        if(msg)
            msg = `<div>Вложенные картинки:</div>${msg}`;
        return msg;
    };

    let delFile = (e) => {
        for(let id in files)
            if(e.target.id === files[id].id)
                deleteFile(files[id].id)
    };

    return (
            <div>
                <div className="form-group mb-0 pb-0">
                    <textarea className="form-control textarea-msg" name="msg" placeholder="Сообщение..." ref={msg}/>
                </div>
                <div onClick={delFile} dangerouslySetInnerHTML={{__html: showFiles()}}></div>

                <div className="float-right mb-0 pb-0">
                    <div className="d-inline pr-2 cursor-pointer" onClick={ clickUpload }>
                        { showFormUploadFile ? <span><input id="file_input" type="file" onChange={(e) => selectFile(e)} /> x</span> : <img width="22" src={upload_icon} />}
                    </div>
                    <button type="submit" className="btn btn-primary" onClick={()=>send(msg)}>
                        Отправить
                    </button>
                </div>
                <div className="clearfix"></div>
            </div>

    )
};


export default SendMessageForm;