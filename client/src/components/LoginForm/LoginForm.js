import React, { useState } from 'react';
import {useDispatch} from "react-redux";
import { useNavigate } from 'react-router-dom';
import {login} from "../../feature/auth/authSlice";
import {TextField, Button, Box, Typography, Container} from '@mui/material';

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
        let error = null;

        if (response.ok) {
            dispatch(login({user: data.user, token: data.token}))
            navigate('/cars');
        } else {
            error = data.message
            alert(data.message || 'Login failed');
        }
    };

    return (
        <Container maxWidth="sm">
            <Box
                component="form"
                onSubmit={handleSubmit}
                sx={{
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    mt: 4,
                    p: 3,
                    boxShadow: 3,
                    borderRadius: 2,
                    backgroundColor: 'white',
                }}
            >
                <Typography variant="h4">Login</Typography>
                {/*{error && <Alert severity="error">{error}</Alert>}*/}
                <TextField
                    label="Email"
                    variant="outlined"
                    fullWidth
                    type="email"
                    margin="normal"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
                <TextField
                    label="Password"
                    variant="outlined"
                    fullWidth
                    margin="normal"
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
                <Button type="submit" variant="contained" color="primary" fullWidth  sx={{ mt: 2 }}>Login</Button>
            </Box>
        </Container>
    );
};

export default LoginForm;
