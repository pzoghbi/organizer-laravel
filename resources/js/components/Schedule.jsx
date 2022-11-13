import { useState, useEffect } from 'react';
import {Link} from "react-router-dom";
import {Lecture} from "./Lecture";

/* input: schedule object */
export function Schedule(props) {
    const [groupLectures, setGroupLectures] = useState({...props.groupLectures});
    const days = [0, 1, 2, 3, 4, 5];

    useEffect(() => {
        setGroupLectures(props.groupLectures);
    }, [props.groupLectures]);

    let thClass = "bg-info bg-opacity-25 bg-gradient";

    return groupLectures ? (
        <div className="table-responsive">
            <table className="table table-borderless">
                <thead>
                    <tr className="text-center">
                        <th className={ thClass } scope="col">Mon</th>
                        <th className={ thClass } scope="col">Tue</th>
                        <th className={ thClass } scope="col">Wed</th>
                        <th className={ thClass } scope="col">Thu</th>
                        <th className={ thClass } scope="col">Fri</th>
                        <th className={ thClass } scope="col">Sat</th>
                    </tr>
                </thead>
                <tbody className="schedule">
                    <tr>
                        { days.map((x, i) => {
                            return (
                                <td className="p-0" key={i}>
                                    <table className="table table-bordered mb-0">
                                        <tbody>
                                        { Object.keys(groupLectures).map((key) => {
                                            return (parseInt(key) === x) ? groupLectures[key].map(lecture => {
                                                return <Lecture {...lecture} key={lecture.id}/>;
                                            }) : null;
                                        })}
                                        </tbody>
                                    </table>
                                </td>
                            )
                        })}
                    </tr>
                </tbody>
            </table>
        </div>
    ) : '';
}
