import React from "react";
import {Link, useParams} from "react-router-dom";
import { useSelector } from "react-redux";
import {Box, Container, Typography, Button} from "@mui/material";
import Grid from '@mui/material/Grid2';

const CarDetails = () => {
    const {id} = useParams();
    const carList = useSelector(state => state.cars.carList);
    const car = carList.find(car => car.id === id);

    if (!car){
        return <p>Car not found.</p>;
    }

    const carProduced = new Date(car.producedAt);
    const year = carProduced.getFullYear();

    return (
        <Container maxWidth="sm">
            <Box>
                <Typography variant="h2">{car.name}</Typography>
                <p>{car.brand} <i>{car.model}</i></p>
                <p>color: {car.color}</p>
                <p>registrationNumber: {car.registrationNumber}</p>
                <p>vin: {car.vin}</p>
                <p>produced: {year}</p>
            </Box>
            <Grid container spacing={2}>
                <Grid xs={12}>
                    <Link to={`/cars/${id}/parts/add`}>
                        <Button variant="contained" color="primary">Add part</Button>
                    </Link>
                </Grid>
                <Grid>
                    <Link to={`/cars/${id}/services/add`}>
                        <Button variant="contained" color="primary">Add service</Button>
                    </Link>
                </Grid>
            </Grid>
        </Container>
    );
}

export default CarDetails;