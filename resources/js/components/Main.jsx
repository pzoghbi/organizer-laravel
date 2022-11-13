import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import {Navbar} from './Navbar';
import {Home} from './Home';
import {ScheduleList} from './ScheduleList';
import {TaskIndex} from "./TaskIndex";
import {TaskCreate} from "./TaskCreate";
import {MaterialIndex} from "./MaterialIndex";
import {MaterialCreate} from "./MaterialCreate";
import {MaterialShow} from "./MaterialShow";
import {TaskShow} from "./TaskShow";
import {TaskEdit} from "./TaskEdit";
import {LoginForm} from "./LoginForm";
import axios from "axios";

/**
 * @return {boolean}
 */
function Main() {
    // TODO make this better, more React way
    axios.get('/api/auth/check')
        .then(response => {
            let userIsLoggedIn = response.data;
            if (userIsLoggedIn === false && location.pathname !== '/login') {
                location.href = '/login';
            }
        });

    return (
        <BrowserRouter>
            <Navbar />
            <main className="py-4 container">
                <div className="row justify-content-center">
                    <div className="col-lg-12 col-md-10 col-sm-12">
                        <Routes>
                            <Route path="/login" element={<LoginForm/>}/>

                            <Route path="/" element={<Home/>}/>
                            <Route path="schedules" element={<ScheduleList/>}/>

                            <Route path="tasks">
                                <Route index element={<TaskIndex />}/>
                                <Route path="create" element={<TaskCreate/>}/>
                                <Route path=":taskId/show" element={<TaskShow/>}/>
                                <Route path=":taskId/edit" element={<TaskEdit/>}/>
                            </Route>

                            <Route path="materials">
                                <Route path="" element={<MaterialIndex/>}/>
                                <Route path="create" element={<MaterialCreate/>}/>
                                <Route path=":materialId/show" element={<MaterialShow/>}/>
                            </Route>
                            {/*<Route path="/study" element={<Study/>} />*/}
                        </Routes>
                    </div>
                </div>
            </main>
        </BrowserRouter>
    );
}

export default Main;

if (document.getElementById('main')) {
    ReactDOM.render(<Main />, document.getElementById('main'));
}
