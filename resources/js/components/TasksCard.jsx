import {Link} from "react-router-dom";
import {useState, useEffect} from 'react';
import {Task} from "./Task";

export function TasksCard(props) {
    const [tasks, setTasks] = useState([]);

    useEffect(() => {
        setTasks(props.tasks);
        return () => { setTasks([]); }
    }, [props.tasks]);

    return (
        <div className="card shadow overflow-hidden h-100">
            <div className="card-header">
                <div className="d-flex align-items-center">
                    {'Upcoming tasks'}
                    <Link className="ms-auto btn-sm text-decoration-none link-secondary"
                          to="/tasks/create" title="Click here to create a new task">
                        <i className="bi bi-plus-circle" />
                    </Link>
                </div>
            </div>
            { tasks && (
            <div className="card-body p-0">
                { tasks.map((task) => {
                    return <Task {...task} key={task.id} />
                })}
            </div>
            )}
        </div>
    );
}
