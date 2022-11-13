import {useState, useEffect} from 'react';
import {Link} from "react-router-dom";

export function Task(props) {
    const [task, setTask] = useState({...props});

    useEffect(() => {
        setTask(props);
    }, [props]);

    return task ? (
        <Link className="p-3 btn btn-outline-light text-start border-0 rounded-0 border-bottom d-block text-reset"
              to={`/tasks/${task.id}/show`}>
            <div className="card-title">
                <div className="d-flex align-items-center justify-content-between">
                    <h5 className="mb-0">{ task.title }</h5>
                    <span className="small text-primary">{ task.subject.name }</span>
                </div>
            </div>

            <p className="card-text mb-2">{ task.details }</p>

            <div className="d-flex justify-content-between text-muted">
                <span className="small badge bg-opacity-75 bg-info align-self-center">{ task.type }</span>
                <span className={`small ${task.due ? 'text-danger': ''}`}>
                    { task.datetime }
                </span>
            </div>
        </Link>
    ) : null;
}
