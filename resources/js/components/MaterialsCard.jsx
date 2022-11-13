import {useEffect, useState} from 'react';
import {Link} from "react-router-dom";
import {Material} from "./Material";

export function MaterialsCard(props) {
    const [materials, setMaterials] = useState([]);

    useEffect(() => {
        setMaterials(props.materials)
    }, [props.materials]);

    return (
        <div className="card shadow overflow-hidden h-100">
            <div className="card-header">
                <div className="d-flex align-items-center">
                    <span>Recently viewed materials</span>
                    <Link className="ms-auto btn-sm text-decoration-none link-secondary"
                       to={`create`} title="Click here to create a new material">
                        <i className="bi bi-plus-circle"/>
                    </Link>
                </div>
            </div>
            { materials && (
            <div className="card-body p-0">
                { materials.map(material => {
                    return <Material {...material} key={material.id} />;
                })}
            </div>
            )}
        </div>
    );
}
