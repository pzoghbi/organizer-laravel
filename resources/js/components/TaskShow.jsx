import {Link, useNavigate} from "react-router-dom";
import {useState, useEffect} from 'react';
import {useParams} from 'react-router-dom';
import axios from "axios";

export function TaskShow() {
    const [task, setTask] = useState({});
    let source = axios.CancelToken.source();
    let urlParams = useParams();
    let navigate = useNavigate();

    useEffect(() => {
        axios.get(`/api/task/${urlParams.taskId}`, {
            cancelToken: source.token
        })
            .then(response => setTask(response.data));
        return () => source.cancel();
    }, []);

    async function confirmDelete(e) {
        e.preventDefault();
        axios.delete(`/api/task/${task.id}`);
        navigate('/tasks');
    }

    return !task.id ? null : (
        <>
            <div className="row justify-content-center">
                <div className="col-md-8 col-sm-12">
                    <div className="card overflow-hidden shadow">
                        <div className="card-header">
                            <div className="d-flex align-items-center">
                                <span>{task.title}</span>
                                <div className="ms-auto d-flex">
                                    <Link className="btn-sm text-decoration-none link-secondary"
                                          to="/tasks/create" title="Create a new task">
                                        <i className="bi bi-plus-circle"/>
                                    </Link>
                                    <a className="btn-sm text-decoration-none link-secondary"
                                       data-bs-toggle="modal" href=""
                                       data-bs-target="#deleteModal" title="Delete task">
                                        <i className="bi bi-trash"/>
                                    </a>
                                    <Link className="btn-sm text-decoration-none link-secondary"
                                          to={`/tasks/${task.id}/edit`} title="Edit task">
                                        <i className="bi bi-pencil-square"/>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div className="card-body">
                            <div className="card-text d-flex">
                                <p>{task.details}</p>
                                <div className="ms-auto d-flex gap-1 align-items-baseline">
                                    <span className="badge bg-info">{task.subject.name}</span>
                                    <span className="badge bg-primary">{task.type}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="deleteModal" tabIndex="-1" aria-labelledby="exampleModalCenterTitle"
                 style={{display: 'none'}} aria-hidden="true">
                <div className="modal-dialog modal-dialog-centered">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalCenterTitle">Delete task</h5>
                            <button type="button" className="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"/>
                        </div>
                        <div className="modal-body">
                            <p>This task will be deleted.</p>
                            <small>This action cannot be undone.</small>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" className="btn btn-danger text-white" data-bs-dismiss="modal"
                                    onClick={confirmDelete}>Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
