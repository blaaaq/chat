import React from "react";
import {connect} from 'react-redux';
import * as messages from '../actions/messages';
import * as notification from "../actions/notification";

import Message from '../components/Message';
import SendMessageForm from "../components/SendMessageForm";




class Chat extends React.Component {
    constructor(props) {
        super(props);
        this.lastMsgId=0;
        this.chatBlock = React.createRef();
        this.msg = React.createRef();
        this.scroll = this.scroll.bind(this);
        this.send = this.send.bind(this);
        this.add = this.add.bind(this);
        this.process=0;
    }


    componentDidMount() {
        this.props.getLastMessages();
        this.ws = new WebSocket('ws://localhost:8081/echo');
        this.ws.onmessage = (message) => this.onMessage(message);
    }

    onMessage(message) {
        let data = JSON.parse(message.data);
        if (data.error) {
            this.props.showNotification(data.error);
            return;
        }

        this.props.setMessage({message: data});
    }

    send(form){
        if(form.current.value === ''){
            this.props.showNotification('Сообщение пустое!');
            return;
        }

        let files = [];
        for(let id in this.props.messages.files)
            files.push([this.props.messages.files[id].hash, this.props.messages.files[id].type]);

        this.ws.send(JSON.stringify({message: form.current.value, files: files, session: this.props.user.session}));
        //this.props.sendMessage({text: form.current.value});
    }

    add(){
        setTimeout(()=> { this.process=0 },2000)
    }

    scroll(){
        if(this.chatBlock.current.scrollHeight - this.chatBlock.current.scrollTop < 1000) {
            if (this.process === 1)
                return;
            this.process = 1;
            this.props.getMessagesFromId(this.lastMsgId);
        }
    }


    render() {
        let messages=[];
         for(let key in this.props.messages.messages) {
                 if(Number(this.props.messages.messages[key].id)<this.lastMsgId || !this.lastMsgId)
                     this.lastMsgId=this.props.messages.messages[key].id;

             messages.push(<Message message={this.props.messages.messages[key]} />)
         }


        return (
            <div id="qqq" className="chat" onScroll={this.scroll} ref={this.chatBlock}>
                { this.props.isAuth() ? <SendMessageForm send={this.send} showFormUploadFile={this.props.messages.showFormUploadFile} changeShowFormUploadFile={this.props.changeShowFormUploadFile} loadFile={this.props.loadFile} deleteFile={this.props.deleteFile} files={this.props.messages.files} /> : <div className="text-center">Войдите, чтобы писать сообщения...</div> }
                { messages }
                {this.add()}
            </div>
        )
    }
}



const mapStateToProps = state => ({
    user: state.user,
    messages: state.messages
});

const mapDispatchToProps = {
    setMessage: messages.setMessage,
    changeShowFormUploadFile: messages.changeShowFormUploadFile,
    getLastMessages: messages.getLastMessages,
    getMessagesFromId: messages.getMessagesFromId,
    loadFile: messages.loadFile,
    deleteFile: messages.deleteFile,
    showNotification: notification.showNotification
};

export default connect(mapStateToProps, mapDispatchToProps)(Chat);