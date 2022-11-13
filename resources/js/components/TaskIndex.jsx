import axios from 'axios';
import {useEffect, useState, useRef} from 'react';
import {Link, useSearchParams} from "react-router-dom";
import {Task} from "./Task";
import {Placeholder} from "./Placeholder";
import {MessageCard} from "./MessageCard";

export function TaskIndex() {
    const [tasks, setTasks] = useState([]);
    const [filters, setFilters] = useState([]);
    const [loading, setLoading] = useState(true);
    const searchRef = useRef(null);

    let [searchParams, setSearchParams] = useSearchParams();
    let spanParam = searchParams.get('span');

    useEffect(() => {
        axios.get('api/task' + location.search)
            .then(response => {
                setLoading(false);
                setTasks(response.data);
            });
    }, [tasks]);

    function handleSearch(e) {
        setFilters(tasks.filter((task) => {
            return Object.keys(task).map((key) => {
                let value = task[key].toString();
                return value.includes(e.target.value);
            }).includes(true);
        }))
    }

    let btnClass = "btn btn-outline-secondary";

    return (
        <>
            <div className="row mb-4 justify-content-center">
                <div className="col-md-8 col-sm-12">
                    <div className="d-flex align-items-center">
                        <div className="btn-group">
                            <Link className={btnClass + ((spanParam === '1' || spanParam === null) ? ' active' : '')}
                                  to={location.pathname}>This week</Link>
                            <Link className={btnClass + ((spanParam === '2') ? ' active' : '')}
                                  to={{search: 'span=2'}}>Two weeks span</Link>
                            <Link className={btnClass + ((spanParam === '3') ? ' active' : '')}
                                  to={{search: 'span=3'}}>All upcoming tasks</Link>
                        </div>
                        <input className="form-control w-auto ms-auto" type="search" placeholder="Search"
                               aria-label="Search" onChange={handleSearch} ref={searchRef}/>
                    </div>
                </div>
            </div>

            <div className="row justify-content-center">
                <div className="col-md-8 col-sm-12">
                    <div className="card overflow-hidden shadow">
                        <div className="card-header">
                            <div className="d-flex align-items-center">
                                <span>{`Upcoming tasks`}</span>
                                <Link className="ms-auto btn-sm text-decoration-none link-secondary"
                                      to={`create`} title="Click here to create a new task">
                                    <i className="bi bi-plus-circle"/>
                                </Link>
                            </div>
                        </div>

                        <div className="card-body p-0">
                            {
                                loading ?
                                    <Placeholder/> :
                                    tasks.length ?
                                        searchRef.current.value ?
                                            filters.length ?
                                                filters.map(task => {
                                                    return <Task {...task} key={task.id}/>;
                                                }) :
                                                <MessageCard
                                                    message={`No search results found for \"${searchRef.current.value}\".`}/> :
                                            tasks.map(task => {
                                                return <Task {...task} key={task.id}/>;
                                            }) :
                                        <MessageCard message='No tasks yet.' action='Create one?' link='create'/>
                            }
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
