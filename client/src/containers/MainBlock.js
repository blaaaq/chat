import React from "react";
import {connect} from 'react-redux';
import {Route, Switch} from "react-router";

import Chat from './Chat';

import * as user from '../actions/user';


class MainBlock extends React.Component {

    componentDidMount() {
          this.props.checkUser();
    }


    render() {
        return (
            <div className="order-md-first col-md-7">
                <Switch>
                    <Route path="/" render={(props)=><Chat {...this.props}/>}/>
                </Switch>
            </div>
        )
    }
}


const mapStateToProps = state => ({
    user: state.user
});

const mapDispatchToProps = {
    checkUser: user.checkUser
};

export default connect(mapStateToProps, mapDispatchToProps)(MainBlock);