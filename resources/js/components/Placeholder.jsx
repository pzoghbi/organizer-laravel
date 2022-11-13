import {Link} from "react-router-dom";

export function Placeholder() {
    return (
        <div className="p-3 border-0 rounded-0 border-bottom d-block">
            <div className="card-title">
                <div className="d-flex align-items-center justify-content-between placeholder-glow">
                    <span className="mb-0 placeholder w-25"/>
                    <span className="placeholder w-25" />
                </div>
            </div>

            <div className="placeholder-glow">
                <span className="card-text mb-2 placeholder-glow placeholder col-6"/>
            </div>

            <div className="d-flex justify-content-between placeholder-glow">
                <span className="placeholder col-2" />
                <span className="placeholder col-2" />
            </div>
        </div>
    );
}
