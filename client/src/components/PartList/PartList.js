import React, { useEffect, useState } from 'react';
import { Autocomplete, CircularProgress, Box, Button, List, ListItem, ListItemText, TextField } from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import api from '../../utils/api';


const PartList = ({ carId, parts, setParts }) => {
  const [unusedParts, setUnusedParts] = useState([]);

  const [selectedPart, setSelectedPart] = useState(null);
  const [addToServiceDisable, setAddToServiceDisable] = useState(true);

  useEffect(() => {
    setLoading(true);
    api.get(`/api/parts/?car_id=${carId}`)
      .then((data) => setUnusedParts(data))
      .catch(err => console.error(err))
      .finally(() => setLoading(false));
    // Fetch parts from API
  }, []);

  const [open, setOpen] = React.useState(false);
  const [loading, setLoading] = React.useState(false);

  const handleOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleChange = (event, newValue) => {
    setSelectedPart(newValue || '');
    setAddToServiceDisable(false);
  };

  const handleAddToService = () => {
    const newParts = [...parts, selectedPart];
    setParts(newParts);

    setUnusedParts(unusedParts.filter((part) => part.id !== selectedPart.id));
    setAddToServiceDisable(true);
    setSelectedPart(null);
  };

  const deletePartHandler = (id) => {
    const deletedPart = parts.filter((part) => part.id === id)[0];
    const newParts = parts.filter((part) => part.id !== id);

    setParts(newParts);
    setUnusedParts([...unusedParts, deletedPart]);
  };

  return (
    <>
      <Box sx={{
        display: 'flex',
        gap: 2,
        mt: 2,
        width: '100%',
      }}>
        <Autocomplete
          sx={{ width: '100%' }}
          open={open}
          onOpen={handleOpen}
          onClose={handleClose}
          isOptionEqualToValue={(option, value) => option.id === value.id}
          getOptionLabel={(option) => option.name}
          options={unusedParts}
          onChange={handleChange}
          loading={loading}
          value={selectedPart}
          renderInput={(params) => (
            <TextField
              {...params}
              label="Choose an exist part"
              slotProps={{
                input: {
                  ...params.InputProps,
                  endAdornment: (
                    <React.Fragment>
                      {loading ? <CircularProgress color="inherit" size={20} /> : null}
                      {params.InputProps.endAdornment}
                    </React.Fragment>
                  ),
                },
              }}
            />
          )}
        />
        <Button
          sx={{ minWidth: 160 }}
          variant="contained"
          disabled={addToServiceDisable}
          color="primary"
          onClick={handleAddToService}
        >Add to Service</Button>
      </Box>
      <List sx={{ width: '100%', bgcolor: 'background.paper' }}>
        {parts.map((part) => (
          <ListItem
            key={part.id}
            disableGutters
            sx={{ pl: '14px' }}
            secondaryAction={
              <DeleteIcon onClick={() => deletePartHandler(part.id)} />
            }
          >
            <ListItemText primary={part.name} key={part.id} />
          </ListItem>
        ))}
      </List>
    </>);
};

export default PartList;