export function ScheduleListItem(props) {
    return (
        <div className="mb-3 d-flex shadow p-3 rounded-3">
            <div className="d-inline-block align-self-center">
                <span className="fw-bold me-3">{props.name}</span>
                <span>{props.start} - {props.end}</span>
            </div>

            <div className="ms-auto d-inline-block">
                <a href="" className="btn btn-warning shadow-sm">Edit</a>
                <form action="" method="post" className="d-inline">
                    <input type="submit" value="Delete" className="btn btn-danger text-white shadow-sm"/>
                </form>
                <form action="" method="post" className="d-inline">
                    <input type="submit" value="Toggle" className="btn text-white btn-primary"/>
                </form>
            </div>
        </div>
    );
}
