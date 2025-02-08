import React from 'react';
import { Link } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { Box, Typography, Button } from '@mui/material';
import Grid from '@mui/material/Grid2';

const CarView = ({ carId }) => {
  const carList = useSelector(state => state.cars.carList);
  const car = carList.find(car => car.id === carId);

  if (!car) {
    return <p>Car not found.</p>;
  }

  const carProduced = new Date(car.producedAt);
  const year = carProduced.getFullYear();

  return (
    <>
      <Box sx={{
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'left',
        p: 3,
        margin: '20px',
        boxShadow: 3,
        borderRadius: 2,
        backgroundColor: 'white',
      }}>
        <Typography variant="h4">{car.name}</Typography>
        <p>{car.brand} <i>{car.model}</i></p>
        <p>color: {car.color}</p>
        <p>registrationNumber: {car.registrationNumber}</p>
        <p>vin: {car.vin}</p>
        <p>produced: {year}</p>

        <Grid container spacing={2}>
          <Grid xs={12}>
            <Link to={`/cars/${carId}/parts/add`}>
              <Button variant="contained" color="primary">Add part</Button>
            </Link>
          </Grid>
          <Grid>
            <Link to={`/cars/${carId}/services/add`}>
              <Button variant="contained" color="primary">Add service</Button>
            </Link>
          </Grid>
        </Grid>
      </Box>
    </>
  );
};

export default CarView;