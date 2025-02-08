import React, { useEffect, useState } from 'react';
import ServiceForm from '../../components/ServiceForm/ServiceForm';
import { useParams } from 'react-router-dom';

const EditServicePage = () => {
  const { id } = useParams(); // Get service ID from the route
  const [service, setService] = useState(null);

  useEffect(() => {
    const fetchService = async () => {
      const response = await fetch(`http://localhost:8000/api/services/${id}`);
      const data = await response.json();
      setService(data);
    };

    fetchService();
  }, [id]);

  const handleSave = async (updatedService) => {
    const response = await fetch(`http://localhost:8000/api/services/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(updatedService),
    });

    if (!response.ok) {
      throw new Error('Failed to update service');
    }

    alert('Service updated successfully');
  };

  if (!service) {
    return <p>Loading...</p>;
  }

  return <ServiceForm service={service} onSave={handleSave} />;
};

export default EditServicePage;
