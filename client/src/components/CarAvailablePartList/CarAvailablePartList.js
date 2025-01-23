import React, {useEffect, useState} from 'react';
import {Box, Button, List, ListItem, ListItemText, Typography} from "@mui/material";
import api from "../../utils/api";

const CarAvailablePartList = ({carId}) =>
{
    const [parts, setParts] = useState([]);

    useEffect(() => {
        api.get(`/api/parts/?car_id=${carId}&limit=3`)
            .then((data) => setParts(data))
            .catch(err => console.error(err));
    }, []);

    const partPresentation = (part) => {
        return `${part.partNumber} (oem: ${part.originalPartNumber})`;
    }

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
            <Typography variant="h4">Available Parts</Typography>
            <List>
                {parts.map(part => (
                    <ListItem key={part.id}>
                        <ListItemText primary={part.name} secondary={partPresentation(part)} />
                    </ListItem>
                ))}
            </List>
            <Button>Show all</Button>
        </Box>
    );
}

export default CarAvailablePartList;