import React from 'react';
import { Link } from 'react-router-dom';
import { Box, Container, Typography } from '@mui/material';

const HomePage = () => {
  return (
    <Container sx={{ mt: 2 }}>
      <Box>
        <Typography variant="h4">Home page</Typography>
      </Box>

      <Link to={'/login'}>Login</Link>
    </Container>
  );
};

export default HomePage;