import React, { useEffect, useState } from 'react';
import {
  TextField,
  Typography,
  Container,
  Box,
  Alert,
  Button,
  Select,
  FormControl,
  MenuItem,
} from '@mui/material';
import PartCategorySelect from '../PartCategorySelect/PartCategorySelect';
import { useSelector } from 'react-redux';

const PartForm = ({ selectedCarId, part, onSave }) => {
  const cars = useSelector(state => state.cars.carList);
  console.log(selectedCarId);
  const [name, setName] = React.useState('');
  const [categoryId, setCategoryId] = React.useState('');
  const [serviceId, setServiceId] = React.useState('');
  const [partNumber, setPartNumber] = React.useState('');
  const [originalPartNumber, setOriginalPartNumber] = React.useState('');
  const [description, setDescription] = React.useState('');
  const [unitPrice, setUnitPrice] = React.useState(0);
  const [quantity, setQuantity] = React.useState(0);
  const [error, setError] = useState(null);
  const [carId, setCarId] = useState(null);

  useEffect(() => {
    if (part) {
      setName(part.name);
      setCategoryId(part.categoryId);
      setServiceId(part.serviceId);
      setPartNumber(part.partNumber);
      setUnitPrice(part.unitPrice);
      setQuantity(part.quantity);
    }
    if (selectedCarId) {
      setCarId(selectedCarId);
    }
  }, [part]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);

    if (!name || !unitPrice || !quantity) {
      setError('All fields are required');
      return;
    }

    const newPart = {
      category_id: categoryId,
      service_id: serviceId,
      car_id: carId,
      name,
      part_number: partNumber,
      original_part_number: originalPartNumber,
      quantity,
      unit_price: unitPrice,
      currency: 'EUR',
      description,
    };

    try {
      await onSave(newPart);
    } catch (err) {
      setError(err.message || 'Falied to save part');
    }
  };

  const handleCarChange = (event) => {
    setCarId(event.target.value);
  };

  const handleCategoryChange = (event) => {
    setCategoryId(event.target.value);
  };

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

        <FormControl fullWidth>
          <Select
            disabled={!!selectedCarId}
            labelId="select-label"
            value={carId}
            onChange={handleCarChange}
            required
          >
            {
              cars.map(car => (<MenuItem key={car.id} value={car.id}>{car.name}</MenuItem>))
            }
          </Select>
        </FormControl>

        <PartCategorySelect selectedCategory={categoryId} onChangeHandler={handleCategoryChange} />

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
          label="Part number"
          variant="outlined"
          fullWidth
          margin="normal"
          value={partNumber}
          onChange={(e) => setPartNumber(e.target.value)}
          required
        />

        <TextField
          label="Original part number"
          variant="outlined"
          fullWidth
          margin="normal"
          value={originalPartNumber}
          onChange={(e) => setOriginalPartNumber(e.target.value)}
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
          type="number"
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

        <TextField
          label="Description"
          variant="outlined"
          fullWidth
          margin="normal"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          required
        />

        <Button type="submit" variant="contained" color="primary" sx={{ mt: 2 }}>
          Save Part
        </Button>
      </Box>
    </Container>
  );
};

export default PartForm;