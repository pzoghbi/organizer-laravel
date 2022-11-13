import {useState, useEffect, useRef} from 'react';
import axios from "axios";
import {useNavigate} from "react-router-dom";

export function TaskCreate() {
    let navigate = useNavigate();
    const formRef = useRef(null);
    const [subjects, setSubjects] = useState([]);
    let source = axios.CancelToken.source();

    useEffect(() => {
        axios.get('/api/subject', {
            cancelToken: source.token
        }).then(response => setSubjects(response.data));
        return () => source.cancel();
    }, []);

    async function handleSubmit(e) {
        e.preventDefault();
        const task = new FormData(formRef.current);
        axios.post('/api/task', task);
        navigate('/tasks');
    }

    // Parse date
    const parseDate = () => {
        return new Date().toISOString().split('.')[0].split(':').slice(0, -1).join(':');
    };

    return (
        <div className="row justify-content-center">
            <div className="col-lg-8 col-sm-12">
                <div className="card shadow">
                    <div className="card-header">
                        {`Create a new task`}
                    </div>

                    <div className="card-body">
                        <form onSubmit={handleSubmit} id="taskForm" ref={formRef}>
                            <div className="form-group mb-3">
                                <label htmlFor="task-title">Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="task-title"
                                    className="form-control"
                                    required/>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="task-details">Details</label>
                                <textarea
                                    cols="30"
                                    id="task-details"
                                    className="form-control"
                                    name="details"
                                    rows="10"/>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="task-type">Type</label>
                                <div className="form-group d-flex gap-3" role="group">
                                    <input type="radio" className="btn-check" name="type" id="type-assignment"
                                           value="assignment" autoComplete="off" required/>
                                    <label className="btn btn-outline-secondary"
                                            htmlFor="type-assignment">Assignment</label>

                                    <input type="radio" className="btn-check" name="type" id="type-exam"
                                           value="exam" autoComplete="off"/>
                                    <label className="btn btn-outline-secondary" htmlFor="type-exam">Exam</label>

                                    <input type="radio" className="btn-check" name="type" id="type-reminder"
                                           value="reminder" autoComplete="off"/>
                                    <label className="btn btn-outline-secondary"
                                           htmlFor="type-reminder">Reminder</label>
                                </div>
                            </div>

                            <div className="input-group mb-3">
                                <label className="input-group-text" htmlFor="task-subject">Subject</label>
                                <select name="subject_id"
                                        id="task-subject"
                                        className="form-select"
                                        required
                                        defaultValue="Choose a subject">
                                    <option defaultValue="" disabled>Choose a subject</option>
                                    {subjects && subjects.map(subject => {
                                        return <option value={subject.id} key={subject.id}>{subject.name}</option>;
                                    })}
                                </select>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="task-datetime">Date and Time</label>
                                <input className="form-control" id="task-datetime"
                                       defaultValue={parseDate()}
                                       name="datetime"
                                       type="datetime-local"
                                       required/>
                            </div>

                            <div className="form-group d-flex">
                                <input
                                    type="submit"
                                    className="ms-auto btn-danger btn text-white"
                                    value={`Create`}/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
