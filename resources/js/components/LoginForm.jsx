import axios from "axios";
import {useRef} from 'react';
import {useNavigate} from 'react-router-dom';

export function LoginForm() {
    let formRef = useRef(null);
    let navigate = useNavigate();

    async function handleSubmitLogin(e) {
        e.preventDefault();

        axios.post('/api/auth/login', new FormData(formRef.current))
            .then(response => {
                if (response.status === 200) {
                    navigate("/");
                }
            })
    }

    return (
        <>
            <div className="row mb-4 justify-content-center">
                <div className="col-md-8 col-sm-12">
                    <div className="align-items-center">
                        <div className="card shadow h-100">
                            <div className="card-header">
                                <div className="d-flex align-items-center">
                                    <div className="">User Login</div>
                                </div>
                            </div>

                            <div className="card-body">
                                <form ref={formRef} onSubmit={handleSubmitLogin}>
                                    <div className="form-group mb-3">
                                        <label htmlFor="login-email">Email</label>
                                        <input id="login-email" name="email" type="email" required className="form-control"/>
                                    </div>

                                    <div className="form-group mb-3">
                                        <label htmlFor="login-password">Password</label>
                                        <input id="login-password" name="password" type="password" required className="form-control"/>
                                    </div>

                                    <button className="btn btn-primary text-white" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
