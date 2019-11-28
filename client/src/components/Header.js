import React from "react";
import {Link} from "react-router-dom";

const Header = ({isAuth, logout}) => {

    return (
        <div className='container-fluid p-0'>
            <nav className="navbar navbar-expand-sm navbar-dark bg-dark">
                <div className="container justify-content-sm-start justify-content-lg-center">
                    <Link to="/" className="navbar-brand">ONLINE CHAT</Link>
                    <button className="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse w-100" id="navbarNavDropdown">
                        <ul className="navbar-nav mr-auto">
                            <li className="nav-item active">
                                <Link to="/" className="nav-link">&lt; В чат</Link>
                            </li>
                        </ul>
                        {isAuth() &&
                        <span className="navbar-text p-0">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item active text-white" style={{cursor: "pointer"}} onClick={logout}>Выйти из аккаунта</li>
                     </ul>
                </span>
                        }
                    </div>

                </div>
            </nav>
        </div>
    )
};


export default Header