import {Link} from "react-router-dom";

export function MessageCard(props) {
    const link = props.link || '';
    const message = props.message || '';
    const action = props.action || '';

    return (
        <div className="p-3 border-0 rounded-0 border-bottom d-block">
            <div className="card-text">
                <div className="d-flex align-items-center gap-2">
                    <span>{message}</span>
                    <Link to={link}>{action}</Link>
                </div>
            </div>
        </div>
    );
}
