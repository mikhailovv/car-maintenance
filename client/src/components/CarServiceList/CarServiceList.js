import React, {useEffect, useState} from 'react';
import {Box, Button, List, ListItem, ListItemText, Typography} from "@mui/material";
import api from "../../utils/api";

const CarServiceList = ({carId}) => {
    const [services, setServices] = useState([]);

    useEffect(() => {
        api.get(`/api/services/?car_id=${carId}`)
            .then((data) => setServices(data));
    }, []);

    return (
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
            <Typography variant="h4">Service History</Typography>
            <List>
                {services.map(service => (
                    <ListItem key={service.id}>
                        <ListItemText primary={service.name} secondary={service.mileage} />
                    </ListItem>
                ))}
            </List>
            <Button>Show all</Button>
        </Box>
    )
}

export default CarServiceList;