import axios from 'axios';
import {useState, useEffect} from 'react';
import {ScheduleCard} from "./ScheduleCard";
import {TasksCard} from "./TasksCard";
import {MaterialsCard} from "./MaterialsCard";
import {ProgressCard} from "./ProgressCard";

export function Home() {
    const [dashboard, setDashboard] = useState({});

    useEffect(() => {
        axios.get('/api/dashboard')
            .then(res => setDashboard(res.data));
    }, []);

    return (
        <>
            <h1 className="h3 text-secondary mb-3 text-light">Overview</h1>
            <div className="row mb-4">
                <div className="col-lg-8 col-md-12 mb-lg-0 mb-4">
                    <ScheduleCard {...dashboard.schedule} />
                </div>

                <div className="col-lg-4 col-md-12">
                    <TasksCard tasks={dashboard.tasks} />
                </div>
            </div>

            <div className="row mb-4">
                <div className="col-lg-4 col-md-12 mb-lg-0 mb-4">
                    <MaterialsCard materials={dashboard.materials} />
                </div>

                <div className="col-lg-8 col-md-12">
                    <ProgressCard />
                </div>
            </div>
        </>
    );
}
