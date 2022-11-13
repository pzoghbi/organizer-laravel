import {useState, useEffect} from 'react';
import {useParams} from "react-router-dom";
import axios from "axios";
import {Placeholder} from "./Placeholder";
import {Category} from "./Category";

export function MaterialShow() {
    let urlParams = useParams();
    const [material, setMaterial] = useState({});

    useEffect(() => {
        axios.get(`/api/material/${urlParams.materialId}`)
            .then(response => setMaterial(response.data));
    }, []);

    return (
        <div className="row justify-content-center">
            <div className="col-lg-8 col-sm-12">
                <div className="card shadow">
                    <div className="card-header">
                        {material.name}
                    </div>

                    <div className="card-body">
                        <img className="card-img w-100 mb-3" src={`/storage/${material.path}`}
                             style={{height: '10rem', objectFit: 'cover'}} alt="File Preview"/>
                        <div className="card-text">{material.details}</div>
                    </div>

                    {
                        material.categories?.map?.(category => {
                            return <Category {...category} key={category.id} />
                        })
                    }
                </div>
            </div>
        </div>
    );
}
