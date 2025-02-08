import React from 'react';
import ServiceForm from '../../components/ServiceForm/ServiceForm';
import api from '../../utils/api';
import { useNavigate, useParams } from 'react-router-dom';

const AddServicePage = () => {
  const navigate = useNavigate();
  const { id } = useParams();
  const handleSave = async (newService) => {
    console.log('new service: ', newService);
    api.post('/api/services', { body: JSON.stringify(newService) })
      .then(() => {
        navigate(`/cars/${id}`);
      })
      .catch(() => {
        alert('Failed to add service');
      });
  };

  return <ServiceForm onSave={handleSave} />;
};

export default AddServicePage;