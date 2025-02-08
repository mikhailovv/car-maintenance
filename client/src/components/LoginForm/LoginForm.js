import React, { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { Navigate, useNavigate } from 'react-router-dom';
import { login } from '../../feature/auth/authSlice';
import { TextField, Button, Box, Typography, Container } from '@mui/material';
import api from '../../utils/api';

const LoginForm = () => {
  const dispatch = useDispatch();
  const isAuthenticated = useSelector((state) => state.auth.isAuthenticated);
  const navigate = useNavigate();

  const [email, setEmail] = useState('bmw-owner@admin.com');
  const [password, setPassword] = useState('bmw-owner');
  const [error, setError] = useState(null);

  // If already logged in, redirect to Dashboard automatically
  if (isAuthenticated) {
    return <Navigate to="/cars" replace />;
  }

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const data = await api.postWithoutToken('/api/login', { body: JSON.stringify({ email, password }) });
      // Dispatch login action and navigate
      await dispatch(login({ user: data.user, token: data.token }));

      navigate('/cars');
    } catch (err) {
      console.error('Login error:', err);
      setError('An unexpected error occurred. Please try again.');
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
        {error && (
          <Typography color="error" sx={{ mt: 2 }}>
            {error}
          </Typography>
        )}
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
        <Button type="submit" variant="contained" color="primary" fullWidth sx={{ mt: 2 }}>Login</Button>
      </Box>
    </Container>
  );
};

export default LoginForm;
