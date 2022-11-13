import {useRef} from 'react';
import {Link, useNavigate} from "react-router-dom";
import axios from "axios";

export function Navbar() {
    function route(name) {
        switch(name){
            case 'home': return '/';
            case 'schedule.index': return '/schedule';
            case 'task.index': return '/tasks';
            case 'material.index': return '/material';
            case 'logout': return '/logout';
        }
    }

    let logoutForm = useRef(null);
    let navigate = useNavigate();

    function handleSubmit(e){
        e.preventDefault();

        axios.post("/logout").then(response => {
            console.log('navigating...');
            location.href = '/';
        });
    }

    let linkClass = "link-secondary rounded-1 px-4 bg-opacity-25";

    return (
        <nav className="navbar navbar-expand-lg position-relative shadow container-fluid d-flex bg-light">
            <div className="d-flex position-relative start-0 top-0 w-auto collapse" style={{ zIndex: 1 }}>
                <a className="navbar-brand text-reset fw-bolder text-uppercase border border-1 p-1 rounded"
                   href={ route('home') }>
                        Task<i className="bi bi-shield-fill mx-1 fs-4"/>Titan
                </a>

                <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"/>
                </button>
            </div>

            <div className="collapse navbar-collapse justify-content-center position-absolute w-100"
                 id="navbarSupportedContent">
                <div className="navbar-nav mb-2 mb-lg-0 d-flex fs-2">
                    <Link to={'/'} className={linkClass}><i className="bi bi-house"/></Link>
                    <Link to={'/schedule'} className={linkClass}><i className="bi bi-calendar-week"/></Link>
                    <Link to={'/tasks'} className={linkClass}><i className="bi bi-check-square"/></Link>
                    <Link to={'/materials'} className={linkClass}><i className="bi bi-folder"/></Link>
                    <Link to={'/study'} className={linkClass}><i className="bi bi-book"/></Link>
                </div>
            </div>

            <div className="d-flex w-auto ms-auto collapse">
                <div className="d-inline-block align-middle me-2">
                    <form>
                        <div className="input-group">
                            <input className="form-control rounded-pill rounded-end" type="search" placeholder="Search" aria-label="Search" />
                            <button className="btn btn-success text-white rounded-pill rounded-start" type="submit">
                                <i className="bi bi-search"/>
                            </button>
                        </div>
                    </form>
                </div>

                <div className="nav-item dropdown">
                    <button
                        className="btn btn-outline-secondary rounded-circle border-0 bg-dark text-secondary bg-opacity-10"
                        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i className="bi bi-caret-down-fill align-middle"/>
                    </button>

                    <ul className="dropdown-menu dropdown-menu-end shadow py-0 overflow-hidden mt-2 border-0"
                        aria-labelledby="navbarDropdown">
                        <li><a className="dropdown-item border-bottom border-light" href="#">Profile</a></li>
                        <li><a className="dropdown-item border-bottom border-light" href="#">Settings</a></li>
                        <li>
                            <button className="dropdown-item" type="Submit" form="logout-form">Logout</button>
                            <form id="logout-form" onSubmit={handleSubmit} className="d-none" ref={logoutForm} />
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
}
