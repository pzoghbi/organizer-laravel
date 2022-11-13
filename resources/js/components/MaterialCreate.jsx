import axios from 'axios';
import csrf from "../csrf";
import {useState, useEffect} from 'react';
import {useNavigate} from "react-router-dom";


export function MaterialCreate() {
    let navigate = useNavigate();
    const [subjects, setSubjects] = useState([]);
    const [material, setMaterial] = useState(new FormData());

    useEffect(() => {
        axios.get('/api/subject')
            .then(response => setSubjects(response.data));
    }, [subjects]);

    function handleChange(e) {
        const target = e.target;
        const value = target.value;
        const name = target.name;

        material.append(name, value);
        setMaterial(material);
    }

    function handleFile(e) {
        const file = e.target.files[0];
        material.append(e.target.name, file);
        setMaterial(material);
    }

    async function handleSubmit(e) {
        e.preventDefault();
        axios.post('/api/material', material);
        navigate('/materials');
    }

    return (
        <div className="row justify-content-center">
            <div className="col-lg-8 col-sm-12">
                <div className="card shadow">
                    <div className="card-header">
                        {`Create a new material`}
                    </div>

                    <div className="card-body">
                        <form onSubmit={handleSubmit}>
                            <div className="form-group mb-3">
                                <input
                                    type="file"
                                    name="file"
                                    id="material-file"
                                    className="form-control"
                                    required
                                    onChange={handleFile}/>
                            </div>

                            <div className="input-group mb-3">
                                <label className="input-group-text" htmlFor="material-details">Notes</label>
                                <textarea
                                    cols="30"
                                    id="material-details"
                                    className="form-control"
                                    name="details"
                                    rows="12"
                                    onChange={handleChange}/>
                            </div>

                            <div className="form-group mb-3">
                                <label htmlFor="material-subject">Subject</label>
                                <select name="subject_id"
                                        id="material-subject"
                                        className="form-select mb-3"
                                        required
                                        defaultValue="Choose a type"
                                        onChange={handleChange}>
                                    <option defaultValue disabled>Choose a type</option>
                                    {subjects.map(subject => {
                                        return <option value={subject.id} key={subject.id}>{subject.name}</option>;
                                    })}
                                </select>
                            </div>

                            {/*<div className="form-group mb-3">*/}
                            {/*    <label htmlFor="task-datetime">Date and Time</label>*/}
                            {/*    <input className="form-control" id="task-datetime"*/}
                            {/*           min={new Date()}*/}
                            {/*           defaultValue={new Date()}*/}
                            {/*           name="datetime"*/}
                            {/*           type="datetime-local"*/}
                            {/*           onChange={handleChange}/>*/}
                            {/*</div>*/}

                            <div className="form-group d-flex">
                                <input
                                    type="submit"
                                    className="ms-auto btn-danger btn text-white"
                                    value={`Create`}
                                    onChange={handleChange}/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
