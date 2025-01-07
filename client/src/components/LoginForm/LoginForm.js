import React, { useState } from 'react';
import {useDispatch} from "react-redux";
import { useNavigate } from 'react-router-dom';
import {login} from "../../feature/auth/authSlice";

const LoginForm = () => {
    const dispatch = useDispatch();

    const [email, setEmail] = useState('bmw-owner@admin.com');
    const [password, setPassword] = useState('bmw-owner');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();

        // Send login request to your API
        const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ email, password }),
        });
        const data = await response.json();

        if (response.ok) {
            dispatch(login({user: data.user, token: data.token}))
            navigate('/cars');
        } else {
            alert(data.message || 'Login failed');
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <h2>Login</h2>
            <div>
                <label>Email:</label>
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
            </div>
            <div>
                <label>Password:</label>
                <input
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
            </div>
            <button type="submit">Login</button>
        </form>
    );
};

export default LoginForm;
