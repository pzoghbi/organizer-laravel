import {useState, useEffect} from 'react';
// todo inline style
export function Category(props) {
    const [category, setCategory] = useState({...props});

    useEffect(() => {
        setCategory(props);
    }, [props]);

    return category ? (
        <span className="badge bg-light text-opacity-50 text-secondary">{ category.name }</span>
    ) : null;
}
