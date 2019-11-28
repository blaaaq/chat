import React from "react";
import {connect} from 'react-redux';
import * as messages from '../actions/messages';

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
    }


    send(form){
        this.props.sendMessage({text: form.current.value});
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
                { this.props.isAuth() ? <SendMessageForm send={this.send} /> : <div className="text-center">Войдите, чтобы писать сообщения...</div> }
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
    sendMessage: messages.sendMessage,
    getLastMessages: messages.getLastMessages,
    getMessagesFromId: messages.getMessagesFromId,
};

export default connect(mapStateToProps, mapDispatchToProps)(Chat);