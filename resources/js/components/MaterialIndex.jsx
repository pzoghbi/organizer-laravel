import axios from 'axios';
import {Link} from "react-router-dom";
import {Material} from "./Material";
import {useState, useEffect} from 'react';
import {MaterialGroups} from "./MaterialGroups";
import {Placeholder} from "./Placeholder";
import {MaterialsCard} from "./MaterialsCard";

export function MaterialIndex() {

    const [materials, setMaterials] = useState([]);
    const [subjects, setSubjects] = useState([]);
    let source = axios.CancelToken.source();

    useEffect(() => {
        axios.get('api/material', {
            cancelToken: source.token
        })
            .then(response => {
                setMaterials(response.data.recentMaterials);
                setSubjects(response.data.subjects);
            });
        return () => { source.cancel(); }
    }, [materials, subjects]);

    return (
        <>
            <div className="row justify-content-center mb-3">
                <div className="col-md-8 col-sm-12">
                    <MaterialGroups subjects={subjects}/>
                </div>
            </div>

            <div className="row justify-content-center">
                <div className="col-md-8 col-sm-12">
                    <MaterialsCard materials={materials}/>
                </div>
            </div>
        </>
    );
}
