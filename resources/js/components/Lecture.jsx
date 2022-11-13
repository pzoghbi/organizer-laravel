import {useState, useEffect} from 'react';
import {Link} from "react-router-dom";

/* props: lecture */
export function Lecture(props) {
    const [lecture, setLecture] = useState({...props});

    useEffect(() => {
        setLecture(props);
    }, [props]);

    let lectureClass = "p-2 gap-1 h-100 w-100 d-block text-decoration-none rounded-0 border-0 text-start text-dark btn btn-outline-light";
    return (
        <tr key={lecture.id}>
            <td className="p-0">
                <Link className={ lectureClass } to={`lecture/${ lecture.id }/edit`}>
                    <div className="d-flex">
                        <strong>{ lecture.subject.name }</strong>
                        <strong className="ms-auto" title="Room">{ lecture.room }</strong>
                    </div>
                    <span>{`${lecture.start} - ${lecture.end}`}</span>
                </Link>
            </td>
        </tr>
    );
}
