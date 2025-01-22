import React, {useEffect, useState} from 'react';
import {TextField, Typography,  Container, Box, Alert, Button} from "@mui/material";
import PartCategorySelect from "../PartCategorySelect/PartCategorySelect";

const PartForm = ({ part, onSave }) => {

    const [name, setName] = React.useState('');
    const [categoryId, setCategoryId] = React.useState('');
    const [serviceId, setServiceId] = React.useState('');
    const [partNumber, setPartNumber] = React.useState('');
    const [unitPrice, setUnitPrice] = React.useState(0);
    const [quantity, setQuantity] = React.useState(0);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (part){
            setName(part.name);
            setCategoryId(part.categoryId);
            setServiceId(part.serviceId);
            setPartNumber(part.partNumber);
            setUnitPrice(part.unitPrice);
            setQuantity(part.quantity);
        }
    }, [part])

    const handleSubmit = async(e) => {
        e.preventDefault();
        setError(null);

        if (!name || !unitPrice || !quantity){
            setError('All fields are required');
            return;
        }

        const newPart = {
            name,
            categoryId,
            serviceId,
            partNumber,
            unitPrice,
            quantity
        }

        try {
            await onSave(newPart);
        } catch (err) {
            setError(err.message || 'Falied to save part')
        }
    }

    return (
        <Container maxWidth="sm">
            <Box component="form" onSubmit={handleSubmit} sx={{
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                mt: 4,
                p: 3,
                boxShadow: 3,
                borderRadius: 2,
                backgroundColor: 'white',
            }}>
                <Typography variant={'h4'} component={'h1'} gutterBottom>
                    {part ? 'Edit Part' : 'Add Part'}
                </Typography>

                {error && <Alert severity="error">{error}</Alert>}

                <TextField
                    label="Part Name"
                    variant="outlined"
                    fullWidth
                    margin="normal"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    required
                />

                <TextField
                    label="Unit price"
                    variant="outlined"
                    fullWidth
                    margin="normal"
                    value={unitPrice}
                    onChange={(e) => setUnitPrice(e.target.value)}
                    required
                />

                <TextField
                    label="Quantity"
                    variant="outlined"
                    fullWidth
                    margin="normal"
                    type="number"
                    value={quantity}
                    onChange={(e) => setQuantity(e.target.value)}
                    required
                />

                <PartCategorySelect value={categoryId} onChange={(e) => setCategoryId(e.target.value)}/>
                <Button type="submit" variant="contained" color="primary" sx={{ mt: 2 }}>
                    Save Part
                </Button>
            </Box>
        </Container>
    )
}

export default PartForm;