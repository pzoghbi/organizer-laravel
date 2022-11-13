import {useEffect, useState} from "react";

export function MaterialGroups(props) {
    const [subjects, setSubjects] = useState([]);

    useEffect(() => {
        setSubjects(props.subjects)
    }, [props.subjects]);

    return (
        <>
            {
                subjects.map?.((subjectGroup) => {
                    return (
                        <div className="card">
                            <div className="card-header">{subjectGroup.name}</div>
                        </div>
                    );
                })
            }
        </>
    );
}
