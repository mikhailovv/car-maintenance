import React, { useState, useEffect } from 'react';
import {
  TextField,
  Button,
  Box,
  Typography,
  Container,
  Alert,
} from '@mui/material';
import PartList from '../PartList/PartList';
import { useParams } from 'react-router-dom';

const ServiceForm = ({ service, onSave }) => {
  const { id } = useParams();
  const [name, setName] = useState('');
  const [unitPrice, setUnitPrice] = useState('');
  const [quantity, setQuantity] = useState('');
  const [mileage, setMileage] = useState('');
  const [shop, setShop] = useState('');
  const [error, setError] = useState(null);

  const [selectedParts, setSelectedParts] = useState([]);

  // Populate form fields when editing an existing service
  useEffect(() => {
    if (service) {
      setName(service.name || '');
      setUnitPrice(service.unit_price || '');
      setQuantity(service.quantity || '');
    }
  }, [service]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);

    // Validate inputs
    if (!name || !unitPrice || !quantity) {
      setError('All fields are required.');
      return;
    }

    const newService = {
      name,
      quantity,
      unit_price: parseFloat(unitPrice),
      parts: selectedParts.map((part) => part.id),
      currency: 'EUR',
      car_id: id,
      mileage,
      shop,
    };

    try {
      // Call onSave prop to handle saving logic (e.g., API call)
      await onSave(newService);
    } catch (err) {
      setError(err.message || 'Failed to save service.');
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
        <Typography variant="h4" component="h1" gutterBottom>
          {service ? 'Edit Service' : 'Add Service'}
        </Typography>

        {error && <Alert severity="error">{error}</Alert>}

        <TextField
          label="Service Name"
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
          type="number"
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
        <TextField
          label="Mileage"
          variant="outlined"
          fullWidth
          margin="normal"
          type="number"
          value={mileage}
          onChange={(e) => setMileage(e.target.value)}
          required
        />
        <TextField
          label="Shop"
          variant="outlined"
          fullWidth
          margin="normal"
          type="string"
          value={shop}
          onChange={(e) => setShop(e.target.value)}
          required
        />

        <PartList carId={id} parts={selectedParts} setParts={setSelectedParts} />

        <Button
          type="submit"
          variant="contained"
          color="primary"
          fullWidth
          sx={{ mt: 2 }}
        >
          {service ? 'Save Changes' : 'Add Service'}
        </Button>
      </Box>
    </Container>
  );
};

export default ServiceForm;