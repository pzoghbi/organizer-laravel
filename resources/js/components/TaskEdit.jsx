import axios from "axios";
import {useState, useEffect, useRef} from 'react';
import {useNavigate, useParams} from 'react-router-dom';

export function TaskEdit() {
    /* Hooks */
    const [task, setTask] = useState({});
    const navigate = useNavigate();
    const formRef = useRef(null);
    const params = useParams();
    const [subjects, setSubjects] = useState([]);

    let source = axios.CancelToken.source();

    /* Get subjects */
    useEffect(() => {
        axios.get('/api/subject', {
            cancelToken: source.token
        }).then(response => setSubjects(response.data));
        return () => source.cancel();
    }, []);

    /* Get task */
    useEffect(() => {
        axios.get(`/api/task/${params.taskId}`)
            .then(response => setTask(response.data));
        return () => source.cancel();
    }, []);

    /* Patch request */
    async function handleSubmit(e) {
        e.preventDefault();
        const task = {};
        (new FormData(formRef.current)).forEach(function(value, key){
            task[key] = value;
        });
        axios.put(`/api/task/${params.taskId}`, task);
        navigate(`/tasks/${params.taskId}/show`);
    }

    // Parse date
    const parseDate = () => {
        return task.datetime.replace(' ', 'T');
    };

    function handleChange(e) {
        e.target.checked = true;
    }

    return !task.id ? null : (
        <div className="row justify-content-center">
            <div className="col-lg-8 col-sm-12">
                <div className="card shadow">
                    <div className="card-header">
                        {`Update task: ${task?.title}`}
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
                                    defaultValue={task?.title}
                                    required/>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="task-details">Details</label>
                                <textarea
                                    cols="30"
                                    id="task-details"
                                    className="form-control"
                                    name="details"
                                    rows="10"
                                    defaultValue={task?.details}/>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="task-type">Type</label>
                                <div className="form-group d-flex gap-3" role="group">
                                    <input type="radio"
                                           className="btn-check"
                                           name="type"
                                           id="type-assignment"
                                           value="assignment"
                                           autoComplete="off"
                                           required
                                           defaultChecked={task.type === 'assignment'}
                                           onChange={handleChange}/>

                                    <label className="btn btn-outline-secondary"
                                           htmlFor="type-assignment">Assignment</label>

                                    <input type="radio"
                                           className="btn-check"
                                           name="type"
                                           id="type-exam"
                                           value="exam"
                                           autoComplete="off"
                                           defaultChecked={task.type === 'exam'}
                                           onChange={handleChange}/>

                                    <label className="btn btn-outline-secondary" htmlFor="type-exam">Exam</label>

                                    <input type="radio"
                                           className="btn-check"
                                           name="type"
                                           id="type-reminder"
                                           value="reminder"
                                           autoComplete="off"
                                           defaultChecked={task.type === 'reminder'}
                                           onChange={handleChange}/>

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
                                        defaultValue={task.subject_id}>
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
                                    className="ms-auto btn-primary btn text-white"
                                    value={`Update`}/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
