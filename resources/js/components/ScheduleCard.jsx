import {Link} from "react-router-dom";
import {Schedule} from "./Schedule";
import {useState, useEffect} from 'react';

export function ScheduleCard(props) {
    const [schedule, setSchedule] = useState({props});

    useEffect(() => {
        setSchedule(props);
    }, [props]);

    return schedule ? (
        <div className="card shadow h-100">
            <div className="card-header">
                <div className="d-flex align-items-center">
                    <div className="">{ 'Your schedule' }</div>

                    <Link className="ms-auto btn-sm text-decoration-none link-secondary"
                          to={`schedule/${schedule.id}/edit`}
                          title="Click here to edit this schedule">
                        <i className="bi bi-pencil-square"/>
                    </Link>
                </div>
            </div>

            <div className="card-body p-0">
                <Schedule {...schedule} />
            </div>
        </div>
    ) : null;
}
