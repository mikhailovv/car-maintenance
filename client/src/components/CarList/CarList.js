import React, {useEffect} from "react";
import api from '../../utils/api'
import {Link} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {setCarList} from "../../feature/cars/carsSlice";
import {Container, Typography} from "@mui/material";
import Grid from '@mui/material/Grid2';

const CarList = () => {
    const dispatch = useDispatch();
    const cars = useSelector(state => state.cars.carList);

    useEffect(() =>{
        api.get('/api/cars').then(function(data){ console.log(data); dispatch(setCarList(data))}).catch(err => console.error(err));
    }, [dispatch])

    if (!cars || cars.length === 0) {
        return <p>No cars available.</p>;
    }

    return (
        <Container maxWidth="sm">
            <Typography variant="h4">Cars</Typography>
            <Grid container spacing={2}>
                {cars.map(car => (
                    <Grid
                        key={car.id}
                        xs={12}
                        sx={{
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'right',
                            mt: 2,
                            p: 3,
                            boxShadow: 3,
                            borderRadius: 2,
                            backgroundColor: 'white',
                        }}
                    >
                        <Link to={`/cars/${car.id}`}>
                        <Typography variant="h6">{car.name}</Typography>
                        <Typography variant="body1">{car.brand} {car.model} ({new Date(car.producedAt).getFullYear()})</Typography>
                        <br/>
                        </Link>
                    </Grid>
                ))}
            </Grid>
        </Container>
    );
}

export default CarList;