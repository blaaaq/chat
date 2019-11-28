import React from "react";

const Message = (props) => {

    const {message} = props;

    const nowDate = new Date();
    const date = new Date();
    date.setTime(message.time*1000);

    const months=['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'декабря'];



    return (
        <div className="message">
            { message.senderNick }
            &nbsp;&nbsp;&nbsp;
            { nowDate.getFullYear() !== date.getFullYear() ? date.getFullYear() : ''}
            { nowDate.getMonth() !== date.getMonth() ? months[date.getMonth()-1] : ''}
            { nowDate.getDate() !== date.getDate() ? date.getDate() : ''}
            <div className="message-time">в { date.getHours() }:{ String(date.getMinutes()).length === 1 ? '0'+date.getMinutes() : date.getMinutes()} </div>

            <div>
            { message.text }
            </div>
            <hr className="bg-secondary" />
        </div>
    )
};


export default Message;