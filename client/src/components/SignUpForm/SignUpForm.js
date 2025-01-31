import React, { useState } from 'react';
import { TextField, Button, Typography, Container, Box, Grid, Alert } from '@mui/material';
import api from "../../utils/api";
import {useNavigate} from "react-router-dom";

const SignUpForm = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
    });

    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(null);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setError(null);
        setSuccess(null);

        const { name, email, password, confirmPassword } = formData;

        if (!name || !email || !password || !confirmPassword) {
            setError('All fields are required');
            return;
        }

        if (password !== confirmPassword) {
            setError('Passwords do not match');
            return;
        }

        const newUser = {name, password, email};

        api.postWithoutToken('/api/signup', {body: JSON.stringify(newUser)})
            .then(() => navigate(`/login`))

        console.log('Sign-up data:', formData);
    };

    return (
        <Container maxWidth="sm">
            <Box
                sx={{
                    mt: 4,
                    p: 4,
                    boxShadow: 3,
                    borderRadius: 2,
                    backgroundColor: 'white',
                    textAlign: 'center'
                }}
            >
                <Typography variant="h4" component="h1" gutterBottom>
                    Sign Up
                </Typography>

                {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
                {success && <Alert severity="success" sx={{ mb: 2 }}>{success}</Alert>}
                {!success &&
                <form onSubmit={handleSubmit}>
                    <Grid container spacing={2}>
                        <Grid item xs={12}>
                            <TextField
                                label="Full Name"
                                name="name"
                                variant="outlined"
                                fullWidth
                                value={formData.name}
                                onChange={handleChange}
                                required
                            />
                        </Grid>
                        <Grid item xs={12}>
                            <TextField
                                label="Email"
                                name="email"
                                type="email"
                                variant="outlined"
                                fullWidth
                                value={formData.email}
                                onChange={handleChange}
                                required
                            />
                        </Grid>
                        <Grid item xs={12}>
                            <TextField
                                label="Password"
                                name="password"
                                type="password"
                                variant="outlined"
                                fullWidth
                                value={formData.password}
                                onChange={handleChange}
                                required
                            />
                        </Grid>
                        <Grid item xs={12}>
                            <TextField
                                label="Confirm Password"
                                name="confirmPassword"
                                type="password"
                                variant="outlined"
                                fullWidth
                                value={formData.confirmPassword}
                                onChange={handleChange}
                                required
                            />
                        </Grid>
                    </Grid>

                    <Button
                        type="submit"
                        variant="contained"
                        color="primary"
                        fullWidth
                        sx={{ mt: 3 }}
                    >
                        Sign Up
                    </Button>
                </form>
                }
            </Box>
        </Container>
    );
};

export default SignUpForm;
