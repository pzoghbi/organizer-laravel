import {useState, useEffect} from 'react';
import {Link} from "react-router-dom";
import {Category} from "./Category";

export function Material(props) {
    const [material, setMaterial] = useState({...props});

    useEffect(() => {
        setMaterial(props);
    }, [props]);

    return material ? (
        <Link className="p-3 btn btn-outline-light text-start border-0 rounded-0 border-bottom d-block text-reset"
              to={`material/${material.id}/show`}>
            <div className="card-title">
                <div className="d-flex align-items-center justify-content-between">
                    <h5 className="mb-0">{ material.name}</h5>
                    <span className="small text-primary">{ material.subject.name }</span>
                </div>
            </div>

            <p className="card-text mb-2">{ material.details }</p>

            <div className="d-flex justify-content-between text-muted">
                <div className="d-flex gap-3">
                    { material.categories.map(category => {
                        return <Category {...category} key={category.id}/>
                    })}
                </div>
                <span className="small">{ material.visited_at }</span>
            </div>
        </Link>
    ) : null;
}
