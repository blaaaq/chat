import React from "react";

const Message = (props) => {

    const {message} = props;

    const nowDate = new Date();
    const date = new Date();
    date.setTime(message.time*1000);

    const months=['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];


    let showDay = () => {
        if (nowDate.getDate() !== date.getDate())
            return <span className="pr-2"> {date.getDate()} {months[date.getMonth()]},</span>
    };

    let showYear = () => {
        if(nowDate.getFullYear() !== date.getFullYear())
            return <span className="pr-2"> {date.getFullYear()},</span>
    };

    let showTime = () => {
        let zero;
        if (String(date.getMinutes()).length === 1)
            zero = 0;

        return <span>{date.getHours()}:{zero}{date.getMinutes()}</span>;
    };

    let showImages = () => {
        let msg = '';
        message.files.forEach((hash) =>
            msg += `<img class="user-image" src="/user_images/${hash[0].substr(0,2)}/${hash[0]+hash[1]}" />`);

        return msg;
    };

    return (
        <div className="message">
            {message.senderNick}
            <span className="pl-2 message-time">
                {showDay()}
                {showYear()}
                в {showTime()}
            </span>
            <div>
                {message.text}
            </div>
            <div dangerouslySetInnerHTML={{__html: showImages()}}></div>
            <hr className="bg-secondary" />
        </div>
    )
};


export default Message;