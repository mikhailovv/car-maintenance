import React from 'react';
import { useParams } from 'react-router-dom';
import CarDetails from '../../components/CarView/CarView';
import CarServiceList from '../../components/CarServiceList/CarServiceList';
import { Container } from '@mui/material';
import CarAvailablePartList from '../../components/CarAvailablePartList/CarAvailablePartList';

const CarDetailsPage = () => {
  const { id } = useParams();

  return (
    <Container maxWidth="sm">
      <CarDetails carId={id} />
      <CarServiceList carId={id} />
      <CarAvailablePartList carId={id} />
    </Container>
  );
};

export default CarDetailsPage;