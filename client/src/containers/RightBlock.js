import React from "react";
import {connect} from 'react-redux';

import AuthForm from "../components/AuthForm";
import RegisterForm from "../components/RegisterForm";
import AuthViewType from "../components/AuthViewType";

import * as user from '../actions/user';



class RightBlock extends React.Component {

    constructor(props) {
        super(props);

        this.nickInput = React.createRef();
        this.passwordInput = React.createRef();
    }


    auth() {
        this.props.login({nick:this.nickInput.current.value,password:this.passwordInput.current.value})
    }


    render() {
        return (
            <div className="block-right order-first col-md-3">
                {!this.props.isAuth() &&
                    <AuthViewType authViewType={this.props.user.authViewType} changeAuthViewType={this.props.changeAuthViewType} />}

                { !this.props.isAuth() && (
                    this.props.user.authViewType !== 'register' ?
                        <AuthForm login={this.props.login} /> : <RegisterForm register={this.props.register} />
                    )}
            </div>
        )
    }
}


const mapStateToProps = state => ({
    user: state.user
});

const mapDispatchToProps = {
    changeAuthViewType: user.changeAuthViewType,
    login: user.login,
    register: user.register
};

export default connect(mapStateToProps, mapDispatchToProps)(RightBlock);