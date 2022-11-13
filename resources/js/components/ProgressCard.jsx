import {Link} from "react-router-dom";

export function ProgressCard() {
    return (
        <div className="card shadow overflow-hidden h-100">
            <div className="card-header">
                <div className="d-flex align-items-center">
                    <span>{'Your progress'}</span>
                    <Link className="ms-auto btn-sm text-decoration-none link-secondary"
                          to="material/create" title="Click here to create a new task">
                        <i className="bi bi-plus-circle"/>
                    </Link>
                </div>
            </div>

            <div className="card-body p-0">
            </div>
        </div>
    );
}
