import React from "react";
import {BrowserRouter, Route, Switch} from "react-router-dom";
import {connect} from 'react-redux';

import Header from '../components/Header';
import MainBlock from './MainBlock';
import RightBlock from './RightBlock';
import Notification from '../components/Notification';
import * as user from "../actions/user";



function App(props) {
    const {user, logout} = props;

    const isAuth = () => {
        return !((user.user || user.user === 'undefined') && user.user === 'null');
    };

    return (
        <BrowserRouter>
            <Notification />
            <Header isAuth={isAuth} logout={logout} />
            <div className="container">
                <div className="row justify-content-md-end">
                    <MainBlock isAuth={isAuth}  />
                    <RightBlock isAuth={isAuth} />
                </div>
            </div>
        </BrowserRouter>
    );
}




const mapStateToProps = state => ({
    user: state.user
});
const mapDispatchToProps = {
    logout: user.logout,
};

export default connect(mapStateToProps, mapDispatchToProps)(App);
