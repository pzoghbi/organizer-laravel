import {useEffect, useState} from 'react';
import {ScheduleListItem} from "./ScheduleListItem";
import {Link} from "react-router-dom";

export function ScheduleList() {
    const [schedules, setSchedules] = useState([]);

    useEffect(() => {
       fetch('api/schedule')
           .then(response => response.json())
           .then(data => setSchedules(data));
    }, [schedules]);

    return (
        <>
            <div className="d-flex mb-3">
                <h1 className="h1 mb-0">Your schedules</h1>
                <Link to="/schedule/create" className="ms-auto btn btn-success h-100 text-white align-self-center">
                    New schedule
                </Link>
            </div>
            {schedules.map(schedule => {
                return (<ScheduleListItem {...schedule} key={schedule.id}/>);
            })}
        </>
    );
}

